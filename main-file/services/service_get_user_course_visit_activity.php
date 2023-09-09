<?php

class ServiceGetUserCourseVisitActivity{
    
    
    public function serve($db, $idUser, $idStatusVisited) {


        $sql = "select idCourse, name, idSubject, info, imageUrl, duration from (select  idCourse, name, idSubject, info, imageUrl, duration, max(CreateTimestamp) as maxCreateTimestamp from UserActivity, CoursesMaster where idUser = $idUser and idStatus = 6 and CoursesMaster.id = UserActivity.idCourse and CoursesMaster.isActive = 1  group by idCourse) as RecentlyViewedCourses order by maxCreateTimestamp desc;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        for ($i=0; $i < count($result); $i++) { 
            $idCourse =  $result[$i]['idCourse'];

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