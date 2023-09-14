<?php
$host= "localhost";
$username="root";
$password="";
$dbName="oms";

$conn=mysqli_connect("$host","$username","$password","$dbName");

if(!$conn){
    header("Location: ../errors/db.php");
    die();
}
// else{
//     echo "database connected.";
// }
?>