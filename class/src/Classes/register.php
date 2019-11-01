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

    public function insert($desnome, $deslogin, $desaddress, $despassword, $desturma){
        $conexao = new Sql;
        $passwordok = password_hash($despassword, PASSWORD_BCRYPT);
        $conexao->query("INSERT INTO tb_logins (desnome, deslogin, desaddress, despassword, desturma) VALUES ('$desnome', '$deslogin', '$desaddress', '$passwordok', '$desturma')");
        header("Location: /login");
        exit;
    }

    public function insertStudents($desnome, $descpf, $desturma){
        $conexao = new Sql;
        $conexao->query("INSERT INTO tb_students (desnome, descpf, desturma) VALUES ('$desnome', '$descpf', '$desturma')");
        header("Location: /adm/cadastrar/alunos");
        die;
    }

    public function insertProfessor($desnome, $descpf, $descodigo){
        $conexao = new Sql;
        $conexao->query("INSERT INTO tb_professores (desnome, descpf, descodigo) VALUES ('$desnome', '$descpf', '$descodigo')");
        header("Location: /adm/cadastrar/professor");
        die;
    }

    public function insertAdm($desnome, $deslogin, $despassword, $desemail, $dessession){
        $conexao = new Sql;
        $passwordok = password_hash($despassword, PASSWORD_BCRYPT);
        $conexao->query("INSERT INTO tb_adm (desnome, deslogin, despassword, desemail, dessession) VALUES ('$desnome', '$deslogin', '$passwordok', '$desemail', '$dessession')");
    }
    
    public function insertNoticias($desautor, $destitulo, $desdetails){
        $conexao = new Sql;
        $conexao->query("INSERT INTO tb_noticias (desautor, destitulo, desdetails) VALUES ('$desautor', '$destitulo', '$desdetails')");
        header("Location: /adm/noticias");
        die;
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
   
    public static function verifyLogin(){
        if(!isset($_SESSION['user'])){
            header("Location: /");
            die;
        }
    }

    public static function issetLogin(){
        if(isset($_SESSION['user'])){
            header("Location: /home");
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
        $results = $sql->select("SELECT * FROM tb_students");
        return($results);
    }

    public function listAllProfessores(){
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_professores");
        return($results);
    }

    public function listNoticias(){
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_noticias");
        return($results);
    }

}