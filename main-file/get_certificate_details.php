<?php
include './components/component_get_certificate_details.php';
include './services/service_base.php';
include './services/service_get_courses.php';
include './services/service_check_token_validity.php';
include './services/service_check_record_exists_in_table.php';
include './services/service_get_certificate_details.php';
include './services/service_create_certificate.php';
include './services/service_check_certificate_exists_in_table.php';
include './utilities/post_parameters.php';
include './utilities/authorization.php';
include './validator/validator_string.php';

$serviceBase = new ServiceBase();
$db = $serviceBase->getDb();
insertCorsHeaders();
date_default_timezone_set(TIME_ZONE);
$validatorString = new ValidatorString();
$serviceCreateCertificate = new ServiceCreateCertificate();
$serviceGetCertificateDetails = new ServiceGetCertificateDetails();
$serviceCheckTokenValidity = new ServiceCheckTokenValidity();
$serviceCheckRecordExistsInTable = new ServiceCheckRecordExistsInTable();
$serviceCheckCertificateExistsInTable = new ServiceCheckCertificateExistsInTable();

$token = getBearerToken();

$isTokenValid = $serviceCheckTokenValidity->serve($db, $token);
if ($isTokenValid == 0) {
    echo response_unauthorized(time());
    return;
}

$idCourse = "";
$idCourse = post_params("idCourse");

//Check whether idCourse is numeric or not
if(!is_numeric($idCourse)){
    echo response_parameters_invalid(time());
    return;
}

//Check whether idCourse exists or not
$rowCountCourse = $serviceCheckRecordExistsInTable->serve($db, "CoursesMaster", $idCourse);
if ($rowCountCourse == 0) {
    echo response_not_found(time());
    return;
}

//Get idUser of from usertokenmapping
$idUser = getSingleValue($db, "SELECT idUser FROM usertokenmapping WHERE token = ?", [$token]);

//Check whether certificate of idUser and idCourse exists or not
$rowCountCertificate = $serviceCheckCertificateExistsInTable->serve($db, $idUser, $idCourse);
if ($rowCountCertificate == 0) {
    
      $id = $serviceCreateCertificate->serve($db, $idUser, $idCourse);
}

$json = $serviceGetCertificateDetails->serve($db, $idUser, $idCourse);

$html = '<style>/*Certificate*/
#background 
{ 
	 left: 0px; 
	 top: 0px; 
	 position: relative; 
	 margin-left: auto; 
	 margin-right: auto; 
	 width: 450px;
	 height: 300px; 
	 overflow: hidden;
	 z-index:0;
	} 
#border 
{ 
	 position: absolute; 
	 width: 100%;
	 height: 100%;
	 z-index:2;
} 

@media screen and (orientation:landscape) {
  #Rectangle1 
  { 
    width: 25px;
    height: 25px;
    z-index:3;
  } 
}
@media screen and (orientation:portrait) {
  #Rectangle1 
  { 
    width: 25px;
    height: 25px;
    z-index:3;
  } 
}

 #Rectangle1copy 
{ 
	 left: 2622px; 
	 top: 758px; 
	 position: absolute; 
	 width: 88px;
	 height: 88px;
	 z-index:4;
} 

@media screen and (orientation:landscape) { 
  #BRICKETCLOGOPNG 
  { 
     width: 100px;
     margin-bottom: 20px;
     z-index:5;
  }   
}

@media screen and (orientation:portrait) { 
  #BRICKETCLOGOPNG 
  { 
    width: 50px;
     margin-top: 5px;
     /* margin-bottom: 10px; */
     z-index:5;
  }  
}

 #CertificateofComplet 
{ 
	 left: 945px; 
	 top: 752px; 
	 position: absolute; 
	 width: 1618px;
	 height: 130px;
	 z-index:6;
} 

 #isherebyawardedto 
{ 
	 left: 1341px; 
	 top: 926px; 
	 position: absolute; 
	 width: 826px;
	 height: 81px;
	 z-index:7;
} 

 #forsuccessfullycompl 
{ 
	 left: 1224px; 
	 top: 1323px; 
	 position: absolute; 
	 width: 1059px;
	 height: 82px;
	 z-index:8;
} 

 

 #Date 
{ 
	 left: 2447px; 
	 top: 2069px; 
	 position: absolute; 
	 width: 131px;
	 height: 45px;
	 z-index:10;
} 

 #seal 
{ 
	 width: 70px;
	 z-index:11;
} 

 #Shape1 
{ 
	 left: 593px; 
	 top: 1187px; 
	 position: absolute; 
	 width: 2322px;
	 height: 8px;
	 z-index:12;
} 

 #Shape1copy 
{ 
	 left: 593px; 
	 top: 1594px; 
	 position: absolute; 
	 width: 2322px;
	 height: 8px;
	 z-index:13;
} 


@media screen and (orientation:landscape) { 
  #cetfificateContent {
    font-size: 100%
  } 
  #Signature 
  { 
    width: 100px;
    z-index:3;
  } 
}

@media screen and (orientation:portrait) { 
  .app{
    height: 260px !important;
  }
  .app h1{
    font-size: 14px !important;
    margin-top: 15px !important;
  }
  .app h3{
    font-size: 12px !important;
    margin : 5px !important;
  }
  .app h4{
    font-size: 10px !important;
  }
  #cetfificateContent {
    font-size: 50%
  }  
  #Signature 
  { 
    width: 40px;
    z-index:3;
  }
  #seal {
    width: 40px !important;
  }
  #Rectangle1{
    margin-top: 0px;

  }
  #Rectangle2{
    margin-top: 0px;

  }
  
}
</style><page orientation="L">'.$json[0]['certificateHtml'].'</page>';

$css = '';

$google_fonts = "Roboto";

$data = array('html'=>$html,
              'css'=>$css,
              'google_fonts'=>$google_fonts);

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, "https://hcti.io/v1/image");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));

curl_setopt($ch, CURLOPT_POST, 1);
// Retrieve your user_id and api_key from https://htmlcsstoimage.com/dashboard
curl_setopt($ch, CURLOPT_USERPWD, "11621dbf-b0be-4fe7-aafe-8d88c30b393c" . ":" . "7eed1c39-09d6-4724-ae8a-6bfbddcf5237");

$headers = array();
$headers[] = "Content-Type: application/x-www-form-urlencoded";
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

$result = curl_exec($ch);
if (curl_errno($ch)) {
  echo 'Error:' . curl_error($ch);
}
curl_close ($ch);
$res = json_decode($result,true);

echo response_ok('"' . $res['url'] . '"', time());

?> 