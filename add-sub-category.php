<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php
include('includes/head.php');

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
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-sm-8 m-auto">
                  <div class="card">
                    <div class="card-body">
                      <div class="card-header-2">
                        <h5>Sub Category Information</h5>
                      </div>

                      <form class="theme-form theme-form-2 mega-form" action="querryCode/subCategoryCode.php"
                        method="POST" enctype="multipart/form-data">
                        <div class="mb-4 row align-items-center">
                          <label class="col-sm-3 col-form-label form-label-title">Cateory</label>
                          <div class="col-sm-9">
                            <select class="js-example-basic-single w-100" name="category">
                            <option selected>Select Medicine Category</option>
                            <?php 
                             $user_id =0;
                                  if(isset($_SESSION['loginInfo']["id"])){
                                   $user_id =$_SESSION['loginInfo']["id"];
                                  }
                    
                        settype($user_id,"integer");  
                        $fetchCatQuerry="SELECT * FROM category";
                        $querry_result=mysqli_query($conn,$fetchCatQuerry);

                        if($querry_result==true){
                            $count=mysqli_num_rows($querry_result);
                            $slNo=1;

                            if( $count>0){
                                echo "<tbody>";
                                while($rows=mysqli_fetch_assoc($querry_result)){
                                  $cat_id=$rows['id'];
                                  $cat_name=$rows['cat_name'];
                        ?>
                              
                              <option value="<?=$cat_id?>"><?=$cat_name?></option>
                              
                              <?php
                                }}}
                              ?>
                            </select>
                          </div>
                        </div>
                    </div>
                    <div class="mb-4 row align-items-center">
                      <label class="form-label-title col-sm-3 mb-0">Subcategory Name</label>
                      <div class="col-sm-9">
                        <input class="form-control" type="text" name="sub_cat_name" placeholder="Sub Category Name">
                      </div>
                    </div>

                    <div class="mb-4 row align-items-center">
                      <label class="col-sm-3 col-form-label form-label-title">Image</label>
                      <div class="form-group col-sm-9">
                        <div class="dropzone-wrapper" onClick="dropzoneAreaClick()" style="cursor:pointer;">
                          <div class="dropzone-desc">
                            <i class="ri-upload-2-line"></i>
                            <p id="image-name">Choose an image file or drag it here.</p>
                          </div>
                          <input type="file" name="sub_cat_image" id="imgInput" class="dropzone"
                            onChange="handleChangeFile()" accept="image/jpeg, image/png, image/jpg">
                        </div>
                      </div>
                    </div>
                    <div class="mb-4 row align-items-center">
                      <label class="form-label-title col-sm-3 mb-0" style="display:none;"
                        id="previewLabel">Preview</label>
                      <div class="col-sm-9">
                        <img id="cat_img" style="display:none;" src="" alt="category image" height="100">
                      </div>
                    </div>

                    <button type="submit" name="addSubCategory" class="btn ms-auto theme-bg-color text-white">Add Sub
                      Category</button>
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
          var imageName = document.getElementById('imgInput').files.item(0).name;

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

          reader.onloadend = function () {
            preview.src = reader.result;
          }

          if (file) {
            reader.readAsDataURL(file);

          } else {
            preview.src = "";
          }
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