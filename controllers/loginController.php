<?php
class loginController extends controller{

    public function index(){
        $dados = array();
        $u = new Usuarios();
        
        if(isset($_POST['email']) && !empty($_POST['email'])){
            $email = addslashes($_POST['email']);
            $senha = $_POST['senha'];
        
            // Verifica se a email e senha estão corretos, se sim redireciona pra 
            // a página principal.
            if($u->login($email, $senha)){
                header("Location: ".BASE_URL);
                exit();        
            }else{
                $dados['erro'] = 'Usuário/senha inválidos';
            }
        }

        // Carrega a view.
        $this->loadTemplate("login", $dados);
    }

    public function sair(){
        unset($_SESSION['cLogin']);
        unset($_SESSION['usuario']);

        header("Location: ". BASE_URL."login");
    }
}