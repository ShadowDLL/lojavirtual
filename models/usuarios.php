<?php
class usuarios extends model{
    public function __construct() {
        parent::__construct();
    }
    public function isExists($email, $senha = ''){
        $sql = "SELECT * FROM usuarios WHERE email = '$email' ";
        if (!empty($senha)) {
            $sql .+ "AND senha = '$senha'";
        }
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            return true;
        }
        else{
            return false;
        }
    }
    public function getId($email){
        $id = 0;
        $sql = "SELECT id FROM usuarios WHERE email = '$email'";
        $sql = $this->db->query($sql);
        if ($sql->rowCount() > 0) {
            $sql = $sql->fetch();
            $id = $sql['id'];
        }
        return $id;
    }
    public function addUser($nome, $email, $senha){
        $sql = "INSERT INTO usuarios SET nome = '$nome', email = '$email', senha = '$senha'";
        $this->db->query($sql);
        return $this->db->lastInsertId();
    }
}

