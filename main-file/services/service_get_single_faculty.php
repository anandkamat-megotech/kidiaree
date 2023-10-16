<?php

class ServiceGetSingleFaculty{
    
    
    public function serve($db, $idFaculty) {
        $sql = "Select FacultyMaster.id, FacultyMaster.idUser, FacultyMaster.designation, FacultyMaster.info, usersmaster.name, usersmaster.email, usersmaster.profilePictureUrl FROM FacultyMaster, usersmaster WHERE FacultyMaster.id = $idFaculty AND FacultyMaster.idUser = usersmaster.id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>