<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<?php
if ( isset( $_SESSION['status'] ) ) {
    if ( $_SESSION['status'] == "added" ) {
        echo "<script>Swal.fire(
          'Great!',
          'User Added Successfully!',
          'success'
      );
      </script>";
    }
    else if ( $_SESSION['status'] == "Admin exist" ) {
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Admin already exist!',
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
    unset( $_SESSION['status'] );
}
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include( 'includes/head.php' );
?>

<body>

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
                                    <form action="querryCode/adminCode.php" method="POST" enctype="multipart/form-data"
                                        class="theme-form theme-form-2 mega-form">
                                        <div class="card">
                                            <div class="card-body">
                                                <div class="title-header option-title">
                                                    <h5 class="text-center">Add New Admin</h5>
                                                </div>

                                                <!-- <div class="card-header-1">
                          <h5>Admin Information</h5>
                        </div> -->
                                                <div class="row">
                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-lg-3 col-md-3 mb-0">
                                                            Photo</label>
                                                        <div class="col-md-5 col-lg-5">
                                                            <input class="form-control form-choose"
                                                                onChange="handleChangeFile(event)" name="admin_img"
                                                                type="file" id="formFileMultiple">
                                                        </div>
                                                        <div class="col-md-4 col-lg-4">
                                                            <img src="" id="admin_img" class="img-fluid mt-1"
                                                                width="50">
                                                        </div>

                                                    </div>
                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-lg-3 col-md-3 mb-0">First
                                                            Name</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="firstName" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-lg-3 col-md-3 mb-0">Last
                                                            Name</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="lastName" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4 row align-items-center">
                                                        <label
                                                            class="col-lg-3 col-md-3 col-form-label form-label-title">Email
                                                            Address</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="emailAddr" onChange="isEmailValid(event)"
                                                                class="form-control" type="email">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4 row align-items-center">
                                                        <label
                                                            class="col-lg-3 col-md-3 col-form-label form-label-title">Phone</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="phone" class="form-control" type="text">
                                                        </div>
                                                    </div>
                                                    <div class="mb-4 row align-items-center">
                                                        <label
                                                            class="col-lg-3 col-md-3 col-form-label form-label-title">Password</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input name="pass" id="pass" onChange="checkPass(event)"
                                                                class="form-control" type="password">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label
                                                            class="col-lg-3 col-md-3 col-form-label form-label-title">Confirm
                                                            Password</label>
                                                        <div class="col-md-9 col-lg-9">
                                                            <input class="form-control" name="confirm_pass"
                                                                id="confirmPass" onChange="isPassMatched(event)"
                                                                type="password">
                                                            <p id="notifyMatchPass" class="text-danger"></p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <button name="addAdmin" type="submit"
                                            class="btn ms-auto theme-bg-color my-2 text-white"
                                            style="margin-right:20px;">Add Admin</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- New User End -->
                <script type="text/javascript" src="./assets/js/pages/add-user.js"></script>

                <?php include( 'includes/footer.php' );
?>
            </div>
            <!-- index body end -->
            <script>
            const handleChangeFile = (event) => {
                let preview = document.getElementById('admin_img');

                console.log(event.target.files[0]);
                preview.src = URL.createObjectURL(event.target.files[0]);
                preview.onload = function() {
                    URL.revokeObjectURL(preview.src) // free memory
                }
            }
            </script>


        </div>
        <!-- Page Body End -->
    </div>
    <!-- page-wrapper End-->

    <?php include( 'includes/scripts.php' );?>
</body>

</html>