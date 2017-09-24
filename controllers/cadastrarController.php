<?php 
class cadastrarController extends controller {

    public function index(){
        $dados = array();
        $u = new Usuarios();

        if($_POST){
            
            $nome = addslashes($_POST['nome']);
            $email = addslashes($_POST['email']);
            $senha = $_POST['senha'];
            $telefone = addslashes($_POST['telefone']);

            $bNome = isset($nome) && !empty($nome);
            $bEmail = !empty($email);
            $bSenha = !empty($senha);

            if($bNome && $bEmail && $bSenha){
                // Vamos tentar cadastrar o usuário, se usuário for cadastrado
                // iremos redirecionar pra página de login.
                // A função abaixo retorna true se foi cadastrado com sucesso, falso, caso contrário.
                if($u->cadastrar($nome, $email, $senha, $telefone)){
                    header("Location: ". BASE_URL. "login");
                    exit();
                }else{
                    $dados['erro'] = 'Usuário já existe.';
                }
            }
        }

        $this->loadTemplate('cadastro', $dados);
    }
}
?>