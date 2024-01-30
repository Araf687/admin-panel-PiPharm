<?php
session_start();
include "../config/dbConn.php";
if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['addCategory'] ) ) {

        $user_id = $_SESSION['loginInfo']["id"];

        $cat_name = $_POST['cat_name'];
        $cat_image = $_FILES['cat_image']['name'];
        $filename = '';
        $isFeatured = 0;
        if ( isset( $_POST['isFeatured'][0] ) ) {
            $isFeatured = 1;
        }

        $cat_slug = strtolower( str_replace( ' ', '-', $cat_name ) );
        $cat_slug = str_replace( "'", '', $cat_slug );

        if ( $cat_image != '' ) {
            $allowed_extension = array( 'png', 'jpg', 'jpeg' );
            $file_extension = pathinfo( $cat_image, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
        }

        $checkCategorySlug = "SELECT id FROM category WHERE slug='$cat_slug'";
        $checkCategorySlug_run = mysqli_query( $conn, $checkCategorySlug );

        if ( mysqli_num_rows( $checkCategorySlug_run ) > 0 ) {
            //adding random number to make the slug unique
            $cat_slug = $cat_slug . rand( 1, 1000 );
        }
        $addCat_querry = "INSERT INTO category (`cat_name`,`cat_image`, `is_featured`, `slug`,`admin_id`) VALUES ('$cat_name','$filename', $isFeatured, '$cat_slug',$user_id)";
        $run_addCatQuerry = mysqli_query( $conn, $addCat_querry );
        
        if ( $run_addCatQuerry ) {
            if ( $filename != '' ) {
                move_uploaded_file( $_FILES['cat_image']['tmp_name'], '../assets/images/categories/' . $filename );
            }

            $_SESSION['status'] = "Added Successfully";
            header( "Location: ../category.php" );

        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../add-category.php" );
        }

    } else if ( isset( $_POST['UpdateCategory'] ) ) {
        $cat_id = $_POST['cat_id'];
        $cat_name = $_POST['cat_name'];
        $cat_image = $_FILES['cat_image']['name'];
        $updateCat_querry = "";

        $isFeatured = 0;
        if ( isset( $_POST['isFeatured'][0] ) ) {
            $isFeatured = 1;
        }

        settype( $cat_id, "integer" );

        if ( $cat_image == "" ) {
            // that means user did not change the previous image
            $updateCat_querry = "UPDATE category SET `cat_name`='$cat_name', `is_featured`=$isFeatured WHERE `id`=$cat_id";
        } else {
            $file_extension = pathinfo( $cat_image, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
            move_uploaded_file( $_FILES['cat_image']['tmp_name'], '../assets/images/categories/' . $filename );
            
            $updateCat_querry = "UPDATE category SET `cat_name`='$cat_name',`cat_image`='$filename', `is_featured`=$isFeatured WHERE `id`=$cat_id";
            
        }
        
        $run_updateCatQuerry = mysqli_query( $conn, $updateCat_querry );
        if ( $run_updateCatQuerry ) {
            $_SESSION['status'] = "Updated Successfully";
            header( "Location: ../category.php" );
        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../category.php" );
        }

    } else if ( isset( $_GET['del_id'] ) ) {
        $cat_id = $_GET['del_id'];
        settype( $cat_id, "integer" );
        $delCat_querry = "DELETE FROM `category` WHERE `id`=$cat_id";
        $run_delCatQuerry = mysqli_query( $conn, $delCat_querry );
        if ( $run_delCatQuerry == true ) {
            $_SESSION['status'] = "Deleted Successfully";
            header( "Location: ../category.php" );

        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../category.php" );
        }

    }
} else {
    header( "Location: ../login.php" );
}
?>