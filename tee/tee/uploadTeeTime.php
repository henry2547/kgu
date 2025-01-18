<?php
// Database configuration
include_once("dbconnect.php");

// Initialize response array
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Escape user inputs for security
    $club = mysqli_real_escape_string($dbcon, $_POST['club']);
    $tname = mysqli_real_escape_string($dbcon, $_POST['tname']);
    $holes = mysqli_real_escape_string($dbcon, $_POST['holes']);
    $price = mysqli_real_escape_string($dbcon, $_POST['price']);

    // Insert into products table without image
    $sqlInsertTee = "INSERT INTO `teetime` (`teeId`, `availableTeeId`, `golf_course`, `NumberOfHoles`, `Price`) 
                      VALUES (NULL, '$tname', '$club', '$holes', '$price')";

    $success = mysqli_query($dbcon, $sqlInsertTee);
    if ($success) {
        // Success response
        $response['status'] = 'success';
        $response['message'] = 'Tee time added without image';
        echo json_encode($response);
    } else {
        // Database insert failed
        $response['status'] = 'error';
        $response['message'] = 'Failed to add tee time to database: ' . mysqli_error($dbcon);
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
