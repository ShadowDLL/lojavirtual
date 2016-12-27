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
            'pagamentos' => array(),
            'total' => '0'
        );  
        $p = new pagamentos();
        $dados['pagamentos'] = $p->getPagamentos();
        
        $produtos = array();
        if (isset($_SESSION['carrinho'])) {
            $produtos = $_SESSION['carrinho'];
        }
        if (count($produtos) > 0 ) {
            $p = new produtos();
            $dados['produtos'] = $p->getProdutos($produtos);
            foreach($dados['produtos'] as $prod){
                $dados['total'] += $prod['preco'];
            }
        }
        
        
        $this->loadTemplate('finalizar_compra', $dados);
    }
}

