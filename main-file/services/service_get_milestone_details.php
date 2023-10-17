<?php

class ServiceGetMilestoneDetails{
    
    
    public function serve($db, $idMilestone) {

        //Get Milestone
        $sql = "Select * from MilestonesMaster where id = $idMilestone;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $jsonMilestone = json_encode($result);

        //Get PrerecordedSession
        $sqlPrerecordedSession = "Select PrerecordedSessionsMaster.id, PrerecordedSessionsMaster.name, PrerecordedSessionsMaster.description, PrerecordedSessionsMaster.idFaculty, FacultyMaster.idUser, usersmaster.name AS facultyName, PrerecordedSessionsMaster.videoUrl, PrerecordedSessionsMaster.thumbnailUrl, PrerecordedSessionsMaster.isLive, PrerecordedSessionsMaster.meetingDescription, PrerecordedSessionsMaster.meetingLink, PrerecordedSessionsMaster.meetingTimestamp, PrerecordedSessionsMaster.dd, PrerecordedSessionsMaster.mm, PrerecordedSessionsMaster.yyyy, PrerecordedSessionsMaster.hh, PrerecordedSessionsMaster.mmm, PrerecordedSessionsMaster.idMilestone, SchedulesMaster.idCourse FROM PrerecordedSessionsMaster, FacultyMaster, usersmaster, SchedulesMaster where PrerecordedSessionsMaster.idMilestone = $idMilestone AND PrerecordedSessionsMaster.idFaculty = FacultyMaster.id AND FacultyMaster.idUser = usersmaster.id AND PrerecordedSessionsMaster.id = SchedulesMaster.idPrerecordedSession;";
        $statementPrerecordedSession = query_execute($db, $sqlPrerecordedSession);
        $resultPrerecordedSession = $statementPrerecordedSession->fetchAll(\PDO::FETCH_ASSOC);
        $jsonPrerecordedSession = json_encode($resultPrerecordedSession);

        //Get Assignment
        $sqlAssignment = "Select * from AssignmentsMaster where idMilestone = $idMilestone;";
        $statementAssignment = query_execute($db, $sqlAssignment);
        $resultAssignment = $statementAssignment->fetchAll(\PDO::FETCH_ASSOC);
        $jsonAssignment = json_encode($resultAssignment);

        //Get liveSessions
        $curTimestamp=time() - 2400;
        $sqlLiveSessions = "Select MultipleLiveSessions.id, MultipleLiveSessions.meetingDescription, MultipleLiveSessions.meetingLink, MultipleLiveSessions.meetingTimestamp, MultipleLiveSessions.dd, MultipleLiveSessions.mm, MultipleLiveSessions.yyyy, MultipleLiveSessions.hh,MultipleLiveSessions.mmm, zoom_key.zoom_sdk_id_mob, zoom_key.sdk_keys_mob, zoom_key.sdk_key_web, zoom_key.sdk_secret, zoom_key.zoom_id from MultipleLiveSessions, PrerecordedSessionsMaster, zoom_key where zoom_key.zoom_id = MultipleLiveSessions.zoom_id AND MultipleLiveSessions.meetingTimestamp>=$curTimestamp AND MultipleLiveSessions.idPrerecordedSession = PrerecordedSessionsMaster.id AND PrerecordedSessionsMaster.idMilestone = $idMilestone order by meetingTimestamp asc";
        $statementLiveSessions = query_execute($db, $sqlLiveSessions);
        $resultLiveSessions = $statementLiveSessions->fetchAll(\PDO::FETCH_ASSOC);
        $jsonLiveSessions = json_encode($resultLiveSessions);


        $myObj = new stdClass();
        $myObj->milestone = $jsonMilestone;
        $myObj->prerecordedSession = $jsonPrerecordedSession;
        $myObj->assignment = $jsonAssignment;
        $myObj->liveSessions = $jsonLiveSessions;
        
		json_encode($myObj);

        
		return $myObj;


        
    }
    
}

?>