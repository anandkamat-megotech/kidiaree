<?php 


function get_params($parameter){
	if (isset($_GET[$parameter])) {
        $string = trim($_GET[$parameter]);
        return $string;
    }
}


?> 