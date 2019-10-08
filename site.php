<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;

session_start();

$app->get('/', function() {
	register::sessionIsset();
	$page = new Page();
	$page->setTpl("login");
});

$app->post('/', function() {
	$login = filter_input(INPUT_POST, 'deslogin', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST, 'despassword', FILTER_SANITIZE_STRING);
	$verify = new register();
	if($login === ""){
		throw new \Exception("Login Incorreto!");
	}
	$verify->valilogin($login, $senha);
});

$app->get('/calcular', function() {
	register::verifyLogin();
	$page = new Page();
	$page->setTpl("calcular");
});

$app->post('/resultado', function(){
	register::verifyLogin();
	$nome = filter_input(INPUT_POST, 'namestudents', FILTER_SANITIZE_STRING);
	$sala = filter_input(INPUT_POST, 'turma', FILTER_SANITIZE_STRING);
	$nota = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_STRING);
	$nota1 = filter_input(INPUT_POST, 'nota1', FILTER_SANITIZE_STRING);
	$nota2 = filter_input(INPUT_POST, 'nota2', FILTER_SANITIZE_STRING);
	$nota3 = filter_input(INPUT_POST, 'nota3', FILTER_SANITIZE_STRING);
	$nota = floatval(str_replace(",", ".", $nota));
	$nota1 = floatval(str_replace(",", ".", $nota1));
	$nota2 = floatval(str_replace(",", ".", $nota2));
	$nota3 = floatval(str_replace(",", ".", $nota3));

	$students = new alunos();
	$students->insert($nome, $sala, $nota, $nota1, $nota2, $nota3);

	$total = $nota + $nota1 + $nota2 + $nota3;
	$media = $total / 4;
	
	if($media >= 6){
		$results = "APROVADO";
	}else{
		$results = "REPROVADO";
	}

	$page = new Page;
	$page->setTpl("results", [
		"namestudent"=>$nome,
		"turma"=>$sala,
		"nota"=>str_replace(".", ",",$nota),
		"nota1"=>str_replace(".", ",",$nota1),
		"nota2"=>str_replace(".", ",",$nota2),
		"nota3"=>str_replace(".", ",",$nota3),
		"media"=>str_replace(".", ",",$media),
		"results"=>$results
	]);
	
});

$app->get('/register', function() {
	register::sessionIsset();
	$page = new Page();
	$page->setTpl("register");
});

$app->post('/registrado', function() {
	register::verifyLogin();
	register::sessionIsset();
	$desnome = filter_input(INPUT_POST, 'desnome', FILTER_SANITIZE_STRING);
	$deslogin = filter_input(INPUT_POST, 'deslogin', FILTER_SANITIZE_STRING);
	$desaddress = filter_input(INPUT_POST, 'desaddress', FILTER_SANITIZE_STRING);
	$despassword = filter_input(INPUT_POST, 'despassword', FILTER_SANITIZE_STRING);
	$desturma = filter_input(INPUT_POST, 'desturma', FILTER_SANITIZE_STRING);

	if($desnome  === "" || $deslogin === "" || $desaddress === "" || $despassword === "" || $desturma === ""){
		throw new \Exception("Preencha todos os campos!");
	}

	$cadastro = new register;
	$cadastro->insert($desnome, $deslogin, $desaddress, $despassword, $desturma);
	$page = new Page;
	$page->setTpl("registrado", [
		"desnome"=>$desnome
	]);
});

$app->get('/professor', function() {
	register::sessionIsset();
	$page = new Page;
	$page->setTpl("professores");
});

$app->get('/home', function(){
	register::verifyLogin();
	$page = new Page();
	$page->setTpl("home");
});

$app->get('/logout', function(){
	session_destroy();
	$page = new Page();
	$page->setTpl("logout");
});