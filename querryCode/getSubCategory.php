<?php
include("../config/dbConn.php");
$pharmacy_id = $_POST['pharmacy_id'] ;
$category_id = $_POST['category_id'];

$fetchSubCatQuery = "SELECT id, sub_category_name FROM sub_category WHERE pharmacy_id=$pharmacy_id AND category_id=$category_id";
$query_result = mysqli_query($conn, $fetchSubCatQuery);

if ($query_result == true) {
    $count = mysqli_num_rows($query_result);
    $slNo = 1;
    echo "<option selected>Select Sub Category</option>";
    if ($count > 0) {
        while ($rows = mysqli_fetch_assoc($query_result)) {
            $sub_cat_id = $rows['id'];
            $sub_cat_name = $rows['sub_category_name'];
            echo "<option value='$sub_cat_id'>$sub_cat_name</option>";
        }
    }
}
?>