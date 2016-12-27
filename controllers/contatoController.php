<?php
class contatoController extends controller{
    public function __construct() {
        parent::__construct();
    }
    public function index(){
        $dados = array();
        if(isset($_POST['nome']) && !empty($_POST['nome']) && isset($_POST['email']) && !empty($_POST['email']) && isset($_POST['msg']) && !empty($_POST['msg']))
        {
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $msg = addslashes($_POST['msg']);
            $para = "suporte@orlnet.xyz";
            $assunto = "Contato pela loja virtual em ".date('d,m,Y');
            $corpo = "Nome: ".$nome." - E-mail: ".$email." \r\n \r\n".$msg;
            $cabecalho = "From: $email"."\r\n"."Replay-To: ".$email."\r\n"."X-Mailer: PHP/".phpversion();
            mail($para, $assunto, $corpo, $cabecalho);

            $dados['msg'] = "E-mail enviado com sucesso!";     
        }    
        
        $this->loadTemplate("contato", $dados);
    }
}

