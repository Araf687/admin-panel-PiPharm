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

      <!-- index body start -->
      <div class="page-body">
        <div class="container-fluid">
          <div class="row">
<?php
$admin_id = 0;
if ( isset( $_SESSION['loginInfo']["id"] ) ) {
    $admin_id = $_SESSION['loginInfo']["id"];
}
settype( $admin_id, "integer" );

$countQuery = "SELECT 
              (SELECT COUNT(*) FROM orders WHERE admin_id=$admin_id) AS totalOrder, 
              (SELECT SUM(sale_amount) FROM orders WHERE admin_id=$admin_id) AS totalRevenue,
              (SELECT COUNT(*) FROM product WHERE admin_id=$admin_id) AS totalProduct,
              (SELECT COUNT(*) FROM user WHERE admin_id=$admin_id) AS totalUser";

$query_result = mysqli_query( $conn, $countQuery );

if ( $query_result == true ) {
    $count = mysqli_num_rows( $query_result );
    $slNo = 1;
    if ( $count>0 ) {
        while( $rows = mysqli_fetch_assoc( $query_result ) ) {
            $totalOrders = $rows['totalOrder'];
            $totalproducts = $rows['totalProduct'];
            $totalUsers = $rows['totalUser'];

            $totalReveneue = $rows['totalRevenue'];

            ?>
            <!-- chart caard section start -->
            <div class="col-sm-6 col-xxl-3 col-lg-6">
              <div class="main-tiles border-5 border-0  card-hover card o-hidden">
                <div class="custome-1-bg b-r-4 card-body">
                  <div class="media align-items-center static-top-widget">
                    <div class="media-body p-0">
                      <span class="m-0">Total Revenue</span>
                      <h4 class="mb-0 counter">$<?php echo $totalReveneue?$totalReveneue:0; ?></h4>
                    </div>
                    <div class="align-self-center text-center">
                      <i class="ri-database-2-line">

                      </i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-xxl-3 col-lg-6">
              <div class="main-tiles border-5 card-hover border-0 card o-hidden">
                <div class="custome-2-bg b-r-4 card-body">
                  <div class="media static-top-widget">
                    <div class="media-body p-0">
                      <span class="m-0">Total Orders</span>
                      <h4 class="mb-0 counter"><?php echo $totalOrders; ?></h4>
                    </div>
                    <div class="align-self-center text-center">
                      <i class="ri-shopping-bag-3-line"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-xxl-3 col-lg-6">
              <div class="main-tiles border-5 card-hover border-0  card o-hidden">
                <div class="custome-3-bg b-r-4 card-body">
                  <div class="media static-top-widget">
                    <div class="media-body p-0">
                      <span class="m-0">Total Products</span>
                      <h4 class="mb-0 counter"><?php echo $totalproducts; ?></h4>
                    </div>

                    <div class="align-self-center text-center">
                      <i class="ri-chat-3-line"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-sm-6 col-xxl-3 col-lg-6">
              <div class="main-tiles border-5 card-hover border-0 card o-hidden">
                <div class="custome-4-bg b-r-4 card-body">
                  <div class="media static-top-widget">
                    <div class="media-body p-0">
                      <span class="m-0">Total Customers</span>
                      <h4 class="mb-0 counter"><?php echo $totalUsers?></h4>
                    </div>

                    <div class="align-self-center text-center">
                      <i class="ri-user-add-line"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <?php } } } ?>

            <!-- Earning chart star-->
            <div class="col-xl-6">
              <div class="card o-hidden card-hover">
                <div class="card-header border-0 pb-1">
                  <div class="card-header-title">
                    <h4>Revenue Report</h4>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div id="report-chart">

                  </div>
                </div>
              </div>
            </div>
            <!-- Earning chart  end-->

            <!-- Best Selling Product Start -->
            <div class="col-xl-6 col-md-12">
              <div class="card o-hidden card-hover">
                <div class="card-header card-header-top card-header--2 px-0 pt-0">
                  <div class="card-header-title">
                    <h4>Best Selling Product</h4>
                  </div>
                </div>

                <div class="card-body p-0">
                  <div>
                    <div class="table-responsive">
                      <table class="best-selling-table w-image w-image w-image table border-0">
                        <tbody>
        <?php
        $fetchBestSellingProd = "SELECT product.prd_name, product.prd_price, SUM(orderitems.qty) AS total_sales 
                                FROM orderitems, product
                                WHERE orderitems.prod_id = product.prd_id AND product.admin_id=$admin_id
                                GROUP BY product.prd_name, product.prd_price 
                                ORDER BY total_sales DESC 
                                LIMIT 4;
                                ";
        $result = mysqli_query( $conn, $fetchBestSellingProd );

        if ( $result == true ) {
            $count = mysqli_num_rows( $result );
            $slNo = 1;
            if ( $count>0 ) {
                while( $dataRow = mysqli_fetch_assoc( $result ) ) {
                    $productName = $dataRow["prd_name"];
                    $productPrice = $dataRow["prd_price"];
                    $totalOrders = $dataRow["total_sales"];

                    ?>
                          <tr>
                            <td>
                              <div class="best-product-box">
                                <div class="product-name">
                                  <h5><?php echo $productName; ?></h5>
                                </div>
                              </div>
                            </td>

                            <td>
                              <div class="product-detail-box">
                                <h6>Price</h6>
                                <h5><?php echo $productPrice; ?></h5>
                              </div>
                            </td>

                            <td>
                              <div class="product-detail-box">
                                <h6>Orders</h6>
                                <h5><?php echo $totalOrders; ?></h5>
                              </div>
                            </td>
                          </tr>
                          <?php }
                } else {
                    echo "<p>Empty table</p>";
                }
            }
            ?>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <!-- Best Selling Product End -->

          </div>
        </div>
        <!-- Container-fluid Ends-->

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
