<?php if(!class_exists('Rain\Tpl')){exit;}?><div class="container">
<div class="p-3 mb-2 bg-light text-dark">
<h1 class="text-center rellax" data-rellax-speed="2" >Notícias</h1><br>
<?php $counter1=-1;  if( isset($results) && ( is_array($results) || $results instanceof Traversable ) && sizeof($results) ) foreach( $results as $key1 => $value1 ){ $counter1++; ?>

<div class="container">
    <div class="p-3 mb-2 bg-light text-dark">
        <div class="container border border-dark shadow-lg" style="height: auto; background-color: bisque;">
            <div class="row">
                <div class="col-sm">
                    <p class="text-center">_</p>
                    <h4 class="text-center" style="font-size: 40px;"><strong><?php echo htmlspecialchars( $value1["destitulo"], ENT_COMPAT, 'UTF-8', FALSE ); ?></strong></h4>
                    <span class="text-muted small"><?php echo htmlspecialchars( $value1["desautor"], ENT_COMPAT, 'UTF-8', FALSE ); ?> - Publicado em: <?php echo htmlspecialchars( $value1["dtregister"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </span>
                    <p class="text-justify" ><?php echo htmlspecialchars( $value1["desdetails"], ENT_COMPAT, 'UTF-8', FALSE ); ?> </p><br>      
                </div>   
            </div> 
            <div class="text-center"> 
                <img  src="/arq/img/upload/<?php echo htmlspecialchars( $value1["desimage"], ENT_COMPAT, 'UTF-8', FALSE ); ?>" style="height: 400px;"><br>
                <p>_</p>
            </div>
        </div>
       
    </div>
</div>  
<?php } ?>

</div>