<?php

include './components/component_get_faculty.php';
include './services/service_base.php';
include './services/service_get_single_faculty.php';
include './services/service_check_record_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';

insertCorsHeaders();
if(strcmp($_SERVER['REQUEST_METHOD'],'OPTIONS') == 0){
    exit(0);
}

$serviceBase = new ServiceBase();
$serviceGetSingleFaculty = new ServiceGetSingleFaculty();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$db = $serviceBase->getDb();

$id = "";
$id = post_params("id");

//Check whether id is numeric or not
if(!is_numeric($id)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether id exists or not
$rowCountId = $serviceCheckRecordExistsInTable->serve($db, "FacultyMaster", $id);
if ($rowCountId == 0) {
    echo response_not_found(time());
    return;
}

date_default_timezone_set(TIME_ZONE);


$json = $serviceGetSingleFaculty->serve($db, $id);

echo response_ok($json, time());

?> 