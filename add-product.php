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

        <!-- New Product Add Start -->
        <form class="theme-form theme-form-2 mega-form" action="querryCode/productCode.php" method="POST"
          enctype="multipart/form-data">
          <div class="container-fluid">
            <div class="row">
              <div class="col-12">
                <div class="row">
                  <div class="col-sm-8 m-auto">
                    <div class="card">
                      <div class="card-body">
                        <div class="card-header-2">
                          <h5>Product Information</h5>
                        </div>

                        <div class="mb-4 row align-items-center">
                          <label class="form-label-title col-sm-3 mb-0">Product
                            Name</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="prd_name" type="text" placeholder="Product Name">
                          </div>
                        </div>

                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 col-form-label form-label-title">Category</label>
                          <div class="col-sm-9">
                            <select class="js-example-basic-single w-100" name="category"
                              onchange="handleChangeCategory(this)" required>
                              <option selected>Select Category</option>
                              <?php
                              $pharmacy_id = 0;
                              if (isset($_SESSION['loginInfo']["id"])) {
                                $pharmacy_id = $_SESSION['loginInfo']["id"];
                              }

                              $fetchCatQuerry = "SELECT id, cat_name FROM category WHERE admin_id=1";
                              $querry_result = mysqli_query($conn, $fetchCatQuerry);

                              if ($querry_result == true) {
                                $count = mysqli_num_rows($querry_result);
                                $slNo = 1;
                                if ($count > 0) {
                                  while ($rows = mysqli_fetch_assoc($querry_result)) {
                                    $cat_id = $rows['id'];
                                    $cat_name = $rows['cat_name'];
                                    echo "<option value='$cat_id'>$cat_name</option>";
                                  }
                                }
                              }
                              ?>
                            </select>
                          </div>
                        </div>
                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 col-form-label form-label-title">Sub Category</label>
                          <div class="col-sm-9">
                            <select class="js-example-basic-single w-100" name="sub_category" id="subcategorySelect">
                              <option selected>Select Sub Category</option>
                             
                            </select>
                          </div>
                        </div>

                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 form-label-title">Product Price</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="prod_price" type="number" min="0" step="0.01"
                              value="0.00">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-body">
                        <div class="card-header-2">
                          <h5>Description</h5>
                        </div>

                        <div class="row">
                          <div class="col-12">
                            <div class="row">
                              <label class="form-label-title col-sm-3 mb-0">Product
                                Description</label>
                              <div class="col-sm-9" id="descSection">
                                <div id="editor">
                                  <!-- hidden input to send descriptiion in backend -->
                                  <input class="form-control" name="prd_desc" style="display:none;" id="desc"
                                    type="text">
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="card">
                      <div class="card-body">
                        <div class="card-header-2">
                          <h5>Product Images</h5>
                        </div>

                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 col-form-label form-label-title">Images ( Multiple )</label>
                          <div class="col-sm-9">
                            <input class="form-control form-choose" onChange="handleChangeFile(event)" name="product_image"
                               type="file" id="formFile">
                          </div>
                          <div class="col-sm-9 mt-4" id="prd_img_section">
                            <img src="" id ="prd_img" class ="img-fluid mt-1" width = "100">
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="card">
                      <div class="card-body">
                        <div class="card-header-2">
                          <h5>Product Inventory</h5>
                        </div>

                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 form-label-title">Product Quantity</label>
                          <div class="col-sm-9">
                            <input class="form-control" name="prod_qty" type="number" 
                              value="0">
                          </div>
                        </div>

                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 col-form-label form-label-title">Stock
                            Status</label>
                          <div class="col-sm-9">
                            <select class="js-example-basic-single w-100" name="status">
                              <option selected>Select Product Status</option>
                              <option>In Stock</option>
                              <option>Out Of Stock</option>
                            </select>
                          </div>
                        </div>

                        
                      </div>
                    </div>

                    <div class="d-flex">
                      <button type="submit" onclick="submitEditedData()" name="addProduct"
                        class="btn w-25 mb-3 theme-bg-color text-white">Add Product</button>
                    </div>

                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!-- New Product Add End -->

        <!-- //js code for this page -->
        <script type="text/javascript" src="./assets/js/pages/add-product.js"></script>
        <?php include('includes/footer.php');
        ?>
      </div>
      <!-- index body end -->

    </div>
    <!-- Page Body End -->
  </div>
  <!-- page-wrapper End-->
  <script>
    const handleChangeCategory = (categoryElement) => {
      const data = {
        pharmacy_id: <?php echo $pharmacy_id ?>,
        category_id: categoryElement.value,
      }
      console.log(data);

      $.ajax({
        type: "POST",
        url: "querryCode/getSubCategory.php",
        data: data,
        success: function (response) {
          console.log(response)
          $("#subcategorySelect").html(response);
        },
      });
    }
  </script>

  <?php include('includes/scripts.php');
  ?>
</body>

</html>