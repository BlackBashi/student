<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\Boletim;
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

$app->get('/adm/turmas', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$register = new register;
	$boletim = new Boletim;

	$turmas = $boletim->turmas();
	$page->setTpl("turmas", [
		"turmas"=>$turmas,
	]);
});

$app->get('/adm/editarTurma', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$register = new register;
	$boletim = new Boletim;

	$professoresadd = $boletim->turmaProfessores($_GET['id']);
	$professores = $register->listAllProfessores();
	$dados = $boletim->getTurma($_GET['id']);
	
	$materias = $boletim->turmaMaterias($_GET['id']);
	$page->setTpl("editarTurma", [
		"nome"=>$dados[0]["descricao"],
		"dados"=>$dados,
		"professores"=>$professores,
		"materias"=>$materias,
		"professoresadd"=>$professoresadd,
		"idturma"=>$_GET["id"]
	]);
});

$app->post('/adm/editarTurma', function(){
	$boletim = new Boletim; 
	$boletim->editTurma($_POST["descricao"], $_POST["turno"], intval($_POST["anoletivo"]), $_POST["idturma"]);
	header("Location: /adm/editarTurma?id=" . $_POST["idturma"]);
	die;
});

$app->post("/adm/addprof", function(){
	$boletim = new Boletim;

	$materia = $_POST["materia"];
	$boletim->addProfessor($_GET["idturma"], $materia, $_GET["id"]);
	header("Location: /adm/editarTurma?id=" . $_GET["idturma"]);
	die;
});

$app->get("/adm/removerprof", function(){
	$boletim = new Boletim;

	$materia = "2";
	$boletim->removeProfessor($_GET["id"]);
	header("Location: /adm/editarTurma?id=" . $_GET["idturma"]);
	die;
});