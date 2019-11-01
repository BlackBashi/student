<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 text-dark" id="tmcont" style="font: normal 23px Robo; background-color: #F0F0D8" >
    <h1 class="text-center">Cadastrar professor</h1> <br>
    <form role="form" method="POST" action="/adm/cadastrar/professor">
        <div class="form-group">
            <label form="desnome">Nome:</label>
            <input class="form-control" type="text" name="desnome"  placeholder="Digite o nome do professor"><br>
            <label form="deslogin">CPF:</label>
            <input class="form-control" type="text"  name="descpf" placeholder="Digite o CPF do professor"><br>
            <label form="deslogin">Código de login:</label>
            <input class="form-control" type="text"  name="descodigo" placeholder="Digite o Código de login"><br>
            <input class="btn btn-success" type="submit" value="cadastrar"><br>
            <div class="text-center"><img src="/arq/img/PTK-icon.png" alt="Imagem responsiva" class="img-rounded"></div><br>
        </div>
    </form>
</div>