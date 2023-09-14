<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include( 'includes/head.php' );
?>
<?php
// echo $_SESSION['status'];

if ( isset( $_SESSION['status'] ) ) {
    if ( $_SESSION['status'] == "Added Successfully" ) {
        echo "<script>Swal.fire(
        'Great!',
        'Attribute Added Successfully!',
        'success'
    );
    </script>";
    } else if ( $_SESSION['status'] == "Updated Successfully" ) {
        echo "<script>Swal.fire(
        'Great!',
        'Attribute Updated Successfully!',
        'success'
    );
    </script>";
    } else if ( $_SESSION['status'] == "Empty attribute" ) {
        echo "<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: 'Failed to Proceed!',
        footer: '<strong>Empty attribute name or value. Please fill the form correctly</strong>'
      })
    </script>";
    }
    unset( $_SESSION['status'] );
}
?>
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

      <!-- Container-fluid starts-->
      <div class="page-body">
        <!-- All User Table Start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-body">
                  <div class="title-header option-title">
                    <h5>All Attributes</h5>
                    <form class="d-inline-flex">
                      <a href="add-attribute.php" class="align-items-center btn btn-theme d-flex">
                        <i data-feather="plus-square"></i>Add New
                      </a>
                    </form>
                  </div>

                  <div class="table-responsive category-table">
                    <table class="table all-package theme-table" id="table_id">
                      <thead>
                        <tr>
                          <th>Name</th>
                          <th>Value</th>
                          <th>Option</th>
                        </tr>
                      </thead>

                      <tbody>
<?php
$user_id = 0;
if ( isset( $_SESSION['loginInfo']["id"] ) ) {
    $user_id = $_SESSION['loginInfo']["id"];
}

settype( $user_id, "integer" );
$fetchCatQuerry = "SELECT * FROM attribute WHERE admin_id=$user_id";
$querry_result = mysqli_query( $conn, $fetchCatQuerry );

if ( $querry_result == true ) {
    $count = mysqli_num_rows( $querry_result );
    if ( $count>0 ) {
        echo "<tbody>";
        while( $rows = mysqli_fetch_assoc( $querry_result ) ) {

            $attr_id = $rows['id'];
            $attr_name = $rows['attr_name'];
            settype( $attr_id, "integer" );

            //fetching attribute value
            $fetchAttrValue_Querry = "SELECT * FROM attributevalues WHERE attr_id=$attr_id";
            $attrValueQuerry_result = mysqli_query( $conn, $fetchAttrValue_Querry );

            $attr_value_str = "";

            if ( $attrValueQuerry_result == true ) {
                $rowCount = mysqli_num_rows( $attrValueQuerry_result );
                if ( $rowCount>0 ) {

                    $i = 1;
                    while( $rowsVal = mysqli_fetch_assoc( $attrValueQuerry_result ) ) {
                        //concatenating all the attribute value in one string
                        $value = $rowsVal['attr_value'];

                        if ( $i == $rowCount ) {
                            $attr_value_str = $attr_value_str.$value;
                        } else {
                            $attr_value_str = $attr_value_str.$value.", ";
                        }
                        $i++;

                    }

                }
            } else {
                echo "<h4>Table is empty</h4>";
            }

            ?>
                        <tr>
                          <td><?php echo $attr_name; ?></td>

                          <td><?php echo $attr_value_str == ""?"no values added":$attr_value_str; ?></td>

                          <td>
                            <ul>
                              <li>
                                <a href="<?php echo "edit-attribute.php?attr_id=".$attr_id?>">
                                  <i class="ri-pencil-line"></i>
                                </a>
                              </li>

                              <li>
                                <a href="javascript:void(0)" onClick="<?php echo "del_attribute(".$attr_id.")"?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
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
          const del_attribute = (attrId) => {
            sessionStorage.setItem("tableName", "attribute");
            sessionStorage.setItem("del_id", attrId);
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
