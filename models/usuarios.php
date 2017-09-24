<?php
class Usuarios extends model
{

    public function getTotalUsuarios()
    {        
        $sql = $this->db->query("Select count(*) as c from usuarios");
        $row = $sql->fetch();
        
        return $row['c'];
    }


    public function cadastrar($nome, $email, $senha, $telefone)
    {
        $sql = $this->db->prepare("Select id from usuarios where email = :email");
        $sql->bindValue(':email', $email);
        $sql->execute();

        if ($sql->rowCount() == 0) {
            $sql = $this->db->prepare("Insert into usuarios set nome = :nome, email = :email, senha = :senha, telefone = :telefone");
            $sql->bindValue(':nome', $nome);
            $sql->bindValue(':email', $email);
            $sql->bindValue(':senha', md5($senha));
            $sql->bindValue(':telefone', $telefone);
            $sql->execute();

            return true;
        } else {
            return false;
        }
    }

    public function login($email, $senha)
    {
        $sql = $this->db->prepare("Select id, nome from usuarios where email = :email and senha = :senha");
        $sql->bindValue(":email", $email);
        $sql->bindValue(":senha", md5($senha));
        $sql->execute();

        if ($sql->rowCount()>0) {
            $dado = $sql->fetch();
            $_SESSION['cLogin'] = $dado['id'];
            $_SESSION['usuario'] = $dado['nome'];
            return true;
        } else {
            return false;
        }
    }
}
