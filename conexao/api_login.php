<?php
header("Access-Control-Allow-Origin: *");
require_once '../siiupa/vendor/autoload.php';
session_start();

// Carregue as variáveis de ambiente do arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable('../');
$dotenv->load();

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

//$key = $_ENV['KEY_TOKEN'];
$key = 'kljsjdlkajl#KJKL#k3j4lkj4kl2jkl34kJL$#wq423lk4jlk23JKL#@LK$';
$jwt = $_SESSION['token'];

//var_dump($_SESSION);

$decoded = JWT::decode($jwt, new Key($key, 'HS256'));

//echo json_encode($decoded);


function verificarAutenticacao() {
    if (isset($_SESSION['usuario'])) {
        $response = array(
            'autenticado' => true,
            'nomeusuario' => $_SESSION['nomeusuario'],
            'nivel' => $_SESSION['nivel'],
            'idServidorUsuario' => $_SESSION['idServidorUsuario'],
            'idUsuario' => $_SESSION['idUsuario'],
            'token' => $_SESSION['token']
        );

        return json_encode($response);
    } else {
        $response = array('autenticado' => false);
        return json_encode($response);
    }
}

// Verifica o estado da sessão
echo verificarAutenticacao();
exit();

?>