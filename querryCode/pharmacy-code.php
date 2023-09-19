<?php
session_start();
include "../config/dbConn.php";
if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['addPharmacy'] ) ) {
        $pharmacy_firstname = $_POST['firstName'];
        $pharmacy_lastName = $_POST['lastName'];
        $admin_email = $_POST['emailAddr'];
        $pharmacy_pass = $_POST['pass'];
        $phone = $_POST['phone'];
        $pharmacy_confirm_pass = $_POST['confirm_pass'];
        $admin_id = $_SESSION['loginInfo']["id"];
        settype( $admin_id, "integer" );

        if ( $pharmacy_pass == $pharmacy_confirm_pass ) {
            $caheckRedundantPharmacy = "SELECT id FROM pharmacy_admin WHERE `admin_email`='$admin_email'";
            $checkPharmacy_run = mysqli_query( $conn, $caheckRedundantPharmacy );

            if ( mysqli_num_rows( $checkPharmacy_run ) > 0 ) {
                $_SESSION['status'] = "Pharmacy exist";
                header( "Location: ../add-pharmacy.php" );
            } else {
                $pharmacy_pass = password_hash( $pharmacy_pass, PASSWORD_DEFAULT );
                
                $addpharmacy_querry = "INSERT INTO pharmacy_admin (`first_name`, `last_name`, `admin_email`, `admin_phone`,`admin_pass`, `admin_type`,`admin_img` ,`shop_name`,`shop_image`,`status`,`created_by`) VALUES ('$pharmacy_firstname','$pharmacy_lastName','$admin_email','$phone','$pharmacy_pass','pharmacy',' ',' ',' ','active',$admin_id)";

                $run_addPharmacyQuerry = mysqli_query( $conn, $addpharmacy_querry ); 

                if($run_addPharmacyQuerry){
                    $_SESSION['status'] = "added";
                    header( "Location: ../add-pharmacy.php" );
                }
                else{
                    $_SESSION['status'] = "wrong";
                    header( "Location: ../add-pharmacy.php" );
                }
            
                
            }
        } else {
            $_SESSION['status'] = "password does not match";
            header( "Location: ../add-pharmacy.php" );
        }
    } else if ( isset( $_POST['updatePharmacy'] ) ) {
        $pharmacy_id = $_POST['pharmacy_id'];
        $pharmacy_firstname = $_POST['firstName'];
        $pharmacy_lastName = $_POST['lastName'];
        $admin_email = $_POST['emailAddr'];
        $pharmacy_phone=$POST["phone"];
        $pharmacy_pass = $_POST['pass'];
        $pharmacy_confirm_pass = $_POST['confirm_pass']?$_POST['confirm_pass']:$_POST['pass'];

        $admin_id = $_SESSION['loginInfo']["id"];
       
        settype( $admin_id, "integer" );

        settype( $pharmacy_id, "integer" );

        if ( $pharmacy_pass == $pharmacy_confirm_pass ) {
            $updatePharmacy_querry = "UPDATE pharmacy_admin SET `first_name`='$pharmacy_firstname', `last_name`='$pharmacy_lastName',`admin_email`='$admin_email',`admin_phone`='$pharmacy_phone', `admin_pass`='$pharmacy_pass' WHERE `id`=$pharmacy_id";

            $run_updateUserQuerry = mysqli_query( $conn, $updatePharmacy_querry );
            if ( $run_updateUserQuerry ) {

                $_SESSION['status'] = "updated";
                header( "Location: ../all-pharmacy.php" );

            } else {
                $_SESSION['status'] = "wrong";
                header( "Location: ../all-pharmacy.php" );
            }
        } else {
            $_SESSION['status'] = "password does not match";
            header( "Location: ../all-pharmacy.php" );
        }

    } else if ( isset( $_GET['del_id'] ) ) {
        $pharmacy_id = $_GET['del_id'];
        settype( $pharmacy_id, "integer" );
        $delPharmacy_querry = "DELETE FROM pharmacy_admin WHERE id=$pharmacy_id";
        $run_delPharmacyQuerry = mysqli_query( $conn, $delPharmacy_querry );
        if ( $run_delPharmacyQuerry == true ) {
            $_SESSION['status'] = "Deleted Successfully";
            header( "Location: ../all-pharmacy.php" );

        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../all-pharmacy.php" );
        }

    }
} else {
    header( "Location: login.php" );
}
?>