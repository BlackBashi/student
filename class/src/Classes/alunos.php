<?php

namespace Students\Classes;
use Students\Classes\Sql;

class alunos {
    
    
    

    public function __call($name, $args)
    {
        $method = substr($name, 0 , 3);
        $fieldName = substr($name, 3, strlen($name));
        switch($method)
        {
            case "get":
                return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
            break;
            case "set":
                $this->values[$fieldName] = $args[0];
            break;
        }
    }
  
    public function setData($data = array())
   {
       foreach ($data as $key => $value) {
           $this->{"set". $key} ($value);
       }
   }

   public function insert($nome, $turma, $nota, $nota1, $nota2, $nota3){
        $conexao = new Sql;
        $conexao->query("INSERT INTO tb_students (namestudent, turma, nota, nota1, nota2, nota3) VALUES ('$nome', '$turma', '$nota', '$nota1', '$nota2', '$nota3')");
   }

    public function setStudents(){
        $nome = filter_input(INPUT_POST, 'namestudents', FILTER_SANITIZE_STRING);
        $sala = filter_input(INPUT_POST, 'turma', FILTER_SANITIZE_STRING);
        $nota = filter_input(INPUT_POST, 'nota', FILTER_SANITIZE_STRING);
   }

    public static function media($nota, $nota1, $nota2, $nota3){
        $total = $nota + $nota1 + $nota2 + $nota3;
        $media = $total / 4;   
    }
}