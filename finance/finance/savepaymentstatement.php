<?php
require("dbconnect.php");

// Initialize an array to store error messages
$errors = array();

// Variables to hold the form data
$statement = '';
$status = '';
$paymentId = '';

// Check if statement field is empty
if (empty($_POST['statement'])) {
    $errors[] = "The Statement field cannot be empty.";
} else {
    $statement = $_POST['statement'];
}

// Check if status field is empty
if (empty($_POST['status'])) {
    $errors[] = "You need to select the status field.";
} else {
    $status = $_POST['status'];
}

// Check if paymentId field is empty
if (empty($_POST['paymentId'])) {
    $errors[] = "Enter the Payment ID.";
} else {
    $paymentId = $_POST['paymentId'];
}

// If there are errors, return JSON response with errors
if (!empty($errors)) {
    $response = array('error' => true, 'message' => $errors);
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Update payment in the database
    $sql = "UPDATE payment SET Statement = ?, paymentStatus = ? WHERE paymentId = ?";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute(array($statement, $status, $paymentId));

    if ($success) {
        // Payment updated successfully
        $response = array('success' => true, 'message' => 'The payment was updated successfully.');
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Error updating payment
        $response = array('error' => true, 'message' => 'Failed to update payment.');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
