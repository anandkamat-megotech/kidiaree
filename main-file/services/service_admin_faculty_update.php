<?php

class ServiceAdminFacultyUpdate{
    
    
    public function serve($db, $id, $name, $designation, $info, $profilePictureUrl, $isActive) {

        $sql = "Update usersmaster SET name = '$name', profilePictureUrl = '$profilePictureUrl', isActive = $isActive where id = $id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $sqlFaculty = "Update FacultyMaster SET designation = '$designation', info = '$info' where idUser = $id;";
        $statementFaculty = query_execute($db, $sqlFaculty);
        $resultFaculty = $statementFaculty->fetchAll(\PDO::FETCH_ASSOC);
    
		return $id;


        
    }
    
}

?>