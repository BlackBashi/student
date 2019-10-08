<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container p-3 mb-2 bg-light text-dark" id="tmcont"  style="font: normal 23px Robo" >
    <h1 class='text-center'>Resultado</h1>
    <div  class="table-responsive">
        <table class="table table-bordered table-dark">
            <thead>
                <tr>
                  <th scope="col">Nome do Aluno</th>
                  <th scope="col">Turma</th>
                  <th scope="col">Nota 1º</th>
                  <th scope="col">Nota 2º</th>
                  <th scope="col">Nota 3º</th>
                  <th scope="col">Nota 4º</th>
                  <th scope="col">Média</th>
                  <th scope="col">Resultado</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><?php echo htmlspecialchars( $namestudent, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $turma, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $nota, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $nota1, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $nota2, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $nota3, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $media, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                  <td><?php echo htmlspecialchars( $results, ENT_COMPAT, 'UTF-8', FALSE ); ?></td>
                </tr>
                </tbody>
        </table>
    </div>
</div>
