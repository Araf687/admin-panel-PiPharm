<?php
session_start();
include "../config/dbConn.php";

if (isset($_POST['loginBTN'])) {

    $email_id = $_POST['email_id'];
    $login_pass = $_POST['pass'];
    $loginType = $_POST['loginType'];

    $login_querry = $loginType == "authority" ?
        "SELECT * FROM admin WHERE admin_email='$email_id' LIMIT 1" : "SELECT * FROM pharmacy_admin WHERE admin_email='$email_id' LIMIT 1";

    $run_loginQuerry = mysqli_query($conn, $login_querry);


    if (mysqli_num_rows($run_loginQuerry) == 1) {


        $row = mysqli_fetch_assoc($run_loginQuerry);
        // echo $row['admin_pass']."-----------------".$login_pass;

        if (password_verify($login_pass, $row['admin_pass'])) {


            if ($row['status'] == "active" || $row['admin_type'] == "admin" ) {
                $_SESSION['loginInfo'] = array(
                    "id" => $row['id'],
                    "firstName" => $row['first_name'],
                    "lastName" => $row['last_name'],
                    "pass" => $row['admin_pass'],
                    "email" => $row['admin_email'],
                    "adminImg" => $row['admin_img'],
                    "adminType" => $row['admin_type'],
                );

                //set up cookie
                if (isset($_POST["remember"])) {
                    setcookie('user_id', $row['admin_email'], time() + 86400);
                    setcookie('pass', $row['admin_pass'], time() + 86400);
                }
                setcookie('login_status', true, time() + (86400 * 3));

                $_SESSION['status'] = "login";
               
                header("Location: ../index.php");
            }
            else{
                $_SESSION['status'] = "inactive";
                header("Location: ../login.php");
            }
     

        } else {
            $_SESSION['status'] = "failed";


            // echo "Incprrect Password"."--".$login_pass."@". $row['admin_pass'] ."|| ";
            // echo "Incprrect Password"."--".password_verify($login_pass, $row['admin_pass']) ."||";
            header("Location: ../login.php");

        }

    } else {
        $_SESSION['status'] = "failed";

        header("Location: ../login.php");

    }
}
?>