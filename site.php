<?php
require_once "class/vendor/autoload.php";

use Students\Classes\Boletim;
use Students\Classes\Page;
use Students\Classes\Register;

$app->get('/', function () {
    $Register = new Register;

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);

    $results = $Register->listNoticias();
    $Page->setTpl("newinicio", [
        "results" => $results,
    ]);
});

$app->get('/noticia', function () {
    $Register = new Register;

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);
    $results = $Register->dadosNoticia($_GET["id"]);
    $Page->setTpl("noticia", [
        "results" => $results,
    ]);
});

$app->get('/login', function () {
    Register::issetLogin();
    $Register = new Register;

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => false,
        "headerAluno" => false,
        "headerProf" => false,
        "footer" => false,
    ]);

    $logout = isset($_GET['logout']) && $_GET['logout'] ? 1 : 0;
    $error = isset($_GET['error']) && $_GET['error'] ? 1 : 0;
    $Page->setTpl("login", [
        "error" => $error,
        "logout" => $logout,
    ]);
});

$app->post('/login', function () {
    $Register = new Register();

    $result = $Register->valilogin($_POST["deslogin"], $_POST["despassword"]);
    if ($result) {
        header("Location: /");
    } else {
        header("Location: /login?error=1");
    }
    die;
});

$app->get('/register', function () {
    Register::issetLogin();
    $Register = new Register;

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);

    $error = isset($_GET["error"]) ? 1 : 0;
    $errorcpf = isset($_GET["errorcpf"]) ? 1 : 0;
    $success = isset($_GET["success"]) ? 1 : 0;
    $Page->setTpl("register", [
        "error" => $error,
        "success" => $success,
        "errorcpf" => $errorcpf,
    ]);
});

$app->post('/register', function () {
    Register::issetLogin();
    if ($_POST["desnome"] == "" || $_POST["deslogin"] == "" || $_POST["desaddress"] == "" || $_POST["despassword"] === "") {
        header("Location: /register?error=1");
        die;
    }

    $cadastro = new Register;
    if ($cadastro->insert($_POST["desnome"], $_POST["deslogin"], $_POST["desaddress"], $_POST["despassword"], $_FILES['fileimage']['tmp_name'], $_POST["descpf"])) {
        header("Location: /register?success=1");
        die;
    } else {
        header("Location: /register?errorcpf=1");
        die;
    }

});

$app->get('/logout', function () {
    session_destroy();
    header("Location: /login?logout=1");
    die();
});

$app->get('/perfil', function () {
    $Register = new Register;
    $Boletim = new Boletim;
    Register::NOTissetLogin();
    $notas = [];
    $notasok = 0;

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);
    $materias = $Boletim->materiasGrafico($_SESSION["user"]["idstudent"]);
    $aluno = $Register->dadosLogin($_SESSION["user"]["idlogin"]);
    $idstudent = $_SESSION["user"]["idstudent"];
    if (isset($_GET["materia"])) {
        $results = $Boletim->graficoNotas($idstudent, $_GET["materia"]);
        foreach ($results AS $result) {
            $notas[$result["bimestre"]] = $result["M"];
        }
        $notasok = json_encode($notas);
    }
    $Page->setTpl("perfil", [
        "aluno" => $aluno,
        "materias" => $materias,
        "notas" => $notasok,
    ]);
});

$app->post('/perfil', function () {
    $Register = new Register;
    $Boletim = new Boletim;
    Register::NOTissetLogin();

});

$app->get('/infoaluno', function () {
    Register::NOTissetLogin();
    $Register = new Register;

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]); $Register = new Register;

    $aluno = $Register->dadosLogin($_SESSION["user"]["idlogin"]);
    $error = isset($_GET['error']) ? 1 : 0;
    $errorsenha = isset($_GET['errorsenha']) ? 1 : 0;
    $success = isset($_GET['success']) ? 1 : 0;
    $Page->setTpl("infoaluno", [
        "aluno" => $aluno,
        "success" => $success,
        "error" => $error,
        "errorsenha" => $errorsenha,
    ]);
});

$app->post('/infoaluno', function () {
    $Register = new Register;
    Register::NOTissetLogin();

    if (isset($_POST["desnome"])) {
        if ($_POST["desnome"] == "" || $_POST["desaddress"] == "") {
            header("Location: /infoaluno?error=1");
            die;
        }

        if (($_FILES["fileimage"]["tmp_name"]) == "") {
            $image = $_SESSION["user"]["desimage"];
        } else {
            $image = $_FILES["fileimage"]["tmp_name"];
        }
        $Register->editLoginA($_POST["desnome"], $_POST["desaddress"], $_POST["desnumber"], $image, $_SESSION["user"]["idlogin"]);
    }
    $Register->editPasswordA($_POST["antiga"], $_POST["nova"], $_SESSION["user"]["idlogin"]);
});

$app->get("/boletim", function () {
    Register::NOTissetLogin();
    $Register = new Register;
    $Boletim = new Boletim;
    $materias = $Boletim->notasAluno($_SESSION["user"]["id"], $_SESSION["user"]["idstudent"], $_GET["b"]);
    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);
    $Page->setTpl("boletimaluno", [
        "materias" => $materias,
        "nome" => $_SESSION["user"]["desnome"],
        "turma" => $_SESSION["user"]["descricao"],
    ]);
});

$app->get("/sobre", function () {
    $Register = new Register;
    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => false,
        "headerAluno" => false,
        "headerProf" => false,
        "footer" => false,
    ]);
    $Page->setTpl("sobre");
});

$app->get("/calendario", function () {
    $Register = new Register;
    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);
    $Page->setTpl("calender");
});