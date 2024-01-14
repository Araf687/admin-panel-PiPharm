<?php
session_start();
include "../config/dbConn.php";
include "./supportiveFunction.php";
if (isset($_COOKIE['login_status'])) {
    if (isset($_POST['addStore']) || isset($_POST['UpdateStore'])) {

        $pahrmacy_id = $_SESSION['loginInfo']["id"];
        settype($pahrmacy_id, "integer");

        $store_id = $_POST['store_id'];
        $store_name = $_POST['shop_name'];
        $store_phone = $_POST['store_phone'];
        $store_email = $_POST['store_email'];
        $store_location = $_POST['store_location'];
        $store_logo = $_FILES['store_logo']['name'];
        $store_banner = $_FILES['store_banner']['name'];

        $allowed_extension = array('png', 'jpg', 'jpeg');

        $logo_file_extension = pathinfo($store_logo, PATHINFO_EXTENSION);
        $banner_file_extension = pathinfo($store_banner, PATHINFO_EXTENSION);

        $logo_filename = "LG" . time() . '.' . $logo_file_extension;
        $banner_filename = "BNR" . time() . '.' . $banner_file_extension;

        $address = $_POST['addr_main'];
        $city = $_POST['addr_city'];
        $state = $_POST['addr_state'];
        $country = $_POST['addr_country'];
        $zipCode = $_POST['addr_zip'];

        $latLong = explode(',', $_POST['latLong']);

        $latitude = floatval($latLong[0]);
        $longitude = floatval($latLong[1]);

        $updatePharmacy = '';

        if (isset($_FILES['store_logo']) && $_FILES["store_logo"]["error"] == UPLOAD_ERR_OK && isset($_FILES['store_banner']) && $_FILES["store_banner"]["error"] == UPLOAD_ERR_OK) {
            $updatePharmacy = "UPDATE pharmacy_admin SET `shop_name`='$store_name', `shop_image`='$banner_filename', `brand_logo`='$logo_filename' WHERE `id`=$store_id";
        } else if (isset($_FILES['store_logo']) && $_FILES["store_logo"]["error"] == UPLOAD_ERR_OK) {
            $updatePharmacy = "UPDATE pharmacy_admin SET `shop_name`='$store_name', `brand_logo`='$logo_filename' WHERE `id`=$store_id";

        } else if (isset($_FILES['store_banner']) && $_FILES["store_banner"]["error"] == UPLOAD_ERR_OK) {
            $updatePharmacy = "UPDATE pharmacy_admin SET `shop_name`='$store_name', `shop_image`='$banner_filename'  WHERE `id`=$store_id";
        }
        else{
            $updatePharmacy = "UPDATE pharmacy_admin SET `shop_name`='$store_name' WHERE `id`=$store_id";
        }

        $updatePharmacyAddress = "UPDATE pharmacy_address SET `address`='$address',`country`='$country', `zip_code`='$zipCode',`state`='$state',`city`='$city',`latitude`=$latitude, `longitude`=$longitude WHERE `pharmacy_id`=$store_id";


        $run_updateStorequery = mysqli_query($conn, $updatePharmacy);

        if ($run_updateStorequery) {

            if (isset($_FILES['store_logo']) && $_FILES["store_logo"]["error"] == UPLOAD_ERR_OK) {

                $folderPathLogo='../assets/images/store/logo/';
                $targetedFile=$_FILES['store_logo']['tmp_name'];
                $prevLogoName=$_POST['prevLogo'];

                if($prevLogoName){
                    deleteImageFromFolder($prevLogoName,$folderPathLogo);
                }
              
                uploadImage($logo_filename, $folderPathLogo, $targetedFile);

                // move_uploaded_file($targetedFile, $folderPath . $logo_filename);

            }
            if (isset($_FILES['store_banner'])&& $_FILES["store_banner"]["error"] == UPLOAD_ERR_OK) {

                $folderPathBanner='../assets/images/store/banner/';
                $targetedFile=$_FILES['store_banner']['tmp_name'];
                $prevBannerName=$_POST['prevBanner'];
                if($prevBannerName){
                    
                    deleteImageFromFolder($prevBannerName,$folderPathBanner);
                }
               
                uploadImage($banner_filename, $folderPathBanner,$targetedFile);
                // move_uploaded_file($targetedFile, $folderPath. $banner_filename);

            }

            $run_updatePharmacyAddress = mysqli_query($conn, $updatePharmacyAddress);

            if ($run_updatePharmacyAddress) {

                $_SESSION['status'] = "Added Successfully";
                header("Location: ../store-setting.php");

            }
        } else {
            $_SESSION['status'] = "something went wrong";
            header("Location: ../store-setting.php");
        }

    }

} else {
    header("Location: login.php");
}

?>