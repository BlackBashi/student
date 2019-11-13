<?php 

require_once("vendor/autoload.php");

use \Slim\Slim;



$app = new Slim;

$app->config('debug', true);

require_once("site.php");
require_once("adm.php");
require_once("function.php");
require_once("admNoticias.php");
require_once("admAlunos.php");
require_once("admProfessor.php");

$app->run();

?>