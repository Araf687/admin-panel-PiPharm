<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/favicon.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon.png" type="image/x-icon">
    <title>Order Management System</title>

    <!-- Google font-->
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">

    <!-- Bootstrap css -->
    <link rel="stylesheet" type="text/css" href="assets/css/vendors/bootstrap.css">

    <!-- sweet alert script -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.24/sweetalert2.all.js"></script>

    <!-- App css -->
    <link rel="stylesheet" type="text/css" href="assets/css/style.css">
</head>

<body>

    <?php
if(isset($_SESSION['status']))
{
  
  if($_SESSION['status']=="Failed to log in"){
    echo "<script>
    Swal.fire({
      icon: 'error',
      title: 'Failed to log in',
      text: 'Invaid Id or Password',
    })
    </script>";
  }
  unset($_SESSION['status']);
}
?>

    <!-- login section start -->
    <section class="log-in-section section-b-space">
        <a href="" class="logo-login"><img src="assets/images/logo/piPharm.png" style="border-radius:5px"
                class="img-fluid"></a>
        <div class="container w-100">
            <div class="row">

                <div class="col-xl-5 col-lg-6 me-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3>Welcome To Admin Panel</h3>
                            <h4>Login Your Account</h4>
                        </div>

                        <div class="input-box">
                            <form action="querryCode/loginCode.php" method="POST" class="row g-4">
                                <div class="mb-3">
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="loginType" style="width:16px"
                                            id="inlineRadio1" value="authority" checked>
                                        <label class="form-check-label" for="inlineRadio1">Authority Admin</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" style="width:16px" name="loginType"
                                            id="inlineRadio2" value="pharmacy">
                                        <label class="form-check-label" for="inlineRadio2">Pharmacy</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" class="form-control" name="email_id" id="email"
                                            placeholder="Email Address">
                                        <label for="email">Email</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="password" name="pass" class="form-control" id="password"
                                            placeholder="Password">
                                        <label for="password">Password</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center" name="loginBTN"
                                        type="submit">Login</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login section end -->

</body>

</html>