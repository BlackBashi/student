<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 bg-light text-dark"  id="tmcont" style="font: normal 23px Robo" >
    <h1 class="text-center">Login</h1><br>
    <form role="form" method="POST" action="/">
        <div class="form-group" style="font: normal 23px Robo" >
            <label class="campName" form="deslogin" style="font: normal 23px Robo">Login:</label>
            <input class="form-control" type="text"  name="deslogin" placeholder="Digite o seu login"><br>
            <label form="despassword">Senha:</label>
            <input class="form-control" type="password"  name="despassword" placeholder="Digite a sua senha"><br>
           <div class="text-right"> <input class="btn btn-success" type="submit" value="Login"> <br></div>
            <div class="text-center"><img src="/arq/img/PTK-icon.png" alt="Imagem responsiva" class="img-rounded"></div><br>
        </div>
    </form>
</div>