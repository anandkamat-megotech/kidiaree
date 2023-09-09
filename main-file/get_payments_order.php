<?php

include './components/component_get_user_profile.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_payments_order.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetPaymentsOrder = new ServiceGetPaymentsOrder();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();
$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}
$teacher  = "";
if(!empty($_GET['teacher'])){
    $teacher = $_GET['teacher'];
}
$date  = "";
if(!empty($_GET['date'])){
    $date = $_GET['date'];
}
$from  = "";
if(!empty($_GET['from'])){
    $from = $_GET['from'];
}

$to  = "";
if(!empty($_GET['to'])){
    $to = $_GET['to'];
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

$json = $serviceGetPaymentsOrder->serve($db, $teacher, $date, $from, $to);

echo response_ok($json, time());

?> 