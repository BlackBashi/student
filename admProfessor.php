<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\Register;
use Students\Classes\Boletim;
use Students\Classes\PageAdmin;


$app->get('/adm/professores', function(){
	Register::verifyLoginAdm();
	$Register = new Register;
	$Boletim = new Boletim;

	$pagination = (isset($_GET["page"])) ?  (int)$_GET["page"] : 1;
	if(isset($_GET["search"])){
		$search = $Boletim->searchProf($_GET["search"]);
	}else{
		$search = "";
	}

	$professores = $Boletim->pageTurma($pagination, 10);
	$pages = [];
	for ($i=1; $i <= $professores["pages"]; $i++){
		array_push($pages, [
			'link'=>"/adm/professores?page=" . $i,
			'page'=>$i,
		]);
	}

	$page = new PageAdmin();
	$page->setTpl("professores", [
		"professores"=>$professores["professores"],
		"pages"=>$pages,
		"search"=>$search
	]);
});

$app->post("/adm/professores", function(){
	if($_POST["search"] == ""){
		header("Location: /adm/professores");
		die;
	}

	header("Location: /adm/professores?&search=" . $_POST["search"]);
	die;
});

$app->get('/adm/cadastrar/professor', function(){
	Register::verifyLoginAdm();
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
	$Register = new Register;
	
	if($_POST["desnome"] == "" || $_POST["descpf"] == "" || $_POST["descodigo"] == ""){
		header("Location: /adm/cadastrar/professor?error=1");
		die;
	}
	$Register->insertProfessor($_POST["desnome"], $_POST["descpf"], $_POST["descodigo"]);
		header("Location: /adm/cadastrar/professor?success=1");
		die;
});

$app->get('/adm/editarprofessor', function(){
	Register::verifyLoginAdm();
	$Register = new Register();
	$page = new PageAdmin();

	$professor = $Register->dadosProfessor($_GET["id"]);
	
	$error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
	$success = isset($_GET['success']) && $_GET['success'] ? 1 : 0;
	$page->setTpl("editarProfessor", [
		"professor"=>$professor,
		"error"=>$error,
		"success"=>$success
	]);
});

$app->post('/adm/editarprofessor', function(){
	Register::verifyLoginAdm();
	$Register = new Register;
	
	if($_POST["desnome"]  == "" || $_POST["descpf"] == "" || $_POST["descodigo"] == ""){
		header("Location: /adm/editarprofessor?error=1&id={$_GET["id"]}");
		die;
	}
	$results = $Register->editProfessor($_POST["desnome"], $_POST["descpf"], $_POST["descodigo"], $_GET["id"]);
	header("Location: /adm/editarprofessor?success=1&id={$_GET['id']}");
	die;
});

$app->get('/adm/deletarprofessor', function(){
	Register::verifyLoginAdm();
	$Register = new Register();

	$Register->deleteProfessor($_GET["id"]);
	header("Location: /adm/professores");
	die;
});

$app->get('/adm/addturma', function(){
	$Register = new Register();
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

