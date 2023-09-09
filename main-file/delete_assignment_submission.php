<?php

include './components/component_delete_assignment_submission.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_delete_assignment_submission.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceDeleteAssignmentSubmission = new ServiceDeleteAssignmentSubmission();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idAssignmentSubmission = "";
$idAssignmentSubmission = post_params("idAssignmentSubmission");

//Check whether idAssignmentSubmission is numeric or not
if(!is_numeric($idAssignmentSubmission)){
    echo response_parameters_invalid(time());
    return;
}


//Check whether idAssignmentSubmission exists or not
$rowCountAssignmentSubmission = $serviceCheckRecordExistsInTable->serve($db, "AssignmentSubmissionsMapping", $idAssignmentSubmission);
if ($rowCountAssignmentSubmission == 0) {
    echo response_not_found(time());
    return;
}

//Check whether idUser and logged in user is same or not
//Get idUser of from usertokenmapping
$idUserToken = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Get idUser of from AssignmentSubmissionsMapping
$idUserAssignmentSubmissionsMapping = getSingleValue($db, "SELECT idUser FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);

if($idUserToken != $idUserAssignmentSubmissionsMapping){
    echo response_unauthorized(time());
    return;
}

//Get id of status completed
$idStatusCompleted = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ['Submitted']);

//Get status of idAssignmentSubmission
$idStatus = getSingleValue($db, "SELECT status FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);

//Check whether status in AssignmentSubmissionsMapping is submitted or not

if($idStatusCompleted != $idStatus){
    echo response_unauthorized(time());
    return;
}


$serviceDeleteAssignmentSubmission->serve($db, $idAssignmentSubmission);

echo response_ok(time());

?> 