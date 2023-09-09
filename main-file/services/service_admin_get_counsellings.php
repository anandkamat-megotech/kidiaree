<?php

class ServiceAdminGetCounsellings{
    
    
    public function serve($db, $offset) {
        $sql = "Select CounsellingSessions.id, CounsellingSessions.idCourse, CoursesMaster.name AS courseName, CounsellingSessions.idUser, usersmaster.name AS studentName, CounsellingSessions.idFaculty, CounsellingSessions.meetingTimestamp, CounsellingSessions.counsellorResponse from CounsellingSessions, usersmaster, CoursesMaster where CounsellingSessions.idUser = usersmaster.id AND CoursesMaster.id = CounsellingSessions.idCourse ORDER BY  CounsellingSessions.reqTimestamp DESC LIMIT ".GET_COUNSELLINGS_LIMIT." OFFSET $offset;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>