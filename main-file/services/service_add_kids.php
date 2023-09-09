<?php

class ServiceAddKids{
    
    
    public function serve($db, $idUser, $k_name, $k_dob_start, $gender, $grade, $kid_id) {
        $sql = "INSERT INTO `kids` (`idUser`, `kid_name`, `dob`, `gender`, `grade`, `created_at`, `updated_at`) VALUES ('$idUser', '$k_name', '$k_dob_start', '$gender', '$grade', current_timestamp(), current_timestamp());";
        $statement = query_execute($db, $sql);
        return true;
    }
    
}

?>