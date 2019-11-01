<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 text-dark" id="tmcont" style="font: normal 23px Robo; background-color: #F0F0D8"" >
    <h1 class="text-center">Cadastrar - Secretaria</h1> <br>
    <form role="form" method="POST" action="/adm/cadastrar/adm">
        <div class="form-group">
            <label form="desnome">Nome:</label>
            <input class="form-control" type="text" name="desnome"  placeholder="Digite o nome"><br>
            <label form="deslogin">Login:</label>
            <input class="form-control" type="text"  name="deslogin" placeholder="Digite o login"><br>
            <label form="despassword">Senha:</label>
            <input class="form-control" type="password" name="despassword" placeholder="Digite a sua senha"><br>
            <label form="desaddress">Email:</label>
            <input class="form-control" type="text"  name="desemail" placeholder="Digite o e-mail"><br>
            <input class="btn btn-success" type="submit" value="cadastrar"><br>
            <div class="text-center"><img src="/arq/img/PTK-icon.png" alt="Imagem responsiva" class="img-rounded"></div><br>
        </div>
    </form>
</div>