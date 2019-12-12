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

    public function insertTurmas($descricao, $turno, $materias){
        $sql = new Sql;

        $turmas = $sql->select("SELECT * FROM tb_turmas WHERE descricao = '$descricao'");
        if(count($turmas) == 0){
            $turmaId = $sql->query(
                "INSERT INTO tb_turmas (descricao, turno, anoletivo) values (:descricao, :turno, :anoletivo)",
                array(
                    'descricao'=> $descricao,
                    'turno'=> $turno,
                    'anoletivo'=> date('Y')
                ),
                true
            );

            foreach ($materias AS $materia) {
                $sql->query(
                    "INSERT INTO tb_turmas_materias (idmateria, idturma) values (:idmateria, :idturma)",
                    array(
                        'idmateria'=> $materia,
                        'idturma'=> $turmaId
                    )
                );
            }
            header("Location: /adm/addturma?success=1");
            die;
        }else{
            header("Location: /adm/addturma?error=1");
            die;
        }
    }

    public function getTurma($id){
        $sql = new Sql;

        $results = $sql->select("SELECT * FROM tb_turmas WHERE id = '$id' ");
        return $results;
    }

    public function turmaMaterias($id){
        $sql = new Sql;

        $results = $sql->select("SELECT a.idmateria, b.descricao FROM tb_turmas_materias a INNER JOIN tb_materias b ON a.idmateria = b.id WHERE a.idturma = '$id'");
        return $results;
    }

    public function turmaProfessores($id){
        $sql = new Sql;

        $results = $sql->select("SELECT a.idturma, a.idprofessor, a.idmateria, b.desnome, c.descricao, b.idprof FROM tb_turmas_professores a INNER JOIN tb_professores b ON a.idprofessor = b.idprof INNER JOIN tb_materias c ON a.idmateria = c.id WHERE a.idturma = '$id'");
        return $results;
    }

    public function addProfessor($idturma, $idmateria = "", $idprofessor ){
        $sql = new Sql;

        $results = $sql->query("INSERT INTO tb_turmas_professores (idturma, idmateria, idprofessor) values (:idturma, :idmateria, :idprofessor)",
            array(
                'idturma'=> $idturma,
                'idmateria'=> $idmateria,
                'idprofessor'=> $idprofessor
            )
        );
    }

    public function removeProfessor($id){
        $Sql = new Sql;

        $Sql->query("DELETE FROM tb_turmas_professores WHERE idprofessor = '$id'");
    }

    public function editTurma($descricao, $turno, $anoletivo, $id){
        $Sql = new Sql;

        $Sql->query("UPDATE tb_turmas SET descricao = :descricao, turno = :turno, anoletivo = :anoletivo WHERE id = :id",
            array(
                'descricao'=>$descricao,
                'turno'=>$turno,
                'anoletivo'=>$anoletivo,
                'id'=>$id
            )
        );

        header("Location: /adm/editarTurma?id=" . $_POST["idturma"]);
	    die;
    }

}