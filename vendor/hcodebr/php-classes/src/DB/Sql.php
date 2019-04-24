<?php 

namespace Hcode\DB;

use PDO;

class Sql {

	const HOSTNAME = "127.0.0.1";
	const USERNAME = "padrao";
	const PASSWORD = "123456";
	const DBNAME = "db_ecommerce";

	private $conn;

	public function __construct()
	{

		$this->conn = new \PDO(
			"mysql:dbname=".Sql::DBNAME.";host=".Sql::HOSTNAME, 
			Sql::USERNAME,
			Sql::PASSWORD
		);
		$this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    	$this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

	}

	private function setParams($statement, $parameters = array())
	{

		foreach ($parameters as $key => $value) {
			
			$this->bindParam($statement, $key, $value);

		}

	}

	private function bindParam($statement, $key, $value)
	{

		$statement->bindParam($key, $value);

	}

	public function query($rawQuery, $params = array())
	{

		try{
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();
		} 
		catch(Exception $e){
			echo 'Exception -> ';
			var_dump($e->getMessage());
			exit;
		}
	}

	public function select($rawQuery, $params = array()):array
	{
		try{
		$stmt = $this->conn->prepare($rawQuery);

		$this->setParams($stmt, $params);

		$stmt->execute();

		return $stmt->fetchAll(\PDO::FETCH_ASSOC);
		}
		catch(Exception $e){
			echo 'Exception -> ';
			var_dump($e->getMessage());
			exit;
		}
	}

}

 ?>