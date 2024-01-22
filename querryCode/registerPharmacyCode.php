<?php
session_start();
include "../config/dbConn.php";

if (isset($_POST['registerPharmacyButton'])) {

    $adminFirstName = $_POST['pharmacy_admin_first_name'];
    $adminLastName = $_POST['pharmacy_admin_last_name'];
    $pharmacy_name = $_POST['pharmacy_name'];
    $admin_email = $_POST['pharmacy_email_id'];

    $checkRedundantPharmacy = "SELECT admin_email FROM pharmacy_admin WHERE `admin_email`='$admin_email'";

    $checkPharmacy_run = mysqli_query($conn, $checkRedundantPharmacy);

    if (mysqli_num_rows($checkPharmacy_run) > 0) {
        $_SESSION['status'] = "Pharmacy exist";
        header("Location: ../register-pharmacy-admin.php");
    } else {
        $pass = password_hash( $_POST['password'], PASSWORD_DEFAULT);

        $registerPharmacySql = "INSERT INTO pharmacy_admin 
        (`first_name`, `last_name`, `admin_email`, `admin_phone`,`admin_pass`, `admin_type`,`admin_img` ,`shop_name`,`shop_image`,`brand_logo`,`status`,`created_by`)
         VALUES ('$adminFirstName','$adminLastName','$admin_email','','$pass','pharmacy',' ','$pharmacy_name',' ',' ','Not Approved',0)";

        $registerPharmacyResult = mysqli_query($conn, $registerPharmacySql);

        if ($registerPharmacyResult) {
            $inserted_pharmacy_id = $conn->insert_id;
            $addAddressQuery = "INSERT INTO pharmacy_address (`pharmacy_id`,`address`,`country`,`zip_code`,`state`,`city`) VALUES ($inserted_pharmacy_id,' ',' ',' ',' ',' ')";

            $addPharmacyAddressResult = mysqli_query($conn, $addAddressQuery);

            if ($addPharmacyAddressResult) {
                $_SESSION['status'] = "added";
                header("Location: ../register-pharmacy-admin.php");
            } else {
                $_SESSION['status'] = "Failed";
                header("Location: ../register-pharmacy-admin.php");
            }
        } else {
            $_SESSION['status'] = "Failed";
            header("Location: ../register-pharmacy-admin.php");
        }


    }


}
?>