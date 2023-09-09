<?php
require_once 'config.php';
  
$url = "https://zoom.us/oauth/authorize?response_type=code&client_id=".CLIENT_ID1."&redirect_uri=".REDIRECT_URI1;
?>
  
<a href="<?php echo $url; ?>">Login with Zoom</a>