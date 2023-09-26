<?php
session_start();
include "../config/dbConn.php";
if ( isset( $_COOKIE['login_status'] ) ) {
    if ( isset( $_POST['addStore'] ) || isset( $_POST['UpdateStore'] )) {

        $pahrmacy_id = $_SESSION['loginInfo']["id"];
        settype( $pahrmacy_id, "integer" );

        $store_id = $_POST['store_id'];
        $store_name = $_POST['shop_name'];
        $store_phone = $_POST['store_phone'];
        $store_email = $_POST['store_email'];
        $store_location = $_POST['store_location'];
        $store_logo = $_FILES['store_logo']['name'];
        $store_banner = $_FILES['store_banner']['name'];

        $allowed_extension = array( 'png', 'jpg', 'jpeg' );
        $logo_file_extension = pathinfo( $store_logo, PATHINFO_EXTENSION );
        $banner_file_extension = pathinfo( $store_banner, PATHINFO_EXTENSION );

        $logo_filename = "LG" . time() . '.' . $logo_file_extension;
        $banner_filename = "BNR" . time() . '.' . $banner_file_extension;

        $address = $_POST['addr_main'];
        $city = $_POST['addr_city'];
        $state = $_POST['addr_state'];
        $country = $_POST['addr_country'];
        $zipCode = $_POST['addr_zip'];


        $updatePharmacy = "UPDATE pharmacy_admin SET `shop_name`='$store_name', `shop_image`='$banner_filename', `brand_logo`='$logo_filename' WHERE `id`=$store_id";

        $updatePharmacyAddress = "UPDATE pharmacy_address SET `address`='$address',`country`='$country', `zip_code`='$zipCode',`state`='$state',`city`='$city' WHERE `pharmacy_id`=$store_id";

        $run_updateStorequery = mysqli_query( $conn, $updatePharmacy );

        echo $updatePharmacyAddress."    ".$updatePharmacy ;
        // if ( $run_updateStorequery ) {

        //     if(!isset( $_POST['UpdateStore'] )){
        //         move_uploaded_file( $_FILES['store_logo']['tmp_name'], '../assets/images/store/logo/' . $logo_filename );

        //         move_uploaded_file( $_FILES['store_banner']['tmp_name'], '../assets/images/store/banner/' . $banner_filename );
        //     }

        //     $run_updatePharmacyAddress = mysqli_query( $conn, $updatePharmacyAddress );

        //     if($run_updatePharmacyAddress){

        //         $_SESSION['status'] = "Added Successfully";
        //         header( "Location: ../store-setting.php" );

        //     }
        // } else {
        //     $_SESSION['status'] = "something went wrong";
        //     header( "Location: ../store-setting.php" );
        // }

    }
    //  else if ( isset( $_POST['UpdateStore'] ) ) {

    //     $store_id = $_POST['store_id'];
    //     settype( $store_id, "integer" );

    //     $store_name = $_POST['store_name'];
    //     $store_name = str_replace( "'", "", $store_name );
    //     $store_phone = $_POST['store_phone'];
    //     $store_email = $_POST['store_email'];
    //     $store_location = $_POST['store_location'];
    //     $store_logo = $_FILES['store_logo']['name'];
    //     $store_banner = $_FILES['store_banner']['name'];

    //     $allowed_extension = array( 'png', 'jpg', 'jpeg' );
    //     $logo_file_extension = pathinfo( $store_logo, PATHINFO_EXTENSION );
    //     $banner_file_extension = pathinfo( $store_banner, PATHINFO_EXTENSION );

    //     $logo_filename = "LG" . time() . '.' . $logo_file_extension;
    //     $banner_filename = "BNR" . time() . '.' . $banner_file_extension;

    //     $updatestore_query = "";
    //     if ( $store_logo == "" && $store_banner == "" ) {
    //         // that means user did not change the previous image
    //         $updatestore_query = "UPDATE store SET `store_name`='$store_name', `phone`='$store_phone', `store_location`='$store_location', `email`='$store_email' WHERE `id`=$store_id";
    //     } else if ( $store_logo == "" ) {

    //         $banner_file_extension = pathinfo( $store_banner, PATHINFO_EXTENSION );
    //         $banner_filename = "BNR" . time() . '.' . $banner_file_extension;
    //         move_uploaded_file( $_FILES['store_banner']['tmp_name'], '../assets/images/store/banner/' . $banner_filename );
    //         $updatestore_query = "UPDATE store SET `store_name`='$store_name', `phone`='$store_phone', `store_location`='$store_location', `email`='$store_email', `banner`='$banner_filename' WHERE `id`=$store_id";

    //     } else if ( $store_banner == "" ) {
    //         $logo_file_extension = pathinfo( $store_logo, PATHINFO_EXTENSION );
    //         $logo_filename = "LG" . time() . '.' . $logo_file_extension;
    //         move_uploaded_file( $_FILES['store_logo']['tmp_name'], '../assets/images/store/logo/' . $logo_filename );
    //         $updatestore_query = "UPDATE store SET `store_name`='$store_name', `phone`='$store_phone', `store_location`='$store_location', `email`='$store_email', `logo`='$logo_filename' WHERE `id`=$store_id";

    //     } else {
    //         $logo_file_extension = pathinfo( $store_logo, PATHINFO_EXTENSION );
    //         $banner_file_extension = pathinfo( $store_banner, PATHINFO_EXTENSION );

    //         $logo_filename = "LG" . time() . '.' . $logo_file_extension;
    //         $banner_filename = "BNR" . time() . '.' . $banner_file_extension;

    //         move_uploaded_file( $_FILES['store_logo']['tmp_name'], '../assets/images/store/logo/' . $logo_filename );

    //         move_uploaded_file( $_FILES['store_banner']['tmp_name'], '../assets/images/store/banner/' . $banner_filename );

    //         $updatestore_query = "UPDATE store SET `store_name`='$store_name', `phone`='$store_phone', `store_location`='$store_location', `email`='$store_email', `logo`='$logo_filename', `banner`='$banner_filename' WHERE `id`=$store_id";
    //     }
    //     $run_updateStoreQuery = mysqli_query( $conn, $updatestore_query );
    //     if ( $run_updateStoreQuery ) {
    //         $_SESSION['status'] = "Updated Successfully";
    //         header( "Location: ../store-setting.php" );
    //     } else {
    //         $_SESSION['status'] = "something went wrong";
    //         header( "Location: ../store-setting.php" );
    //     }

    // }

} else {
    header( "Location: login.php" );
}

?>