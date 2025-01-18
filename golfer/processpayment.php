<?php
// Include the file with database connection details
require_once("dbconnect.php");

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get golfer ID, transaction code, and total amount from POST data
    $golferId = $_POST['golferId'];
    $transactionCode = $_POST['transactionCode'];
    $totalAmount = $_POST['totalAmount'];
    $mode_payment = $_POST['mode_payment'];

    // Sanitize input data to prevent SQL injection
    $golferId = mysqli_real_escape_string($dbcon, $golferId);
    $transactionCode = mysqli_real_escape_string($dbcon, $transactionCode);
    $totalAmount = mysqli_real_escape_string($dbcon, $totalAmount);
    $mode_payment = mysqli_real_escape_string($dbcon, $mode_payment);

    // Check if PaymentCode exists
    $checkQuery = "SELECT * FROM payment WHERE PaymentCode = '$transactionCode'";
    $checkResult = mysqli_query($dbcon, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        // PaymentCode already exists, return danger message
        $response = array('success' => false, 'message' => 'PaymentCode already used.');
    } else {
        // PaymentCode does not exist, insert payment data into the database
        $insertQuery = "INSERT INTO payment (golferId, PaymentCode, Amount, mode_payment) VALUES ('$golferId', '$transactionCode', '$totalAmount', '$mode_payment')";

        if (mysqli_query($dbcon, $insertQuery)) {
            // Payment data inserted successfully, update booktee table
            $updateQuery = "UPDATE booktee SET isPaid = 'paid' WHERE golferId = '$golferId'";
            if (mysqli_query($dbcon, $updateQuery)) {
                $response = array('success' => true, 'message' => 'Payment successful.');
            } else {
                $response = array('success' => false, 'message' => 'Failed to update booktee table.');
            }
        } else {
            // Error inserting payment data
            $response = array('success' => false, 'message' => 'Error inserting payment data: ' . mysqli_error($dbcon));
        }
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    $response = array('success' => false, 'message' => 'Invalid request method.');
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
