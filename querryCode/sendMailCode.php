<?php
include('../config/dbConn.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';


function sendMail($mailTo, $recipientName,$conn,$order_id)
{
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // true enables exceptions

    try {
        // Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';               // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = 'pharmacypi012@gmail.com';         // SMTP username
        // $mail->Password = 'pizeocqeceaeczjx';            // SMTP password
        $mail->Password = 'ykxjqdjjtrkrvaoq';            // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                              // TCP port to connect to

        // Recipients
        $mail->setFrom('pharmacypi012@gmail.com', 'PI Pharmacy');
        $mail->addAddress($mailTo, $recipientName); // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = 'PI-Pharm Delivery Confirm Email';
        $mail->Body = "<p style='margin-bottom:15px; font-weight:600'>Dear Sir,</p>
    <p style='margin-bottom:10px'>The medicines you ordered from PI Pharmacy have been delivered. I hope you have received our product! Please let us know if you have not received the product or if the product has any problems. You can reply to us here. Or you can contact us.</p>
    <p>Our contact number: +880 16 3230 7542</p>
    <p style='margin-top:10px'>Happy Shopping!</p>
    <p style='margin-top:10px; color:green; font-weight:600'>PI Pharmacy</p>
    ";

        if($mail->send()){
            $isOrderStatusChanged=changeOrderStatus($order_id,$conn);
            if($isOrderStatusChanged==true){
                echo json_encode(["isSuccess" => true, "data" => ["customerName"=>$recipientName,"destinationMail"=>$mailTo], "message" => "send mail successfully!"]);
            }

        } 
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        echo json_encode(["isSuccess" => false, "data" => [$mail->ErrorInfo], "message" => "Failed to send mail."]);
    }


}

function changeOrderStatus($order_id,$conn)
{

    // Update order status in the database
    $sql = "UPDATE orders SET `order_status`='completed', `delivery_status` = 'completed' WHERE id = $order_id";
    $result = mysqli_query($conn,$sql);

    if ($result) {
       return true;
    } else {
        return json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "Failed to changed status"]);
    }

}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $customer_id = isset($_POST['customerId']) ?intval( $_POST['customerId'] ): null;
        $order_id = isset($_POST['orderId']) ?intval($_POST['orderId'] ): null;

    //     $sql1="SELECT
    //     orders.order_id,
    //     pharmacy_admin.contact_no,
    //     user.name,
    //     user.email
    // FROM
    //     orders
    // JOIN
    //     pharmacy_admin ON orders.pharmacy_id = pharmacy_admin.id
    // JOIN
    //     user ON orders.cust_id = user.id LIMIT 1";

        $sql = "SELECT * FROM user WHERE `id`=$customer_id LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if($result){

            $row = mysqli_fetch_array($result);
            $customer_name=isset($row['name'])?$row['name']:null;
            $customer_email=isset($row['email'])?$row['email']:null;

            sendMail($customer_email, $customer_name,$conn,$order_id);

        }
        else{
            echo json_encode(["isSuccess" => false, "data" => [$row,$sql], "message" => "Invalid Customer email"]);
        }

    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to send mail."]);

    }
}

