<?php
session_start();
include('conexao.php');

$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);
$email = mysqli_real_escape_string($conexao, $_POST['email']);

$query = "select usuario from usuarios where email = '{$email}'";

$result = mysqli_query($conexao, $query);

$row = mysqli_num_rows($result);

if($row == 0) {

  $sql = "insert into usuarios(usuario,senha,email) values('{$usuario}',md5('{$codigo}'),'{$email}')";

	if($conexao->query($sql) === TRUE){

		$conexao->close();

		header('Location: ../conexao/usuarios.php');
		exit();

	} else {
		$_SESSION['erro'] = true;
		header('Location: ../conexao/painel.php');
		exit();

	}


} else {

	$_SESSION['erro_email'] = true;
	header('Location: ../conexao/painel.php');
	exit();

}
