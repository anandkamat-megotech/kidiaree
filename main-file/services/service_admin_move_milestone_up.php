<?php

class ServiceAdminMoveMilestoneUp{
    
    
    public function serve($db, $idMilestone, $milestoneSequenceNumber, $idCourse) {

        
        $idAssignment = getSingleValue($db, "SELECT idAssignment FROM SchedulesMaster WHERE idCourse = ? AND idAssignment IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumber]);

        $assignmentSequenceNumber = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idAssignment = ?", [$idAssignment]);

        $idPrerecordedSession = getSingleValue($db, "SELECT idPrerecordedSession FROM SchedulesMaster WHERE idCourse = ? AND idPrerecordedSession IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumber]);

        $prerecordedSessionSequenceNumber = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idPrerecordedSession = ?", [$idPrerecordedSession]);


        $idMilestonePrevious = getSingleValue($db, "SELECT idMilestone FROM SchedulesMaster WHERE idCourse = ? AND idMilestone IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumber]);

        $milestoneSequenceNumberPrevious = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idMilestone = ?", [$idMilestonePrevious]);

        $idAssignmentPrevious = getSingleValue($db, "SELECT idAssignment FROM SchedulesMaster WHERE idCourse = ? AND idAssignment IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumberPrevious]);

        $assignmentSequenceNumberPrevious = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idAssignment = ?", [$idAssignmentPrevious]);

        $idPrerecordedSessionPrevious = getSingleValue($db, "SELECT idPrerecordedSession FROM SchedulesMaster WHERE idCourse = ? AND idPrerecordedSession IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumberPrevious]);

        $prerecordedSessionSequenceNumberPrevious = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idPrerecordedSession = ?", [$idPrerecordedSessionPrevious]);

       
        $sqlMilestone1 = "Update SchedulesMaster SET sequenceNumber = '$milestoneSequenceNumber' where idMilestone = $idMilestonePrevious;";
        $statementMilestone1 = query_execute($db, $sqlMilestone1);
        $resultMilestone1 = $statementMilestone1->fetchAll(\PDO::FETCH_ASSOC);

        $sqlMilestone2 = "Update SchedulesMaster SET sequenceNumber = '$milestoneSequenceNumberPrevious' where idMilestone = $idMilestone;";
        $statementMilestone2 = query_execute($db, $sqlMilestone2);
        $resultMilestone2 = $statementMilestone2->fetchAll(\PDO::FETCH_ASSOC);

        $sqlAssignment1 = "Update SchedulesMaster SET sequenceNumber = '$assignmentSequenceNumber' where idAssignment = $idAssignmentPrevious;";
        $statementAssignment1 = query_execute($db, $sqlAssignment1);
        $resultAssignment1 = $statementAssignment1->fetchAll(\PDO::FETCH_ASSOC);

        $sqlAssignment2 = "Update SchedulesMaster SET sequenceNumber = '$assignmentSequenceNumberPrevious' where idAssignment = $idAssignment;";
        $statementAssignment2 = query_execute($db, $sqlAssignment2);
        $resultAssignment2 = $statementAssignment2->fetchAll(\PDO::FETCH_ASSOC);

        $sqlPrerecordedSession1 = "Update SchedulesMaster SET sequenceNumber = '$prerecordedSessionSequenceNumber' where idPrerecordedSession = $idPrerecordedSessionPrevious;";
        $statementPrerecordedSession1 = query_execute($db, $sqlPrerecordedSession1);
        $resultPrerecordedSession1 = $statementPrerecordedSession1->fetchAll(\PDO::FETCH_ASSOC);

        $sqlPrerecordedSession2 = "Update SchedulesMaster SET sequenceNumber = '$prerecordedSessionSequenceNumberPrevious' where idPrerecordedSession = $idPrerecordedSession;";
        $statementPrerecordedSession2 = query_execute($db, $sqlPrerecordedSession2);
        $resultPrerecordedSession2 = $statementPrerecordedSession2->fetchAll(\PDO::FETCH_ASSOC);


        
    }
    
}

?>