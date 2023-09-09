<?php

class ServiceGetUserProfile{
    
    
    public function serve($db, $idUser) {

        $sql = "Select id, name, email, age, contactNumber, mobile, idRole, profilePictureUrl from usersmaster WHERE id = $idUser;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;


        
    }
    
}

?>