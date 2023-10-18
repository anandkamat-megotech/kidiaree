<?php

class ServiceAdminMilestoneDelete{
    
    
    public function serve($db, $idMilestone) {

        $idScheduleMilestone = getSingleValue($db, "SELECT id FROM SchedulesMaster WHERE idMilestone = ?", [$idMilestone]);
        $sql = "Delete from MilestonesMaster where id = $idMilestone;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $idPrerecordedSession = getSingleValue($db, "SELECT id FROM PrerecordedSessionsMaster WHERE idMilestone = ?", [$idMilestone]);
        $idSchedulePrerecordedSession = getSingleValue($db, "SELECT id FROM SchedulesMaster WHERE idPrerecordedSession = ?", [$idPrerecordedSession]);
        $sqlPrerecordedSession = "Delete from PrerecordedSessionsMaster where idMilestone = $idMilestone;";
        $statementPrerecordedSession = query_execute($db, $sqlPrerecordedSession);
        $resultPrerecordedSession = $statementPrerecordedSession->fetchAll(\PDO::FETCH_ASSOC);

        $idAssignment = getSingleValue($db, "SELECT id FROM AssignmentsMaster WHERE idMilestone = ?", [$idMilestone]);
        $idScheduleAssignment = getSingleValue($db, "SELECT id FROM SchedulesMaster WHERE idAssignment = ?", [$idAssignment]);
        $sqlAssignment = "Delete from AssignmentsMaster where idMilestone = $idMilestone;";
        $statementAssignment = query_execute($db, $sqlAssignment);
        $resultAssignment = $statementAssignment->fetchAll(\PDO::FETCH_ASSOC);

        $sqlDeleteSchedulePrerecordedSession = "Delete from SchedulesMaster where id = $idSchedulePrerecordedSession;";
        $statementDeleteSchedulePrerecordedSession = query_execute($db, $sqlDeleteSchedulePrerecordedSession);
        $resultDeleteSchedulePrerecordedSession = $statementDeleteSchedulePrerecordedSession->fetchAll(\PDO::FETCH_ASSOC);

        $sqlDeleteScheduleAssignment = "Delete from SchedulesMaster where id = $idScheduleAssignment;";
        $statementDeleteScheduleAssignment = query_execute($db, $sqlDeleteScheduleAssignment);
        $resultDeleteScheduleAssignment = $statementDeleteScheduleAssignment->fetchAll(\PDO::FETCH_ASSOC);

        $sqlDeleteScheduleMilestone = "Delete from SchedulesMaster where id = $idScheduleMilestone;";
        $statementDeleteScheduleMilestone = query_execute($db, $sqlDeleteScheduleMilestone);
        $resultDeleteScheduleMilestone = $statementDeleteScheduleMilestone->fetchAll(\PDO::FETCH_ASSOC);

        //Making Course inactive if milestone count is zero
        $idCourse = getSingleValue($db, "SELECT idCourse FROM SchedulesMaster WHERE idMilestone = ?", [$idMilestone]);

        $sqlMilestoneCount = "Select id from SchedulesMaster where idCourse = $idCourse AND idMilestone IS NOT NULL;";
        $statementMilestoneCount = query_execute($db, $sqlMilestoneCount);
        $milestoneCount = $statementMilestoneCount->rowCount(); 

        if($milestoneCount==0)
        {
            $isActive=0;

            $sqlCourseActive = "Update CoursesMaster SET  isActive = $isActive where id = $idCourse;";
            $statementCourseActive = query_execute($db, $sqlCourseActive);
            $resultCourseActive = $statementCourseActive->fetchAll(\PDO::FETCH_ASSOC);
    
        }
        
    }
    
}

?>