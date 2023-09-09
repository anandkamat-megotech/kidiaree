<?php 
include('global.php');
if(!empty($_GET['token']) && $_SESSION['token'] != $_GET['token']){$_SESSION['token'] = $_GET['token'];}
$token = $_SESSION['token'];
if(empty($_SESSION['token'])){
   header("Location: login.php"); exit;
}


?>
<?php
   //
   // A very simple PHP example that sends a HTTP POST to a remote site
   //
   
   // print_r($token);
   $ch = curl_init();
   
   curl_setopt($ch, CURLOPT_URL,"https://kidiaree.softwareconnect.in/main-file/get_all_user_details.php");
   $authorization = "Authorization: Bearer ".$token;
   curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   // curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
   $result = curl_exec($ch);
   curl_close($ch);
//    print_r($result);
   $kids =json_decode($result);


   $ch = curl_init();
   
   curl_setopt($ch, CURLOPT_URL,"https://kidiaree.softwareconnect.in/main-file/get_user_profile_details.php");
   $authorization = "Authorization: Bearer ".$token;
   curl_setopt($ch, CURLOPT_HTTPHEADER, array($authorization ));
   curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   // curl_setopt($ch, CURLOPT_POSTFIELDS,$post);
   $resultProfile = curl_exec($ch);
   curl_close($ch);
//    print_r($result);
   $profile =json_decode($resultProfile);
   // print_r($profile->code);
   // print_r($profile->body);
   // Further processing ...
   // if ($server_output == "OK") { ... } else { ... }
   ?>
<?php include_once 'global.php'; ?>
<!doctype html>
<html class="no-js" lang="en">
   <head>
      <meta charset="utf-8">
      <meta http-equiv="x-ua-compatible" content="ie=edge">
      <title>kidiaree - Curated Classes & Activities for Children</title>
      <meta name="robots" content="noindex, follow" />
      <meta name="description" content="Curated Classes & Activities for Children">
      <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="assets/images/logo.png">
      <!-- CSS
         ============================================ -->
      <!-- Icon Font CSS -->
      <link rel="stylesheet" href="assets/css/plugins/all.min.css?v=0.23">
      <link rel="stylesheet" href="assets/css/plugins/flaticon.css?v=0.23">
      <!-- Plugins CSS -->
      <link rel="stylesheet" href="assets/css/plugins/bootstrap.min.css?v=0.23">
      <link rel="stylesheet" href="assets/css/plugins/swiper-bundle.min.css?v=0.23">
      <link rel="stylesheet" href="assets/css/plugins/aos.css?v=0.23">
      <link rel="stylesheet" href="assets/css/plugins/nice-select.css?v=0.23">
      <link rel="stylesheet" href="assets/css/plugins/jquery.powertip.min.css?v=0.23">
      <link rel="stylesheet" href="assets/css/plugins/magnific-popup.css?v=0.23">
      <!-- Main Style CSS -->
      <link rel="stylesheet" href="assets/css/style.css?v=0.23">
      <link rel="stylesheet" href="assets/css/kidiaree.css?v=0.23">
   </head>
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
                  <div class="horizontal-header clearfix d-lg-none">
                     <div class="container">
                        <a id="horizontal-navtoggle" class="animated-arrow">
                           <span>
                              <div class="header-toggle d-lg-none">
                                 <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu2">
                                 <span></span>
                                 <span></span>
                                 <span></span>
                                 </button>
                              </div>
                           </span>
                        </a>
                        <span class="smllogo d-lg-none"><a href="index.php"><img src="assets/images/logo.png" width="120" alt="img"></a></span><a  class="callusbtn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"><i class="flaticon-user-2" aria-hidden="true"></i></a> 
                     </div>
                  </div>
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
                              <li><a href="#">List a Class or Activity</a></li>
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
                        <div class="header-cart dropdown  d-none">
                           <button class="cart-btn" data-bs-toggle="dropdown">
                           <i class="flaticon-shopping-cart"></i>
                           <span class="count">3</span>
                           </button>
                           <div class="dropdown-menu dropdown-cart">
                              <!-- Cart Items Start -->
                              <div class="cart-items">
                                 <!-- Single Cart Item Start -->
                                 <div class="single-cart-item">
                                    <div class="item-image">
                                       <img src="assets/images/shop-cart-1.jpg" alt="Cart">
                                    </div>
                                    <div class="item-content">
                                       <h4 class="title"><a href="#">Smart Gear Watch</a></h4>
                                       <span class="quantity"> 2 x $59.99 </span>
                                    </div>
                                    <button class="btn-close"></button>
                                 </div>
                                 <!-- Single Cart Item End -->
                                 <!-- Single Cart Item Start -->
                                 <div class="single-cart-item">
                                    <div class="item-image">
                                       <img src="assets/images/shop-cart-2.jpg" alt="Cart">
                                    </div>
                                    <div class="item-content">
                                       <h4 class="title"><a href="#">Smart Gear Watch</a></h4>
                                       <span class="quantity"> 2 x $59.99 </span>
                                    </div>
                                    <button class="btn-close"></button>
                                 </div>
                                 <!-- Single Cart Item End -->
                                 <!-- Single Cart Item Start -->
                                 <div class="single-cart-item">
                                    <div class="item-image">
                                       <img src="assets/images/shop-cart-3.jpg" alt="Cart">
                                    </div>
                                    <div class="item-content">
                                       <h4 class="title"><a href="#">Smart Gear Watch</a></h4>
                                       <span class="quantity"> 2 x $59.99 </span>
                                    </div>
                                    <button class="btn-close"></button>
                                 </div>
                                 <!-- Single Cart Item End -->
                              </div>
                              <!-- Cart Items End -->
                              <!-- Cart Total Start -->
                              <div class="cart-total">
                                 <span class="label">Subtotal:</span>
                                 <span class="value">$229.95</span>
                              </div>
                              <!-- Cart Total End -->
                              <!-- Cart Button Start -->
                              <div class="cart-btns">
                                 <a href="#" class="btn">View Cart</a>
                                 <a href="#" class="btn btn-white">Checkout</a>
                              </div>
                              <!-- Cart Button End -->
                           </div>
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
                     <li><a href="#">List a Class or Activity</a></li>
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
                  <a href="#"><img src="assets/images/logo-white.png" alt=""></a>
               </div>
               <!-- Offcanvas Logo End -->
               <button type="button" class="close-btn" data-bs-dismiss="offcanvas"><i class="flaticon-close"></i></button>
            </div>
            <div class="offcanvas-body">
               <div class="offcanvas-menu">
                  <ul class="main-menu">
                  <li><a href="#"><b class="color1-k ">Kid</b> details</a>
                            <ul class="sub-menu">
                                <li><a href="add_kids.php">Add new child</a></li>
                            </ul>
                        </li>
                     <li><a href="#">Upcoming Classes & Activities</a></li>
                     <li><a href="#">My Bookings</a></li>
                     <li><a href="#">My Favorites</a></li>
                     <li><a href="#">Profile Settings</a></li>
                     <li><a href="logout.php">Logout</a></li>
                  </ul>
               </div>
            </div>
         </div>
         <!-- Offcanvas End -->
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
                           <h2 class="title">Profile</h2>
                           <ul class="breadcrumb justify-content-center">
                              <li class="breadcrumb-item"><a href="#">Home</a></li>
                              <li class="breadcrumb-item active" aria-current="page">Profile </li>
                           </ul>
                        </div>
                        <!-- Page Banner Content End -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
         <!-- Page Banner End -->
         <!-- Course Details Start -->
         <div class="section section-padding">
            <div class="container">
               <div class="row justify-content-between">
                  <div class="col-xl-7 col-lg-8 mx-auto">
                     <!-- Course Details Wrapper Start -->
                     <div class="course-details-wrapper">
                        <!-- Course Lessons Start -->
                        <div class="course-lessons">
                           <div class="lessons-top">
                              <h3 class="title">Settings</h3>
                              <div class="lessons-time">
                                 <button class="btn btn-primary btn-sm-add-student" href="#" data-bs-toggle="modal" data-bs-target="#kidsModal">  Add New Child</button> 
                              </div>
                           </div>
                           <!-- Course Accordion Start -->
                           <div class="course-accordion accordion" id="accordionCourse">
                              <div class="accordion-item">
                                 <button data-bs-toggle="collapse" data-bs-target="#collapseOne">Kids Details </button>
                                 <div id="collapseOne" class="accordion-collapse collapse show" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body table-responsive">
                                       <table class="table table-striped">
                                          <thead>
                                             <tr>
                                                <!-- <th scope="col">#</th> -->
                                                <th scope="col">Name</th>
                                                <th scope="col">D.O.B (Age)</th>
                                                <th scope="col">Action</th>
                                             </tr>
                                          </thead>
                                          <tbody>
                                             <?php foreach($kids->body as $value){   $year = (date('Y') - date('Y',strtotime($value->dob))); ?>
                                             <tr>
                                                <!-- <th scope="row"><?php echo $value->id ?></th> -->
                                                <td><?php echo $value->kid_name ?></td>
                                                <td><?php echo  $newDate = date("d/m/Y", strtotime( $value->dob)); ?> (<?php echo $year; ?> yrs)</td>
                                                <td><i class="fa fa-user-edit icon-style" onclick="getKidsDashboard('<?php echo $value->id ?>')"></i><i class="fa fa-trash icon-style"></i> </td>
                                             </tr>
                                             <?php } ?>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseTwo">Upcoming Classes & Activities</button>
                                 <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body">
                                       <div class="accordion-body table-responsive">
                                          <table class="table table-striped mt-3">
                                             <tbody>
                                                <tr>
                                                   <th scope="row">1</th>
                                                   <td>Class One</td>
                                                   <td>Today 10:00pm</td>
                                                   <td><i class="fa fa-user-edit icon-style"></i><i class="fa fa-trash icon-style"></i> </td>
                                                </tr>
                                                <tr>
                                                   <th scope="row">2</th>
                                                   <td>Class two</td>
                                                   <td>Tomorrow 02:00pm</td>
                                                   <td><i class="fa fa-user-edit icon-style"></i><i class="fa fa-trash icon-style"></i> </td>
                                                </tr>
                                                <tr>
                                             </tbody>
                                          </table>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseThree">My Bookings</button>
                                 <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body">
                                    <div class="order-date">Booked on : 12 July 2023, 12:45:00 pm</div>
                                    <div class="single-course-list single-course" style="border-radius: 10px;border:1px solid #ddd;display:inline-block !important;border-style: dashed;">
                                            <div class="course-image width-thumb">
                                                <a href="course-details.html"><img src="assets/images/two_z.jpg" alt="Courses"></a>
                                            </div>
                                            <div class="courses-content width-content" style="padding-top: 0px !important;">
                                                <h3 class="title" style="margin-top: 0px !important;"><a href="creative_writing_lab_single.php" style="font-size: 14px !important;">Creative Writing Lab 4</a></h3>

                                                <div class="top-meta">
                                                      <span class="price">
                                                      <span class="sale-price" style="font-size: 12px !important;">INR 6000</span>
                                                      </span>
                                                </div>
                                                <ul class="description-list">
                                                   <li><i class="flaticon-location-pin creative-page-icons"></i> Online</li>
                                                   <li><i class="far fa-calendar-alt creative-page-icons"></i> 16-20 Jul, 2023 </li>
                                                   <li><i class="fa fa-stopwatch creative-page-icons"></i> 60 mins per session</li>
                                                </ul>
                                             </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFour">My Favorites </button>
                                 <div id="collapseFour" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body table-responsive">
                                       <table class="table table-striped mt-3">
                                          <tbody>
                                             <tr>
                                                <th scope="row">1</th>
                                                <td>Creative class lab</td>
                                                <td><i class="fa fa-trash icon-style"></i> </td>
                                             </tr>
                                             <tr>
                                                <th scope="row">2</th>
                                                <td>The Drum</td>
                                                <td><i class="fa fa-trash icon-style"></i> </td>
                                             </tr>
                                             <tr>
                                          </tbody>
                                       </table>
                                    </div>
                                 </div>
                              </div>
                              <div class="accordion-item">
                                 <button class="collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFive">Profile Settings </button>
                                 <div id="collapseFive" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                    <div class="accordion-body mt-2">
                                       <ul class="lessons-list">
                                          <li><a href=""><i class="fa fa-user"></i> <?php echo strtok($profile->body[0]->email, '@') ?> <span><i class="fa fa-user-edit icon-style"></i></span></a></li>
                                          <li><a href=""><i class="fa fa-blender-phone"></i> <?php echo $profile->body[0]->mobile; ?> <span><i class="fa fa-user-edit icon-style"></i></span></a></li>
                                          <li><a href=""><i class="fa fa-envelope"></i> <?php echo $profile->body[0]->email; ?><span><i class="fa fa-user-edit icon-style"></i></span></a></li>
                                          <li><a href=""><i class="fa fa-map-marker"></i> <?php echo $profile->body[0]->addressLine2; ?> <span><i class="fa fa-user-edit icon-style"></i></span></a></li>
                                       </ul>
                                    </div>
                                 </div>
                              </div>
                           </div>
                           <!-- Course Accordion End -->
                           <!-- Modal -->
                           <div class="modal fade" id="kidsModal" tabindex="-1" aria-labelledby="kidsModalLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="kidsModalLabel">Kid Details</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <!-- Contact Form Wrap Start -->
                                       <div class="contact-form-wrap">
                                          <form action="#">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="single-form">
                                                      <label for="">Name</label>
                                                      <input class="form-control" type="text" id="k_name" name="k_name" placeholder="e.g Amit Singh">
                                                   </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="single-form">
                                                      <label for="">Select Date of birth</label>
                                                      <input class="form-control" type="date"  placeholder="Dob" id="k_dob_start">
                                                   </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="radio-button m-3">
                                                        <input type="radio" id="gender" name="gender" value="Male" checked />
                                                        <label for="huey">Male</label>
                                                        <input type="radio" id="gender" style="margin-left: 10px;" name="gender" value="Female" />
                                                        <label for="Female">Female</label>
                                                    </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <select class="mt-3 mb-3 w-100" name="grade" id="grade">
                                                        <option>Pre-school</option>
                                                        <option>Nursery</option>
                                                        <option>Junior KG</option>
                                                        <option>Senior KG</option>
                                                        <option>Grade 1</option>
                                                        <option>Grade 2</option>
                                                        <option>Grade 3</option>
                                                        <option>Grade 4</option>
                                                        <option>Grade 5</option>
                                                        <option>Grade 6</option>
                                                        <option>Grade 7</option>
                                                        <option>Grade 8</option>
                                                        <option>Grade 9</option>
                                                        <option>Grade 10</option>
                                                    </select>
                                                   <!-- Single Form End -->
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <!-- Contact Form Wrap End -->
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                       <button type="button" class="btn btn-primary" onclick="saveKidsDashboardAdd('none')">Save</button>
                                    </div>
                                 </div>
                              </div>
                           </div>

                           <!-- Modal -->
                           <div class="modal fade" id="kidsModalEdit" tabindex="-1" aria-labelledby="kidsModalEditLabel" aria-hidden="true">
                              <div class="modal-dialog">
                                 <div class="modal-content">
                                    <div class="modal-header">
                                       <h5 class="modal-title" id="kidsModalEditLabel">Kid Details</h5>
                                       <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                       <!-- Contact Form Wrap Start -->
                                       <div class="contact-form-wrap">
                                          <form action="#">
                                             <div class="row">
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="single-form">
                                                      <label for="">Name</label>
                                                      <input class="form-control" type="hidden" id="k_id" name="k_id" >
                                                      <input class="form-control" type="text" id="k_name_edit" name="k_name" placeholder="e.g Amit Singh">
                                                   </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="single-form">
                                                      <label for="">Select Date of birth</label>
                                                      <input class="form-control" type="date"  placeholder="Dob" id="k_dob_start_edit">
                                                   </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <div class="radio-button m-3">
                                                        <input type="radio" id="gender_Male" name="gender" value="Male" checked />
                                                        <label for="huey">Male</label>
                                                        <input type="radio" id="gender_Female" style="margin-left: 10px;" name="gender" value="Female" />
                                                        <label for="Female">Female</label>
                                                    </div>
                                                   <!-- Single Form End -->
                                                </div>
                                                <div class="col-md-6">
                                                   <!-- Single Form Start -->
                                                   <select class="mt-3 mb-3 w-100" name="grade" id="grade_edit">
                                                        <option>Pre-school</option>
                                                        <option>Nursery</option>
                                                        <option>Junior KG</option>
                                                        <option>Senior KG</option>
                                                        <option>Grade 1</option>
                                                        <option>Grade 2</option>
                                                        <option>Grade 3</option>
                                                        <option>Grade 4</option>
                                                        <option>Grade 5</option>
                                                        <option>Grade 6</option>
                                                        <option>Grade 7</option>
                                                        <option>Grade 8</option>
                                                        <option>Grade 9</option>
                                                        <option>Grade 10</option>
                                                    </select>
                                                   <!-- Single Form End -->
                                                </div>
                                             </div>
                                          </form>
                                       </div>
                                       <!-- Contact Form Wrap End -->
                                    </div>
                                    <div class="modal-footer">
                                       <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                       <button type="button" class="btn btn-primary" onclick="saveKidsDashboard('none')">Save</button>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <!-- Course Lessons End -->
                     </div>
                     <!-- Course Details Wrapper End -->
                  </div>
               </div>
            </div>
         </div>
         <!-- Course Details End -->
         <!-- Footer Start -->
         <div class="footer-section section mt-5">
            <div class="container">
               <!-- Footer Widget Wrapper Start -->
               <div class="footer-widget-wrap">
                  <div class="row">
                     <div class="col-lg-3 col-sm-6">
                        <!-- Footer Widget Start -->
                        <div class="footer-widget widget-about">
                           <div class="footer-logo">
                              <a href="#"><img src="assets/images/logo-white.png" alt=""></a>
                           </div>
                           <p class="text">Curated Classes & Activities for Children</p>
                           <div class="widget-info">
                              <div class="info-icon">
                                 <i class="flaticon-phone-call"></i>
                              </div>
                              <div class="info-text">
                                 <p class="call-text">Call Us</p>
                                 <a href="tel:+917045715869">+91 7045715869</a>
                              </div>
                           </div>
                        </div>
                        <!-- Footer Widget End -->
                     </div>
                     <div class="col-lg-3 col-sm-6">
                        <!-- Footer Widget Start -->
                        <div class="footer-widget">
                           <h4 class="footer-widget-title">Trending Courses</h4>
                           <div class="widget-link">
                              <ul class="link">
                                 <li><a href="#">Courses 1 </a></li>
                                 <li><a href="#">Courses 2</a></li>
                                 <li><a href="#">Courses 3</a></li>
                              </ul>
                           </div>
                        </div>
                        <!-- Footer Widget End -->
                     </div>
                     <div class="col-lg-3 col-sm-6">
                        <!-- Footer Widget Start -->
                        <div class="footer-widget">
                           <h4 class="footer-widget-title">Quick Links</h4>
                           <div class="widget-link">
                              <ul class="link">
                                 <li><a href="#">Free eBooks & checklists</a></li>
                                 <li><a href="#">Free eBooks & checklists</a></li>
                                 <li><a href="#">Free eBooks & checklists</a></li>
                              </ul>
                           </div>
                        </div>
                        <!-- Footer Widget End -->
                     </div>
                     <div class="col-lg-3 col-sm-6">
                        <!-- Footer Widget Start -->
                        <div class="footer-widget">
                           <h4 class="footer-widget-title">Events</h4>
                           <div class="widget-link">
                              <ul class="link">
                                 <li><a href="#">Events 1</a></li>
                                 <li><a href="#">Events 2</a></li>
                                 <li><a href="#">Events 3</a></li>
                              </ul>
                           </div>
                        </div>
                        <!-- Footer Widget End -->
                     </div>
                  </div>
               </div>
               <!-- Footer Widget Wrapper End -->
               <!-- Footer Copyright Start -->
               <div class="footer-copyright">
                  <div class="copyright-wrapper">
                     <div class="row align-items-center">
                        <div class="col-lg-6 col-md-6">
                           <!-- Footer Copyright Text Start -->
                           <div class="copyright-text">
                              <p>© Copyright 2023 Playfluent Eduventures LLP. All rights reserved. </p>
                           </div>
                           <!-- Footer Copyright Text End -->
                        </div>
                        <div class="col-lg-6 col-md-6">
                           <!-- Footer Copyright Social Start -->
                           <div class="copyright-social">
                              <ul class="social">
                                 <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                 <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                 <li><a href="#"><i class="fab fa-linkedin-in"></i></a></li>
                              </ul>
                           </div>
                           <!-- Footer Copyright Social End -->
                        </div>
                     </div>
                  </div>
               </div>
               <!-- Footer Copyright End -->
            </div>
         </div>
         <!-- Footer End -->
         <!-- back to top start -->
         <div class="progress-wrap">
            <svg class="progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
               <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98" />
            </svg>
         </div>
         <!-- back to top end -->
      </div>
      <!-- JS
         ============================================ -->
      <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
      <script src="assets/js/vendor/modernizr-3.11.2.min.js"></script>
      <!-- Bootstrap JS -->
      <script src="assets/js/plugins/popper.min.js"></script>
      <script src="assets/js/plugins/bootstrap.min.js"></script>
      <!-- Plugins JS -->
      <script src="assets/js/plugins/swiper-bundle.min.js"></script>
      <script src="assets/js/plugins/aos.js"></script>
      <script src="assets/js/plugins/waypoints.min.js"></script>
      <script src="assets/js/plugins/jquery.counterup.min.js"></script>
      <script src="assets/js/plugins/jquery.nice-select.min.js"></script>
      <script src="assets/js/plugins/back-to-top.js"></script>
      <script src="assets/js/plugins/jquery.powertip.min.js"></script>
      <script src="assets/js/plugins/jquery.magnific-popup.min.js"></script>
      <!--====== Use the minified version files listed below for better performance and remove the files listed above ======-->
      <!-- Main JS -->
      <script src="assets/js/main.js?v=0.23"></script>
      <script>
        
$(document).ready(function() {
  // executes when HTML-Document is loaded and DOM is ready
  var date = new Date();
  console.log(date);
  var dd = date.getDate();
  var mm = date.getMonth() + 1;
  var yyyy = date.getFullYear();

  //Add a zero if one Digit (eg: 05,09)
  if (dd < 10) {
    dd = "0" + dd;
  }

  //Add a zero if one Digit (eg: 05,09)
  if (mm < 10) {
    mm = "0" + mm;
  }

  minYear = yyyy - 18; //Calculate Minimun Age (<80)
  maxYear = yyyy - 1; //Calculate Maximum Age (>18)

  var min = minYear + "-" + mm + "-" + dd;
  var max = maxYear + "-" + mm + "-" + dd;
  console.log(min);
  console.log(max);

  document.getElementById("k_dob_start").setAttribute("min", min);
  document.getElementById("k_dob_start").setAttribute("max", max);
  document.getElementById("k_dob_start_edit").setAttribute("min", min);
  document.getElementById("k_dob_start_edit").setAttribute("max", max);
 });
 

    </script>
   </body>
</html>