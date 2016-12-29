<?php
class pedidosController extends controller{
    public function __construct(){
        parent::__construct();
    }
    public function index(){
        $dados = array();
        if(isset($_SESSION['cliente']) && !empty($_SESSION['cliente'])) {
            $vendas = new vendas();
            $dados['pedidos'] = $vendas->getPedidosDoUsuario($_SESSION['cliente']);
            $this->loadTemplate('pedidos', $dados);  
        }
        else{
            header("Location: /login");
        }
           
    }
}

