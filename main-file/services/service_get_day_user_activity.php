<?php

class ServiceGetDayUserActivity{
    
    
    public function serve($db) {
        
        $currentTime = time();

        $yesterdayTime = strtotime('-1 day', $currentTime);

        $sqlPurchases = "Select UserCoursePaymentMapping.id, UserCoursePaymentMapping.idUser, UserCoursePaymentMapping.idCourse, UserCoursePaymentMapping.idOrder, UserCoursePaymentMapping.razorpayPaymentId, usersmaster.name AS userName, CoursesMaster.name AS courseName from UserCoursePaymentMapping, usersmaster, CoursesMaster where UserCoursePaymentMapping.idUser = usersmaster.id AND UserCoursePaymentMapping.idCourse = CoursesMaster.id AND UserCoursePaymentMapping.timestamp > '$yesterdayTime';";
        $statementPurchases = query_execute($db, $sqlPurchases);
        $rowCountPurchases = $statementPurchases->rowCount(); 

        $idStatusVisited = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ['Visited']);
        $sqlCourseVisit = "SELECT UserActivity.id, UserActivity.idCourse, UserActivity.idUser, usersmaster.name AS userName, CoursesMaster.name AS courseName FROM UserActivity, usersmaster, CoursesMaster WHERE UserActivity.idCourse = CoursesMaster.id AND UserActivity.idUser = usersmaster.id AND idStatus = $idStatusVisited AND UserActivity.createTimestamp > '$yesterdayTime';";
        $statementCourseVisit = query_execute($db, $sqlCourseVisit);
        $rowCountCourseVisit = $statementCourseVisit->rowCount(); 

        $sqlAssignment = "SELECT AssignmentSubmissionsMapping.id, AssignmentSubmissionsMapping.idCourse, AssignmentSubmissionsMapping.idUser, usersmaster.name AS userName, CoursesMaster.name AS courseName, AssignmentSubmissionsMapping.idAssignment, AssignmentsMaster.name AS assignmentName, AssignmentSubmissionsMapping.idFaculty, AssignmentSubmissionsMapping.studentRemarks, AssignmentSubmissionsMapping.studentAttachmentUrl, AssignmentSubmissionsMapping.status FROM AssignmentSubmissionsMapping, usersmaster, CoursesMaster, AssignmentsMaster WHERE AssignmentSubmissionsMapping.idCourse = CoursesMaster.id AND AssignmentSubmissionsMapping.idAssignment = AssignmentsMaster.id AND AssignmentSubmissionsMapping.idUser = usersmaster.id AND AssignmentSubmissionsMapping.timestampSubmit > '$yesterdayTime';";
        $statementAssignment = query_execute($db, $sqlAssignment);
        $resultAssignment = $statementAssignment->fetchAll(\PDO::FETCH_ASSOC);
        $rowCountAssignment = $statementAssignment->rowCount(); 

        $sqlCourseCompletion = "SELECT Certificates.id, Certificates.idCourse, Certificates.idUser, usersmaster.name AS userName, CoursesMaster.name AS courseName FROM Certificates, usersmaster, CoursesMaster WHERE Certificates.idCourse = CoursesMaster.id AND Certificates.idUser = usersmaster.id AND Certificates.certifiedTimestamp > '$yesterdayTime';";
        $statementCourseCompletion = query_execute($db, $sqlCourseCompletion);
        $rowCountCourseCompletion = $statementCourseCompletion->rowCount(); 

        $body = "Course Enrollments: ".$rowCountPurchases."\nCourse Visits: ".$rowCountCourseVisit."\nAssignment Submissions: ".$rowCountAssignment."\nCourse Completed: ".$rowCountCourseCompletion;

        
		return $body;

        
    }
    
}

?>