<?php
include './globals/constants_send_otp_email_db.php';
include './globals/constants_new_user_registered_email_db.php';
include './components/component_get_faculty.php';
include './services/service_base.php';
include './services/service_check_value_exists_in_table.php';
include './services/service_get_kids.php';
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
$serviceGetKids = new ServiceGetKids();
$kid_id = '';
$id = post_params("id");

// $k_name = post_params("k_name");
// $k_dob_start = post_params("k_dob");
// $gender = post_params("gender");
// $grade = post_params("grade");
// $kid_id = post_params("kid_id");


//Generate OTP and update in database
$data = $serviceGetKids->serve($db, $id);

echo response_ok($data, time());


?> 
