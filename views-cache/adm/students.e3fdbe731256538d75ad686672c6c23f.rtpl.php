<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container">
<div class="p-3 mb-2 text-dark" style="background-color: #F0F0D8">
    <h1 class="text-center">Lista de alunos:</h1><br>
    <table class="table table-bordered table-dark">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nome</th>
                <th scope="col">CPF</th>
                <th scope="col">Turma</th>
            </tr>
        </thead>
        <tbody>
            <?php $counter1=-1;  if( isset($aluno) && ( is_array($aluno) || $aluno instanceof Traversable ) && sizeof($aluno) ) foreach( $aluno as $key1 => $value1 ){ $counter1++; ?>

            <tr>
                <th scope="row"><?php echo htmlspecialchars( $value1["idstudent"], ENT_COMPAT, 'UTF-8', FALSE ); ?></th>
                <td><?php echo htmlspecialchars( $value1["desnome"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td><?php echo htmlspecialchars( $value1["descpf"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                <td><?php echo htmlspecialchars( $value1["desturma"], ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
            </tr> 
            <?php } ?>

        </tbody>
      </table>     
    </div>
</div>