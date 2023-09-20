<?php
include './globals/constants_send_otp_email_db.php';
include './globals/constants_new_user_registered_email_db.php';
include './components/component_validate_email.php';
include './services/service_base.php';
include './services/service_check_value_exists_in_table.php';
include './services/service_add_enquiry.php';
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
$serviceAddEnquiry = new ServiceAddEnquiry();
$kid_id = '';
$en_name = post_params("en_name");
$en_contact = post_params("en_contact");
$en_email = post_params("en_email");


//Generate OTP and update in database
$serviceAddEnquiry->serve($db, $en_name, $en_contact,$en_email);

echo response_ok('204', time());


?> 
