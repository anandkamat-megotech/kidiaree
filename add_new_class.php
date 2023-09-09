<?php include_once 'global.php'; ?>
<?php 
if(!empty($_GET['token'])){
   $_SESSION['token'] = $_GET['token'];
}

$token = $_SESSION['token'];

$ch = curl_init();
   
curl_setopt($ch, CURLOPT_URL,$url_curl_kidiaree."/main-file/get_user_profile_details.php");
$authorization = "Authorization: Bearer ".$token;
curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
$resultProfile = curl_exec($ch);
curl_close($ch);
//    print_r($result);
$profile =json_decode($resultProfile);

if (isset($_POST['class_form'])) {
    // print_r($profile);
    // print_r($_POST);
    $thumbnails_url = '';
    $msg = '';
    $target_dir = "assets/images/classes/";
    $target_file = $target_dir . basename($_FILES["thumbnail"]["name"]);
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    if(isset($_POST["class_form"])) {
    $check = getimagesize($_FILES["thumbnail"]["tmp_name"]);
    if($check !== false) {
        $msg .= "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        $msg .=  "File is not an image.";
        $uploadOk = 0;
    }
    }

    // Check if file already exists
if (file_exists($target_file)) {
    $msg .=  "Sorry, file already exists.";
    $uploadOk = 0;
  }
  
  // Check file size
  if ($_FILES["thumbnail"]["size"] > 500000) {
    $msg .= "Sorry, your file is too large.";
    $uploadOk = 0;
  }
  
  // Allow certain file formats
  if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
  && $imageFileType != "gif" ) {
    $msg .=  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
  }
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $msg .=  "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["thumbnail"]["tmp_name"], $target_file)) {
        $thumbnails_url = $target_file;
        $msg .=  "The file ". htmlspecialchars( basename( $_FILES["thumbnail"]["name"])). " has been uploaded.";
    } else {
        $msg .=  "Sorry, there was an error uploading your file.";
    }
  }
    // die;
include('dbConfig.php');
$age_tags = '-:-'.$_POST['age'].'-:-';
$sql = "INSERT INTO products (name, sub_name, description,tags,teacher_id,price,type,thumbnail,age,age_tags,status,product_url)
VALUES ('".$_POST['class_name']."', '".$_POST['sub_name']."', '".$_POST['description']."', '".$_POST['tags']."', '".$profile->body[0]->id."', '".$_POST['price']."', '".$_POST['type']."', '".$thumbnails_url."', '".$_POST['age']."', '".$age_tags."', '0', '".$_POST['product_url']."')";
$db->query($sql);
}
?>
<?php

   //
   // A very simple PHP example that sends a HTTP POST to a remote site
   //
   
   // print_r($token);
   $ch = curl_init();
   
   curl_setopt($ch, CURLOPT_URL,$url_curl_kidiaree."/main-file/get_all_user_details.php");
   $authorization = "Authorization: Bearer ".$token;
   curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   // curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
   $result = curl_exec($ch);
   curl_close($ch);
//    print_r($result);
   $kids =json_decode($result);


   // print_r($profile->code);
   // print_r($profile->body);
   // Further processing ...
   // if ($server_output == "OK") { ... } else { ... }
   ?>

<!doctype html>
<html class="no-js" lang="en">
<?php include('const/head.php'); ?>
   <body>
      <div class="main-wrapper">
         <!-- Preloader start -->
         <div id="preloader">
            <div class="preloader">
               <span></span>
               <span></span>
            </div>
         </div>
         <!-- Preloader End -->
         <?php include('const/header.php'); ?>
         <div class="section login-register-section section-padding mt-5">
            <div class="container">

                <!-- Login & Register Wrapper Start -->
                <div class="login-register-wrap">
         <!-- Course Details Start -->
                    <div class="login-register-box">
                                <div class="section-title">
                                    <h2 class="title">Class Details</h2>
                                </div>
                        <div class="login-register-form">
                            <form action="" method="POST" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="class_name" class="form-control" placeholder="Enter Class Title ">
                                         </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="sub_name" class="form-control" placeholder="Enter sub-name ">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="description" class="form-control" placeholder="Enter Description - 'About the Class' ">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="tags" class="form-control" placeholder="Enter Suggested Tags (tag1, tag2) ">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                        <select class=" w-100" name="type"  id="mode">
                                            <option value="">Select Mode</option>
                                            <option>Online</option>
                                            <option>Offline</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4" id="update"></div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="age" class="form-control" placeholder="Enter age Minimum ">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="age" class="form-control" placeholder="Enter age Maximum ">
                                        </div>
                                    </div>
                                    <!-- <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="product_url" class="form-control" placeholder="Enter product_url">
                                        </div>
                                    </div> -->
                                    
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                        <select class=" w-100" name="type"  id="session">
                                            <option value="">Select Class type</option>
                                            <option value="s">Single session</option>
                                            <option value="m">Multi-session</option>
                                        </select>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                        <label for="">Start Date</label>
                                            <input type="date" name="price" class="form-control" placeholder="Start Date">
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="price" class="form-control" placeholder="Enter Price per session ">
                                        </div>
                                    </div>
                                    <div id="update2"></div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <label for="" style="margin-bottom: 0px !important;">Upload Image / Creative </label>
                                            <span class="validation-image">Image size (400px X 600px)</span>
                                            <input type="file" name="thumbnail" class="form-control" placeholder="Enter type ">
                                        </div>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <button type="submit" name="class_form" class=" btn-add-class bg-save-draft">Save Draft</button>
                                    </div>
                                    <div class="col-6 mt-3">
                                        <button type="submit" name="class_form" class="btn btn-add-class">Submit</button>
                                    </div>
                                </div>
                               
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
         </div>
         <!-- Course Details End -->
         <?php include('const/footer.php'); ?>
         <!-- back to top start -->
         <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
               <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
         </div>
         <!-- back to top end -->
      </div>
      <?php include('const/scripts.php'); ?>
      <script>
        
$(document).ready(function() {
  // executes when HTML-Document is loaded and DOM is ready
  var date = new Date();
  console.log(date);
  var dd = date.getDate();
  var mm = date.getMonth() + 1;
  var yyyy = date.getFullYear();

  //Add a zero if one Digit (eg: 05,09)
  if (dd < 10) {
    dd = "0" + dd;
  }

  //Add a zero if one Digit (eg: 05,09)
  if (mm < 10) {
    mm = "0" + mm;
  }

  minYear = yyyy - 18; //Calculate Minimun Age (<80)
  maxYear = yyyy - 1; //Calculate Maximum Age (>18)

  var min = minYear + "-" + mm + "-" + dd;
  var max = maxYear + "-" + mm + "-" + dd;
  console.log(min);
  console.log(max);

  document.getElementById("k_dob_start").setAttribute("min", min);
  document.getElementById("k_dob_start").setAttribute("max", max);
  document.getElementById("k_dob_start_edit").setAttribute("min", min);
  document.getElementById("k_dob_start_edit").setAttribute("max", max);
 });
 
 $('#mode').change(function(event) {
    if(this.value == 'Online'){
        $('#update').html('<div class="single-form"><input type="text" name="zoom_link" class="form-control" placeholder="Enter Zoom_link "></div>');
    }else{
        $('#update').html('<div class="single-form"><input type="text" name="zoom_link" class="form-control" placeholder="Enter Map Url "></div>');
    }
        
    });
 
 $('#session').change(function(event) {
    if(this.value == 's'){
        $('#update2').html('<div class="col-md-6 col-lg-4"><div class="single-form"><label for="">Enter Time</label><input type="time" name="time" class="form-control" placeholder="Enter Time "></div></div>');
    }else{
        $('#update2').html('<div class="col-md-6 col-lg-4"><div class="single-form"><label for="">END Date</label><input type="date" name="price" class="form-control" placeholder="End Date "></div></div><div class="col-md-6 col-lg-4"><div class="single-form"><label for="">Enter Start time Time </label><input type="text" name="time" class="form-control" placeholder="Enter Time "></div></div><div class="col-md-6 col-lg-4"><div class="single-form"><label for="">Session per hour</label><input type="time" name="time" class="form-control" placeholder="Session per hour (1,2) "></div></div>');
    }
        
    });
    </script>
   </body>
</html>