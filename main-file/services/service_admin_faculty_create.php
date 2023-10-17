<?php

class ServiceAdminFacultyCreate{
    
    
    public function serve($db, $name, $email) {

        $idFacultyMaster = getSingleValue($db, "SELECT id FROM rolesmaster WHERE name = ?", ["Faculty"]);

        $sql = "Insert into usersmaster (name, email, idRole, isActive) values ('$name', '$email', $idFacultyMaster, 1);";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);

        $idUser = getSingleValue($db, "SELECT id FROM usersmaster WHERE name = ? AND email = ? ORDER BY id DESC LIMIT 1", [$name, $email]);

        $sqlFaculty = "Insert into FacultyMaster (idUser) values ($idUser);";
        $statementFaculty = query_execute($db, $sqlFaculty);
        $resultFaculty = $statementFaculty->fetchAll(\PDO::FETCH_ASSOC);
    
		return $idUser;


        
    }
    
}

?>