<?php 

//Import PHPMailer classes into the global namespace
//These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

function send_mail_to($email, $subject, $content) {

    $mail = new PHPMailer;
    $mail->isHTML(true);								//Sets Mailer to send message using SMTP
    $mail->Host = 'ssl://smtp.gmail.com';		//Sets the SMTP hosts of your Email hosting, this for Godaddy
    $mail->Port = '465';								//Sets the default SMTP server port
    $mail->SMTPAuth = true;							//Sets SMTP authentication. Utilizes the Username and Password variables
    $mail->Username = 'kamatanand3@gmail.com';					//Sets SMTP username
    $mail->Password = 'L1m1tl3ss1!';					//Sets SMTP password
    $mail->SMTPSecure = 'SSL';

    
    //Recipients
    $mail->setFrom("kamatanand3@gmail.com", "Kidiaree");
    $mail->addAddress($email, "");

    //Content
    $mail->isHTML(true);                                  //Set email format to HTML
    $mail->Subject = $subject;
    $mail->MsgHTML($content);
    $mail->clearAttachments();
    //var_dump($mail->Send());
    if(!$mail->Send()) {
        
    } else {
        
    }
}

?> 