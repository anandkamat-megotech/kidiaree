<?php
include('global/admin_global.php');
if(!empty($_GET['token']) && $_SESSION['token'] != $_GET['token']){$_SESSION['token'] = $_GET['token'];}
$token = $_SESSION['token'];

if(empty($_SESSION['token'])){
   header("Location: login.php"); exit;
}

// print_r($token);
// die;
$ch = curl_init();
   
curl_setopt($ch, CURLOPT_URL,$url_curl_kidiaree_admin."/main-file/get_user_profile.php");
$authorization = "Authorization: Bearer ".$token;
curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
$result = curl_exec($ch);
curl_close($ch);
   
$user_details =json_decode($result);
// print_r($user_details->body[0]->email);
$display_name = '';
if(!empty($user_details)){
    $display_name = strstr($user_details->body[0]->email, '@', true);

}

?>
<div class="header">
            <div class="header-left">
               <a href="index.php" class="logo">
               <img src="../assets/images/logo-white.png" alt="Logo">
               </a>
               <a href="index.html" class="logo logo-small">
               <img src="assets/img/logo-small.png" alt="Logo" width="30" height="30">
               </a>
            </div>
            <div class="menu-toggle">
               <a href="javascript:void(0);" id="toggle_btn">
               <i class="fas fa-bars"></i>
               </a>
            </div>
            <div class="top-nav-search">
               <form>
                  <input type="text" class="form-control" placeholder="Search here">
                  <button class="btn" type="submit"><i class="fas fa-search"></i></button>
               </form>
            </div>
            <a class="mobile_btn" id="mobile_btn">
            <i class="fas fa-bars"></i>
            </a>
            <ul class="nav user-menu">
               <li class="nav-item dropdown noti-dropdown language-drop me-2">
                  <a href="#" class="dropdown-toggle nav-link header-nav-list" data-bs-toggle="dropdown">
                  <img src="assets/img/icons/header-icon-01.svg" alt>
                  </a>
                  <div class="dropdown-menu ">
                     <div class="noti-content">
                        <div>
                           <a class="dropdown-item" href="javascript:;"><i class="flag flag-lr me-2"></i>English</a>
                           <a class="dropdown-item" href="javascript:;"><i class="flag flag-bl me-2"></i>Francais</a>
                           <a class="dropdown-item" href="javascript:;"><i class="flag flag-cn me-2"></i>Turkce</a>
                        </div>
                     </div>
                  </div>
               </li>
               <li class="nav-item zoom-screen me-2">
                  <a href="#" class="nav-link header-nav-list win-maximize">
                  <img src="assets/img/icons/header-icon-04.svg" alt>
                  </a>
               </li>
               <li class="nav-item dropdown has-arrow new-user-menus">
                  <a href="#" class="dropdown-toggle nav-link" data-bs-toggle="dropdown">
                     <span class="user-img">
                        <img class="rounded-circle" src="assets/img/profiles/avatar-01.jpg" width="31" alt="Ryan Taylor">
                        <div class="user-text">
                           <h6><?php echo $display_name ; ?></h6>
                           <p class="text-muted mb-0">Administrator</p>
                        </div>
                     </span>
                  </a>
                  <div class="dropdown-menu">
                     <div class="user-header">
                        <div class="avatar avatar-sm">
                           <img src="assets/img/profiles/avatar-01.jpg" alt="User Image" class="avatar-img rounded-circle">
                        </div>
                        <div class="user-text">
                           <h6><?php echo $display_name ; ?></h6>
                           <p class="text-muted mb-0">Administrator</p>
                        </div>
                     </div>
                     <a class="dropdown-item" href="logout.php">Logout</a>
                  </div>
               </li>
            </ul>
         </div>