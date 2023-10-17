<?php
include './globals/constants_send_otp_email_db.php';
include './globals/constants_new_user_registered_email_db.php';
include './components/component_validate_email.php';
include './services/service_base.php';
include './services/service_check_value_exists_in_table.php';
include './services/service_update_parent.php';
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
$serviceUpdateParent = new ServiceUpdateParent();
$p_name = post_params("p_name");
$email = post_params("email");
$p_id = post_params("p_id");


//Generate OTP and update in database
$otp = $serviceUpdateParent->serve($db, $p_name, $email, $p_id);

echo response_ok($p_id, time());


?> 
