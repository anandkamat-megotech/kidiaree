<?php

class ServiceAdminStudentUpdate{
    
    
    public function serve($db, $id, $isActive) {

        $sql = "Update usersmaster SET isActive = $isActive where id = $id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    
		return $id;


        
    }
    
}

?>