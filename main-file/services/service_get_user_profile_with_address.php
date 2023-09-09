<?php

class ServiceGetUserProfileWithAddress{
    
    
    public function serve($db, $idUser) {

        $sql = "Select id, name, email, age, contactNumber, mobile, idRole, profilePictureUrl from usersmaster WHERE id = $idUser;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $sql1 = "Select addressLine1, addressLine2, city, state, country, pincode from useraddressmapping WHERE idUser = $idUser;";
        $statement1 = query_execute($db, $sql1);
        $result1 = $statement1->fetchAll(\PDO::FETCH_ASSOC);
        
        $result=array_merge($result,$result1);

        $json = json_encode($result);
		return $json;


        
    }
    
}

?>