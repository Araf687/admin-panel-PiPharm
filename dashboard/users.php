<!DOCTYPE html>
<html lang="en" dir="ltr">

<?php include('includes/head.php'); 
$fetchPrdQuery="SELECT p.prd_id, p.prd_name, p.prd_image, p.prd_cat_id, p.prd_price, p.attributes, p.prd_sku, p.prd_status, c.id, c.cat_name,  FROM product p, category c WHERE prd_id=c.id AND prd_id=$prd_id LIMIT 1";

?>

<body>


<?php
      session_start();
      if(isset($_SESSION['status']))
      {
        // echo "<script>console.log(\"".$_SESSION['status']."\")</script>";

        if($_SESSION['status']=="updated"){
          echo "<script>Swal.fire(
              'Great!',
              'User Updated Successfully!',
              'success'
          );
          </script>";
        }
        if($_SESSION['status']=="Deleted Successfully"){
          echo "<script>Swal.fire(
              'Great!',
              'User Deleted Successfully!',
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
        <!-- All User Table Start -->
        <div class="container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="card card-table">
                <div class="card-body">
                  <div class="title-header option-title">
                    <h5>All Users</h5>
                    <form class="d-inline-flex">
                      <a href="add-pharmacy.php" class="align-items-center btn btn-theme d-flex">
                        <i data-feather="plus"></i>Add New
                      </a>
                    </form>
                  </div>

                  <div class="table-responsive table-product">
                    <table class="table all-package theme-table" id="table_id">
                      <thead>
                        <tr>
                          <th>User</th>
                          <th>Name</th>
                          <th>Email</th>
                          <!-- <th>Type</th> -->
                          <th>Option</th>
                        </tr>
                      </thead>

                      <tbody>
                      <?php 
                        include "config/dbConn.php";
                        $admin_id=$_SESSION['loginInfo']["id"];
                        settype($admin_id,"integer");  

                        $fetchUserQuerry="SELECT * FROM user WHERE admin_id=$admin_id";
                        $querry_result=mysqli_query($conn,$fetchUserQuerry);

                        if($querry_result==true){
                            $count=mysqli_num_rows($querry_result);
                            $slNo=1;

                            if( $count>0){
                                echo "<tbody>";
                                while($rows=mysqli_fetch_assoc($querry_result)){	
                                  // user_name	user_email	user_type	user_pass
                                  $user_id=$rows['id'];
                                  $user_firstName=$rows['first_name'];
                                  $user_lastName=$rows['last_name'];
                                  $user_email=$rows['user_email'];
                                  // $user_type=$rows['user_type'];

                        ?>
                          <tr>
                            <td>
                              <div class="table-image">
                                <img src="assets/images/users/1.jpg" class="img-fluid" alt="">
                              </div>
                            </td>

                            <td>
                              <div class="user-name">
                                <span><?php echo $user_firstName." ".$user_lastName; ?></span>
                                <!-- <span>Essex Court</span> -->
                              </div>
                            </td>

                            <td><?php echo $user_email; ?></td>

                            <!-- <td><?php echo $user_type; ?></td> -->

                            <td>
                              <ul>
                                <li>
                                  <a href="#">
                                    <i class="ri-eye-line"></i>
                                  </a>
                                </li>

                                <li>
                                  <a href=<?php echo "edit-user.php?user_id=".$user_id?>>
                                    <i class="ri-pencil-line"></i>
                                  </a>
                                </li>

                                <li>
                                  <a href="javascript:void(0)" onClick=<?php echo "del_user(".$user_id.")";?> data-bs-toggle="modal" data-bs-target="#exampleModalToggle">
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
        <!-- All User Table Ends-->
        <script>
          const del_user=(userId)=>{
            console.log(userId);
            sessionStorage.setItem("tableName", "user");
            sessionStorage.setItem("del_id", userId);

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
