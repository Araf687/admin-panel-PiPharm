<?php
include 'config/session.php';
include 'config/dbConn.php';
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
                  <form action="querryCode/userCode.php" method="POST" class="theme-form theme-form-2 mega-form">
                    <div class="card">
                      <div class="card-body">
                        <div class="title-header option-title">
                          <h5>Edit User</h5>
                        </div>
                        <div class="card-header-1">
                          <h5>User Information</h5>
                        </div>

<?php
$user_id = $_GET['user_id'];
settype( $cat_id, "integer" );
$fetchCatQuerry = "SELECT * FROM user WHERE id= $user_id LIMIT 1";
$querry_result = mysqli_query( $conn, $fetchCatQuerry );

if ( $querry_result == true ) {
    $count = mysqli_num_rows( $querry_result );
    $slNo = 1;

    if ( $count>0 ) {
        echo "<tbody>";
        while( $rows = mysqli_fetch_assoc( $querry_result ) ) {
            $user_firstName = $rows['first_name'];
            $user_lastName = $rows['last_name'];

            $user_email = $rows['user_email'];
            $user_type = $rows['user_type'];
            $user_pass = $rows['user_pass'];
            $phone = $rows['user_phone'];

            ?>
                        <div class="row">
                          <div class="mb-4 row align-items-center">
                            <input type="text" name="user_id" value="<?php echo $user_id;?>" style="display:none;">
                            <label class="form-label-title col-lg-3 col-md-3 mb-0">First Name</label>
                            <div class="col-md-9 col-lg-9">
                              <input name="firstName" value="<?php echo $user_firstName;?>" class="form-control" type="text">
                            </div>
                          </div>
                          <div class="mb-4 row align-items-center">
                            <label class="form-label-title col-lg-3 col-md-3 mb-0">Last
                              Name</label>
                            <div class="col-md-9 col-lg-9">
                              <input name="lastName" value="<?php echo $user_lastName;?>" class="form-control" type="text">
                            </div>
                          </div>

                          <div class="mb-4 row align-items-center">
                            <label class="col-lg-3 col-md-3 col-form-label form-label-title">Email
                              Address</label>
                            <div class="col-md-9 col-lg-9">
                              <input name="emailAddr" value="<?php echo $user_email;?>" onChange="isEmailValid(event)" class="form-control" type="email">
                            </div>
                          </div>
                          <div class="mb-4 row align-items-center">
                            <label class="col-lg-3 col-md-3 col-form-label form-label-title">Phone</label>
                            <div class="col-md-9 col-lg-9">
                              <input name="phone" value="<?php echo $phone;?>" class="form-control" type="text">
                            </div>
                          </div>

                          <div class="mb-4 row align-items-center">
                            <label class="col-lg-3 col-md-3 col-form-label form-label-title">Password</label>
                            <div class="col-md-9 col-lg-9">
                              <input name="pass" id="pass" value="" onChange="checkPass(event)" class="form-control" type="password">
                            </div>
                          </div>

                          <div class="row align-items-center">
                            <label class="col-lg-3 col-md-3 col-form-label form-label-title">Confirm
                              Password</label>
                            <div class="col-md-9 col-lg-9">
                              <input class="form-control" name="confirm_pass" value="" id="confirmPass" onChange="isPassMatched(event)" type="password">
                              <p id="notifyMatchPass" class="text-danger"></p>
                            </div>
                          </div>
                        </div>
<?php } } } ?>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-body">
                        <div class="title-header option-title">
                          <h5>User Address</h5>
                        </div>
                        <div id="allAddresses">
        <?php
        $user_id = $_GET['user_id'];
        settype( $cat_id, "integer" );
        $fetchCatQuerry = "SELECT * FROM user_address WHERE user_id=$user_id";
        $querry_result = mysqli_query( $conn, $fetchCatQuerry );

        if ( $querry_result == true ) {
            $count = mysqli_num_rows( $querry_result );
            $slNo = 1;
            // <!-- //hidden input to send number of address data in the backend -->
            echo "<input type='number' style='display:none;
            '  value='$count' id='addresses' name='noOfAddress'>";
            if ( $count>0 ) {
                echo "<tbody>";
                while( $rows = mysqli_fetch_assoc( $querry_result ) ) {
                    $mainAddr = $rows['address'];
                    $city = $rows['city'];

                    $state = $rows['state'];
                    $country = $rows['country'];
                    $zip_code = $rows['zip_code'];

                    ?>
                          <div class="mb-5 row align-items-center" id="address1">
                            <label class="form-label-title col-lg-2 col-md-3 mb-0">Address</label>
                            <div class="col-md-9 col-lg-9">
                              <div class="mb-3">
                                <label></label>
                                <input name="<?php echo "addr$slNo"."_main"?>" value="<?php echo $mainAddr;?>" class="form-control" type="text">
                              </div>
                              <div class="row">
                                <div class="col-md-6 col-lg-6 mb-2">
                                  <label>City</label>
                                  <input name="<?php echo "addr$slNo"."_city"?>" value="<?php echo $city;?>" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2">
                                  <label>State</label>
                                  <input name="<?php echo "addr$slNo"."_state"?>" value="<?php echo $state;?>" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2">
                                  <label>Country</label>
                                  <input name="<?php echo "addr$slNo"."_country"?>" value="<?php echo $country;?>" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2">
                                  <label>Zip Code</label>
                                  <input name="<?php echo "addr$slNo"."_zip"?>" value="<?php echo $zip_code;?>" class="form-control" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-1">
                              <i class="ri-close-fill text-danger cancelIcon" onclick="deleteAddress(this.parentElement)" style="cursor:pointer;font-weight: bolder;"></i>
                            </div>
                          </div>

            <?php
            $slNo++;
            }
            } else {
            ?>

                          <!-- //hidden input to send number of address data in the backend -->
                          <input type="number" value=1 style="display:none" id="addresses" name="noOfAddress">
                          <div class="mb-5 row align-items-center" id="address1">
                            <label class="form-label-title col-lg-2 col-md-3 mb-0">Address</label>
                            <div class="col-md-9 col-lg-9">
                              <div class="mb-3">
                                <label>Street Address</label>
                                <input name="addr1_main" class="form-control" type="text">
                              </div>
                              <div class="row">
                                <div class="col-md-6 col-lg-6 mb-2">
                                  <label>City</label>
                                  <input name="addr1_city" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2">
                                  <label>State</label>
                                  <input name="addr1_state" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2">
                                  <label>Country</label>
                                  <input name="addr1_country" class="form-control" type="text">
                                </div>
                                <div class="col-md-6 col-lg-6 mb-2">
                                  <label>Zip Code</label>
                                  <input name="addr1_zip" class="form-control" type="text">
                                </div>
                              </div>
                            </div>
                            <div class="col-sm-1">
                              <i class="ri-close-fill text-danger cancelIcon" onclick="deleteAddress(this.parentElement)" style="cursor:pointer;font-weight: bolder;"></i>
                            </div>
                          </div>
<?php } } ?>
                        </div>

                        <span onclick="addAddress()" class="add-option" style="cursor:pointer"><i class="ri-add-line me-2"></i> Add Another Address</span>
                      </div>
                    </div>
                    <button name="UpdateUser" type="submit" class="btn ms-auto theme-bg-color my-2 text-white" style="margin-right:20px;">Update User</button>
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
