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
header("Location: educator_details_thank_you.php"); exit;

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


        <!-- Page Banner Start -->
        <div class="section page-banner-section" style="background-image: url(assets/images/bg/page-banner.jpg);">
            <div class="shape-1">
                <img src="assets/images/shape/shape-7.png" alt="">
            </div>
            <div class="shape-2">
                <img src="assets/images/shape/shape-1.png" alt="">
            </div>
            <div class="shape-3"></div>
            <div class="container">
                <div class="page-banner-wrap">
                    <div class="row">
                        <div class="col-lg-12">
                            <!-- Page Banner Content Start -->
                            <div class="page-banner text-center">
                                <h2 class="title">Registration</h2>
                                <ul class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Partner Registration </li>
                                </ul>
                            </div>
                            <!-- Page Banner Content End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Banner End -->

        <!-- Login & Register Start -->
        <div class="section login-register-section section-padding">
            <div class="container">

                <!-- Login & Register Wrapper Start -->
                <div class="login-register-wrap">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">

                             <!-- Login & Register Box Start -->
                             <div class="login-register-box">
                                <!-- Section Title Start -->
                                <div class="section-title">
                                    <h2>Partner Details</h2>
                                </div>
                                <!-- Section Title End -->

                                <div class="login-register-form">
                                    <form action="" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate onSubmit = "return checkPassword(this)">
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="f_name" name="f_name" placeholder="First Name" required>
                                            <div class="invalid-feedback">
                                                First Name is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="l_name" name="l_name" placeholder="Last Name" required>
                                            <div class="invalid-feedback">
                                                Last Name is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email ID" required>
                                            <div class="invalid-feedback">
                                                Email ID is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text"  class="form-control" id="mobile_number" name="mobile_number" placeholder="Mobile Number" required>
                                            <div class="invalid-feedback">
                                                Mobile Number is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="addressLine1" name="addressLine1" placeholder="Address Line 1 " required>
                                            <div class="invalid-feedback">
                                                Address Line 1 is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="addressLine2" name="addressLine2" placeholder="Address Line 2" required>
                                            <div class="invalid-feedback">
                                                Address Line 2 is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode " required>
                                             <div class="invalid-feedback">
                                                Pincode is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="area" name="area" placeholder="Area" required>
                                            <div class="invalid-feedback">
                                                Area is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="city" name="city" placeholder="City" required>
                                            <div class="invalid-feedback">
                                               City is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="state" name="state" placeholder="State " required>
                                            <div class="invalid-feedback">
                                                State is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="country" name="country" placeholder="Country " required>  
                                            <div class="invalid-feedback">
                                                Country is required!
                                            </div>
                                        </div>
                                        
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="Pan" name="pan" placeholder="PAN" required>
                                            <div class="invalid-feedback">
                                                PAN is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <div class="radio-button">
                                                <div for="">Do you have a GST Identification Number (GSTIN)?</div>
                                                <input type="radio" id="type" name="type" value="yes" checked required/>
                                                <label for="Individual">Yes</label>
                                                <input type="radio" id="type" style="margin-left: 10px;" name="type" value="no" required/>
                                                <label for="Organization">No</label>
                                            </div>
                                            <div class="invalid-feedback">
                                                GSTIN is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="GSTIN" name="GSTIN" placeholder="GSTIN" required>
                                            <div class="invalid-feedback">
                                                GSTIN is required!
                                            </div>
                                        </div>

                                        <hr class="mt-4 mb-4">
                                        <div class="section-title mt-3">
                                            <h2>Bank Details</h2>
                                        </div>

                                        <div class="single-form">
                                            <input type="text" class="form-control" id="account_name" name="account_name" placeholder="Beneficiary Account Name" required>
                                            <div class="invalid-feedback">
                                                Beneficiary Account Name is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="account_number" name="account_number" placeholder="Account Number" required>
                                            <div class="invalid-feedback">
                                                Account Number is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="re_account_number" name="re_account_number" placeholder="Re-enter Account Number" required>
                                            <div class="invalid-feedback">
                                                Account Number not a match
                                            </div>
                                            <div id="not_match"></div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="IFSC Code " required>
                                            <div class="invalid-feedback">
                                                IFSC Code is required!
                                            </div>
                                            <p id="address_bank"></p>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name" required>
                                            <div class="invalid-feedback">
                                               Bank Name is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="bank_branch" name="bank_branch" placeholder="Branch Name" required>
                                            <div class="invalid-feedback">
                                               Branch Name is required!
                                            </div>
                                        </div>

                                        <div class="section-title mt-3">
                                            <h2>Document Upload </h2>
                                        </div>

                                        <div class="single-form">
                                            <label for="">PAN Card Photo copy</label>
                                            <input type="file" class="form-control" id="panDoc" name="panDoc" placeholder="Upload Pan " required>
                                            <div class="invalid-feedback">
                                                Copy of PAN Card is required!
                                            </div>
                                        </div>
                                        <div class="single-form">
                                            <label for="">Adhaar Card Photo copy</label>
                                            <input type="file" class="form-control" id="addDocpan" name="addDoc" placeholder="Upload Pan " required>
                                            <div class="invalid-feedback">
                                                Copy of Aadhaar Card is required!
                                            </div>
                                        </div>

                                        <div class="form-btn mt-3">
                                            <button type="submit" class="btn" name="edu_details" id="submit_details_inv" disabled>Save Details</button>
                                        </div>
                                    </form>
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
        <div class="modal fade" id="gst_terms" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body text-center">
      Terms & conditions
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" onclick="gstConfirmation()">Confirm</button>
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
// is same or not.
function checkPassword(form) {
                account_number = form.account_number.value;
                re_account_number = form.re_account_number.value;
  
                // If password not entered
                if (account_number == '')
                    alert ("Please check the details entered");
                      
                // If confirm password not entered
                else if (re_account_number == '')
                    alert ("Please check the details entered");
                      
                // If Not same return False.    
                else if (account_number != re_account_number) {
                    $("#not_match") = html("Account number not matched");
                    alert ("\nPlease check the details entered")
                    return false;
                }
  
                // If same return True.
                // else{
                //     alert("Password Match: Welcome to GeeksforGeeks!")
                //     return true;
                // }
            }

// Example starter JavaScript for disabling form submissions if there are invalid fields
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


$(document).ready(function () {  
        $("#Pan").keyup(function () {  
            $(this).val($(this).val().toUpperCase());  
        });  
        
    }); 
    $("#re_account_number").keyup(function () {  
        var account_number =  $('#account_number').val();   
        var re_account_number =  $('#re_account_number').val();   
        if(account_number == re_account_number) {
            $('#submit_details_inv').prop("disabled", false);
            $("#not_match").html("");
        }else{
            $("#not_match").html("Account number not matched");
            $('#submit_details_inv').prop("disabled", true);
        }
    });  
   
    
    $("#ifsc_code").keyup(function () {  

// HDFC0000182
var ifsc_code =  $('#ifsc_code').val(); 

$.ajax({
url: './ifsc.php?ifsc='+ifsc_code,
type:'POST',
success: function(msg)
{
let response = JSON.parse(msg);
console.log(response);
console.log(response.length);
if(response != "undefined"){
console.log(response.body.ADDRESS);
$("#address_bank").html(response.body.ADDRESS);
$("#bank_name").val(response.body.BANK);
$("#bank_branch").val(response.body.BRANCH);
}


// $('#idUser').val(response.body.id)
},
error: function(xhr){
alert('Request Status: ' + xhr.status + ' Status Text: ' + xhr.statusText + ' ' + xhr.responseText);
}             
});  


});  

$('input[type=radio][name=type]').change(function() {
    if (this.value == 'yes') {
        $('#GSTIN').val('');
        $('#GSTIN').attr('type', 'text');
    }
    else if (this.value == 'no') {
        $('#gst_terms').modal('show');
    }
});

function gstConfirmation(){
    $('#GSTIN').val('No');
    $('#GSTIN').attr('type', 'hidden');
    $('#gst_terms').modal('hide');
}
    </script>



   




</body>

</html>