<?php  

require_once("config.php");


//// isso é pra encontrar a classe SQL que nos criamos

/*
$sql= New Sql();

$usuarios=$sql->select ("SELECT * FROM tb_usuarios");

echo json_encode($usuarios); */

// agora usando a classe usuario - economizarei linhas

// carrega um usuario
//$idConsulta=5;
//$root=New Usuario();
//$root->loadByid($idConsulta);
//echo $root;

// carrega um alista de usuarios

//$lista=Usuario::getList();
//echo json_encode($lista);

//carrega uma lista de usuários buscando pelo login
//$search=Usuario::search("braga");
//echo json_encode($search);

// autenticar um usuario 

/*$log="REY";
$pass="456";

$usuario = New Usuario();
$usuario->login($log,$pass);
//echo json_encode($usuario);
echo $usuario;*/



$executa=2;

if($executa==0) { 

// inserindo usuario novo
$aluno= New Usuario('TentaDeletar','tr444');
// como botei um metodo construtor em Usuario, basta refenciar
// nao precisa usar 2 $aluno e etc abaixo
//$aluno->setDeslogin('sp_SQL'); nao entra 
//$aluno->setDessenha('teste1'); nao entra
$aluno->insert();
echo $aluno;
}

// alterando um ususario

if ($executa==1) {

$usuario= New Usuario();
$usuario->loadByid(1040);
$usuario->update("NaoExclui","333");

echo $usuario;

//echo "vou fazer update";

}

// EXCLUSAO DE REGISTRO

if ($executa==2) {

$usuario= New Usuario();
$usuario->loadByid(1040);
$usuario->delete();
echo $usuario;

}

?>