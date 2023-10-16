<?php

class ServiceUpdateUserCourseActivity{
    
    
    public function serve($db, $id, $idSchedule, $idUser, $idStatus, $createTimestamp, $updateTimestamp, $progress, $idCourse) {

        if($id == NULL){
            $sql = "Insert into UserActivity (idSchedule, idUser, idStatus, createTimestamp, idCourse) values ($idSchedule, $idUser, $idStatus, $createTimestamp, $idCourse);";
        }else{
            $sql = "Update UserActivity SET idStatus = $idStatus, updateTimestamp = $updateTimestamp, progress = $progress where id = $id;";
        }

        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);


        $id = getSingleValue($db, "SELECT id FROM UserActivity WHERE idSchedule = ? AND idUser = ? ORDER BY createTimestamp DESC LIMIT 1", [$idSchedule, $idUser]);

        
		return $id;


        
    }
    
}

?>