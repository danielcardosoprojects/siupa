<?php
require 'siiupa/vendor/autoload.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

$key = 'kljsjdlkajl#KJKL#k3j4lkj4kl2jkl34kJL$#wq423lk4jlk23JKL#@LK$';
$payload = [
    'iss' => 'https://siupa.com.br',
    'aud' => 'https://siupa.com.br',
    'iat' => 1356999524,
    'nbf' => 1357000000
];

/**
 * IMPORTANT:
 * You must specify supported algorithms for your application. See
 * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
 * for a list of spec-compliant algorithms.
 */
$jwt = JWT::encode($payload, $key, 'HS256');
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));
//echo $jwt;

// Pass a stdClass in as the third parameter to get the decoded header values
$headers = new stdClass();
$decoded = JWT::decode($jwt, new Key($key, 'HS256'), $headers);
//echo json_encode($decoded);

/*
 NOTE: This will now be an object instead of an associative array. To get
 an associative array, you will need to cast it as such:
*/

$decoded_array = (array) $decoded;

/**
 * You can add a leeway to account for when there is a clock skew times between
 * the signing and verifying servers. It is recommended that this leeway should
 * not be bigger than a few minutes.
 *
 * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
 */
JWT::$leeway = 60; // $leeway in seconds
$decoded = JWT::decode($jwt, new Key($key, 'HS256'));
?>
<script>sessionStorage.setItem('token', '<?=$jwt;?>');    </script>