<div class="container">
    <h1>Meus Anúncios - Editar Anúncio</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="categoria">Categorias:</label>
            <select name="categoria" id="categoria" class="form-control">
<?php foreach ($cats as $cat):?>
		<option value="<?php echo $cat['id'];?>"

<?php echo ($info['id_categoria'] == $cat['id'])?'selected="selected"':'';?>>
<?php echo utf8_encode($cat['nome']);?>
</option>
<?php endforeach;?>
<option></option>
            </select>
       </div>
        <div class="form-group">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="tituto" class="form-control"
            value="<?php echo $info['titulo'];
?>" />
        </div>
        <div class="form-group">
            <label for="valor">Valor:</label>
            <input type="text" name="valor" id="valor" class="form-control"
            value="<?php echo $info['valor'];
?>"
            />
        </div>
        <div class="form-group">
            <label for="descricao">Descricao:</label>
            <textarea class="form-control" name="descricao"><?php echo $info['descricao'];?></textarea>
        </div>
        <div class="form-group">
            <label for="estado">Estado de conservação:</label>
            <select name="estado" id="estado" class="form-control">
                <option value="0"
<?php echo ($info['estado'] == '0')?'selected="selected"':'';
?>
>Ruim</option>
                <option value="1"
<?php echo ($info['estado'] == '1')?'selected="selected"':'';
?>>Bom</option>
                <option value="2"
<?php echo ($info['estado'] == '2')?'selected="selected"':'';
?>
>Ótimo</option>
            </select>
        </div>

        <div class="form-group">
            <label for="add_foto">Fotos do anúncio:</label>
            <input type="file" name="fotos[]" multiple/>
            <br/>
            <div class="panel panel-default">
                <div class="panel-heading">Fotos do Anúncio</div>
                <div class="panel-body">

<?php foreach ($info['fotos'] as $foto):?>
                        <div class="foto_item">
                            <img src="<?php echo BASE_URL;?>assets/images/anuncios/<?php echo $foto['url'];?>" class="img-thumbnail" border="0" /><br/>
                            <a href="<?php echo BASE_URL;?>fotos/excluir/<?php echo $foto['id'];?>" class="btn btn-default">Excluir imagem.</a>
                        </div>
<?php endforeach;?>
                </div>
            </div>
        </div>


        <input type="submit" value="Salvar" class="btn btn-default" />
    </form>
</div>