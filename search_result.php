
<?php // Load the database configuration file
include_once 'dbConfig.php';
$where = '';
$text = '';
if(isset($_GET['tags'])){
    $where .= 'tags LIKE \'%'.$_GET['tags']."%' ";
}

if(!empty($_GET['age'])){
    // if($_GET['age'] < 10){
    //     $where .= ' AND age_tags LIKE "'.$_GET['age']."%\"";
    // }else{
    //     $where .= ' AND age_tags LIKE "%'.$_GET['age']."%\"";
    // }
    $where .= ' AND age_tags LIKE "%-:-'.$_GET['age']."-:-%\"";
    

}
if(isset($_GET['type']) && $_GET['type'] == "both"){
    $where .= ' AND tags LIKE \'%'.$_GET['type']."%' ";
    $text .= ' Online & Offline ';

}
if(isset($_GET['type']) && $_GET['type'] != "both" ){
    $where .= ' AND type = \''.$_GET['type']."' ";
    $text .= '<span style="text-transform: capitalize;"> '.$_GET['type'].' </span>';
}

if(!empty($_GET['tags'])){
    $text .=' '. $_GET['tags'].' Classes ';
} else {
    $text .= ' Classes & Activities ';
}
if(!empty($_GET['age'])){
    $text .= ' for '.$_GET['age'].' year olds';
}


// echo "SELECT * FROM products where ".$where." order by id desc";
// Get member rows
$getClass = $db->query("SELECT * FROM products where ".$where." order by id desc");
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
                                <h2 class="title">Search results</h2>
                                <h4>for</h4>
                                <ul class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item active" aria-current="page"><?php if(!empty($text)){ echo $text;} ?></li>
                                </ul>
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
                        <div class="col-lg-3">
                            <!-- Sidebar Wrapper Start -->
                            <div class="sidebar-wrap-02">

                                <!-- Sidebar Wrapper Start -->
                                <div class="sidebar-widget-02">
                                    <h3 class="widget-title">Search Classes</h3>

                                    <div class="">
                                        <form>
                                            <!-- <li class="form-check"> -->
                                                <input class="form-control mt-2" type="text" placeholder="e.g. math or english" value="" id="checkbox1">
                                                <!-- <label class="form-check-label" for="checkbox1">Online (11)</label> -->
                                            <!-- </li> -->
                                        </form>
                                    </div>
                                </div>
                                <!-- Sidebar Wrapper End -->

                                <div class="course-accordion accordion" id="accordionCourse">
                                <div class="accordion-item">
                                        <button data-bs-toggle="collapse" data-bs-target="#collapseOne">Quick Filters </button>
                                        <div id="collapseOne" class="accordion-collapse collapse" data-bs-parent="#accordionCourse">
                                            <div class="accordion-body mt-2">
                                                 <!-- Sidebar Wrapper Start -->
                                <div class="sidebar-widget-02">
                                    <h3 class="widget-title">Mode</h3>

                                    <div class="widget-checkbox">
                                        <ul class="checkbox-list">
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value id="checkbox1" checked>
                                                <label class="form-check-label" for="checkbox1">Online</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox2" checked>
                                                <label class="form-check-label" for="checkbox2">Offline</label>
                                                <ul class="checkbox-list">
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox12">
                                                            <label class="form-check-label" for="checkbox12">Teacher to travel</label>
                                                        </li>
                                                </ul>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Sidebar Wrapper End -->

                                <!-- Sidebar Wrapper Start -->
                                <div class="sidebar-widget-02">
                                    <h3 class="widget-title">Subject(s) </h3>

                                    <div class="widget-checkbox">
                                        <ul class="checkbox-list">
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox3">
                                                <label class="form-check-label" for="checkbox3">English</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox4">
                                                <label class="form-check-label" for="checkbox4">Math</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox5">
                                                <label class="form-check-label" for="checkbox5">EVS / Science</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox6">
                                                <label class="form-check-label" for="checkbox7">Physics</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox8">
                                                <label class="form-check-label" for="checkbox8">Chemistry</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox9">
                                                <label class="form-check-label" for="checkbox9">Biology</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox10">
                                                <label class="form-check-label" for="checkbox10">Computer Science</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox11">
                                                <label class="form-check-label" for="checkbox11">Indian Languages</label>
                                                <div class="widget-checkbox">
                                                    <ul class="checkbox-list">
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox12">
                                                            <label class="form-check-label" for="checkbox12">Hindi</label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox13">
                                                            <label class="form-check-label" for="checkbox13">Marathi</label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox14">
                                                            <label class="form-check-label" for="checkbox14">Bengali</label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox15">
                                                            <label class="form-check-label" for="checkbox15">Kannada</label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox16">
                                                            <label class="form-check-label" for="checkbox16">Sanskrit</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox11">
                                                <label class="form-check-label" for="checkbox11">Board</label>
                                                <div class="widget-checkbox">
                                                    <ul class="checkbox-list">
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox12">
                                                            <label class="form-check-label" for="checkbox12">ICSCE</label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox13">
                                                            <label class="form-check-label" for="checkbox13">CBSE</label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox14">
                                                            <label class="form-check-label" for="checkbox14">IB</label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox15">
                                                            <label class="form-check-label" for="checkbox15">IGCSE</label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox16">
                                                            <label class="form-check-label" for="checkbox16">State Board</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Sidebar Wrapper End -->

                                <!-- Sidebar Wrapper Start -->
                                <div class="sidebar-widget-02">
                                    <h3 class="widget-title">Grade</h3>

                                    <div class="widget-checkbox">
                                        <ul class="checkbox-list">
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value id="checkbox17">
                                                <label class="form-check-label" for="checkbox17">Pre-school</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox18">
                                                <label class="form-check-label" for="checkbox18">Nursery</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox19">
                                                <label class="form-check-label" for="checkbox19">Junior KG</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox20">
                                                <label class="form-check-label" for="checkbox20">Senior KG</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox21">
                                                <label class="form-check-label" for="checkbox21">Grade 1</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox22">
                                                <label class="form-check-label" for="checkbox21">Grade 1</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox21">
                                                <label class="form-check-label" for="checkbox22">Grade 2</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox23">
                                                <label class="form-check-label" for="checkbox23">Grade 3</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox24">
                                                <label class="form-check-label" for="checkbox24">Grade 4</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox25">
                                                <label class="form-check-label" for="checkbox25">Grade 5</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox26">
                                                <label class="form-check-label" for="checkbox26">Grade 6</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox27">
                                                <label class="form-check-label" for="checkbox27">Grade 7</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox28">
                                                <label class="form-check-label" for="checkbox28">Grade 8</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox29">
                                                <label class="form-check-label" for="checkbox29">Grade 9</label>
                                            </li>
                                            <li class="form-check">
                                                <input class="form-check-input" type="checkbox" value="" id="checkbox30">
                                                <label class="form-check-label" for="checkbox30">Grade 10</label>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <!-- Sidebar Wrapper End -->
                                            </div>
                                        </div>
                                    </div>
                                </div>



                            </div>
                            <!-- Sidebar Wrapper End -->
                        </div>
                        <div class="col-lg-9">

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
                                    <div class="course-collapse-btn">
                                        <button class="btn collapsed" data-bs-toggle="collapse" data-bs-target="#collapseFilters">
                                            <i class="fa fa-filter"></i>
                                            Sort by : <span>Default </span>
                                            <i class="fa fa-angle-down"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <!-- Course Top Bar End -->

                            <!-- Course Collapse Start -->
                            <div class="collapse" id="collapseFilters">
                                <div class="course-collapse">
                                    <div class="row">
                                        <div class="col-md-3">
                                            <!-- Sidebar Wrapper Start -->
                                            <div class="sidebar-widget-02">
                                                <h3 class="widget-title">Sort by</h3>

                                                <div class="widget-checkbox">
                                                    <ul class="checkbox-list">
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox14">
                                                            <label class="form-check-label" for="checkbox14">Distance (for Offline only)</label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- Sidebar Wrapper End -->
                                        </div>
                                        <div class="col-md-3">
                                            <!-- Sidebar Wrapper Start -->
                                            <div class="sidebar-widget-02">
                                                <h3 class="widget-title">Ratings</h3>

                                                <div class="widget-checkbox">
                                                    <ul class="checkbox-list">
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox22">
                                                            <label class="form-check-label" for="checkbox22">
                                                                <div class="rating">
                                                                    <div class="rating-on" style="width: 100%;"></div>
                                                                </div> (4.5)
                                                            </label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox23">
                                                            <label class="form-check-label" for="checkbox23">
                                                                <div class="rating">
                                                                    <div class="rating-on" style="width: 60%;"></div>
                                                                </div> (3.5)
                                                            </label>
                                                        </li>
                                                        <li class="form-check">
                                                            <input class="form-check-input" type="checkbox" value="" id="checkbox24">
                                                            <label class="form-check-label" for="checkbox24">
                                                                <div class="rating">
                                                                    <div class="rating-on" style="width: 40%;"></div>
                                                                </div> (2)
                                                            </label>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <!-- Sidebar Wrapper End -->
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                                                                <div class="single-course new-width">
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
                                                <div class="swiper-pagination"></div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Testimonial Wrap End  -->
                                <div class="d-none d-md-block">
                                    <div class="row">
                                        <div class="col-lg-4 col-sm-6">
                                            <!-- Single Courses Start -->
                                            <div class="single-course">
                                                <div class="courses-image">
                                                    <a href="single-session.php"><img src="assets/images/courses/one.jpg" alt="Courses"></a>
                                                </div>
                                                <div class="courses-content">
                                                    <div class="top-meta">
                                                        <div class="tag-time">
                                                            <a class="tag" href="#">Online</a>
                                                            <!-- <p class="time"><i class="far fa-clock"></i> Single Session</p> -->
                                                        </div>
                                                        <span class="price">
                                                        <span class="sale-price">INR 5000</span>
                                                        </span>
                                                    </div>
                                                    <h3 class="title"><a href="single-session.php">Story Time</a></h3>
                                                    <div class="courses-meta">
                                                        <p class="author-name"><span>By</span> Andrew paker</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Single Courses End -->
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <!-- Single Courses Start -->
                                            <div class="single-course">
                                                <div class="courses-image">
                                                    <a href="course-details.html"><img src="assets/images/courses/2.jpg" alt="Courses"></a>
                                                </div>
                                                <div class="courses-content">
                                                    <div class="top-meta">
                                                        <div class="tag-time">
                                                            <a class="tag" href="#">Offline</a>
                                                            <!-- <p class="time"><i class="far fa-clock"></i> Multiple Session</p> -->
                                                        </div>
                                                        <span class="price">
                                                        <span class="sale-price">INR 1K/Session</span>
                                                        </span>
                                                    </div>
                                                    <h3 class="title"><a href="course-details.html">Mom and me</a></h3>
                                                    <div class="courses-meta">
                                                        <p class="author-name"><span>By</span> Andrew paker</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Single Courses End -->
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <!-- Single Courses Start -->
                                            <div class="single-course">
                                                <div class="courses-image">
                                                    <a href="course-details.html"><img src="assets/images/courses/three.jpg" alt="Courses"></a>
                                                </div>
                                                <div class="courses-content">
                                                    <div class="top-meta">
                                                        <div class="tag-time">
                                                            <a class="tag" href="#">Beginner</a>
                                                            <p class="time"><i class="far fa-clock"></i> 2h 30m</p>
                                                        </div>
                                                        <span class="price">
                                                        <span class="sale-price">Free</span>
                                                        </span>
                                                    </div>
                                                    <h3 class="title"><a href="course-details.html">The wonderful world of jolly phonics</a></h3>
                                                    <div class="courses-meta">
                                                        <p class="author-name"><span>By</span> Andrew paker</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Single Courses End -->
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <!-- Single Courses Start -->
                                            <div class="single-course">
                                                <div class="courses-image">
                                                    <a href="course-details.html"><img src="assets/images/courses/courses-5.jpg" alt="Courses"></a>
                                                </div>
                                                <div class="courses-content">
                                                    <div class="top-meta">
                                                        <div class="tag-time">
                                                            <a class="tag" href="#">Beginner</a>
                                                            <p class="time"><i class="far fa-clock"></i> 2h 30m</p>
                                                        </div>
                                                        <span class="price">
                                                        <span class="sale-price">$59</span>
                                                        </span>
                                                    </div>
                                                    <h3 class="title"><a href="course-details.html">The Complete JavaScript Course for Beginner</a></h3>
                                                    <div class="courses-meta">
                                                        <p class="author-name"><span>By</span> Andrew paker</p>
                                                        <div class="rating">
                                                            <div class="rating-star">
                                                                <div class="rating-active" style="width: 60%;"></div>
                                                            </div>
                                                            <span>(4.5)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Single Courses End -->
                                        </div>
                                        <div class="col-lg-4 col-sm-6">
                                            <!-- Single Courses Start -->
                                            <div class="single-course">
                                                <div class="courses-image">
                                                    <a href="course-details.html"><img src="assets/images/courses/courses-6.jpg" alt="Courses"></a>
                                                </div>
                                                <div class="courses-content">
                                                    <div class="top-meta">
                                                        <div class="tag-time">
                                                            <a class="tag" href="#">Beginner</a>
                                                            <p class="time"><i class="far fa-clock"></i> 2h 30m</p>
                                                        </div>
                                                        <span class="price">
                                                        <span class="sale-price">Free</span>
                                                        </span>
                                                    </div>
                                                    <h3 class="title"><a href="course-details.html">Getting Started with the Linux Command Line</a></h3>
                                                    <div class="courses-meta">
                                                        <p class="author-name"><span>By</span> Daziy Millar</p>
                                                        <div class="rating">
                                                            <div class="rating-star">
                                                                <div class="rating-active" style="width: 60%;"></div>
                                                            </div>
                                                            <span>(4.5)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Single Courses End -->
                                        </div>
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

    <!-- JS
    ============================================ -->
    <?php include('const/scripts.php'); ?>

</body>

</html>