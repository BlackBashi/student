<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 text-dark" id="tmcont" style="font: normal 23px Robo; background-color: #CCCCCC" >
    <h1 class="text-center">Editar noticia</h1> <br>
    <form role="form" method="POST">
        <div class="form-group">
            <?php $counter1=-1;  if( isset($results) && ( is_array($results) || $results instanceof Traversable ) && sizeof($results) ) foreach( $results as $key1 => $value1 ){ $counter1++; ?>

            <label form="desautor">Autor:</label>
            <input class="form-control" type="text" name="desautor"  value="<?php echo htmlspecialchars( $value1["desautor"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><br>
            <label form="destitulo">Título:</label>
            <input class="form-control" type="text"  name="destitulo" value="<?php echo htmlspecialchars( $value1["destitulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?>"><br>
            <label form="destitulo">Imagem:</label><br>
            <input class="btn btn-warning" type="file"  name="fileimage" value="{value.desimage}"><br>
            <label form="destitulo">Detalhes:</label>
            <textarea class="form-control"name="desdetails"><?php echo htmlspecialchars( $value1["desdetails"], ENT_COMPAT, 'UTF-8', FALSE ); ?></textarea><br>
            <input class="btn btn-success" type="submit" value="Postar"><br>
            <div class="text-center"><img src="/arq/img/PTK-icon.png" alt="Imagem responsiva" class="img-rounded"></div><br>
            <?php } ?>

        </div>
    </form>
</div>