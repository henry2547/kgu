<?php
require_once('database/Database.php');
$db = new Database();

// Initialize response array
$response = array();

// Include necessary files and start session if not already started
include('dbconnect.php');
if (session_status() == PHP_SESSION_NONE) {
    include('session.php');
}

// Array to handle error messages
$errors = array();

// Validate amount, quantity, and requestId from POST data
$amount = $_POST['amount'] ?? '';
$quantity = $_POST['quantity'] ?? '';
$requestId = $_POST['requestId'] ?? '';
$quantity_each = $_POST['quantity_each'] ?? '';

if (empty($amount)) {
    $errors[] = "Enter amount field";
}

if(empty($quantity_each)){
    $errors[] = "Enter amount for each";
}

if (empty($quantity)) {
    $errors[] = "Enter quantity field";
}

if (empty($requestId)) {
    $errors[] = "Enter the requestId";
}

// If there are errors, return JSON response with errors
if (!empty($errors)) {
    $response['error'] = true;
    $response['errors'] = $errors;
} else {
    // Prepare and execute SQL query to update match amount
    $sql = "INSERT INTO saveSupply(requestId, quantity, quantity_each, amount) VALUES (?, ?, ?, ?)";
    $q = $conn->prepare($sql);
    $success = $q->execute(array($requestId, $quantity, $quantity_each, $amount));

    if ($success) {
        $response['success'] = true;
        $response['message'] = "Request saved successfully";
    } else {
        $response['error'] = true;
        $response['message'] = "Error saving request";
    }
}

// Set HTTP header to return JSON response
header('Content-Type: application/json');

// Output JSON response
echo json_encode($response);

// Disconnect from the database
$db->Disconnect();
?>
