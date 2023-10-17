<?php

class ServiceGetCounsellingDetails{
    
    
    public function serve($db, $idCounsellingSession) {
        $sql = "Select CounsellingSessions.id, CounsellingSessions.idCourse, CoursesMaster.name AS courseName, CounsellingSessions.idUser, usersmaster.name AS studentName, usersmaster.email AS studentEmail, usersmaster.profilePictureUrl, CounsellingSessions.idFaculty, CounsellingSessions.meetingDescription, CounsellingSessions.meetingLink, CounsellingSessions.dd, CounsellingSessions.yyyy, CounsellingSessions.hh, CounsellingSessions.mmm, CounsellingSessions.timezone, CounsellingSessions.meetingTimestamp, CounsellingSessions.counsellorResponse, zoom_key.zoom_sdk_id_mob, zoom_key.sdk_keys_mob, zoom_key.sdk_key_web, zoom_key.sdk_secret, zoom_key.zoom_id from CounsellingSessions, usersmaster, CoursesMaster, zoom_key where zoom_key.zoom_id = CounsellingSessions.zoom_id AND CounsellingSessions.idUser = usersmaster.id AND CoursesMaster.id = CounsellingSessions.idCourse AND CounsellingSessions.id = $idCounsellingSession;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);       

        $json = json_encode($result);
		return $json;
    }
    
}

?>