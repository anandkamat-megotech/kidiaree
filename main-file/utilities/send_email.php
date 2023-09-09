<?php 

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function send_mail_to($email, $subject, $content) {

    $mail = new PHPMailer();
    $mail->IsSMTP();
    $mail->Mailer = "smtp";

    $mail->SMTPDebug  = 0;  
    $mail->SMTPAuth   = TRUE;
    $mail->SMTPSecure = "tls";
    $mail->Port       = 587;
    $mail->Host       = "smtp.gmail.com";
    $mail->Username   = "kamatanand3@gmail.com";
    $mail->Password   = "L1m1tl3ss1!";

    
    //Recipients
    $mail->setFrom("kamatanand3@gmail.com", "Kidiaree");
    $mail->addAddress($email, "");

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->MsgHTML($content);
    //var_dump($mail->Send());
    if(!$mail->Send()) {
        
    } else {
        
    }
}

?> 