<?php
include('../config/dbConn.php');
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $pharmacy_admin_id = isset($_POST['pharmacy_admin_id']) ? mysqli_real_escape_string($conn, $_POST['pharmacy_admin_id']) : null;
        $status = isset($_POST['status']) ? trim( mysqli_real_escape_string($conn, $_POST['status'])) : null;
        settype($pharmacy_admin_id, "integer");


        $sql = "UPDATE pharmacy_admin SET  `status`='$status' WHERE `id`=$pharmacy_admin_id";

        $result = mysqli_query($conn, $sql);

        if ($result) {

            echo json_encode(["isSuccess" => true, "data" => ["userId" =>$pharmacy_admin_id,"sql"=>$sql ], "message" => "Status Changed successfully."]);

        } else {
            echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "Failed to change change status."]);
        }
    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to change change status."]);
    }
}
?>