<?php
session_start();
include "../config/dbConn.php";

if(isset($_POST['addStore'])){

    $user_id=$_SESSION['loginInfo']["id"];
    settype($user_id,"integer");

    $store_name=$_POST['store_name'];
    $store_name=str_replace("'","",$store_name);
    $store_phone=$_POST['store_phone'];
    $store_email=$_POST['store_email'];
    $store_location=$_POST['store_location'];
    $store_logo=$_FILES['store_logo']['name'];
    $store_banner=$_FILES['store_banner']['name'];
 


    $allowed_extension= array('png','jpg','jpeg');
    $logo_file_extension=pathinfo($store_logo,PATHINFO_EXTENSION);
    $banner_file_extension=pathinfo($store_banner,PATHINFO_EXTENSION);

    $logo_filename="LG".time().'.'.$logo_file_extension;
    $banner_filename="BNR".time().'.'.$banner_file_extension;

    $addStore_query="INSERT INTO store (store_name, phone, store_location, email, logo, banner, admin_id) VALUES ('$store_name','$store_phone','$store_location','$store_email','$logo_filename','$banner_filename',$user_id)";

    echo $store_name.','.$store_phone.','.$store_location.','.$store_email.','.$logo_filename.','.$banner_filename.','.$user_id." ".gettype($user_id);

    $run_addStorequery=mysqli_query($conn,$addStore_query);
    if($run_addStorequery){

        move_uploaded_file($_FILES['store_logo']['tmp_name'], '../assets/images/store/logo/'.$logo_filename);

        move_uploaded_file($_FILES['store_banner']['tmp_name'], '../assets/images/store/banner/'.$banner_filename);

        $_SESSION['status']="Added Successfully";
        header("Location: ../store-setting.php");
        
    }
    else{
        $_SESSION['status']="something went wrong";
        header("Location: ../store-setting.php");
    }
    echo  $_SESSION['status'];
    
}

    else if(isset($_POST['UpdateStore'])){

        $store_id=$_POST['store_id'];
        settype($store_id,"integer");
    
        $store_name=$_POST['store_name'];
        $store_name=str_replace("'","",$store_name);
        $store_phone=$_POST['store_phone'];
        $store_email=$_POST['store_email'];
        $store_location=$_POST['store_location'];
        $store_logo=$_FILES['store_logo']['name'];
        $store_banner=$_FILES['store_banner']['name'];

        echo $store_name.", ".$store_phone.", ".$store_email.", ".$store_location.", ".$store_logo.", ".$store_name.", ".$store_banner.", ";


        $allowed_extension= array('png','jpg','jpeg');
        $logo_file_extension=pathinfo($store_logo,PATHINFO_EXTENSION);
        $banner_file_extension=pathinfo($store_banner,PATHINFO_EXTENSION);

        $logo_filename="LG".time().'.'.$logo_file_extension;
        $banner_filename="BNR".time().'.'.$banner_file_extension;

        $updatestore_query="";
        if($store_logo==""&&$store_banner==""){
            // that means user did not change the previous image
            $updatestore_query="UPDATE store SET store_name='$store_name', phone='$store_phone', store_location='$store_location', email='$store_email' WHERE id=$store_id";
        }
        else if($store_logo==""){

            $banner_file_extension=pathinfo($store_banner,PATHINFO_EXTENSION);
            $banner_filename="BNR".time().'.'.$banner_file_extension;
            move_uploaded_file($_FILES['store_banner']['tmp_name'], '../assets/images/store/banner/'.$banner_filename);
            $updatestore_query="UPDATE store SET store_name='$store_name', phone='$store_phone', store_location='$store_location', email='$store_email', banner='$banner_filename' WHERE id=$store_id";


        }
        else if($store_banner==""){
            $logo_file_extension=pathinfo($store_logo,PATHINFO_EXTENSION);
            $logo_filename="LG".time().'.'.$logo_file_extension;
            move_uploaded_file($_FILES['store_logo']['tmp_name'], '../assets/images/store/logo/'.$logo_filename);
            $updatestore_query="UPDATE store SET store_name='$store_name', phone='$store_phone', store_location='$store_location', email='$store_email', logo='$logo_filename' WHERE id=$store_id";


        }
        else{
            $logo_file_extension=pathinfo($store_logo,PATHINFO_EXTENSION);
            $banner_file_extension=pathinfo($store_banner,PATHINFO_EXTENSION);

            $logo_filename="LG".time().'.'.$logo_file_extension;
            $banner_filename="BNR".time().'.'.$banner_file_extension;

            move_uploaded_file($_FILES['store_logo']['tmp_name'], '../assets/images/store/logo/'.$logo_filename);

            move_uploaded_file($_FILES['store_banner']['tmp_name'], '../assets/images/store/banner/'.$banner_filename);

            $updatestore_query="UPDATE store SET store_name='$store_name', phone='$store_phone', store_location='$store_location', email='$store_email', logo='$logo_filename', banner='$banner_filename' WHERE id=$store_id";
        }
        $run_updateStoreQuery=mysqli_query($conn,$updatestore_query);
        if($run_updateStoreQuery){
            $_SESSION['status']="Updated Successfully";
            header("Location: ../store-setting.php"); 
        }
        else{
            $_SESSION['status']="something went wrong";
            header("Location: ../store-setting.php");
        }
    
    }
    else if(isset($_GET['del_id'])){
        $cat_id=$_GET['del_id'];
        settype($cat_id, "integer");
        $delCat_query="DELETE FROM category WHERE id=$cat_id";
        $run_delCatquery=mysqli_query($conn,$delCat_query);
        if($run_delCatquery==true){
            $_SESSION['status']="Deleted Successfully";
            header("Location: ../category.php"); 

        }
        else{
            $_SESSION['status']="something went wrong";
            header("Location: ../category.php");
        }

    }

?>