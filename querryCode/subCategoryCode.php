<?php
session_start();
include "../config/dbConn.php";
if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['addSubCategory'] ) ) {

        $user_id = $_SESSION['loginInfo']["id"];
        $categoryId= $_POST['category'];
        $cat_name = $_POST['sub_cat_name'];
        $cat_image = $_FILES['sub_cat_image']['name'];
        $filename = '';
        echo $categoryId;
       

        $cat_slug = strtolower( str_replace( ' ', '-', $cat_name ) );
        $cat_slug = str_replace( "'", '', $cat_slug );

        if ( $cat_image != '' ) {
            $allowed_extension = array( 'png', 'jpg', 'jpeg' );
            $file_extension = pathinfo( $cat_image, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
        }

        $checkCategorySlug = "SELECT id FROM sub_category WHERE slug='$cat_slug'";
        $checkCategorySlug_run = mysqli_query( $conn, $checkCategorySlug );

        if ( mysqli_num_rows( $checkCategorySlug_run ) > 0 ) {
            //adding random number to make the slug unique
            $cat_slug = $cat_slug . rand( 1, 1000 );
        }
        $addCat_querry = "INSERT INTO  sub_category (`sub_category_name`,`sub_category_image`, `slug`,`category_id`,`pharmacy_id`) VALUES ('$cat_name','$filename','$cat_slug',$categoryId,$user_id)";
        $run_addCatQuerry = mysqli_query( $conn, $addCat_querry );
        
        if ( $run_addCatQuerry ) {
            if ( $filename != '' ) {
                move_uploaded_file( $_FILES['sub_cat_image']['tmp_name'], '../assets/images/sub_categories/' . $filename );
            }

            $_SESSION['status'] = "Added Successfully";
            header( "Location: ../sub-category.php" );

        } else {
            $_SESSION['status'] = "something went wrong";
            // header( "Location: ../add-sub-category.php" );
            echo $run_addCatQuerry;
        }

    } else if ( isset( $_POST['UpdateSubCategory'] ) ) {
        $cat_id = $_POST['sub_cat_id'];
        $cat_name = $_POST['sub_cat_name'];
        $cat_image = $_FILES['sub_cat_image']['name'];
        $updateCat_querry = "";

        settype( $cat_id, "integer" );

        if ( $cat_image == "" ) {
            // that means user did not change the previous image
            $updateCat_querry = "UPDATE sub_category SET `sub_category_name`='$cat_name' WHERE `id`=$cat_id";
        } else {
            $file_extension = pathinfo( $cat_image, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
            move_uploaded_file( $_FILES['sub_cat_image']['tmp_name'], '../assets/images/sub_categories/' . $filename );
            $updateCat_querry = "UPDATE sub_category SET `sub_category_name`='$cat_name',`sub_category_image`='$filename' WHERE `id`=$cat_id";
            
        }
        echo $updateCat_querry."---------------------";
        $run_updateCatQuerry = mysqli_query( $conn, $updateCat_querry );
        if ( $run_updateCatQuerry ) {
            $_SESSION['status'] = "Updated Successfully";
            header( "Location: ../sub-category.php" );
        } else {
            $_SESSION['status'] = "something went wrong";
            // header( "Location: ../sub-category.php" );
        }

    } else if ( isset( $_GET['del_id'] ) ) {
        $cat_id = $_GET['del_id'];
        settype( $cat_id, "integer" );
        $delCat_querry = "DELETE FROM `sub_category` WHERE `id`=$cat_id";
        $run_delCatQuerry = mysqli_query( $conn, $delCat_querry );
        if ( $run_delCatQuerry == true ) {
            $_SESSION['status'] = "Deleted Successfully";
            header( "Location: ../sub-category.php" );

        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../sub-category.php" );
        }

    }
} else {
    header( "Location: ../login.php" );
}
?>