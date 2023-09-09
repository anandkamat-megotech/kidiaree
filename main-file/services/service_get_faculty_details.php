<?php

class ServiceGetFacultyDetails{
    
    
    public function serve($db, $id) {
        $sql = "Select FacultyMaster.id, FacultyMaster.idUser, FacultyMaster.designation, FacultyMaster.info, usersmaster.name, usersmaster.email, usersmaster.profilePictureUrl, usersmaster.isActive FROM FacultyMaster, usersmaster WHERE FacultyMaster.idUser = usersmaster.id AND FacultyMaster.id = $id;";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
        $json = json_encode($result);
		return $json;
    }
    
}

?>