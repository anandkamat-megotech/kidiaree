<?php

class ServiceAdminMilestoneCreate{
    
    
    public function serve($db, $milestoneName, $sessionName, $sessionDescription, $isLive, $sessionVideo, $idFaculty, $assignmentTitle, $assignmentDescription, $assignmentQuizUrl, $sessionThumbnailUrl, $assignmentHandoutUrl, $idCourse) {

        //Create Milestone
        $sql = "Insert into MilestonesMaster (name) values ('$milestoneName');";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $idMilestone = getSingleValue($db, "SELECT MAX(id) FROM MilestonesMaster", []);
        $sqlPrerecordedSession = "";
        if($isLive == 0){
            //Create PrerecordedSession
            $sqlPrerecordedSession = "Insert into PrerecordedSessionsMaster (name, description, idFaculty, videoUrl, thumbnailUrl, idMilestone, isLive) values ('$sessionName', '$sessionDescription', $idFaculty, '$sessionVideo', '$sessionThumbnailUrl', $idMilestone, 0);";
        }else{
            //Create Live Session
            $sqlPrerecordedSession = "Insert into PrerecordedSessionsMaster (name, description, idFaculty, videoUrl, thumbnailUrl, idMilestone, isLive) values ('$sessionName', '$sessionDescription', $idFaculty, '$sessionVideo', '$sessionThumbnailUrl', $idMilestone, 1);";
        }

        
        $statementPrerecordedSession = query_execute($db, $sqlPrerecordedSession);
        $resultPrerecordedSession = $statementPrerecordedSession->fetchAll(\PDO::FETCH_ASSOC);

        $idPrerecordedSession = getSingleValue($db, "SELECT MAX(id) FROM PrerecordedSessionsMaster", []);

        //Create Assignment
        $sqlAssignment = "Insert into AssignmentsMaster (name, description, idMilestone, attachmentUrl, quizUrl) values ('$assignmentTitle', '$assignmentDescription', $idMilestone, '$assignmentHandoutUrl', '$assignmentQuizUrl');";
        $statementAssignment = query_execute($db, $sqlAssignment);
        $resultAssignment = $statementAssignment->fetchAll(\PDO::FETCH_ASSOC);

        $idAssignment = getSingleValue($db, "SELECT MAX(id) FROM AssignmentsMaster", []);

        $lastSequenceNumber = getSingleValue($db, "SELECT MAX(sequenceNumber) FROM SchedulesMaster where idCourse = ?", [$idCourse]);
        if($lastSequenceNumber == ''){
            $lastSequenceNumber = 0;
        }
        $lastSequenceNumber++;
        
        $sqlSchedule = "Insert into SchedulesMaster (idCourse, sequenceNumber, idMilestone, idPrerecordedSession, idAssignment) values ($idCourse, ".$lastSequenceNumber++.", NULL, $idPrerecordedSession, NULL), ($idCourse, ".$lastSequenceNumber++.", NULL, NULL, $idAssignment), ($idCourse, ".$lastSequenceNumber++.", $idMilestone, NULL, NULL);";
        $statementSchedule = query_execute($db, $sqlSchedule);
        $resultSchedule = $statementSchedule->fetchAll(\PDO::FETCH_ASSOC);
            
		return $idMilestone;
        
    }
    
}

?>