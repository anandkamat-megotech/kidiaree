<?php

class ServiceUpdateLiveSession{
    
    
    public function serve($db, $idPrerecordedSession,  $timestamp, $link, $description) {

        $year = date("Y", $timestamp);

        $month = date("m", $timestamp);

        $day = date("d", $timestamp);

        $hour = date("h", $timestamp);

        $minute = date("i", $timestamp);

        $sql = "Update PrerecordedSessionsMaster SET isLive = 1, meetingDescription = '$description', meetingLink = '$link', dd = $day, mm = $month, yyyy = $year, hh = $hour, mmm = $minute, meetingTimestamp = '$timestamp' WHERE id = $idPrerecordedSession;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $sql1 = "Insert into MultipleLiveSessions (idPrerecordedSession, meetingDescription, meetingLink, dd, mm, yyyy, hh, mmm, meetingTimestamp) values ($idPrerecordedSession, '$description', '$link', $day, $month, $year, $hour, $minute,'$timestamp');";
        $statement1 = query_execute($db, $sql1);
        $result1 = $statement1->fetchAll(\PDO::FETCH_ASSOC);

        
    }
    
}

?>