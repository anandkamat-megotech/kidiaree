<?php

include './components/component_admin_campaign_create.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_admin_campaign_create.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceAdminCampaignCreate = new ServiceAdminCampaignCreate();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$name = "";
$name = post_params("name");



$isNameValid = $validatorString->validate($name);

if(!$isNameValid){
    echo response_parameters_invalid(time());
    return;
}

//Check whether campaign is exist or not
$idCampaign = getSingleValue($db, "SELECT id FROM CampaignsMaster WHERE BINARY name = ?", [$name]);

if($idCampaign != ''){
    echo response_already_exist(time());
    return;
}

$bucketSize = "";
$bucketSize = post_params("bucketSize");

//Check whether bucketSize is numeric or not
if(!is_numeric($bucketSize)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether bucketSize is more than 0 or not
if($bucketSize == 0){
    echo response_parameters_invalid(time());
    return;
}

$courses = "";
$courses = post_params("courses");

$isCoursesValid = $validatorString->validate($courses);

if(!$isCoursesValid){
    echo response_parameters_invalid(time());
    return;
}

if(!isJson(json_encode($courses))){
    echo response_parameters_invalid(time());
    return;
}

$redeemExpiryTimestamp = "";
$redeemExpiryTimestamp = post_params("redeemExpiryTimestamp");

$isRedeemExpiryTimestampValid = $validatorString->validate($redeemExpiryTimestamp);

if(!$isRedeemExpiryTimestampValid){
    echo response_parameters_invalid(time());
    return;
}

$validity = "";
$validity = post_params("validity");

//Check whether validity is numeric or not
if(!is_numeric($validity)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether validity is more than 0 or not
if($validity == 0){
    echo response_parameters_invalid(time());
    return;
}

$offerPercentage = "";
$offerPercentage = post_params("offerPercentage");

if(!is_numeric($offerPercentage)){
    echo response_parameters_invalid(time());
    return;
}

$maxAmountInr = "";
$maxAmountInr = post_params("maxAmountInr");

if(!is_numeric($maxAmountInr)){
    echo response_parameters_invalid(time());
    return;
}

$minAmountInr = "";
$minAmountInr = post_params("minAmountInr");

if(!is_numeric($minAmountInr)){
    echo response_parameters_invalid(time());
    return;
}

$maxAmountUsd = "";
$maxAmountUsd = post_params("maxAmountUsd");

if(!is_numeric($maxAmountUsd)){
    echo response_parameters_invalid(time());
    return;
}

$minAmountUsd = "";
$minAmountUsd = post_params("minAmountUsd");

if(!is_numeric($minAmountUsd)){
    echo response_parameters_invalid(time());
    return;
}

$flatDiscountInr = "";
$flatDiscountInr = post_params("flatDiscountInr");

if(!is_numeric($flatDiscountInr)){
    echo response_parameters_invalid(time());
    return;
}

$flatDiscountUsd = "";
$flatDiscountUsd = post_params("flatDiscountUsd");

if(!is_numeric($flatDiscountUsd)){
    echo response_parameters_invalid(time());
    return;
}

$discountType = "";
$discountType = post_params("discountType");

$isDiscountTypeValid = $validatorString->validate($discountType);

if(!$isDiscountTypeValid){
    echo response_parameters_invalid(time());
    return;
}

$usageType = "";
$usageType = post_params("usageType");






$isUsageTypeValid = $validatorString->validate($usageType);

if(!$isUsageTypeValid){
    echo response_parameters_invalid(time());
    return;
}



//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether user is Admin or not
$idAdminMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Admin"]);

$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

if($idRole != $idAdminMaster){
    echo response_unauthorized(time());
    return;
}


$id = $serviceAdminCampaignCreate->serve($db, $name, $bucketSize, $courses, $redeemExpiryTimestamp, $validity, $offerPercentage, $maxAmountInr, $maxAmountUsd, $flatDiscountInr, $flatDiscountUsd, $discountType, $usageType, $minAmountInr, $minAmountUsd);

echo response_ok($id, time());

function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

?> 