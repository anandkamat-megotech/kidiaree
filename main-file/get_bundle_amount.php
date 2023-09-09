<?php

include './components/component_get_bundle_amount.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$validatorString = new ValidatorString();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$courses = "";
$courses = post_params("courses");

$isIndia = "";
$isIndia = post_params("isIndia");

$isCoursesValid = $validatorString->validate($courses);

if(!$isCoursesValid){
    echo response_parameters_invalid(time());
    return;
}

if(!isJson(json_encode($courses))){
    echo response_parameters_invalid(time());
    return;
}

$isIndiaNonEmpty = $validatorString->validate($isIndia);

if(!$isIndiaNonEmpty){
    echo response_parameters_invalid(time());
    return;
}

if ($isIndia != "true" && $isIndia != "false") {
    echo response_parameters_invalid(time());
    return;
}

$totalAmount = 0;

for($i = 0; $i < sizeof($courses); $i++){
    $idCourse = $courses[$i]['id'];

    //Check whether idCourse is numeric or not
    if(!is_numeric($idCourse)){
        echo response_parameters_invalid(time());
        return;
    }

    //Check whether idCourse exists or not
    $rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
    if ($rowCountCourse == 0) {
        echo response_not_found(time());
        return;
    }

    $amount = 0;

    if($isIndia == "true"){
        //Get amount of from CoursesMaster
        $amount = getSingleValue($db, "SELECT amount FROM CoursesMaster WHERE id = ?", [$idCourse]);
    }else{
        //Get amount of from CoursesMaster
        $amount = getSingleValue($db, "SELECT amountUsd FROM CoursesMaster WHERE id = ?", [$idCourse]);
    }
    

    $totalAmount = $totalAmount + $amount;

}

// $totalAmount = $totalAmount * 100;

$discountedAmount = 0;

if (sizeof($courses) == 2) {
    $discountedAmount = $totalAmount - ((TWO_COURSES_DISCOUNT / 100) * $totalAmount);
}else{
    $discountedAmount = $totalAmount - ((THREE_COURSES_DISCOUNT / 100) * $totalAmount);
}


$myObj = new stdClass();
$myObj->totalAmount = $totalAmount;
$myObj->discountedAmount = $discountedAmount;

echo response_ok(json_encode($myObj), time());

function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

?> 