<?php if(!class_exists('Rain\Tpl')){exit;}?><h1 class='titulo'>Alunos</h1>
<form role="form" method="POST" action="/resultado">
    <label class="campName" form="namestudents">Nome: </label>
    <input class="campText" type="text" name="namestudents" placeholder="Digite o nome completo">
    <label class="campSala" form="turma">Turma: </label>
    <input class="campTextS" type="text" name="turma" placeholder="Digite a sala">
    <label class="campNota" form="nota">Nota 1º: </label>
    <input class="campTextN" type="text" name="nota" placeholder="Digite a nota do 1º Bimestre">
    <label class="campNota1" form="nota1">Nota 2º: </label>
    <input class="campTextN1" type="text" name="nota1" placeholder="Digite a nota do 2º Bimestre">
    <label class="campNota2" form="nota2">Nota 3º: </label>
    <input class="campTextN2" type="text" name="nota2" placeholder="Digite a nota do 3º Bimestre">
    <label class="campNota3" form="nota3">Nota 4º: </label>
    <input class="campTextN3" type="text" name="nota3" placeholder="Digite a nota do 4º Bimestre">
    <input class="bot" type="submit" value="Calcular">
</form>