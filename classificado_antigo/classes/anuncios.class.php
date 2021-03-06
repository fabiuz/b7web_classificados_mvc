<?php

class Anuncios
{
    

    public function getTotalAnuncios($filtros)
    {
        global $pdo;

        $filtrostring = array('1=1');
        if (!empty($filtros['categoria'])) {
            $filtrostring[] = 'anuncios.id_categoria = :id_categoria';
        }
        if (!empty($filtros['preco'])) {
            $filtrostring[] = 'anuncios.valor between :preco1 and :preco2';
        }
        if (!empty($filtros['estado'])) {
            $filtrostring[] = 'anuncios.estado = :estado';
        }

        $sql = $pdo->prepare("Select count(*) as c from anuncios where " .
            implode(' and ', $filtrostring));

        if (!empty($filtros['categoria'])) {
            $sql->bindValue(':id_categoria', $filtros['categoria']);
        }
        if (!empty($filtros['preco'])) {
            $preco = explode('-', $filtros['preco']);
            $sql->bindValue(':preco1', $preco[0]);
            $sql->bindValue(':preco2', $preco[1]);
        }
        if (!empty($filtros['estado'])) {
            $sql->bindValue(':estado', $filtros['estado']);
        }

        $row = $sql->execute();
        $row = $sql->fetch();

        return $row['c'];
    }

    public function getUltimosAnuncios($page, $perPage, $filtros)
    {
        global $pdo;

        $offset = ($page - 1) * $perPage;


        $array = array();
        

        $filtrostring = array('1=1');
        if (!empty($filtros['categoria'])) {
            $filtrostring[] = 'anuncios.id_categoria = :id_categoria';
        }
        if (!empty($filtros['preco'])) {
            $filtrostring[] = 'anuncios.valor between :preco1 and :preco2';
        }
        if (!empty($filtros['estado'])) {
            $filtrostring[] = 'anuncios.estado = :estado';
        }

        $sql = $pdo->prepare(
            "Select *, (select anuncios_imagens.url 
                        from anuncios_imagens where
            anuncios_imagens.id_anuncio = anuncios.id limit 1)
             as url,
             (select categorias.nome from categorias
             where categorias.id = anuncios.id_categoria) as categoria              
              from anuncios
               where " . implode(' and ', $filtrostring) . "               
               order by id desc 
              limit $offset, $perPage");

        if (!empty($filtros['categoria'])) {
            $sql->bindValue(':id_categoria', $filtros['categoria']);
        }
        if (!empty($filtros['preco'])) {
            $preco = explode('-', $filtros['preco']);
            $sql->bindValue(':preco1', $preco[0]);
            $sql->bindValue(':preco2', $preco[1]);
        }
        if (!empty($filtros['estado'])) {
            $sql->bindValue(':estado', $filtros['estado']);
        }


        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function getMeusAnuncios()
    {
        global $pdo;

        $array = array();
        $sql = $pdo->prepare(
            "Select *, (select anuncios_imagens.url " .
            "from anuncios_imagens where " .
            "anuncios_imagens.id_anuncio = anuncios.id limit 1)" .
            " as url from anuncios where id_usuario = :id_usuario");
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetchAll();
        }

        return $array;
    }

    public function addAnuncio($titulo, $categoria, $valor, $descricao, $estado)
    {
        global $pdo;

        $sql = $pdo->prepare(
            "insert into anuncios set titulo = :titulo," .
            "id_categoria = :id_categoria, " .
            "id_usuario = :id_usuario," .
            "descricao = :descricao," .
            "valor = :valor," .
            "estado = :estado");

        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":id_categoria", $categoria);
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":estado", $estado);
        $sql->execute();

    }

    public function excluirAnuncio($id)
    {
        global $pdo;

        $sql = $pdo->prepare("Delete from anuncios_imagens where id_anuncio = :id_anuncio");
        $sql->bindValue(":id_anuncio", $id);
        $sql->execute();

        $sql = $pdo->prepare("Delete from anuncios where id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

    }

    public function getAnuncio($id)
    {
        $array = array();
        global $pdo;

        $sql = $pdo->prepare("Select *,
          (Select categorias.nome from categorias where categorias.id = anuncios.id_categoria) as categoria,
          (Select usuarios.telefone from usuarios where usuarios.id = anuncios.id_usuario) as telefone
          from anuncios where id=:id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $array = $sql->fetch();
            $array['fotos'] = array();

            $sql = $pdo->prepare("Select id, url from anuncios_imagens where id_anuncio = :id_anuncio");
            $sql->bindValue(":id_anuncio", $id);
            $sql->execute();

            if ($sql->rowCount() > 0) {
                $array['fotos'] = $sql->fetchAll();
            }
        }

        return $array;
    }

    public function editAnuncio($titulo, $categoria, $valor, $descricao, $estado, $fotos, $id)
    {
        global $pdo;

        $sql = $pdo->prepare(
            "Update anuncios set titulo = :titulo," .
            "id_categoria = :id_categoria, " .
            "id_usuario = :id_usuario," .
            "descricao = :descricao," .
            "valor = :valor," .
            "estado = :estado" .
            " where id = :id");

        $sql->bindValue(":titulo", $titulo);
        $sql->bindValue(":id_categoria", $categoria);
        $sql->bindValue(":id_usuario", $_SESSION['cLogin']);
        $sql->bindValue(":descricao", $descricao);
        $sql->bindValue(":valor", $valor);
        $sql->bindValue(":estado", $estado);
        $sql->bindValue(":id", $id);
        $sql->execute();

        if (count($fotos) > 0) {
            for ($q = 0; $q < count($fotos['tmp_name']); $q++) {
                $tipo = $fotos['type'][$q];

                if (in_array($tipo, array('image/jpeg', 'image/png'))) {
                    $tmpname = md5(time() . rand(0, 99999)) . '.jpg';
                    move_uploaded_file($fotos['tmp_name'][$q], 'assets/images/anuncios/' . $tmpname);

                    list($width_orig, $height_orig) = getimagesize('assets/images/anuncios/' . $tmpname);
                    $ratio = $width_orig / $height_orig;

                    $width = 500;
                    $height = 500;

                    if ($width / $height > $ratio) {
                        $width = $height_orig * $ratio;
                    } else {
                        $height = $width / $ratio;
                    }

                    $img = imagecreatetruecolor($width, $height);
                    if ($tipo == 'image/jpeg') {
                        $origi = imagecreatefromjpeg('assets/images/anuncios/' . $tmpname);
                    } elseif ($tipo == 'image/png') {
                        $origi = imagecreatefrompng('assets/images/anuncios/' . $tmpname);
                    }

                    imagecopyresampled($img, $origi, 0, 0, 0, 0, $width, $height, $width_orig, $height_orig);

                    imagejpeg($img, 'assets/images/anuncios/' . $tmpname, 80);

                    $sql = $pdo->prepare("Insert into anuncios_imagens set id_anuncio = :id_anuncio, url = :url");
                    $sql->bindValue(":id_anuncio", $id);
                    $sql->bindValue(":url", $tmpname);
                    $sql->execute();
                }
            }
        }
    }

    public function excluirFoto($id)
    {
        global $pdo;

        // Devemos pegar o id do anúncio e depois, verificar se há mais fotos pra
        // deletar.
        $sql = $pdo->prepare("Select id_anuncio from anuncios_imagens where id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        if ($sql->rowCount() > 0) {
            $row = $sql->fetch();
            $id_anuncio = $row['id_anuncio'];
        }

        $sql = $pdo->prepare("Delete from anuncios_imagens where id = :id");
        $sql->bindValue(":id", $id);
        $sql->execute();

        // Agora, verificar se há mais fotos pendentes
        if(isset($id_anuncio) && !empty($id_anuncio)){ 
            $sql = $pdo->prepare("Select id_anuncio from anuncios_imagens where id_anuncio = :id_anuncio");
            $sql->bindValue(":id_anuncio", $id_anuncio);
            $sql->execute();
        
            unset($id_anuncio);

            if ($sql->rowCount() > 0) {
                $row = $sql->fetch();
                $id_anuncio = $row['id_anuncio'];
            }
        }

        // Vai retorna null, se não há registros.
        return $id_anuncio;
    }
}