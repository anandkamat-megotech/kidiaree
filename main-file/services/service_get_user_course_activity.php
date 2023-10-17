<?php

class ServiceGetUserCourseActivity{
    
    
    public function serve($db, $idCourse, $idUser) {

        $sql = "Select UserActivity.id, UserActivity.idSchedule, UserActivity.idUser, UserActivity.idStatus, StatusMaster.name, UserActivity.createTimestamp, UserActivity.updateTimestamp, UserActivity.progress from UserActivity, SchedulesMaster, StatusMaster where SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.id = UserActivity.idSchedule AND UserActivity.idStatus = StatusMaster.id AND UserActivity.idUser = $idUser;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);

        
		return $json;


        
    }
    
}

?>