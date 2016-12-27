<?php
class produtos extends model{
    public function __construct() {
        parent::__construct();
    }
    public function getProduto($id){
        $array = array();
        if (!empty($id)) {
            $id = addslashes($id);
            $sql = "SELECT * FROM produtos WHERE id = '$id'";
            $sql = $this->db->query($sql);
            if ($sql->rowCount() > 0) {
                $array = $sql->fetch();
            }
            else{
                header('Location: /naoencontrado');
            }
        }
        return $array;
    }
    
    public function listar($qt = 0){
        $produtos = array();
        $sql = "SELECT * FROM produtos ORDER BY RAND()";
        if ($qt > 0) {
            $sql .= " LIMIT $qt";
        }
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $produtos = $sql->fetchAll();
        }
        else{
            header('Location: /naoencontrado');
        }
        return $produtos;
    }
    
    public function listar_categoria($cat){
        $produtos = array();
        $sql = "SELECT * FROM produtos WHERE id_categoria = '$cat' ORDER BY RAND()";
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $produtos['produto'] = $sql->fetchAll();
        }
        return $produtos;
    }
    public function getProdutos($produtos = array()){
        $array = array();
        if (is_array($produtos) && count($produtos) > 0 ) {  
            $sql = "SELECT * FROM produtos WHERE id IN(". implode(',', $produtos).")";
            $sql = $this->db->query($sql);
            if ($sql->rowCount() > 0) {
                $array = $sql->fetchAll();
            }
        }
        
        return $array;
    }
}

