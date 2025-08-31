<?php

$servername = "localhost";
$database = "u940659928_siupa";
$username = "u940659928_siupa";
$password = "4jHd@myhRDEBL@7";
// Create connection

global $conexao;
$conexao = mysqli_connect($servername, $username, $password, $database) or die ('Não foi possível conectar');
