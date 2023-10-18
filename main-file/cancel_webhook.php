<?php

include './globals/constants_counselling_cancelled_email_db.php';
include './components/component_cancel_webhook.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_cancel_appointment.php';
include './services/service_cancel_live_session.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/get_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';
include './utilities/send_email.php';


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
$serviceCancelAppointment = new ServiceCancelAppointment();
$serviceCancelLiveSession = new ServiceCancelLiveSession();


$entityBody = file_get_contents('php://input');

$jsonObj = json_decode($entityBody);  

$slug = $jsonObj->payload->event_type->slug;

$idCourse = "";
$idUser = "";
$idPrerecordedSession = "";

if($slug == CALENDLY_SLUG_APPOINTMENT){
    $idCourse = $jsonObj->payload->tracking->utm_source;


    $idUser = $jsonObj->payload->tracking->utm_medium;

    //Check whether idCourse is numeric or not
    if(!is_numeric($idCourse)){
        echo response_parameters_invalid(time());
        return;
    }

    //Check whether idCourse exists or not
    $rowCountIdCourseCount = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
    if ($rowCountIdCourseCount == 0) {
        echo response_not_found(time());
        return;
    }

    //Check whether idUser is numeric or not
    if(!is_numeric($idUser)){
        echo response_parameters_invalid(time());
        return;
    }

    //Check whether idUser exists or not
    $rowCountIdUserCount = $serviceCheckRecordExistsInTable->serve($db, "usersmaster", $idUser);
    if ($rowCountIdUserCount == 0) {
        echo response_not_found(time());
        return;
    }
}else{
    $idPrerecordedSession = $jsonObj->payload->tracking->utm_source;

    //Check whether idPrerecordedSession is numeric or not
    if(!is_numeric($idPrerecordedSession)){
        echo response_parameters_invalid(time());
        return;
    }

    //Check whether idPrerecordedSession exists or not
    $rowCountIdPrerecordedSessionCount = $serviceCheckRecordExistsInTable->serve($db, "PrerecordedSessionsMaster", $idPrerecordedSession);
    if ($rowCountIdPrerecordedSessionCount == 0) {
        echo response_not_found(time());
        return;
    }
}



if($slug == CALENDLY_SLUG_APPOINTMENT){

    //Get idCounsellingSession from CounsellingSessions
    $idCounsellingSession = getSingleValue($db, "SELECT id FROM CounsellingSessions WHERE idUser = ? AND idCourse = ?", [$idUser, $idCourse]);

    $serviceCancelAppointment->serve($db, $idCounsellingSession);

    //Get idFaculty from CoursesMaster
    $idFaculty = getSingleValue($db, "SELECT idFaculty FROM CoursesMaster WHERE id = ?", [$idCourse]);
    
    $idFacultyUser = getSingleValue($db, "SELECT idUser FROM FacultyMaster WHERE id = ?", [$idFaculty]);
    $facultyEmail = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idFacultyUser]);
    $studentEmail = getSingleValue($db, "SELECT email FROM usersmaster WHERE id = ?", [$idUser]);
    $courseName = getSingleValue($db, "SELECT name FROM CoursesMaster WHERE id = ?", [$idCourse]);
    $studentName = getSingleValue($db, "SELECT name FROM usersmaster WHERE id = ?", [$idUser]);
    //Send mail to Faculty and student about cancelling a counselling session
    $mailSubject = "Counselling Session Cancelled";
    
    $mailContent = str_replace("[COURSE]", $courseName, COUNSELLING_CANCELLED_MAIL_FORMAT);
    $mailContent = str_replace("[STUDENT_NAME]", $studentName, $mailContent);
    
    send_mail_to($facultyEmail, $mailSubject, $mailContent);
    send_mail_to($studentEmail, $mailSubject, $mailContent);
}else{
    $serviceCancelLiveSession->serve($db, $idPrerecordedSession);
}


echo response_ok(time());

?> 