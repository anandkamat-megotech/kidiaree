<?php

class ServiceGetAllCourses{
    
    
    public function serve($db) {
        $sql = "Select CoursesMaster.id AS idCourse, CoursesMaster.name, CoursesMaster.idSubject, CoursesMaster.info, CoursesMaster.amount, CoursesMaster.amountUsd, CoursesMaster.imageUrl, CoursesMaster.duration, SubjectsMaster.name AS subjectName from CoursesMaster, SubjectsMaster WHERE CoursesMaster.idSubject = SubjectsMaster.id AND CoursesMaster.isActive=1;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
		

        for ($i=0; $i < count($result) ; $i++) { 

            $idCourse = $result[$i]['idCourse'];
            $sqlSessionCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idPrerecordedSession IS NOT NULL;";
            $statementSessionCount = query_execute($db, $sqlSessionCount);
            $sessionCount = $statementSessionCount->rowCount();

            $sqlMilestoneCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idMilestone IS NOT NULL;";
            $statementMilestoneCount = query_execute($db, $sqlMilestoneCount);
            $milestoneCount = $statementMilestoneCount->rowCount();    

            $sqlLiveSessionCount = "Select SchedulesMaster.id from SchedulesMaster, PrerecordedSessionsMaster where SchedulesMaster.idCourse = $idCourse AND SchedulesMaster.idPrerecordedSession = PrerecordedSessionsMaster.id AND PrerecordedSessionsMaster.isLive = 1;";
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