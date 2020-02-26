<?php

namespace Students\Classes;
use Students\Classes\Sql;

if (session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

class Boletim {

    public function materias() {
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_materias");
        return $results;
    }

    public function turmas() {
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_turmas");
        return $results;
    }

    public function notas() {
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_notas");
        return $results;
    }

    public function addNotas($idturma, $idstudent, $idmateria, $idprofessor, $bimestre, $T = 1, $C = 1, $P = 1, $M = 1) {
        $sql = new Sql;

        $notas = $sql->select("SELECT
            *
        FROM tb_notas
        WHERE
            idstudent = '$idstudent'
        AND
            idmateria = '$idmateria'
        AND
            bimestre = '$bimestre'"
        );

        if (count($notas) == 0) {
            $query = "INSERT INTO tb_notas (idturma, idstudent, idmateria, idprofessor, bimestre, T, C, P, M)
            values (:idturma, :idstudent, :idmateria, :idprofessor, :bimestre, :T, :C, :P, :M)";
            $sql->query($query,
                array(
                    'idturma' => $idturma,
                    'idstudent' => $idstudent,
                    'idmateria' => $idmateria,
                    'idprofessor' => $idprofessor,
                    'bimestre' => $bimestre,
                    'T' => $T,
                    'C' => $C,
                    'P' => $P,
                    'M' => $M,
                )
            );
        } else {
            $query = "UPDATE tb_notas
            SET T = :T, C = :C, P = :P, M = :M
            WHERE idstudent = :idstudent AND idmateria = :idmateria AND bimestre = '$bimestre'";
            $sql->query($query,
                array(
                    'idstudent' => $idstudent,
                    'T' => $T,
                    'C' => $C,
                    'P' => $P,
                    'M' => $M,
                    "idmateria" => $idmateria,
                )
            );
        }
    }

    public function insertTurmas($descricao, $turno, $materias) {
        $sql = new Sql;

        $turmas = $sql->select("SELECT * FROM tb_turmas WHERE descricao = '$descricao'");
        if (count($turmas) == 0) {
            $turmaId = $sql->query(
                "INSERT INTO tb_turmas (descricao, turno, anoletivo) values (:descricao, :turno, :anoletivo)",
                array(
                    'descricao' => $descricao,
                    'turno' => $turno,
                    'anoletivo' => date('Y'),
                ),
                true
            );

            foreach ($materias AS $materia) {
                $sql->query(
                    "INSERT INTO tb_turmas_materias (idmateria, idturma) values (:idmateria, :idturma)",
                    array(
                        'idmateria' => $materia,
                        'idturma' => $turmaId,
                    )
                );
            }
            header("Location: /adm/addturma?success=1");
            die;
        } else {
            header("Location: /adm/addturma?error=1");
            die;
        }
    }

    public function getTurma($id) {
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_turmas WHERE id = '$id' ");
        return $results;
    }

    public function turmaMaterias($id) {
        $sql = new Sql;
        $query = "SELECT
            a.idmateria,
            b.descricao
        FROM tb_turmas_materias a
        INNER JOIN tb_materias b ON a.idmateria = b.id
        WHERE a.idturma = {$id}";

        $results = $sql->select($query);
        return $results;
    }

    public function notasAluno($idturma, $idstudent, $bimestre) {
        $sql = new Sql;
        switch ($bimestre) {
        case "1":
            $bimestre = "1º Bimestre";
            break;
        case "2":
            $bimestre = "2º Bimestre";
            break;
        case "3":
            $bimestre = "3º Bimestre";
            break;
        case "4":
            $bimestre = "4º Bimestre";
            break;
        }
        $query = "SELECT
            a.idmateria,
            b.descricao,
            c.M
        FROM tb_turmas_materias a
        INNER JOIN tb_materias b ON a.idmateria = b.id
        INNER JOIN tb_notas c ON b.id = c.idmateria
        WHERE a.idturma = {$idturma} AND c.idstudent = {$idstudent} AND bimestre = '$bimestre'";

        $results = $sql->select($query);
        return $results;
    }

    public function turmaProfessores($id) {
        $sql = new Sql;
        $query = "SELECT
            a.idturma,
            a.idprofessor,
            a.idmateria,
            b.desnome,
            c.descricao,
            b.idprof
        FROM tb_turmas_professores a
        INNER JOIN tb_professores b ON a.idprofessor = b.idprof
        INNER JOIN tb_materias c ON a.idmateria = c.id
        WHERE a.idturma = {$id}
        ORDER BY b.desnome ASC";

        $results = $sql->select($query);
        return $results;
    }

    public function addProfessor($idturma, $idmateria = "", $idprofessor) {
        $sql = new Sql;

        $results = $sql->query("INSERT INTO tb_turmas_professores (idturma, idmateria, idprofessor) values (:idturma, :idmateria, :idprofessor)",
            array(
                'idturma' => $idturma,
                'idmateria' => $idmateria,
                'idprofessor' => $idprofessor,
            )
        );
    }

    public function removeProfessor($id) {
        $Sql = new Sql;

        $Sql->query("DELETE FROM tb_turmas_professores WHERE idprofessor = '$id'");
    }

    public function removeTurma($id) {
        $Sql = new Sql;

        $Sql->query("SET FOREIGN_KEY_CHECKS=0");
        $Sql->query(" DELETE FROM tb_turmas WHERE id = '$id'");
        $Sql->query("SET FOREIGN_KEY_CHECKS=1");
    }

    public function editTurma($descricao, $turno, $anoletivo, $id) {
        $Sql = new Sql;

        $turmas = $Sql->select("SELECT * FROM tb_turmas WHERE descricao = '$descricao'");
        if (count($turmas) == 0 && $descricao != "") {
            $Sql->query("UPDATE tb_turmas SET descricao = :descricao, turno = :turno, anoletivo = :anoletivo WHERE id = :id",
                array(
                    'descricao' => $descricao,
                    'turno' => $turno,
                    'anoletivo' => $anoletivo,
                    'id' => $id,
                )
            );
            header("Location: /adm/editarTurma?id=" . $_POST["idturma"]);
            die;
        } else {
            header("Location: /adm/editarTurma?id=" . $id . "&error=1");
            die;
        }
    }

    public function pageTurma($page = 1, $itensPorPage = 12) {
        $start = ($page - 1) * $itensPorPage;

        $sql = new Sql;
        $query = "SELECT
            SQL_CALC_FOUND_ROWS *
        FROM tb_professores
        ORDER BY desnome ASC LIMIT $start,$itensPorPage";

        $results = $sql->select($query);
        $total = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        foreach ($results as &$row) {
            $values = $row;
        }

        return [
            "professores" => $results,
            "total" => $total[0]["nrtotal"],
            "pages" => ceil($total[0]["nrtotal"] / $itensPorPage),
        ];
    }

    public function pageStudents($page = 1, $itensPorPage = 12) {
        $start = ($page - 1) * $itensPorPage;

        $sql = new Sql;
        $query = "SELECT
            SQL_CALC_FOUND_ROWS a.idstudent, a.desnome, a.descpf, b.descricao
        FROM tb_students a
        INNER JOIN tb_turmas_students c ON a.idstudent = c.idstudent
        INNER JOIN tb_turmas b ON c.idturma = b.id
        ORDER BY desnome ASC LIMIT $start,$itensPorPage";

        $results = $sql->select($query);
        $total = $sql->select("SELECT FOUND_ROWS() AS nrtotal;");

        foreach ($results as &$row) {
            $values = $row;
        }

        return [
            "students" => $results,
            "total" => $total[0]["nrtotal"],
            "pages" => ceil($total[0]["nrtotal"] / $itensPorPage),
        ];
    }

    public function searchProf($nome) {
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_professores WHERE desnome LIKE '%{$nome}%' ");
        return ($results);
    }

    public function searchStudents($nome) {
        $sql = new Sql;
        $query = "SELECT
            a.idstudent,
            a.desnome,
            a.descpf,
            b.descricao
        FROM tb_students a
        INNER JOIN tb_turmas_students c ON a.idstudent = c.idstudent
        INNER JOIN tb_turmas b ON c.idturma = b.id
        WHERE desnome LIKE '%{$nome}%';";
        $results = $sql->select($query);
        return ($results);
    }

    public function professorTurmas($id) {
        $sql = new Sql;
        $query = "SELECT
            a.descricao,
            a.turno,
            a.anoletivo,
            a.id
        FROM tb_turmas a
        INNER JOIN tb_turmas_professores b ON a.id = b.idturma
        WHERE
            b.idprofessor = {$id}
        ORDER BY a.descricao ASC ";

        $results = $sql->select($query);
        return $results;
    }

    public function materiasDaTurma($idProfessor, $idTurma) {
        $sql = new Sql;
        $query = "SELECT
            a.descricao,
            b.idturma,
            b.idmateria,
            a.id
        FROM tb_materias a
        INNER JOIN tb_turmas_professores b ON b.idmateria = a.id
        WHERE b.idprofessor = {$idProfessor} AND b.idturma = {$idTurma}
        ORDER BY a.descricao ASC";

        $results = $sql->select($query);
        return ($results);
    }

    public function getNota($idstudent, $idmateria, $bimestre) {
        $Sql = new Sql;

        $query = "SELECT * FROM tb_notas WHERE idstudent = $idstudent AND idmateria= $idmateria AND bimestre = $bimestre";
        $results = $Sql->select($query);
        return $results;
    }

    public function listarNotas($idmateria, $idturma, $bimestre) {
        $Sql = new Sql;

        switch ($bimestre) {
        case "1":
            $bimestre = "1º Bimestre";
            break;
        case "2":
            $bimestre = "2º Bimestre";
            break;
        case "3":
            $bimestre = "3º Bimestre";
            break;
        case "4":
            $bimestre = "4º Bimestre";
            break;
        }

        $query = "SELECT
            *
        FROM tb_notas
        WHERE
            idmateria = $idmateria
        AND
            idturma = $idturma
        AND
            bimestre = '$bimestre'";

        $resultsNotas = count($Sql->select($query));

        $query = "SELECT
            *
        FROM tb_turmas_students
        WHERE
            idturma = $idturma";

        $resultsTotal = count($Sql->select($query));

        $query = "SELECT
            a.idstudent,
            a.desnome,
            d.T,
            d.C,
            d.P,
            d.M
        FROM tb_students a
        INNER JOIN tb_turmas_students c ON a.idstudent = c.idstudent
        INNER JOIN tb_turmas b ON c.idturma = b.id
        LEFT JOIN tb_notas d ON a.idstudent = d.idstudent AND d.idmateria = $idmateria AND d.bimestre = '$bimestre'
        WHERE
            c.idturma = $idturma
        ORDER BY
            a.desnome ASC ;";

        $results = $Sql->select($query);
        return ($results);
    }

    public function getMateria($idprofessor, $idturma) {
        $Sql = new Sql;
        $query = "SELECT
            *
        FROM tb_turmas_professores
        WHERE
            idprofessor = $idprofessor
        AND
            idturma = {$idturma}";

        $results = $Sql->select($query);
        if ($results) {
            return $results[0];
        }
        return $results;
    }

    public function graficoNotas($id, $idMateria) {
        $Sql = new Sql;
        $query = "SELECT
            M, bimestre
        FROM tb_notas
        WHERE
            idmateria = $idMateria
        AND
            idstudent = $id
        ";
        $results = $Sql->select($query);
        return $results;
    }

    public function materiasGrafico($idstudent) {
        $sql = new Sql;
        $query = "SELECT
            n.idmateria,
            m.descricao,
            m.id
        FROM tb_notas n
        INNER JOIN tb_materias m
        ON n.idmateria = m.id
        WHERE
            n.idstudent = {$idstudent}
        AND
            n.bimestre = '4º Bimestre'
        ";

        $results = $sql->select($query);
        return $results;
    }
}