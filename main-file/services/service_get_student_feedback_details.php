<?php

class ServiceGetStudentFeedbackDetails{
    
    
    public function serve($db, $idUser, $idCourse) {
        $sql = "Select * from StudentFeedbacks WHERE idUser = '$idUser' AND idCourse = '$idCourse'";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>