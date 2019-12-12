<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\PageAdmin;

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

$app->get('/logoutprofessor', function(){
	session_destroy();
	header("Location: /professor?logout=1");
	die();
});

$app->get('/perfilProfessor', function(){
	$Register = new register;
	register::NOTissetLogin();

	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>$header['user'],
		"headerAluno"=>$header['aluno'],
		"headerProf"=>$header['professor']
	]);
	
	$professor = $Register->dadosProfessor($_SESSION["userProf"]["idprof"]);
	$Page->setTpl("perfilProfessor", [
		"professor"=>$professor
	]);
});

$app->get('/infoprofessor', function(){
	$Register = new register;
	register::NOTissetLogin();

	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>$header['user'],
		"headerAluno"=>$header['aluno'],
		"headerProf"=>$header['professor']
	]);

	
	$professor = $Register->dadosProfessor($_SESSION["userProf"]["idprof"]);
	$error = isset($_GET['error']) ? 1 : 0;
	$errorsenha = isset($_GET['errorsenha']) ? 1 : 0;
	$success = isset($_GET['success']) ? 1 : 0;
	$Page->setTpl("infoProfessor", [
		"professor"=>$professor,
		"success"=>$success,
		"error"=>$error,
		"errorsenha"=>$errorsenha
	]);
});

$app->post('/infoprofessor', function(){
	$Register = new register;
	register::NOTissetLogin();

	if(isset($_POST["desnome"])){
		if($_POST["desnome"] == "" || $_POST["desaddress"] == ""){
			header("Location: /infoaluno?error=1");
			die;
		}
	
		if(($_FILES["fileimage"]["tmp_name"]) == ""){
			$image = $_SESSION["userProf"]["desimage"];
		}else{
			$image = $_FILES["fileimage"]["tmp_name"];
		}
		$Register->editLoginP($_POST["desnome"], $_POST["desaddress"], $_POST["desnumber"], $image, $_SESSION["userProf"]["idprof"]);
	}
	$Register->editPasswordP($_POST["antiga"], $_POST["nova"], $_SESSION["userProf"]["idprof"]);
});
