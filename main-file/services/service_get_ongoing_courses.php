<?php

class ServiceGetOngoingCourses{
    
    
    public function serve($db, $idUser) {

        $sql = "Select UserCoursePaymentMapping.idCourse, CoursesMaster.name, CoursesMaster.duration, CoursesMaster.imageUrl, CoursesMaster.info, CoursesMaster.idSubject from CoursesMaster, UserCoursePaymentMapping WHERE UserCoursePaymentMapping.idUser = $idUser AND  UserCoursePaymentMapping.idCourse = CoursesMaster.id;";
        
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $curTimestamp=time();
        for ($i=0; $i < count($result) ; $i++) { 
            $idCourse =  $result[$i]['idCourse'];
            $isCompleted = getSingleValue($db, "SELECT id FROM Certificates WHERE idUser = ? AND idCourse = ?", [$idUser, $idCourse]);
            $isExpired = getSingleValue($db, "SELECT id FROM UserCoursePaymentMapping WHERE idUser = ? AND idCourse = ? AND expiryTimestamp < ?", [$idUser, $idCourse, $curTimestamp]);
            
            if($isCompleted != '' || $isExpired != ''){
                $result[$i]['isCompleted'] = 1;
            }else{
                $result[$i]['isCompleted'] = 0;
            }

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