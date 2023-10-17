<?php

class ServiceSubmitAnswer{
    
    
    public function serve($db, $answer, $idQuestion, $idUser, $idCourse) {

        $sql = "Insert into Answers (answer, idQuestion, idUser, idCourse, blacklisted, timestamp) values ('$answer', $idQuestion, $idUser, $idCourse, 0, ".time().");";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $id = getSingleValue($db, "SELECT id FROM Answers WHERE idUser = ? AND idCourse = ? ORDER BY id DESC LIMIT 1", [$idUser, $idCourse]);        
		return $id;


        
    }
    
}

?>