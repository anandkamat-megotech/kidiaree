<?php

class ServiceGetRandomCourses{
    
    public function serve($db) {

        $sqlId = "Select id from CoursesMaster;";
        $statementId = query_execute($db, $sqlId);
        $resultId = $statementId->fetchAll(\PDO::FETCH_ASSOC);

        $numbers = [];

        for($i = 0; $i < 5; $i++){

            $randomNumber = rand(1,sizeof($resultId) + 1);

            if(!in_array($randomNumber,$numbers))
            {
                array_push($numbers, $randomNumber);
            }else{
                $i--;
            }
        }
        $courses = [];
        for($i = 0; $i < sizeof($numbers); $i++){
            $id = $resultId[$numbers[$i] - 1]['id'];

            $sql = "Select id, name, duration, amount, info, idSubject, rating, idLevel, imageUrl from CoursesMaster WHERE id = $id;";
            $statement = query_execute($db, $sql);
            $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
            
            $sqlSessionCount = "Select id from SchedulesMaster where idCourse = $id AND idPrerecordedSession IS NOT NULL;";
            $statementSessionCount = query_execute($db, $sqlSessionCount);
            $sessionCount = $statementSessionCount->rowCount();

            $sqlMilestoneCount = "Select id from SchedulesMaster where idCourse = $id AND idMilestone IS NOT NULL;";
            $statementMilestoneCount = query_execute($db, $sqlMilestoneCount);
            $milestoneCount = $statementMilestoneCount->rowCount(); 
            
            $sqlLiveSessionCount = "Select id from SchedulesMaster where idCourse = $id AND idPrerecordedSession IS NOT NULL AND idLiveSession = 1;";
            $statementLiveSessionCount = query_execute($db, $sqlLiveSessionCount);
            $liveSessionCount = $statementLiveSessionCount->rowCount();
            
            $result[0]['sessionCount'] = $sessionCount;
            $result[0]['milestoneCount'] = $milestoneCount;
            $result[0]['liveSessionCount'] = $liveSessionCount;

            array_push($courses, $result[0]);

        }

        $json = json_encode($courses);
		return $json;
    }


    
}

?>