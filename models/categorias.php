<?php
class categorias extends model{
    public function __construct() {
        parent::__construct();
    }
    
    public function getNome($id){
        $sql = "SELECT titulo FROM categorias WHERE id = '$id'";
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $titulo = $sql['titulo'];
        }
        else{
            header('Location: /naoencontrado');
        }
        return $titulo;
    }
}

