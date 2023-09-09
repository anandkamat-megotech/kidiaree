<?php

class ServiceCancelLiveSession{
    
    
    public function serve($db, $idPrerecordedSession) {

        $sql = "Update PrerecordedSessionsMaster SET meetingDescription = NULL, meetingLink = NULL, dd = NULL, mm = NULL, yyyy = NULL, hh = NULL, mmm = NULL, meetingTimestamp = NULL WHERE id = $idPrerecordedSession;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
    }
    
}

?>