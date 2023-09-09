<?php

class ServiceCheckCertificateExistsInTable{
    
    
    public function serve($db, $idUser, $idCourse) {
        $sql = "SELECT id FROM Certificates WHERE idUser = '$idUser' AND idCourse = '$idCourse';";
        $statement = query_execute($db, $sql);
        $rowCount = $statement->rowCount(); 
        return $rowCount;
    }
    
}

?>