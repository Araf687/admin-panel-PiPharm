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
    else if( $_SESSION['status']=="Data already exist"){
      echo "<script>
      Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Failed to add Store!',
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
    <?php include('includes/header.php'); ?>

    <!-- Page Body Start-->
    <div class="page-body-wrapper">
      <?php include('includes/sidebar.php'); ?>

      <!-- Settings Section Start -->
      <div class="page-body">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="row">
                <div class="col-sm-12">
                  <!-- Details Start -->
                  <div class="card">
                    <div class="card-body">
                      <div class="title-header option-title">
                        <h5>Store Setting</h5>
                      </div>
                      <form class="theme-form theme-form-2 mega-form" action="querryCode/storeCode.php" method="POST" enctype="multipart/form-data">
                        <?php
                        include "config/dbConn.php";
                        $admin_id=$_SESSION['loginInfo']["id"];
                        settype($admin_id,"integer");  
                        $fetchCatQuerry="SELECT * FROM store WHERE admin_id=$admin_id LIMIT 1";
                        $querry_result=mysqli_query($conn,$fetchCatQuerry);

                        $store_id="";
                        $store_name="";
                        $phone="";
                        $Store_location="";
                        $email="";
                        $logo="";
                        $banner="";
                        $img_src_logo="";
                        $img_src_banner="";
                        if($querry_result==true){
                            $count=mysqli_num_rows($querry_result);
                            $slNo=1;

                            if( $count>0){
                                while($rows=mysqli_fetch_assoc($querry_result)){
                                  $store_id=$rows['id'];
                                  $store_name=$rows['store_name'];
                                  $phone=$rows['phone'];
                                  $Store_location=$rows['store_location'];
                                  $email=$rows['email'];
                                  $logo=$rows['logo'];
                                  $banner=$rows['banner'];
                                  $img_src_logo="assets/images/store/logo/".$logo;
                                  $img_src_banner="assets/images/store/banner/".$banner;;
                                  
                                }
                            }
                          }
                        ?>
                        <div class="row">
                          <!-- hidden input store id -->
                          <input type="text" value='<?php echo $store_id;?>' name="store_id" style="display:none;">
                          <div class="mb-4 row align-items-center">
                            <label class="form-label-title col-sm-2 mb-0">Store Name</label>
                            <div class="col-sm-10">
                              <input class="form-control" name="store_name" value='<?php echo  $store_name;?>' type="text" placeholder="Enter Your Store Name">
                            </div>
                          </div>

                          <div class="mb-4 row align-items-center">
                            <label class="form-label-title col-sm-2 mb-0">Store Location</label>
                            <div class="col-sm-10">
                              <input class="form-control" name="store_location" value='<?php echo  $Store_location;?>' type="text" placeholder="Enter Your Store Location">
                            </div>
                          </div>

                          <div class="mb-4 row align-items-center">
                            <label class="form-label-title col-sm-2 mb-0">Store Phone</label>
                            <div class="col-sm-10">
                              <input class="form-control" value='<?php echo  $phone;?>' name="store_phone" type="number" placeholder="Enter Your Store Phone">
                            </div>
                          </div>

                          <div class="mb-4 row align-items-center">
                            <label class="form-label-title col-sm-2 mb-0">Store Email</label>
                            <div class="col-sm-10">
                              <input class="form-control" name="store_email" value='<?php echo  $email;?>' type="email" placeholder="Enter Your Store Email">
                            </div>
                          </div>

                          <div class="mb-4 row align-items-center">
                            <label class="col-sm-2 col-form-label form-label-title">Store Logo</label>
                            <div class="col-sm-10">
                              <input class="form-control form-choose" onChange="handleLogo(event)" name="store_logo" type="file" id="formFileMultiple" multiple>
                              <img src='<?php echo $img_src_logo;?>' alt="" class="rounded m-1" id="logoImg" width="50">
                            </div>
                          </div>

                          <div class="mb-4 row align-items-center">
                            <label class="col-sm-3 col-form-label form-label-title">Store Banner</label>
                            <div class="form-group col-sm-9">
                              <div class="dropzone-wrapper" style="cursor:pointer" onClick="dropzoneAreaClick()">
                                <div class="dropzone-desc">
                                  <i class="ri-upload-2-line"></i>
                                  <p id="image-name">Choose an image file or drag it here.</p>
                                </div>
                                <input type="file" id="bannerInput" name="store_banner" onChange="handleChangeFile(event)" accept="image/jpeg, image/png, image/jpg" class="dropzone">
                              </div>
                              <img src='<?php echo $img_src_banner;?>'  alt="" class="rounded mt-2" id="bannerImg" width="250">
                            </div>
                          </div>
                          <?php
                          if($store_id==""){
                          ?>
                            <div style="padding-right:30px !important">
                              <button name="addStore" type="submit" class="btn ms-auto theme-bg-color text-white">Add Store Information</button>
                            </div>
                          <?php
                          }else{
                            echo "<script>
                              let logo=document.getElementById('logoImg');
                              let banner=document.getElementById('bannerImg');
                               
                            </script>";
                          ?>
                           <div>
                                <button name="UpdateStore" id="updateProfileBtn" type="submit" class="btn theme-bg-color text-white">Update</button>
                            </div>
                          <?php
                          }
                          ?>
                        </div>
                      </form>
                    </div>
                  </div>
                  <!-- Details End -->
                </div>
              </div>
            </div>
          </div>
        </div>

        <?php include('includes/footer.php'); ?>
      </div>
      <!-- index body end -->
      <script>
          function dropzoneAreaClick(){
              console.log("here click upcontent");
              document.getElementById('bannerInput').click();
          }
          function handleChangeFile(event){
              console.log("hi");
              var imageContent = document.getElementById('bannerInput'); 
              var imageName=imageContent.files.item(0).name;
              
              document.getElementById('image-name').innerText=imageName;

              let preview=document.getElementById('bannerImg');
              preview.style.display="block"
              console.log(event.target.files[0]);
              preview.src = URL.createObjectURL(event.target.files[0]);
              preview.onload = function() {
                  URL.revokeObjectURL(preview.src) // free memory
              }

          }
          const handleLogo=(event)=>{
            let preview=document.getElementById('logoImg');
            preview.style.display="block"
            console.log(event.target.files[0]);
            preview.src = URL.createObjectURL(event.target.files[0]);
            preview.onload = function() {
                URL.revokeObjectURL(preview.src) // free memory
            }
            
          }

        </script>

    </div>
    <!-- Page Body End -->
  </div>
  <!-- page-wrapper End-->

  <?php include('includes/scripts.php'); ?>
</body>

</html>
