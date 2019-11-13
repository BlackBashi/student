<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\alunos;
use Students\Classes\register;
use Students\Classes\PageAdmin;

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

	$error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
	$success = isset($_GET['success']) && $_GET['success'] ? 1 : 0;

	$page->setTpl("novaNoticia", [
		"error"=>$error,
		"success"=>$success
	]);
});

$app->post('/adm/novanoticia', function(){
	register::verifyLoginAdm();
	$Register = new Register();
	
	if($_POST['desautor'] === "" || $_POST['destitulo'] === "" || $_POST['desdetails'] === ""){
		header("Location: /adm/novanoticia?error=1");
		die;
	}
	$Register->insertNoticias($_POST['desautor'], $_POST['destitulo'], $_POST['desdetails'], $_FILES['fileimage']['tmp_name']);
	header("Location: /adm/novanoticia?success=1");
	die;
});

$app->get('/adm/editarnoticia', function(){
	register::verifyLoginAdm();
	$page = new PageAdmin();
	$Register = new register;

	$results = $Register->dadosNoticia($_GET["id"]);
	$error = isset($_GET["error"]) && $_GET["error"] ? 1 : 0;
	$success = isset($_GET["success"]) && $_GET["success"] ? 1 : 0;
	$page->setTpl("editarNoticia", [
		"results"=>$results,
		"error"=>$error,
		"success"=>$success
	]);
});

$app->post('/adm/editarnoticia', function(){
	register::verifyLoginAdm();
	$Register = new Register();

	if($_POST["desautor"] == "" || $_POST["destitulo"] == "" || $_POST["desdetails"] == ""){
		header("Location: /adm/editarnoticia?id={$_GET['id']}&error=1");
		die;
	}
	$Register->editNoticia($_POST['desautor'], $_POST['destitulo'], $_POST['desdetails'], $_GET["id"]);
	header("Location: /adm/editarnoticia?id={$_GET['id']}&success=1");
	die;
});

$app->get('/adm/deletarnoticia', function(){
	register::verifyLoginAdm();
	$Register = new Register();

	$Register->deleteNoticia($_GET["id"]);
	header("Location: /adm/noticias");
	die;
});
