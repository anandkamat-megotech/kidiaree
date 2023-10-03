
<?php include_once 'global.php'; ?>
<?php
if(!empty($_SESSION['token'])){
     header("Location: index.php"); exit;
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
                                <h2 class="title">OTP</h2>
                                <ul class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">OTP </li>
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

               <!-- OTP Form
      ========================= -->
      <div class="col-md-6 d-flex mx-auto">
        <div class="container my-auto py-5">
          <div class="row g-0">
            <div class="col-10 col-lg-9 col-xl-8 mx-auto">
              <h3 class="fw-600 mb-4">Validate OTP</h3>
              <p class="text-muted mb-4">Please enter the OTP (one time password) to verify your account. A Code has been sent to <span class="text-dark"><?php echo $_GET['mobile'] ?></span></p>
              <div id="otp-screen" >
                <div class="row g-3">
                    <input type="hidden" id="emailorphone" value="<?php echo $_GET['mobile'] ?>">
                    <input type="hidden" id="idUser" value="<?php echo $_GET['idUser'] ?>">
                    <input type="text" id="otpField">
                  <div class="col">
                    <input type="text" name="otp[]" class="form-control text-center text-6 py-2" maxlength="1" required autocomplete="off">
                  </div>
                  <div class="col">
                    <input type="text" name="otp[]" class="form-control text-center text-6 py-2" maxlength="1" required autocomplete="off">
                  </div>
                  <div class="col">
                    <input type="text" name="otp[]" class="form-control text-center text-6 py-2" maxlength="1" required autocomplete="off">
                  </div>
                  <div class="col">
                    <input type="text" name="otp[]" class="form-control text-center text-6 py-2" maxlength="1" required autocomplete="off">
                  </div>
                </div>
                <div id="otpError" class="mt-2" style="color: red;"></div>
                <div class="d-grid my-4">
					<button class="btn btn-primary"  onclick="VerifyOtp()">Verify</button>
				</div>
</div>
              <p class="text-center text-muted mb-0">Not received your code? <a onclick="resendOtp()" disabled>Resend code</a></p>
            </div>
          </div>
        </div>
      </div>
      <!-- OTP Form End --> 

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
      <span onclick="sendOtp()" class="text-center text-primary mb-2" style="display: inline;">Resend OTP</span></div>
      
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



// OTP Form (Focusing on next input)
$("#otp-screen .form-control").keyup(function() {  
if (this.value.length == 0) {
   $(this).blur().parent().prev().children('.form-control').focus();
   $(this).blur().prev('.form-control').focus();
}
else if (this.value.length == this.maxLength) {
   $(this).blur().parent().next().children('.form-control').focus();
   $(this).blur().next('.form-control').focus();
}
});

document.addEventListener('deviceready', onDeviceReady, false);

function onDeviceReady() {
    // Request permission to read SMS messages
    cordova.plugins.permissions.requestPermission(cordova.plugins.permissions.READ_SMS, successCallback, errorCallback);
}

function successCallback(status) {
    if (status.hasPermission) {
        // Permission granted, now read SMS messages
        readSMS();
    } else {
        // Permission denied
        console.error('SMS permission is required.');
    }
}

function errorCallback(status) {
    console.error('Error requesting SMS permission: ' + status.error);
}

function readSMS() {
    // Use the cordova-plugin-sms-receive plugin to read SMS messages
    SmsReceive.startWatch(function(message) {
        // Parse the message content to extract the OTP (you may use regular expressions here)
        const otp = extractOTP(message);

        // Display the OTP in your app's interface
        if (otp) {
            document.getElementById('otpField').value = otp;
        }
    }, function() {
        console.error('Error starting SMS watch');
    });
}

function extractOTP(message) {
    // Use regular expressions or any other method to extract the OTP from the message
    // For example, you can search for a 6-digit number in the message
    const otpRegex = /\b\d{6}\b/;
    const match = message.match(otpRegex);

    if (match) {
        return match[0];
    }

    return null;
}

    </script>

</body>

</html>