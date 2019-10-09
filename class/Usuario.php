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