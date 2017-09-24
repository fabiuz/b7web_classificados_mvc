<?php
class anunciosController extends controller {

	public function index() {
		$dados = array();

		// Só iremos ir pra os anúncios, se houver algum
		// usuários autenticado.
		if (empty($_SESSION['cLogin'])) {
			header("Location: ".BASE_URL."login");
			exit;
		}

		$a                 = new Anuncios();
		$dados['anuncios'] = $a->getMeusAnuncios();
		$this->loadTemplate('anuncios', $dados);
	}

	public function add() {
		if (empty($_SESSION['cLogin'])) {
			header("Location: ".BASE_URL."login");
			exit;
		}

		$a = new Anuncios();

		if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {
			$titulo    = addslashes($_POST['titulo']);
			$categoria = addslashes($_POST['categoria']);
			$valor     = addslashes($_POST['valor']);
			$descricao = addslashes($_POST['descricao']);
			$estado    = addslashes($_POST['estado']);

			$a->addAnuncio($titulo, $categoria, $valor, $descricao, $estado);
			$dados['msg_anuncio_adicionado'] = 'Produto adicionado com sucesso!!!';
		}

		$c             = new Categorias();
		$dados['cats'] = $c->getLista();

		$this->loadTemplate('anuncios_add', $dados);
	}

	public function editar($id) {
		$dados = array(
		);

		// Verifica se há algum usuário logado.
		if (empty($_SESSION['cLogin'])) {
			header("Location: ".BASE_URL."login");

			exit;
		}

		$a = new Anuncios();

		if (isset($_POST['titulo']) && !empty($_POST['titulo'])) {

			$titulo    = addslashes($_POST['titulo']);
			$categoria = addslashes($_POST['categoria']);
			$valor     = addslashes($_POST['valor']);
			$descricao = addslashes($_POST['descricao']);
			$estado    = addslashes($_POST['estado']);

			if (isset($_FILES['fotos'])) {
				$fotos = $_FILES['fotos'];
			} else {
				$fotos = array();
			}

			$a->editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $id);

			header("Location: ".BASE_URL."anuncios/editar/". $id);
			exit();
		}

		if (isset($id) && !empty($id)) {
			$info = $a->getAnuncio($id);
		}
		$dados['info'] = $info;

		$c             = new Categorias();
		$dados['cats'] = $c->getLista();

		$this->loadTemplate('anuncios_edit', $dados);

	}

	public function excluir($id) {
		$dados = array();

		if (empty($_SESSION['cLogin'])) {
			header("Location: ".BASE_URL."login");
			exit;
		}

		$a = new Anuncios();
		
		if(isset($id) && !empty($id)){
			$a->excluirAnuncio($id);
			$dados['id_deletado'] = $id;
		}

		// Redireciona
		header("Location: ". BASE_URL. "anuncios");
	}
}