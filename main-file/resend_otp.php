<?php
include './globals/constants_send_otp_email_db.php';
include './components/component_resend_otp.php';
include './services/service_base.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_otp_generate.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './utilities/send_email.php';
include './utilities/send_message.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceOTPGenerate = new ServiceOTPGenerate();

$idUser = "";
$idUser = post_params("idUser");

//Check whether idUser is numeric or not
if(!is_numeric($idUser)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idUser exists or not
$rowCountUser = $serviceCheckRecordExistsInTable->serve($db, "usersmaster", $idUser);
if ($rowCountUser == 0) {
    echo response_not_found(time());
    return;
}

//Get email of from usersmaster
$email = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idUser]);

//Generate OTP and update in database
$otp = $serviceOTPGenerate->serve($db, "id", $idUser);


if($email)
{
    //otp mail sending
    $mailSubject = "OTP For Login";

    $mailContent = str_replace("[OTP]", $otp, OTP_MAIL_FORMAT);

    send_mail_to($email, $mailSubject, $mailContent);
}
//Get mobile of from usersmaster
$mobile = getSingleValue($db, "SELECT mobile FROM usersmaster WHERE id = ?", [$idUser]);
if($mobile)
{
    //otp message sending
    $message = str_replace("[OTP]", $otp, MOBILE_OTP_MESSAGE);
    send_message_to($mobile, $message);
}



echo response_ok($idUser, time());


?> 