<?php  

require_once("config.php");


//// isso é pra encontrar a classe SQL que nos criamos

/*
$sql= New Sql();

$usuarios=$sql->select ("SELECT * FROM tb_usuarios");

echo json_encode($usuarios); */

// agora usando a classe usuario - economizarei linhas

$idConsulta=5;
$root=New Usuario();
$root->loadByid($idConsulta);

echo $root;



?>