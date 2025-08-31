<?php
// Carregue o autoloader do Composer
require_once 'siiupa/vendor/autoload.php';

// Carregue as variáveis de ambiente do arquivo .env
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();


echo $_ENV['KEY_TOKEN'];

?>