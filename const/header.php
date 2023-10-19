 <?php 
//  include('global.php');
$uriSegments = explode("/", parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));
$lastUriSegment = array_pop($uriSegments);
if($_SESSION['under_c'] != '1234@kidiaree'){
    header("Location: enter_password.php?action=$lastUriSegment"); exit;
}
if(!empty($_SESSION['token'])){
    // $_SESSION['token'] = $_GET['token'];
    $token = $_SESSION['token'];
    $ch = curl_init();
      
    curl_setopt($ch, CURLOPT_URL,$url_curl_kidiaree."/main-file/get_user_profile_details.php");
    $authorization = "Authorization: Bearer ".$token;
    curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
    $resultProfile_header = curl_exec($ch);
    curl_close($ch);
      
    $profile =json_decode($resultProfile_header);
    // print_r($profile->body[0]->idRole);
 }
 

 ?>
 <!-- Header Start  -->
 <div class="section header">
            <div class="header-top-section">
                <div class="container">
                    <div class="header-top-wrap">
                        <div class="header-top-content text-center">
                            <p>Curated Classes & Activities for Children <span>Kidiaree</span></p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="header-bottom-section">

                <div class="container-fluid custom-container">

                <div class="horizontal-header clearfix d-lg-none"> <div class="container"> <a id="horizontal-navtoggle" class="animated-arrow"><span><div class="header-toggle d-lg-none">
                                <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu2">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                            </div></span></a> <span class="smllogo d-lg-none"><a href="index.php"><img src="assets/images/logo.png" width="120" alt="img"></a></span><a  class="callusbtn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"><?php if(!empty($_SESSION['token']) && !empty($profile) && $profile->body[0]->step_number == 2){  ?>
                                    <p > <?php echo explode(' ', $profile->body[0]->name)[0]; ?><i class="flaticon-user-2" style="margin-left: 2px;" aria-hidden="true"></i></p>
                                    <?php }else{ ?>
                                        <i class="flaticon-user-2"></i>
                                    <?php } ?></a> </div> </div>
                    <div class="header-bottom-wrap">

                        <div class="header-logo-menu">

                            <!--  Header Logo Start  -->
                            <div class="header-logo d-none d-lg-inline">
                                <a href="index.php"><img src="assets/images/logo.png" alt="logo"></a>
                            </div>
                            <!--  Header Logo End  -->

                            <!--  Header Menu Start  -->
                            <div class="header-menu d-none d-lg-block">
                                <ul class="main-menu">
                                    <li><a href="#">About Us</a></li>
                                    <li><a href="#">Classes & Activities</a></li>
                                    <li><a href="list_class_enquiry.php">List a Class or Activity</a></li>
                                    <li><a href="#">Testimonials</a></li>
                                    <li><a href="#">Reach Us</a></li>
                                </ul>
                            </div>
                            <!--  Header Menu End  -->

                        </div>


                        <!-- Header Meta Start -->
                        <div class="header-meta">
                            <!-- <div class="header-search d-none d-xl-block">
                                <form action="#">
                                    <input type="text" placeholder="Enter your Pincode" id="zipcode">
                                    <button><i class="flaticon-location-pin"></i></button>
                                </form>
                            </div> -->

                            

                            <div class="header-cart dropdown desktop-only">
                                <button class="cart-btn" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu">
                                <?php if(!empty($_SESSION['token']) && !empty($profile) && $profile->body[0]->step_number == 2){  ?>
                                    <p > <?php echo explode(' ', $profile->body[0]->name)[0]; ?><i class="flaticon-user-2" style="margin-left: 2px;" aria-hidden="true"></i></p>
                                    <?php }else{ ?>
                                        <i class="flaticon-user-2"></i>
                                    <?php } ?>
                                   
                                    <!-- <span class="count">3</span> -->
                                </button>
                            </div>

                           

                        </div>
                        <!-- Header Meta End -->

                    </div>
                </div>


            </div>
        </div>
        <!-- Header End -->


        <!-- Offcanvas Start -->
        <div class="offcanvas offcanvas-start" id="offcanvasMenu2">

            <div class="offcanvas-header">
                <!-- Offcanvas Logo Start -->
                <div class="offcanvas-logo">
                    <a href="#"><img src="assets/images/logo-white.png" alt=""></a>
                </div>
                <!-- Offcanvas Logo End -->

                <button type="button" class="close-btn" data-bs-dismiss="offcanvas"><i class="flaticon-close"></i></button>

            </div>
            <div class="offcanvas-body">
                <div class="offcanvas-menu">
                    <ul class="main-menu">
                        <li><a href="#">About Us</a></li>
                        <li><a href="#">Classes & Activities</a></li>
                        <li><a href="list_class_enquiry.php">List a Class or Activity</a></li>
                        <li><a href="#">Testimonials</a></li>
                        <li><a href="#">Reach Us</a></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Offcanvas End -->


        
        <!-- Offcanvas Start 2 -->
        <div class="offcanvas offcanvas-end" id="offcanvasMenu">

            <div class="offcanvas-header">
                <!-- Offcanvas Logo Start -->
                <div class="offcanvas-logo">
                <?php if(!empty($_SESSION['token']) && !empty($profile) && $profile->body[0]->step_number == 2){  ?>
                    <h4 class="header-user">Welcome <?php echo explode(' ', $profile->body[0]->name)[0]; ?></h4>
                    <?php }else{ ?>
                    <a href="#"><img src="assets/images/logo-white.png" alt=""></a>
                    <?php } ?>
                </div>
                <!-- Offcanvas Logo End -->

                <button type="button" class="close-btn" data-bs-dismiss="offcanvas"><i class="flaticon-close"></i></button>

            </div>
            <div class="offcanvas-body">
                <div class="offcanvas-menu">
                    <ul class="main-menu">
                        <?php if(!empty($_SESSION['token']) && !empty($profile)){  ?>
                        <?php if($profile->body[0]->step_number == 2) { ?>
                    <?php if(!empty($profile->body[0]->parents_teacher)){ ?>
                    <li><a href="<?php if($profile->body[0]->idRole == 3){ echo 'teacher_dashboard.php';}else{ echo'dashboard.php';} ?>?tab=KD"><b class="color1-k ">Kid</b> details</a>
                            <ul class="sub-menu">
                                <li><a href="<?php if($profile->body[0]->idRole == 3){ echo 'teacher_dashboard.php';}else{ echo'dashboard.php';} ?>?tab=KD">Add new child</a></li>
                            </ul>
                        </li>
                        <?php } ?>
                        <li><a href="<?php if($profile->body[0]->idRole == 3){ echo 'teacher_dashboard.php';}else{ echo'dashboard.php';} ?>?tab=UCA">Upcoming Classes & Activities</a></li>
                        <li><a href="<?php if($profile->body[0]->idRole == 3){ echo 'teacher_dashboard.php';}else{ echo'dashboard.php';} ?>?tab=MB">My Bookings</a></li>
                        <li><a href="<?php if($profile->body[0]->idRole == 3){ echo 'teacher_dashboard.php';}else{ echo'dashboard.php';} ?>?tab=MF">My Favorites</a></li>
                        <li><a href="<?php if($profile->body[0]->idRole == 3){ echo 'teacher_dashboard.php';}else{ echo'dashboard.php';} ?>?tab=PS">Profile Settings</a></li>
                        <?php } elseif($profile->body[0]->step_number == 0) {?>
                            <li><a href="add_kid.php?token=<?php echo $_SESSION['token']?>">Add Kid</a></li>
                        <?php } elseif($profile->body[0]->step_number == 1) {?>
                            <li><a href="add_address.php?token=<?php echo $_SESSION['token']?>">Add Address</a></li>
                        <?php } }?>
                        <li><?php if(!empty($_SESSION['token'])){ ?><a href="logout.php">Logout</a> <?php } else { ?> <a href="myaccount.php">Login / Sign Up</a><?php } ?></li>
                        <!-- <li><?php if(!empty($_SESSION['token'])){ ?> <?php } else { ?> <a href="teacher_login.php">Teacher Login / Sign Up</a><?php } ?></li> -->
                    </ul>
                </div>
            </div>
        </div>
        <!-- Offcanvas End -->

        <div class="loader">
            <div class="loading">
            </div>
        </div>