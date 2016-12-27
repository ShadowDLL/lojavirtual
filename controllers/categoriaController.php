<?php
class categoriaController extends controller{
    public function __construct() {
        parent::__construct();
    }
    
    public function ver($id){
        if (!empty($id)) {
            $dados = array(
                'categoria' => '',
                'produtos' => array()
            );
            $produto = new produtos();
            $dados['produtos'] = $produto->listar_categoria($id);
            
            $cat = new categorias();
            $dados['categoria'] = $cat->getNome($id);
        
            $this->loadTemplate("categoria", $dados);
        }
        else{
            header('Location: /naoencontrado');
        }
    }
}

