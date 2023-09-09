<?php

include './components/component_validate_otp.php';
include './services/service_base.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_validate_admin_otp.php';
include './services/service_token_generate.php';
include './services/service_consumer_pin_generate.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceTokenGenerate = new ServiceTokenGenerate();
$serviceConsumerPinGenerate = new ServiceConsumerPinGenerate();
$serviceValidateOTP = new ServiceValidateAdminOTP();

$idUser = "";
$number = post_params("number");

$otp = "";
$otp = post_params("otp");

//Check whether idUser is numeric or not


//Check whether otp is numeric or not
if(!is_numeric($otp)){
    echo response_parameters_invalid(time());
    return;
}
$idUser = getSingleValue($db, "SELECT id FROM usersmaster WHERE mobile = ?", [$number]);

//Check whether idUser exists or not
$rowCountUser = $serviceCheckRecordExistsInTable->serve($db, "usersmaster", $idUser);
if ($rowCountUser == 0) {
    echo response_not_found(time());
    return;
}

//Check whether idUser isActive or not
$idActive = getSingleValue($db, "SELECT id FROM usersmaster WHERE id = ? AND isActive = ?", [$idUser, 1]);
if ($idActive == '') {
    echo response_not_active(time());
    return;
}


//Validate OTP with idUser
$rowCountidUserOTP = $serviceValidateOTP->serve($db, $idUser, $otp);
if ($rowCountidUserOTP == 0) {
    echo response_invalid_otp(time());
    return;
}

//Get idUser of User from usersmaster
$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

//Get name of User from usersmaster
$name = getSingleValue($db, "SELECT name FROM usersmaster WHERE id = ?", [$idUser]);
$url = 'index.php';

$token = $serviceTokenGenerate->serve($db, $idUser);

$consumerPin = $serviceConsumerPinGenerate->serve($db, $idUser);

$myObj = new stdClass();
$myObj->idUser = $idUser;
$myObj->token = $token;
$myObj->name = $name;
$myObj->idRole = $idRole;
$myObj->url = $url;

echo response_ok(json_encode($myObj), time());

?> 