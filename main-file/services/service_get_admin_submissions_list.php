<?php

class ServiceGetAdminSubmissionsList{
    
    
    public function serve($db, $offset) {

        $sql = "Select AssignmentSubmissionsMapping.id, AssignmentSubmissionsMapping.idUser, usersmaster.name, AssignmentSubmissionsMapping.status, AssignmentSubmissionsMapping.idCourse, AssignmentSubmissionsMapping.idAssignment, AssignmentsMaster.name AS assignmentName, MilestonesMaster.name AS milestoneName, StatusMaster.name AS statusName, AssignmentSubmissionsMapping.timestampSubmit, CoursesMaster.id AS idCourse, CoursesMaster.name AS courseName from AssignmentSubmissionsMapping, usersmaster, StatusMaster, CoursesMaster, AssignmentsMaster, MilestonesMaster where AssignmentSubmissionsMapping.idUser = usersmaster.id AND AssignmentSubmissionsMapping.status = StatusMaster.id AND AssignmentSubmissionsMapping.idAssignment = AssignmentsMaster.id AND AssignmentsMaster.idMilestone = MilestonesMaster.id AND CoursesMaster.id = AssignmentSubmissionsMapping.idCourse ORDER BY AssignmentSubmissionsMapping.timestampSubmit DESC LIMIT ".GET_SUBMISSIONS_LIMIT." OFFSET $offset;;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>