<?php
class carrinhoController extends controller{
    public function __construct() {
        parent::__construct();
    }
    
    public function index(){
        $dados = array();   
        if (isset($_SESSION['carrinho'])) {
            $produtos = $_SESSION['carrinho'];
            if (count($produtos) == 0) {
                header("Location: /");
            }
            else{
                $p = new produtos();
                $dados['carrinho'] = $p->getProdutos($produtos);
            }
        }
        $this->loadTemplate('carrinho', $dados);
    }
    
    public function add($id){
        if (!empty($id)) {
            if (!isset($_SESSION['carrinho'])) {
                $_SESSION['carrinho'] = array();
            }
            $_SESSION['carrinho'][] = $id;
            header("Location: /carrinho");
        }
    }
    public function del($id){
        if (!empty($id)) {
            foreach ($_SESSION['carrinho'] as $key => $value) {
                if ($value == $id) {
                    unset($_SESSION['carrinho'][$key]);
                }
            }
            header("Location: /carrinho");
        }
    }
    public function finalizar(){
        $dados = array(
            'total' => 0,
            'sessionId' => '',
            'erro' => '',
            'produtos' => array()
        );
        require 'libraries/PagSeguroLibrary/PagSeguroLibrary.php';
        
        $produtos = array();
        if (isset($_SESSION['carrinho'])) {
            $prods= $_SESSION['carrinho'];
        }
        
        if (count($prods) > 0) {
            $produtos = new produtos();
            $dados['produtos'] = $produtos->getProdutos($prods);
            foreach($dados['produtos'] as $prod){
                $dados['total'] += $prod['preco'];
            }
        }
        
        if (isset($_POST['pg_form']) && !empty($_POST['pg_form'])) {
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);
            $sessionId = addslashes($_POST['sessionId']);
            
            if (!empty($email) && !empty($senha)) {
                $uid = 0;
                $u = new usuarios();
                if ($u->isExists($email)) {
                    if ($u->isExists($email, $senha)) {
                        $uid = $u->getId($email);
                    }
                    else{
                        $dados['erro'] = "Usuário e/ou senha inválidos!";
                    }
                }
                else{
                    $uid = $u->addUser($nome, $email, $senha);
                }
            }
            else{
                $dados['erro'] = "Preencha todos os campos";
            }
            
            if ($uid > 0) {
                $vendas = new vendas();
                $venda = $vendas->setVendaCkTransparente($_POST, $uid, $sessionId, $dados['produtos'], $dados['total']);
                //Pegar o tipo de pagamento retornado que será em forma de númeoro   
                $tipo = $venda->getPaymentMethod()->getType()->getValue();
                if ($tipo == 4) {//Boleto = 4
                   $link = $venda->getPaymentLink();
                   $vendas->setLinkBySession($link, $sessionId);
                   header("Location: ".$link);
                }
                else{
                    header("Location: /carrinho/obrigado");
                }
                
            }
        }
        else{
            try{
                $credentials = PagSeguroConfig::getAccountCredentials();
                $dados['sessionId'] = PagSeguroSessionService::getSession($credentials);
            } catch (PagSeguroServiceException $e) {
                die($e->getMessage());
            }
        }
        
        
        
        $this->loadTemplate("finalizar_compra", $dados);     
    }
       
    public function notificacao(){
        //Pagseguro vai enviar o tipo da notificação e o código da notificação via POST
        $vendas = new vendas();
        $vendas->verificarVendas();         
    }
    public function obrigado(){
        $this->loadTemplate('obrigado');
    }
    
        /*public function finalizar(){
        $dados = array(
            'pagamentos' => array(),
            'total' => '0',
            'aviso' => ''
        );  
        $p = new pagamentos();
        $dados['pagamentos'] = $p->getPagamentos();
        unset($p);    
        $produtos = array();
        if (isset($_SESSION['carrinho'])) {
            $produtos = $_SESSION['carrinho'];
        }
        if (count($produtos) > 0 ) {
            $p = new produtos();
            $dados['produtos'] = $p->getProdutos($produtos);
            unset($p);
            foreach($dados['produtos'] as $prod){
                $dados['total'] += $prod['preco'];
            }
        }
        if (isset($_POST['nome']) && !empty($_POST['nome'])) {
            $nome = addslashes($_POST['nome']);
            $email = (isset($_POST['email']))?addslashes($_POST['email']):'';
            $senha = (isset($_POST['senha']))?md5($_POST['senha']):'';
            $endereco = (isset($_POST['endereco']))?addslashes($_POST['endereco']):'';
            $pg = (isset($_POST['pg']))?addslashes($_POST['pg']):'';  
            if (!empty($email) && !empty($senha) && !empty($endereco) && !empty($pg)) {
                $uid = 0;
                $u = new usuarios();
                if ($u->isExists($email)) {
                    if ($u->isExists($email, $senha)) {
                        $uid = $u->getId($email);
                    }
                    else{
                        $dados['aviso'] = "Usuário e/ou senha inválidos!";
                    }
                }
                else{
                    $uid = $u->addUser($nome, $email, $senha);
                }
                unset($u);      
                if ($uid > 0) {                       
                    $v = new vendas();
                    $link = $v->setVenda($uid, $endereco, $dados['total'], $pg, $dados['produtos']);
                    unset($v);
                    header("Location: ".$link);                
                }         
            }
            else{
                $dados['aviso'] = "Preencha todos os campos!";
            }       
        }    
        $this->loadTemplate('finalizar_compra', $dados);
    }*/
    
}

