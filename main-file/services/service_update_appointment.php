<?php

class ServiceUpdateAppointment{
    
    
    public function serve($db, $idCounsellingSession, $idUser, $idFaculty, $idCourse, $timestamp, $link, $description) {

        $year = date("Y", $timestamp);

        $month = date("m", $timestamp);

        $day = date("d", $timestamp);

        $hour = date("h", $timestamp);

        $minute = date("i", $timestamp);
        
        if($idCounsellingSession!='')
        {
        $sql = "Update CounsellingSessions SET meetingDescription = '$description', meetingLink = '$link', dd = $day, mm = $month, yyyy = $year, hh = $hour, mmm = $minute, meetingTimestamp = '$timestamp' WHERE id = $idCounsellingSession;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        }
        
        else
        {
            $sql1 = "Insert into CounsellingSessions (idCourse, idUser, idFaculty, meetingDescription, meetingLink, dd, mm, yyyy, hh, mmm, meetingTimestamp) values ($idCourse, $idUser, $idFaculty, '$description', '$link', $day, $month, $year, $hour, $minute,'$timestamp');";
            $statement1 = query_execute($db, $sql1);
            $result1 = $statement1->fetchAll(\PDO::FETCH_ASSOC);
        }


        
    }
    
}

?>