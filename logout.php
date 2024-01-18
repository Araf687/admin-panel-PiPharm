<?php
session_start();
unset( $_SESSION['loginInfo']);
header( "Location: login.php" );
?>