<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php'); ?>

<body>
<?php
  
  if(isset($_SESSION['status']))
  {
    if($_SESSION['status']=="Added Successfully"){
      echo "<script>Swal.fire(
          'Great!',
          'Added Successfully!',
          'success'
      );
      </script>";
    }
  
    else if($_SESSION['status']=="Updated Successfully"){
      echo "<script>Swal.fire(
          'Great!',
          'Updated Successfully!',
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
    <?php include('includes/header.php'); ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <?php include('includes/sidebar.php'); ?>

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
                            <th>Slug</th>
                            <th>Price</th>
                            <th>Option</th>
                          </tr>
                        </thead>
                        <tbody>
                        <?php 

                        $user_id=$_SESSION['loginInfo']["id"];
                        settype($user_id,"integer");
                        $fetchPrdQuery="SELECT p.prd_id, p.prd_name, p.prd_image, p.prd_cat_id, p.prd_price, p.attributes, p.prd_sku, p.prd_status, p.slug, p.created_date, c.id, c.cat_name FROM product p, category c WHERE p.prd_cat_id=c.id AND p.admin_id=$user_id";
                        // $fetchPrdQuery="SELECT * FROM product WHERE admin_id=$user_id";
                        include "config/dbConn.php";
                        $query_result=mysqli_query($conn,$fetchPrdQuery);

                        if($query_result==true){
                            $count=mysqli_num_rows($query_result);
                            $slNo=1;
                            if( $count>0){
                                echo "<tbody>";
                                while($rows=mysqli_fetch_assoc($query_result)){
                                  $prd_id=$rows['prd_id'];
                                  $prd_name=$rows['prd_name'];
                                  $prd_image=explode("@",$rows['prd_image']);
                                  $prd_category=$rows['cat_name'];
                                  $prd_price=$rows['prd_price'];
                                  $prd_slug=$rows['slug'];
                                  $created_date=explode(" ",$rows['created_date']);

                                  $img_src="assets/images/product/".$prd_image[0];
                        ?>
                          <tr>
                            <td>
                              <div class="table-image">
                                <img src=<?php echo "\"$img_src\"";?> class="img-fluid" alt="">
                              </div>
                            </td>

                            <td><?php echo  $prd_name;?></td>

                            <td><?php echo  $prd_category;?></td>

                            <td><?php echo  $prd_slug;?></td>

                            <td class="td-price">$<?php echo  $prd_price;?></td>

                            <td>
                              <ul>
                                <li>
                                  <a href="#">
                                    <i class="ri-eye-line"></i>
                                  </a>
                                </li>

                                <li>
                                  <a href="<?php echo "edit-product.php?prd_id=".$prd_id?>">
                                    <i class="ri-pencil-line"></i>
                                  </a>
                                </li>

                                <li>
                                  <a href="javascript:void(0)" onClick=<?php echo "del_product(".$prd_id.")";?> data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
                                    <i class="ri-delete-bin-line"></i>
                                  </a>
                                </li>
                              </ul>
                            </td>
                          </tr>
                        <?php }}}?>
                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- Container-fluid Ends-->
        <script>
          const del_product=(prdId)=>{
            console.log(prdId); 
            sessionStorage.setItem("tableName", "product");
            sessionStorage.setItem("del_id", prdId);

          }
        </script>

        <?php include('includes/footer.php'); ?>
      </div>
      <!-- index body end -->

    </div>
    <!-- Page Body End -->
  </div>
  <!-- page-wrapper End-->

  <?php include('includes/scripts.php'); ?>
</body>

</html>
