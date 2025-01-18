<?php
// Include necessary files and initialize database connection
require_once('database/Database.php');
$db = new Database();
include('dbconnect.php');

// Check if session is not active, include session.php if necessary
if (session_status() == PHP_SESSION_NONE) {
    include('session.php');
}

// Initialize response array
$response = array();

// Variables to hold form data (assuming they are already sanitized)
$typeId = $_POST['typeId'];
$resultId = $_POST['resultId'];

// Check if the resultId already exists in the database
$checkSql = "SELECT COUNT(*) FROM awards WHERE resultId = ?";
$checkStmt = $conn->prepare($checkSql);
$checkStmt->execute([$resultId]);
$count = $checkStmt->fetchColumn();

if ($count > 0) {
    $response['error'] = true;
    $response['message'] = "Award already exists";
} else {
    // Insert data into awards table
    $sql = "INSERT INTO awards (typeId, resultId) VALUES (?, ?)";
    $q = $conn->prepare($sql);
    $success = $q->execute([$typeId, $resultId]);

    if ($success) {
        $response['error'] = false;
        $response['message'] = "Award saved successfully";
    } else {
        $response['error'] = true;
        $response['message'] = "Error saving Award";
    }
}

// Set HTTP header to return JSON response
header('Content-Type: application/json');

// Output JSON response
echo json_encode($response);

// Disconnect from database
$db->Disconnect();
?>
