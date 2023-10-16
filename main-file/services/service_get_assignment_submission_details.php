<?php

class ServiceGetAssignmentSubmissionDetails{
    
    
    public function serve($db, $idAssignmentSubmission, $idMilestone) {
        $sql = "Select AssignmentSubmissionsMapping.id, AssignmentSubmissionsMapping.idAssignment, AssignmentsMaster.name AS AssignmentName,AssignmentsMaster.attachmentUrl AS assignmentUrl, AssignmentsMaster.description AS AssignmentDescription, AssignmentSubmissionsMapping.idUser, usersmaster.name, usersmaster.profilePictureUrl, AssignmentSubmissionsMapping.idFaculty, AssignmentSubmissionsMapping.idCourse, CoursesMaster.name AS CourseName, AssignmentSubmissionsMapping.studentRemarks, AssignmentSubmissionsMapping.studentAttachmentUrl, AssignmentSubmissionsMapping.facultyRemarks, AssignmentSubmissionsMapping.facultyAttachmentUrl, AssignmentSubmissionsMapping.status, AssignmentSubmissionsMapping.timestampSubmit, AssignmentSubmissionsMapping.timestampReviewed, StatusMaster.name AS statusName from AssignmentSubmissionsMapping, StatusMaster, usersmaster, CoursesMaster, AssignmentsMaster where AssignmentSubmissionsMapping.id = $idAssignmentSubmission AND AssignmentSubmissionsMapping.idUser = usersmaster.id AND AssignmentSubmissionsMapping.status = StatusMaster.id AND CoursesMaster.id = AssignmentSubmissionsMapping.idCourse AND AssignmentsMaster.id = AssignmentSubmissionsMapping.idAssignment;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $resultEncoded = json_encode($result);

        $milestoneName = getSingleValue($db, "SELECT name FROM MilestonesMaster WHERE id = ?", [$idMilestone]);
        $assignmentSumissionDetails = json_decode($resultEncoded, true);
        $assignmentSumissionDetails[0]['idMilestone'] = $idMilestone;
        $assignmentSumissionDetails[0]['milestoneName'] = $milestoneName;

        
        $resultEncoded = json_encode($assignmentSumissionDetails);

		return $resultEncoded;
    }
    
}

?>