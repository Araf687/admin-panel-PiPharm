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
      else if ( $_SESSION['status'] == "Deleted Successfully" ) {
          echo "<script>Swal.fire(
                'Great!',
                'User Deleted Successfully!',
                'success'
            );
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
                          <th>Option</th>
                        </tr>
                      </thead>

                      <tbody>
<?php
$admin_id = $_SESSION['loginInfo']["id"];
settype( $admin_id, "integer" );

$fetchUserQuerry = "SELECT * FROM pharmacy_admin WHERE `created_by`=$admin_id";
$querry_result = mysqli_query( $conn, $fetchUserQuerry );

if ( $querry_result == true ) {
    $count = mysqli_num_rows( $querry_result );
    $slNo = 1;

    if ( $count>0 ) {
        echo "<tbody>";
        while( $rows = mysqli_fetch_assoc( $querry_result ) ) {

            // user_name	pharmacy_email	user_type	user_pass
            $pharmacy_id = $rows['id'];
            $pharmacy_firstName = $rows['first_name'];
            $pharmacy_lastName = $rows['last_name'];
            $pharmacy_email = $rows['admin_email'];
            // $user_type = $rows['user_type'];

            ?>
                        <tr>
                          <td class="text-center"><?php echo $pharmacy_firstName." ".$pharmacy_lastName; ?></td>

                          <td><?php echo $pharmacy_email; ?></td>

                          <td>
                            <ul>
                              <li>
                                <a href="<?php echo "edit-pharmacy.php?pharmacy_id=".$pharmacy_id?>">
                                  <i class="ri-pencil-line"></i>
                                </a>
                              </li>

                              <li>
                                <a href="javascript:void(0)" onClick="<?php echo "del_user( ".$pharmacy_id." )"; ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                                  <i class="ri-delete-bin-line"></i>
                                </a>
                              </li>
                            </ul>
                          </td>
                        </tr>
<?php } } } ?>
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
