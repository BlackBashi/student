<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\PageAdmin;

session_start();

$app->get('/adm', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$page->setTpl("secretaria");
});

$app->get('/adm/login', function(){
	register::issetLoginAdm();
	$Page = new PageAdmin([
		"header"=>false,
		"footer"=>false
	]);

	$logout = isset($_GET['logout']) && $_GET['logout'] ? 1 : 0;
	$error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
	$Page->setTpl("login", [
		"error"=>$error,
		"logout"=>$logout
	]);
	
});

$app->post('/adm/login', function(){
	$register = new register;

	$result = $register->valiLoginAdm($_POST["deslogin"], $_POST["despassword"]);
	if ($result) {
		header("Location: /adm");
	} else {
		header("Location: /adm/login?error=1");
	}
	die;
});

$app->get('/adm/logout', function(){
	session_destroy();
	header("Location: /adm/login?logout=1");
	die();
});

$app->get('/adm/cadastrar', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$page->setTpl("cadastrar");
});


$app->get('/adm/cadastrar/adm', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$page->setTpl("registerAdm");
});

$app->post('/adm/cadastrar/adm', function(){
	$session = 1;
	$register = new register;
	$register->insertAdm($_POST["desnome"], $_POST["deslogin"], $_POST["despassword"], $_POST["desemail"], $session);
	header("Location: /adm");
	die;
});