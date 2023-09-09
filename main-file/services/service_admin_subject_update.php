<?php

class ServiceAdminSubjectUpdate{
    
    
    public function serve($db, $id, $name, $description, $subjectImageUrl, $isActive) {

        $sql = "Update SubjectsMaster SET name = '$name', description = '$description', imageUrl = '$subjectImageUrl', isActive = $isActive where id = $id;";

        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    
		return $id;
        
    }
    
}

?>