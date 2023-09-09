<?php

include './components/component_get_question.php';
include './services/service_base.php';
include './services/service_get_question.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceGetQuestion = new serviceGetQuestion();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idQuestion = "";
$idQuestion = post_params("idQuestion");

//Check whether idQuestion is numeric or not
if(!is_numeric($idQuestion)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idQuestion exists or not
$rowCountQuestion = $serviceCheckRecordExistsInTable->serve($db, "Questions", $idQuestion);
if ($rowCountQuestion == 0) {
    echo response_not_found(time());
    return;
}


$json = $serviceGetQuestion->serve($db, $idQuestion);

echo response_ok($json, time());

?> 