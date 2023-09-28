
<?php include_once 'global.php'; ?>
<?php include_once 'dbConfig.php';
$where = '';
// Get member rows
$getClass = $db->query("SELECT * FROM products where id=".$_GET['id']);
$data = $getClass->fetch_assoc();
// print_r($data);
// echo "SELECT * FROM usersmaster where id=".$data['teacher_id'];
$getTeacher = $db->query("SELECT * FROM usersmaster where id=".$data['teacher_id']);
$dataTeachers = $getTeacher->fetch_assoc();
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
        <div class="section page-banner-section class-details" style="background-image: url(assets/images/bg/page-banner.jpg);">
            <div class="shape-1">
                <img src="assets/images/shape/shape-7.png" alt="">
            </div>
            <div class="shape-2">
                <img src="assets/images/shape/shape-1.png" alt="">
            </div>
            <div class="shape-3"></div>
            <div class="container">
                <!-- Course Details Banner Content Start -->
                <div class="course-details-banner-content">

                    <h2 class="title color-k-7"><?php echo $data['name'] ?> </h2>


                    <div class="course-details-meta">
                        <div class="meta-action">
                            <div class="meta-author">
                                <img src="assets/images/author-zeeny.jpg" alt="Author">
                            </div>
                            <a class="meta-name" href="#">
                                <p class="name">by <?php echo $dataTeachers['name'] ?></p>
                            </a>
                        </div>

                        <!-- <div class="meta-action">
                            <h5 class="date">Last Update: <span>2/12/2023</span></h5>
                        </div> -->
                        <div class="meta-action">
                            <div class="rating">
                                <div class="rating-star">
                                    <div class="rating-active" style="width: 100%;"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <p class="text creative-page-sub-heading"><?php echo $dataTeachers['sub-desc'] ?></p>

                </div>
                <!-- Course Details Banner Content End -->
            </div>
        </div>
        <!-- Page Banner End -->

        <!-- Course Details Start -->
        <div class="section section-padding">
            <div class="container">

                <div class="row justify-content-between">
                    <div class="col-xl-7 col-lg-8">

                        <!-- Course Details Wrapper Start -->
                        <div class="course-details-wrapper">

                            <!-- Course Overview Start -->
                            <div class="course-overview">
                                <h3 class="title">About the Class</h3>
                                <p><?php echo $data['description'] ?></p>
                            </div>
                            <!-- Course Overview End -->

                            <!-- Course Instructor Start -->
                            <div class="course-instructor">
                                <h3 class="title">About the Teacher</h3>

                                <div class="instructor-profile">
                                    <div class="profile-images">
                                        <img src="assets/<?php echo $dataTeachers['profilePictureUrl'] ?>" alt="author">
                                    </div>
                                    <div class="profile-content">
                                        <h5 class="name"><?php echo $dataTeachers['name'] ?></h5>

                                        <div class="profile-meta">
                                            <div class="rating">
                                                <div class="rating-star">
                                                    <div class="rating-active" style="width: 100%;"></div>
                                                </div>
                                            </div>
                                            <!-- <span class="meta-action"><i class="fa fa-play-circle creative-page-icons"></i> 10 Tutorials</span> -->
                                            <!-- <span class="meta-action"><i class="fa fa-person-booth creative-page-icons"></i> Instructor-led</span> -->
                                        </div>

                                        <p><?php echo $dataTeachers['descriptions'] ?></p>

                                    </div>
                                </div>
                            </div>
                            <!-- Course Instructor End -->


                        </div>
                        <!-- Course Details Wrapper End -->

                    </div>

                    <div class="col-lg-4">
                        <!-- Sidebar Wrapper Start -->
                        <div class="sidebar-details-wrap">

                            <!-- Sidebar Details Video Description Start -->
                            <div class="sidebar-details-video-description">
                                <div class="sidebar-video">
                                    <img src="assets/images/courses/sidebar-video.jpg" alt="video">
                                    <a href="https://www.youtube-nocookie.com/embed/Ga6RYejo6Hk" class="popup-video play"><i class="fa fa-play"></i></a>
                                </div>
                                <div class="sidebar-description">
                                    <div class="price-wrap">
                                        <!-- <span class="label">Price  :</span> -->
                                        <div class="price">
                                            <span class="sale-price">INR <?php echo $data['price'] ?></span>
                                            <span class="regular-price">for 5 Sessions</span>
                                        </div>
                                    </div>
                                    <ul class="description-list">
                                        <li><i class="flaticon-location-pin creative-page-icons"></i> <?php echo $data['type'] ?></li>
                                        <li><i class="fas fa-birthday-cake creative-page-icons"></i>Suitable for <?php echo $data['age'] ?> year olds</li>
                                        <li><i class="far fa-calendar-alt creative-page-icons"></i> 16-20 Jul, 2023 </span></li>
                                        <li><i class="far fa-clock creative-page-icons"></i> 5.15 pm IST</span></li>
                                        <li><i class="fa fa-stopwatch creative-page-icons"></i> 60 mins per session</li>
                                        <li><i class="fas fa-language creative-page-icons"></i> Medium of Instruction - English</li>
                                        <!-- <li><i class="far fa-user"></i> Enrolled <span>4 Enrolled</span></li> -->
                                    </ul>
                                    <?php if(!empty($_SESSION['token'])){ ?><a href="checkout.php" class="btn w-100">Enroll Now</a> <?php } else { ?> <a class="btn w-100" href="myaccount.php">Enroll Now</a><?php } ?>
                                    <div class="share-link">
                                        <div class="link-icon">
                                            <i class="fas fa-share-alt creative-page-icons"></i>
                                        </div>
                                        <a class="share-btn" href="#"> Share This Course</a>
                                        <div class="social-share-wrapper">
                                            <ul>
                                                <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                                <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                                                <li><a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                                <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Sidebar Details Video Description End -->


                        </div>
                        <!-- Sidebar Wrapper End -->
                    </div>
                </div>


            </div>
        </div>
        <!-- Course Details End -->

        <!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Select a Slot</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio1" value="option1">
  <label class="form-check-label" for="inlineRadio1"><span class=""><i class="far fa-calendar-alt"></i> May 15, 2023 6:00 - 6.30</span></label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio2" value="option2">
  <label class="form-check-label" for="inlineRadio2"><span class=""><i class="far fa-calendar-alt"></i> May 17, 2023 6:15 - 6.45</span></label>
</div>
<div class="form-check form-check-inline">
  <input class="form-check-input" type="radio" name="inlineRadioOptions" id="inlineRadio3" value="option3" disabled>
  <label class="form-check-label" for="inlineRadio3"><span class=""><i class="far fa-calendar-alt"></i> May 19, 2023 6:00 - 6.30</span></label>
</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary">Submit</button>
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

    <?php include('const/scripts.php'); ?>

</body>

</html>