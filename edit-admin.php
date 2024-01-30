<?php
include 'config/session.php';
include 'config/dbConn.php';
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php');
?>

<body>
    <?php
    if (isset($_SESSION['status'])) {
        if ($_SESSION['status'] == "updated") {
            echo "<script>Swal.fire(
                'Great!',
                'User Updated Successfully!',
                'success'
            );
            </script>";
        } else if ($_SESSION['status'] == "Admin exist") {
            echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Admin already exist!',
                })
            </script>";
        } else if ($_SESSION['status'] == "wrong") {
            echo "<script>Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
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
                                            <?php
                                            $adminId = isset($_GET['admin_id']) ? $_GET['admin_id'] : null;

                                            $sql = "SELECT id,first_name,last_name,admin_email,phone,admin_img,admin_type From admin WHERE id=$adminId LIMIT 1";
                                            $result = mysqli_query($conn, $sql);
                                            if ($result) {
                                                $row = mysqli_fetch_assoc($result);
                                                $admin_id = $row['id'];
                                                $first_name = $row['first_name'];
                                                $last_name = $row['last_name'];
                                                $admin_email = $row['admin_email'];
                                                $phone = $row['phone'];
                                                $admin_img = $row['admin_img'];
                                                $admin_type = $row['admin_type'];

                                                $image_src='assets/images/admins/'.$admin_img;
                                                ?>
                                                <div class="card-body">
                                                    <div class="title-header option-title">
                                                        <h5 class="text-center">Edit Admin</h5>
                                                    </div>

                                                    <div class="row">
                                                        <input type="number" name='admin_id' value='<?=$admin_id?>' class="d-none">
                                                        <div class="mb-4 row align-items-center">
                                                            <label class="form-label-title col-lg-3 col-md-3 mb-0">
                                                                Photo</label>
                                                            <div class="col-md-5 col-lg-5">
                                                                <input class="form-control form-choose"
                                                                    onChange="handleChangeFile(event)" name="admin_img"
                                                                    type="file" id="formFileMultiple">
                                                            </div>
                                                            <div class="col-md-4 col-lg-4">
                                                                <img src='<?=$image_src?>' id="admin_img" class="img-fluid mt-1"
                                                                    width="50">
                                                            </div>

                                                        </div>
                                                        <div class="mb-4 row align-items-center">
                                                            <label class="form-label-title col-lg-3 col-md-3 mb-0">First
                                                                Name</label>
                                                            <div class="col-md-9 col-lg-9">
                                                                <input name="firstName" class="form-control" type="text" value='<?=$first_name?>'>
                                                            </div>
                                                        </div>
                                                        <div class="mb-4 row align-items-center">
                                                            <label class="form-label-title col-lg-3 col-md-3 mb-0">Last
                                                                Name</label>
                                                            <div class="col-md-9 col-lg-9">
                                                                <input name="lastName" class="form-control" type="text" value='<?=$last_name?>'>
                                                            </div>
                                                        </div>
                                                        <div class="mb-4 row align-items-center">
                                                            <label
                                                                class="col-lg-3 col-md-3 col-form-label form-label-title">Email
                                                                Address</label>
                                                            <div class="col-md-9 col-lg-9">
                                                                <input name="emailAddr" onChange="isEmailValid(event)"
                                                                    class="form-control" type="email" value='<?=$admin_email?>'>
                                                            </div>
                                                        </div>
                                                        <div class="mb-4 row align-items-center">
                                                            <label
                                                                class="col-lg-3 col-md-3 col-form-label form-label-title">Phone</label>
                                                            <div class="col-md-9 col-lg-9">
                                                                <input name="phone" class="form-control" type="text" value='<?=$phone?>'>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php
                                            } else {
                                                echo "<div class='p-4 d-flex justify-content-center align-items-center' style='min-height:300px'><h3>Invalid Admin Id</h3></div>";
                                            }
                                            ?>

                                        </div>

                                        <button name="editAdmin" type="submit"
                                            class="btn ms-auto theme-bg-color my-2 text-white"
                                            style="margin-right:20px;">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- New User End -->
                <script type="text/javascript" src="./assets/js/pages/add-user.js"></script>

                <?php include('includes/footer.php');
                ?>
            </div>
            <!-- index body end -->
            <script>
                const handleChangeFile = (event) => {
                    let preview = document.getElementById('admin_img');

                    console.log(event.target.files[0]);
                    preview.src = URL.createObjectURL(event.target.files[0]);
                    preview.onload = function () {
                        URL.revokeObjectURL(preview.src) // free memory
                    }
                }
            </script>


        </div>
        <!-- Page Body End -->
    </div>
    <!-- page-wrapper End-->

    <?php include('includes/scripts.php');
    ?>
</body>

</html>