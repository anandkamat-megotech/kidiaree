<?php

include './components/component_get_assignment_submission_details.php';
include './services/service_base.php';
include './services/service_get_courses.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_get_assignment_submission_details.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetAssignmentSubmissionDetails = new ServiceGetAssignmentSubmissionDetails();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$id = "";
$id = post_params("id");

//Check whether id is numeric or not
if(!is_numeric($id)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether id exists or not
$rowCountAssignmentSubmission = $serviceCheckRecordExistsInTable->serve($db, "AssignmentSubmissionsMapping", $id);
if ($rowCountAssignmentSubmission == 0) {
    echo response_not_found(time());
    return;
}

//Get Assignment id of from AssignmentSubmissionsMapping
$idAssignment = getSingleValue($db, "SELECT idAssignment FROM AssignmentSubmissionsMapping WHERE id = ?", [$id]);

//Get course id of from AssignmentSubmissionsMapping
$idCourse = getSingleValue($db, "SELECT idCourse FROM AssignmentSubmissionsMapping WHERE id = ?", [$id]);

//Get schedule id of from SchedulesMaster
$assignmentSequenceNumber = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idAssignment = ? AND idCourse = ?", [$idAssignment, $idCourse]);

$idMilestone = getSingleValue($db, "SELECT idMilestone FROM SchedulesMaster WHERE sequenceNumber > ? AND idCourse = $idCourse ORDER BY sequenceNumber ASC LIMIT 1", [$assignmentSequenceNumber]);

$json = $serviceGetAssignmentSubmissionDetails->serve($db, $id, $idMilestone);

echo response_ok($json, time());

?> 