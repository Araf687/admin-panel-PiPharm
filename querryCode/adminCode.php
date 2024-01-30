<?php
session_start();
include "../config/dbConn.php";
if (isset($_COOKIE['login_status'])) {
    if (isset($_POST['addAdmin'])) {

        // get admin information
        $admin_firstName = $_POST['firstName'];
        $admin_lastName = $_POST['lastName'];
        $admin_email = $_POST['emailAddr'];
        $admin_img = $_FILES['admin_img']['name'];
        $admin_pass = $_POST['pass'];

        // image 
        $filename = '';
        if ($admin_img != '') {
            $allowed_extension = array('png', 'jpg', 'jpeg');
            $file_extension = pathinfo($admin_img, PATHINFO_EXTENSION);
            $filename = time() . '.' . $file_extension;
        }

        $phone = $_POST['phone'];
        $admin_confirm_pass = $_POST['confirm_pass'];

        // echo  $admin_pass ." - ". $admin_confirm_pass." - ".$admin_img ;

        if ($admin_pass == $admin_confirm_pass) {


            $checkRedundantAdmin = "SELECT id FROM admin WHERE `admin_email`='$admin_email'";
            $checkAdmin_run = mysqli_query($conn, $checkRedundantAdmin);



            if (mysqli_num_rows($checkAdmin_run) > 0) {
                $_SESSION['status'] = "Admin exist";
                header("Location: ../add-admin.php");
            } else {

                $admin_pass = password_hash($_POST['pass'], PASSWORD_DEFAULT);

                $addAdmin_querry = "INSERT INTO admin (`first_name`, `last_name`, `admin_email`, `phone`, `admin_img`, `admin_type`, `admin_pass`) VALUES ('$admin_firstName','$admin_lastName','$admin_email', '$phone', '$filename', 'admin','" . $admin_pass . "')";



                $run_addAdminQuerry = mysqli_query($conn, $addAdmin_querry);

                if ($run_addAdminQuerry) {

                    if ($filename != '') {
                        move_uploaded_file($_FILES['admin_img']['tmp_name'], '../assets/images/admins/' . $filename);
                    }

                    $_SESSION['status'] = "added";
                    header("Location: ../all-admin.php");

                } else {
                    $_SESSION['status'] = "wrong";
                    header("Location: ../add-admin.php");
                }
            }
        } else {
            $_SESSION['status'] = "password does not match";
            header("Location: ../add-admin.php");
        }
    } else if (isset($_POST['editAdmin'])) {
        $admin_id = $_POST['admin_id'];
        $admin_firstName = $_POST['firstName'];
        $admin_lastName = $_POST['lastName'];
        $admin_email = $_POST['emailAddr'];
        $admin_img = $_FILES['admin_img']['name'];

        settype($admin_id, "integer");

         // image 
         $filename = '';
         if ($admin_img != '') {
             $allowed_extension = array('png', 'jpg', 'jpeg');
             $file_extension = pathinfo($admin_img, PATHINFO_EXTENSION);
             $filename = time() . '.' . $file_extension;
         }



        $query1 = "UPDATE admin SET `first_name`='$admin_firstName', `last_name`='$admin_lastName',`admin_email`='$admin_email' WHERE `id`=$admin_id";

        $query2 = "UPDATE admin SET `first_name`='$admin_firstName', `last_name`='$admin_lastName',`admin_email`='$admin_email', `admin_img`='$filename' WHERE `id`=$admin_id";

        $updateAdmin_querry= $filename ==''?$query1:$query2;
        

        $run_updateUserQuerry = mysqli_query($conn, $updateAdmin_querry);
        if ($run_updateUserQuerry) {
            if ($filename != '') {
                $_SESSION['status'] = "updated admin";
                move_uploaded_file($_FILES['admin_img']['tmp_name'], '../assets/images/admins/' . $filename);
            }
            header("Location: ../all-admin.php");
        } else {
            $_SESSION['status'] = "something went wrong";
            header("Location: ../all-admin.php");
        }


    } else if (isset($_GET['del_id'])) {
        $user_id = $_GET['del_id'];
        settype($user_id, "integer");
        $delUser_querry = "DELETE FROM admin WHERE id=$user_id";
        $run_delUserQuerry = mysqli_query($conn, $delUser_querry);
        if ($run_delUserQuerry == true) {

            $_SESSION['status'] = "Deleted Successfully";

            header("Location: ../all-admin.php");

        } else {
            $_SESSION['status'] = "Failed to delete admin.";
            header("Location: ../all-admin.php");
        }

    }
} else {
    header("Location: login.php");
}
?>