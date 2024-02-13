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
    if ($_SESSION['status'] == "Added Successfully") {
      echo "<script>Swal.fire(
          'Great!',
          'Added Successfully!',
          'success'
      );
      </script>";
    } else if ($_SESSION['status'] == "Updated Successfully") {
      echo "<script>Swal.fire(
          'Great!',
          'Updated Successfully!',
          'success'
      );
      </script>";
    } else if ($_SESSION['status'] == "Uploaded Successfully") {
      echo "<script>Swal.fire(
          'Great!',
          'Uploaded Successfully!',
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
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-body">
                  <div class="title-header option-title d-sm-flex d-block">
                    <h5>Products List</h5>
                    <div class="right-options">
                      <ul>
                        <!-- added upload product button according to the instruction -->
                        <!-- <li data-bs-toggle="modal" data-bs-target="#exampleModalToggle_UploadProduct">
                          <a href="#" class="btn btn-solid">Upload Product</a>
                        </li> -->
                        <li>
                          <a class="btn btn-solid" href="add-product.php">Add Product</a>
                        </li>
                      </ul>
                    </div>
                  </div>
                  <div>
                    <div class="table-responsive">
                      <table class="table all-package theme-table table-product" id="table_id">
                        <thead>
                          <tr>
                            <th>Product Image</th>
                            <th>Product Name</th>
                            <th>Category</th>
                            <th>Sub Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Option</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php
                          $admin_id = 0;
                          if (isset($_SESSION['loginInfo']["id"])) {
                            $admin_id = $_SESSION['loginInfo']["id"];
                          }

                          settype($admin_id, "integer");

                          $limit = 25;
                          $page = isset($_GET['page']) ? $_GET['page'] : 1;
                          $offset = ($page - 1) * $limit;

                          $fetchPrdQuery = "SELECT p.prd_id, p.prd_name, p.prd_image, p.prd_price, p.slug,p.quantity, p.created_date, c.cat_name, sc.sub_category_name
                          FROM product p
                          JOIN category c ON p.prd_cat_id = c.id
                          Left JOIN sub_category sc ON p.prd_sub_cat_id = sc.id";

                          $query_result = mysqli_query($conn, $fetchPrdQuery);
                          $count = 0;
                          if ($query_result == true) {

                            $count = mysqli_num_rows($query_result);
                            $slNo = 0;
                            echo $count;
                            if ($count > 0) {

                              echo "<tbody>";
                              while ($rows = mysqli_fetch_assoc($query_result)) {
                                $slNo = $slNo+1;
                                $prd_id = $rows['prd_id'];
                                $prd_name = $rows['prd_name'];
                                $prd_image = explode("@", $rows['prd_image']);
                                $prd_category = $rows['cat_name'];
                                $prd_sub_category = $rows['sub_category_name'];
                                $prd_price = $rows['prd_price'];
                                $quantity = $rows['quantity'];
                                $prd_slug = $rows['slug'];
                                $created_date = explode(" ", $rows['created_date']);


                                if ($prd_image[0] == '') {
                                  $img_src = "assets/images/product/default-image.jpg";
                                } else {
                                  $img_src = "assets/images/product/" . $prd_image[0];
                                }
                                ?>
                                <tr>
                                  <td>
                                    <div class="table-image">
                                      <img src="<?php echo $img_src; ?>" class="img-fluid" alt="">
                                    </div>
                                  </td>

                                  <td>
                                    <?php echo $prd_name?>
                                  </td>

                                  <td>
                                    <?php echo $prd_category; ?>
                                  </td>
                                  <td>
                                    <?php echo $prd_sub_category; ?>
                                  </td>
                                  <td>
                                    <?php echo $quantity; ?>
                                  </td>
                                  <td class="td-price">$
                                    <?php echo $prd_price; ?>
                                  </td>

                                  <td>
                                    <ul>
                                      <li>
                                        <a href="<?php echo "edit-product.php?prd_id=" . $prd_id ?>">
                                          <i class="ri-pencil-line"></i>
                                        </a>
                                      </li>

                                      <li>
                                        <a href="javascript:void(0)" onClick="<?php echo "del_product( " . $prd_id . " )"; ?>"
                                          data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                                          <i class="ri-delete-bin-line"></i>
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

                      <nav aria-label="page navigation example" class="m-3">
                        <ul class="pagination text-center">
                          <?php
                          // Pagination
                          $sql = "SELECT * FROM product WHERE pharmacy_id=$admin_id";

                          $result = mysqli_query($conn, $sql);

                          $total_records = mysqli_num_rows($result);
                          $total_pages = ceil($total_records / $limit);

                          // echo $total_records." ".$limit;
                          
                          for ($i = 1; $i <= $total_pages; $i++) {

                            if (isset($_GET['page'])) {
                              if ($_GET['page'] == $i) {
                                $active = 'active';
                              } else {
                                $active = '';
                              }
                            } else {
                              $active = '';
                            }

                            ?>
                            <li class="page-item <?php echo $active; ?>">
                              <a class="page-link" href="<?php echo "products.php?page=$i" ?>">
                                <?php echo $i; ?>
                              </a>
                            </li>
                          <?php } ?>
                        </ul>
                      </nav>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid Ends-->
        <script>
          const del_product = (prdId) => {
            console.log(prdId);
            sessionStorage.setItem("tableName", "product");
            sessionStorage.setItem("del_id", prdId);
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

  <?php include('includes/scripts.php');
  ?>
</body>

</html>