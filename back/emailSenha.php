<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Desligue todos os relatórios de erros
error_reporting(0);

require_once('../bd/conexao.php');
require_once('query.php');

$query = "SELECT * FROM cfa_usuarios WHERE email = '" . $_POST['emailEsqueciSenha'] . "'";
$result = $conn->query($query);
$email = $result->fetch_assoc();

if ($email['email'] != NULL) {

    $alterarSenha = "UPDATE cfa_usuarios SET alterarSenha = '1' WHERE (id = '" . $email['id'] . "')";
    $update = $conn->query($alterarSenha);

    $partInicial = substr($email['email'], '0', '6');

    $partFinal = substr($email['email'], strpos($email['email'], '@'));

    require '../vendor/autoload.php';

    //Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        //Server settings
        /* $mail->SMTPDebug = SMTP::DEBUG_SERVER; //Enable verbose debug output */
        $mail->CharSet = "utf-8";
        $mail->isSMTP();//Send using SMTP
        $mail->SMTPDebug = 1; // debugging: 1 = errors and messages, 2 = messages only
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'contato@cfasitiocercado.com.br';                     //SMTP username
        $mail->Password   = 'cfasitiocercado';                               //SMTP password
        $mail->SMTPSecure = 'ssl'; // secure transfer enabled REQUIRED for Gmail
        $mail->Host = "smtp.titan.email";
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('contato@cfasitiocercado.com.br', 'Contato CFA');          
        $mail->addAddress($email['email'], $email['nome'].' '.$email['sobre_nome']);     //Add a recipient
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
        $mail->Subject = 'Alteração de Senha';
        $mail->AddEmbeddedImage($sistema['cfa_logo_login'], 'logoEmail');
        $mail->Body = '<head>
                        <style>
                            @import url("https://fonts.googleapis.com/css2?family=Rubik:wght@300&display=swap");
                            #email {
                                border-top: 5px solid #120eed;
                                width: 80%;
                                background-color: #e4efef;
                                border-radius: 13px;
                                font-family: "Rubik", sans-serif;
                            }
                            .corpo {
                                padding: 19px;
                            }
                            .titulo {
                                padding: 1px 0px 0px 19px;
                            }
                            img.logo {
                                width: 11%;
                                border-radius: 50px;
                                margin-left: 620px;
                                margin-top: -77px;
                                margin-bottom: 3px;
                            }
                        </style>
                        </head>
                            
                        <body>
                            <div id="email">
                                <div class="titulo">
                                    <h3>Olá, '.$email['nome'].' '.$email['sobre_nome'].'</h3>
                                </div>
                                <div class="corpo">
                                    <p>Foi solicitado uma alteração de senha do seu acesso ao portal <b>Mebro CFA</b></p>
                                    <p>Caso tenha sido realmente você, basta clicar em <a
                                            href="http://cfasitiocercado.com.br/adm.php?pag=2&idUsuario='.$email['id'].'">ALTERAR SENHA</a>, que você será
                                        redirecionado para alterar sua senha</p>
                                    <p>Agora se não foi você pode desconsiderar essa msn!</p>
                                    <p>Que a paz de Cristo esteja na sua vida!</p>
                                </div>                            
                                <div class="rodape">
                                    <img src="cid:logoEmail" alt="IMG" class="logo">
                                </div>
                            </div>
                        
                        </body>';
        $mail->send();

        echo 'Enviado solicitação para o email: ' . $partInicial . '*****' . $partFinal;
        echo '<meta http-equiv="refresh" content="5;url=../adm.php?pag=1" />';

    } catch (Exception $e) {

        echo "A mensagem não pôde ser enviada. Erro do Mailer:: {$mail->ErrorInfo}";

    }
} else {
    
    echo 'Não foi encontrado esse e-mail em nossos registros, peço que entre em contato com a secretaria para auxilio <br />';
    echo '<b>contato@cfa.com.br<b>';
    echo '<meta http-equiv="refresh" content="10;url=../index.php?pag=1" />';
}

$conn->close();
