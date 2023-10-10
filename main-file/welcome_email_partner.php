<?php
include './globals/constants_send_welcome_email_partner.php';
include './globals/constants_new_user_registered_email_db.php';
include './components/component_validate_email.php';
include './services/service_base.php';
include './services/service_check_value_exists_in_table.php';
include './services/service_otp_generate.php';
include './services/service_create_user.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './utilities/send_email.php';
include './validator/validator_string.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);


$mailSubject = "Welcome Kit from Kidiaree";
$name = $_GET['name'];
$username = $_GET['email'];
$password = '*********';
$mailContent = str_replace("[PARTNER]", $name, OTP_MAIL_FORMAT);
$mailContent .= str_replace("[USERNAME]", $username, DETAIL_MAIL_FORMAT);
$mailContent .= str_replace("[PASSWORD]", $password, DETAIL_MAIL_FORMAT1);
$url = 'https://kidiaree.softwareconnect.in/change_password.php?username='.$username;
$mailContent .= str_replace("[URL]", $url, DETAIL_MAIL_FORMAT2);
// $email =  post_params("email");
send_mail_to($username, $mailSubject, $mailContent);

echo response_ok($idUser, time());


?> 
