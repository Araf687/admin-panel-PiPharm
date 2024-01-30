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

    if ( $_SESSION['status'] == "updated admin" ) {
        echo "<script>Swal.fire(
            'Great!',
            'Updated Admin Successfully!',
            'success'
        );
        </script>";
    }
    if ( $_SESSION['status'] == "something went wrong" ) {
        echo "<script>Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: 'Something went wrong!',

          });
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

            <!-- Settings Section Start -->
            <div class="page-body">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-12">
                            <div class="row">
                                <div class="col-sm-12">

                                    <!-- Details Start -->
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="title-header option-title">
                                                <h5>Profile Setting</h5>
                                            </div>
                                            <?php 
                                              $adminType=$_SESSION['loginInfo']["adminType"];
                                              $tableName=$adminType==="pharmacy"?"pharmacy_admin":"admin";
                                              $backendAddress=$adminType==="pharmacy"?"querryCode/pharmacy-code.php" :"querryCode/settingCode.php";
                                              $submitBTN_name=$adminType==="pharmacy"?"updatePharmacy":"updateProfileBtn";

                                            ?>
                                            <form class="theme-form theme-form-2 mega-form" action=<?=$backendAddress?>
                                                method="POST" enctype="multipart/form-data">
                                                <?php
                                                    $admin_id = $_SESSION['loginInfo']["id"];
                                                    settype( $admin_id, "integer" );

                                                    $fetchCatQuerry = "SELECT * FROM ".$tableName." WHERE `id`=$admin_id LIMIT 1";
                                                    $querry_result = mysqli_query( $conn, $fetchCatQuerry );

                                                    if ( $querry_result == true ) {
                                                        $count = mysqli_num_rows( $querry_result );
                                                        $slNo = 1;

                                                        if ( $count>0 ) {
                                                            echo "<tbody>";
                                                            while( $rows = mysqli_fetch_assoc( $querry_result ) ) {
                                                                // $admin_id = $rows['id'];
                                                                $first_name = $rows['first_name'];
                                                                $last_name = $rows['last_name'];
                                                                $admin_email = $rows['admin_email'];
                                                                $phone =$adminType==="pharmacy"? $rows['admin_phone']:$rows['phone'];
                                                                $admin_pass = $rows['admin_pass'];
                                                                $image = $rows['admin_img'];
                                                                $img_src =$image===" "?"":$image ;
                                                                if($img_src!=""){
                                                                  $img_src = $adminType==="pharmacy"?"assets/images/pharmacy_admins/".$image:"assets/images/admins/".$image;
                                                                }

                                                                

                                                ?>
                                                <div class="row">

                                                    <!-- if pharmacy admin update his profile -->
                                                    <input style="display:none;" class="form-control"
                                                        value=<?=$rows["id"]?> type="text" name="pharmacy_id">

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">First Name</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" value="<?php echo $first_name?>"
                                                                type="text" name="firstName"
                                                                placeholder="Enter Your First Name">

                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">Last Name</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="text"
                                                                value="<?php echo $last_name?>" name="lastName"
                                                                placeholder="Enter Your Last Name">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">Phone
                                                            Number</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="number"
                                                                value="<?php echo $phone?>" name="phone"
                                                                placeholder="Enter Your Number">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">Email
                                                            Address</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="email"
                                                                value="<?php echo $admin_email?>"
                                                                name=<?=$adminType==="pharmacy"?"emailAddr":"mail" ?>
                                                                placeholder="Enter Your Email Address">
                                                        </div>
                                                    </div>

                                                    <div class="mb-4 row align-items-center">
                                                        <label
                                                            class="col-sm-2 col-form-label form-label-title">Photo</label>
                                                        <div class="col-sm-6">
                                                            <input class="form-control form-choose"
                                                                onChange="handleChangeFile(event)"
                                                                name=<?=$adminType==="pharmacy"?"admin_img":"img" ?>
                                                                type="file" id="formFileMultiple">
                                                        </div>
                                                        <div class="col-sm-4">
                                                            <img src="<?php echo $img_src;?>" id="admin_img"
                                                                class="img-fluid mt-1" width="50">
                                                        </div>
                                                    </div>

                                                    <!-- <div class="mb-4 row align-items-center">
                                                        <label class="form-label-title col-sm-2 mb-0">Confirm
                                                            Password</label>
                                                        <div class="col-sm-10">
                                                            <input class="form-control" type="password" value=""
                                                                name="confirmPass" onblur="checkMatchedPass(this)"
                                                                placeholder="Enter Your Confirm Passowrd">
                                                            <p class="text-danger bolder" style="display:none;"
                                                                id="passError">Password does not matched</p>
                                                        </div>
                                                    </div> -->
                                                    <div>

                                                        <button name=<?=$submitBTN_name?> id="updateProfileBtn"
                                                            type="submit"
                                                            class="btn theme-bg-color text-white">Update</button>
                                                    </div>
                                                </div>
                                                <?php } } } ?>
                                            </form>
                                        </div>
                                    </div>
                                    <!-- Details End -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <script>
                function checkMatchedPass(e) {
                    let password = e.value;
                    const mainPass = document.getElementById("pass").value;
                    //check the password matched or not
                    if (password === mainPass) {
                        document.getElementById("passError").style.display = "none";
                    } else {
                        document.getElementById("passError").style.display = "block";
                    }

                }

                const handleChangeFile = (event) => {
                    let preview = document.getElementById('admin_img');

                    console.log(event.target.files[0]);
                    preview.src = URL.createObjectURL(event.target.files[0]);
                    preview.onload = function() {
                        URL.revokeObjectURL(preview.src) // free memory
                    }
                }
                </script>

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