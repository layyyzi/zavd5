<?php

// Check if the file parameter is set
if (isset($_GET['file'])) {
    // Get the file name from the parameter
    $fileName = $_GET['file'];

    // Define the directory where the file is located
    $directory = 'uploads/';

    // Check if the file exists in the directory
    if (file_exists($directory . $fileName)) {
        // Delete the file
        unlink($directory . $fileName);

        // Redirect back to the main page
        header('Location: index.php');
    } else {
        // File not found
        echo 'File not found.';
    }
} else {
    // File parameter not set
    echo 'Invalid request.';
}