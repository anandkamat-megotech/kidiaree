<?php

class ServiceCreateTeacher{
    
    
    public function serve($db, $columnName, $value) {
        $sql = "Insert into usersmaster ($columnName, idRole, isProfileSet, isActive,parents_teacher) values ('$value', 3, 0, 1,'');";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}

?>