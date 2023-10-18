<?php

include 'razorpay-php/Razorpay.php';
include './components/component_update_bundle_payment_status.php';
include './globals/constants_user_enrolled_bundle_email_db.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_bundle_payment_status.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/authorization.php';
include './utilities/post_parameters.php';
include './validator/validator_string.php';
include './utilities/send_email.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceUpdateBundlePaymentStatus = new ServiceUpdateBundlePaymentStatus();
$validatorString = new ValidatorString();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$courses = "";
$courses = post_params("courses");

$idOrder = "";
$idOrder = post_params("idOrder");

$razorpayPaymentId = "";
$razorpayPaymentId = post_params("razorpayPaymentId");

$razorpayOrderId = "";
$razorpayOrderId = post_params("razorpayOrderId");

$razorpaySignature = "";
$razorpaySignature = post_params("razorpaySignature");

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

$coursesString;
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

    $course = getSingleValue($db, "SELECT name FROM CoursesMaster WHERE id = ?", [$idCourse]);

    if($i == 0){
        $coursesString = $course;
    }else {
        $coursesString = $coursesString.", ".$course;
    }
    

}

$discountedAmount = 0;

if (sizeof($courses) == 2) {
    $discountedAmount = $totalAmount - ((TWO_COURSES_DISCOUNT / 100) * $totalAmount);
}else{
    $discountedAmount = $totalAmount - ((THREE_COURSES_DISCOUNT / 100) * $totalAmount);
}


$isIdOrderValid = $validatorString->validate($idOrder);

if(!$isIdOrderValid){
    echo response_parameters_invalid(time());
    return;
}

$isRazorpayOrderIdValid = $validatorString->validate($razorpayOrderId);

if(!$isRazorpayOrderIdValid){
    echo response_parameters_invalid(time());
    return;
}

$isRazorpayPaymentIdValid = $validatorString->validate($razorpayPaymentId);

if(!$isRazorpayPaymentIdValid){
    echo response_parameters_invalid(time());
    return;
}

$isRazorpaySignatureValid = $validatorString->validate($razorpaySignature);

if(!$isRazorpaySignatureValid){
    echo response_parameters_invalid(time());
    return;
}

//Get idUser from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

$userName = getSingleValue($db, "SELECT name FROM usersmaster WHERE id = ?", [$idUser]);

$serviceUpdateBundlePaymentStatus->serve($db, $idUser, $courses, $idOrder, $razorpayOrderId, $razorpayPaymentId, $razorpaySignature);

$mailSubject = "User Enrolled for Course Bundle";
$mailContent = str_replace("[USER_NAME]", $userName, USER_ENROLLED_BUNDLE_MAIL_FORMAT);
$mailContent = str_replace("[COURSES]", $coursesString, $mailContent);
$mailContent = str_replace("[AMOUNT]", $discountedAmount, $mailContent);
send_mail_to(ADMIN_MAIL_ID, $mailSubject, $mailContent);

echo response_ok($idUser, time());

function isJson($string) {
    json_decode($string);
    return json_last_error() === JSON_ERROR_NONE;
}

?> 