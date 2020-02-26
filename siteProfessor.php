<?php
require_once "class/vendor/autoload.php";

use Students\Classes\Boletim;
use Students\Classes\Page;
use Students\Classes\Register;

$app->get('/professor', function () {
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
    $Page->setTpl("loginProfessores", [
        "error" => $error,
        "logout" => $logout,
    ]);
});

$app->post('/professor', function () {
    $Register = new Register;

    $results = $Register->valiLoginProf($_POST["deslogin"], $_POST["despassword"]);
    if ($results) {
        header("Location: /");
        die;
    } else {
        header("Location: /professor?error=1");
        die;
    }
});

$app->get('/logoutprofessor', function () {
    session_destroy();
    header("Location: /professor?logout=1");
    die();
});

$app->get('/perfilProfessor', function () {
    $Register = new Register;
    Register::NOTissetLogin();

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);

    $professor = $Register->dadosProfessor($_SESSION["userProf"]["idprof"]);
    $Page->setTpl("perfilProfessor", [
        "desnome" => $professor[0]["desnome"],
        "descpf" => $professor[0]["descpf"],
        "desaddress" => $professor[0]["desaddress"],
        "desnumero" => $professor[0]["desnumero"],
        "turmas" => $professor,
    ]);
});

$app->get('/infoprofessor', function () {
    $Register = new Register;
    Register::NOTissetLogin();

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);

    $professor = $Register->dadosProfessor($_SESSION["userProf"]["idprof"]);
    $error = isset($_GET['error']) ? 1 : 0;
    $errorsenha = isset($_GET['errorsenha']) ? 1 : 0;
    $success = isset($_GET['success']) ? 1 : 0;
    $Page->setTpl("infoProfessor", [
        "desnome" => $professor[0]["desnome"],
        "descpf" => $professor[0]["descpf"],
        "desaddress" => $professor[0]["desaddress"],
        "desnumero" => $professor[0]["desnumero"],
        "success" => $success,
        "error" => $error,
        "errorsenha" => $errorsenha,
    ]);
});

$app->post('/infoprofessor', function () {
    $Register = new Register;
    Register::NOTissetLogin();

    if (isset($_POST["desnome"])) {
        if ($_POST["desnome"] == "" || $_POST["desaddress"] == "") {
            header("Location: /infoprofessor?error=1");
            die;
        }

        if (($_FILES["fileimage"]["tmp_name"]) == "") {
            $image = $_SESSION["userProf"]["desimage"];
        } else {
            $image = $_FILES["fileimage"]["tmp_name"];
        }
        $Register->editLoginP($_POST["desnome"], $_POST["desaddress"], $_POST["desnumber"], $image, $_SESSION["userProf"]["idprof"]);
    }
    $Register->editPasswordP($_POST["antiga"], $_POST["nova"], $_SESSION["userProf"]["idprof"]);
});

$app->get("/salas", function () {
    $Register = new Register;
    $Boletim = new Boletim;
    Register::NOTissetLogin();

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);

    $turmas = $Boletim->professorTurmas($_SESSION["userProf"]["idprof"]);

    $Page->setTpl("salas", [
        "turmas" => $turmas,
    ]);
});

$app->get("/sala", function () {
    $Register = new Register;
    $Boletim = new Boletim;
    Register::NOTissetLogin();

    $header = $Register->verifyHeader();
    $Page = new Page([
        "header" => $header['user'],
        "headerAluno" => $header['aluno'],
        "headerProf" => $header['professor'],
    ]);
    $materia = $Boletim->getMateria($_SESSION["userProf"]["idprof"], $_GET["turma"]);
    $dados = $Boletim->getTurma($_GET['turma']);
    $alunos = $Boletim->listarNotas($materia["idmateria"], $_GET['turma'], $_GET["b"]);
    $materias = $Boletim->materiasDaTurma($_SESSION["userProf"]["idprof"], $_GET["turma"]);

    // dd($alunos);

    foreach ($alunos as $key => $value) {
        if (!isset($alunos[$key]["T"])) {
            $alunos[$key]["T"] = 6;
        }
    }
    foreach ($alunos as $key => $value) {
        if (!isset($alunos[$key]["C"])) {
            $alunos[$key]["C"] = 6;
        }
    }
    foreach ($alunos as $key => $value) {
        if (!isset($alunos[$key]["P"])) {
            $alunos[$key]["P"] = 6;
        }
    }
    foreach ($alunos as $key => $value) {
        if (!isset($alunos[$key]["M"])) {
            $alunos[$key]["M"] = 6;
        }
    }
    $Page->setTpl("boletimprof", [
        "materias" => $materias,
        "idprof" => $_SESSION["userProf"]["idprof"],
        "nome" => $dados[0]["descricao"],
        "idturma" => $dados[0]["id"],
        "alunos" => $alunos,
        "id" => $_GET["turma"],
        "bimestre" => $_GET["b"],
    ]);
});

$app->post("/sala", function () {
    $Boletim = new Boletim;
    $dados['id'] = $_POST['id'];
    $dados['nota'] = $_POST['nota'];
    $dados['bimestre'] = $_POST['bimestre'];
    $dados['idturma'] = $_POST['idturma'];
    $dados['idmateria'] = $_POST['idmateria'];
    $dados['idprof'] = $_POST['idprof'];
    $dados['tipo'] = $_POST['tipo'];
    $notas = $Boletim->getNota($dados['id'], $dados["idmateria"], $dados["bimestre"]);

    if ($dados['tipo'] == 'T') {
        $T = $dados['nota'];
    } else {
        if (isset($notas[0]["T"])) {
            $T = $notas[0]["T"];
        } else {
            $T = 6;
        }
    }
    if ($dados['tipo'] == 'C') {
        $C = $dados['nota'];
    } else {
        if (isset($notas[0]["C"])) {
            $C = $notas[0]["C"];
        } else {
            $C = 6;
        }
    }
    if ($dados['tipo'] == 'P') {
        $P = $dados['nota'];
    } else {
        if (isset($notas[0]["P"])) {
            $P = $notas[0]["P"];
        } else {
            $P = 6;
        }
    }
    switch ($dados['bimestre']) {
    case "1":
        $dados['bimestre'] = "1º Bimestre";
        break;
    case "2":
        $dados['bimestre'] = "2º Bimestre";
        break;
    case "3":
        $dados['bimestre'] = "3º Bimestre";
        break;
    case "4":
        $dados['bimestre'] = "4º Bimestre";
        break;
    }

    $M = ($T + $C + $P) / 3;
    $M = round($M, 2);
    $Boletim->addNotas($dados['idturma'], $dados['id'], $dados['idmateria'], $dados['idprof'], $dados['bimestre'], $T, $C, $P, $M);
});