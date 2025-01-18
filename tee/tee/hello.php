<?php
// Database configuration
include_once("dbconnect.php");

// Initialize response array
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/'; // Directory to save uploaded files (adjust as needed)
        $file = $_FILES['image'];

        $fileName = basename($file['name']);
        $uploadPath = $uploadDir . $fileName;

        if (move_uploaded_file($file['tmp_name'], $uploadPath)) {

            // Escape user inputs for security
            $description = mysqli_real_escape_string($dbcon, $_POST['description']);
            $tname = mysqli_real_escape_string($dbcon, $_POST['tname']);
            $holes = mysqli_real_escape_string($dbcon, $_POST['holes']);
            $price = mysqli_real_escape_string($dbcon, $_POST['price']);

            // Insert into products table with image path
            $sqlInsertTee = "INSERT INTO `teetime` (`teeId`, `Image`, `availableTeeId`, `Description`, `NumberOfHoles`, `Price`) 
                                VALUES (NULL, '$fileName', '$tname', '$description', '$holes', '$price')";

            $success = mysqli_query($dbcon, $sqlInsertTee);
            if ($success) {
                // Success response
                $response['status'] = 'success';
                $response['message'] = 'Tee time Added';
                echo json_encode($response);
            } else {
                // Database insert failed
                $response['status'] = 'error';
                $response['message'] = 'Failed to add tee time to database: ' . mysqli_error($dbcon);
                echo json_encode($response);
            }
        } else {
            // Failed to move uploaded file
            $response['status'] = 'error';
            $response['message'] = 'Failed to move uploaded file to destination directory';
            echo json_encode($response);
        }
    } else {
        // No file uploaded or file upload error
        $response['status'] = 'error';
        $response['message'] = 'File upload failed or no file uploaded';
        echo json_encode($response);
    }
} else {
    // Invalid request method
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method';
    echo json_encode($response);
}

// Close the database connection
mysqli_close($dbcon);
?>
