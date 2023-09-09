<?php

class ServiceEnrolledStudent{
    
    
    public function serve($db,$idUser, $idMilestone) {


        $sql = "SELECT MultipleLiveSessions.*, LiveSessionEnrollment.idUser FROM `MultipleLiveSessions` LEFT JOIN LiveSessionEnrollment ON LiveSessionEnrollment.liveSessionId = MultipleLiveSessions.id JOIN PrerecordedSessionsMaster ON PrerecordedSessionsMaster.id = MultipleLiveSessions.idPrerecordedSession WHERE PrerecordedSessionsMaster.idMilestone = ".$idMilestone." AND LiveSessionEnrollment.idUser =".$idUser." order by meetingTimestamp desc limit 1";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>