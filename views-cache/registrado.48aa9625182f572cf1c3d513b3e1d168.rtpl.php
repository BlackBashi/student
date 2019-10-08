<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container">
    <div class="central"><h2 class="text-center">Obrigado por se registrar <?php echo htmlspecialchars( $desnome, ENT_COMPAT, 'UTF-8', FALSE ); ?>!</h2></div>
    <form role="form" method="GET" action="/">
        <input class="btn btn-success" type="submit" value="Fazer login!">
    </form>
</div>