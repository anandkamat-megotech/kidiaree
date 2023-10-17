<?php

include './components/component_validate_consumer_pin.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_validate_consumer_pin.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceValidateConsumerPin = new ServiceValidateConsumerPin();


$consumerPin = "";
$consumerPin = get_params("consumerPin");

$password = "";
$password = get_params("password");

$isConsumerPinNonEmpty = $validatorString->validate($consumerPin);

if(!$isConsumerPinNonEmpty){
    echo response_parameters_invalid(time());
    return;
}

$isPasswordNonEmpty = $validatorString->validate($password);

if(!$isPasswordNonEmpty){
    echo response_parameters_invalid(time());
    return;
}

if($password != CONSUMER_PIN_PASSWORD){
    echo response_parameters_invalid(time());
    return;
}


//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT id FROM usersmaster WHERE consumerPin = ?", [$consumerPin]);


if(empty($idUser)){
    echo response_not_found(time());
    return;
}


$id = $serviceValidateConsumerPin->serve($db, $idUser);

echo response_ok($id, time());

?> 