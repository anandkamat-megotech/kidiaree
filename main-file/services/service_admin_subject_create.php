<?php

class ServiceAdminSubjectCreate{
    
    
    public function serve($db, $name, $description, $subjectImageUrl) {

        $sql = "Insert into SubjectsMaster (name, description, imageUrl, isActive) values ('$name', '$description', '$subjectImageUrl', 1);";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $id = getSingleValue($db, "SELECT id FROM SubjectsMaster WHERE name = ? AND description = ? ORDER BY id DESC LIMIT 1", [$name, $description]);
    
		return $id;

        
    }
    
}

?>