<?php  

/// essa classe traz todas as funcoes do PDO
class Sql extends PDO {

	// protegendo a conexao = apenas esta classe ve
	Private $conn;

    // função para conectar automaticamente ao banco
	Public function __construct() {

		$this->conn= New PDO("sqlsrv:Database=dbphp7;server=localhost\SQLEXPRESS;connectionPooling=0","sa","joshua");
	}

	Private function setParams($statment,$parameters=array()) {

		foreach ($parameters as $key => $value) {

			$this->setParam($key,$value);
		
		}

	}

	// para apenas receber um valor e nao um array
	Private function setParam($statment,$key,$value) {

		$statment->bindParam($key,$value);

	}

	// $rawquery - recebe a query bruta , $param ja sabemos que recebermos um array
	Public function query($rawquery,$params=array()) {

		$stmt=$this->conn->prepare($rawquery);

		$this->setParams($stmt,$params);

		$stmt->execute();

		return $stmt;
	

	}

	Public function Select($rawquery,$params=array()):array 
	{

		$stmt=$this->query($rawquery,$params);

		return $stmt->fetchAll(PDO::FETCH_ASSOC);


	}


}


?>