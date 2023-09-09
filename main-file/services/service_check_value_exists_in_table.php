<?php

class ServiceCheckValueExistsInTable{
    
    
    public function serve($db, $tablename, $columnName, $value) {
        $sql = "SELECT $columnName FROM $tablename WHERE $columnName='$value';";
        $statement = query_execute($db, $sql);
        $rowCount = $statement->rowCount(); 
        return $rowCount;
    }
    
}

?>