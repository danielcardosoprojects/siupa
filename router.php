<?php
// siiupa/router.php
session_start();
// Pega o caminho da URL
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Remove a barra inicial, se houver
if (strpos($path, '/') === 0) {
    $path = substr($path, 1);
}

// Verifica se o arquivo ou diretório existe no sistema de arquivos
$file = __DIR__ . '/' . $path;

// Se for um arquivo existente, serve ele diretamente e para a execução.
// Isso permite que CSS, JS, e imagens funcionem.
if (is_file($file)) {
    return false;
}

// Se o caminho for um diretório, procure por um index.php dentro dele
if (is_dir($file)) {
    $indexPath = $file . '/index.php';
    if (is_file($indexPath)) {
        require $indexPath;
        return; // Termina a execução após carregar o index do subdiretório
    }
        if (is_file($file . '/index.html')) {
        require $file . '/index.php';
        return; // Termina a execução após carregar o index do subdiretório
    }
}

// Se nenhuma das condições acima for satisfeita, significa que a URL não
// corresponde a um arquivo ou diretório físico. Nesse caso,
// você pode ter um index.php principal para lidar com as rotas.
require __DIR__ . '/index.php';
