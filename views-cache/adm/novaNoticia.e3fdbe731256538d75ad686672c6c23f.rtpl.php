<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 text-dark" id="tmcont" style="font: normal 23px Robo; background-color: #CCCCCC" >
    <h1 class="text-center">Nova noticia</h1> <br>
    <form role="form" method="POST" action="/adm/novanoticia" enctype="multipart/form-data">
        <div class="form-group">
            <label form="desautor">Autor:</label>
            <input class="form-control" type="text" name="desautor"  placeholder="Digite o nome do autor"><br>
            <label form="destitulo">Título:</label>
            <input class="form-control" type="text"  name="destitulo" placeholder="Digite o Título"><br>
            <label form="destitulo">Imagem:</label><br>
            <input class="btn btn-warning" type="file"  name="fileimage"><br>
            <br><label form="destitulo">Detalhes:</label>
            <textarea class="form-control"name="desdetails"> </textarea><br>
            <input class="btn btn-success" type="submit" value="Postar"><br>
            <div class="text-center"><img src="/arq/img/PTK-icon.png" alt="Imagem responsiva" class="img-rounded"></div><br>
        </div>
    </form>
</div>