<?php

$servername = "localhost"; // normalmente, "localhost"
$username = "u940659928_siupa";
$password = "4jHd@myhRDEBL@7";
$dbname = "u940659928_siupa";

// Criar conexão
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

echo "Conexão bem-sucedida!";

// Fechar a conexão
$conn->close();


?>
