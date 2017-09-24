<div class="container">
    <h2>Meus Anúncios</h2>

    <a href="<?php echo BASE_URL; ?>anuncios/add" class="btn btn-default">Adicionar Anúncio</a>

    <?php if(isset($id_deletado) && !empty($id_deletado)): ?>
        <p class="alert alert-success">Anúncio deletado com sucesso!!!</p>
    <?php endif; ?>


    <table class="table table-striped">
        <thead>
        <tr>
            <th>Foto</th>
            <th>Titulo</th>
            <th>Valor</th>
            <th>Ações</th>
        </tr>
        </thead>
        <?php
        // require 'classes/anuncios.class.php';
        //$a = new Anuncios();
        //$anuncios = $a->getMeusAnuncios();


        foreach ($anuncios as $anuncio):
            ?>
            <tr>
                <td>
                    <?php if (!empty($anuncio['url'])): ?>
                    <img src="<?php echo BASE_URL; ?>assets/images/anuncios/<?php echo $anuncio['url']; ?>" border="0" height="50px"/></td>
                <?php else : ?>
                    <img src="<?php echo BASE_URL; ?>assets/images/default.png" height="50px"/>
                <?php endif;
                ?>
                <td><?php echo $anuncio['titulo']; ?></td>
                <td>R$ <?php echo number_format($anuncio['valor'], 2); ?></td>
                <td>
                    <a href="<?php echo BASE_URL; ?>anuncios/editar/<?php echo $anuncio['id']; ?>" class="btn btn-default">Editar</a>
                    <a href="<?php echo BASE_URL; ?>anuncios/excluir/<?php echo $anuncio['id']; ?>" class="btn btn-danger">Excluir</a>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>
</div>