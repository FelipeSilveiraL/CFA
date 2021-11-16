<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require_once('../bd/conexao.php');

$query = "SELECT * FROM cfa_usuarios WHERE email = '" . $_POST['emailEsqueciSenha'] . "'";
$result = $conn->query($query);
$email = $result->fetch_assoc();

if ($email['email'] != NULL) {

    $alterarSenha = "UPDATE cfa_usuarios SET alterarSenha = '1' WHERE (id = '" . $email['id'] . "')";
    $update = $conn->query($alterarSenha);

    $partInicial = substr($email['email'], '0', '6');

    $partFinal = substr($email['email'], strpos($email['email'], '@'));

    //ENVIANDO O EMAIL USANDO PHPmailer

    //Import PHPMailer classes into the global namespace
    //These must be at the top of your script, not inside a function


    //Load Composer's autoloader
    require '../vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'desenvolvimento@servopa.com.br';                     //SMTP username
        $mail->Password   = 'cpdtec05';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('euquemandei@gmail.com.br', 'Mailer');

          
        $mail->addAddress('felipe.lara@servopa.com.br', 'Joe User');     //Add a recipient
        /*
        $mail->addAddress('ellen@example.com');               //Name is optional
        $mail->addReplyTo('info@example.com', 'Information');
        $mail->addCC('cc@example.com');
        $mail->addBCC('bcc@example.com'); 
        
        //Attachments
        $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        $mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
        */

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = 'Here is the subject';
        $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();

        echo 'Enviado solicitação para o email: ' . $partInicial . '*****' . $partFinal;
        echo '<meta http-equiv="refresh" content="5;url=../index.php?pag=1" />';
    } catch (Exception $e) {
        echo "A mensagem não pôde ser enviada. Erro do Mailer:: {$mail->ErrorInfo}";
    }
} else {
    echo 'Não foi encontrado esse e-mail em nossos registros, peço que entre em contato com a secretaria para auxilio';
    echo '<meta http-equiv="refresh" content="5;url=../index.php?pag=1" />';
}

$conn->close();
