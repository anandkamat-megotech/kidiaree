<?php

include './components/component_validate_mobile.php';
include './globals/constants_new_user_registered_email_db.php';
include './services/service_base.php';
include './services/service_check_value_exists_in_table.php';
include './services/service_otp_generate.php';
include './services/service_create_user.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './utilities/send_message.php';
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

$mobile = "";
$mobile = post_params("data");

$isMobileValid = $validatorString->validate($mobile);

if(!$isMobileValid){
    echo response_parameters_invalid(time());
    return;
}

//Check whether mobile exists or not
$rowCountMobileExist = $serviceCheckValueExistsInTable->serve($db, "usersmaster", "mobile", $mobile);
if ($rowCountMobileExist == 0) {
    $serviceCreateUser->serve($db, "mobile", $mobile);
    $mailSubject = "New User Registered";
    $mailContent = str_replace("[CONTACT]", $mobile, NEW_USER_MAIL_FORMAT);
    send_mail_to(ADMIN_MAIL_ID, $mailSubject, $mailContent);
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT id FROM usersmaster WHERE mobile = ?", [$mobile]);

//Check whether idUser isActive or not
$idActive = getSingleValue($db, "SELECT id FROM usersmaster WHERE id = ? AND isActive = ?", [$idUser, 1]);
if ($idActive == '') {
    echo response_not_active(time());
    return;
}

//Generate OTP and update in database
$otp = $serviceOTPGenerate->serve($db, "mobile", $mobile);

$message = str_replace("[OTP]", $otp, MOBILE_OTP_MESSAGE);


send_message_to($mobile, $message);

echo response_ok($idUser, time());




?> 