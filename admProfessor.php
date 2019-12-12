<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\Boletim;
use Students\Classes\PageAdmin;


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

$app->get('/adm/cadastrar/professor', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$Boletim = new Boletim;

	$materias = $Boletim->materias();
	$materias = $Boletim->materias();
	$error = isset($_GET["error"]) && $_GET["error"] ? 1 : 0;
	$success = isset($_GET["success"]) && $_GET["success"] ? 1 : 0;
	$page->setTpl("registerProfessores", [
		"error"=>$error,
		"success"=>$success,
		"materias"=>$materias
	]);
});

$app->post('/adm/cadastrar/professor', function(){
	$register = new register;
	
	if($_POST["desnome"] == "" || $_POST["descpf"] == "" || $_POST["descodigo"] == ""){
		header("Location: /adm/cadastrar/professor?error=1");
		die;
	}
	$register->insertProfessor($_POST["desnome"], $_POST["descpf"], $_POST["descodigo"]);
		header("Location: /adm/cadastrar/professor?success=1");
		die;
});

$app->get('/adm/editarprofessor', function(){
	register::verifyLoginAdm();
	$register = new register();
	$page = new PageAdmin();

	$professor = $register->dadosProfessor($_GET["id"]);
	
	$error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
	$success = isset($_GET['success']) && $_GET['success'] ? 1 : 0;
	$page->setTpl("editarProfessor", [
		"professor"=>$professor,
		"error"=>$error,
		"success"=>$success
	]);
});

$app->post('/adm/editarprofessor', function(){
	register::verifyLoginAdm();
	$Register = new register;
	
	if($_POST["desnome"]  == "" || $_POST["descpf"] == "" || $_POST["descodigo"] == ""){
		header("Location: /adm/editarprofessor?error=1&id={$_GET["id"]}");
		die;
	}
	$results = $Register->editProfessor($_POST["desnome"], $_POST["descpf"], $_POST["descodigo"], $_GET["id"]);
	header("Location: /adm/editarprofessor?success=1&id={$_GET['id']}");
	die;
});

$app->get('/adm/deletarprofessor', function(){
	register::verifyLoginAdm();
	$Register = new Register();

	$Register->deleteProfessor($_GET["id"]);
	header("Location: /adm/professores");
	die;
});

$app->get('/adm/addturma', function(){
	$register = new register();
	$page = new PageAdmin();
	$Boletim = new Boletim();

	$results = $Boletim->materias();
	$error = isset($_GET['error']) ? 1 : 0;
	$success = isset($_GET['success']) ? 1 : 0;
	$page->setTpl("registerTurmas", [
		"materias"=>$results,
		"error"=>$error,
		"success"=>$success
	]);
});

$app->post('/adm/addturma', function(){
	$Boletim = new Boletim;

	$Boletim->insertTurmas($_POST["descricao"], $_POST["turno"], $_POST["materias"]);
});

