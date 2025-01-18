<?php
// Assuming $dbcon is your MySQL database connection
require ("dbconnect.php");

header('Content-Type: application/json');

$response = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve awardId from POST data
    $awardId = $_POST['awardId'];

    // Perform SQL update to mark award as claimed
    $update_query = "UPDATE awards SET claim_award = 'claimed' WHERE awardId = '$awardId'";

    if (mysqli_query($dbcon, $update_query)) {
        $response['success'] = true;
        $response['message'] = "Award has been claimed successfully!";
    } else {
        $response['success'] = false;
        $response['message'] = "Error updating database: " . mysqli_error($dbcon);
    }
} else {
    // Handle invalid request method
    $response['success'] = false;
    $response['message'] = "Invalid request method.";
}

// Close database connection
mysqli_close($dbcon);

// Output JSON response
echo json_encode($response);
?>
