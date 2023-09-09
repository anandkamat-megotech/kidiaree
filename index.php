
<?php include_once 'dbConfig.php';
$where = '';
// Get member rows
$getClass = $db->query("SELECT * FROM products  order by id desc");
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
    <link rel="manifest" href="manifest.json">

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
    <link href="owl-carousel/owl.carousel.css" rel="stylesheet">
    <link href="owl-carousel/owl.theme.css" rel="stylesheet">
    <!-- Main Style CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/css-toggle-switch/latest/toggle-switch.css" rel="stylesheet" /> -->

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

                <div class="horizontal-header clearfix d-lg-none"> <div class="container"> <a id="horizontal-navtoggle" class="animated-arrow"><span><div class="header-toggle d-lg-none">
                                <button data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu2">
                                    <span></span>
                                    <span></span>
                                    <span></span>
                                </button>
                            </div></span></a> <span class="smllogo d-lg-none"><a href="index.php"><img src="assets/images/logo.png" width="120" alt="img"></a></span><a  class="callusbtn d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu"><i class="flaticon-user-2" aria-hidden="true"></i></a> </div> </div>
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
                        <li><?php if(!empty($_SESSION['token'])){ ?><a href="logout.php">Logout</a> <?php } else { ?> <a href="myaccount.php">Login</a><?php } ?></li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- Offcanvas End -->


        <!-- Hero Start -->
        <div class="kidiaree-hero-section section" style="background-image: url(assets/images/bg/hero-bg.jpg);">
            <div class="shape-3">
                <img src="assets/images/shape/shape-1.png" alt="">
            </div>
            <div class="shape-4"></div>
            <div class="shape-5">
                <img src="assets/images/shape/hero-shape2.png" alt="">
            </div>
            <div class="svg-shape">
                <svg width="100%" height="100%" id="svg" viewBox="0 0 1440 390">
                    <path d="M 0,400 C 0,400 0,200 0,200 C 247.5,166.5 495,133 735,133 C 975,133 1207.5,166.5 1440,200 C 1440,200 1440,400 1440,400 Z" stroke="none" stroke-width="0" fill-opacity="1"></path>
                </svg>
            </div>
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <!-- Hero Content Start -->
                        <div class="hero-content">
                            <p class="text" data-aos="fade-up" data-aos-delay="800"><img src="assets/images/energy.png" alt=""> Select from the widest range</p>
                            <h2 class="title" data-aos="fade-up" data-aos-delay="700"><span>Curated </span> Classes  & Activities for kids</h2>
                            <h2 class="sub-titlesub-title-new new-sub-title" data-aos="fade-up" data-aos-delay="700">Start a quick and easy search</h2>
                            <div class="header-search mt-3">
                                <form action="#" id="form-location">
                                    <p class="tooltiptext d-none" id="pop-location_yes">Would you like to search for this pincode? <span class="badge badge-yes ml-3" style="margin-left:5px;" onclick= "noClick('pop-location_yes')">Yes</span><span class="badge badge-no" style="margin-left:5px;"  onclick= "clearInput('pop-location_yes')">No</span></p>
                                    <input type="text" placeholder="Enter your Pincode" id="zipcode" style="width: 100%;">
                                    <button><i class="flaticon-location-pin"></i></button>
                                </form>
                            </div>

                            
                            <div class="switch-toggle switch-3 switch-candy mt-3" style="width: 70%;">
                                    <input id="online" name="mode" value="online" type="radio"/>
                                    <label for="online" onclick="mychecked('online')">Online</label>

                                    <input id="both" name="mode" type="radio"  value="both" />
                                    <label for="both" class="disabled" onclick="mychecked('both')">Both</label>

                                    <input id="offline" name="mode" type="radio"  value="offline"/>
                                    <label for="offline" onclick="mychecked('offline')">Offline </label>

                                    <a></a>
                            </div>
                            
                            <div class="header-search mt-3">
                                <form autocomplete="off" method="GET" action="search_result.php">
                                <select class="selectpicker" name="age">
                                    <option value="">Age</option>
                                    <option>1</option>
                                    <option>2</option>
                                    <option>3</option>
                                    <option>4</option>
                                    <option>5</option>
                                    <option>6</option>
                                    <option>7</option>
                                    <option>8</option>
                                    <option>9</option>
                                    <option>10</option>
                                    <option>11</option>
                                    <option>12</option>
                                    <option>13</option>
                                    <option>14</option>
                                    <option>15</option>
                                    <option>16</option>
                                    <option>18</option>
                                </select>
                                    <div class="autocomplete d-inline">
                                        <input id="type" type="hidden" name="type" value="online">
                                        <input id="myInput" type="text" name="tags" placeholder="What class/activity are you looking for?">
                                        <!-- <button style="top: -10px;"><i class="flaticon-loupe"></i></button> -->
                                    </div>
                                    <button class="btn btn-small btn-search-new"><i class="flaticon-loupe" style="color:#fff !important;"></i></button>

                                    <!-- <div class="single-form form-check mt-3">
                                    <input class="form-check-input header-check-input" type="checkbox" value="" id="flexCheckDefault">
                                    <label class="form-check-label header-label-text" for="flexCheckDefault">Remember me</label>
                                    </div> -->


                                </form>
                            </div>
                            <p class=" mt-3">Need Help? Reach us on <a target="_blank" href="https://api.whatsapp.com/send?phone=919833992919&text=Hello" class="whatsapp-button"><i
            class="fab fa-whatsapp color-green what-app-kidiaree"></i></a></p>
                            
                        </div>
                        
                        <!-- Hero Content End -->
                    </div>
                    <div class="col-lg-6">
                        <!-- Hero Images Start -->
                        <div class="hero-images">
                            <img class="shape-1" src="assets/images/shape/hero-shape1.png" alt="">
                            <div class="shape-2"></div>
                            <div class="shape-6">
                                <img src="assets/images/shape/shape-7.png" alt="">
                            </div>
                            <div class="image">
                                <img src="assets/images/hero-img-3.png" alt="">
                            </div>
                        </div>
                        <!-- Hero Images End -->
                    </div>
                </div>
            </div>

        </div>
        <!-- Hero End -->
        <div class="arrow bounce">
            <a  href="#topcat"><i class="flaticon-download" style="font-size: 30px; color:#379f75;font-weight:900;"></i></a>
        </div>
        
        <!-- Category Start -->
        <div class="section kidiaree-category-section" id="topcat">
            <div class="container">
                <div class="category-wrap">
                    <div class="row">
                        <div class="section-title text-center">
                            <h2 class="title">Top <span>Categories</span></h2>
                        </div>
                    </div>
                    <div class="category-content-wrap">
                        <div class="row text-center">
                            <div class="col-lg-3 col-6">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <a class="image-cat" href="academic_classes.php">
                                        <img src="assets/images/category/1.jpg" alt="offer" class="rounded">
                                    </a>
                                </div>
                                <!-- Category Item End -->
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <a class="image-cat" href="extra-curricular.php">
                                        <img src="assets/images/category/2.jpg" alt="offer" class="rounded">
                                    </a>
                                </div>
                                <!-- Category Item End -->
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <div class="image-cat">
                                        <img src="assets/images/category/3.jpg" alt="offer" class="rounded">
                                    </div>
                                </div>
                                <!-- Category Item End -->
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <a class="image-cat" href="events.php">
                                        <img src="assets/images/category/5.jpg" alt="offer" class="rounded">
                                    </a>
                                </div>
                                <!-- Category Item End -->
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <div class="image-cat">
                                        <img src="assets/images/category/6.jpg" alt="offer" class="rounded">
                                    </div>
                                </div>
                                <!-- Category Item End -->
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <div class="image-cat">
                                        <img src="assets/images/category/4.jpg" alt="offer" class="rounded">
                                    </div>
                                </div>
                                <!-- Category Item End -->
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <div class="image-cat">
                                        <img src="assets/images/13.jpg" alt="offer" class="rounded">
                                    </div>
                                </div>
                                <!-- Category Item End -->
                            </div>
                            <div class="col-lg-3 col-6">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <div class="image-cat">
                                        <img src="assets/images/Picks for parents.jpg" alt="offer" class="rounded">
                                    </div>
                                </div>
                                <!-- Category Item End -->
                            </div>
                            <div class="col-lg-3 col-6 d-none">
                                <!-- Category Item Start -->
                                <div class="single-offer text-center">
                                    <div class="image-cat">
                                        <img src="assets/images/category/7.jpg" alt="offer" class="rounded">
                                    </div>
                                </div>
                                <!-- Category Item End -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Category End -->


        <!-- Courses Start -->
        <div class="section section-padding">
            <div class="container">

                <!-- Course Header Start -->
                <div class="course-header">
                    <!-- Section Title Start -->
                    <div class="section-title">
                        <h2 class="title"><span>Featured</span> Classes </h2>
                    </div>
                    

                    <!-- <div class="tab-menu">
                        <ul class="nav justify-content-center justify-content-lg-start">
                            <li><button class="active" data-bs-toggle="tab" data-bs-target="#tab1">Todays</button></li>
                            <li><button data-bs-toggle="tab" data-bs-target="#tab2">Tomorrow</button></li>
                            <li><button data-bs-toggle="tab" data-bs-target="#tab3">This Weekend </button></li>
                            <li><button data-bs-toggle="tab" data-bs-target="#tab4">Offline</button></li>
                            <li><button data-bs-toggle="tab" data-bs-target="#tab5">Online</button></li>
                        </ul>
                    </div> -->
                </div>
                <!-- Course Header End -->

                <!-- Courses Wrapper Start -->
                <div class="courses-wrapper">
                    <!-- Section Title End -->
                    <!-- <div id="owl-demo" class="owl-carousel owl-theme">
                        <div class="item"><h1>1</h1></div>
                        <div class="item"><h1>2</h1></div>
                        <div class="item"><h1>3</h1></div>
                        <div class="item"><h1>4</h1></div>
                        <div class="item"><h1>5</h1></div>
                        <div class="item"><h1>6</h1></div>
                        <div class="item"><h1>7</h1></div>
                        <div class="item"><h1>8</h1></div>
                        <div class="item"><h1>9</h1></div>
                        <div class="item"><h1>10</h1></div>
                        <div class="item"><h1>11</h1></div>
                        <div class="item"><h1>12</h1></div>
                        <div class="item"><h1>13</h1></div>
                        <div class="item"><h1>14</h1></div>
                        <div class="item"><h1>15</h1></div>
                        <div class="item"><h1>16</h1></div>
                    </div> -->
                        
                        <!-- <div class="customNavigation">
                        <a class="btn prev">Previous</a>
                        <a class="btn next">Next</a>
                    </div> -->

                    <!-- Courses Tab Start -->
                    <div class="testimonial-wrap-02">

                                        <div class="testimonial-content-wrap-02">
                                            <div id="owl-demo" class="owl-carousel owl-theme">
                                                <!-- <div class="swiper-wrapper"> -->
                                                    <?php
                                                    if($getClass->num_rows > 0){
                                                        while($row = $getClass->fetch_assoc()){
                                                            // print_r($row );
                                                            // die;
                                                    ?>
                                                    <!-- <div class="swiper-slide"> -->
                                                        <!--  Single Testimonial Start  -->
                                                            <!-- Single Courses Start -->
                                                                <div class="single-course new-width item">
                                                                    <div class="courses-image">
                                                                        <a href="<?php echo $row['product_url'] ;?>"><img src="<?php echo $row['thumbnail'] ;?>" alt="Courses"></a>
                                                                    </div>
                                                                    <div class="courses-content">
                                                                        <div class="top-meta">
                                                                            <div class="tag-time">
                                                                                <a class="tag" href="<?php echo $row['product_url'] ;?>"><?php echo $row['type'] ;?></a>
                                                                                <p class="time"><i class="fa fa-birthday-cake"></i> <?php echo $row['age'] ;?> Yrs</p>
                                                                            </div>
                                                                        </div>
                                                                        <h3 class="title mt-2"><a href="<?php echo $row['product_url'] ;?>"><?php echo $row['name'] ;?></a></h3>
                                                                        <div class="top-meta  mt-2">
                                                                            <span class="price">
                                                                            <span class="sale-price">INR <?php echo $row['price'] ;?></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Single Courses End -->
                                                                <!-- Single Courses Start -->
                                                                <!-- <div class="single-course new-width">
                                                                    <div class="courses-image">
                                                                        <a href="course-details.html"><img src="assets/images/the_drum.png" alt="Courses"></a>
                                                                    </div>
                                                                    <div class="courses-content">
                                                                        <div class="top-meta">
                                                                            <div class="tag-time">
                                                                                <a class="tag" href="#">Offline</a>
                                                                                <p class="time"><i class="fa fa-birthday-cake"></i> 9-12 Yrs</p>
                                                                            </div>
                                                                        </div>
                                                                        <h3 class="title mt-2"><a href="course-details.html"><?php echo $row['name'] ;?></a></h3>
                                                                        <div class="top-meta mt-2">
                                                                            <span class="price">
                                                                            <span class="sale-price">INR 6000 for 5 Sessions</span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div> -->
                                                                <!-- Single Courses End -->
                                                        <!-- </div> -->
                                                        <!--  Single Testimonial End  -->
                                                    <?php } }else{ ?>
                                                        <p class="mt-3 text-center">No Class(s) found...</p>
                                                    <?php } ?>
                                                    
                                                <!-- </div> -->
                                                <!-- Add Pagination -->
                                                  
                                            </div>
                                            <div class="customNavigation mt-3">
                                                <a class="prev"><i class="fa fa-arrow-alt-circle-left" style="font-size:25px;"></i></a>
                                                <a class="next"><i class="fa fa-arrow-alt-circle-right" style="font-size:25px;"></i></a>
                                            </div>
                                        </div>
                                    </div>
                    <!-- Courses Tab End -->

                </div>
                <!-- Courses Wrapper End -->
            </div>
        </div>
        <!-- Courses End -->

        
        
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
                                <h4 class="footer-widget-title">Other Headers</h4>
                                <div class="widget-link">
                                    <ul class="link">
                                        <li><a href="#">About Us </a></li>
                                        <li><a href="#">Featured Classes & Activities</a></li>
                                        <li><a href="privacy_policy.php">Privacy Policy</a></li>
                                        <li><a href="terms_and_conditions_for_users.php">Terms & Conditions for Users </a></li>
                                        <li><a href="terms_and_conditions_for_service_provider.php">Terms & Conditions for Service Providers </a></li>
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


    <!-- location Modal -->
<div class="modal md-placement fade" id="locationModal" tabindex="-1" aria-labelledby="locationModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
    <div class="modal-header">
        <img src = "assets/images/near.svg" alt="My Happy SVG" style="margin-right: 5px;"/>
        <p class="text-dark">Enable your location And we'll find you the nearest options! </p>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModal('locationModal')" aria-label="Close"></button>
    </div>
  </div>
</div>
</div>

    <!-- location Modal -->
<div class="modal fade" id="checkLocation1" tabindex="-1" aria-labelledby="checkLocation" aria-hidden="true" style="margin-top: 12% !important;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="checkLocation">Location</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModal('checkLocation')" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-danger">Would you like to search for this pincode?</p>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick= "clearInput('checkLocation')">Yes</button>
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="closeModal('checkLocation')">No</button>
      </div>
  </div>
</div>
</div>
    <!-- location Modal -->
<div class="modal fade" id="notifications" tabindex="-1" aria-labelledby="notifications" aria-hidden="true" style="margin-top: 12% !important;">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="notifications">Notification</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" onclick="closeModal('notifications')" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p class="text-danger">Would you like to recevied notifications?</p>
        <div class="widget-checkbox">
        <ul class="checkbox-list">
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" value id="checkbox1" checked>
                    <label class="form-check-label" for="checkbox1">WhatsApp</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkbox2" checked>
                    <label class="form-check-label" for="checkbox2">Email</label>
                </li>
                <li class="form-check">
                    <input class="form-check-input" type="checkbox" value="" id="checkbox2" checked>
                    <label class="form-check-label" for="checkbox2">Push notification</label>
                </li>
            </ul>
    </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" onclick="acceptEmail()">Save</button>
      </div>
  </div>
</div>
</div>


    <!-- JS
    ============================================ -->
    <script src="assets/js/vendor/jquery-1.12.4.min.js"></script>
    <script src="owl-carousel/owl.carousel.min.js"></script>
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
  if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
      navigator.serviceWorker.register('/service-worker.js')
        .then(registration => {
          console.log('Service Worker registered with scope:', registration.scope);
        })
        .catch(error => {
          console.log('Service Worker registration failed:', error);
        });
    });
  }
  
 let deferredPrompt; // Declare a variable to store the deferred prompt

// Listen for the beforeinstallprompt event
window.addEventListener('beforeinstallprompt', (event) => {
    event.preventDefault(); // Prevent the browser's default prompt
    deferredPrompt = event; // Store the deferred prompt for later use

    // Show your custom "Add to Home Screen" button or any other UI element
    // that will trigger the prompt when clicked
    showAddToHomeScreenButton();
});

// Function to show your custom "Add to Home Screen" button
function showAddToHomeScreenButton() {
    // const addToHomeScreenButton = document.createElement('button');
    // addToHomeScreenButton.textContent = 'Add to Home Screen';
    addToHomeScreenButton.addEventListener('click', () => {
        if (deferredPrompt) {
            deferredPrompt.prompt(); // Show the prompt
            deferredPrompt.userChoice.then((choiceResult) => {
                if (choiceResult.outcome === 'accepted') {
                    // User accepted the prompt
                } else {
                    // User dismissed the prompt
                }
                deferredPrompt = null; // Reset the deferred prompt
            });
        }
    });

    // Append the button to a visible part of your web app
    // document.body.appendChild(addToHomeScreenButton);
}

$("#zipcode").change(function(){
   var zipcode  = $('#zipcode').val();
   localStorage.setItem("pin", zipcode);
});

var pin = localStorage.getItem("pin");
$('#zipcode').val(pin);

// Example usage: Call showAddToHomeScreenButton() when you want to display the prompt again

$(document).ready(function() {
 
 var owl = $("#owl-demo");

 owl.owlCarousel({
     items : 6, //10 items above 1000px browser width
     itemsDesktop : [1000,3], //5 items between 1000px and 901px
     itemsDesktopSmall : [900,3], // betweem 900px and 601px
     itemsTablet: [600,2], //2 items between 600 and 0
     itemsMobile : false // itemsMobile disabled - inherit from itemsTablet option
 });
//  $( ".owl-prev").html('<i class="fa fa-chevron-left"></i>');
//  $( ".owl-next").html('<i class="fa fa-chevron-right"></i>');

 // Custom Navigation Events
 $(".next").click(function(){
   owl.trigger('owl.next');
 })
 $(".prev").click(function(){
   owl.trigger('owl.prev');
 })
 $(".play").click(function(){
   owl.trigger('owl.play',1000); //owl.play event accept autoPlay speed as second parameter
 })
 $(".stop").click(function(){
   owl.trigger('owl.stop');
 })

});

</script>

</body>

</html>