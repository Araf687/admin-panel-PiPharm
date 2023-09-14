<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
  <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
  <title>Order Management System</title>
  
  <!-- Google font-->
  <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

  <!-- Linear Icon css -->
  <link rel="stylesheet" href="assets/css/linearicon.css">

  <!-- fontawesome css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/font-awesome.css">

  <!-- Themify icon css-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/themify.css">

  <!-- ratio css -->
  <link rel="stylesheet" type="text/css" href="assets/css/ratio.css">

  <!-- remixicon css -->
  <link rel="stylesheet" type="text/css" href="assets/css/remixicon.css">

  <!-- Feather icon css-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/feather-icon.css">

  <!-- Plugins css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/scrollbar.css">
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/animate.css">

  <!-- Bootstrap css-->
  <link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">

  <!-- vector map css -->
  <link rel="stylesheet" type="text/css" href="assets/css/vector-map.css">

  <!-- Slick Slider Css -->
  <link rel="stylesheet" href="assets/css/vendors/slick.css">

  <!-- App css -->
  <link rel="stylesheet" type="text/css" href="assets/css/style.css">

  <!-- Main css -->
  <link rel="stylesheet" type="text/css" href="assets/css/main.css">

  <!-- sweet alert script -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>

  <!-- ajax link -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
</head>
<?php
session_start();
if(!$_SESSION['loginInfo']["id"]){
  header("Location: login.php");
}
?>