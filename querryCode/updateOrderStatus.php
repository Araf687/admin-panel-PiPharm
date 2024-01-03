<?php

session_start();
include "../config/dbConn.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {

        $order_id = $_POST['order_id'];
        $deliveryStatus = $_POST['deliveryStatus'];
        $orderStatus = $_POST['ordStatus'];

        // Update order status in the database
        $sql = "UPDATE orders SET `order_status`='$orderStatus', `delivery_status` = '$deliveryStatus' WHERE id = $order_id";
        $result = mysqli_query($conn,$sql);

        if ($result) {
            echo json_encode(["isSuccess" => true, "data" => ["orderId"=>$order_id,"orderStatus"=>$orderStatus,"deliveryStatus"=>$deliveryStatus], "message" => "Status Changed successfully."]);
        } else {
            echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "Failed to changed status"]);
        }
    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to changed status"]);
    }
}

?>