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
   }

   public function valilogin($login, $senha){
        $sql = new Sql;
       
        $results = $sql->select("SELECT * FROM tb_logins  idperson WHERE deslogin = :LOGIN", array(
            ":LOGIN"=>$login
        ));
        
        if (count($results)) {
            $password = $results[0]["despassword"];
            $senharesult = password_verify($senha, $password);
            
            if($senharesult === false){
                throw new \Exception("Senha incorreta!");
            }else{
               $_SESSION['user'] = $results[0];
               header("Location: /calcular");
               dd($_SESSION);
            }

        } else {
            throw new \Exception("Senha incorreta!");
        }
   }
   
    public static function verifyLogin(){
        if(!isset($_SESSION['user'])){
            header("Location: /");
            die;
        }
   }

    public static function sessionIsset(){
        if(isset($_SESSION['user'])){
            header("Location: /home");
            die;
        }
    }

}