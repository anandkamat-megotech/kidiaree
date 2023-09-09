<?php

class ServiceAdminSearchByCourse{
    
    
    public function serve($db, $searchString) {
        $searchStringL = strtolower($searchString);
        $sql = "SELECT * FROM CoursesMaster WHERE lower(name) LIKE '%$searchString%' OR lower(info) LIKE '%$searchString%';";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

    
        for ($i=0; $i < count($result) ; $i++) { 
            $name = strtolower($result[$i]['name']);
            $info = strtolower($result[$i]['info']);
            if(!strrpos($name, $searchStringL, 0)){
                $result[$i]['matchString'] = substr($result[$i]['info'], strrpos($info, $searchStringL, 0), strlen($info));
            }else{
                $result[$i]['matchString'] = substr($result[$i]['name'], strrpos($name, $searchStringL, 0), strlen($name));
            }

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