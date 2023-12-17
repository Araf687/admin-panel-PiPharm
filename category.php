<?php
include 'config/session.php';
include 'config/dbConn.php';
?>
<!DOCTYPE html>
<html lang="en" dir="ltr">
<?php include('includes/head.php'); ?>
<?php
if(isset($_SESSION['status']))
{
  if($_SESSION['status']=="Updated Successfully"){
    echo "<script>Swal.fire(
        'Great!',
        'Category Updated Successfully!',
        'success'
    );
    </script>";
  }
  unset($_SESSION['status']);
}
?>

<body>
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
                                        <h5>All Category</h5>
                                        <form class="d-inline-flex">
                                            <a href="add-category.php" class="align-items-center btn btn-theme d-flex">
                                                <i data-feather="plus-square"></i>Add New
                                            </a>
                                        </form>
                                    </div>

                                    <div class="table-responsive category-table">
                                        <div>
                                            <table class="table all-package theme-table" id="table_id">
                                                <thead>
                                                    <tr>
                                                        <th>Category Name</th>
                                                        <th>Category Image</th>
                                                        <th>Slug</th>
                                                        <th>Option</th>
                                                    </tr>
                                                </thead>

                             <tbody>

                           <?php 
                           
                        $fetchCatQuerry="SELECT * FROM category";
                        $querry_result=mysqli_query($conn,$fetchCatQuerry);

                        if($querry_result==true){
                            $count=mysqli_num_rows($querry_result);
                            $slNo=1;

                            if( $count>0){
                                
                                while($rows=mysqli_fetch_assoc($querry_result)){
                                  $cat_id=$rows['id'];
                                  $cat_name=$rows['cat_name'];
                                  $cat_image=$rows['cat_image'];
                                  $cat_slug=$rows['slug'];
                                  $isFeatured=$rows['is_featured']==0?'':'checked';
                                  $created_date=explode(" ",$rows['created_date']);
                                  $img_src=$cat_image?"assets/images/categories/".$cat_image:"assets/images/categories/default-image.jpg";

                        ?>

                                                    <tr>
                                                        <td><?php echo $cat_name;?></td>

                                                        <td>
                                                            <div class="table-image">
                                                                <img src="<?php echo $img_src;?>" class="img-fluid"
                                                                    alt="">
                                                            </div>
                                                        </td>

                                                        <td><?php echo $cat_slug;?></td>

                                                        <td>
                                                            <ul>
                                                                <li>
                                                                    <a
                                                                        href="<?php echo "edit-category.php?cat_id=".$cat_id?>">
                                                                        <i class="ri-pencil-line"></i>
                                                                    </a>
                                                                </li>

                                                                <li>
                                                                    <a href="#"
                                                                        onClick="del_cat(<?php echo $cat_id; ?>)"
                                                                        data-bs-toggle="modal"
                                                                        data-bs-target="#exampleModalToggle">
                                                                        <i class="ri-delete-bin-line"></i>
                                                                    </a>
                                                                </li>
                                                            </ul>
                                                        </td>
                                                    </tr>
                                                    <?php
                            $slNo++;
                                }
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
                    </div>
                </div>
                <!-- All User Table Ends-->
                <script>
                const del_cat = (catId) => {
                    console.log(catId);
                    sessionStorage.setItem("tableName", "category");
                    sessionStorage.setItem("del_id", catId);

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