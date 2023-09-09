<?php

class ServiceGetCourseDetails{
    
    
    public function serve($db, $idCourse) {

        $sql = "Select * from CoursesMaster where id = $idCourse;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $sqlSessionCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idPrerecordedSession IS NOT NULL;";
        $statementSessionCount = query_execute($db, $sqlSessionCount);
        $sessionCount = $statementSessionCount->rowCount();

        $sqlMilestoneCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idMilestone IS NOT NULL;";
        $statementMilestoneCount = query_execute($db, $sqlMilestoneCount);
        $milestoneCount = $statementMilestoneCount->rowCount(); 
        
        $sqlLiveSessionCount = "Select SchedulesMaster.id from SchedulesMaster, PrerecordedSessionsMaster where SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idPrerecordedSession = PrerecordedSessionsMaster.id AND PrerecordedSessionsMaster.isLive = 1;";
        $statementLiveSessionCount = query_execute($db, $sqlLiveSessionCount);
        $liveSessionCount = $statementLiveSessionCount->rowCount();
        
        $result[0]['sessionCount'] = $sessionCount;
        $result[0]['milestoneCount'] = $milestoneCount;
        $result[0]['liveSessionCount'] = $liveSessionCount;
        $json = json_encode($result);
		return $json;
    }
    
}

?>