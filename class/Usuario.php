<?php  

Class Usuario {

	Private $idusuario;
	Private $deslogin;
	Private $dessenha;
	Private $dtcadastro;

	Public function getIdusuario() {

		return $this->idusuario;
	}
	Public function setIdusuario($value) {

		$this->idusuario=$value;
	}

	Public function getDeslogin() {

		return $this->deslogin;
	}
	Public function setDeslogin($value) {

		$this->deslogin=$value;
	}
	Public function getDessenha() {

		return $this->dessenha;
	}
	Public function setDessenha($value) {

		$this->dessenha=$value;
	}

	Public function getDtcadastro() {

		return $this->dtcadastro;
	}
	Public function setDtcadastro($value) {

		$this->dtcadastro=$value;
	}

	/// um metodo para carregar um registro do banco

	Public function loadByid($id) {

		$sql= New Sql();
		$result=$sql->select("SELECT * FROM tb_usuarios where idusuario=:ID", array(
			":ID"=>$id

		));

		if(count($result)>0) {

			/// vou pegar a primeira linha do array - posicao zero

			$row= $result[0];

			// vou mandar os dados para os meus gets e sets

			$this->setIdusuario($row["idusuario"]);
			$this->setDeslogin($row["deslogin"]);
			$this->setDessenha($row["dessenha"]);
			$this->setDtcadastro(New Datetime($row["dtcadastro"]));

		}
	}

	/// função para trazer todos os registros da tabela
	// sendo estatico nao preciso instanciar quando for chamado / ver no index.php como chamo
	Public static function getList() {

		$sql=New Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

	}

	Public static function search($login) {
		$sql=New Sql();
		return $sql->select("SELECT * FROM tb_usuarios WHERE deslogin LIKE :SEARCH ORDER BY deslogin",array(
			':SEARCH'=>"%".$login."%"

		));
	}

	/// função para autenticar o usuario - login e senha
	// nao pode ser estatico pois usarei outras classes get e seters da vida

	Public function login($login,$password){


		$sql= New Sql();
		$result=$sql->select("SELECT * FROM tb_usuarios WHERE deslogin=:LOGIN AND dessenha=:PASSWORD", array(
			":LOGIN"=>$login,
			":PASSWORD"=>$password

		));

		if(count($result)>0) {

			/// vou pegar a primeira linha do array - posicao zero

			$row= $result[0];

			// vou mandar os dados para os meus gets e sets

			$this->setIdusuario($row["idusuario"]);
			$this->setDeslogin($row["deslogin"]);
			$this->setDessenha($row["dessenha"]);
			$this->setDtcadastro(New Datetime($row["dtcadastro"]));

		}else {

			throw new Exception("Login e/ou Senha inválidos.");
			
		}
		


	}

	Public function __toString() {

		return json_encode(array(
			"idusuario"=>$this->getIdusuario(),
			"deslogin"=>$this->getDeslogin(),
			"dessenha"=>$this->getDessenha(),
			"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")





		));
	}
}

?>