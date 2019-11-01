<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\PageAdmin;



$app->get('/', function() {
	register::issetLogin();
	$Page = new Page;
	$Register = new register;

	$results = $Register->listNoticias();
	
	$Page->setTpl("inicio", [
		"results"=>$results
	]);
});


$app->get('/login', function() {
	register::issetLogin();
	$Page = new Page([
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

$app->post('/login', function() {
	$Register = new register();
	
	$result = $Register->valilogin($_POST["deslogin"], $_POST["despassword"]);
	if ($result) {
		header("Location: /home");
	} else {
		header("Location: /login?error=1");
	}
	die;
});

$app->get('/register', function() {
	register::issetLogin();
	$page = new Page();
	$page->setTpl("register");
});

$app->post('/register', function() {
	register::issetLogin();
	if($_POST["desnome"]  === "" || $_POST["deslogin"] === "" || $_POST["desaddress"] === "" || $_POST["despassword"] === "" || $_POST["desturma"] === ""){
		throw new \Exception("Preencha todos os campos!");
	}

	$cadastro = new register;
	$cadastro->insert($_POST["desnome"], $_POST["deslogin"], $_POST["desaddress"], $_POST["despassword"], $_POST["desturma"]);
});

$app->get('/professor', function() {
	register::issetLogin();
	$page = new Page([
		"header"=>false,
		"footer"=>false
	]);
	$page->setTpl("loginProfessores");
});

$app->get('/home', function(){
	register::verifyLogin();
	$page = new Page();
	$page->setTpl("home");
});

$app->get('/logout', function(){
	session_destroy();
	header("Location: /login?logout=1");
	die();
});