<?php

ob_start();

include './components/component_view_assignment_submission.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
ob_end_clean();

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


$token = "";
$token = get_params("token");

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idAssignmentSubmission = "";
$idAssignmentSubmission = get_params("idAssignmentSubmission");

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

//Get facultyAttachmentUrl of from AssignmentSubmissionsMapping
$facultyAttachmentUrl = getSingleValue($db, "SELECT facultyAttachmentUrl FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);
$format = substr( $facultyAttachmentUrl, -3 );
$format = strtolower($format);

if ($format == "pdf") {
    header('content-type:application/pdf');
}

if ($format == "jpg" || $format == "peg") {
    header('content-type:image/jpeg');
}

if ($format == "png") {
    header('content-type:image/png');
}



$pdf = (file_get_contents($facultyAttachmentUrl));
echo $pdf;

?> 