<?php

class ServiceSubmitQuestion{
    
    
    public function serve($db, $idUser, $idCourse, $question) {

        $sql = "Insert into Questions (question, idUser, idCourse, blacklisted, timestamp) values ('$question', $idUser, $idCourse, 0, ".time().");";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $id = getSingleValue($db, "SELECT id FROM Questions WHERE idUser = ? AND idCourse = ? ORDER BY id DESC LIMIT 1", [$idUser, $idCourse]);

        
		return $id;


        
    }
    
}

?>