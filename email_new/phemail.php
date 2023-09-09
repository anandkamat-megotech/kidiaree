<?php
$servername = "localhost";
$username = "advanced2_root";
$password = "L1m1tl3ss1!";
$dbname = "advanced2_rms";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$datetime = new DateTime('tomorrow');
$tomorrowdt = $datetime->format('Y-m-d');


$sql = "SELECT * FROM `public_holidays` where date = '$tomorrowdt';";

$result = $conn->query($sql);

if ($result->num_rows > 0) {

    // output data of each row
    while($row = $result->fetch_assoc()) {

        $holidaydate = $row[date];
        $day = date('l, F d, Y', strtotime($holidaydate));
        $eventname = $row[name];
        $for = "Advanced CasePRO Services";
        $hremail = "hr@advancedcaseproservices.com";
        $SiteURL = "https://advancedcaseproservices.com/";

        $mailmsg ="";
        $mailmsg .= "<h2 style='text-align: center'>Holiday Announcement Letter</h2>";
        $mailmsg .= "<p><span style='float:right;padding-right:30px;'>".$day."</span>Hello All,</p>"; 
        $mailmsg .= "<p>Kindly note that our office will remain closed tomorrow, ".$day.", on the occasion of ".$eventname.". For anything urgent, please call the individual's mobile phone. Wishing everyone a happy and safe holiday.</p>\r";

        $mailmsg .= '</table>' ;

        $mailmsg .= "<p>Thank you</p>\r"; 
        $mailmsg .= "<p>REGARDS,</p>\r"; 
        $mailmsg .= "<p>For ".$for."</p>\r"; 


        $body .= "<!DOCTYPE html>
        <html>
        <head>
        <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
        </head>
        <body>
        <center>
        <table width=98% border=\"0\" align=\"center\" cellpadding=1 cellspacing=\"0\" >
        <tr>
        <td align=\"center\" valign=\"top\">
        <table width=900px border=\"0\"  cellpadding=\"0\" cellspacing=\"0\" style='border:2px solid; border-color:#969696'>
        <tr>                                            
        <td bgcolor=\"#FFFFFF\" align=\"left\" style=\"padding:14px;\">" . $mailmsg . "</td>                                            
        </tr>
        <tr>
        <td bgcolor=#606060 align=\"center\" style=\"padding:2px; border-top:2px solid; border-color:#777777\">
        <a href=\"" . $SiteURL . "\" style='color:#ffffff; text-decoration:none'>" . $hremail . "</a>
        </td>
        </tr>
        </table>
        </td>
        </tr>
        </table>
        </center>
        </body>
        </html>";
        
        require 'class/class.phpmailer.php';
        $mail = new PHPMailer;
        $mail->IsSMTP();                                //Sets Mailer to send message using SMTP
        $mail->Host = 'smtp.gmail.com';     //Sets the SMTP hosts of your Email hosting, this for Godaddy
        $mail->Port = '587';                                //Sets the default SMTP server port
        $mail->SMTPAuth = true;                         //Sets SMTP authentication. Utilizes the Username and Password variables
        $mail->Username = 'aacs0878@gmail.com';                 //Sets SMTP username
        $mail->Password = 'L1m1tl3ss1!';                    //Sets SMTP password
        $mail->SMTPSecure = 'tls';                          //Sets connection prefix. Options are "", "ssl" or "tls"
        $mail->From = 'adigareyogesh38@gmail.com';                  //Sets the From email address for the message
        $mail->FromName = 'Yogesh';
        $mail->AddAddress('adigareyogesh38@gmail.com');             //Sets the From name of the message
        $mail->AddCC('kamatanand3@gmail.com', 'Anand Kamat');
        $mail->setFrom('aacs0878@gmail.com');
        // $mail->AddAddress('abc@xyz.com', 'Name');        //Adds a "To" address
        // $mail->AddCC($_POST["email"], $_POST["name"]);   //Adds a "Cc" address
        $mail->WordWrap = 50;                           //Sets word wrapping on the body of the message to a given number of characters
        $mail->IsHTML(true);                            //Sets message type to HTML             
        $mail->Subject = $eventname;             //Sets the Subject of the message
        $mail->Body = $body;                //An HTML or plain text message body
        if($mail->Send())                               //Send an Email. Return true on success or false on error
        {
            $error = '<label class="text-success">Thank you for contacting us</label>';
           
        }
        else
        {
            $error = '<label class="text-danger">There is an Error '.$mail->ErrorInfo.'</label>';
           
        }
        $name = '';
        $email = '';
        $subject = '';
        $message = '';

    }
} else {
    echo "0 results";
}
$conn->close();
?>