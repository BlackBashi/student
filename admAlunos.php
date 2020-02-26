<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\Register;
use Students\Classes\Boletim;
use Students\Classes\PageAdmin;


$app->get('/adm/alunos', function(){
	Register::verifyLoginAdm();
	$Boletim = new Boletim;

	$pagination = (isset($_GET["page"])) ?  (int)$_GET["page"] : 1;
	if(isset($_GET["search"])){
		$search = $Boletim->searchStudents($_GET["search"]);
	}else{
		$search = "";
	}
	$alunos = $Boletim->pageStudents($pagination);
	$pages = [];
	for ($i=1; $i <= $alunos["pages"]; $i++){
		array_push($pages, [
			'link'=>"/adm/alunos?page=" . $i,
			'page'=>$i,
		]);
	}

	$page = new PageAdmin();
	$page->setTpl("students", [
		"aluno"=>$alunos["students"],
		"pages"=>$pages,
		"search"=>$search
	]);
});

$app->post("/adm/alunos", function(){
	if($_POST["search"] == ""){
		header("Location: /adm/alunos");
		die;
	}

	header("Location: /adm/alunos?&search=" . $_POST["search"]);
	die;
});

$app->get('/adm/cadastrar/alunos', function(){
	Register::verifyLoginAdm();
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
	$Register = new Register;

	if($_POST["desnome"]  == "" || $_POST["descpf"] == "" || $_POST["desturma"] == ""){
		header("Location: /adm/cadastrar/alunos?error=1");
		die;
	}
	$Register->insertStudents($_POST["desnome"], $_POST["descpf"], $_POST["desturma"]);
	header("Location: /adm/cadastrar/alunos?success=1");
	die;
});

$app->get('/adm/editaraluno', function(){
	Register::verifyLoginAdm();
	$Register = new Register();
	$Boletim = new Boletim;
	$page = new PageAdmin();

	$alunos = $Register->dadosAluno($_GET["id"]);
	$error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
	$success = isset($_GET['success']) && $_GET['success'] ? 1 : 0;
	$materias = $Boletim->turmas();
	$page->setTpl("editarAluno", [
		"aluno"=>$alunos,
		"error"=>$error,
		"success"=>$success,
		"materias"=>$materias
	]);
});

$app->post('/adm/editaraluno', function(){
	Register::verifyLoginAdm();
	$Register = new Register;
	
	if($_POST["desnome"]  == "" || $_POST["descpf"] == "" || $_POST["desturma"] == ""){
		header("Location: /adm/editaraluno?error=1&id={$_GET['id']}");
		die;
	}
	$results = $Register->editAluno($_POST["desnome"], $_POST["descpf"], $_POST["desturma"], $_GET["id"]);
	header("Location: /adm/editaraluno?success=1&id={$_GET['id']}");
	die;
});

$app->get('/adm/deletaraluno', function(){
	Register::verifyLoginAdm();
	$Register = new Register();

	$Register->deleteAluno($_GET["id"]);
	header("Location: /adm/alunos");
	die;
});
