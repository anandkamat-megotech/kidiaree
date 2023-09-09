<?php
include './globals/constants_assignment_needs_improvement_email_db.php';
include './components/component_reject_assignment.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_reject_assignment.php';
include './services/service_upload_to_cloud.php';
include './services/service_check_record_exists_in_table.php';
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
$serviceRejectAssignment = new ServiceRejectAssignment();
$serviceUploadToCloud = new ServiceUploadToCloud();


$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idAssignmentSubmission = "";
$idAssignmentSubmission = post_params("idAssignmentSubmission");

$review = "";
$review = clean(post_params("review"));


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


$isReviewValid = $validatorString->validate($review);

if(!$isReviewValid){
    echo response_parameters_invalid(time());
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

$idNeedsImprovementStatus = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ["Needs Improvement"]);

$idStudent = getSingleValue($db, "SELECT idUser FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);

$emailStudent = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idStudent]);
$emailFaculty = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idUser]);
$idAssignment = getSingleValue($db, "SELECT idAssignment FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);
$idCourse = getSingleValue($db, "SELECT idCourse FROM AssignmentSubmissionsMapping WHERE id = ?", [$idAssignmentSubmission]);

$courseName = getSingleValue($db, "SELECT name FROM CoursesMaster WHERE id = ?", [$idCourse]);

$facultyReviewAttachmentUrl = "";
if (!empty($_FILES['file']['name']))
{
    $filename = $idStudent.'_'.$idCourse.'_'.$idAssignment.'_review_'.time().'.pdf';

    $uploaddir = "cache/";
    $uploadfile = $uploaddir . $filename;
    $ext = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);

    if(!move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile))
    {
        echo response_parameters_invalid(time());
        return;
    }

    //upload file to google cloud storage
    $facultyReviewAttachmentUrl = $serviceUploadToCloud->serve('cache//'.$filename, $uploadfile, "assignments");

}



$serviceRejectAssignment->serve($db, $idAssignmentSubmission, $review, $idNeedsImprovementStatus, $facultyReviewAttachmentUrl);

$scheduleSequenceNumber = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idAssignment = ? AND idCourse = ?", [$idAssignment, $idCourse]);

$idMilestone = getSingleValue($db, "SELECT idMilestone FROM SchedulesMaster WHERE idMilestone IS NOT NULL AND idCourse = ? AND sequenceNumber > ? LIMIT 1", [$idCourse, $scheduleSequenceNumber]);

$milestoneName = getSingleValue($db, "SELECT name FROM MilestonesMaster WHERE id = ?", [$idMilestone]);
$idFacultyCourse = getSingleValue($db, "SELECT idFaculty FROM CoursesMaster WHERE id = ?", [$idCourse]);


//Send mail to student about rejection of assignment
$mailSubject = "Assignment Needs Improvement";

$mailContent = str_replace("[COURSE]", $courseName, ASSIGNMENT_NEEDS_IMPROVEMENT_MAIL_FORMAT);
$mailContent = str_replace("[MILESTONE]", $milestoneName, $mailContent);

send_mail_to($emailStudent, $mailSubject, $mailContent);



echo response_ok($idAssignmentSubmission, time());

?> 