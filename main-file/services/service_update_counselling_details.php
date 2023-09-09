<?php

class ServiceUpdateCounsellingDetails{
    
    
    public function serve($db, $idCounsellingSession, $meetingDescription, $meetingLink, $meetingTimestamp, $zoom_id,$slot) {

        $dateSlots = date("Y-m-d", $meetingTimestamp);
        $year = date("Y", $meetingTimestamp);

        $month = date("m", $meetingTimestamp);

        $day = date("d", $meetingTimestamp);

        $hour = date("h", $meetingTimestamp);

        $minute = date("i", $meetingTimestamp);


        $sql = "Update CounsellingSessions SET meetingDescription = '$meetingDescription', meetingLink = '$meetingLink', dd = $day, mm = $month, yyyy = $year, hh = $hour, mmm = $minute, meetingTimestamp = '$meetingTimestamp', zoom_id = '$zoom_id' WHERE id = $idCounsellingSession;";
        $statement = query_execute($db, $sql);

        $sql1 = "Insert into slotsavailblecounselling (date, slots, coursesId, zoom_id) values ('$dateSlots', '$slot', '$idCounsellingSession','$zoom_id')";
        $statement1 = query_execute($db, $sql1);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>