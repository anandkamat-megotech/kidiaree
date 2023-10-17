
<?php // Load the database configuration file
include_once 'dbConfig.php';
// $where = '';
// $text = '';
// if(isset($_GET['tags'])){
//     $where .= 'tags LIKE \'%'.$_GET['tags']."%' ";
// }

// if(!empty($_GET['age'])){
//     // if($_GET['age'] < 10){
//     //     $where .= ' AND age_tags LIKE "'.$_GET['age']."%\"";
//     // }else{
//     //     $where .= ' AND age_tags LIKE "%'.$_GET['age']."%\"";
//     // }
//     $where .= ' AND age_tags LIKE "%-:-'.$_GET['age']."-:-%\"";
    

// }
// if(isset($_GET['type']) && $_GET['type'] == "both"){
//     $where .= ' AND tags LIKE \'%'.$_GET['type']."%' ";
//     $text .= ' Online & Offline ';

// }
// if(isset($_GET['type']) && $_GET['type'] != "both" ){
//     $where .= ' AND type = \''.$_GET['type']."' ";
//     $text .= '<span style="text-transform: capitalize;"> '.$_GET['type'].' </span>';
// }

// if(!empty($_GET['tags'])){
//     $text .=' '. $_GET['tags'].' Classes ';
// } else {
//     $text .= ' Classes & Activities ';
// }
// if(!empty($_GET['age'])){
//     $text .= ' for '.$_GET['age'].' year olds';
// }


// echo "SELECT * FROM products where ".$where." order by id desc";
// Get member rows
$getClass = $db->query("SELECT * FROM products order by id desc");
$getClass1 = $db->query("SELECT * FROM products order by id desc");
 ?>
<?php include_once 'global.php'; ?>
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
                                <h2 class="title">Play Areas</h2>
                                <ul class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="#">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">Play Areas </li>
                                </ul>
                                <p>Play Areas in Mumbai, Showing results nearest to 400101</p>
                            </div>
                            <!-- Page Banner Content End -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Page Banner End -->


        <!-- Course List Start -->
        <div class="section section-padding">
            <div class="container">

                <!-- Course List Wrapper Start -->
                <div class="course-list-wrapper">
                    <div class="row">
                        <div class="col-lg-12">

                            <!-- Course Top Bar Start -->
                            <div class="course-top-bar">
                                <div class="course-top-text">
                                    <p>We found <span><?php if(!empty($getClass->num_rows)){ echo $getClass->num_rows;} else { echo '0'; } ?></span> Classes For You</p>
                                </div>
                                <div class="course-top-inner">
                                    <div class="course-top-menu">
                                        <ul class="nav">
                                            <li><button class="active" data-bs-toggle="tab" data-bs-target="#grid"><i class="fa fa-th-large"></i></button></li>
                                            <li><button data-bs-toggle="tab" data-bs-target="#list"><i class="fa fa-th-list"></i></button></li>
                                        </ul>
                                    </div>
                                    
                                </div>
                            </div>
                            <!-- Course Top Bar End -->

                            
                            <!-- Course Collapse End -->

                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="grid">
                                    <!-- Testimonial Wrap Start  -->
                                    <div class="testimonial-wrap-02 d-block d-md-none">

                                        <div class="testimonial-content-wrap-02">
                                            <div class=" row mt-3">
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
                                                            <div class=" single-course mb-3" style="border-radius: 10px;border:1px solid #ddd;display:inline-block !important;border-style: dashed;">
                                                            <div class="play-action" >Book Now </div>        
                                                            <div class="course-image width-thumb play-area">
                                                               <a href="#"><img src="<?php echo $row['thumbnail']; ?>" alt="Courses"></a>
                                                         </div>
                                                         <div class="courses-content width-content" style="padding-top: 0px !important;">
                                                               <h3 class="title" style="margin-top: 0px !important;"><a href="<?php echo 'playarea_details.php?id='.$row['id']; ?>" style="font-size: 14px !important;"><?php echo $row['name']; ?></a></h3>
                                                               <ul class="description-list">
                                                                  <li><i class="flaticon-location-pin creative-page-icons"></i> Kandivali, <?php echo $row['id']; ?>km Away</li>
                                                                  <li><i class="far fa-calendar-alt creative-page-icons"></i> Slides, Ball Pit, Trampoline & much more </li>
                                                                  <li><i class="fa fa-stopwatch creative-page-icons"></i> 10am – 7pm, Open everyday</li>
                                                               </ul>
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
                                                <div class="swiper-pagination"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Wrap End  -->
                                <div class="d-none d-md-block">
                                    <div class="row">
                                    <?php
                                                    if($getClass1->num_rows > 0){
                                                        while($row1 = $getClass1->fetch_assoc()){
                                                            // print_r($row );
                                                            // die;
                                                    ?>
                                        <div class=" single-course mb-3" style="border-radius: 10px;border:1px solid #ddd;display:inline-block !important;border-style: dashed;">
                                                            <!-- <div class="action-course"><i class="fa fa-user-edit icon-style"></i><i class="fa fa-trash icon-style"></i> </div>         -->
                                                            <div class="course-image width-thumb play-area">
                                                               <a href="#"><img src="<?php echo $row1['thumbnail']; ?>" alt="Courses"></a>
                                                         </div>
                                                         <div class="courses-content width-content" style="padding-top: 0px !important;">
                                                               <h3 class="title" style="margin-top: 0px !important;"><a href="<?php echo $row1['product_url'].'?id='.$row1['id']; ?>" style="font-size: 14px !important;"><?php echo $row1['name']; ?></a></h3>

                                                               <div class="top-meta">
                                                                     <span class="price">
                                                                     <span class="sale-price" style="font-size: 12px !important;">INR <?php echo $row1['price']; ?></span>
                                                                     </span>
                                                               </div>
                                                               <ul class="description-list">
                                                                  <li><i class="flaticon-location-pin creative-page-icons"></i> <?php echo $row1['type']; ?></li>
                                                                  <li><i class="far fa-calendar-alt creative-page-icons"></i> 16-20 Jul, 2023 </li>
                                                                  <li><i class="fa fa-stopwatch creative-page-icons"></i> 60 mins per session</li>
                                                               </ul>
                                                            </div>
                                                      </div>
                                        <?php } }else{ ?>
                                                        <p class="mt-3 text-center">No Class(s) found...</p>
                                                    <?php } ?>
                                    </div>
                </div>

                                </div>
                                <div class="tab-pane fade " id="list">
                                    <!-- Course List Start -->
                                    <div class="course-list-items">

                                        <!-- Course List Start -->
                                        <div class="single-course-list">
                                            <div class="course-image">
                                                <a href="course-details.html"><img src="assets/images/courses/courses-1.jpg" alt="Courses"></a>
                                            </div>
                                            <div class="course-content">
                                                <div class="top-meta">
                                                    <a class="tag" href="#">Beginner</a>
                                                    <span class="price">
                                            <span class="sale-price">Free</span>
                                                    </span>
                                                </div>
                                                <h3 class="title"><a href="course-details.html">Getting Started with the Linux Command Line</a></h3>
                                                <span class="author-name">Andrew paker</span>

                                                <p>Managing a popular open source project can be daunting at first. How do we maintain all these issues, or automatically trigger</p>

                                                <div class="bottom-meta">
                                                    <p class="meta-action"><i class="far fa-user"></i> 79</p>
                                                    <p class="meta-action"><i class="far fa-clock"></i> 2h 20min</p>
                                                    <div class="rating">
                                                        <div class="rating-star">
                                                            <div class="rating-active" style="width: 60%;"></div>
                                                        </div>
                                                        <span>(4.5)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Course List End -->

                                        <!-- Course List Start -->
                                        <div class="single-course-list">
                                            <div class="course-image">
                                                <a href="course-details.html"><img src="assets/images/courses/courses-2.jpg" alt="Courses"></a>
                                            </div>
                                            <div class="course-content">
                                                <div class="top-meta">
                                                    <a class="tag" href="#">Beginner</a>
                                                    <span class="price">
                                                      <span class="sale-price">$49</span>
                                                    </span>
                                                </div>
                                                <h3 class="title"><a href="course-details.html">Learn PHP Programming From Scratch</a></h3>
                                                <span class="author-name">Daziy Millar</span>

                                                <p>Managing a popular open source project can be daunting at first. How do we maintain all these issues, or automatically trigger</p>

                                                <div class="bottom-meta">
                                                    <p class="meta-action"><i class="far fa-user"></i> 79</p>
                                                    <p class="meta-action"><i class="far fa-clock"></i> 2h 20min</p>
                                                    <div class="rating">
                                                        <div class="rating-star">
                                                            <div class="rating-active" style="width: 60%;"></div>
                                                        </div>
                                                        <span>(4.5)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Course List End -->

                                        <!-- Course List Start -->
                                        <div class="single-course-list">
                                            <div class="course-image">
                                                <a href="course-details.html"><img src="assets/images/courses/courses-3.jpg" alt="Courses"></a>
                                            </div>
                                            <div class="course-content">
                                                <div class="top-meta">
                                                    <a class="tag" href="#">Beginner</a>
                                                    <span class="price">
                                                       <span class="sale-price">$29</span>
                                                    </span>
                                                </div>
                                                <h3 class="title"><a href="course-details.html">The Complete JavaScript Course for Beginner</a></h3>
                                                <span class="author-name">Andrew paker</span>

                                                <p>Managing a popular open source project can be daunting at first. How do we maintain all these issues, or automatically trigger</p>

                                                <div class="bottom-meta">
                                                    <p class="meta-action"><i class="far fa-user"></i> 79</p>
                                                    <p class="meta-action"><i class="far fa-clock"></i> 2h 20min</p>
                                                    <div class="rating">
                                                        <div class="rating-star">
                                                            <div class="rating-active" style="width: 60%;"></div>
                                                        </div>
                                                        <span>(4.5)</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- Course List End -->

                                    </div>
                                    <!-- Course List End -->
                                </div>
                            </div>

                            <!-- Page Pagination Start -->
                            <div class="kidiaree-pagination d-none d-md-block">
                                <ul class="pagination justify-content-center">
                                    <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                    <li><a class="active" href="course-grid.html">1</a></li>
                                    <li><a href="course-grid.html">2</a></li>
                                    <li><a href="course-grid.html">3</a></li>
                                    <li><span>...</span></li>
                                    <li><a href="course-grid.html"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
                            </div>
                            <!-- Page Pagination End -->

                        </div>
                    </div>
                </div>
                <!-- Course List Wrapper End -->

            </div>
        </div>
        <!-- Course List End -->



        <?php include('const/footer.php'); ?>


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
    <script src="assets/js/main.js?v=0.19"></script>

</body>

</html>