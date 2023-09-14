<?php
session_start();
include "../config/dbConn.php";

if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['updateProfile'] ) ) {
        $admin_id = $_SESSION['loginInfo']["id"];
        settype( $user_id, "integer" );
        $firstName = $_POST['firstName'];
        $lastName = $_POST['lastName'];
        $phone = $_POST['phone'];
        $email = $_POST['mail'];
        $pass = $_POST['pass'];
        $image = $_FILES['img']['name'];
        $confirmPass = $_POST['confirmPass'];

        $update_querry = "";
        
        if ( $pass == "" || $pass != $confirmPass && $image == "" ) {
            $update_querry = "UPDATE admin SET `first_name`='$firstName', `last_name`='$lastName', `admin_email`='$email', `phone`='$phone' WHERE `id`=$admin_id";
        } else if ( $pass == "" ) {
            $file_extension = pathinfo( $image, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
            move_uploaded_file( $_FILES['img']['tmp_name'], '../assets/images/admins/' . $filename );

            $_SESSION['loginInfo']['adminImg'] = $filename;

            $update_querry = "UPDATE admin SET `first_name`='$firstName', `last_name`='$lastName', `admin_email`='$email', `phone`='$phone', `admin_img`='$filename' WHERE `id`=$admin_id";

        } else if ( $image == "" ) {
            $pass = password_hash( $pass, PASSWORD_DEFAULT );
            $update_querry = "UPDATE admin SET `first_name`='$firstName', `last_name`='$lastName', `admin_email`='$email', `phone`='$phone', `admin_pass`='$pass' WHERE `id`=$admin_id";
        } else {
            $pass = password_hash( $pass, PASSWORD_DEFAULT );

            $file_extension = pathinfo( $image, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
            move_uploaded_file( $_FILES['img']['tmp_name'], '../assets/images/admins/' . $filename );
            $_SESSION['loginInfo']['adminImg'] = $filename;

            $update_querry = "UPDATE admin SET `first_name`='$firstName', `last_name`='$lastName', `admin_email`='$email', `phone`='$phone', `admin_img`='$filename', `admin_pass`='$pass' WHERE `id`=$admin_id";
        }
        

        $run_updateQuerry = mysqli_query( $conn, $update_querry );
        if ( $run_updateQuerry ) {
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