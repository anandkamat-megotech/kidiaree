<?php

include './components/component_careers.php';
include './services/service_base.php';
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

$firstName = "";
$firstName = post_params("firstName");

$lastName = "";
$lastName = post_params("lastName");

$email = "";
$email = post_params("email");

$phone = "";
$phone = post_params("phone");

$message = "";
$message = post_params("message");

$isFirstNameValid = $validatorString->validate($firstName);

if(!$validatorString->checkemail($email)){
    echo response_parameters_invalid_email(time());
    return;
}

if(!$isFirstNameValid){
    echo response_parameters_invalid(time());
    return;
}

$isLastNameValid = $validatorString->validate($lastName);

if(!$isLastNameValid){
    echo response_parameters_invalid(time());
    return;
}

$isEmailValid = $validatorString->validate($email);

if(!$isEmailValid){
    echo response_parameters_invalid(time());
    return;
}

$isPhoneValid = $validatorString->validate($phone);

if(!$isPhoneValid){
    echo response_parameters_invalid(time());
    return;
}

$isMessageValid = $validatorString->validate($message);

if(!$isMessageValid){
    echo response_parameters_invalid(time());
    return;
}

$recipientMailAddress = CONTACT_US_MAIL;
$mailSubject = 'BrickETC Careers Enquiry';
$mailContent = "First Name: ".$firstName."<br/>Last Name: ".$lastName."<br/>Email: ".$email."<br/>Phone: ".$phone."<br/>Message: ".$message."<br/><br/>";

send_mail_to($recipientMailAddress, $mailSubject, $mailContent);

echo response_ok(time());


?> 