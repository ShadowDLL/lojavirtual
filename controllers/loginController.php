<?php
class loginController extends controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $dados = array(
            'aviso' => ''
        );
        
        if (isset($_POST['email']) && !empty($_POST['email'])) {
            $email = addslashes($_POST['email']);
            $senha = md5($_POST['senha']);
            $u = new usuarios();
            if ($u->isExists($email, $senha)) {
                $_SESSION['cliente'] = $u->getId($email);
                header("Location: /pedidos");
            }
            else{
                $dados['aviso'] = "Usuário e/ou senha inválidos!";
            }
        }
        
        $this->loadTemplate('login', $dados);
    }
    public function logout(){
        unset($_SESSION['cliente']);
        header("Location: /login");
    }
}

