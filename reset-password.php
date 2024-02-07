<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php
include('includes/head.php');

?>

<body>
    <?php
    if (isset($_SESSION['status'])) {

        if ($_SESSION['status'] == "Added Successfully") {
            echo "<script>Swal.fire(
          'Great!',
          'Added Successfully!',
          'success'
      );
      </script>";
        }
        if ($_SESSION['status'] == "Data already exist") {
            echo "<script>
      Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Failed to add Category!',
          footer: 'Data already exist'
        })
      </script>";
        }
        unset($_SESSION['status']);
    }
    ?>
    <!-- tap on top start -->
    <div class="tap-top">
        <span class="lnr lnr-chevron-up"></span>
    </div>
    <!-- tap on tap end -->

    <!-- page-wrapper Start-->
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <?php include('includes/header.php');
        ?>

        <!-- Page Body Start-->
        <div class="page-body-wrapper">
            <?php include('includes/sidebar.php');
            ?>

            <div class="page-body">

                <!-- Reset Password Start -->
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-8 m-auto">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="card-header-2">
                                                <h5>Reset Password</h5>
                                            </div>

                                            <form class="theme-form theme-form-2 mega-form"
                                                id="reset-user-password-form" method="POST">
                                                <input type="text" name='user_id'
                                                    value='<?= $_SESSION['loginInfo']['id'] ?>' class="d-none">
                                                <input type="text" name='user_type'
                                                    value='<?= $_SESSION['loginInfo']['adminType'] ?>' class="d-none">
                                                <div class="mb-4 row align-items-center">
                                                    <label class="form-label-title col-sm-3 mb-0">Current
                                                        Password</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="password"
                                                            name="current_password" placeholder="Current Password"
                                                            required onchange="validateForm()">
                                                    </div>
                                                </div>
                                                <div class="mb-4 row align-items-center">
                                                    <label class="form-label-title col-sm-3 mb-0">New Password</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" id="newPassword" type="password"
                                                            name="new_password" placeholder="New Password" required
                                                            onchange="validateForm()">
                                                    </div>
                                                </div>
                                                <div class="mb-4 row align-items-center">
                                                    <label class="form-label-title col-sm-3 mb-0">Confirm
                                                        Password</label>
                                                    <div class="col-sm-9">
                                                        <input class="form-control" type="password"
                                                            name="confirm_password" placeholder="Confirm Password"
                                                            id="confirmPassword" required>
                                                        <p class="text-danger" id="errorMessage"></p>
                                                    </div>

                                                </div>


                                                <button type="submit" name="resetPassword"
                                                    class="btn ms-auto theme-bg-color text-white">Reset
                                                    Password</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Reset Password End -->


                <?php include('includes/footer.php');
                ?>
            </div>
            <!-- index body end -->

        </div>
        <!-- Page Body End -->
    </div>
    <!-- page-wrapper End-->

    <script>
        function validateForm() {
            var newPassword = document.getElementById('newPassword').value;
            var confirmPassword = document.getElementById('confirmPassword').value;
            var errorMessage = document.getElementById('errorMessage');

            if (newPassword != "" && confirmPassword != "" && newPassword !== confirmPassword) {

                errorMessage.innerHTML = "Passwords do not match!";
                return false; // Prevent form submission
            } else {
                errorMessage.innerHTML = "";
                return true; // Allow form submission
            }
        }

        $(document).ready(function () {

            let request;

            $("#reset-user-password-form").submit(function (event) {
                event.preventDefault();
                if (request) {
                    request.abort();
                }
                if (validateForm()) {
                    var $form = $(this);
                    var serializedData = $form.serialize();

                    request = $.ajax({
                        url: "querryCode/reset/reset-user-password-code.php",
                        type: "post",
                        data: serializedData,
                    });

                    request.done(function (response, textStatus, jqXHR) {
                        console.log(response);
                        // console.log($.parseJSON(response));
                        const jsonData = $.parseJSON(response);

                        if (jsonData?.isSuccess) {

                            Swal.fire({
                                title: "Good job!",
                                text: "Password Reset Successfully",
                                icon: "success"
                            });
                        } else {

                            Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Failed reset user password",
                            });
                        }
                    });

                    request.fail(function (jqXHR, textStatus, errorThrown) {
                        console.error("The following error occurred: " + textStatus, errorThrown);
                        Swal.fire({
                            icon: "error",
                            title: "Oops...",
                            text: "Something went wrong!",
                        });
                    });
                    request.always(function () { });
                }
                else{
                    Swal.fire({
                                icon: "error",
                                title: "Oops...",
                                text: "Password Does not matched",
                            });
                }



            });
        })
    </script>

    <?php include('includes/scripts.php');
    ?>
</body>

</html>