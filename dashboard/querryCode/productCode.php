<?php
session_start();
include "../config/dbConn.php";

if(isset($_POST['addProduct'])){
    $description=$_POST['prd_desc'];
    $user_id=$_SESSION['loginInfo']["id"];
    $prd_name=$_POST['prd_name'];
    $prd_cat=$_POST['category'];
    $prd_price=$_POST['prod_price'];
    $prd_sku=$_POST["sku"];
    $prd_status=$_POST['status'];
    $noOf_attr=$_POST['noOfAttr'];

    

    settype($prd_cat,"integer");
    settype($prd_price,"float");

    // echo $prd_name." ".$prd_cat." ".$prd_price." ".$prd_sku." ".$prd_status." ".$noOf_attr;

    // product image 
    $prd_image=$_FILES['files'];
    $fileNameAsString="";
    if(isset($prd_image) && !empty($prd_image)){
        // Loop through each file
        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            // Get the temp file path
            $tmp_file_path = $tmp_name;
     
            // Make sure the file exists
            if(file_exists($tmp_file_path)){
                // Generate a new file name
                $new_file_name = time().'-'.$key.$_FILES['files']['name'][$key];

                if($fileNameAsString==""){
                    $fileNameAsString=$fileNameAsString.$new_file_name;
                }
                else{
                    $fileNameAsString=$fileNameAsString."@".$new_file_name;
                }

     
                // Set the destination path
                $destination = '../assets/images/product/'.$new_file_name;

                // Move the file to the destination
                move_uploaded_file($tmp_file_path, $destination);
            }
        }
        echo $fileNameAsString; 
    }

    //check product slug is already exist or not
    $prod_slug = strtolower(str_replace(' ', '-', $prd_name));
    $prod_slug=str_replace("'", '', $prod_slug);

    $checkProdSlug="SELECT prd_id FROM product WHERE slug='$prod_slug'";
    $checkProdSlug_run=mysqli_query($conn,$checkProdSlug);

    if(mysqli_num_rows($checkProdSlug_run)>0){
        //adding random number to make the slug unique
        $prod_slug=$prod_slug.rand(1,1000); 
    }

   
    if( $noOf_attr==1 && !isset($_POST["attr1nameId1"])){
        $addPrd_querry="INSERT INTO product (prd_image, prd_name, prd_cat_id, prd_price, prd_description, slug, attributes, prd_sku, prd_status, admin_id) VALUES ('$fileNameAsString','$prd_name',$prd_cat,$prd_price,'$description','$prod_slug','','$prd_sku','$prd_status','$user_id')";

        $run_addPrdQuerry=mysqli_query($conn,$addPrd_querry);
        if($run_addPrdQuerry){
            
            $_SESSION['status']="Added Successfully";
            header("Location: ../add-product.php");
        
        }
        else{
            $_SESSION['status']="something went wrong";
            header("Location: ../add-category.php");
        }
    }
    else{
        //concat all attribute id in a string
        $i=0;
        $attrId="";
        for($i=1;$i<=$noOf_attr;$i++){
            if(isset($_POST["attr$i"])){
                if($attrId==""){
                    $attrId.=$_POST["attr$i"];
                }
                else{
                    $attrId.="@".$_POST["attr$i"];
                }
                
            }
            
        }

    
        $addPrd_querry="INSERT INTO product (prd_image, prd_name, prd_cat_id, prd_price, prd_description, slug, attributes, prd_sku, prd_status, admin_id) VALUES ('$fileNameAsString','$prd_name',$prd_cat,$prd_price,'$description','$prod_slug','$attrId','$prd_sku','$prd_status','$user_id')";

        $run_addPrdQuerry=mysqli_query($conn,$addPrd_querry);
        if($run_addPrdQuerry){

            $prd_id=mysqli_insert_id($conn);

             // extended value of attributes
             for($i=1;$i<=$noOf_attr;$i++){
                if(isset($_POST["attr$i"])==1){
                    $attrId=$_POST["attr$i"];
                    settype($attrId,"integer");
                    $total_values=$_POST["total_attr$i"."Values"];

                    for($j=1;$j<=$total_values;$j++){
                        //checck wheather attribute sets or not
                            $attrValueId=$_POST["attr$i"."nameId$j"];
                            $extendedPrice=$_POST["attr$i"."value$j"];

                            settype($attrValueId,"integer");
                            settype($extendedPrice,"float");

                            $addPrdExtVal_querry="INSERT INTO prod_attribute_values (prd_id, attr_id, attr_val_id, extended_price) VALUES ($prd_id,$attrId,$attrValueId,$extendedPrice)";

                            $run_addExtValQuerry=mysqli_query($conn,$addPrdExtVal_querry);
                            if($run_addExtValQuerry){
                                $_SESSION['status']="Added Successfully";
                                header("Location: ../products.php");
                            }
                            else{
                                $_SESSION['status']="something went wrong";
                                header("Location: ../products.php");
                            }
                        

                    }
                }
        
            }
        
        }
        else{
            $_SESSION['status']="something went wrong";
            header("Location: ../add-category.php");
        }
    }
    
}

    else if(isset($_POST['UpdateProduct'])){
        $prd_id=$_POST['prd_id'];
        $prd_name=$_POST['prd_name'];
        $prd_cat=$_POST['category'];
        $prd_price=$_POST['prod_price'];
        $prd_sku=$_POST["sku"];
        $prd_status=$_POST['status'];
        $description=$_POST['prd_desc'];
        $noOf_attr=$_POST['noOfAttr'];

        //get products previous images
        $previousImages=$_POST['prev_img'];

        settype($prd_cat,"integer");
        settype($prd_id,"integer");
        settype($prd_price,"float");
        
       
    
        // product image 
        $prd_image=$_FILES['files'];
        $fileNameAsString="";

        $updatePrd_query="";

        settype($cat_id,"integer");
        
        //concat all attribute id in a string
        $i=0;
        $attrId="";
        for($i=1;$i<=$noOf_attr;$i++){
            if(isset($_POST["attr$i"])){
                if($attrId==""){
                    $attrId.=$_POST["attr$i"];
                }
                else{
                    $attrId.="@".$_POST["attr$i"];
                }
                
            }
            
        }
        if($attrId=="Select Attribute"){
            $attrId="";
        }

        if($prd_image["name"]["0"]==""){
            // that means user did not change the previous image
            $updatePrd_query="UPDATE product SET prd_name='$prd_name', prd_cat_id=$prd_cat, prd_price=$prd_price, prd_description='$description', attributes='$attrId', prd_sku='$prd_sku', prd_status='$prd_status' WHERE prd_id=$prd_id";
            
        }
        
        else{
            foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
                // Get the temp file path
                $tmp_file_path = $tmp_name;
         
                // Make sure the file exists
                if(file_exists($tmp_file_path)){
                    // Generate a new file name
                    $new_file_name = time().'-'.$_FILES['files']['name'][$key];
    
                    if($fileNameAsString==""){
                        $fileNameAsString=$fileNameAsString.$new_file_name;
                    }
                    else{
                        $fileNameAsString=$fileNameAsString."@".$new_file_name;
                    }
    
         
                    // Set the destination path
                    $destination = '../assets/images/product/'.$new_file_name;

    
                    // Move the file to the destination
                    move_uploaded_file($tmp_file_path, $destination);
                }
                
            }
            //concatenating previous images with the newr images
            if($previousImages!=""){
                $fileNameAsString=$previousImages."@".$fileNameAsString;
            }
            echo $fileNameAsString;
            
            $updatePrd_query="UPDATE product SET prd_image='$fileNameAsString', prd_name='$prd_name', prd_cat_id=$prd_cat, prd_price=$prd_price,prd_description='$description', attributes='$attrId', prd_sku='$prd_sku', prd_status='$prd_status' WHERE prd_id=$prd_id";

        }


        $run_updatePrdQuerry=mysqli_query($conn,$updatePrd_query);

        if($run_updatePrdQuerry){
            if($noOf_attr==1 && !isset($_POST["attr1nameId1"])){
                $_SESSION['status']="Updated Successfully";
                header("Location: ../products.php");
            }
            else{
                //delete previous product attribute value
                $delPrdExtPrice_querry="DELETE FROM prod_attribute_values WHERE prd_id=$prd_id";
                $run_delPrdExtPriceQuerry=mysqli_query($conn,$delPrdExtPrice_querry);
                if($run_delPrdExtPriceQuerry){
                    // extended value of attribute
                    for($i=1;$i<=$noOf_attr;$i++){
                        if(isset($_POST["attr$i"])==1){
                            $attrId=$_POST["attr$i"];
                            settype($attrId,"integer");
                            $total_values=$_POST["total_attr$i"."Values"];

                            for($j=1;$j<=$total_values;$j++){
                                //checck wheather attribute sets or not
                                    $attrValueId=$_POST["attr$i"."nameId$j"];
                                    $extendedPrice=$_POST["attr$i"."value$j"];

                                    settype($attrValueId,"integer");
                                    settype($extendedPrice,"float");

                                    echo "attr$i"."nameId$j: ".$attrValueId." attr$i"."value$j :".$extendedPrice."  ||||  ";

                                    $addPrdExtVal_querry="INSERT INTO prod_attribute_values (prd_id, attr_id, attr_val_id, extended_price) VALUES ($prd_id,$attrId,$attrValueId,$extendedPrice)";

                                    $run_addExtValQuerry=mysqli_query($conn,$addPrdExtVal_querry);
                            }
                            if($run_addExtValQuerry){
                                $_SESSION['status']="Updated Successfully";
                                header("Location: ../products.php");
                            }
                            else{
                                $_SESSION['status']="something went wrong";
                                header("Location: ../products.php");
                            }
                        
                        }
                
                    }
                    $_SESSION['status']="Updated Successfully";
                    header("Location: ../products.php");
                }
                else{
                    $_SESSION['status']="something went wrong";
                    header("Location: ../products.php");
                }
            }
            
        }
        else{
            $_SESSION['status']="something went wrong";
            header("Location: ../products.php");
        }
    
    }
    else if(isset($_GET['del_id'])){
        $prd_id=$_GET['del_id'];
        settype($prd_id, "integer");
        $delPrd_querry="DELETE FROM product WHERE prd_id=$prd_id";
        $run_delPrdQuerry=mysqli_query($conn,$delPrd_querry);
        if($run_delPrdQuerry==true){
            $delPrdExtPrice_querry="DELETE FROM prod_attribute_values WHERE prd_id=$prd_id";
            $run_delPrdExtPriceQuerry=mysqli_query($conn,$delPrdExtPrice_querry);
            if($run_delPrdExtPriceQuerry==true){
                $_SESSION['status']="Deleted Successfully";
                header("Location: ../products.php"); 
            }
            else{
                $_SESSION['status']="something went wrong";
                header("Location: ../products.php");
            }

           
        }
        else{
            $_SESSION['status']="something went wrong";
            header("Location: ../products.php");
        }

    }

?>