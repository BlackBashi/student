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

    public function insert($desnome, $deslogin, $desaddress, $despassword, $desturma, $file = "", $descpf, $desnumber = ""){
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
            $conexao->query("INSERT INTO tb_logins (desnome, deslogin, desaddress, despassword, desturma, desimage, descpf, desnumber) VALUES ('$desnome', '$deslogin', '$desaddress', '$passwordok', '$desturma', '$novo_nome', '$descpf', '$desnumber')");
            return true;
        }else{
            return false;
        }
        
    }

    public function insertStudents($desnome, $descpf, $desturma){
        $conexao = new Sql;
        $conexao->query("INSERT INTO tb_students (desnome, descpf, desturma) VALUES ('$desnome', '$descpf', '$desturma')");
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
       
        $results = $sql->select("SELECT * FROM tb_logins  idlogin WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));
        
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
       
        $results = $sql->select("SELECT * FROM tb_professores  id WHERE descpf = :LOGIN", array(
            ":LOGIN"=>$login
        ));
       
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
        $results = $sql->select("SELECT * FROM tb_students ORDER BY desnome");
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
        $results = $sql->select("SELECT * FROM tb_students WHERE idstudent = :ID", array(
            ":ID"=>$id
        ));
        return($results);
    }

    public function dadosLogin($id){
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_logins WHERE idlogin = :ID", array(
            ":ID"=>$id
        ));
        return($results);
    }

    public function dadosProfessor($id){
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_professores WHERE idprof = :ID", array(
            ":ID"=>$id
        ));
        return($results);
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
            $sql->query("UPDATE tb_logins SET desnome = :DESNOME, desaddress = :DESADDRESS, desimage = :DESIMAGE, desnumber = :DESNUMBER WHERE idlogin = :ID", array(
                ":DESNOME"=>$desnome,
                ":DESADDRESS"=>$desemail,
                ":DESNUMBER"=>$desnumber,
                ":DESIMAGE"=>$novo_nome,
                ":ID"=>$id
            ));
            header("Location: /infoaluno?success=1");
            
	        die;
        }else{
            $sql->query("UPDATE tb_logins SET desnome = :DESNOME, desaddress = :DESADDRESS, desnumber = :DESNUMBER WHERE idlogin = :ID", array(
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

    public function editAluno($desnome, $descpf, $desturma, $id){
        $sql = new Sql;
        $sql->query("UPDATE tb_students SET desnome = :DESNOME, descpf = :DESCPF, desturma = :DESTURMA WHERE idstudent = :ID", array(
            ":DESNOME"=>$desnome,
            ":DESCPF"=>$descpf,
            ":DESTURMA"=>$desturma,
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