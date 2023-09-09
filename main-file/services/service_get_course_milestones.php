<?php

class ServiceGetCourseMilestones{
    
    
    public function serve($db, $idCourse) {
        $sql = "Select MilestonesMaster.id, MilestonesMaster.name FROM MilestonesMaster, SchedulesMaster WHERE SchedulesMaster.idMilestone = MilestonesMaster.id AND SchedulesMaster.idCourse = $idCourse ORDER by SchedulesMaster.sequenceNumber ASC;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>