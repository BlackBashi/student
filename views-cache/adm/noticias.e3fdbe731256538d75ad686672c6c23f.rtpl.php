<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 text-dark" style="background-color: #CCCCCC">
    <a class="btn btn-warning btn-lg btn-block" href="/adm/novanoticia" role="button">Nova Notícia</a><br>
    <h2 class="text-center">Gerenciar Notícias</h2>
    <table class="table table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Autor</th>
                <th scope="col">Título</th>
                <th scope="col">Data de publicação</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter1=-1;  if( isset($noticias) && ( is_array($noticias) || $noticias instanceof Traversable ) && sizeof($noticias) ) foreach( $noticias as $key1 => $value1 ){ $counter1++; ?>

            <tr>
                <th scope="row"><?php echo htmlspecialchars( $value1["idnoticia"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                <td><?php echo htmlspecialchars( $value1["desautor"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td><?php echo htmlspecialchars( $value1["destitulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td><?php echo htmlspecialchars( $value1["dtregister"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td>
                    <a class="btn btn-info" href="/adm/editarnoticia?1=<?php echo htmlspecialchars( $value1["idnoticia"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Editar</a>
                    <a class="btn btn-danger" href="/adm/deletarnoticia?1=<?php echo htmlspecialchars( $value1["idnoticia"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" role="button">Deletar</a>
                </td> 
            </tr> 
            <?php } ?>

        </tbody>
      </table>     
</div>