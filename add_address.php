<?php include_once 'global.php'; ?>
<?php 

if(!empty($_GET['token'])){ $_SESSION['token'] = $_GET['token'];}

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

        <!-- Header Start  -->
        <?php include('const/header.php'); ?>
        <!-- Header End -->


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
                                <h2 class="title">Address Details</h2>
                                <ul class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Address </li>
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
                                    <h2>Add Address</h2>
                                </div>
                                <!-- Section Title End -->

                                <div class="login-register-form">
                                    <!-- <form action="#"> -->
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="yfname" name="yfname" placeholder="Parent First Name">
                                            <p id="validationErrorName" style="color: red;"></p>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="ylname" name="ylname" placeholder="Parent Last Name">
                                            <p id="validationErrorLname" style="color: red;"></p>
                                        </div>
                                        <div class="single-form">
                                            <input type="email" class="form-control" id="email" name="email" placeholder="Email">
                                            <p id="validationErrorEmail" style="color: red;"></p>
                                        </div>
                                        
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="pincode" name="pincode" placeholder="Pincode ">
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="area" name="area" placeholder="Area" disabled>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="city" name="city" placeholder="City" disabled>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="state" name="state" placeholder="State " disabled>
                                        </div>
                                        <div class="single-form">
                                            <input type="text" class="form-control" id="country" name="country" placeholder="Country " disabled> 
                                        </div>
                                        


                                        <div class="form-btn mt-3">
                                            <button class="btn" onclick="saveAddress()">Save</button>
                                        </div>
                                    <!-- </form> -->
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

        <!-- Footer Start -->
        <?php include('const/footer.php'); ?>
        <!-- Footer End -->

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
 
 function saveAddress(){
  var idUser =  localStorage.getItem("idUser");
  var token =  localStorage.getItem("token");
  console.log(token);
  console.log(token);
  var email =  $('#email').val(); 
  var yfname =  $('#yfname').val(); 
  var ylname =  $('#ylname').val(); 
  var addressLine1 =  "xyz"; 
  var addressLine2 = "abc"; 
  var area =  $('#area').val(); 
  var city =  $('#city').val(); 
  var state =  $('#state').val(); 
  var country =  $('#country').val(); 
  var pincode =  $('#pincode').val(); 
  console.log(ylname);
  console.log(addressLine1);
  console.log(addressLine2);
  console.log(area);
  console.log(city);
  console.log(state);
  console.log(country);
  console.log(pincode);
  var validRegexemail = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
  
  var validationaddAddress = true; 
  $("#validationErrorName").text("");
  $("#validationErrorLname").text("");
  $("#validationErrorEmail").text("");
  if(yfname == ''){
  $("#validationErrorName").text("Parent First Name is requried!.");
  validationaddAddress = false; 
  }
  if(ylname == ''){
  $("#validationErrorLName").text("Parent Last Name is requried!.");
  validationaddAddress = false; 
  }
  if(email == ''){
    $("#validationErrorEmail").text("Email is requried!.");
    validationaddAddress = false; 
    }else if(!validRegexemail.test(email)){
    document.getElementById("email").focus();
    $("#validationErrorEmail").text("Please enter valid email.")
    validationaddAddress = false; 
    }
    if(validationaddAddress){
   
  $('#preloader').show();
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
        yfname: yfname,
        ylname: ylname,
        pincode: pincode,
        step_number: 2
    },
    success: function(msg)
    {
      let response = JSON.parse(msg);
      console.log(response);
      if(response.code == "200"){
        window.location.href = 'dashboard.php';
      }
      
      // $('#idUser').val(response.body.id)
    }           
});
}
}

    </script>

</body>

</html>