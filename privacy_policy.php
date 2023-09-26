
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

       

       <!-- Faq Start -->
       <div class="section faq-section section-padding mt-5">
            <div class="container">
                <div class="faq-wrapper">
                <div>
                    <?php echo file_get_contents('Privacy Policy.html');?>
                </div>

                </div>
            </div>
        </div>
        <!-- Faq End -->
        
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

    <?php include('const/scripts.php'); ?>

</body>

</html>