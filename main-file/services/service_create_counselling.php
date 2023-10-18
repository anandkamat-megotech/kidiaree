<?php

class ServiceCreateCounselling{
    
    
    public function serve($db, $idCourse, $idUser, $idFaculty) {

        $sql = "Insert into CounsellingSessions (idCourse, idUser, idFaculty) values ($idCourse, $idUser, '$idFaculty');";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        
    }
    
}

?>