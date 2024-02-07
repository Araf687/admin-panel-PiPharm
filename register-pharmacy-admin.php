<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/images/favicon/medicine.png" type="image/x-icon">
    <link rel="shortcut icon" href="assets/images/favicon/medicine.png" type="image/x-icon">
    <title>PiPharma Admin Panel</title>

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
    session_start();
    if (isset($_SESSION['status'])) {

        if ($_SESSION['status'] == "Failed") {
            echo "<script>
                    Swal.fire({
                    icon: 'error',
                    title: 'Failed to register pharmacy',
                    
                    })
                </script>";
        }
        if ($_SESSION['status'] == "added") {
            echo "<script>
            Swal.fire({
                title: 'Good job!',
                text: 'Registered Successfully!',
                icon: 'success'
              });
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
                            <form action="querryCode/registerPharmacyCode.php" method="POST" class="row g-3">
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="text" class="form-control" name="pharmacy_admin_first_name"
                                            placeholder="First Name">
                                        <label for="admin_name">First Name</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="text" class="form-control" name="pharmacy_admin_last_name"
                                            placeholder="Last Name">
                                        <label for="admin_name">Last Name</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="text" class="form-control" name="pharmacy_name"
                                            placeholder="Pharmacy Name">
                                        <label for="pharmacy_name">Pharmacy Name</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" class="form-control" name="pharmacy_email_id" id="email"
                                            placeholder="Pharmacy Email Address">
                                        <label for="email">Email</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="password" name="password" class="form-control" id="password"
                                            placeholder="Password" onblur="checkPassword()">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="password" name="confirm_pass" class="form-control" id="confirm_password"
                                            placeholder="Confirm Password" onblur="checkPassword()">
                                        <label for="confirm_password">Confirm Password</label>
                                    </div>
                                    <p id="passErrorMessage" class="text-danger d-none">Password does not match!</p>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center"
                                        name="registerPharmacyButton" type="submit">Submit</button>
                                </div>
                                <div class="col-12" id="registerPharmacyOption">
                                    <p>Already registered? <a href="login.php"><strong class="text-primary">Login to
                                                your account</strong> </a></p>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- login section end -->
    <script>
        function checkPasswords() {
            // Get the values of the password and confirm password fields
            var password = document.getElementById("password").value;
            var confirmPassword = document.getElementById("confirm_password").value;

            // Check if the passwords match
            if (password != confirmPassword && password!) {
                event.preventDefault();
                document.getElementById("passErrorMessage").classList.remove("d-none");

            }
        }
    </script>


</body>

</html>