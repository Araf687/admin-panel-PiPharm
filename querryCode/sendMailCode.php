<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer-master/src/Exception.php';
require 'PHPMailer-master/src/PHPMailer.php';
require 'PHPMailer-master/src/SMTP.php';


$to = "recipient@example.com";
$subject = "Test Email";
$message = "This is a test email sent from PHP.";
$headers = "From: sender@example.com";