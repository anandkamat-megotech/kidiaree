<?php

class ValidatorString {
    
    
    public function __construct(){

    }
    
    public function validate($string) {
        if ($string != '') {
            return true;           
        }else{
            return false;
        }
    }
    
    function checkemail($str) {
        return (!preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $str)) ? FALSE : TRUE;
    }  
    
}
?>