<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include( 'includes/head.php' );
?>

<body>
<?php
if ( isset( $_SESSION['status'] ) ) {
    if ( $_SESSION['status'] == "updated" ) {
        echo "<script>Swal.fire(
          'Great!',
          'User Updated Successfully!',
          'success'
      );
      </script>";
    }
    else if ( $_SESSION['status'] == "password does not match" ) {
        echo "<script>Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        })
      </script>";
    }
    else if ( $_SESSION['status'] == "wrong" ) {
        echo "<script>Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Something went wrong!',
        })
      </script>";
    }
    else if ( $_SESSION['status'] == "Pharmacy exist" ) {
        echo "<script>Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Email already exist!',
        })
      </script>";
    }
    unset( $_SESSION['status'] );
}
?>

    <!-- tap on top start -->
    <div class="tap-top">
        <span class="lnr lnr-chevron-up"></span>
    </div>
    <!-- tap on tap end -->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include( 'includes/header.php' );
?>

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <?php include( 'includes/sidebar.php' );
?>

            <!-- Page Sidebar Start -->
            <div class="page-body">
                <!-- New User start -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-8 m-auto">
                                    <form action="querryCode/pharmacy-code.php" method="POST"
                                        class="theme-form theme-form-2 mega-form">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="title-header option-title">
                                                    <h5>Edit User</h5>
                                                </div>
                                                <div class="card-header-1">
                                                    <h5>User Information</h5>
                                                </div>

                                                <?php
                                                    $pharmacy_id = $_GET['pharmacy_id'];
                                                    settype( $cat_id, "integer" );
                                                    $fetchCatQuerry = "SELECT * FROM pharmacy_admin WHERE id= $pharmacy_id LIMIT 1";
                                                    $querry_result = mysqli_query( $conn, $fetchCatQuerry );

                                                    if ( $querry_result == true ) {
                                                        $count = mysqli_num_rows( $querry_result );
                                                        $slNo = 1;

                                                        if ( $count>0 ) {
                                                            echo "<tbody>";
                                                            while( $rows = mysqli_fetch_assoc( $querry_result ) ) {
                                                                $pharmacy_firstName = $rows['first_name'];
                                                                $pharmacy_lastName = $rows['last_name'];

                                                                $pharmacy_email = $rows['admin_email'];
                                                                $admin_type = $rows['admin_type'];
                                                                $admin_pass = $rows['admin_pass'];
                                                                $phone = $rows['admin_phone'];
                                                                $pharmacy_pass=$rows['admin_pass'];

                                                ?>
                                                <div class="row">
                                                    <div class="mb-4 row align-items-center">
                                                        <input type="text" name="pharmacy_id" value="<?php echo $pharmacy_id;?>"
                                                            style="display:none;">
                                                        <label class="form-label-title col-lg-3 col-md-3 mb-0">First
                                                            Name</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="firstName"
                                                                value="<?php echo $pharmacy_firstName;?>"
                                                                class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-lg-3 col-md-3 mb-0">Last
                                                            Name</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="lastName" value="<?php echo $pharmacy_lastName;?>"
                                                                class="form-control" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label
                                                            class="col-lg-3 col-md-3 col-form-label form-label-title">Email
                                                            Address</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="emailAddr" value="<?php echo $pharmacy_email;?>"
                                                                onChange="isEmailValid(event)" class="form-control"
                                                                type="email">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4 row align-items-center">
                                                        <label
                                                            class="col-lg-3 col-md-3 col-form-label form-label-title">Phone</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="phone" value="<?php echo $phone;?>"
                                                                class="form-control" type="text">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label
                                                            class="col-lg-3 col-md-3 col-form-label form-label-title">Password</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="pass" id="pass" value=<?=$pharmacy_pass?>
                                                                onChange="checkPass(event)" class="form-control"
                                                                type="password">
                                                        </div>
                                                    </div>

                                                    <div class="row align-items-center">
                                                        <label
                                                            class="col-lg-3 col-md-3 col-form-label form-label-title">Confirm
                                                            Password</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input class="form-control" name="confirm_pass" value=""
                                                                id="confirmPass" onChange="isPassMatched(event)"
                                                                type="password">
                                                            <p id="notifyMatchPass" class="text-danger"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php } } } ?>
                                            </div>
                                        </div>
                                        <button name="updatePharmacy" type="submit"
                                            class="btn ms-auto theme-bg-color my-2 text-white"
                                            style="margin-right:20px;">Update Pharmacy</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- New User End -->
                <script type="text/javascript" src="./assets/js/pages/edit-user.js"></script>

                <?php include( 'includes/footer.php' );
?>
            </div>
            <!-- index body end -->

        </div>
        <!-- Page Body End -->
    </div>
    <!-- page-wrapper End-->

    <?php include( 'includes/scripts.php' );
?>
</body>

</html>