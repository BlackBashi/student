<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\Boletim;
use Students\Classes\PageAdmin;


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

$app->get('/adm/cadastrar/alunos', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$Boletim = new Boletim;

	$turmas = $Boletim->turmas();
	$error = isset($_GET["error"]) && $_GET["error"] ? 1 : 0;
	$success = isset($_GET["success"]) && $_GET["success"] ? 1 : 0;
	$page->setTpl("registerAlunos", [
		"error"=>$error,
		"success"=>$success,
		"turmas"=>$turmas
	]);
});

$app->post('/adm/cadastrar/alunos', function(){
	$page = new PageAdmin();
	$register = new register;

	if($_POST["desnome"]  == "" || $_POST["descpf"] == "" || $_POST["desturma"] == ""){
		header("Location: /adm/cadastrar/alunos?error=1");
		die;
	}
	$register->insertStudents($_POST["desnome"], $_POST["descpf"], $_POST["desturma"]);
	header("Location: /adm/cadastrar/alunos?success=1");
	die;
});

$app->get('/adm/editaraluno', function(){
	register::verifyLoginAdm();
	$register = new register();
	$page = new PageAdmin();

	$alunos = $register->dadosAluno($_GET["id"]);
	$error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
	$success = isset($_GET['success']) && $_GET['success'] ? 1 : 0;
	$page->setTpl("editarAluno", [
		"aluno"=>$alunos,
		"error"=>$error,
		"success"=>$success
	]);
});

$app->post('/adm/editaraluno', function(){
	register::verifyLoginAdm();
	$Register = new register;
	
	if($_POST["desnome"]  == "" || $_POST["descpf"] == "" || $_POST["desturma"] == ""){
		header("Location: /adm/editaraluno?error=1&id={$_GET['id']}");
		die;
	}
	$results = $Register->editAluno($_POST["desnome"], $_POST["descpf"], $_POST["desturma"], $_GET["id"]);
	header("Location: /adm/editaraluno?success=1&id={$_GET['id']}");
	die;
});

$app->get('/adm/deletaraluno', function(){
	register::verifyLoginAdm();
	$Register = new Register();

	$Register->deleteAluno($_GET["id"]);
	header("Location: /adm/alunos");
	die;
});
