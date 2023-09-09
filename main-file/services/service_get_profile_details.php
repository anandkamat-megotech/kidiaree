<?php

class ServiceGetprofileDetails{
    
    
    public function serve($db, $id) {
        $sql = "Select u.*, um.addressLine2 FROM usersmaster u join useraddressmapping um on um.idUser = u.id WHERE u.id = $id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>