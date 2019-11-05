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

$app->get('/adm/alunos', function(){
	register::verifyLoginAdm();
	$Register = new register;

	$alunos = $Register->listAllStudents();

	//dd($alunos);
	$page = new PageAdmin();
	$page->setTpl("students", [
		"aluno"=>$alunos
	]);
});

$app->get('/adm/noticias', function(){
	register::verifyLoginAdm();
	$Page = new PageAdmin();
	$Register = new register();

	$results = $Register->listNoticias();
	$Page->setTpl("noticias", [
		"noticias"=>$results
	]);
});


$app->get('/adm/novanoticia', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();

	$page->setTpl("novaNoticia");
});

$app->post('/adm/novanoticia', function(){
	register::verifyLoginAdm();
	$Register = new Register();
	
	$Register->insertNoticias($_POST['desautor'], $_POST['destitulo'], $_POST['desdetails'], $_FILES['fileimage']['tmp_name']);
});

$app->get('/adm/editarnoticia', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$Register = new register;

	$results = $Register->dadosNoticia($_GET[1]);
	$page->setTpl("editarNoticia", [
		"results"=>$results
	]);
});

$app->post('/adm/editarnoticia', function(){
	register::verifyLoginAdm();
	$Register = new Register();

	$Register->editNoticia($_POST['desautor'], $_POST['destitulo'], $_POST['desdetails'], $_GET[1]);
	header("Location: /adm/noticias");
	die;
});

$app->get('/adm/deletarnoticia', function(){
	register::verifyLoginAdm();
	$Register = new Register();

	$Register->deleteNoticia($_GET[1]);
	header("Location: /adm/noticias");
	die;
});

$app->get('/adm/professores', function(){
	register::verifyLoginAdm();
	$Register = new register;

	$professores = $Register->listAllProfessores();

	//dd($alunos);
	$page = new PageAdmin();
	$page->setTpl("professores", [
		"professores"=>$professores
	]);
});

/*$app->post('/ok', function(){
	$register = new register;
	$register->valiLoginAdm($_POST["deslogin"], $_POST["despassword"]);
	dd($_SESSION);
});*/

$app->get('/adm/cadastrar', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$page->setTpl("cadastrar");
});

$app->get('/adm/cadastrar/alunos', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$page->setTpl("registerAlunos");
});

$app->post('/adm/cadastrar/alunos', function(){
	
	$register = new register;
	$register->insertStudents($_POST["desnome"], $_POST["descpf"], $_POST["desturma"]);
	$page = new PageAdmin();
	$page->setTpl("registerAlunos");
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

$app->get('/adm/cadastrar/professor', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$page->setTpl("registerProfessores");
});

$app->post('/adm/cadastrar/professor', function(){
	$register = new register;
	$register->insertProfessor($_POST["desnome"], $_POST["descpf"], $_POST["descodigo"]);
	header("Location: /adm/cadastrar/professor");
	die;
});