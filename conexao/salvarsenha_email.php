<?php
session_start();
include('conexao.php');

if(empty($_POST['codigo'])) {
	header('Location: redefinirsenha_email.php');
	exit();
}

$codigo = mysqli_real_escape_string($conexao, $_POST['codigo']);


$usuario = $_SESSION['usuario'];
$query = "select usuario from u940659928_siupa.usuarios where usuario = '{$usuario}' and remember_token = md5('{$codigo}')";

echo $query;

$result = mysqli_query($conexao, $query);

$row = mysqli_num_rows($result);

if($row == 1) {

  $senha1 = mysqli_real_escape_string($conexao, $_POST['senha1']);
  $senha2 = mysqli_real_escape_string($conexao, $_POST['senha2']);

  if($senha1 == $senha2) {

    $sql = "update u940659928_siupa.usuarios set senha = md5('{$senha1}') where usuario = '$usuario'";

	echo "<br>$sql";


		if($conexao->query($sql) === TRUE){

			$conexao->close();

			header('Location: ../index.php');
			exit();

		} else {
			echo "$senha1 e $senha2";
			var_dump($senha1==$senha2);
			$_SESSION['errosenha'] = true;
			header('Location: redefinirsenha_email.php');
			exit();

		}

  } else {

    $_SESSION['errosenha'] = true;
    header('Location: redefinirsenha_email.php');
    exit();

  }

} else {
	

	$_SESSION['errocodigo'] = true;
	header('Location: redefinirsenha_email.php');
	exit();

}
