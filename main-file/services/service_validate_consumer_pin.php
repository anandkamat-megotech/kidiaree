<?php

class ServiceValidateConsumerPin{
    
    
    public function serve($db, $idUser) {

        $sql = "Select id, name, email, mobile, idRole, profilePictureUrl from usersmaster WHERE id = $idUser;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $sqlCourses = "Select UserCoursePaymentMapping.id, UserCoursePaymentMapping.idCourse, CoursesMaster.name, CoursesMaster.duration, CoursesMaster.imageUrl, CoursesMaster.idSubject from CoursesMaster, UserCoursePaymentMapping WHERE UserCoursePaymentMapping.idUser = $idUser AND UserCoursePaymentMapping.idCourse = CoursesMaster.id;";
        $statementCourses = query_execute($db, $sqlCourses);
        $resultCourses = $statementCourses->fetchAll(\PDO::FETCH_ASSOC);

        for ($i=0; $i < count($resultCourses) ; $i++) { 
            $idCourse =  $resultCourses[$i]['idCourse'];
            $isCompleted = getSingleValue($db, "SELECT id FROM Certificates WHERE idUser = ? AND idCourse = ?", [$idUser, $idCourse]);
            if($isCompleted != ''){
                $resultCourses[$i]['isCompleted'] = 1;
            }else{
                $resultCourses[$i]['isCompleted'] = 0;
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
            
            $resultCourses[$i]['sessionCount'] = $sessionCount;
            $resultCourses[$i]['milestoneCount'] = $milestoneCount;
            $resultCourses[$i]['liveSessionCount'] = $liveSessionCount;
        }
        $result[0]['courses'] = $resultCourses;
        $json = json_encode($result);
		return $json;


        
    }
    
}

?>