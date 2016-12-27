<?php

class homeController extends controller
{
    public function __construct() {
        parent::__construct();
    }
    
    public function index()
    {
        $dados = array();    
        $p = new produtos();
        $dados['produtos'] = $p->listar(8);      
        $this->loadTemplate('home', $dados);
    }
}

