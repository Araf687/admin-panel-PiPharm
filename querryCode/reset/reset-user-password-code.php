<?php
include('../../config/dbConn.php');
session_start();

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
        $userId=intval($_POST['user_id']);
        $loginType = $_SESSION['loginInfo']['adminType'];
        $currentPassword = $_POST['current_password'];
        $newPassword = $_POST['new_password'];

        $tableName = $loginType=="admin"?'admin':'pharmacy_admin';

        $sql = "SELECT * FROM ".$tableName." WHERE `id`=$userId LIMIT 1";
        $result = mysqli_query($conn, $sql);
        

        if ($result) {
            
            if (mysqli_num_rows($result) > 0) {
                $row=mysqli_fetch_assoc($result);
                $user_password=$row['admin_pass'];


               
           

                if (!password_verify($currentPassword, $row['admin_pass'])) {

                    $newPassword = password_hash( $newPassword , PASSWORD_DEFAULT);

                    $sql_updateUserPass = "UPDATE ".$tableName." SET `admin_pass`='$newPassword' WHERE `id`=$userId";
                    $result_updateUserPass = mysqli_query($conn, $sql_updateUserPass);

                    if ($result_updateUserPass) {
                        echo json_encode(["isSuccess" => true, "data" => ["result" => true], "message" => "Password sent to your mail successfully."]);
                    }
                    else{
                        echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn) ], "message" => "invalid user"]);
                    }


                } else {
                    echo json_encode(["isSuccess" => false, "data" => ["error" => "password does verified","currentPassword"=>$currentPassword], "message" => "invalid user"]);
                }

            } else {
                echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn),"sql"=>$sql ], "message" => "invalid user.rsult not found"]);
            }
        } else {
            echo json_encode(["isSuccess" => false, "data" => ["error" => mysqli_error($conn),"sql"=>$sql ], "message" => "Email is incorrect"]);
        }
    } catch (Exception $e) {
        echo json_encode(["isSuccess" => false, "data" => [], "message" => "Failed to send mail"]);
    }
}
?>