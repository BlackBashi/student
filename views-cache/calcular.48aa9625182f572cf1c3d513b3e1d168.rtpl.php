<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 bg-dark text-white">
    <h1 class='titulo'>Alunos</h1><br>
    <form role="form" method="POST" action="/resultado">
        <div class="form-group">
            <label class="campName" form="namestudents">Nome: </label>
            <input class="form-control" type="text" name="namestudents" placeholder="Digite o nome completo"><br>
            <label class="campSala" form="turma">Turma: </label>
            <input class="form-control" type="text" name="turma" placeholder="Digite a sala"><br>
            <label class="campNota" form="nota">Nota 1º: </label>
            <input class="form-control" type="text" name="nota" placeholder="Digite a nota do 1º Bimestre"><br>
            <label class="campNota1" form="nota1">Nota 2º: </label>
            <input class="form-control" type="text" name="nota1" placeholder="Digite a nota do 2º Bimestre"><br>
            <label class="campNota2" form="nota2">Nota 3º: </label>
            <input class="form-control" type="text" name="nota2" placeholder="Digite a nota do 3º Bimestre"><br>
            <label class="campNota3" form="nota3">Nota 4º: </label>
            <input class="form-control" type="text" name="nota3" placeholder="Digite a nota do 4º Bimestre"><br>
            <input class="bot" type="submit" value="Calcular">
        </div>
    </form>
</div>