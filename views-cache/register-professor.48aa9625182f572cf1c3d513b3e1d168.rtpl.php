<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container">
    <h1 class="text-center">Cadastrar</h1> <br>
    <form role="form" method="POST" action="/registrado">
        <div class="form-group">
            <label class="campName" form="desnome">Nome:</label>
            <input class="form-control" type="text" name="desnome"  placeholder="Digite seu nome"><br>
            <label class="campSala" form="deslogin">Login:</label>
            <input class="form-control" type="text"  name="deslogin" placeholder="Digite o seu login"><br>
            <label class="campNota" form="desaddress">Email:</label>
            <input class="form-control" type="text"  name="desaddress" placeholder="Digite o seu e-mail"><br>
            <label class="campNota1" form="despassword">Senha:</label>
            <input class="form-control" type="password" name="despassword" placeholder="Digite a sua senha"><br>
            <label class="campNota1" form="despassword">Código:</label>
            <input class="form-control" type="password" name="despassword" placeholder="Digite o seu código"><br>
            <input class="btn btn-success" type="submit" value="cadastrar"><br>
            <div class="text-center"><img src="/arq/img/PTK-icon.png" alt="Imagem responsiva" class="img-rounded"></div><br>
        </div>
    </form>
</div>