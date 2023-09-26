<?php include_once 'global.php'; ?>
<?php 

if(!empty($_GET['token'])){ $_SESSION['token'] = $_GET['token'];}

// print_r($_POST);
//     // die;
if (isset($_POST['edu_details'])) {
    // print_r($profile);
    // print_r($_POST);
    // print_r($_FILES["panDoc"]["name"]);
    // die;
    $pan_url = '';
    $add_url = '';
    $msg = '';
    $target_dir = "assets/images/doc_user_pan/";
    $temp = explode(".", $_FILES["panDoc"]["name"]);
    // print_r(end($temp));
    $newfilename = $_POST['f_name'].'_PAN_'.round(microtime(true)) . '.' . end($temp);
    $target_file = $target_dir . $newfilename;


    $temp1 = explode(".", $_FILES["addDoc"]["name"]);
    // print_r(end($temp));
    $newfilename1 = $_POST['f_name'].'_Addaar_'.round(microtime(true)) . '.' . end($temp1);
    $target_file1 = $target_dir . $newfilename1;


    $uploadOk = 1;
    // $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
// Check if image file is a actual image or fake image
    // if(isset($_POST["edu_details"])) {
    // $check = getimagesize($_FILES["panDoc"]["tmp_name"]);
    // echo $check;
    // if($check !== false) {
    //     $msg .= "File is an image - " . $check["mime"] . ".";
    //     $uploadOk = 1;
    // } else {
    //     $msg .=  "File is not an image.";
    //     $uploadOk = 0;
    // }
    // }

    // Check if file already exists
if (file_exists($target_file)) {
    $msg .=  "Sorry, file already exists.";
    $uploadOk = 0;
  }
  
  // Check file size
//   if ($_FILES["panDoc"]["size"] > 500000) {
//     $msg .= "Sorry, your file is too large.";
//     $uploadOk = 0;
//   }
  
  // Allow certain file formats
  
  // Check if $uploadOk is set to 0 by an error
  if ($uploadOk == 0) {
    $msg .=  "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["panDoc"]["tmp_name"], $target_file)) {
        $pan_url = $target_file;
        $msg .=  "The file ". htmlspecialchars( basename( $_FILES["panDoc"]["name"])). " has been uploaded.";
    } else {
        $msg .=  "Sorry, there was an error uploading your file.";
    }
  }
  if ($uploadOk == 0) {
    $msg .=  "Sorry, your file was not uploaded.";
  // if everything is ok, try to upload file
  } else {
    if (move_uploaded_file($_FILES["addDoc"]["tmp_name"], $target_file1)) {
        $add_url = $target_file1;
        $msg .=  "The file ". htmlspecialchars( basename( $_FILES["addDoc"]["name"])). " has been uploaded.";
    } else {
        $msg .=  "Sorry, there was an error uploading your file.";
    }
  }
//   echo $msg;
//   $product_url = 'creative_writing_lab_single.php';
    // die;
include('dbConfig.php');
// $age_tags = '-:-'.$_POST['age'].'-:-';
// INSERT INTO `enuiary_details` (`id`, `type`, `org_name`, `f_name`, `l_name`, `email`, `mobile_number`, `addressLine1`, `addressLine2`, `area`, `city`, `state`, `country`, `pincode`, `pan`, `GSTIN`, `bname`, `account_name`, `bank_name`, `account_number`, `ifsc_code`, `panDoc`, `addDoc`, `created_at`, `updated_at`, `status`) VALUES (NULL, 'ind', '', 'ak', 'ak last', 'kamatanand3@gail.com', '7045715869', 'mumbai', 'mumbai', 'mumbai', 'mumbai', 'MH', 'IN', '400101', 'afsf45sdgs', '14s5dg4', 'ssf', 'sfdf', 'sdf', 'sdf', 'sdf', 'sdf', 'sdf', current_timestamp(), current_timestamp(), '0');
// Array ( [f_name] => Anand [l_name] => Kamat [email] => kamat@gmail.com [mobile_number] => 7045715869 [addressLine1] => lan1 [addressLine2] => lan2 [pincode] => 401303 [pan] => 554654fsdf [type] => Individual [GSTIN] => 123235295 [bname] => sdf [account_name] => sdfsd [bank_name] => sdfs [account_number] => 211548484 [re_account_number] => 2184949494 [ifsc_code] => 546546
$sql = "INSERT INTO enuiary_details (`type`,`f_name`, `l_name`, `email`, `mobile_number`, `addressLine1`, `addressLine2`, `area`, `city`, `state`, `country`, `pincode`, `pan`, `GSTIN`, `bname`, `account_name`, `bank_name`, `account_number`, `ifsc_code`, `panDoc`, `addDoc`, `status`)
VALUES ('INDV','".$_POST['f_name']."', '".$_POST['l_name']."', '".$_POST['email']."', '".$_POST['mobile_number']."', '".$_POST['addressLine1']."', '".$_POST['addressLine2']."', '".$_POST['area']."', '".$_POST['city']."', '".$_POST['state']."', '".$_POST['country']."','".$_POST['pincode']."','".$_POST['pan']."','".$_POST['GSTIN']."','".$_POST['bname']."','".$_POST['account_name']."','".$_POST['bank_name']."','".$_POST['account_number']."','".$_POST['ifsc_code']."','".$pan_url."','".$add_url."','0')";
// die;
$db->query($sql);
$succ = $add_url;
}
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


        <!-- Login & Register Start -->
        <div class="section login-register-section mt-5">
            <div class="container">

                <!-- Login & Register Wrapper Start -->
                <div class="login-register-wrap mt-5">
                    <div class="row">
                    

                        <div class="col-lg-6 mx-auto">

                             <!-- Login & Register Box Start -->
                             <div class="login-register-box thankyou-section">
                             <div class="col-lg-6 mx-auto mb-4">
                            <h3 class="text-center" style="color: #eb5e36 !important;">Contact Kidiaree</h3>
                            <p class="mt-3 text-send"> <a target="_blank" href="https://api.whatsapp.com/send?phone=919833992919&text=Hello" class="whatsapp-button"><i class="fab fa-whatsapp"></i>  Send a message</a></p>
                        <p class="text-send"><a href="tel:+919833992919"><i class="flaticon-phone-call"></i> +91 98339 92919</a></p>
        <p class="text-send"><a target="_blank" href="mailto:saumyasaraogi@kidiaree.in" class="whatsapp-button"><i class="far fa-envelope"></i> Send an Email</a></p>

                        </div>

                        <hr>

                                <div class="login-register-form text-center mt-4">
                                    <h4  style="color: #eb5e36 !important;">Thank you!</h4>
                                    <p>Your details have been received.</p>
                                    <p>Kidiaree will be contacting you very soon!</p>
                                    
                                </div>
                            </div>
                            <!-- Login & Register Box End -->

                        </div>
                    </div>
                </div>
                <!-- Login & Register Wrapper End -->

            </div>
        </div>
        <!-- Login & Register End -->



        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Enter Otp</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      <input id="partitioned" type="text" maxlength="4" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Confirm</button>
      </div>
    </div>
  </div>
</div>

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
    var localpin = localStorage.getItem("pin");
    $('#pincode').val(localpin);
    if (localpin !== "") {
    // strValue was empty string
    if(localpin.length >= 6){
            // let pin = document.getElementById("text").value;
            $.getJSON("https://api.postalpincode.in/pincode/" + localpin, function (data) {
                // let response = JSON.parse(data);
                if (data[0].PostOffice && data[0].PostOffice.length) {
                    for (var i = 0; i < data[0].PostOffice.length; i++) {
                        $("#area").val(data[0].PostOffice[i].Name)
                        $("#city").val(data[0].PostOffice[i].Region)
                        $("#state").val(data[0].PostOffice[i].State)
                        $("#country").val(data[0].PostOffice[i].Country)
                    }
                }
            console.log(data);
            })

        }
    }
    
    $("#pincode").on("change paste keyup", function() {
        var pin = $(this).val();
        if(pin.length >= 6){
            // let pin = document.getElementById("text").value;
            $.getJSON("https://api.postalpincode.in/pincode/" + pin, function (data) {
                // let response = JSON.parse(data);
                if (data[0].PostOffice && data[0].PostOffice.length) {
                    for (var i = 0; i < data[0].PostOffice.length; i++) {
                        $("#area").val(data[0].PostOffice[i].Name)
                        $("#city").val(data[0].PostOffice[i].Region)
                        $("#state").val(data[0].PostOffice[i].State)
                        $("#country").val(data[0].PostOffice[i].Country)
                    }
                }
            console.log(data);
            })

        }
    });
 });
 
 function saveAddressTeacher(){
  var idUser =  localStorage.getItem("idUser");
  var token =  localStorage.getItem("token");
  console.log(token);
  var email =  $('#email').val(); 
  var addressLine1 =  $('#addressLine1').val(); 
  var addressLine2 = $('#addressLine2').val(); 
  var area =  $('#area').val(); 
  var city =  $('#city').val(); 
  var state =  $('#state').val(); 
  var country =  $('#country').val(); 
  var pincode =  $('#pincode').val(); 
  console.log(addressLine1);
  console.log(addressLine2);
  console.log(area);
  console.log(city);
  console.log(state);
  console.log(country);
  console.log(pincode);
  $.ajax({
    url: './main-file/update_user_profile.php',
    type:'POST',
    headers: {
        'Authorization': 'Bearer '+token
    },
    data:
    {
        // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
        email: email,
        addressLine1: addressLine1,
        addressLine2: addressLine2,
        area: area,
        city: city,
        state: state,
        country: country,
        pincode: pincode
    },
    success: function(msg)
    {
      let response = JSON.parse(msg);
      console.log(response);
      if(response.code == "200"){
        window.location.href = 'teacher_dashboard.php';
      } else {
        // $('#otpError').html('Otp is incorrect!');
      }
      
      // $('#idUser').val(response.body.id)
    }               
});
}
    </script>

</body>

</html>