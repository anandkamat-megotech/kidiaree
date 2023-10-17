<?php

class ServiceAdminMilestoneUpdate{
    
    
    public function serve($db, $idMilestone, $milestoneName, $sessionName, $sessionDescription, $sessionVideo, $idFaculty, $assignmentTitle, $assignmentDescription, $assignmentQuizUrl, $sessionThumbnailUrl, $assignmentHandoutUrl, $idCourse) {

        //Update Milestone
        $sql = "Update MilestonesMaster SET name = '$milestoneName' where id = $idMilestone;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        //Update PrerecordedSession
        $sqlPrerecordedSession = "Update PrerecordedSessionsMaster SET name = '$sessionName', description = '$sessionDescription', idFaculty = $idFaculty, videoUrl = '$sessionVideo', thumbnailUrl = '$sessionThumbnailUrl', idMilestone = $idMilestone where idMilestone = $idMilestone;";
        $statementPrerecordedSession = query_execute($db, $sqlPrerecordedSession);
        $resultPrerecordedSession = $statementPrerecordedSession->fetchAll(\PDO::FETCH_ASSOC);

        //Update Assignment
        $sqlAssignment = "Update AssignmentsMaster SET name = '$assignmentTitle', description = '$assignmentDescription', idMilestone = $idMilestone, attachmentUrl = '$assignmentHandoutUrl', quizUrl = '$assignmentQuizUrl' where idMilestone = $idMilestone;";
        $statementAssignment = query_execute($db, $sqlAssignment);
        $resultAssignment = $statementAssignment->fetchAll(\PDO::FETCH_ASSOC);
        
    
		return $idMilestone;


        
    }
    
}

?>