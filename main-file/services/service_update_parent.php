<?php

use Spipu\Html2Pdf\Tag\Html\Em;

class ServiceUpdateParent{
    
    
    public function serve($db, $p_name, $email, $p_id) {

           $sqlkids = "Update usersmaster SET name = '$p_name', email = '$email' where id = $p_id;";
            $statementkids = query_execute($db, $sqlkids);
            return true;
       
        
        
    }
    
}

?>