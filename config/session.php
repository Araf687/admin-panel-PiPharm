<?php
session_start();

if(!$_SESSION['loginInfo']["id"]){
  header("Location: login.php");
}
?>