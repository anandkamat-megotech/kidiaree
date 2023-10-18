<?php

class ServiceGetMeetingLink{
    
    
    public function serve($db, $idPrerecordedSession) {
        
        $meetingLink = getSingleValue($db, "SELECT meetingLink FROM PrerecordedSessionsMaster WHERE id = ?", [$idPrerecordedSession]);

        return $meetingLink;
    }
    
}

?>