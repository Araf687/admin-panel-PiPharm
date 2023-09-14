<?php
session_start();
include "../config/dbConn.php";
if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['addSlider'] ) ) {

        $user_id = $_SESSION['loginInfo']["id"];
        settype( $user_id, "integer" );

        $slider_name = $_POST['slider_name'];
        $slider_image = $_FILES['slider_image']['name'];
        $allowed_extension = array( 'png', 'jpg', 'jpeg' );
        $file_extension = pathinfo( $slider_image, PATHINFO_EXTENSION );

        $slider_slug = strtolower( str_replace( ' ', '-', $slider_name ) );
        $slider_slug = str_replace( "'", '', $slider_slug );

        $filename = time() . '.' . $file_extension;

        $checkSliderSlug = "SELECT `id` FROM slider WHERE `slug`='$slider_slug'";
        $checkSliderSlug_run = mysqli_query( $conn, $checkSliderSlug );

        if ( mysqli_num_rows( $checkSliderSlug_run ) > 0 ) {
            //adding random number to make the slug unique
            $slider_slug = $slider_slug . rand( 1, 1000 );
        }
        $addSlider_querry = "INSERT INTO slider (`slider_name`,`slider_image`, `slug`, `admin_id`) VALUES ('$slider_name','$filename', '$slider_slug',$user_id)";
      
        $run_addSliderQuerry = mysqli_query( $conn, $addSlider_querry );
        if ( $run_addSliderQuerry ) {
            move_uploaded_file( $_FILES['slider_image']['tmp_name'], '../assets/images/slider/' . $filename );
            $_SESSION['status'] = "Added Successfully";
            header( "Location: ../slider.php" );

        } else {

            $_SESSION['status'] = "something went wrong";
            header( "Location: ../slider.php" );
        }

    } else if ( isset( $_POST['UpdateSlider'] ) ) {
        $slider_id = $_POST['slider_id'];
        $slider_name = $_POST['slider_name'];
        $slider_image = $_FILES['slider_image']['name'];
        $updateSlider_querry = "";

        settype( $slider_id, "integer" );

        if ( $slider_image == "" ) {
            // that means user did not change the previous image
            $updateSlider_querry = "UPDATE slider SET `slider_name`='$slider_name' WHERE `id`=$slider_id";
        } else {
            $file_extension = pathinfo( $slider_image, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
            move_uploaded_file( $_FILES['slider_image']['tmp_name'], '../assets/images/slider/' . $filename );
            $updateSlider_querry = "UPDATE slider SET `slider_name`='$slider_name',`slider_image`='$filename' WHERE `id`=$slider_id";
            ;
        }
        
        $run_updateSliderQuerry = mysqli_query( $conn, $updateSlider_querry );
        if ( $run_updateSliderQuerry ) {
            $_SESSION['status'] = "Updated Successfully";
            header( "Location: ../slider.php" );
        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../slider.php" );
        }

    } else if ( isset( $_GET['del_id'] ) ) {
        $slider_id = $_GET['del_id'];
        settype( $slider_id, "integer" );
        $delSlider_querry = "DELETE FROM slider WHERE `id`=$slider_id";
        $run_delSliderQuerry = mysqli_query( $conn, $delSlider_querry );
        if ( $run_delSliderQuerry == true ) {
            $_SESSION['status'] = "Deleted Successfully";
            header( "Location: ../slider.php" );

        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../slider.php" );
        }

    }
} else {
    header( "Location: login.php" );
}
?>