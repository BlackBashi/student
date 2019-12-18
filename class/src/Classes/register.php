<?php

namespace Students\Classes;
use Students\Classes\Sql;


if (session_id() == '' || !isset($_SESSION)) {
    // session isn't started
    session_start();
}

class register {
  
    public function setData($data = array())
   {
       foreach ($data as $key => $value) {
           $this->{"set". $key} ($value);
       }
   }

    public function insert($desnome, $deslogin, $desaddress, $despassword, $file = "", $descpf, $desnumber = ""){
        $conexao = new Sql;
        $results = $conexao->select("SELECT * FROM tb_students  idstudent WHERE descpf = :CPF", array(
            ":CPF"=>$descpf
        ));
        if(count($results)){
            if(isset($file)){
                $extensão = strtolower(substr($file, -4)); //deixa tudo minusculo e as ultimas 4 letras.
                $novo_nome = md5(time()) . $extensão; //nome da imagem
                $diretorio = "/home/mauricio/www/student/arq/img/upload/perfil/";
                move_uploaded_file($file, $diretorio.$novo_nome); //faz o upload
            }
            $passwordok = password_hash($despassword, PASSWORD_BCRYPT);
            $conexao->query("INSERT INTO tb_logins (desnomelogin, deslogin, desaddress, despassword, desimage, descpf, desnumber) VALUES ('$desnome', '$deslogin', '$desaddress', '$passwordok', '$novo_nome', '$descpf', '$desnumber')");
            return true;
        }else{
            return false;
        }
        
    }

    public function insertStudents($desnome, $descpf, $turmaId){
        $Sql = new Sql;
        $turmas = $Sql->select("SELECT * FROM tb_students WHERE descpf = '$descpf'");
        if(count($turmas) == 0){
            $idstudent = $Sql->query(
                "INSERT INTO tb_students (desnome, descpf) values (:desnome, :descpf)",
                array(
                    'desnome'=> $desnome,
                    'descpf'=> $descpf
                ),
                true
            );
            $Sql->query("SET FOREIGN_KEY_CHECKS=0");
            $Sql->query(
                "INSERT INTO tb_turmas_students (idstudent, idturma) values (:idstudent, :idturma)",
                array(
                    'idstudent'=> $idstudent,
                    'idturma'=> $turmaId
                )
            );
            $Sql->query("SET FOREIGN_KEY_CHECKS=1");
            header("Location: /adm/cadastrar/alunos?success=1");
            die;
        }else{
            header("Location: /adm/cadastrar/alunos?error=1");
            die;
        }
    }

    public function insertProfessor($desnome, $descpf, $descodigo){
        $conexao = new Sql;
        $conexao->query("INSERT INTO tb_professores (desnome, descpf, descodigo) VALUES ('$desnome', '$descpf', '$descodigo')");
    }

    public function insertAdm($desnome, $deslogin, $despassword, $desemail, $dessession){
        $conexao = new Sql;
        $passwordok = password_hash($despassword, PASSWORD_BCRYPT);
        $conexao->query("INSERT INTO tb_adm (desnome, deslogin, despassword, desemail, dessession) VALUES ('$desnome', '$deslogin', '$passwordok', '$desemail', '$dessession')");
    }
    
    public function insertNoticias($desautor, $destitulo, $desdetails, $file){
        $conexao = new Sql;
        if(isset($file)){
            $extensão = strtolower(substr($file, -4)); //deixa tudo minusculo e as ultimas 4 letras.
            $novo_nome = md5(time()) . $extensão; //nome da imagem
            $diretorio = "/home/mauricio/www/student/arq/img/upload/";
            move_uploaded_file($file, $diretorio.$novo_nome); //faz o upload
        }
        $conexao->query("INSERT INTO tb_noticias (desautor, destitulo, desdetails, desimage) VALUES ('$desautor', '$destitulo', '$desdetails', '$novo_nome')");
    }

    public function valilogin($login, $senha){
        $sql = new Sql;
       
        $results = $sql->select(
            "SELECT a.idstudent, a.desnome, a.descpf, b.descricao, d.desnumber, d.desnomelogin, d.desaddress, d.idlogin, d.deslogin, d.desimage, d.despassword FROM tb_students a
            INNER JOIN tb_turmas_students c ON a.idstudent = c.idstudent 
            INNER JOIN tb_turmas b ON c.idturma = b.id
            INNER JOIN tb_logins d ON a.descpf = d.descpf WHERE d.deslogin = :deslogin",
            array(
                ":deslogin"=>$login
            )
        );

        if (count($results)) {
            $password = $results[0]["despassword"];
            $senharesult = password_verify($senha, $password);
            
            if ($senharesult === false){
                return false;
                header("Location: /login?error=1");
                die;
            }else{
               $_SESSION['user'] = $results[0];
               header("Location: /home");
               return 1;
            }

        } else {
            return false;
            //throw new \Exception("Senha incorreta!");
        }
    }



    public function valiLoginAdm($login, $senha){
        $sql = new Sql;
       
        $results = $sql->select("SELECT * FROM tb_adm  id WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));
        
        if (count($results)) {
            $password = $results[0]["despassword"];
            $senharesult = password_verify($senha, $password);
            
            if($senharesult === false){
                return false;
                header("Location: /adm/login?error=1");
                die;
            }else{
               $_SESSION['userAdm'] = $results[0];
               header("Location: /adm");
               return 1;
            }

        } else {
            return false;
        }
    }

    public function valiLoginProf($login, $senha){
        $sql = new Sql;
        $query = "SELECT 
            a.idturma, 
            a.idprofessor, 
            a.idmateria, 
            b.desnome, 
            c.descricao, 
            c.turno, 
            c.anoletivo, 
            b.idprof, 
            b.descpf, 
            b.desaddress, 
            b.desnumero, 
            b.desnome, 
            b.descodigo, 
            b.desimage, 
            b.desnumero, 
            b.despassword 
        FROM  tb_professores b 
        INNER JOIN tb_turmas_professores a ON  a.idprofessor = b.idprof 
        INNER JOIN tb_turmas c ON a.idturma = c.id 
        WHERE b.descpf = '{$login}'";
       
        $results = $sql->select($query);
       
        if (count($results)) {
            $codigo = $results[0]["descodigo"];
            $password = $results[0]["despassword"];

            $ok = password_verify($senha, $password);
            
            if($senha == $codigo || $ok == true){
                $_SESSION['userProf'] = $results[0];
                header("Location: /");
                return 1;
            }else{
                return false;
                header("Location: /professor?error=1");
                die;
            }

        } else {
            return false;
        }
    }
   
    /*public static function verifyLogin(){
        if(!isset($_SESSION['user']) || !isset($_SESSION['userProf']) ){
            header("Location: /");
            die;
        }
    }*/

    public static function issetLogin(){
        if(isset($_SESSION['user']) || isset($_SESSION['userProf'])){
            header("Location: /");
            die;
        }
    }

    public static function NOTissetLogin(){
        if(!isset($_SESSION['user']) && !isset($_SESSION['userProf'])){
            header("Location: /login");
            die;
        }
    }

    public static function verifyLoginAdm(){
        if(isset($_SESSION["userAdm"])){
            if($_SESSION["userAdm"]["dessession"] < 1){
                header("Location: /adm/login");
                die;
            }
        }else{
            header("Location: /adm/login");
            die;
        }
        
    }

    public function verifyHeader(){
        $result = array(
            'user'=> false,
            'aluno'=> false,
            'professor'=> false
        );
        if(!isset($_SESSION["user"]) && !isset($_SESSION["userProf"])){
            $result['user'] = true;
        }
        if(isset($_SESSION["user"])){
            $result['aluno'] = true;
        }
        if(isset($_SESSION["userProf"])){
            $result['professor'] = true;
        }

        return $result;
    }

    public static function issetLoginAdm(){
        if(isset($_SESSION["userAdm"])){
            if($_SESSION["userAdm"]["dessession"] >= 1){
                header("Location: /adm");
                die;
            }
        }else{
            header("Location: /adm/login");
        }    
    }

    public function listAllStudents(){
        $sql = new Sql;
        $results = $sql->select("SELECT a.idstudent, a.desnome, a.descpf, b.descricao FROM tb_students a INNER JOIN tb_turmas_students c ON a.idstudent = c.idstudent INNER JOIN tb_turmas b ON c.idturma = b.id ORDER BY a.desnome ASC ;");
        return($results);
    }

    public function listStudentsTurma($id){
        $sql = new Sql;
        $results = $sql->select("SELECT a.idstudent, a.desnome, a.descpf, b.descricao FROM tb_students a INNER JOIN tb_turmas_students c ON a.idstudent = c.idstudent INNER JOIN tb_turmas b ON c.idturma = b.id WHERE c.idturma = $id ORDER BY a.desnome ASC ;");
        return($results);
    }

    public function listAllProfessores(){
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_professores ORDER BY desnome");
        return($results);
    }

    public function listNoticias(){
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_noticias ORDER BY idnoticia DESC");
        return($results);
    }

    public function dadosNoticia($id){
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_noticias WHERE idnoticia = :ID", array(
            ":ID"=>$id
        ));
        return($results);
    }

    public function dadosAluno($id){
        $sql = new Sql;
        $results = $sql->select(
            "SELECT a.idstudent, a.desnome, a.descpf, b.descricao, d.desnumber, d.desaddress, d.desnomelogin, d.deslogin FROM tb_students a
            INNER JOIN tb_turmas_students c ON a.idstudent = c.idstudent 
            INNER JOIN tb_turmas b ON c.idturma = b.id
            INNER JOIN tb_logins d ON a.descpf = d.descpf WHERE a.idstudent = :ID",
            array(
                ":ID"=>$id
            )
        );
        return($results);
    }

    public function dadosLogin($id){
        $sql = new Sql;
        $results = $sql->select("SELECT a.idstudent, a.desnome, a.descpf, b.descricao, d.desnumber, d.desnomelogin, d.desaddress, d.deslogin FROM tb_students a
            INNER JOIN tb_turmas_students c ON a.idstudent = c.idstudent 
            INNER JOIN tb_turmas b ON c.idturma = b.id
            INNER JOIN tb_logins d ON a.descpf = d.descpf WHERE d.idlogin = :ID",
            array(
                ":ID"=>$id
            )
        );
        return($results);
    }

    public function dadosProfessor($id){
        $sql = new Sql;
        $results = $sql->select("SELECT a.idturma, a.idprofessor, a.idmateria, b.desnome, c.descricao, c.turno, c.anoletivo, b.idprof, b.descpf, b.desaddress, b.desnumero FROM  tb_professores b INNER JOIN tb_turmas_professores a ON a.idprofessor = b.idprof INNER JOIN tb_turmas c ON a.idturma = c.id WHERE b.idprof = '$id'");
        return $results;
    }

    public function editNoticia($desautor, $destitulo, $desdetails, $id){
        $sql = new Sql;
        $sql->query("UPDATE tb_noticias SET desautor = :DESAUTOR, destitulo = :DESTITULO, desdetails = :DESDETAILS WHERE idnoticia = :ID", array(
            ":DESAUTOR"=>$desautor,
            ":DESTITULO"=>$destitulo,
            ":DESDETAILS"=>$desdetails,
            ":ID"=>$id
        ));
    }

    public function editLoginA($desnome, $desemail, $desnumber, $file, $id){
        $sql = new Sql;
        $começo = substr($file, 0, 4);
        if($começo == "/tmp"){
            $extensão = strtolower(substr($file, -4)); //deixa tudo minusculo e as ultimas 4 letras.
            $novo_nome = md5(time()) . $extensão; //nome da imagem
            $diretorio = "/home/mauricio/www/student/arq/img/upload/perfil/";
            move_uploaded_file($file, $diretorio.$novo_nome); //faz o upload
            $sql->query("UPDATE tb_logins SET desnomelogin = :DESNOME, desaddress = :DESADDRESS, desimage = :DESIMAGE, desnumber = :DESNUMBER WHERE idlogin = :ID", array(
                ":DESNOME"=>$desnome,
                ":DESADDRESS"=>$desemail,
                ":DESNUMBER"=>$desnumber,
                ":DESIMAGE"=>$novo_nome,
                ":ID"=>$id
            ));
            header("Location: /infoaluno?success=1");
            
	        die;
        }else{
            $sql->query("UPDATE tb_logins SET desnomelogin = :DESNOME, desaddress = :DESADDRESS, desnumber = :DESNUMBER WHERE idlogin = :ID", array(
                ":DESNOME"=>$desnome,
                ":DESADDRESS"=>$desemail,
                ":DESNUMBER"=>$desnumber,
                ":ID"=>$id
            ));
            header("Location: /infoaluno?success=1");
	        die;
        }
    } 

    public function editLoginP($desnome, $desemail, $desnumber, $file, $id){
        $sql = new Sql;
        $começo = substr($file, 0, 4);
        if($começo == "/tmp"){
            $extensão = strtolower(substr($file, -4)); //deixa tudo minusculo e as ultimas 4 letras.
            $novo_nome = md5(time()) . $extensão; //nome da imagem
            $diretorio = "/home/mauricio/www/student/arq/img/upload/perfil/";
            move_uploaded_file($file, $diretorio.$novo_nome); //faz o upload
            $sql->query("UPDATE tb_professores SET desnome = :DESNOME, desaddress = :DESADDRESS, desimage = :DESIMAGE, desnumero = :DESNUMBER WHERE idprof = :ID", array(
                ":DESNOME"=>$desnome,
                ":DESADDRESS"=>$desemail,
                ":DESNUMBER"=>$desnumber,
                ":DESIMAGE"=>$novo_nome,
                ":ID"=>$id
            ));
            header("Location: /infoprofessor?success=1");
            
	        die;
        }else{
            $sql->query("UPDATE tb_professores SET desnome = :DESNOME, desaddress = :DESADDRESS, desnumero = :DESNUMBER WHERE idprof = :ID", array(
                ":DESNOME"=>$desnome,
                ":DESADDRESS"=>$desemail,
                ":DESNUMBER"=>$desnumber,
                ":ID"=>$id
            ));
            header("Location: /infoprofessor?success=1");
	        die;
        }
    }

    public function editPasswordA($antiga, $nova, $login){
         $sql = new Sql;
       
        $results = $sql->select("SELECT * FROM tb_logins  id WHERE idlogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));
        $password = $results[0]["despassword"];
        if(password_verify($antiga, $password)){
            $passwordok = password_hash($nova, PASSWORD_BCRYPT);
            $sql->query("UPDATE tb_logins SET despassword = :DESPASSWORD WHERE idlogin = :ID", array(
                ":DESPASSWORD"=>$passwordok,
                ":ID"=>$login
            ));
            header("Location: /infoaluno?success=1");
            die;
        }else{
            header("Location: /infoaluno?errorsenha=1");
            die;
        }

    }

    public function editPasswordP($antiga, $nova, $login){
        $sql = new Sql;
      
       $results = $sql->select("SELECT * FROM tb_professores id WHERE idprof = :LOGIN", array(
           ":LOGIN"=>$login
       ));
       $codigo = $results[0]["descodigo"];
       $password = $results[0]["despassword"];
       if($antiga == $codigo || password_verify($antiga, $password)){
           $passwordok = password_hash($nova, PASSWORD_BCRYPT);
           $sql->query("UPDATE tb_professores SET despassword = :DESPASSWORD WHERE idprof = :ID", array(
               ":DESPASSWORD"=>$passwordok,
               ":ID"=>$login
           ));
           header("Location: /infoprofessor?success=1");
           die;
       }else{
           header("Location: /infoprofessor?errorsenha=1");
           die;
       }

   }

    public function editAluno($desnome, $descpf,  $id){
        $sql = new Sql;
        $sql->query("UPDATE tb_students SET desnome = :DESNOME, descpf = :DESCPF WHERE idstudent = :ID", array(
            ":DESNOME"=>$desnome,
            ":DESCPF"=>$descpf,
            ":ID"=>$id
        ));
    }

    public function editProfessor($desnome, $descpf, $descodigo, $id){
        $sql = new Sql;
        $sql->query("UPDATE tb_professores SET desnome = :DESNOME, descpf = :DESCPF, descodigo = :DESCODIGO WHERE idprof = :ID", array(
            ":DESNOME"=>$desnome,
            ":DESCPF"=>$descpf,
            ":DESCODIGO"=>$descodigo,
            ":ID"=>$id
        ));
    }

    public function deleteNoticia($id){
        $sql = new Sql;
        $sql->query("DELETE FROM tb_noticias WHERE idnoticia = '$id' ");
    }
    public function deleteAluno($id){
        $sql = new Sql;
        $sql->query("DELETE FROM tb_students WHERE idstudent = '$id' ");
    }

    public function deleteProfessor($id){
        $sql = new Sql;
        $sql->query("DELETE FROM tb_professores WHERE idprof = '$id' ");
    }

}