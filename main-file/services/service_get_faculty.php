<?php

class ServiceGetFaculty{
    
    
    public function serve($db) {
        $sql = "Select FacultyMaster.id, FacultyMaster.idUser, FacultyMaster.designation, FacultyMaster.info, usersmaster.name, usersmaster.email, usersmaster.profilePictureUrl FROM FacultyMaster, usersmaster WHERE FacultyMaster.idUser = usersmaster.id AND usersmaster.isActive=1;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>