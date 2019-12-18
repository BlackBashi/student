<?php 

namespace Students\Classes;


class Sql{
    
    public function __construct(){
        $results = parse_ini_file("db.ini");
        $this->conn = new \PDO(
			"mysql:dbname=".$results["dbname"].";host=".$results["hostname"], $results["username"], $results["password"]
		);
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

    public function query($rawQuery, $params = array()){
        $stmt = $this->conn->prepare($rawQuery);
        $this->setParams($stmt,$params);
        $stmt->execute();
    }

    public function select($rawQuery, $params = array()):array
	{

		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);

	}
}