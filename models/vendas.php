<?php
class vendas extends model{
    public function __construct(){
        parent::__construct();
    }
    
    public function getPedido($id, $id_usuario){
        $array = array();
        if (!empty($id)) {
            $sql = "SELECT *, (SELECT pagamentos.nome FROM pagamentos WHERE pagamentos.id = vendas.forma_pg) AS forma_pg FROM vendas WHERE id = '$id' AND id_usuario = '$id_usuario'";
            $sql = $this->db->query($sql);
            if ($sql->rowCount() > 0) {
                $array = $sql->fetch();
                $array['produtos'] = $this->getProdutosDoPedido($id);
            }
        }
        return $array;
    }
    
    public function getProdutosDoPedido($id){
        $array = array();
        if (!empty($id)) {
           $sql = "SELECT v.quantidade, v.id_produto,p.nome,p.imagem,p.preco FROM vendas_produto AS v LEFT JOIN produtos AS p ON v.id_produto = p.id WHERE v.id_venda = '$id'"; 
           $sql = $this->db->query($sql);
           if ($sql->rowCount() > 0) {
               $array = $sql->fetchAll();
           }
        }
        return $array;
    }
    public function getPedidosDoUsuario($id_usuario){
        $array = array();
        if (!empty($id_usuario)) {
            $sql = "SELECT *, (SELECT pagamentos.nome FROM pagamentos WHERE pagamentos.id = vendas.forma_pg) AS forma_pg FROM vendas WHERE id_usuario = '$id_usuario'";
            $sql = $this->db->query($sql);
            if ($sql->rowCount() > 0) {
                $array = $sql->fetchAll();
            }
        }
        return $array;
    }
    public function setVenda($uid, $endereco, $subtotal, $pg, $prods){
        /*
        1 => Aguardando aprovação
        2 => Aprovado
        3 => Cancelado    
        */
        
        $status = '1';
        $link = '';
        
        $sql = "INSERT INTO vendas SET id_usuario = '$uid', endereco = '$endereco', valor = '$subtotal', forma_pg = '$pg', status_pg = '$status', pg_link = '$link'";
        $this->db->query($sql);
        $id_venda = $this->db->lastInsertId();
        
        if ($pg == '1') {
           $status = '2';
           $link = "/carrinho/obrigado";
           $this->db->query("UPDATE vendas SET status = '$status' WHERE id = '".$id_venda."'");
        }
        elseif($pg == '2'){
            //Pagseguro 
            //Requisita a biblioteca do pagseguro
            require "libraries/PagSeguroLibrary/PagSeguroLibrary.php";
            //Instancia a classe principal do pagseguro
            $paymentRequest = new PagSeguroPaymentRequest();
            //Adiciona os itens no carrinho do pagseguro
            foreach($prods as $prod){
                $paymentRequest->addItem($prod['id'], $prod['nome'], 1, $prod['preco']);
            }
            //Configura a moeda
            $paymentRequest->setCurrency('BRL');
            //Configura a referencia da compra com o id
            $paymentRequest->setReference($id_venda);
            //Configura o redirecionamento para quando o usuário realizar o pagamento
            $paymentRequest->setRedirectURL("http://lojavirtual.orlnet.xyz/carrinho/obrigado");
            //Configura a notiificação para quando alterar o status do pagamento no pagseguro
            $paymentRequest->addParameter("notificationURL", "http://lojavirtual.orlnet.xyz/carrinho/notificacao");
            
            try {
                //Pegar as credenciais do pagseguro referenciando a conta
                $cred = PagSeguroConfig::getAccountCredentials();
                //Gerar o link do pagseguro
                $link = $paymentRequest->register($cred);
            } catch (PagSeguroServiceException $e) {
                echo $e->getMessage();
            }
        }     
        foreach ($prods as $prod){
        $sql = "INSERT INTO vendas_produto SET id_venda = '$id_venda', id_produto = '".($prod['id'])."', quantidade = '1'";
        $this->db->query($sql);
        }
        unset($_SESSION['carrinho']);
        return $link;
    }
    public function verificarVendas(){
        require "libraries/PagSeguroLibrary/PagSeguroLibrary.php";
        $code = '';
        $type = '';
        if (isset($_POST['notificationCode']) && isset($_POST['notificationType'])) {
            $code = trim($_POST['notificationCode']);
            $type = trim($_POST['notificationType']);
            $notificationType =  new PagSeguroNotificationType($type);
            $strType = $notificationType->getTypeFromValue();
            $credentials = PagSeguroConfig::getAccountCredentials();
            try {
                $transaction = PagSeguroNotificationService::checkTransaction($credentials, $code);
                $ref = $transaction->getReference();
                $status = $transaction->getStatus()->getValue();
                $novoStatus = 0;
                switch($status){
                    case '1'://Aguardando Pagamento pagseguro
                    case '2'://Em análise pagseguro
                        $novoStatus = '1';
                        break;
                    case '3'://Aprovado
                    case '4'://Disponível
                        $novoStatus = '2';
                        break;
                    case '6': //Devolvida
                    case '7': //Cancelada
                        $novoStatus = '3';
                        break;      
                }
                $this->db->query("UPDATE vendas SET status_pg = '$novoStatus' WHERE = id = '$ref'");
                
            } catch (PagSeguroServiceException $e) {
                echo "FALHA: ".$e->getMessage();
            }
        }
    }
    
    public function setVendaCkTransparente($params, $uid, $sessionId, $produtos, $subtotal){
        require 'libraries/PagSeguroLibrary/PagSeguroLibrary.php';
        /*
        1 => Aguardando aprovação
        2 => Aprovado
        3 => Cancelado    
        */
        
        $status = '1';
        $link = '';
        $endereco = implode(', ', $params['endereco']);
        
        $sql = "INSERT INTO vendas SET id_usuario = '$uid', endereco = '$endereco', valor = '$subtotal', forma_pg = '6', status_pg = '$status', pg_link = '$sessionId'";
        $this->db->query($sql);
        $id_venda = $this->db->lastInsertId();
        
        foreach ($produtos as $prod){
        $sql = "INSERT INTO vendas_produto SET id_venda = '$id_venda', id_produto = '".($prod['id'])."', quantidade = '1'";
        $this->db->query($sql);
        }
        unset($_SESSION['carrinho']);
        //Configurações iniciais do pagseguro
        $directPaymentRequest = new PagSeguroDirectPaymentRequest();
        //Único que existe no momento
        $directPaymentRequest->setPaymentMode('DEFAULT');
        //Forma de pagamento
        $directPaymentRequest->setPaymentMethod($params['pg_form']);
        //Referencia da compra
        $directPaymentRequest->setReference($id_venda);
        //Moeda
        $directPaymentRequest->setCurrency('BRL');
        //Parametro de notificação para quando atualizar o status no pagseguro
        $directPaymentRequest->addParameter("notificationURL", "http://lojavirtual.orlnet.xyz/carrinho/notificacao");
        //Preenchendo os produtos
        foreach ($produtos as $prod){
            $directPaymentRequest->addItem($prod['id'], $prod['nome'], 1, $prod['preco']);
        }
        //Dados do usuário
        $directPaymentRequest->setSender(
            $params['nome'],
            $params['email'],
            $params['ddd'],
            $params['telefone'],
            'CPF',
            $params['c_cpf']
        );
        //Setando o hash
        $directPaymentRequest->setSenderHash($params['shash']);
        //Forma de envio 1 => SEDEX, 2 => PAC, 3 => Não informado a combinar
        $directPaymentRequest->setShippingAddress(3);
        $directPaymentRequest->setShippingCost(0);
        //Dados de Frete requerido pelo pagseguro
        $directPaymentRequest->setShippingAddress(
                $params['endereco']['cep'],
                $params['endereco']['logradouro'],
                $params['endereco']['numero'],
                $params['endereco']['complemento'],
                $params['endereco']['bairro'],
                $params['endereco']['cidade'],
                $params['endereco']['estado'],
                'BRA'
        );
        //Dados de Endereço de pagamento
        $billingAddress = new PagSeguroBilling(
                array(
                    'postalCode' => $params['endereco']['cep'],
                    'street' => $params['endereco']['logradouro'],
                    'number' => $params['endereco']['numero'],
                    'complement' => $params['endereco']['complemento'],
                    'district' => $params['endereco']['bairro'],
                    'city' => $params['endereco']['cidade'],
                    'state' => strtoupper($params['endereco']['estado']),
                    'country' => 'BRA' 
                )
        );
        
        if ($params['pg_form'] == 'CREDIT_CARD') {
            $parc = explode(';', $params['parc']);
            //Classe de parcelamento do pagseguro
            $installments = new PagSeguroInstallment(
                    '',//Solicita a bandeira do carão mas não é necessário enviar
                    $parc[0],//Numero de parcelas
                    $parc[1],//Valor da parcela
                    '',//Interestfree que não é necessário
                    ''//Dígito cvv que tambem não é necessário ma tem que preencher
            );
            //Classe para gerar as informações do cartão
            $creditCardData = new PagSeguroCreditCardCheckout(
                    array(
                        'token' => $params['ctoken'], //Token gerado pelo pagseguro
                        'installment' => $installments, //Informações de parcelamento do cartão
                        'billing' => $billingAddress,  //Endereço de Pagamento
                        'holder' => new PagSeguroCreditCardHolder(
                                    array(
                                        'name' => $params['c_titular'], //Nome do titular
                                        'birthDate' => date('01/10/1979'), //Não é necessário pode inserir qualquer data
                                        'areaCode' => $params['ddd'],  //DDD do telefone
                                        'number' => $params['telefone'], //Número de telefone
                                        'documents' => array(
                                            'type' => 'CPF',
                                            'value' => $params['c_cpf']
                                        )
                                    )
                                )//Dados do titular
                    )
            );
            //Registro do pagamento
            $directPaymentRequest->setCreditCard($creditCardData);
        }
        //Registrar o pagamento requerido try catch pelo pagseguro
        try {
            $credentials = PagSeguroConfig::getAccountCredentials();
            $resposta = $directPaymentRequest->register($credentials);
            return $resposta;
        } catch (PagSeguroServiceException $e) {
            die($e->getMessage());
        }      
    }
    
    public function setLinkBySession($link, $sessionId){
        $this->db->query("UPDATE venda SET pg_link = '$link' WHERE pg_link = '$sessionId'");
    }
    
    
    
    
    
    
    
    
    
}

