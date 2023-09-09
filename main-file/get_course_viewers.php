<?php

include './components/component_get_course_viewers.php';
include './services/service_base.php';
include './services/service_get_course_viewers.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();

date_default_timezone_set(TIME_ZONE);
$serviceGetCourseViewers = new ServiceGetCourseViewers();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

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

$viewers = $serviceGetCourseViewers->serve($db, $idCourse);

echo response_ok($viewers, time());

?> 