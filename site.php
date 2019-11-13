<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\PageAdmin;

$app->get('/', function() {
	$Register = new register;

	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>$header['user'],
		"headerAluno"=>$header['aluno'],
		"headerProf"=>$header['professor']
	]);

	$results = $Register->listNoticias();
	
	$Page->setTpl("inicio", [
		"results"=>$results,
	]);
});



$app->get('/login', function() {
	register::issetLogin();
	$Register = new register;

	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>false,
		"headerAluno"=>false,
		"headerProf"=>false,
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
		header("Location: /");
	} else {
		header("Location: /login?error=1");
	}
	die;
});

$app->get('/register', function() {
	register::issetLogin();
	$Register = new register;

	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>$header['user'],
		"headerAluno"=>$header['aluno'],
		"headerProf"=>$header['professor']
	]);

	$error = isset($_GET["error"]) && $_GET["error"] ? 1 : 0;
	$success = isset($_GET["success"]) && $_GET["success"] ? 1 : 0;
	$Page->setTpl("register", [
		"error"=>$error,
		"success"=>$success
	]);
});

$app->post('/register', function() {
	register::issetLogin();
	if($_POST["desnome"]  == "" || $_POST["deslogin"] == "" || $_POST["desaddress"] == "" || $_POST["despassword"] === "" || $_POST["desturma"] === ""){
		header("Location: /register?error=1");
		die;
	}

	$cadastro = new register;
	$cadastro->insert($_POST["desnome"], $_POST["deslogin"], $_POST["desaddress"], $_POST["despassword"], $_POST["desturma"], $_POST["fileimage"]);
	header("Location: /register?success=1");
	die;
});

$app->get('/professor', function() {
	register::issetLogin();
	$Register = new register;

	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>false,
		"headerAluno"=>false,
		"headerProf"=>false,
		"footer"=>false
	]);
	$logout = isset($_GET['logout']) && $_GET['logout'] ? 1 : 0;
	$error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
	$Page->setTpl("loginProfessores", [
		"error"=>$error,
		"logout"=>$logout
	]);
});

$app->post('/professor', function() {
	$Register = new register;

	$results = $Register->valiLoginProf($_POST["deslogin"], $_POST["despassword"]);
	if($results){
		header("Location: /");
		die;
	}else{
		header("Location: /professor?error=1");
		die;
	}
});


$app->get('/logout', function(){
	session_destroy();
	header("Location: /login?logout=1");
	die();
});

$app->get('/logoutprofessor', function(){
	session_destroy();
	header("Location: /professor?logout=1");
	die();
});