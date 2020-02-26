<?php
require_once("class/vendor/autoload.php");

use Students\Classes\Page;
use Students\Classes\DB\Sql;
use Students\Classes\Register;
use Students\Classes\PageAdmin;

$app->get('/adm/noticias', function(){
	Register::verifyLoginAdm();
	$Page = new PageAdmin();
	$Register = new Register();

	$results = $Register->listNoticias();
	$Page->setTpl("noticias", [
		"noticias"=>$results
	]);
});


$app->get('/adm/novanoticia', function(){
	Register::verifyLoginAdm();
	$page = new PageAdmin();

	$error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
	$success = isset($_GET['success']) && $_GET['success'] ? 1 : 0;

	$page->setTpl("novaNoticia", [
		"error"=>$error,
		"success"=>$success
	]);
});

$app->post('/adm/novanoticia', function(){
	Register::verifyLoginAdm();
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
	Register::verifyLoginAdm();
	$page = new PageAdmin();
	$Register = new Register;

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
	Register::verifyLoginAdm();
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
	Register::verifyLoginAdm();
	$Register = new Register();

	$Register->deleteNoticia($_GET["id"]);
	header("Location: /adm/noticias");
	die;
});
