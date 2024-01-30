<?php
session_start();
include "../config/dbConn.php";

if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['updateProfileBtn'] ) ) {
        $admin_id = $_SESSION['loginInfo']["id"];
        settype( $user_id, "integer" );
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone = $_POST['phone'];
        $email = $_POST['mail'];
        $image = $_FILES['img']['name'];

        $update_querry = "";
         if ( $image == "" ) {
            $update_querry = "UPDATE admin SET `first_name`='$firstName', `last_name`='$lastName', `admin_email`='$email', `phone`='$phone',  WHERE `id`=$admin_id";
        } else {
            $file_extension = pathinfo( $image, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
            move_uploaded_file( $_FILES['img']['tmp_name'], '../assets/images/admins/' . $filename );
            $_SESSION['loginInfo']['adminImg'] = $filename;

            $update_querry = "UPDATE admin SET `first_name`='$firstName', `last_name`='$lastName', `admin_email`='$email', `phone`='$phone', `admin_img`='$filename' WHERE `id`=$admin_id";
        }
        

        $run_updateQuerry = mysqli_query( $conn, $update_querry );
        if ( $run_updateQuerry ) {
            echo "asd";
            $_SESSION['status'] = "updated admin";
            header( "Location: ../setting.php" );
        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../setting.php" );
        }

    }
} else {
    header( "Location: login.php" );
}
?>