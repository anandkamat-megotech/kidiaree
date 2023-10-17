<?php

class ServiceGetUnsubscribedCourses{
    
    
    public function serve($db, $idUser) {
        $sql = "Select CoursesMaster.id AS idCourse, CoursesMaster.name, CoursesMaster.idSubject, CoursesMaster.info, CoursesMaster.amount, CoursesMaster.amountUsd, CoursesMaster.imageUrl, CoursesMaster.duration, SubjectsMaster.name AS subjectName from CoursesMaster, SubjectsMaster WHERE CoursesMaster.idSubject = SubjectsMaster.id AND CoursesMaster.isActive=1 AND CoursesMaster.id not in(SELECT idCourse from UserCoursePaymentMapping where idUser=$idUser);";
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

            $sqlLiveSessionCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idPrerecordedSession IS NOT NULL AND idLiveSession = 1;";
            $statementLiveSessionCount = query_execute($db, $sqlLiveSessionCount);
            $liveSessionCount = $statementLiveSessionCount->rowCount();
            
            $result[$i]['sessionCount'] = $sessionCount;
            $result[$i]['milestoneCount'] = $milestoneCount;
            $result[$i]['liveSessionCount'] = $liveSessionCount;
            
        }

        function utf8ize($d) {
            if (is_array($d)) {
                foreach ($d as $k => $v) {
                    $d[$k] = utf8ize($v);
                }
            } else if (is_string ($d)) {
                return utf8_encode($d);
            }
            return $d;
        }
        $json = json_encode(utf8ize($result));

        return $json;
    }
    
}

?>