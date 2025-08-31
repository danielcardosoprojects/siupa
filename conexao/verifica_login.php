<?php
header("Access-Control-Allow-Origin: *");

//var_dump($_SESSION);
if (!$_SESSION['usuario']) {
	header('Location: /');

	exit();
}
