<?php 


function post_params($parameter){
	if (isset($_POST[$parameter])) {
        $array;
        if(is_array(json_decode($_POST[$parameter], true))) {
            $array = json_decode($_POST[$parameter], true);
        }else{
            $array = trim($_POST[$parameter]);
        }
        
        if (json_last_error()) {
            $array = trim($_POST[$parameter]);
        }
        return $array;
    }
    
}

function clean($string) {
    $string = str_replace("'", "\'", $string); // Replaces all spaces with hyphens.
    $string = str_replace("\"", "\"", $string); // Replaces all spaces with hyphens.
    return $string;
 }


?> 