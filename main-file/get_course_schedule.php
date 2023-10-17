<?php
include './globals/constants_config.php';
include './components/component_get_course_schedule.php';
include './services/service_base.php';
include './services/service_check_token_validity.php';
include './services/service_get_course_schedule.php';
include './services/service_get_course_schedule_without_login.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';


$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceGetCourseSchedule = new ServiceGetCourseSchedule();
$serviceGetCourseScheduleWithoutLogin = new ServiceGetCourseScheduleWithoutLogin();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$token = getBearerToken();



$idCourse = "";
$idCourse = post_params("idCourse");

//Check whether idCourse is numeric or not
if(!is_numeric($idCourse)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idCourse exists or not
$rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountCourse == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usersmaster
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);



if($idUser == '')
{   
    
    $json = $serviceGetCourseScheduleWithoutLogin->serve($db, $idCourse);
}
else{
   
   $json = $serviceGetCourseSchedule->serve($db, $idCourse, $idUser);
}
echo response_ok(json_encode($json), time());

?> 