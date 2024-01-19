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
    } else if ($_SESSION['status'] == "password does not match") {
      echo "<script>Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!',
      })
    </script>";
    } else if ($_SESSION['status'] == "wrong") {
      echo "<script>Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Something went wrong!',
      })
    </script>";
    } else if ($_SESSION['status'] == "Deleted Successfully") {
      echo "<script>Swal.fire(
                'Great!',
                'User Deleted Successfully!',
                'success'
            );
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

      <!-- Container-fluid starts-->
      <div class="page-body">
        <!-- All User Table Start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-body">
                  <div class="title-header option-title">
                    <h5>All Users</h5>
                    <form class="d-inline-flex">
                      <a href="add-pharmacy.php" class="align-items-center btn btn-theme d-flex">
                        <i data-feather="plus"></i>Add New
                      </a>
                    </form>
                  </div>

                  <div class="table-responsive table-product">
                    <table class="table all-package theme-table" id="table_id">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Email</th>
                          <th>Status</th>
                          <th>Option</th>
                        </tr>
                      </thead>

                      <tbody>
                        <?php
                        $admin_id = $_SESSION['loginInfo']["id"];
                        settype($admin_id, "integer");

                        $fetchUserQuerry = "SELECT * FROM pharmacy_admin WHERE `created_by`=$admin_id";
                        $query_result = mysqli_query($conn, $fetchUserQuerry);

                        if ($query_result == true) {
                          $count = mysqli_num_rows($query_result);
                          $slNo = 1;

                          if ($count > 0) {
                            echo "<tbody>";
                            while ($rows = mysqli_fetch_assoc($query_result)) {

                              // user_name	pharmacy_email	user_type	user_pass
                              $pharmacy_id = $rows['id'];
                              $pharmacy_firstName = $rows['first_name'];
                              $pharmacy_lastName = $rows['last_name'];
                              $pharmacy_email = $rows['admin_email'];
                              $status = $rows['status'];
                              // $user_type = $rows['user_type'];
                              $pharmacy_admin_name = $pharmacy_firstName . " " . $pharmacy_lastName;

                              ?>
                              <tr>
                                <td class="text-center">
                                  <?php echo $pharmacy_firstName . " " . $pharmacy_lastName; ?>
                                </td>

                                <td>
                                  <?php echo $pharmacy_email; ?>
                                </td>
                                <td id=<?=$pharmacy_id."_status"?>>
                                  <?php echo $status; ?>
                                </td>

                                <td>
                                  <ul>
                                    <li>
                                      <a href="<?php echo "edit-pharmacy.php?pharmacy_id=" . $pharmacy_id ?>">
                                        <i class="ri-pencil-line"></i>
                                      </a>
                                    </li>

                                    <li>
                                      <a href="javascript:void(0)" onClick="<?php echo "del_user( " . $pharmacy_id . " )"; ?>"
                                        data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                                        <i class="ri-delete-bin-line"></i>
                                      </a>
                                    </li>
                                    <li>
                                      <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#blockUserModal"
                                        data-toggle="tooltip" data-placement="top" title="Change Pharmacy Status"
                                        onclick="<?= "handleClickBlockUser($pharmacy_id, '$status', '$pharmacy_admin_name')" ?>">
                                        <i class="ri-arrow-up-down-line"></i>
                                      </a>
                                    </li>
                                  </ul>
                                </td>
                              </tr>
                            <?php }
                          }
                        } ?>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- All User Table Ends-->
        <script>
          const del_user = (pharmacyId) => {
            console.log(pharmacyId);
            sessionStorage.setItem("tableName", "Pharmacy_admin");
            sessionStorage.setItem("del_id", pharmacyId);

          }
          const handleClickBlockUser = (pharmacyAdminId, status, pharmacyAdminName) => {
            const newStatus = (status == 'active' || status == 'Active') ? 'Inactive' : 'Active';
            const changeStatusModalText = "You want to " + newStatus + " " + pharmacyAdminName + "?";
            $('#changeStatusModalText').text(changeStatusModalText);
            $('#hiddenUserId').val(pharmacyAdminId);
            $('#hiddenUserNewStatus').val(newStatus);
          }

          const confirmBlockUser = () => {
            // Get the value from the input using val()
            var userId = $("#hiddenUserId").val();
            var newStatus = $("#hiddenUserNewStatus").val();
            $.ajax({
              type: "POST",
              url: "querryCode/blockPharmacyAdmin.php",
              data: { pharmacy_admin_id: userId, status: newStatus },
              success: function (response) {
                console.log(response);
                // Handle the response from the server
                const res = JSON.parse(response);

                if (res.isSuccess) {
                  console.log(`#${userId}_status`);

                  $("#hiddenConfirmBTN").click();
                  $(`#${userId}_status`).text(newStatus);

                } else {
                 console.log("failed to change status")
                }
              },
            });


          }

        </script>

        <?php include('includes/footer.php');
        ?>
      </div>
      <!-- index body end -->

    </div>
    <!-- Page Body End -->
  </div>
  <!-- page-wrapper End-->

  <!-- modal for block user  -->
  <div class="modal fade theme-modal remove-coupon" id="blockUserModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header d-block text-center">
          <h5 class="modal-title w-100" id="exampleModalLabel22">Are You Sure ?</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="remove-box">
            <p id="changeStatusModalText"></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
          <button type="button" class="btn btn-animation btn-md fw-bold" onclick="confirmBlockUser()">Yes</button>

          <!-- hidden input  -->
          <input type="number" class="d-none" id="hiddenUserId">
          <input type="text" class="d-none" id="hiddenUserNewStatus">
          <button type="button" class="btn btn-animation btn-md fw-bold d-none" data-bs-target="#confirmationModal"
            data-bs-toggle="modal" data-bs-dismiss="modal" id="hiddenConfirmBTN">Yes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- confirmation modal of block user  -->
  <div class="modal fade theme-modal remove-coupon" id="confirmationModal" aria-hidden="true" tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title text-center" id="exampleModalLabel12">Done!</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
            <i class="fas fa-times"></i>
          </button>
        </div>
        <div class="modal-body">
          <div class="remove-box text-center">
            <div class="wrapper">
              <svg class="checkmark" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 52 52">
                <circle class="checkmark__circle" cx="26" cy="26" r="25" fill="none" />
                <path class="checkmark__check" fill="none" d="M14.1 27.2l7.1 7.2 16.7-16.8" />
              </svg>
            </div>
            <h4 class="text-content"><span id="blockUserName"></span> Has been blocked</h4>
          </div>
        </div>
        <div class="modal-footer">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  <?php include('includes/scripts.php');
  ?>
</body>

</html>