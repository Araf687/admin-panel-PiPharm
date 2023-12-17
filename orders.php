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

      <!-- Order section Start -->
      <div class="page-body">
        <!-- Table Start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-body">
                  <div class="title-header option-title">
                    <h5>Order List</h5>
                  </div>
                  <div>
                    <div class="table-responsive">
                      <table class="table all-package order-table theme-table" id="table_id">
                        <thead>
                          <tr>
                            <th>Order Code</th>
                            <th>Date</th>
                            <th>Payment Method</th>
                            <th>Order Type</th>
                            <th>Delivery Status</th>
                            <th>Amount</th>
                            <th>Option</th>
                          </tr>
                        </thead>

                        <tbody>
<?php

$admin_id = 0;
if ( isset( $_SESSION['loginInfo']["id"] ) ) {
    $admin_id = $_SESSION['loginInfo']["id"];
}

settype( $admin_id, "integer" );

$fetchPrdQuery = "SELECT * FROM orders WHERE `pharmacy_id`=$admin_id";

$query_result = mysqli_query( $conn, $fetchPrdQuery );

if ( $query_result == true ) {
    $count = mysqli_num_rows( $query_result );
    $slNo = 1;
    if ( $count>0 ) {
        echo "<tbody>";
        while( $rows = mysqli_fetch_assoc( $query_result ) ) {
            $ord_id = $rows['id'];
            $ord_date = $rows['created_date'];
            $ord_code = $rows['order_code'];
            $amount = $rows['sale_amount'];
            $pay_method = $rows['payment_method'];
            $status = $rows['delivery_status'];
            $orderType = $rows['order_type'];

            $exploded_date = explode( " ", $ord_date );
            $newDate = date( "jS F Y", strtotime( $exploded_date[0] ) );

            ?>
                          <!-- data-bs-toggle = "offcanvas"  -->
                          <tr href="#order-details">
                            <td><?php echo $ord_code; ?></td>

                            <td><?php echo $newDate; ?></td>
                            <td><?php echo $pay_method; ?></td>
                            <td><?php echo $orderType; ?></td>

                            <td class="<?php echo "order-".$status; ?>">
                              <span><?php echo $status; ?></span>
                            </td>

                            <td>$<?php echo $amount; ?></td>

                            <td>
                              <ul>
                                <li>
                                  <a href="<?php echo "order-detail.php?ord_id=".$ord_id; ?>">
                                    <i class="ri-eye-line"></i>
                                  </a>
                                </li>

                                <li>
                                  <a href="javascript:void(0)" onClick="<?php echo "del_product("."\"$ord_code\"".")"; ?>" data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
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
        </div>
        <!-- Table End -->
        <script>
          const del_product = (ordId) => {
            console.log(ordId);
            sessionStorage.setItem("tableName", "order");
            sessionStorage.setItem("del_id", ordId);

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
