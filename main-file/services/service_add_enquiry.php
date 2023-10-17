<?php

use Spipu\Html2Pdf\Tag\Html\Em;

class ServiceAddEnquiry{
    
    
    public function serve($db, $en_name, $en_contact, $email) {

        $sql = "INSERT INTO `enquiry` (`name`, `contact`, `status`, `email`) VALUES ('$en_name', '$en_contact', '0','$email');";
            $statement = query_execute($db, $sql);
            return true;
        
        
    }
    
}

?>