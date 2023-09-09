<?php // Load the database configuration file
include_once 'dbConfig.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Music web</title>
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
    <link rel="stylesheet" href="node_modules/mdbootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/mdbootstrap/css/mdb.min.css">
    <link rel="stylesheet" href="node_modules/mdbootstrap/css/style.css">
    <link rel="stylesheet" href="node_modules/global/global.css">
</head>
<body class="main-wrapper">
   <!--Navbar -->
<nav class="mb-1 navbar navbar-expand-lg navbar-dark primary-color lighten-1">
  <a class="navbar-brand" href="index.php">LOGO</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent-555"
    aria-controls="navbarSupportedContent-555" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent-555">
    
    <ul class="navbar-nav ml-auto nav-flex-icons">
      <li class="nav-item avatar">
        <a class="nav-link p-0" href="#">
          <img src="https://mdbootstrap.com/img/Photos/Avatars/avatar-5.webp" class="rounded-circle z-depth-0"
            alt="avatar image" height="35">
        </a>
      </li>
    </ul>
  </div>
</nav>
<!--/.Navbar -->
<div class="container mt-5">
    <section class="title-section">
        <h3 class="main-title d-inline">Artists list <a href="add_artist.php" class="btn btn-sm bg-1 text-white d-inline float-right"><i class="fas fa-plus"></i></a></h2>
    </section>
    
    <section class="card w-100 ">
        <table id="dtBasicExample" class="table" width="100%">
        <tbody>
        <?php
        // Get member rows
        $getSongs = $db->query("SELECT * FROM tbl_artist ORDER BY id DESC");
        if($getSongs->num_rows > 0){
            while($row = $getSongs->fetch_assoc()){
        ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td class="float-right">
                    <div class="button-icon-action d-inline"><i class="fas fa-edit"></i></div>
                    <div class="button-icon-action d-inline"><i class="fas fa-trash"></i></div>
                </td>
            </tr>
            <?php } }else{ ?>
            <tr><td colspan="5">No Artist(s) found...</td></tr>
        <?php } ?>
        </tbody>
        </table>
    </section>
</div>    

<!-- <img src="Artist screen.png" alt="mdb logo"> -->
</body>
<script type="text/javascript" src="node_modules/mdbootstrap/js/jquery.min.js"></script>
<script type="text/javascript" src="node_modules/mdbootstrap/js/popper.min.js"></script>
<script type="text/javascript" src="node_modules/mdbootstrap/js/bootstrap.min.js"></script>
<script type="text/javascript" src="node_modules/mdbootstrap/js/mdb.min.js"></script>
<script>
$('#dtBasicExample').mdbEditor({
  mdbEditor: true
});
$('.dataTables_length').addClass('bs-select');
</script>
</html>