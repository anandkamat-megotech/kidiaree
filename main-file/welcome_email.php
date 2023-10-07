<?php
include './globals/constants_send_welcome_email_user.php';
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


$mailSubject = "Welcome Email";
$otp = 'Saumya';
$mailContent = str_replace("[PARENT]", $otp, OTP_MAIL_FORMAT);
$email = 'kamatanand3@gmail.com';
send_mail_to($email, $mailSubject, $mailContent);

echo response_ok($idUser, time());


?> 
