<?php if(!class_exists('Rain\Tpl')){exit;}?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    

 
     <!-- Bootstrap CSS -->
    <script src="/arq/js/jquery.min.js"></script>
    <script src="/arq/js/popper.min.js"></script>
    <script src="/arq/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/arq/css/bootstrap.min.css">
    <link rel="stylesheet" media="(max-width : 2550px)" href="/arq/css/estilos.css">
    <title>Teste</title>
</head>
<body class="backimagelogin paralax">
        <div class="container border border-dark shadow-lg w-50 p-5 text-dark"  id="tmcont" style="height: 19,2cm; font: normal 23px Robo; background-color: #F0F0F0" >
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="/">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Login</li>
                </ol>
              </nav>
            <h1 class="text-center">Aluno <br>Login</h1><br>
            <?php if( $error == 1 ){ ?>

                <div class="alert alert-danger" role="alert">
                    Senha ou usuário incorreto!
                </div>
            <?php } ?>

            <?php if( $logout == 1 ){ ?>

            <div class="alert alert-success" role="alert">
                Deslogado com sucesso!
            </div>
            <?php } ?>

            <form class="form-response" role="form" method="POST" action="/login">
                <div style="font: normal 23px Robo" >
                    <label class="campName" form="deslogin" style="font: normal 23px Robo">Login:</label>
                    <input class="form-control" type="text"  name="deslogin" placeholder="Digite o seu login"><br>
                    <label form="despassword">Senha:</label>
                    <input class="form-control" type="password"  name="despassword" placeholder="Digite a sua senha"><br>
                    <div class="text-right"> <input class="btn btn-success" type="submit" value="Login"> <br></div><br>
                    <h4 class="text-center">Ainda não possui uma conta? <a href="/register">clique aqui</a> </h4><br>
                    <div class="text-center"><img src="/arq/img/PTK-icon.png" alt="Imagem" class="img-responsiva"></div><br>
                </div>    
            </form>
        </div>
</body>
</html>