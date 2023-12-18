<?php

session_start();
include "../config/dbConn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $order_id = $_POST['order_id'];
        $status = $_POST['ordStatus'];

        // Update order status in the database
        $sql = "UPDATE orders SET `delivery_status` = '$status' WHERE id = $order_id";
        $result = mysqli_query($sql, $conn);

        if ($result) {
            echo json_encode(["isSuccess" => true, "data" => ["user" => $row, "session" => $_SESSION], "message" => "Logged in successfully."]);
        } else {
            echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "Email or password is incorrect"]);
        }
    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to login"]);
    }
}

?>