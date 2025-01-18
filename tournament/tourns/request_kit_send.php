<?php
require("dbconnect.php");

// Initialize response array
$output = array('error' => false);

// Variables to hold the form data
$kitId = mysqli_real_escape_string($dbcon, $_POST['kitId']);
$quantity = mysqli_real_escape_string($dbcon, $_POST['quantity']);

// SQL query to insert data into database
$sql = "INSERT INTO `requested_kit` (`kitId`, `quantity`) VALUES ('$kitId', '$quantity');";

// Perform the query
$success = mysqli_query($dbcon, $sql);

// Check if insertion was successful
if ($success) {
    $output['message'] = 'Kit requested successfully';
} else {
    $output['error'] = true;
    $output['message'] = 'Failed to request kit: ' . mysqli_error($dbcon);
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($output);
?>
