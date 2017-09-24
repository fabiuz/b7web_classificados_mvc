<div class="container">
    <h1>Meus Anúncios - Adicionar Anúncio</h1>
    <?php if(isset($msg_anuncio_adicionado)): ?>
        <div class="alert alert-success">
            <?php echo $msg_anuncio_adicionado ?>   
        </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data">

        <div class="form-group">
            <label for="categoria">Categorias:</label>
            <select name="categoria" id="categoria" class="form-control">
<?php  foreach ($cats as $cat): ?>
        <option value="<?php echo $cat['id'];?>">
        <?php echo utf8_encode($cat['nome']);?></option>
<?php endforeach; ?>
<option></option>
            </select>
       </div>

        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="tituto" class="form-control" />
        </div>

        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="text" name="valor" id="valor" class="form-control" />
        </div>

        <div class="form-group">
            <label for="descricao">Descricao:</label>
            <textarea class="form-control" name="descricao"></textarea>
        </div>

        <div class="form-group">
            <label for="estado">Estado de conservação:</label>
            <select name="estado" id="estado" class="form-control">
                <option value="0">Ruim</option>
                <option value="1">Bom</option>
                <option value="2">Ótimo</option>
            </select>
        </div>
        <input type="submit" value="Adicionar" class="btn btn-default" />

    </form>
</div>
