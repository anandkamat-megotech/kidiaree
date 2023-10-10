<!DOCTYPE html>
<html lang="en">
    <?php


?>
   <?php include('inc/head.php') ?>
   <body>
    <style>.login-wrapper .loginbox .login-right h1 {
    font-size: 22px;
    color: #379F75;
}</style>
      
<div class="main-wrapper login-body">
<div class="login-wrapper">
<div class="container">
<div class="loginbox">
<div class="login-left">
<img class="img-fluid" src="assets/img/login.png" alt="Logo">
</div>
<div class="login-right">
<div class="login-right-wrap">
<h1 class="text-center">Welcome to Kidiaree</h1>
<h2 class="mt-5">Change password</h2>

<!-- <form action="index.html"> -->
<div class="form-group">
<label>Password <span class="login-danger">*</span></label>
<input  type="hidden" id="number" name="number" value="<?php echo $_GET['username']?>">
<input class="form-control pass-input" type="password" id="password" name="password">

<span class="profile-views feather-eye-off toggle-password"></span>

</div>
<div class="form-group">
<label>Confirm Password<span class="login-danger">*</span></label>
<input class="form-control" type="text" id="re_password" name="re_password">

<!-- <span class="profile-views feather-eye toggle-password"></span> -->

</div>
<div id="validationError" class="mb-3" style="color: red;
    margin-top: -14px;
    text-align: center;"></div>
<div class="form-group">
<button class="btn btn-primary btn-block mt-3"  onclick="changePassword()">Change</button>
</div>
<!-- </form> -->



</div>
</div>
</div>
</div>
</div>
</div>
      <?php include('inc/scripts.php'); ?>
   </body>
   <script>
 
   </script>
</html>