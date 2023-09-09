<?php

class ServiceCancelAppointment{
    
    
    public function serve($db, $idCounsellingSession) {

        $sql = "Update CounsellingSessions SET meetingDescription = NULL, meetingLink = NULL, dd = NULL, mm = NULL, yyyy = NULL, hh = NULL, mmm = NULL, meetingTimestamp = NULL WHERE id = $idCounsellingSession;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        
    }
    
}

?>