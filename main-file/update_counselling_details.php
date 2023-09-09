<?php
include './globals/constants_counselling_updated_email_db.php';
include './components/component_update_counselling_details.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_update_counselling_details.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
include './utilities/send_email.php';
include './zoom/create-meeting-counselling.php';
insertCorsHeaders();
  

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

// $entityBody = file_get_contents('php://input'); 
$start_time = "";
$start_time = post_params("start_time");
$slots = "";
$slots = post_params("slots");
$zoom_id = "";
$zoom_id = 3;



date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceUpdateCounsellingDetails = new ServiceUpdateCounsellingDetails();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();

// $isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
// if ($isTokenValid == 0) {
//     echo response_unauthorized(time());
//     return;
// }

$idCounsellingSession = "";
$idCounsellingSession = post_params("idCounsellingSession");

$meetingDescription = "";
$meetingDescription = post_params("meetingDescription");

$meetingLink = "";
$meetingLink = post_params("meetingLink");

$meetingTimestamp = "";




//Check whether idCounsellingSession is numeric or not
if(!is_numeric($idCounsellingSession)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idCounsellingSession exists or not
$rowCountCounsellingSession = $serviceCheckRecordExistsInTable->serve($db, "CounsellingSessions", $idCounsellingSession);
if ($rowCountCounsellingSession == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check id of Faculty from rolesmaster
$idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);


//Check role of user from usersmaster
$idRole = getSingleValue($db, "SELECT idRole FROM usersmaster WHERE id = ?", [$idUser]);


// if($idRole != $idFacultyMaster){
//     echo response_unauthorized(time());
//     return;
// }

//Get idFaculty of from FacultyMaster
$idFaculty = getSingleValue($db, "SELECT id FROM FacultyMaster WHERE idUser = ?", [$idUser]);

//Get idFaculty of from CounsellingSessions
$idFacultyCounsellingSessions = getSingleValue($db, "SELECT idFaculty FROM CounsellingSessions WHERE id = ?", [$idCounsellingSession]);

// if($idFaculty != $idFacultyCounsellingSessions){
//     echo response_unauthorized(time());
//     return;
// }




$idFacultyUser = getSingleValue($db, "SELECT idUser FROM FacultyMaster WHERE id = ?", [$idFaculty]);
$facultyEmail = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idFacultyUser]);

$idStudentUser = getSingleValue($db, "SELECT idUser FROM CounsellingSessions WHERE id = ?", [$idCounsellingSession]);
$studentEmail = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idStudentUser]);
$studentName = getSingleValue($db, "SELECT name FROM usersmaster WHERE id = ?", [$idStudentUser]);

$idCourse = getSingleValue($db, "SELECT idCourse FROM CounsellingSessions WHERE id = ?", [$idCounsellingSession]);
$courseName = getSingleValue($db, "SELECT name FROM CoursesMaster WHERE id = ?", [$idCourse]);
$timestampC = strtotime($start_time);
$datetimeFormat = 'Y-m-d H:i:s';
$date = new \DateTime();
$date->setTimestamp($timestampC);
$meetingTime = $date->format($datetimeFormat);



$mailSubject = "Counselling Session scheduled";

$mailContent = str_replace("[COURSE]", $courseName, COUNSELLING_UPDATED_MAIL_FORMAT);
$mailContent = str_replace("[START_TIME]", $meetingTime, $mailContent);
$mailContent = str_replace("[STUDENT_NAME]", $studentName, $mailContent);

send_mail_to($facultyEmail, $mailSubject, $mailContent);
send_mail_to($studentEmail, $mailSubject, $mailContent);

$ServiceUpdateCounsellingDetailsMeetingData = new ServiceUpdateCounsellingDetailsMeeting();
$dataC = $ServiceUpdateCounsellingDetailsMeetingData->create_meeting($start_time,$studentName);
// $datadecode = json_decode($dataC);
// print_r($dataC->topic);
// die;
if (empty($dataC->id)) {
    echo response_not_found(time());
    return;
}

$serviceUpdateCounsellingDetails->serve($db, $idCounsellingSession, $dataC->topic, $dataC->id, $timestampC, $zoom_id,$slots);

echo response_ok($idCounsellingSession, time());

?> 