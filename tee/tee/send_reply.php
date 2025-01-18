<?php
require("dbconnect.php");

// Initialize response array
$response = array();

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if all required fields are set and not empty
    if (isset($_POST['feedbackId'], $_POST['reply']) &&
        !empty($_POST['feedbackId']) && !empty($_POST['reply'])) {

        // Sanitize inputs to prevent SQL injection
        $feedbackId = mysqli_real_escape_string($dbcon, $_POST['feedbackId']);
        $reply = mysqli_real_escape_string($dbcon, $_POST['reply']);

        // Prepare and execute SQL query to insert reply into the replies table
        $sql = "INSERT INTO replies (feedbackId, message_reply) VALUES ('$feedbackId', '$reply')";
        if (mysqli_query($dbcon, $sql)) {
            // Reply inserted successfully
            $response['status'] = 'success';
            $response['message'] = 'Reply submitted successfully';
        } else {
            // Error inserting reply
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
