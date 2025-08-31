<?php
require '../siiupa/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;


session_start();
include('conexao.php');

if(empty($_POST['usuario']) || empty($_POST['senha'])) {
    // Redireciona se usuário ou senha não forem fornecidos
    $_SESSION['nao_autenticado'] = true;
    echo "<script>window.location.href = '/siiupa/';</script>";
    exit();
}

$usuario = mysqli_real_escape_string($conexao, $_POST['usuario']);
$senha = mysqli_real_escape_string($conexao, $_POST['senha']);

// Verifica se o usuário e senha estão corretos
$query = "SELECT id, usuario, nome, nivel, idservidor FROM usuarios WHERE usuario = '{$usuario}' AND senha = md5('{$senha}')";
$result = mysqli_query($conexao, $query);
$row = mysqli_num_rows($result);

if($row == 1) {
    while ($loginnome = mysqli_fetch_assoc($result)) {
        $_SESSION['nomeusuario'] = $loginnome['nome'];
        $_SESSION['nivel'] = $loginnome['nivel'];
        $_SESSION['idServidorUsuario'] = $loginnome['idservidor'];
        $_SESSION['idUsuario'] = $loginnome['id'];
    }

    date_default_timezone_set('America/Sao_Paulo');
    
    // Geração do token JWT
    $key = 'kljsjdlkajl#KJKL#k3j4lkj4kl2jkl34kJL$#wq423lk4jlk23JKL#@LK$';
    $payload = [
        'iss' => 'https://siupa.com.br',
        'aud' => 'https://siupa.com.br',
        'iat' => time(),
        'exp' => time() + 14400,
        'idUsuario' => $_SESSION['idUsuario'],
        'nbf' => 1357000000
    ];

    $jwt = JWT::encode($payload, $key, 'HS256');
    $_SESSION['usuario'] = $usuario;
    $_SESSION['token'] = $jwt;
    echo "<script>localStorage.setItem('token','$jwt')</script>";

    // Insere o token JWT no campo jwt para o usuário
    $idUsuario = $_SESSION['idUsuario'];
    $sqlUpdateJWT = "UPDATE usuarios SET token = ? WHERE id = ?";
    $stmt = $conexao->prepare($sqlUpdateJWT);

    if ($stmt) {
        $stmt->bind_param('si', $jwt, $idUsuario);
        if ($stmt->execute()) {
            echo "Login com sucesso e token JWT inserido!";
        } else {
            echo "Erro ao inserir o token JWT: " . $stmt->error;
        }
        $stmt->close();
    } else {
        echo "Erro na preparação da declaração: " . $conexao->error;
    }

    // Define o token no sessionStorage e redireciona
    echo "<script>sessionStorage.setItem('token', '$jwt');</script>";
    echo "<script>window.location.href = '/siiupa/';</script>";

    exit();
} else {
    $_SESSION['nao_autenticado'] = true;
    echo "<script>window.location.href = '/siiupa/';</script>";
    exit();
}
?>
