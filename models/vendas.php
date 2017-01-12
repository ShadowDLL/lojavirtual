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
        
        $directPaymentRequest = new PagSeguroDirectPaymentRequest();
        $directPaymentRequest->setPaymentMode('DEFAULT');
        $directPaymentRequest->setPaymentMethod($params['pg_form']);
        $directPaymentRequest->setReference($id_venda);
        $directPaymentRequest->setCurrency('BRL');
        $directPaymentRequest->addParameter("notificationURL", "http://lojavirtual.orlnet.xyz/carrinho/notificacao");
        
        foreach ($produtos as $prod){
            $directPaymentRequest->addItem($prod['id'], $prod['nome'], 1, $prod['preco']);
        }
        
        $directPaymentRequest->setSender(
            $parms['nome'],
            $parms['email'],
            $parms['ddd'],
            $parms['telefone'],
            'CPF',
            $parms['c_cpf']
        );
        
        $directPaymentRequest->setSenderHash($params['shash']);
        
        
        
        
        
        
        
        
        
        
        
        
        
    }
    
    
    
    
    
    
    
    
    
    
    
}

