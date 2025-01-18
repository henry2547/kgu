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

$status = '';
$matchId = '';

// Validate status and matchId from POST data
if (empty($_POST['status'])) {
    array_push($errors, "You need to select the status field");
} else {
    $status = $_POST['status'];
}

if (empty($_POST['matchId'])) {
    array_push($errors, "Enter the match id");
} else {
    $matchId = $_POST['matchId'];
}

// If there are errors, return JSON response with errors
if ($errors) {
    $response['error'] = true;
    $response['errors'] = $errors;
} else {
    // Prepare and execute SQL query to update match status
    $sql = "UPDATE matches SET matchStatus = ? WHERE matchId = ?";
    $q = $conn->prepare($sql);
    $success = $q->execute(array($status, $matchId));

    if ($success) {
        $response['success'] = true;
        $response['message'] = "The Match status updated successfully";
    } else {
        $response['error'] = true;
        $response['message'] = "Error updating match status";
    }
}

// Set HTTP header to return JSON response
header('Content-Type: application/json');

// Output JSON response
echo json_encode($response);

// Disconnect from the database
$db->Disconnect();
?>
