<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;



$app = new Slim;

$app->config('debug', true);

require_once("site.php");
require_once("adm.php");
require_once("function.php");

$app->run();

?>