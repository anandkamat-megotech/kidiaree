<?php

class ServiceCheckStudentFeedbackExistsInTable{
    
    
    public function serve($db, $idUser, $idCourse) {
        $sql = "SELECT id FROM StudentFeedbacks WHERE idUser = '$idUser' AND idCourse = '$idCourse';";
        $statement = query_execute($db, $sql);
        $rowCount = $statement->rowCount(); 
        return $rowCount;
    }
    
}

?>