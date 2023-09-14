<?php
session_start();
include "../config/dbConn.php";

if ( isset( $_POST['loginBTN'] ) ) {

    $email_id = $_POST['email_id'];
    $login_pass = $_POST['pass'];

    $login_querry = "SELECT * FROM admin WHERE admin_email='$email_id' LIMIT 1";
    $run_loginQuerry = mysqli_query( $conn, $login_querry );

    if ( mysqli_num_rows( $run_loginQuerry ) == 1 ) {
        $row = mysqli_fetch_assoc( $run_loginQuerry );

        if ( password_verify( $login_pass, $row['admin_pass'] ) ) {
            $_SESSION['loginInfo'] = array(
                "id"=>$row['id'],
                "firstName"=>$row['first_name'],
                "lastName"=>$row['last_name'],
                "pass"=>$row['admin_pass'],
                "email"=>$row['admin_email'],
                "adminType"=>$row['admin_type'],
                "adminImg"=>$row['admin_img']
            );

            //set up cookie
            if ( isset( $_POST["remember"] ) ) {
                setcookie( 'user_id', $row['admin_email'], time() + 86400 );
                setcookie( 'pass', $row['admin_pass'], time() + 86400 );
            }
            setcookie( 'login_status', true, time() + ( 86400 * 3 ) );

            $_SESSION['status'] = "admin login";
            header( "Location: ../index.php" );
        }

    } else {

        $_SESSION['status'] = "Failed to log in";
        header( "Location: ../login.php" );

    }
}
?>