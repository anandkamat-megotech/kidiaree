<?php

class ServiceRequestCounsellingSchedule{
    
    
    public function serve($db, $idUser, $idCourse, $idFaculty, $idCounsellingSession) {
        $curTimestamp=time();
               
        if($idCounsellingSession!='')
        {
        $sql = "Update CounsellingSessions SET reqTimestamp = '$curTimestamp' WHERE id = $idCounsellingSession;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
       
        }
        
        else
        {
            $sql1 = "Insert into CounsellingSessions (idCourse, idUser, idFaculty, reqTimestamp) values ($idCourse, $idUser, $idFaculty, '$curTimestamp');";
            $statement1 = query_execute($db, $sql1);
            $result1 = $statement1->fetchAll(\PDO::FETCH_ASSOC);
            
        }

         return $curTimestamp;
        
    }
    
}

?>