<?php

class ServiceCreateUser{
    
    
    public function serve($db, $columnName, $value) {
        $sql = "Insert into usersmaster ($columnName, idRole, isProfileSet, isActive) values ('$value', 2, 0, 1);";
        $statement = query_execute($db, $sql);
        $result = $statement->fetchAll(\PDO::FETCH_ASSOC);
    }
    
}

?>