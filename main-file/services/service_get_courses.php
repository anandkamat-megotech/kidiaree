<?php

class ServiceGetCourses{
    
    
    public function serve($db, $idSubject) {
        $sql = "Select id, name, duration, amount, info, idSubject, rating, idLevel, imageUrl from CoursesMaster WHERE idSubject = $idSubject AND isActive=1;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        

        for ($i=0; $i < count($result) ; $i++) { 

            $idCourse = $result[$i]['id'];
            $sqlSessionCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idPrerecordedSession IS NOT NULL;";
            $statementSessionCount = query_execute($db, $sqlSessionCount);
            $sessionCount = $statementSessionCount->rowCount();

            $sqlMilestoneCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idMilestone IS NOT NULL;";
            $statementMilestoneCount = query_execute($db, $sqlMilestoneCount);
            $milestoneCount = $statementMilestoneCount->rowCount();    

            $sqlLiveSessionCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idPrerecordedSession IS NOT NULL AND idLiveSession = 1;";
            $statementLiveSessionCount = query_execute($db, $sqlLiveSessionCount);
            $liveSessionCount = $statementLiveSessionCount->rowCount();
            
            $result[$i]['sessionCount'] = $sessionCount;
            $result[$i]['milestoneCount'] = $milestoneCount;
            $result[$i]['liveSessionCount'] = $liveSessionCount;
            
        }

        $json = json_encode($result);
		return $json;
    }
    
}

?>