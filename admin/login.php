<!DOCTYPE html>
<html lang="en">
    <?php
session_start();
if(!empty($_SESSION['token'])){
     header("Location: index.php"); exit;
}

?>
   <?php include('inc/head.php') ?>
   <body>
      
<div class="main-wrapper login-body">
<div class="login-wrapper">
<div class="container">
<div class="loginbox">
<div class="login-left">
<img class="img-fluid" src="assets/img/login.png" alt="Logo">
</div>
<div class="login-right">
<div class="login-right-wrap">
<h1>Welcome to Kidiaree</h1>
<h2>Sign in</h2>

<!-- <form action="index.html"> -->
<div class="form-group">
<label>Username <span class="login-danger">*</span></label>
<input class="form-control" type="text" id="number" name="number">
<span class="profile-views"><i class="fas fa-user-circle"></i></span>
</div>
<div class="form-group">
<label>Password <span class="login-danger">*</span></label>
<input class="form-control pass-input" type="text" id="password" name="password">
<span class="profile-views feather-eye toggle-password"></span>
<div id="validationError" class="mt-2" style="color: red;"></div>
</div>
<div class="forgotpass">
<div class="remember-me">
<label class="custom_check mr-2 mb-0 d-inline-flex remember-me"> Remember me
<input type="checkbox" name="radio">
<span class="checkmark"></span>
</label>
</div>
<a href="#">Forgot Password?</a>
</div>
<div class="form-group">
<button class="btn btn-primary btn-block"  onclick="VerifyUser()">Login</button>
</div>
<!-- </form> -->

<div class="login-or">
<span class="or-line"></span>
<span class="span-or">or</span>
</div>

<div class="social-login">
<a href="#"><i class="fab fa-google-plus-g"></i></a>
<a href="#"><i class="fab fa-facebook-f"></i></a>
<a href="#"><i class="fab fa-twitter"></i></a>
<a href="#"><i class="fab fa-linkedin-in"></i></a>
</div>

</div>
</div>
</div>
</div>
</div>
</div>
      <?php include('inc/scripts.php'); ?>
   </body>
</html>