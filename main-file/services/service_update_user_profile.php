<?php

class ServiceUpdateUserProfile{
    
    
    public function serve($db, $idUser,$addressLine1,$addressLine2, $city, $state, $country, $pincode, $email,$yfname,$ylname, $step_number) {
            $name = $yfname.' '.$ylname;
            $sqlUpdateEmail = "UPDATE `usersmaster` SET `email` = '$email', `name` = '$name', `step_number` = $step_number WHERE id = $idUser";
            $statementUpdateEmail = query_execute($db, $sqlUpdateEmail);
            $resultUpdateEmail = $statementUpdateEmail->fetchAll(\PDO::FETCH_ASSOC);

        $idAddress = getSingleValue($db, "SELECT id FROM useraddressmapping WHERE idUser = ?", [$idUser]);
        if($idAddress == '')
        {
            $sqlInsertAddress = "Insert into useraddressmapping (idUser, addressLine1, addressLine2, city, state, country, pincode) values ($idUser, '$addressLine1','$addressLine2', '$city', '$state', '$country', '$pincode');";
            $statementInsertAddress = query_execute($db, $sqlInsertAddress);
            $resultInsertAddress = $statementInsertAddress->fetchAll(\PDO::FETCH_ASSOC);
        }
        else
        {
            $sqlUpdateAddress = "Update useraddressmapping SET addressLine1 = '$addressLine1', addressLine2 = '$addressLine2', city = '$city', state = '$state', country = '$country', pincode = '$pincode' Where idUser = $idUser";
            $statementUpdateAddress = query_execute($db, $sqlUpdateAddress);
            $resultUpdateAddress = $statementUpdateAddress->fetchAll(\PDO::FETCH_ASSOC);
        }
        
		return $idUser;


        
    }
    
}

?>