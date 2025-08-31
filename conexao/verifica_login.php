<?php
header("Access-Control-Allow-Origin: *");
session_start();
//var_dump($_SESSION);
if(!$_SESSION['usuario']) {
	header('Location: /');
	
	exit();
}
