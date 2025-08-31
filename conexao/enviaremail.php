<?php
require_once  '../siiupa/vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
session_start();
include('conexao.php');
$mail = new PHPMailer(true);
if(empty($_POST['email'])) {
	header('Location: recuperar.php');

	exit();
}else{

	$email = mysqli_real_escape_string($conexao, $_POST['email']);

	$random = randomPassword();

	$sql = "update u940659928_siupa.usuarios set remember_token = md5('{$random}') where email = '{$email}'";
	

	if($conexao->query($sql) === TRUE){

		$conexao->close();
		
		try {
    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.hostinger.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'contato@siupa.com.br';                     //SMTP username
    $mail->Password   = 'Saude*2024';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
    $mail->Port       = 465;                                    //porta
    
      //Recipients
    $mail->setFrom('contato@siupa.com.br', 'SIUPA');
    $mail->addAddress($email);     //Add a recipient
   

    //Attachments
   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = "Recuperar senha";
	$mail->Body = "<b>Código:</b> " . $random ." <b><br>Use o código para redefinir sua senha:</b> http://siupa.com.br/conexao/redefinirsenha_email.php";
    

    $mail->send();
    echo 'Message has been sent';
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
        $_SESSION['email_enviado'] = true;
		header('Location: enviado.php');
		exit();
	} else {
		$_SESSION['nao_autenticado'] = true;
		header('Location: ../index.php');
		exit();
	}

}
echo "teste";

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
