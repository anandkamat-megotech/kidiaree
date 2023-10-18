<?php

class ServiceGetCourseViewers{
    
    
    public function serve($db, $idCourse) {

        $idStatusVisited = getSingleValue($db, "SELECT id FROM StatusMaster WHERE name = ?", ['Visited']);

        $sql = "Select id from UserActivity WHERE idStatus = $idStatusVisited AND idCourse = $idCourse;";
        $statement = query_execute($db, $sql);
        $viewersCount = $statement->rowCount();

		return $viewersCount;
    }
    
}

?>