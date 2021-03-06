<?php 

namespace Students\Classes;


class Sql{
    
    
    private $conn;

    public function __construct(){
        # apenas um compentario 2
        $results = parse_ini_file("db.ini");
        $this->conn = new \PDO("mysql:dbname=".$results['dbname'].";host=".$results['hostname'], $results['username'], $results['password']);
        $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        $this->query("SET NAMES utf8");
    }

    private function setParams($statement, $parameters = array()){
   
        foreach ($parameters as $key => $value) {
            $this->bindParam($statement, $key, $value);
        }
    }

    private function bindParam($statement, $key, $value){
        $statement->bindParam($key, $value);
    }

    public function query($rawQuery, $params = array(), $returnId = false){
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt,$params);
        $stmt->execute();
        if ($returnId) {
            return $this->conn->lastInsertId();
        }
    }

    public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}
}