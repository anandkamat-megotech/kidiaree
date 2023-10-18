<?php

class ServiceGetCourseByFaculty{
    
    
    public function serve($db, $userId) {
        $sql = "SELECT * FROM CoursesMaster WHERE isActive=1 AND idFaculty = ".$userId.";";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    
        for ($i=0; $i < count($result) ; $i++) { 

            $id = $result[$i]['id'];
           
            $sqlSessionCount = "Select id from SchedulesMaster where idCourse = $id AND idPrerecordedSession IS NOT NULL;";
            $statementSessionCount = query_execute($db, $sqlSessionCount);
            $sessionCount = $statementSessionCount->rowCount();

            $sqlMilestoneCount = "Select id from SchedulesMaster where idCourse = $id AND idMilestone IS NOT NULL;";
            $statementMilestoneCount = query_execute($db, $sqlMilestoneCount);
            $milestoneCount = $statementMilestoneCount->rowCount(); 
            
            $sqlLiveSessionCount = "Select id from SchedulesMaster where idCourse = $id AND idPrerecordedSession IS NOT NULL AND idLiveSession = 1;";
            $statementLiveSessionCount = query_execute($db, $sqlLiveSessionCount);
            $liveSessionCount = $statementLiveSessionCount->rowCount();
            
            $result[$i]['sessionCount'] = $sessionCount;
            $result[$i]['milestoneCount'] = $milestoneCount;
            $result[$i]['liveSessionCount'] = $liveSessionCount;
            $result[$i]['idCourse'] =  $id;

        }
        $json = json_encode($result);
        return $json;
        

    }
    
}

?>