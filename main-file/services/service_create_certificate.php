<?php

class ServiceCreateCertificate{
    
    
    public function serve($db, $idUser, $idCourse) {

        $userName = getSingleValue($db, "SELECT name FROM usersmaster WHERE id = ?", [$idUser]);
        $courseName = getSingleValue($db, "SELECT name FROM CoursesMaster WHERE id = ?", [$idCourse]);
        $date = date("d/m/Y");
        $certificateHtml = getSingleValue($db, "SELECT certificateHtml FROM CertificatesMaster WHERE idCourse = ?", [$idCourse]);

        $certificateHtml = str_replace("[STUDENT_NAME]", $userName, $certificateHtml);
        $certificateHtml = str_replace("[COURSE_NAME]", $courseName, $certificateHtml);
        $certificateHtml = str_replace("[COMPLETION_DATE]", $date, $certificateHtml);

        $sql = "Insert into Certificates (idCourse, idUser, certificateHtml, certifiedTimestamp) values ($idCourse, $idUser, '$certificateHtml', '".time()."');";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        $id = getSingleValue($db, "SELECT id FROM Certificates WHERE idUser = ? AND idCourse = ? ORDER BY id DESC LIMIT 1", [$idUser, $idCourse]);

        
		return $id;


        
    }
    
}

?>