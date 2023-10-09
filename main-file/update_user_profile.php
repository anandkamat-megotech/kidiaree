<?php
include './globals/constants_send_welcome_email_user.php';
include './components/component_update_user_profile.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_user_profile.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_upload_to_cloud.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
include './utilities/send_email.php';



$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceUpdateUserProfile = new ServiceUpdateUserProfile();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceUploadToCloud = new ServiceUploadToCloud();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}



$addressLine1 = "";
$addressLine1 = post_params("addressLine1");

$isAddressLine1Valid = $validatorString->validate($addressLine1);

if(!$isAddressLine1Valid){
    echo response_parameters_invalid(time());
    return;
}


$addressLine2 = "";
$area = post_params("area");

$addressLine2 = post_params("addressLine2").' '.$area ;

$isAddressLine2Valid = $validatorString->validate($addressLine2);

if(!$isAddressLine2Valid){
    $addressLine2 = '';
    
}


$city = "";
$city = post_params("city");

$isCityValid = $validatorString->validate($city);

if(!$isCityValid){
    echo response_parameters_invalid(time());
    return;
}


$state = "";
$state = post_params("state");

$isStateValid = $validatorString->validate($state);

if(!$isStateValid){
    echo response_parameters_invalid(time());
    return;
}


$country = "";
$country = post_params("country");

$isCountryValid = $validatorString->validate($country);

if(!$isCountryValid){
    echo response_parameters_invalid(time());
    return;
}


$pincode = "";
$pincode = post_params("pincode");
$email = post_params("email");
$yfname = post_params("yfname");
$ylname = post_params("ylname");

$isPincodeValid = $validatorString->validate($pincode);

if(!$isPincodeValid){
    echo response_parameters_invalid(time());
    return;
}


//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);


$id = $serviceUpdateUserProfile->serve($db, $idUser,$addressLine1,$addressLine2, $city, $state, $country, $pincode, $email,$yfname,$ylname);
$mailSubject = "Welcome Email from Kidiaree";
$fname = $yfname;
$mailContent = str_replace("[PARENT]", $fname, OTP_MAIL_FORMAT);
send_mail_to($email, $mailSubject, $mailContent);

echo response_ok($id, time());

?> 