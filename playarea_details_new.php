
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
        <div class="section page-banner-section" style="padding-top: 0px;">
        <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
    <div class="carousel-item active">
      <img src="playarea/rush/1.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="playarea/rush/2.png" class="d-block w-100" alt="...">
    </div>
    <div class="carousel-item">
      <img src="playarea/rush/3.png" class="d-block w-100" alt="...">
    </div>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>
        </div>
        <!-- Page Banner End -->

        <!-- Course Details Start -->
        <div class="section section-padding" style="padding-top:0px !important;">
            <div class="container">

            <div class="row justify-content-between">
                    <div class="col-xl-7 col-lg-8">

                        <!-- Course Details Wrapper Start -->
                        <div class="course-details-wrapper">

                            <!-- Course Overview Start -->
                            <div class="course-overview">
                                <h3 class="title">Rush</h3>
                                <p>Ballard Estate, Mumbai  | 4 km Away</p>
                                <p>₹ 600 for 60 mins for 1 Child + 1 Adult</p>
                                <p><span class="bg-success-text">Open Now </span> | <span class=" bg-danger-text">Closes 7.30pm</span></p>
                            </div>
                            <!-- Course Overview End -->
                            <div class="action_playarea">
                                <button type="button" class="play-btn" href="#" data-bs-toggle="modal" data-bs-target="#exampleModal">Contact</button>
                                <button onclick="window.open('https://goo.gl/maps/ZSnuxgHsn7vgnfb49')" type="button" class="play-btn">Directions</button>
                                <button type="button" class="play-btn">Share</button>
                            </div>
                            


                        </div>
                        <!-- Course Details Wrapper End -->

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
        <h5 class="modal-title" id="exampleModalLabel">Contact</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <p><a href="tel:+919820074277"><i class="flaticon-phone-call"></i> +91 9820074277</a></p>
        <p><a target="_blank" href="https://api.whatsapp.com/send?phone=919820074277&text=Hello" class="whatsapp-button"><i class="fab fa-whatsapp"></i> Send a message</a></p>
        <p><a target="_blank" href="mailto:email@rush.in" class="whatsapp-button"><i class="far fa-envelope"></i> Send an Email</a></p>
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
    <div id="mybutton">
<button class="book_now_play">Book Now</button>
</div>
    <?php include('const/scripts.php'); ?>

</body>

</html>