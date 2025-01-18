<?php
session_start();

// Check if session variables are set
if (isset($_SESSION['golferId'])) {
    // Assign session variable to local variable
    $golferId = $_SESSION['golferId'];
} else {
    // Redirect to login page if session variable is not set
    header("Location: login.php");
    exit(); // Stop further execution
}

// Include database connection
include('dbconnect.php');

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (isset($_POST['golferId'], $_POST['feedback_type'], $_POST['message']) &&
        !empty($_POST['golferId']) && !empty($_POST['feedback_type']) && !empty($_POST['message'])) {

        // Sanitize inputs to prevent SQL injection
        $golferId = mysqli_real_escape_string($dbcon, $_POST['golferId']);
        $feedback_type = mysqli_real_escape_string($dbcon, $_POST['feedback_type']);
        $message = mysqli_real_escape_string($dbcon, $_POST['message']);

        // Prepare and execute SQL query to insert feedback into the feedback table
        $sql = "INSERT INTO feedback (golferId, message_to, Message) VALUES ('$golferId', '$feedback_type', '$message')";
        if (mysqli_query($dbcon, $sql)) {
            // Feedback inserted successfully
            $response['status'] = 'success';
            $response['message'] = 'Feedback submitted successfully';
        } else {
            // Error inserting feedback
            $response['status'] = 'error';
            $response['message'] = 'Error: ' . mysqli_error($dbcon);
        }
    } else {
        // Required fields are missing
        $response['status'] = 'error';
        $response['message'] = 'Please fill in all required fields';
    }
} else {
    // Form not submitted
    $response['status'] = 'error';
    $response['message'] = 'Form not submitted';
}

// Close database connection
mysqli_close($dbcon);

// Encode response array to JSON and return
header('Content-Type: application/json');
echo json_encode($response);
?>
