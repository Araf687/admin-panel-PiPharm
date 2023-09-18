<?php
session_start();
include "../config/dbConn.php";
if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['addUser'] ) ) {
        // user_name	user_email	user_type	user_pass
        $user_firstName = $_POST['firstName'];
        $user_lastName = $_POST['lastName'];
        $user_email = $_POST['emailAddr'];
        $user_pass = $_POST['pass'];
        $phone = $_POST['phone'];
        $user_confirm_pass = $_POST['confirm_pass'];
        $admin_id = $_SESSION['loginInfo']["id"];
        settype( $admin_id, "integer" );

        $noOfAddress = $_POST['noOfAddress'];
        settype( $noOfAddress, "integer" );
        $i = 1;

        if ( $user_pass == $user_confirm_pass ) {
            $caheckRedundantUser = "SELECT id FROM user WHERE `user_email`='$user_email'";
            $caheckUser_run = mysqli_query( $conn, $caheckRedundantUser );

            if ( mysqli_num_rows( $caheckUser_run ) > 0 ) {
                $_SESSION['status'] = "User exist";
                header( "Location: ../add-pharmacy.php" );
            } else {
                $user_pass = password_hash( $user_pass, PASSWORD_DEFAULT );
                $addUser_querry = "INSERT INTO user (`first_name`, `last_name`, `user_email`, `user_phone`, `user_type`, `user_pass`,`admin_id`) VALUES ('$user_firstName','$user_lastName','$user_email','$phone','','$user_pass',$admin_id)";
                $run_addUserQuerry = mysqli_query( $conn, $addUser_querry );

                if ( $run_addUserQuerry ) {
                    $user_id = mysqli_insert_id( $conn );
                    settype( $user_id, "integer" );
                    for ( $i = 1; $i <= $noOfAddress; $i++ ) {
                        if ( isset( $_POST["addr$i" . "_main"] ) ) {
                            $mainAddr = $_POST["addr$i" . "_main"];
                            $country = $_POST["addr$i" . "_country"];
                            $city = $_POST["addr$i" . "_city"];
                            $state = $_POST["addr$i" . "_state"];
                            $zipCode = $_POST["addr$i" . "_zip"];
                            $addUserAddress_querry = "INSERT INTO user_address (`user_id`, `admin_id`, `address`, `city`, `state`, `country`, `zip_code`) VALUES ($user_id,$admin_id,'$mainAddr', '$city','$state', '$country', '$zipCode')";

                            $run_addUserAddrQuerry = mysqli_query( $conn, $addUserAddress_querry );
                            if ( $run_addUserAddrQuerry ) {
                                $_SESSION['status'] = "added";
                            }
                        }
                    }
                    header( "Location: ../add-pharmacy.php" );
                } else {
                    $_SESSION['status'] = "something went wrong";
                    header( "Location: ../add-pharmacy.php" );
                }
            }
        } else {
            $_SESSION['status'] = "password does not match";
            header( "Location: ../add-pharmacy.php" );
        }
    } else if ( isset( $_POST['UpdateUser'] ) ) {
        $user_id = $_POST['user_id'];
        $user_firstName = $_POST['firstName'];
        $user_lastName = $_POST['lastName'];
        $user_email = $_POST['emailAddr'];
        $user_pass = $_POST['pass'];
        $user_confirm_pass = $_POST['confirm_pass'];
        $admin_id = $_SESSION['loginInfo']["id"];
        settype( $admin_id, "integer" );

        settype( $user_id, "integer" );

        $noOfAddress = $_POST['noOfAddress'];
        settype( $noOfAddress, "integer" );

        if ( $user_pass == $user_confirm_pass ) {
            $updateUser_querry = "UPDATE user SET `first_name`='$user_firstName', `last_name`='$user_lastName',`user_email`='$user_email', `user_pass`='user_pass' WHERE `id`=$user_id";
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
                header( "Location: ../all-pharmacy.php" );
            } else {
                $_SESSION['status'] = "something went wrong";
                header( "Location: ../all-pharmacy.php" );
            }
        } else {
            $_SESSION['status'] = "password does not match";
            header( "Location: ../all-pharmacy.php" );
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