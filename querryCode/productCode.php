<?php
session_start();
include "../config/dbConn.php";

if (isset($_COOKIE['login_status'])) {

    if (isset($_POST['addProduct'])) {
        $description = $_POST['prd_desc'];
        $user_id = $_SESSION['loginInfo']["id"];
        $prd_name = $_POST['prd_name'];
        $prd_cat = isset($_POST['category']) ? $_POST['category'] : 0;
        $prd_sub_cat = isset($_POST['sub_category']) ? $_POST['sub_category'] : 0;
        $prd_price = $_POST['prod_price'];
        $prd_qty = $_POST['prod_qty'];
        $prd_status = $_POST['status'];
        $product_image = $_FILES['product_image']['name'];

        settype($prd_cat, "integer");
        settype($prd_sub_cat, "integer");
        settype($prd_price, "float");
        settype($prd_qty, "integer");

        // product image
        $fileNameAsString = "";


        if ($product_image != '') {
            $allowed_extension = array('png', 'jpg', 'jpeg');
            $file_extension = pathinfo($product_image, PATHINFO_EXTENSION);
            $fileNameAsString = time() . '.' . $file_extension;
        }


        //check product slug is already exist or not
        $prod_slug = strtolower(str_replace(' ', '-', $prd_name));
        $prod_slug = str_replace("'", '', $prod_slug);

        $checkProdSlug = "SELECT `prd_id` FROM product WHERE slug='$prod_slug'";
        $checkProdSlug_run = mysqli_query($conn, $checkProdSlug);

        if (mysqli_num_rows($checkProdSlug_run) > 0) {
            //adding random number to make the slug unique
            $prod_slug = $prod_slug . rand(1, 1000);
        }


        $addPrd_querry = "INSERT INTO product (`prd_image`, `prd_name`, `prd_cat_id`,`prd_sub_cat_id`, `prd_price`,`quantity`, `prd_description`, `slug`, `prd_status`, `pharmacy_id`) VALUES ('$fileNameAsString','$prd_name',$prd_cat, $prd_sub_cat,$prd_price,$prd_qty,'$description','$prod_slug','$prd_status','$user_id')";

        $run_addPrdQuerry = mysqli_query($conn, $addPrd_querry);
        if ($run_addPrdQuerry) {

            // Set the destination path
            $destination = '../assets/images/product/' . $fileNameAsString;
            if ($fileNameAsString != '') {
                move_uploaded_file($_FILES['product_image']['tmp_name'], $destination);
            }

            $_SESSION['status'] = "Added Successfully";
            header("Location: ../add-product.php");

        } else {
            $_SESSION['status'] = "something went wrong";
            header("Location: ../add-category.php");
        }


    } else if (isset($_POST['UpdateProduct'])) {
        $prd_id = $_POST['prd_id'];
        $prd_name = $_POST['prd_name'];
        $prd_cat = $_POST['category'];
        $prd_sub_cat = isset($_POST['sub_category'])?$_POST['sub_category']:null;
        $prd_price = $_POST['prod_price'];
        $prd_qty = $_POST['prod_qty'];
        $prd_status = $_POST['status'];
        $description = $_POST['prd_desc'];

        $product_image = $_FILES['product_image']['name'];

        //get products previous images
        $previousImages = $_POST['prev_img'];

        settype($prd_cat, "integer");
        settype($prd_sub_cat, "integer");
        settype($prd_id, "integer");
        settype($prd_price, "float");

       
        $fileNameAsString = "";

        $updatePrd_query = "";

        settype($cat_id, "integer");


        if ($product_image == "") {
            // that means user did not change the previous image
            $updatePrd_query = "UPDATE product SET `prd_name`='$prd_name', `prd_cat_id`=$prd_cat, `prd_sub_cat_id`=$prd_sub_cat, `prd_price`=$prd_price, `quantity`=$prd_qty, `prd_description`='$description', `prd_status`='$prd_status' WHERE `prd_id`=$prd_id";
        } else {
            $file_extension = pathinfo($product_image, PATHINFO_EXTENSION);
            $fileNameAsString = time() . '.' . $file_extension;

            $updatePrd_query = "UPDATE product SET `prd_image`='$fileNameAsString', `prd_name`='$prd_name', `prd_cat_id`=$prd_cat,`prd_sub_cat_id`=$prd_sub_cat, `prd_price`=$prd_price,`quantity`=$prd_qty, `prd_description`='$description',`prd_status`='$prd_status' WHERE `prd_id`=$prd_id";

        }


        $run_updatePrdQuerry = mysqli_query($conn, $updatePrd_query);

        if ($run_updatePrdQuerry) {
              // Set the destination path
              $destination = '../assets/images/product/' . $fileNameAsString;
            
              if ($fileNameAsString != "") {
         
                  move_uploaded_file($_FILES['product_image']['tmp_name'], $destination);
              }

            $_SESSION['status'] = "Updated Successfully";
            header("Location: ../products.php");

        } else {
            $_SESSION['status'] = "something went wrong";
            header("Location: ../products.php");
        }

    } else if (isset($_POST['uploadProductExcelFIle'])) {

        $file = $_FILES['excel']['name'];
        $file_extension = pathinfo($file, PATHINFO_EXTENSION);
        $filename = time() . '.' . $file_extension;
        $targetDirectory = "../assets/files/productsInExcel/" . $filename;

        move_uploaded_file($_FILES['excel']['tmp_name'], "../assets/files/productsInExcel/" . $filename);
        error_reporting(0);
        ini_set('display_errors', 0);

        require '../vendor/autoload.php';
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReaderForFile("$targetDirectory");
        $reader->setReadDataOnly(true);
        $reader = $reader->load("$targetDirectory");
        $reader->getActiveSheet()->toArray();
        $excelData = $reader->getActiveSheet()->toArray();

        $user_id = $_SESSION['loginInfo']["id"];
        settype($user_id, "integer");

        $fetchCatQuerry = "SELECT `id`, `cat_name` FROM category WHERE admin_id=$user_id";
        $querry_result = mysqli_query($conn, $fetchCatQuerry);

        $categoryNameCache = array();
        $categoryIdCache = array();
        if ($querry_result == true) {
            $count = mysqli_num_rows($querry_result);
            $slNo = 1;
            if ($count > 0) {
                while ($rows = mysqli_fetch_assoc($querry_result)) {
                    $cat_id = $rows['id'];
                    $cat_name = $rows['cat_name'];
                    array_push($categoryNameCache, $cat_name);
                    array_push($categoryIdCache, $cat_id);
                }
            } else {
                echo "empty category table";
            }
        }

        $i = 0;
        foreach ($excelData as $key) {
            if ($i != 0) {

                //assign excel data into variables
                $categoryName = $key[0];
                $itemName = $key[1];
                $price = $key[2];
                settype($price, "float");
                $desc = $key[3];
                $prod_slug = strtolower(str_replace(' ', '-', $itemName));
                $prod_slug = str_replace("'", '', $prod_slug);

                $isCategoryExist = array_search($categoryName, $categoryNameCache);

                // echo " catName: ".$categoryName." itm: ".$itemName." p: ".$price." dsc: ".$desc." slg: ".$prod_slug." isExistst: ".$isCategoryExist."|@@@@@@@@@@@@@@@@@@@@@|";

                if ($isCategoryExist) {
                    $categoryId = $categoryIdCache[$isCategoryExist];
                    settype($categoryId, "integer");

                    // when category already exist we directly add the product in database
                    $addPrd_querry = "INSERT INTO product (`prd_name`, `prd_cat_id`, `prd_price`, `prd_description`, `slug`, `admin_id`) VALUES ('$itemName', $categoryId, $price,'$desc','$prod_slug',$user_id)";
                    $run_addPrdQuerry = mysqli_query($conn, $addPrd_querry);
                    if (!$run_addPrdQuerry) {
                        echo "cant insert the product---------------------  ";
                    }

                } else {
                    $cat_slug = strtolower(str_replace(' ', '-', $categoryName));
                    $cat_slug = str_replace("'", '', $cat_slug);

                    // if category doesnot exist then first add the category and then add the product data into db
                    $addCat_querry = "INSERT INTO category (`cat_name`, `is_featured`, `slug`,`admin_id`) VALUES ('$categoryName', 0, '$cat_slug', $user_id)";
                    $run_addCatQuerry = mysqli_query($conn, $addCat_querry);

                    if ($run_addCatQuerry) {
                        //get new category id
                        $categoryId = mysqli_insert_id($conn);

                        //added new category id and name into array. it needs to add the product in db
                        array_push($categoryNameCache, $categoryName);
                        array_push($categoryIdCache, $categoryId);


                        $addPrd_querry = "INSERT INTO product (`prd_name`, `prd_cat_id`, `prd_price`, `prd_description`, `slug`, `admin_id`) VALUES ('$itemName', $categoryId, $price,'$desc','$prod_slug',$user_id)";

                        $run_addPrdQuerry = mysqli_query($conn, $addPrd_querry);
                        if (!$run_addPrdQuerry) {
                            echo "product not added ||||||||||| ";
                        }

                    } else {
                        echo "new category not added ||||||||||| ";
                    }
                }

            }
            $i++;

        }
        $_SESSION['status'] = "uploaded Successfully";
        header("Location: ../products.php");

    } else if (isset($_GET['del_id'])) {
        $prd_id = $_GET['del_id'];
        settype($prd_id, "integer");
        $delPrd_querry = "DELETE FROM product WHERE `prd_id`=$prd_id";
        $run_delPrdQuerry = mysqli_query($conn, $delPrd_querry);
        if ($run_delPrdQuerry == true) {

            $_SESSION['status'] = "Deleted Successfully";
            header("Location: ../products.php");

        } else {
            $_SESSION['status'] = "something went wrong";
            header("Location: ../products.php");
        }

    }
} else {
    header("Location: login.php");
}
?>