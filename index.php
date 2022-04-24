<?php
//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

//Create an instance; passing `true` enables exceptions
$mail = new PHPMailer();

try {
    //Server settings
   // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       =  $_POST['host'];                     //Set the SMTP server to send through
    $mail->SMTPAuth   = $_POST['auth'];                                   //Enable SMTP authentication
    $mail->Username   = $_POST['username'];                     //SMTP username
    $mail->Password   = $_POST['password']; 
    if($_POST['secure']=='tls'){                              //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
    } else {
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; 
    }
    $mail->Port       = $_POST['port']; //587                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
    $mail->setFrom($_POST['username'], $_POST['name']);
    $mail->addAddress($_POST['mailto']);     //Add a recipient
//    $mail->addAddress('itsvrahul@outlook.com');               //Name is optional
    $mail->addReplyTo($_POST['username'], $_POST['name']);
   // $mail->addCC('cc@example.com');
    //$mail->addBCC('bcc@example.com');

    //Attachments
  //  $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
    $mail->isHTML($_POST['html']);                                  //Set email format to HTML
    $mail->Subject = $_POST['subject'];
    $mail->Body    = $_POST['body'];

    $mail->send();
    echo json_encode(array(
        "status"=>true
    ));
} catch (Exception $e) {
    echo json_encode(array(
        "status"=>false,
        "message"=>$mail->ErrorInfo
    ));
}
?>