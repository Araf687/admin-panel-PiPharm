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
                    <?php

                    $prd_id = $_GET['prd_id'];
                    settype($prd_id, "integer");
                    $fetchPrdQuery = "SELECT * FROM product WHERE prd_id=$prd_id LIMIT 1";
                    $query_result = mysqli_query($conn, $fetchPrdQuery);

                    $attr_id = "";

                    if ($query_result == true) {
                      $count = mysqli_num_rows($query_result);
                      $slNo = 1;

                      if ($count > 0) {
                        while ($rows = mysqli_fetch_assoc($query_result)) {
                          $prd_name = $rows['prd_name'];
                          $imgString = $rows['prd_image'];
                          $prd_image =  $rows['prd_image'];
                          $prd_category = $rows['prd_cat_id'];
                          $prd_sub_category = $rows['prd_sub_cat_id'];
                          $prd_price = $rows['prd_price'];
                          $quantity = $rows['quantity'];
                          $product_desc = $rows['prd_description'];
                          $prd_status = $rows['prd_status'];

                          $img_src = $prd_image ? "assets/images/product/" . $prd_image : "";
                          ?>
                          <div class="card">
                            <div class="card-body">
                              <div class="card-header-2">
                                <h5>Product Information</h5>
                              </div>

                              <div class="mb-4 row align-items-center">
                                <!-- hidden product id for update operation-->
                                <input style="display:none" value="<?php echo $prd_id; ?>" name="prd_id" type="text">
                                <label class="form-label-title col-sm-3 mb-0">Product
                                  Name</label>
                                <div class="col-sm-9">
                                  <input class="form-control" value="<?php echo $prd_name; ?>" name="prd_name" type="text"
                                    placeholder="Product Name">
                                </div>
                              </div>

                              <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Category</label>
                                <div class="col-sm-9">
                                  <select class="js-example-basic-single w-100" name="category" required>
                                    <?php
                                    $user_id = $_SESSION['loginInfo']["id"];

                                    $fetchCatQuerry = "SELECT id, cat_name FROM category";
                                    $querry_result = mysqli_query($conn, $fetchCatQuerry);

                                    if ($querry_result == true) {
                                      $count = mysqli_num_rows($querry_result);
                                      $slNo = 1;
                                      if ($count > 0) {
                                        while ($rows = mysqli_fetch_assoc($querry_result)) {
                                          $cat_id = $rows['id'];
                                          $cat_name = $rows['cat_name'];
                                          if ($cat_id == $prd_category) {
                                            $optSelected = "<option value=$cat_id selected>$cat_name</option>";
                                          } else {
                                            $opt = $opt . "<option value=$cat_id>$cat_name</option>";
                                          }
                                        }
                                      }
                                      echo $optSelected;
                                      echo $opt;
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>
                              <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Sub Category</label>
                                <div class="col-sm-9">
                                  <select class="js-example-basic-single w-100" name="sub_category">
                                    <?php
                                    $user_id = $_SESSION['loginInfo']["id"];

                                    $fetchSubCatQuerry = "SELECT * FROM sub_category WHERE `pharmacy_id`=$user_id";
                                    $querry_result2 = mysqli_query($conn, $fetchSubCatQuerry);
                                    $subCatOpt = $subCatOptSelected = " ";

                                    if ($querry_result2 == true) {

                                      $count = mysqli_num_rows($querry_result2);
                                      $slNo = 1;
                                      if ($count > 0) {
                                        while ($rows2 = mysqli_fetch_assoc($querry_result2)) {
                                          $sub_cat_id = $rows2['id'];
                                          $sub_cat_name = $rows2['sub_category_name'];
                                          if ($sub_cat_id == $prd_sub_category) {
                                            $subCatOptSelected = "<option value=$sub_cat_id selected>$sub_cat_name</option>";
                                          } else {

                                            $subCatopt = $subCatOpt . "<option value=$sub_cat_id>$sub_cat_name</option>";
                                          }
                                        }
                                      }
                                      echo $subCatOptSelected;
                                      echo $subCatOpt;
                                    }
                                    ?>
                                  </select>
                                </div>
                              </div>


                              <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 form-label-title">Product Price</label>
                                <div class="col-sm-9">
                                  <input class="form-control" name="prod_price" value="<?php echo $prd_price; ?>"
                                    type="number" min="0" step="0.01" value="0.00">
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

                                        <input class="form-control" name="prd_desc" value="<?php echo "'$product_desc'"; ?>"
                                          style="display:none;" id="desc" type="text">
                                        <?php echo $product_desc; ?>
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
                                <label class="col-sm-3 col-form-label form-label-title">Image</label>

                                <!-- set previous image names to hidden as if we concatanate them with the newer images -->
                                <input style="display:none" value="<?php echo $imgString; ?>" name="prev_img" type="text">

                                <div class="col-sm-9">
                                  <input class="form-control form-choose" onChange="handleChangeFile(event)"
                                    name="product_image" type="file" id="formFile">
                                </div>
                                <div class="col-sm-9 mt-4" id="prd_img_section">

                                  <div class="imgContainerProd">
                                    <img src="<?php echo $img_src; ?>" id="prd_img" class="img-fluid mt-1" width="100">
                                  </div>


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
                                  <input class="form-control" name="prod_qty" value="<?php echo $quantity; ?>" type="number"
                                    min="0">
                                </div>
                              </div>

                              <div class="mb-4 row align-items-center">
                                <label class="col-sm-3 col-form-label form-label-title">Stock
                                  Status</label>
                                <div class="col-sm-9">
                                  <select class="js-example-basic-single w-100" name="status">
                                    <option selected>
                                      <?php echo $prd_status; ?>
                                    </option>
                                    <option>In Stock</option>
                                    <option>Out Of Stock</option>
                                  </select>
                                </div>
                              </div>
                            </div>
                          </div>

                          <div class="text-center">
                            <button type="submit" onclick="submitEditedData()" name="UpdateProduct"
                              class="btn w-25 mb-3 theme-bg-color text-white">Update Product</button>
                          </div>
                        <?php }
                      }
                    } ?>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
        <!-- New Product Add End -->

        <!-- //js code for this page -->
        <script type="text/javascript" src="./assets/js/pages/edit-product.js"></script>
        <script>
          const addProductAttribute = () => {
            let value = parseInt(document.getElementById('noOfAttr').value, 10);
            value++;
            console.log(value);
            document.getElementById('noOfAttr').value = value;

            let parentDiv = document.getElementById('allAttributes');

            let attrChild = document.createElement('div');
            attrChild.id = `attrChild$ {
                            value}
                            `;
            attrChild.className = "mt-3"

            let childHeader = document.createElement('div');
            childHeader.className = "mb-4 row align-items-center";

            let label = document.createElement("label");
            label.className = "form-label-title col-sm-3 mb-0";
            label.innerText = "Attributes Name";

            let div = document.createElement('div');
            div.className = "col-sm-8";

            let crossBtn = document.createElement('div');
            crossBtn.className = "col-sm-1";

            let crossIcon = document.createElement("i");
            crossIcon.className = "ri-close-fill text-danger";
            crossIcon.style.cursor = "pointer";
            crossIcon.style.fontWeight = "bolder";
            crossIcon.onclick = function () {
              deleteAttribute(this.parentElement);
            };

            crossBtn.appendChild(crossIcon);

            var select = document.createElement("select");
            select.id = `attr$ {
                                value}
                                `;
            select.className = "js-example-basic-single w-100";
            select.onchange = "attributeSelect";
            select.setAttribute("onchange", `attributeSelect( '#attr-section${value}', 'attr${value}' )`);
            select.name = `attr$ {
                                    value}
                                    `;
            select.innerHTML = '<?php echo $attrOptions; ?>';

            div.appendChild(select);

            childHeader.appendChild(label);
            childHeader.appendChild(div);
            childHeader.appendChild(crossBtn);

            attrChild.appendChild(childHeader);
            let adjacentDiv = document.createElement('div');
            adjacentDiv.className = "row align-items-center";
            adjacentDiv.id = `attr-section$ {
                                        value}
                                        `
            attrChild.appendChild(adjacentDiv);

            parentDiv.appendChild(attrChild);

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