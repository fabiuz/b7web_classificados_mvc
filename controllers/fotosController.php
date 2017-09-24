<?php
class fotosController extends controller{

    public function index(){

    }

    public function excluir($id_foto){

        if(empty($_SESSION['cLogin'])){
            header("Location: login.php");
            exit;
        }
        
        $a = new Anuncios();

        if(isset($id_foto) && !empty($id_foto)){
            $id_anuncio = $a->excluirFoto($id_foto);
        }
        
        if(isset($id_anuncio)){            
            header("Location: ". BASE_URL."anuncios/editar/".$id_anuncio);
        }else{
            //header("Location: meus-anuncios.php");
            header("Location: ". BASE_URL."anuncios");
        }
        
    }
}