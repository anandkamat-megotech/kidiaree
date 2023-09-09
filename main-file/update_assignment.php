<?php
include './globals/constants_assignment_submitted_email_db.php';
include './components/component_update_assignment.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_assignment.php';
include './services/service_upload_to_cloud.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_check_user_assignment_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
include './utilities/send_email.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceCheckUserAssignmentExistsInTable = new ServiceCheckUserAssignmentExistsInTable();
$serviceUpdateAssignment = new ServiceUpdateAssignment();
$serviceUploadToCloud = new ServiceUploadToCloud();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$studentRemarks = "";
$studentRemarks = clean(post_params("studentRemarks"));

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


$isStudentRemarksValid = $validatorString->validate($studentRemarks);

if(!$isStudentRemarksValid){
    echo response_parameters_invalid(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

$idUserAssignmentSubmissionMapping = getSingleValue($db, "SELECT idUser FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);

if($idUser != $idUserAssignmentSubmissionMapping){
    echo response_unauthorized(time());
    return;
}

//Get idCourse of from AssignmentSubmissionsMapping
$idCourse = getSingleValue($db, "SELECT idCourse FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);

//Get idAssignment of from AssignmentSubmissionsMapping
$idAssignment = getSingleValue($db, "SELECT idAssignment FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);

//Get assignment sequence number from SchedulesMaster
$assignmentSequenceNumber = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idAssignment = ? AND idCourse = ?", [$idAssignment, $idCourse]);


$idPrerecordedSession = getSingleValue($db, "SELECT idPrerecordedSession FROM SchedulesMaster WHERE sequenceNumber < ? AND idCourse = $idCourse ORDER BY sequenceNumber DESC LIMIT 1", [$assignmentSequenceNumber]);

$idFaculty = getSingleValue($db, "SELECT idFaculty FROM CoursesMaster WHERE id = ?", [$idCourse]);
$idFacultyUser = getSingleValue($db, "SELECT idUser FROM FacultyMaster WHERE id = ?", [$idFaculty]);
$facultyEmail = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idFacultyUser]);

$ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
$filename = $idUser.'_'.$idCourse.'_'.$idAssignment.'_'.time().'.'.$ext;

$uploaddir = "cache/";
$uploadfile = $uploaddir . $filename;

if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
{
    echo response_parameters_invalid(time());
    return;
}


//upload file to google cloud storage
$studentAttachmentUrl = $serviceUploadToCloud->serve('cache//'.$filename, $uploadfile, "assignments");

//Get id of status completed
$idStatusCompleted = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ['Submitted']);

$id = $serviceUpdateAssignment->serve($db, $idAssignmentSubmission, $studentRemarks, $studentAttachmentUrl, $idStatusCompleted);


$studentEmail = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idUser]);
$courseName = getSingleValue($db, "SELECT name FROM CoursesMaster WHERE id = ?", [$idCourse]);
$idMilestone = getSingleValue($db, "SELECT idMilestone FROM SchedulesMaster WHERE idMilestone IS NOT NULL AND idCourse = ? AND sequenceNumber > ? LIMIT 1", [$idCourse, $assignmentSequenceNumber]);

$milestoneName = getSingleValue($db, "SELECT name FROM MilestonesMaster WHERE id = ?", [$idMilestone]);

//Send mail to Faculty about submitting an assignment
$mailSubject = "Assignment Submitted";

$mailContent = str_replace("[COURSE]", $courseName, ASSIGNMENT_SUBMITTED_MAIL_FORMAT);
$mailContent = str_replace("[ASSIGNMENT_ID]", $idAssignmentSubmission, $mailContent);
$mailContent = str_replace("[MILESTONE]", $milestoneName, $mailContent);



send_mail_to($facultyEmail, $mailSubject, $mailContent);
send_mail_to($studentEmail, $mailSubject, $mailContent);

echo response_ok($id, time());

?> 