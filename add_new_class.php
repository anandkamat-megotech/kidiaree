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
    $temp = explode(".", $_FILES["thumbnail"]["name"]);
    $newfilename = $_FILES["thumbnail"]["name"].round(microtime(true)) . '.' . end($temp);
    $target_file = $target_dir . $newfilename;
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
  $product_url = 'creative_writing_lab_single.php';
    // die;
include('dbConfig.php');
// print_r($_POST);
// die;
$age_tags = '-:-';
for($i=$_POST['age']; $i<=$_POST['ageMax']; $i++) {
    $age_tags.= $i.'-:-';
  }
$sql = "INSERT INTO products (name, sub_name, description,tags,teacher_id,price,type,thumbnail,age,age_tags,status,product_url)
VALUES ('".$_POST['class_name']."', '".$_POST['sub_name']."', '".$_POST['description']."', '".$_POST['tags']."', '".$profile->body[0]->id."', '".$_POST['price']."', '".$_POST['type']."', '".$thumbnails_url."', '".$_POST['age'].'-'.$_POST['ageMax']."', '".$age_tags."', '0', '".$product_url."')";
// die;
$db->query($sql);
}
?>
<?php
$timenow = time();
$opentime = strtotime('05:00');
$closetime = strtotime('20:59');
$select ='<select class=" nice-select w-100 mb-2">';
if($timenow > $closetime || $timenow <= $opentime){
    $select.= '<option value="Closed">CLOSED</option>';
    $select.= "</select>"; 
} 
else{
    // you said you wanted the time to start in 1 hour, but had +15 minutes...
    $deliverytime = strtotime('05:00');
    // $deliverytime = strtotime('+15 minutes', $timenow);
    // round to next 15 minutes (15 * 60 seconds)
    $deliverytime = ceil($deliverytime / (15*60)) * (15*60);
    // echo $deliverytime;
    // $select.= '<option value="asap">As soon as possible</option>';
    while($deliverytime <= $closetime && $deliverytime >= $opentime) {
        $select.=  '<option value="'. date('h:i A', $deliverytime) .'">' . date('h:i A', $deliverytime) . '</option>';
        $deliverytime = strtotime('+15 minutes', $deliverytime);
    }
    $select.=  "</select>"; 
}




function pad_number(&$item, $key, $pad = 2)
{
	$item = sprintf('%0'.$pad.'d', $item);
}

function build_time_options($hours, $minutes, $time)
{
	// pad hours and minutes with 0
	array_walk($hours, 'pad_number');
	array_walk($minutes, 'pad_number');
	$time_hour_options = '';
	$time_minute_options = '';
	
	$time_components = explode(':', $time);

	foreach($hours as $hour)
	{
		if(count($time_components) == 2)
		{
			if($time_components[0] == $hour)
			{
				$time_hour_options .= '<option selected="selected">'.$hour.' hour</option>';
			}
			else
			{
				$time_hour_options .= '<option>'.$hour.' hours</option>';
			}
		}
		else
		{
			$time_hour_options .= '<option>'.$hour.' hour</option>';
		}
	}
	foreach($minutes as $minute)
	{
		if(count($time_components) == 2)
		{
			if($time_components[1] == $minute)
			{
				$time_minute_options .= '<option selected="selected">'.$minute.' minutes</option>';
			}
			else
			{
				$time_minute_options .= '<option>'.$minute.' minutes</option>';
			}
		}
		else
		{
			$time_minute_options .= '<option>'.$minute.' minutes</option>';
		}
	}
	
	return array('hours' => $time_hour_options, 'minutes' => $time_minute_options);
}
	
$hours = array(0,1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23);
$minutes = array(0,15,30,45);

$event_time = '0:30';

$time_options = build_time_options($hours, $minutes, $event_time);

$timer = '<select name="event_time_hour" class="form-control" style="display:inline;width:50%;padding: 8px 25px;">'.$time_options['hours'].'</select>';
$timer .='<select name="event_time_minute" class="form-control" style="display:inline;width:50%;padding: 8px 25px;">'.$time_options['minutes'].'</select>';
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
                            <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="class_name" class="form-control" placeholder="Enter Class Title " required>
                                            <div class="invalid-feedback">
                                                Class Title is empty!
                                            </div>
                                         </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="sub_name" class="form-control" placeholder="Enter sub-name " required>
                                            <div class="invalid-feedback">
                                                Sub name is empty!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="description" class="form-control" placeholder="Enter Description - 'About the Class' " required>
                                            <div class="invalid-feedback">
                                                Description is empty!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="tags" class="form-control" placeholder="Enter Suggested Tags (tag1, tag2) " required>
                                            <div class="invalid-feedback">
                                                Suggested Tags is empty!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                        <select class=" w-100" name="type"  id="mode" required> 
                                            <option value="">Select Mode</option>
                                            <option>Online</option>
                                            <option>Offline</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Mode is empty!
                                        </div>
                                    </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4" id="update"></div>
                                    <div class="col-md-6 col-lg-4 d-none" id="address_section">
                                        <div class="single-form">
                                        <select class=" w-100" name="address_use"  id="address_use"> 
                                            <option value="">Select Address</option>
                                            <option value="exising">Use Existing</option>
                                            <option value="new">Add New</option>
                                        </select>
                                        <div class="invalid-feedback">
                                            Mode is empty!
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                    <div class="row d-none" id="address_section_details">
                                        <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="addressLine1" name="addressLine1" placeholder="Address Line 1 ">
                                            <div class="invalid-feedback">
                                                Address Line 1 is empty!
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="addressLine2" name="addressLine2" placeholder="Address Line 2">
                                            <div class="invalid-feedback">
                                                Address Line 2 is empty!
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="area" name="area" placeholder="Area">
                                            <div class="invalid-feedback">
                                                Area is empty!
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="city" name="city" placeholder="City">
                                            <div class="invalid-feedback">
                                               City is empty!
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="state" name="state" placeholder="State ">
                                            <div class="invalid-feedback">
                                                State is empty!
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="country" name="country" placeholder="Country ">  
                                            <div class="invalid-feedback">
                                                Country is empty!
                                            </div>
                                        </div>
                                        </div>
                                        <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode ">
                                             <div class="invalid-feedback">
                                                Pincode is empty!
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                    
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                        <select class=" w-100" name="age" id="ageMin" required>
                                            <option value="">Minimum Age</option>
                                            <option value="01">1</option>
                                            <option value="02">2</option>
                                            <option value="03">3</option>
                                            <option value="04">4</option>
                                            <option value="05">5</option>
                                            <option value="06">6</option>
                                            <option value="07">7</option>
                                            <option value="08">8</option>
                                            <option value="09">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">18</option>
                                        </select>
                                        <div class="invalid-feedback">
                                                Minimum age is empty!
                                        </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                        <select class=" w-100" name="ageMax" id="ageMax" required>
                                            <option value="">Maximum Age</option>
                                            <option value="01">1</option>
                                            <option value="02">2</option>
                                            <option value="03">3</option>
                                            <option value="04">4</option>
                                            <option value="05">5</option>
                                            <option value="06">6</option>
                                            <option value="07">7</option>
                                            <option value="08">8</option>
                                            <option value="09">9</option>
                                            <option value="10">10</option>
                                            <option value="11">11</option>
                                            <option value="12">12</option>
                                            <option value="13">13</option>
                                            <option value="14">14</option>
                                            <option value="15">15</option>
                                            <option value="16">16</option>
                                            <option value="17">18</option>
                                        </select>
                                        <div id="maxage_error" style="color:red"></div>
                                        <div class="invalid-feedback">
                                                Maximum age is empty!
                                        </div>
                                    </div>
                                    </div>
                                    <!-- <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <input type="text" name="product_url" class="form-control" placeholder="Enter product_url">
                                        </div>
                                    </div> -->
                                    
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                        <select class=" w-100" name="session"  id="session" required>
                                            <option value="">Select Class type</option>
                                            <option value="s">Single-Session Class/Workshop/Camp</option>
                                            <option value="m">Multi-Session Class/Workshop/Camp</option>
                                            <option value="m">Regular Classes</option>
                                        </select>
                                        <div class="invalid-feedback">
                                                Class type is empty!
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                        <label for="" id="date_label">Date</label>
                                            <input type="date" min="<?php echo date('Y-m-d') ?>" name="price" class="form-control" placeholder="Date" id=startDate required>
                                            <div class="invalid-feedback">
                                                Date is empty!
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                    <div class="row" id="update2"></div>
                                    <div class="row">
                                    <div class="col-md-6 col-lg-4 d-none" id="recurr"><div class="single-form"><select class=" w-100" name="recurrence"  id="recurrence"><option value="">Select Class Recurrence</option><option value="d">Daily</option><option value="w">Weekly</option><option value="y">Yearly</option></select>
                                    <div class="invalid-feedback">
                                        Class Recurrence is empty!
                                    </div>
                                    </div></div>
                                    <div class="col-md-6 col-lg-4 d-none" id="daysWeek"><div class="single-form" ><div class="weekDays-selector"><input type="checkbox" name="week[]" value="1" id="weekday-mon" class="weekday" /><label for="weekday-mon">MON</label><input type="checkbox"  name="week[]" value="2"  id="weekday-tue" class="weekday" /><label for="weekday-tue">TUE</label><input type="checkbox"  name="week[]" value="3"  id="weekday-wed" class="weekday" /><label for="weekday-wed">WED</label><input type="checkbox"  name="week[]" value="4"  id="weekday-thu" class="weekday" /><label for="weekday-thu">THU</label><input type="checkbox"  name="week[]" value="5"  id="weekday-fri" class="weekday" /><label for="weekday-fri">FRI</label><input type="checkbox"  name="week[]" value="6"  id="weekday-sat" class="weekday" /><label for="weekday-sat">SAT</label><input type="checkbox"  name="week[]" value="7"  id="weekday-sun" class="weekday" /><label for="weekday-sun">SUN</label><button id="save_value" class="weeksave">save</button></div></div></div>
                                    </div>
                                    <div class="row mt-2 d-none" id="update4"></div>
                                    <div class="row" id="update5"></div>
                                    
                                    
                                    
                                    <div class="row" id="update3"></div>
                                    

                                    



                                    <div class="row">
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form">
                                            <label for="" style="text-transform: unset !important;">Fees (Inclusive of GST)</label>
                                            <input type="text" name="price" class="form-control" placeholder="" required>
                                            <div class="invalid-feedback">
                                                Fees is empty!
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-6 col-lg-4">
                                        <div class="single-form add_new_class">
                                            <label for="" style="margin-bottom: 0px !important;">Upload Image / Creative </label>
                                            <span class="validation-image">Image size (400px X 600px)</span>
                                            <input type="file" name="thumbnail" class="form-control" placeholder="Enter type " required>
                                            <div class="invalid-feedback">
                                                Image is empty!
                                            </div>
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
      <script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.17.1/moment.min.js"></script>
      <script>
   
 
 $('#mode').change(function(event) {
    if(this.value == 'Online'){
        $('#update').html('<div class="single-form"><input type="text" name="zoom_link" class="form-control" placeholder="Enter joining link "></div>');
        $('#address_section').addClass('d-none');
    }else{
        $('#address_section').removeClass('d-none');
        $('#update').html('<div class="single-form"><input type="text" name="zoom_link" class="form-control" placeholder="Enter Map Url "></div>');
    }
        
    });
 $('#address_use').change(function(event) {
    if(this.value == 'new'){
        $('#address_section_details').removeClass('d-none');
    }else{
        $('#address_section_details').addClass('d-none');
    }
        
    });
    
 $('#session').change(function(event) {
    if(this.value == 's'){
        $('#recurr').toggleClass('d-none');
        $('#update4').addClass('d-none');
        $('#date_label').html('Date');
        $('#update2').html('<div class="col-md-6 col-lg-4"><div class="single-form"><label for="">Select Time</label><?php echo $select; ?></div></div><div class="col-md-6 col-lg-4"><div class="single-form"><label for="">Duration</label><?php echo $timer ; ?></div></div>');
    }else{
        $('#update4').removeClass('d-none');
        $('#recurr').removeClass('d-none');
        $('#date_label').html('Start Date');
        $('#update2').html('<div class="col-md-6 col-lg-4"><div class="single-form"><label for="">End Date</label><input type="date" name="price" class="form-control" placeholder="End Date " id="endDate"></div></div>');
        $('#update5').html('<div class="col-md-6 col-lg-4"><div class="single-form"><label for="">Enter Start time </label><?php echo $select; ?></div></div><div class="col-md-6 col-lg-4"><div class="single-form"><label for="">Duration</label><?php echo $timer ; ?></div></div>');
    }
        
    });

    $('#ageMax').change(function(event) {
       var minAge = $('#ageMin').val();
       var maxAge =$('#ageMax').val();
       console.log(minAge);
       console.log(maxAge);
       if(minAge > maxAge){
        $('#maxage_error').html('Maximum Age needs to be more than min age')
        $('#ageMax').val('')
       }else{
        $('#maxage_error').html('');
       }
     });
    $('#recurrence').change(function(event) {
    if(this.value == 'w' || this.value == 'y'){
        $('#daysWeek').removeClass('d-none');
        // $('#update3').html('<div class="col-md-6 col-lg-4"><div class="single-form" id="daysWeek"><div class="weekDays-selector"><input type="checkbox" name="week[]" id="weekday-mon" class="weekday" /><label for="weekday-mon">MON</label><input type="checkbox"  name="week[]"  id="weekday-tue" class="weekday" /><label for="weekday-tue">TUE</label><input type="checkbox"  name="week[]"  id="weekday-wed" class="weekday" /><label for="weekday-wed">WED</label><input type="checkbox"  name="week[]"  id="weekday-thu" class="weekday" /><label for="weekday-thu">THU</label><input type="checkbox"  name="week[]"  id="weekday-fri" class="weekday" /><label for="weekday-fri">FRI</label><input type="checkbox"  name="week[]"  id="weekday-sat" class="weekday" /><label for="weekday-sat">SAT</label><input type="checkbox"  name="week[]"  id="weekday-sun" class="weekday" /><label for="weekday-sun">SUN</label></div></div></div>');
    }else{
        $('#daysWeek').addClass('d-none');
        $('#update3').html('');
    }
        
    });
    (function () {
  'use strict'

  // Fetch all the forms we want to apply custom Bootstrap validation styles to
  var forms = document.querySelectorAll('.needs-validation')

  // Loop over them and prevent submission
  Array.prototype.slice.call(forms)
    .forEach(function (form) {
      form.addEventListener('submit', function (event) {
        if (!form.checkValidity()) {
          event.preventDefault()
          event.stopPropagation()
        }

        form.classList.add('was-validated')
      }, false)
    })
})()
$('#startDate').change(function(event) {
    var min = $('#startDate').val();
    $('#endDate').val('');
    document.getElementById("endDate").setAttribute("min", min);
});

$('#recurrence').change(function(event) {
    var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    const oneDay = 24 * 60 * 60 * 1000; // hours*minutes*seconds*milliseconds
    const firstDate = new Date(startDate);
    const secondDate = new Date(endDate);
    if(this.value == 'd'){
        const diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay)+1);
        $('#update4').html('<div>Recurrence session : '+diffDays+'</div>');
    }
    if(this.value == 'w'){
        $('#update4').html('');
    }
    
});

$(function(){
      $('#save_value').click(function(){
        var val = [];
        $(':checkbox:checked').each(function(i){
          val[i] = $(this).val();
        });
        console.log(val);
        var startDate = $('#startDate').val();
    var endDate = $('#endDate').val();
    var daysDiff_week = countCertainDays(val,new Date(startDate),new Date(endDate))
    $('#update4').html('<div class="col-md-6 col-lg-4">Recurrence session : '+daysDiff_week+'</div>');
        console.log(daysDiff_week);
      });
    });
    function countCertainDays( days, d0, d1 ) {
  var ndays = 1 + Math.round((d1-d0)/(24*3600*1000));
  var sum = function(a,b) {
    var valueDays = $('#recurrence').find(":selected").val();
    var daysFor = 7;
    if(valueDays == 'y'){daysFor = 365;}
    return a + Math.floor( ( ndays + (d0.getDay()+6-b) % 7 ) / daysFor ); };
  return days.reduce(sum,0);
}
    </script>
   </body>
</html>