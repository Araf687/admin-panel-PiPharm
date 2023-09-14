<?php
session_start();
include "../config/dbConn.php";

if(isset($_POST['loginBTN'])){
    
    $email_id=$_POST['email_id'];
    $login_pass=$_POST['pass'];
    		 
    $login_querry="SELECT * FROM admin WHERE admin_email='$email_id' LIMIT 1";
    $run_loginQuerry=mysqli_query($conn,$login_querry);
    

    if(mysqli_num_rows($run_loginQuerry)>0){

        $adminID="";$adminName="";$adminPass="";$branchId="";$adminType="";
        foreach($run_loginQuerry as $row){
          if(password_verify($login_pass, $row['admin_pass'])) {
            $id=$row['id'];
            $admin_firstName=$row['first_name'];
            $admin_lastName=$row['last_name'];
            $adminPass=$row['admin_pass'];
            $admin_email=$row['admin_email'];
            $adminType=$row['admin_type'];
            $admin_img=$row['admin_img'];

            $_SESSION['loginInfo']= array("id"=>$id,"firstName"=>$admin_firstName,"lastName"=>$admin_lastName,"pass"=>$adminPass,"email"=>$admin_email,"adminType"=>$adminType,"adminImg"=>$admin_img);
          }
        }
        $_SESSION['status']="admin login";
        header("Location: ../index.php");
        
    }
    else{ 

        echo "hi";
        // $_SESSION['status']="Failed to log in";
        // header("Location: ../login.php");
       
    }
}
?>