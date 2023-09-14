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
                      <form class="theme-form theme-form-2 mega-form" action="querryCode/slideCode.php" method="POST" enctype="multipart/form-data">
<?php
$slider_id = $_GET['slider_id'];
settype( $slider_id, "integer" );
$fetchCatQuerry = "SELECT * FROM slider WHERE `id`=$slider_id LIMIT 1";
$querry_result = mysqli_query( $conn, $fetchCatQuerry );

if ( $querry_result == true ) {
    $count = mysqli_num_rows( $querry_result );
    $slNo = 1;

    if ( $count>0 ) {
        echo "<tbody>";
        while( $rows = mysqli_fetch_assoc( $querry_result ) ) {
            $slider_id = $rows['id'];
            $slider_name = $rows['slider_name'];
            $slider_image = $rows['slider_image'];
            $img_src = "assets/images/slider/".$slider_image;
            ?>
                        <div class="mb-4 row align-items-center">
                          <!-- hidden category id for update operation-->
                          <input value="<?php echo $slider_id;?>" type="integer" style="display:none;" name="slider_id">
                          <!-- end -->

                          <label class="form-label-title col-sm-3 mb-0">Slider Name</label>
                          <div class="col-sm-9">
                            <input class="form-control" value="<?php echo $slider_name;?>" type="text" name="slider_name" placeholder="Category Name">
                          </div>
                        </div>

                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 col-form-label form-label-title">Slider
                            Image</label>
                          <div class="form-group col-sm-9">
                            <div class="dropzone-wrapper" onClick="dropzoneAreaClick()" style="cursor:pointer;">
                              <div class="dropzone-desc">
                                <i class="ri-upload-2-line"></i>
                                <p id="image-name"><?php echo $slider_image; ?></p>
                              </div>
                              <input type="file" name="slider_image" id="imgInput" class="dropzone" onChange="handleChangeFile()" accept="image/jpeg, image/png, image/jpg">
                            </div>
                          </div>
                        </div>
                        <div class="mb-4 row align-items-center">
                          <label class="form-label-title col-sm-3 mb-0" id="previewLabel">Preview</label>
                          <div class="col-sm-9">
                            <img id="cat_img" src="<?php echo $img_src;?>" alt="slider image" height="100">
                          </div>
                        </div>
                        <?php } } } ?>
                        <button type="submit" name="UpdateSlider" class="btn ms-auto theme-bg-color text-white">Update Slider</button>
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
            var preview = document.getElementById('cat_img');
            var previewLabel = document.getElementById('previewLabel');
            //display image tag
            preview.style.display = "block";

            //display preview Label tag
            previewLabel.style.display = "block";

            var file = document.querySelector('input[type=file]').files[0];
            var reader = new FileReader();

            reader.onloadend = function() {
              preview.src = reader.result;
            }

            if (file) {
              reader.readAsDataURL(file);

            } else {
              // preview.src = "";
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
