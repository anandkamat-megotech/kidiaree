<?php

include './components/component_start_faculty_review.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_start_faculty_review.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceStartFacultyReview = new ServiceStartFacultyReview();


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

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether user is faculty or not
$idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);

$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);

if($idRole != $idFacultyMaster){
    echo response_unauthorized(time());
    return;
}

//Get idFaculty of user
$idFaculty = getSingleValue($db, "SELECT id FROM FacultyMaster WHERE idUser = ?", [$idUser]);

$idFacultyAssignmentSubmission = getSingleValue($db, "SELECT idFaculty FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);

if($idFaculty != $idFacultyAssignmentSubmission){
    echo response_unauthorized(time());
    return;
}

$idUnderReviewStatus = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ["Under Review"]);

$serviceStartFacultyReview->serve($db, $idAssignmentSubmission, $idUnderReviewStatus);

echo response_ok($idAssignmentSubmission, time());

?> 