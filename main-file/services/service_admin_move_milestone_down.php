<?php

class ServiceAdminMoveMilestoneDown{
    
    
    public function serve($db, $idMilestone, $milestoneSequenceNumber, $idCourse) {

        
        $idAssignment = getSingleValue($db, "SELECT idAssignment FROM SchedulesMaster WHERE idCourse = ? AND idAssignment IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumber]);

        $assignmentSequenceNumber = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idAssignment = ?", [$idAssignment]);

        $idPrerecordedSession = getSingleValue($db, "SELECT idPrerecordedSession FROM SchedulesMaster WHERE idCourse = ? AND idPrerecordedSession IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumber]);

        $prerecordedSessionSequenceNumber = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idPrerecordedSession = ?", [$idPrerecordedSession]);


        $idMilestoneNext = getSingleValue($db, "SELECT idMilestone FROM SchedulesMaster WHERE idCourse = ? AND idMilestone IS NOT NULL AND sequenceNumber > ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumber]);

        $milestoneSequenceNumberNext = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idMilestone = ?", [$idMilestoneNext]);

        $idAssignmentNext = getSingleValue($db, "SELECT idAssignment FROM SchedulesMaster WHERE idCourse = ? AND idAssignment IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumberNext]);

        $assignmentSequenceNumberNext = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idAssignment = ?", [$idAssignmentNext]);

        $idPrerecordedSessionNext = getSingleValue($db, "SELECT idPrerecordedSession FROM SchedulesMaster WHERE idCourse = ? AND idPrerecordedSession IS NOT NULL AND sequenceNumber < ? ORDER BY sequenceNumber DESC LIMIT 1", [$idCourse, $milestoneSequenceNumberNext]);

        $prerecordedSessionSequenceNumberNext = getSingleValue($db, "SELECT sequenceNumber FROM SchedulesMaster WHERE idPrerecordedSession = ?", [$idPrerecordedSessionNext]);

        
        $sqlMilestone1 = "Update SchedulesMaster SET sequenceNumber = '$milestoneSequenceNumber' where idMilestone = $idMilestoneNext;";
        $statementMilestone1 = query_execute($db, $sqlMilestone1);
        $resultMilestone1 = $statementMilestone1->fetchAll(\PDO::FETCH_ASSOC);

        $sqlMilestone2 = "Update SchedulesMaster SET sequenceNumber = '$milestoneSequenceNumberNext' where idMilestone = $idMilestone;";
        $statementMilestone2 = query_execute($db, $sqlMilestone2);
        $resultMilestone2 = $statementMilestone2->fetchAll(\PDO::FETCH_ASSOC);

        $sqlAssignment1 = "Update SchedulesMaster SET sequenceNumber = '$assignmentSequenceNumber' where idAssignment = $idAssignmentNext;";
        $statementAssignment1 = query_execute($db, $sqlAssignment1);
        $resultAssignment1 = $statementAssignment1->fetchAll(\PDO::FETCH_ASSOC);

        $sqlAssignment2 = "Update SchedulesMaster SET sequenceNumber = '$assignmentSequenceNumberNext' where idAssignment = $idAssignment;";
        $statementAssignment2 = query_execute($db, $sqlAssignment2);
        $resultAssignment2 = $statementAssignment2->fetchAll(\PDO::FETCH_ASSOC);

        $sqlPrerecordedSession1 = "Update SchedulesMaster SET sequenceNumber = '$prerecordedSessionSequenceNumber' where idPrerecordedSession = $idPrerecordedSessionNext;";
        $statementPrerecordedSession1 = query_execute($db, $sqlPrerecordedSession1);
        $resultPrerecordedSession1 = $statementPrerecordedSession1->fetchAll(\PDO::FETCH_ASSOC);

        $sqlPrerecordedSession2 = "Update SchedulesMaster SET sequenceNumber = '$prerecordedSessionSequenceNumberNext' where idPrerecordedSession = $idPrerecordedSession;";
        $statementPrerecordedSession2 = query_execute($db, $sqlPrerecordedSession2);
        $resultPrerecordedSession2 = $statementPrerecordedSession2->fetchAll(\PDO::FETCH_ASSOC);


        
    }
    
}

?>