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
    
    public function insertNoticias($desautor, $destitulo, $desdetails, $file){
        $conexao = new Sql;
        if(isset($file)){
            $extensão = strtolower(substr($file, -4)); //deixa tudo minusculo e as ultimas 4 letras.
            $novo_nome = md5(time()) . $extensão; //nome da imagem
            $diretorio = "/home/mauricio/students/arq/img/upload/";
            move_uploaded_file($file, $diretorio.$novo_nome); //faz o upload
        }
        $conexao->query("INSERT INTO tb_noticias (desautor, destitulo, desdetails, desimage) VALUES ('$desautor', '$destitulo', '$desdetails', '$novo_nome')");
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

    public function dadosNoticia($id){
        $sql = new Sql;
        $results = $sql->select("SELECT * FROM tb_noticias WHERE idnoticia = :ID", array(
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

    public function deleteNoticia($id){
        $sql = new Sql;
        $sql->query("DELETE FROM tb_noticias WHERE idnoticia = '$id' ");
    }
}