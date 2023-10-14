

<?php // Load the database configuration file
include_once 'dbConfig.php';
$where = '';
$text = '';
if(isset($_GET['page'])){
    $where .= 'service_type= \''.$_GET['page']."'";
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
$query_get_class = "SELECT * FROM products where ".$where." order by id desc";
$getClass = $db->query($query_get_class);
$getClass_md = $db->query($query_get_class);
$getClass_md_list = $db->query($query_get_class);
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
                                <h2 class="title" style="text-transform: capitalize;"><?php echo $_GET['page'] ?></h2>
                                <ul class="breadcrumb justify-content-center">
                                    <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                                    <li class="breadcrumb-item active" aria-current="page"  style="text-transform: capitalize;"><?php echo $_GET['page'] ?></li>
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
                            <?php include('const/filter.php'); ?>
                            <!-- Sidebar Wrapper End -->
                        </div>
                        <div class="col-lg-9">

                            <!-- Course Top Bar Start -->
                            <div class="course-top-bar">
                                <div class="course-top-text">
                                    <p>We found <span><?php if(!empty($getClass->num_rows)){ echo $getClass->num_rows;} else { echo '0'; } ?></span> <?php echo $_GET['page'] ?> item for you</p>
                                </div>
                               
                            </div>
                            <!-- Course Top Bar End -->

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
                                                                        <a href="<?php echo $row['product_url'] ;?>?id=<?php echo $row['id'] ;?>"><img src="<?php echo $row['thumbnail'] ;?>" alt="Courses"></a>
                                                                    </div>
                                                                    <div class="courses-content">
                                                                        <div class="top-meta">
                                                                            <div class="tag-time">
                                                                                <a class="tag" href="<?php echo $row['product_url'] ;?>?id=<?php echo $row['id'] ;?>"><?php echo $row['type'] ;?></a>
                                                                                <p class="time"><i class="fa fa-birthday-cake"></i> <?php echo $row['age'] ;?> Yrs</p>
                                                                            </div>
                                                                        </div>
                                                                        <h3 class="title mt-2"><a href="<?php echo $row['product_url'] ;?>?id=<?php echo $row['id'] ;?>"><?php echo $row['name'] ;?></a></h3>
                                                                        <div class="top-meta  mt-2">
                                                                            <span class="price">
                                                                            <span class="sale-price">INR <?php echo $row['price'] ;?></span>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- Single Courses End -->
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
                                    if($getClass_md->num_rows > 0){
                                        while($row_md = $getClass_md->fetch_assoc()){
                                            // print_r($row );
                                            // die;
                                    ?>
                                        <div class="col-lg-3 col-sm-6">
                                            <!-- Single Courses Start -->
                                            <div class="single-course">
                                                <div class="courses-image">
                                                    <a href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><img src="<?php echo $row_md['thumbnail'] ?>" alt="Courses"></a>
                                                </div>
                                                <div class="courses-content">
                                                    <div class="top-meta">
                                                        <div class="tag-time">
                                                            <a class="tag" href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><?php echo $row_md['type'] ;?></a>
                                                            <p class="time"><i class="fa fa-birthday-cake"></i> <?php echo $row_md['age'] ;?> Yrs</p>
                                                        </div>
                                                    </div>
                                                    <h3 class="title mt-2"><a href="<?php echo $row_md['product_url'] ;?>?id=<?php echo $row_md['id'] ;?>"><?php echo $row_md['name'] ;?></a></h3>
                                                    <div class="top-meta  mt-2">
                                                        <span class="price">
                                                        <span class="sale-price">INR <?php echo $row_md['price'] ;?></span>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Single Courses End -->
                                        </div>
                                        <?php } }else{ ?>
                                                        <p class="mt-3 text-center">No Class(s) found...</p>
                                                    <?php } ?>
                                    </div>
                </div>

                                </div>
                            </div>

                            <!-- Page Pagination Start -->
                            <!-- <div class="kidiaree-pagination d-none d-md-block">
                                <ul class="pagination justify-content-center">
                                    <li><a href="#"><i class="fa fa-angle-left"></i></a></li>
                                    <li><a class="active" href="course-grid.html">1</a></li>
                                    <li><a href="course-grid.html">2</a></li>
                                    <li><a href="course-grid.html">3</a></li>
                                    <li><span>...</span></li>
                                    <li><a href="course-grid.html"><i class="fa fa-angle-right"></i></a></li>
                                </ul>
                            </div> -->
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