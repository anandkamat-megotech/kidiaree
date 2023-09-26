
<?php include_once 'global.php'; ?>
<?php
// if(!empty($_SESSION['token'])){
//      header("Location: index.php"); exit;
// }

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
                                <h2 class="title">Become a Partner </h2>
                                <ul class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Become a Partner </li>
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
                <div class="login-register-wrap mt-5">
                    <div class="row">
                        <div class="col-lg-6 mx-auto">
                            <h3 class="text-center"  style="color: #eb5e36 !important;">Thank you for your interest</h3>
                            <p class="mt-3 text-send"> <a target="_blank" href="https://api.whatsapp.com/send?phone=+91 9833992919&text=Hello" class="whatsapp-button"><i class="fab fa-whatsapp"></i>  Send a message</a></p>
                        <p class="text-send"><a href="tel:+919833992919"><i class="flaticon-phone-call"></i> +91 9833992919</a></p>
        <p class="text-send"><a target="_blank" href="mailto:saumyasaraogi@kidiaree.in" class="whatsapp-button"><i class="far fa-envelope"></i> Send an Email</a></p>

                        </div>
                        <div class="col-lg-6 mx-auto enqua">
                        <div class="login-register-box">
                        <div class="login-register-form">
                            <h4 class="text-center">Alternatively, please share your details below, for us to contact you</h4>
                            <div class="single-form">
                                <input type="text" class="form-control" placeholder="Name " id="en_name">
                            </div>
                            <div class="single-form">
                                <input type="text" class="form-control" placeholder="Contact Number " id="en_contact">
                            </div>
                            <div class="single-form">
                                <input type="text" class="form-control" placeholder="Email " id="en_email">
                            </div>
                            <div class="form-btn">
                                            <button class="btn" onclick="sendEnquiry()">Send</button>
                                        </div>
                        </div>
                        </div>
                        </div>
                    </div>
                </div>
                <!-- Login & Register Wrapper End -->

            </div>
        </div>
        <!-- Login & Register End -->



        <!-- Modal -->
        <div class="modal fade" id="optSendModal" tabindex="-1" aria-labelledby="optSendModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="optSendModalLabel">Enter OTP</h5>
      </div>
      <div class="modal-body text-center">
      <input id="idUser" type="hidden"/>
      <input id="partitioned" type="text" maxlength="4" />
      <div id="otpError" class="mt-2" style="color: red;"></div>
      </div>
      <div class="text-center" style="margin-bottom: 10px;"><span onclick="ClearOtp()" class="text-center mb-2" style="color:red !important; margin-right: 20px;display: inline;">Clear OTP</span>
      <span onclick="sendOtpTeacher()" class="text-center text-primary mb-2" style="display: inline;">Resend OTP</span></div>
      
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal('optSendModal')">Close</button>
        <button type="button" class="btn btn-primary" onclick="VerifyOtp()">Confirm</button>
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

    <?php include('const/scripts.php');  ?>
    <script>
    var obj = document.getElementById('partitioned');
    console.log(obj);

if(obj != null){
  obj.addEventListener('keydown', stopCarret); 
  obj.addEventListener('keyup', stopCarret); 
}

function stopCarret() {
    console.log(obj.value.length)
    console.log(obj)
    if (obj.value.length < 4){
        setCaretPosition(obj, 3);
    }else {
         obj.blur();
    }
}

function setCaretPosition(elem, caretPos) {
    if(elem != null) {
        if(elem.createTextRange) {
            var range = elem.createTextRange();
            range.move('character', caretPos);
            range.select();
        }
        else {
            console.log(elem.selectionStart);
            if(elem.selectionStart) {
                elem.focus();
                elem.setSelectionRange(caretPos, caretPos);
            }
            // else
                // elem.focus();
        }
    }
}
function ClearOtp(){
    document.getElementById('partitioned').value='';
}

function sendOtpTeacher(){
  var emailorphone = $('#emailorphone').val();
  console.log(emailorphone);
  let url = 'validate_mobile_teacher.php';
  function validatePhoneNumber(input_str) {
    var re = /^\(?(\d{3})\)?[- ]?(\d{3})[- ]?(\d{4})$/;
  
    return re.test(input_str);
  }

  var datavalue = validatePhoneNumber(emailorphone);
  console.log(datavalue);
  if(datavalue){
    url = 'validate_mobile_teacher.php';
  }

  // var regex = new RegExp('/^(\+\d{1,3}[- ]?)?\d{10}$/');
  var regex = new RegExp('^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})|(^[0-9]{10})+$');
  
  if(emailorphone){
  		 if(!regex.test(emailorphone)){
          document.getElementById("emailorphone").focus();
          $("#validationError").text("Please enter valid phone number.")
       }else{
         $("#validationError").text('')
         $.ajax({
          url: './main-file/'+url,
          type:'POST',
          data:
          {
              // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
              data: $('#emailorphone').val()
          },
          success: function(msg)
          {
            var element = document.getElementById("optSendModal");
              element.classList.add("show");
              element.classList.add("d-block");
            let response = JSON.parse(msg);
            console.log(response.body.id);
            localStorage.setItem("idUser", response.body.id);
            $('#idUser').val(response.body.id)
          }               
      });
       }
  }else{
    document.getElementById("emailorphone").focus();
   	$("#validationError").text('This field is required.')
  }

console.log(url);
 
}
    </script>

<script>
        function sendEnquiry(){

  var en_name =  $('#en_name').val(); 
  var en_contact = $('#en_contact').val(); 
  var en_email = $('#en_email').val(); 
  console.log(en_name);
  console.log(en_contact);
  $.ajax({
    url: './main-file/add_enquiry.php',
    type:'POST',
    data:
    {
        // The key is 'mobile'. This will be the same key in $_POST[] that holds the mobile number value.
        en_name: en_name,
        en_email: en_email,
        en_contact: en_contact
    },
    success: function(msg)
    {
      let response = JSON.parse(msg);
      console.log(response);
      if(response.code == "200"){
        window.location.href = 'educator_details_thank_you_msg.php';
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