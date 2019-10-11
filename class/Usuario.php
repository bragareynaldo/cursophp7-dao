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

			//$row= $result[0];

			// vou mandar os dados para os meus gets e sets

			$this->setData($result[0]);
			
			//$this->setIdusuario($row["idusuario"]);
			//$this->setDeslogin($row["deslogin"]);
			//$this->setDessenha($row["dessenha"]);
			//$this->setDtcadastro(New Datetime($row["dtcadastro"]));

		}
	}

	/// função para trazer todos os registros da tabela
	// sendo estatico nao preciso instanciar quando for chamado / ver no index.php como chamo
	Public static function getList() {

		$sql=New Sql();
		return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");

	}
    
    Public static function getUltimo() {

		$sql=New Sql();
		return $sql->select("SELECT * FROM tb_usuarios where idusuario=(SELECT MAX(idusuario) FROM tb_usuarios)");

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

			//$row= $result[0];

			// vou mandar os dados para os meus gets e sets

			$this->setData($result[0]);

			//$this->setIdusuario($row["idusuario"]);
			//$this->setDeslogin($row["deslogin"]);
			//$this->setDessenha($row["dessenha"]);
			//$this->setDtcadastro(New Datetime($row["dtcadastro"]));

		}else {

			throw new Exception("Login e/ou Senha inválidos.");
			
		}
		


	}

	Public function setData($data){

		$this->setIdusuario($data["idusuario"]);
		$this->setDeslogin($data["deslogin"]);
		$this->setDessenha($data["dessenha"]);
		$this->setDtcadastro(New Datetime($data["dtcadastro"]));



	}


	/// classe para inserir novo registro

	Public function insert(){

		$sql=New Sql();

		// para mysql - FUNCIONA OK
		//$result = $sql->select("CALL sp_usuarios_insert(:LOGIN,:PASSWORD)", array(

		// para sqlserver - NAO ESTAVA FUNCIONANDO
		//$result = $sql->select("EXECUTE sp_usuarios_insert(:LOGIN,:PASSWORD)", array(			

		// vamos testar sem procedures
		$result = $sql->select("INSERT INTO tb_usuarios (deslogin,dessenha) VALUES (:LOGIN,:PASSWORD)", array(			


			":LOGIN"=>$this->getDeslogin(),
			":PASSWORD"=>$this->getDessenha()	

		));
        
        // comecando uma solução de select
        // criei o getUltimo para obter o ultimo registro gravado
        $sql=New Sql();
        $result=Usuario::getUltimo();


		/// acho que o erro é porque apos insert não ha select em cursor para display
		/// modificar o sp_ para uma função dentro da aplicação
		/// toda vez que incluir ou alterar dar refresh no array

		
		if(count($result)>0) {

			
			$this->setData($result[0]);


		}else {
			

			throw new Exception("Erro na Inclusao.");
		}
		
	}

	Public function update($login,$password){

		$this->setDeslogin($login);
		$this->setDessenha($password);


		$sql=New Sql();
		$sql->query("UPDATE tb_usuarios SET deslogin=:LOGIN , dessenha=:PASSWORD WHERE idusuario=:ID",array(

			':LOGIN'=>$this->getDeslogin(),
			':PASSWORD'=>$this->getDessenha(),
			':ID'=>$this->getIdusuario()

		));

	}

	Public function delete(){

		
		$sql=New Sql();

		$sql->query("DELETE FROM tb_usuarios WHERE idusuario=:ID",array(
			':ID'=>$this->getIdusuario()


		));


        /// necessario porque na classe exibe valores(display do Regsitro) apos a exec do comando
		$this->setIdusuario(0);
		$this->setDeslogin("");
		$this->setDessenha("");
		$this->setDtcadastro(New Datetime());

	}

	// colocado ="" para nao se tornar obrigatorio o conteudo da variavel em referencia
	// se nao tivesse forçaria a enviar um conteudo para executar o metodo __construct

	Public function __construct($login="",$password="") {

		$this->setDeslogin($login);
		$this->setDessenha($password);


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