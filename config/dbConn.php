<?php
$host= "localhost";
// $username="foodcoral_oms";
// $password="OEaf?I4r#sG=";
$username="root";
$password="";
$dbName="onlinemedicinesys";

$conn=mysqli_connect("$host","$username","$password","$dbName");

if(!$conn){
    header("Location: ../errors/db.php");
    die();
}
// else{
//     echo "database connected.";
// }
?>