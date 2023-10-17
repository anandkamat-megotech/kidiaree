<?php

include './components/component_get_assignment_details.php';
include './services/service_base.php';
include './services/service_get_courses.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_get_assignment_details.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetAssignmentDetails = new ServiceGetAssignmentDetails();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}



$idAssignment = "";
$idAssignment = post_params("idAssignment");

//Check whether idAssignment is numeric or not
if(!is_numeric($idAssignment)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idAssignment exists or not
$rowCountAssignment = $serviceCheckRecordExistsInTable->serve($db, "AssignmentsMaster", $idAssignment);
if ($rowCountAssignment == 0) {
    echo response_not_found(time());
    return;
}

$json = $serviceGetAssignmentDetails->serve($db, $idAssignment);

echo response_ok($json, time());

?> 