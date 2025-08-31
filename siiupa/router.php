<?php
// siiupa/router.php
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (php_sapi_name() === 'cli-server') {
    $file = __DIR__ . $path;
    if (is_file($file)) {
        return false;
    }
}

require __DIR__ . 'siiupa/index.php';
