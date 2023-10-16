<?php

class ServiceGetprofileDetails{
    
    
    public function serve($db, $id) {
        $sql = "Select u.* FROM usersmaster u WHERE u.id = $id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>