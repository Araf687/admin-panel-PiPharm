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

      <div class="page-body">

        <!-- New Product Add Start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-sm-8 m-auto">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-header-2">
                        <h5>Edit Category Information</h5>
                      </div>
                      <form class="theme-form theme-form-2 mega-form" action="querryCode/subCategoryCode.php" method="POST" enctype="multipart/form-data">
<?php
$cat_id = $_GET['sub_cat_id'];
settype( $cat_id, "integer" );
$fetchCatQuerry = "SELECT * FROM sub_category WHERE `id`=$cat_id LIMIT 1";
$querry_result = mysqli_query( $conn, $fetchCatQuerry );

if ( $querry_result == true ) {
    $count = mysqli_num_rows( $querry_result );
    $slNo = 1;

    if ( $count>0 ) {
        echo "<tbody>";
        while( $rows = mysqli_fetch_assoc( $querry_result ) ) {
            $cat_id = $rows['id'];
            $cat_name = $rows['sub_category_name'];
            $cat_image = $rows['sub_category_image'];
            ?>
                        <div class="mb-4 row align-items-center">
                          <!-- hidden category id for update operation-->
                          <input value="<?php echo $cat_id;?>" type="integer" style="display:none;" name="sub_cat_id">
                          <!-- end -->

                          <label class="form-label-title col-sm-3 mb-0">Category Name</label>
                          <div class="col-sm-9">
                            <input class="form-control" value="<?php echo $cat_name;?>" type="text" name="sub_cat_name" placeholder="Category Name">
                          </div>
                        </div>

                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 col-form-label form-label-title">Sub Category Image</label>
                          <div class="form-group col-sm-9">
                            <div class="dropzone-wrapper" onClick="dropzoneAreaClick()" style="cursor:pointer;">
                              <div class="dropzone-desc">
                                <i class="ri-upload-2-line"></i>
                                <p id="image-name"><?php echo $cat_image; ?></p>
                              </div>
                              <input type="file" name="sub_cat_image" id="imgInput" class="dropzone" onChange="handleChangeFile()" accept="image/jpeg, image/png, image/jpg">
                            </div>
                            <?php $img_src = $cat_image == ''?'':"assets/images/sub_categories/".$cat_image; ?>
                            <img src="<?php echo $img_src?>" width="100" id="previewImg" class="mt-3">
                          </div>
                        </div>
                        <?php } } } ?>
                        <button type="submit" name="UpdateSubCategory" class="btn ms-auto theme-bg-color text-white">Update Sub Category</button>
                      </form>

                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- New Product Add End -->
        <script>
          function dropzoneAreaClick() {
            document.getElementById('imgInput').click();
          }

          function handleChangeFile() {
            console.log("hi");
            var imageContent = document.getElementById('imgInput');
            var imageName = imageContent.files.item(0).name;

            document.getElementById('image-name').innerText = imageName;

            //set image preview
            var preview = document.getElementById('previewImg');
            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
              preview.src = reader.result;
            }

            if (file) {
              reader.readAsDataURL(file);

            } else {
              preview.src = "";
              console.log("file not selected");
            }
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
