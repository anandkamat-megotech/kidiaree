<?php

include './components/component_get_subject_faculty.php';
include './services/service_base.php';
include './services/service_get_subject_faculty.php';
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
$serviceGetSubjectFaculty = new ServiceGetSubjectFaculty();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();

$idSubject = "";
$idSubject = post_params("idSubject");

//Check whether idSubject is numeric or not
if(!is_numeric($idSubject)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idSubject exists or not
$rowCountSubject = $serviceCheckRecordExistsInTable->serve($db, "SubjectsMaster", $idSubject);
if ($rowCountSubject == 0) {
    echo response_not_found(time());
    return;
}

$json = $serviceGetSubjectFaculty->serve($db, $idSubject);

echo response_ok($json, time());

?> 