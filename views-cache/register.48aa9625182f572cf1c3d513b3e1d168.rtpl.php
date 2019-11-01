<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 bg-light text-dark" id="tmcont" style="font: normal 23px Robo" >
    <h1 class="text-center">Cadastrar</h1> <br>
    <form role="form" method="POST" action="/register">
        <div class="form-group">
            <label form="desnome">Nome:</label>
            <input class="form-control" type="text" name="desnome"  placeholder="Digite seu nome"><br>
            <label form="deslogin">Login:</label>
            <input class="form-control" type="text"  name="deslogin" placeholder="Digite o seu login"><br>
            <label form="desaddress">Email:</label>
            <input class="form-control" type="text"  name="desaddress" placeholder="Digite o seu e-mail"><br>
            <label form="despassword">Senha:</label>
            <input class="form-control" type="password" name="despassword" placeholder="Digite a sua senha"><br>
            <label form="desturma">Turma:</label><br>
            <select name="desturma"> 
                <option value=""></option> 
                <option value="1am">1º AM</option>
                <option value="1bm">1º BM</option>
                <option value="1cm">1º CM</option>
                <option value="1dm">1º DM</option>
                <option value="1em">1º EM</option>
                <option value="1fm">1º FM</option>
                <option value="1gm">1º GM</option>
                <option value="2am">2º AM</option>
                <option value="2bm">2º BM</option>
                <option value="2cm">2º CM</option>
                <option value="2dm">2º DM</option>
                <option value="2em">2º EM</option>
                <option value="2fm">2º FM</option>
                <option value="2gm">2º GM</option>
                <option value="3am">3º AM</option>
                <option value="3bm">3º BM</option>
                <option value="3cm">3º CM</option>
                <option value="3dm">3º DM</option>
                <option value="3em">3º EM</option>
                <option value="3fm">3º FM</option>
                <option value="3gm">3º GM</option>
                <option value="1aV">1º AV</option>
                <option value="1bV">1º BV</option>
                <option value="1cV">1º CV</option>
                <option value="1dV">1º DV</option>
                <option value="1eV">1º EV</option>
                <option value="1fV">1º FV</option>
                <option value="1gV">1º GV</option>
                <option value="2aV">2º AV</option>
                <option value="2bV">2º BV</option>
                <option value="2cV">2º CV</option>
                <option value="2dV">2º DV</option>
                <option value="2eV">2º EV</option>
                <option value="2fV">2º FV</option>
                <option value="2gV">2º GV</option>
                <option value="3aV">3º AV</option>
                <option value="3bV">3º BV</option>
                <option value="3cV">3º CV</option>
                <option value="3dV">3º DV</option>
                <option value="3eV">3º EV</option>
                <option value="3fV">3º FV</option>
                <option value="3gV">3º GV</option>
                <option value="1aN">1º AN</option>
                <option value="1bN">1º BN</option>
                <option value="1cN">1º CN</option>
                <option value="1dN">1º DN</option>
                <option value="1eN">1º EN</option>
                <option value="1fN">1º FN</option>
                <option value="1gN">1º GN</option>
                <option value="2aN">2º AN</option>
                <option value="2bN">2º BN</option>
                <option value="2cN">2º CN</option>
                <option value="2dN">2º DN</option>
                <option value="2eN">2º EN</option>
                <option value="2fN">2º FN</option>
                <option value="2gN">2º GN</option>
                <option value="aN">3º AN</option>
                <option value="bN">3º BN</option>
                <option value="cN">3º CN</option>
                <option value="dN">3º DN</option>
                <option value="eN">3º EN</option>
                <option value="fN">3º FN</option>
                <option value="gN">3º GN</option>
            </select><br>
            <input class="btn btn-success" type="submit" value="cadastrar"><br>
            <div class="text-center"><img src="/arq/img/PTK-icon.png" alt="Imagem responsiva" class="img-rounded"></div><br>
        </div>
    </form>
</div>