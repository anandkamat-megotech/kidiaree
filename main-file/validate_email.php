<?php
include './globals/constants_send_otp_email_db.php';
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
$validatorString = new ValidatorString();
$serviceCheckValueExistsInTable = new ServiceCheckValueExistsInTable();
$serviceOTPGenerate = new ServiceOTPGenerate();
$serviceCreateUser = new ServiceCreateUser();

$email = "";
$email = post_params("data");

$isEmailValid = $validatorString->validate($email);

if(!$isEmailValid){
    echo response_parameters_invalid(time());
    return;
}

//Check whether email exists or not
$rowCountEmailExist = $serviceCheckValueExistsInTable->serve($db, "usersmaster", "email", $email);
if ($rowCountEmailExist == 0) {
    $serviceCreateUser->serve($db, "email", $email);
    $mailSubject = "New User Registered";
    $mailContent = str_replace("[CONTACT]", $email, NEW_USER_MAIL_FORMAT);
    send_mail_to(ADMIN_MAIL_ID, $mailSubject, $mailContent);
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT id FROM usersmaster WHERE email = ?", [$email]);

//Check whether idUser isActive or not
$idActive = getSingleValue($db, "SELECT id FROM usersmaster WHERE id = ? AND isActive = ?", [$idUser, 1]);
if ($idActive == '') {
    echo response_not_active(time());
    return;
}

//Generate OTP and update in database
$otp = $serviceOTPGenerate->serve($db, "email", $email);

$mailSubject = "OTP For Login";

$mailContent = str_replace("[OTP]", $otp, OTP_MAIL_FORMAT);

send_mail_to($email, $mailSubject, $mailContent);

echo response_ok($idUser, time());


?> 
