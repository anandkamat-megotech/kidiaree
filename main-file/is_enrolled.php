<?php

include 'razorpay-php/Razorpay.php';
include './components/component_is_enrolled.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_get_order_id.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetOrderId = new ServiceGetOrderId();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}


$idCourse = "";
$idCourse = post_params("idCourse");

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

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);



$idUserCoursePayment = getSingleValue($db, "SELECT id FROM UserCoursePaymentMapping WHERE idUser = ? AND idCourse = ?", [$idUser, $idCourse]);

if($idUserCoursePayment != NULL){
    $currentTimestamp = time();
    $expiryTimestamp = getSingleValue($db, "SELECT expiryTimestamp FROM UserCoursePaymentMapping WHERE idUser = ? AND idCourse = ?", [$idUser, $idCourse]);
    if($currentTimestamp < $expiryTimestamp){
        $myObj = new stdClass();
        $myObj->isEnrolled = 'true';
        $myObj->message = 'This course is valid till '.date('D, M d Y, H:i:s', $expiryTimestamp);

        echo response_ok(json_encode($myObj), time());
    }else{
        $myObj = new stdClass();
        $myObj->isEnrolled = 'false';
        $myObj->message = 'This course was valid till '.date('D, M d Y, H:i:s', $expiryTimestamp);
        echo response_ok(json_encode($myObj), time());
    }
}else{
    $myObj = new stdClass();
    $myObj->isEnrolled = 'false';
    $myObj->message = 'This course is not enrolled';
    echo response_ok(json_encode($myObj), time());
}



?> 