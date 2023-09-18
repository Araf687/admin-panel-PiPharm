<?php
session_start();
include "../config/dbConn.php";
if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['addAdmin'] ) ) {

        // get admin information
        $admin_firstName = $_POST['firstName'];
        $admin_lastName = $_POST['lastName'];
        $admin_email = $_POST['emailAddr'];
        $admin_img = $_FILES['admin_img']['name'];
        $admin_pass = $_POST['pass'];

        // image 
        $filename = '';
        if ( $admin_img != '' ) {
            $allowed_extension = array( 'png', 'jpg', 'jpeg' );
            $file_extension = pathinfo( $admin_img, PATHINFO_EXTENSION );
            $filename = time() . '.' . $file_extension;
        }
        
        $phone = $_POST['phone'];
        $admin_confirm_pass = $_POST['confirm_pass'];

        // echo  $admin_pass ." - ". $admin_confirm_pass." - ".$admin_img ;

        if ( $admin_pass == $admin_confirm_pass ) {

       
            $admin_pass = password_hash($admin_pass, PASSWORD_DEFAULT);

            $checkRedundantAdmin = "SELECT id FROM admin WHERE `admin_email`='$admin_email'";
            $checkAdmin_run = mysqli_query( $conn, $checkRedundantAdmin );



            if ( mysqli_num_rows( $checkAdmin_run ) > 0 ) {
                $_SESSION['status'] = "Admin exist";
                header( "Location: ../add-admin.php" );
            } else {
                $admin_pass = password_hash( $admin_pass, PASSWORD_DEFAULT );
                $addAdmin_querry = "INSERT INTO admin (`first_name`, `last_name`, `admin_email`, `phone`, `admin_img`, `admin_type`, `admin_pass`) VALUES ('$admin_firstName','$admin_lastName','$admin_email', '$phone', '$filename', '','$admin_pass')";
                $run_addAdminQuerry = mysqli_query( $conn, $addAdmin_querry );

                if ( $run_addAdminQuerry ) {

                    if ( $filename != '' ) {
                        move_uploaded_file( $_FILES['admin_img']['tmp_name'], '../assets/images/admins/' . $filename );
                    }

                    $_SESSION['status'] = "added";
                    header( "Location: ../all-admin.php" );  
                        
                } else {
                    $_SESSION['status'] = "wrong";
                    header( "Location: ../add-admin.php" );
                }
            }
        } else {
            $_SESSION['status'] = "password does not match";
            header( "Location: ../add-admin.php" );
        }
    } else if ( isset( $_POST['UpdateUser'] ) ) {
        $user_id = $_POST['user_id'];
        $admin_firstName = $_POST['firstName'];
        $admin_lastName = $_POST['lastName'];
        $admin_email = $_POST['emailAddr'];
        $admin_pass = $_POST['pass'];
        $admin_confirm_pass = $_POST['confirm_pass'];
        $admin_id = $_SESSION['loginInfo']["id"];
        settype( $admin_id, "integer" );

        settype( $user_id, "integer" );

        $noOfAddress = $_POST['noOfAddress'];
        settype( $noOfAddress, "integer" );

        if ( $admin_pass == $admin_confirm_pass ) {
            $updateUser_querry = "UPDATE user SET `first_name`='$admin_firstName', `last_name`='$admin_lastName',`admin_email`='$admin_email', `admin_pass`='admin_pass' WHERE `id`=$user_id";
            ;

            $run_updateUserQuerry = mysqli_query( $conn, $updateUser_querry );
            if ( $run_updateUserQuerry ) {
                $deletePrevUserAddr = "DELETE FROM user_address WHERE user_id=$user_id";
                $run_query = mysqli_query( $conn, $deletePrevUserAddr );
                if ( $run_query ) {
                    for ( $i = 1; $i <= $noOfAddress; $i++ ) {
                        if ( isset( $_POST["addr$i" . "_main"] ) ) {
                            $mainAddr = $_POST["addr$i" . "_main"];
                            $country = $_POST["addr$i" . "_country"];
                            $city = $_POST["addr$i" . "_city"];
                            $state = $_POST["addr$i" . "_state"];
                            $zipCode = $_POST["addr$i" . "_zip"];

                            $addUserAddress_querry = "INSERT INTO user_address (`user_id`, `admin_id`, `address`, `city`, `state`, `country`, `zip_code`) VALUES ($user_id, $admin_id,'$mainAddr', '$city','$state', '$country', '$zipCode')";

                            $run_addUserAddrQuerry = mysqli_query( $conn, $addUserAddress_querry );
                            if ( $run_addUserAddrQuerry ) {
                                $_SESSION['status'] = "updated";
                            }
                        }
                    }
                } else {
                    $_SESSION['status'] = "user address not found";
                }
                header( "Location: ../users.php" );
            } else {
                $_SESSION['status'] = "something went wrong";
                header( "Location: ../users.php" );
            }
        } else {
            $_SESSION['status'] = "password does not match";
            header( "Location: ../users.php" );
        }

    } else if ( isset( $_GET['del_id'] ) ) {
        $user_id = $_GET['del_id'];
        settype( $user_id, "integer" );
        $delUser_querry = "DELETE FROM user WHERE id=$user_id";
        $run_delUserQuerry = mysqli_query( $conn, $delUser_querry );
        if ( $run_delUserQuerry == true ) {
            $deleteUserAddr = "DELETE FROM user_address WHERE `user_id`=$user_id";
            $run_query = mysqli_query( $conn, $deleteUserAddr );
            if ( $run_query ) {
                $_SESSION['status'] = "Deleted Successfully";
            }
            header( "Location: ../users.php" );

        } else {
            $_SESSION['status'] = "something went wrong";
            header( "Location: ../users.php" );
        }

    }
} else {
    header( "Location: login.php" );
}
?>