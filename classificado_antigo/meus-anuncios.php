<?php require 'pages/header.php'; ?>
<?php
if (empty($_SESSION['cLogin'])) {
    ?>
    <script type="text/javascript">window.location.href = "login.php";</script>
    <?php
    exit;
}
?>
<div class="container">
    <h2>Meus Anúncios</h2>

    <a href="add-anuncio.php" class="btn btn-default">Adicionar Anúncio</a>

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
        require 'classes/anuncios.class.php';
        $a = new Anuncios();
        $anuncios = $a->getMeusAnuncios();


        foreach ($anuncios as $anuncio):
            ?>
            <tr>
                <td>
                    <?php if (!empty($anuncio['url'])): ?>
                    <img src="assets/images/anuncios/<?php echo $anuncio['url']; ?>" border="0" height="50px"/></td>
                <?php else : ?>
                    <img src="assets/images/default.png" height="50px"/>
                <?php endif;
                ?>
                <td><?php echo $anuncio['titulo']; ?></td>
                <td>R$ <?php echo number_format($anuncio['valor'], 2); ?></td>
                <td>
                    <a href="editar-anuncio.php?id=<?php echo $anuncio['id']; ?>" class="btn btn-default">Editar</a>
                    <a href="excluir-anuncio.php?id=<?php echo $anuncio['id']; ?>" class="btn btn-danger">Excluir</a>
                </td>
            </tr>

        <?php endforeach; ?>
    </table>
</div>
<?php require 'pages/footer.php'; ?>
