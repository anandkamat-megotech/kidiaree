<?php

class ServiceGetLoginStudents{
    
    
    public function serve($db) {
        $sql = "Select id,name,email,mobile,profilePictureUrl,isProfileSet,consumerPin,isActive,age,contactNumber FROM usersmaster WHERE  usersmaster.idRole = 2 AND usersmaster.otp != '';";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        

        for ($i=0; $i < count($result) ; $i++) { 
            $id = $result[$i]['id'];
            $sqlPayment[$i] = "Select DISTINCT idOrder FROM UserCoursePaymentMapping WHERE UserCoursePaymentMapping.idUser = $id;";
            $statementPayment[$i] = query_execute($db, $sqlPayment[$i]);
            $resultPayment[$i] = $statementPayment[$i]->fetchAll(\PDO::FETCH_ASSOC); 
            $result[$i]['purchaseDetails']=$resultPayment[$i];
        }

        function utf8ize($d) {
            if (is_array($d)) {
                foreach ($d as $k => $v) {
                    $d[$k] = utf8ize($v);
                }
            } else if (is_string ($d)) {
                return utf8_encode($d);
            }
            return $d;
        }
        $json = json_encode(utf8ize($result));
  
		return $json;
    }
    
}

?>