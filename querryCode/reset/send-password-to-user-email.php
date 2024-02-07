<?php
include('../../config/dbConn.php');
session_start();


use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../PHPMailer-master/src/Exception.php';
require '../../PHPMailer-master/src/PHPMailer.php';
require '../../PHPMailer-master/src/SMTP.php';


function sendMail($mailTo, $recipientName,$mailBody,$mailSubject)
{
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true); // true enables exceptions

    try {
        // Server settings
        $mail->isSMTP();                                      // Set mailer to use SMTP
        $mail->Host = 'smtp.gmail.com';               // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;                             // Enable SMTP authentication
        $mail->Username = 'pharmacypi012@gmail.com';         // SMTP username
        $mail->Password = 'pizeocqeceaeczjx';            // SMTP password
        $mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
        $mail->Port = 587;                              // TCP port to connect to

        // Recipients
        $mail->setFrom('pharmacypi012@gmail.com', 'PI Pharmacy');
        $mail->addAddress($mailTo, $recipientName); // Add a recipient

        // Content
        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->Subject = $mailSubject;
        $mail->Body = $mailBody;

        if($mail->send()){
                return ["isSuccess" => true, "data" => [], "message" => "send mail successfully!"];
        } 
        
    } catch (Exception $e) {
     
        return ["isSuccess" => false, "data" => [$mail->ErrorInfo], "message" => "Failed to send mail."];
    }


}

function generatePassword() {
    $length = 8;
    $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $password = '';

    for ($i = 0; $i < $length; $i++) {
        $password .= $characters[rand(0, strlen($characters) - 1)];
    }

    return $password;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $loginType = $_POST['loginType'];
        $recipientName = isset($_POST['user-name']) ? mysqli_real_escape_string($conn, $_POST['user-name']) : null;
        $mail_to = isset($_POST['email']) ? mysqli_real_escape_string($conn, $_POST['email']) : null;
        $tableName = $loginType=="authority"?'admin':'pharmacy_admin';

        $sql = "SELECT * FROM " .$tableName." WHERE `email`='$mail_to' LIMIT 1";
        $result = mysqli_query($conn, $sql);

        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_array($result);
                $newPassword = generatePassword();
                $newPassword = password_hash( generatePassword(), PASSWORD_DEFAULT);
                $mailSubject = "Password recovery mail";
                $mailBody = "<p style='margin-bottom:15px; font-weight:600'>Dear Sir,</p>
                <h5 style='margin-bottom:10px'>This is your new password.</h5>
                <p>New Password: <strong>$newPassword</strong></p>
                <p style='margin-top:8px'>Happy Shopping!</p>
                <p style='margin-top:8px; color:green; font-weight:600'>PI Pharmacy</p>
                ";

                $sendMailResult = sendMail($mail_to, $recipientName, $mailBody, $mailSubject);

                if ($sendMailResult["isSuccess"]) {

                    $sql_updateUserPass = "UPDATE .$tableName. SET `password`='$newPassword' WHERE `email`='$mail_to'";
                    $result_updateUserPass = mysqli_query($conn, $sql_updateUserPass);

                    if ($result_updateUserPass) {
                        echo json_encode(["isSuccess" => true, "data" => ["result" => $sendMailResult], "message" => "Password sent to your mail successfully."]);
                    }
                    else{
                        print_r(mysqli_error($conn));
                    }


                } else {
                    echo json_encode(["isSuccess" => false, "data" => ["error" => $sendMailResult], "message" => "Email is incorrect"]);
                }

            } else {
                echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "Email is incorrect"]);
            }
        } else {
            echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn)], "message" => "Email is incorrect"]);
        }
    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to send mail"]);
    }
}
?>