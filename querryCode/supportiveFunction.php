<?php

// import 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../PHPMailer-master/src/Exception.php';
require '../PHPMailer-master/src/PHPMailer.php';
require '../PHPMailer-master/src/SMTP.php';




// Function to delete image
function deleteImageFromFolder($prevImageName, $folderPath)
{

    if ($prevImageName) {
        // Specify the path to the folder and the filename to be deleted
        $fileName = $prevImageName; // Replace with the actual file name

        // Check if the file exists before attempting to delete
        $filePath = $folderPath . $fileName;
        if (file_exists($filePath)) {
            // Attempt to delete the file
            unlink($filePath);
        }
    }

}

// Function to upload an image to a folder
function uploadImage($filename, $targetFolder, $targetedFile)
{
    // Set the destination path
    $destination = $targetFolder . $filename;
    // Move the file to the destination
    move_uploaded_file($targetedFile, $destination);
}

