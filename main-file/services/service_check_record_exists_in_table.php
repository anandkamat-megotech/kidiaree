<?php

class ServiceCheckRecordExistsInTable{
    
    
    public function serve($db, $tablename, $id) {
        $sql = "SELECT id FROM $tablename WHERE id='$id';";
        $statement = query_execute($db, $sql);
        $rowCount = $statement->rowCount(); 
        return $rowCount;
    }
    
}

?>