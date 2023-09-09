<?php

use Spipu\Html2Pdf\Tag\Html\Em;

class ServiceAddKids{
    
    
    public function serve($db, $idUser, $k_name, $k_dob_start, $gender, $grade, $kid_id) {

        if(!empty($kid_id)){
            $sqlkids = "Update kids SET kid_name = '$k_name', dob = '$k_dob_start', gender = '$gender', grade = '$grade' where id = $kid_id;";
            $statementkids = query_execute($db, $sqlkids);
            return true;
        }else{
            $sql = "INSERT INTO `kids` (`idUser`, `kid_name`, `dob`, `gender`, `grade`, `created_at`, `updated_at`) VALUES ('$idUser', '$k_name', '$k_dob_start', '$gender', '$grade', current_timestamp(), current_timestamp());";
            $statement = query_execute($db, $sql);
            return true;
        }
        
        
    }
    
}

?>