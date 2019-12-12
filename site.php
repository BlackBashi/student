<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\Boletim;
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

	$error = isset($_GET["error"])  ? 1 : 0;
	$errorcpf = isset($_GET["errorcpf"])  ? 1 : 0;
	$success = isset($_GET["success"]) ? 1 : 0;
	$Page->setTpl("register", [
		"error"=>$error,
		"success"=>$success,
		"errorcpf"=>$errorcpf
	]);
});

$app->post('/register', function() {
	register::issetLogin();
	if($_POST["desnome"]  == "" || $_POST["deslogin"] == "" || $_POST["desaddress"] == "" || $_POST["despassword"] === "" || $_POST["desturma"] === ""){
		header("Location: /register?error=1");
		die;
	}

	$cadastro = new register;
	if($cadastro->insert($_POST["desnome"], $_POST["deslogin"], $_POST["desaddress"], $_POST["despassword"], $_POST["desturma"], $_FILES['fileimage']['tmp_name'], $_POST["descpf"])){
		header("Location: /register?success=1");
		die;
	}else{
		header("Location: /register?errorcpf=1");
		die;
	}
	
});

$app->get('/logout', function(){
	session_destroy();
	header("Location: /login?logout=1");
	die();
});

$app->get('/perfil', function(){
	$Register = new register;
	register::NOTissetLogin();

	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>$header['user'],
		"headerAluno"=>$header['aluno'],
		"headerProf"=>$header['professor']
	]);

	
	$aluno = $Register->dadosLogin($_SESSION["user"]["idlogin"]);
	$Page->setTpl("perfil", [
		"aluno"=>$aluno
	]);
});

$app->get('/infoaluno', function(){
	register::NOTissetLogin();
	$Register = new Register;

	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>$header['user'],
		"headerAluno"=>$header['aluno'],
		"headerProf"=>$header['professor']
	]);$Register = new register;
	

	
	$aluno = $Register->dadosLogin($_SESSION["user"]["idlogin"]);
	$error = isset($_GET['error']) ? 1 : 0;
	$errorsenha = isset($_GET['errorsenha']) ? 1 : 0;
	$success = isset($_GET['success']) ? 1 : 0;
	$Page->setTpl("infoaluno", [
		"aluno"=>$aluno,
		"success"=>$success,
		"error"=>$error,
		"errorsenha"=>$errorsenha
	]);
});

$app->post('/infoaluno', function(){
	$Register = new register;
	register::NOTissetLogin();

	if(isset($_POST["desnome"])){
		if($_POST["desnome"] == "" || $_POST["desaddress"] == ""){
			header("Location: /infoaluno?error=1");
			die;
		}
	
		if(($_FILES["fileimage"]["tmp_name"]) == ""){
			$image = $_SESSION["user"]["desimage"];
		}else{
			$image = $_FILES["fileimage"]["tmp_name"];
		}
		$Register->editLoginA($_POST["desnome"], $_POST["desaddress"], $_POST["desnumber"], $image, $_SESSION["user"]["idlogin"]);
	}
	$Register->editPasswordA($_POST["antiga"], $_POST["nova"], $_SESSION["user"]["idlogin"]);
});

$app->get("/testeboletim", function(){
	$Register = new register;
	$Boletim = new Boletim;

	$turmas = $Boletim->turmas();
	$notas = $Boletim->notas();
	$header = $Register->verifyHeader();
	$Page = new Page([
		"header"=>$header['user'],
		"headerAluno"=>$header['aluno'],
		"headerProf"=>$header['professor']
	]);
	$Page->setTpl("boletimprof", [
		"turmas"=>$turmas,
		"bimestre"=>$notas
	]);
});