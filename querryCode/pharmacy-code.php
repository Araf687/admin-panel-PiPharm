<?php
session_start();
include "../config/dbConn.php";
if (isset($_COOKIE['login_status'])) {
    if (isset($_POST['addPharmacy'])) {
        $pharmacy_firstname = $_POST['firstName'];
        $pharmacy_lastName = $_POST['lastName'];
        $admin_email = $_POST['emailAddr'];
        $pharmacy_pass = $_POST['pass'];
        $phone = $_POST['phone'];
        $pharmacy_confirm_pass = $_POST['confirm_pass'];
        $admin_id = $_SESSION['loginInfo']["id"];
        settype($admin_id, "integer");

        if ($pharmacy_pass == $pharmacy_confirm_pass) {
            $caheckRedundantPharmacy = "SELECT id FROM pharmacy_admin WHERE `admin_email`='$admin_email'";
            $checkPharmacy_run = mysqli_query($conn, $caheckRedundantPharmacy);

            if (mysqli_num_rows($checkPharmacy_run) > 0) {
                $_SESSION['status'] = "Pharmacy exist";
                header("Location: ../add-pharmacy.php");
            } else {
                $pharmacy_pass = password_hash($pharmacy_pass, PASSWORD_DEFAULT);

                $addpharmacy_querry = "INSERT INTO pharmacy_admin 
                (`first_name`, `last_name`, `admin_email`, `admin_phone`,`admin_pass`, `admin_type`,`admin_img` ,`shop_name`,`shop_image`,`brand_logo`,`status`,`created_by`)
                 VALUES ('$pharmacy_firstname','$pharmacy_lastName','$admin_email','$phone','$pharmacy_pass','pharmacy',' ',' ',' ',' ','Active',$admin_id)";

                $run_addPharmacyQuerry = mysqli_query($conn, $addpharmacy_querry);

                if ($run_addPharmacyQuerry) {
                    $inserted_pharmacy_id = $conn->insert_id;
                    $addAddressQuery = "INSERT INTO pharmacy_address (`pharmacy_id`,`address`,`country`,`zip_code`,`state`,`city`) VALUES ($inserted_pharmacy_id,' ',' ',' ',' ',' ')";

                    $run_addAddressQuerry = mysqli_query($conn, $addAddressQuery);

                    if ($run_addAddressQuerry) {
                        $_SESSION['status'] = "added";
                        header("Location: ../add-pharmacy.php");
                    } else {
                        $_SESSION['status'] = "wrong address";
                        header("Location: ../add-pharmacy.php");
                    }
                } else {
                    $_SESSION['status'] = "wrong";
                    header("Location: ../add-pharmacy.php");
                }


            }
        } else {
            $_SESSION['status'] = "password does not match";
            header("Location: ../add-pharmacy.php");
        }
    } else if (isset($_POST['updatePharmacy'])) {
        $pharmacy_id = $_POST['pharmacy_id'];
        $pharmacy_firstname = $_POST['firstName'];
        $pharmacy_lastName = $_POST['lastName'];
        $admin_email = $_POST['emailAddr'];
        $pharmacy_phone = $_POST["phone"];

        $pharmacy_admin_img = isset($_FILES['admin_img']['name']) && $_FILES['admin_img']['name'] != '' ? $_FILES['admin_img']['name'] : null;

        $admin_id = $_SESSION['loginInfo']["id"];

        settype($admin_id, "integer");

        settype($pharmacy_id, "integer");


        // image 
        $filename = '';
        if ($pharmacy_admin_img) {
            $allowed_extension = array('png', 'jpg', 'jpeg');
            $file_extension = pathinfo($pharmacy_admin_img, PATHINFO_EXTENSION);
            $filename = time() . '.' . $file_extension;
        }

        $query1 = "UPDATE pharmacy_admin SET `first_name`='$pharmacy_firstname', `last_name`='$pharmacy_lastName',`admin_email`='$admin_email',`admin_phone`='$pharmacy_phone' WHERE `id`=$pharmacy_id";

        $query2 = "UPDATE pharmacy_admin SET `first_name`='$pharmacy_firstname', `last_name`='$pharmacy_lastName',`admin_email`='$admin_email',`admin_phone`='$pharmacy_phone', `admin_img`='$filename' WHERE `id`=$pharmacy_id";

        $updatePharmacy_querry = $pharmacy_admin_img ? $query2 : $query1;

        $run_updateUserQuerry = mysqli_query($conn, $updatePharmacy_querry);
        if ($run_updateUserQuerry) {

            if ($filename != '') {
                move_uploaded_file($_FILES['admin_img']['tmp_name'], '../assets/images/pharmacy_admins/' . $filename);
            }

            $_SESSION['status'] = "updated";
            header($pharmacy_admin_img ? "Location: ../setting.php" : "Location: ../all-pharmacy.php");

        } else {
            $_SESSION['status'] = "wrong";
            header($pharmacy_admin_img ? "Location: ../setting.php" : "Location: ../all-pharmacy.php");
        }


    } else if (isset($_GET['del_id'])) {
        echo "as";
        $pharmacy_id = $_GET['del_id'];
        settype($pharmacy_id, "integer");
        $delPharmacy_querry = "DELETE FROM pharmacy_admin WHERE id=$pharmacy_id";
        $run_delPharmacyQuerry = mysqli_query($conn, $delPharmacy_querry);
        if ($run_delPharmacyQuerry == true) {

            // $delPharmacyAddress_querry = "DELETE FROM pharmacy_address WHERE id=$pharmacy_id";
            // $run_delPharmacyAddressQuerry = mysqli_query( $conn, $delPharmacyAddress_querry );

            // if($run_delPharmacyAddressQuerry){

            // }


            $_SESSION['status'] = "Deleted Successfully";
            header("Location: ../all-pharmacy.php");

        } else {
            $_SESSION['status'] = "something went wrong";
            header("Location: ../all-pharmacy.php");
        }

    }
} else {
    header("Location: login.php");
}
?>