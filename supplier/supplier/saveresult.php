<?php
// Include the database connection file
include('dbconnect.php');

// Initialize response array
$response = array();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the form
    $club1Points = $_POST['club1'];
    $club2Points = $_POST['club2'];
    $matchId = $_POST['matchId'];

    // Check if the match results already exist in the database
    $checkQuery = "SELECT * FROM results WHERE matchId = ?";
    $stmtCheck = $dbcon->prepare($checkQuery);
    $stmtCheck->bind_param('i', $matchId);
    $stmtCheck->execute();
    $existingResults = $stmtCheck->get_result()->fetch_assoc();

    // If match results already exist, return JSON error response
    if ($existingResults) {
        $response['error'] = true;
        $response['message'] = "Match results for this match ID already exist.";
    } else {
        // Insert the match results into the results table
        $query = "INSERT INTO results (matchId, clubId1, clubId2, resultDate) VALUES (?, ?, ?, NOW())";
        $stmt = $dbcon->prepare($query);
        $stmt->bind_param('iii', $matchId, $club1Points, $club2Points);

        // Execute the query
        if ($stmt->execute()) {
            $response['success'] = true;
            $response['message'] = "Match results saved successfully.";
        } else {
            $response['error'] = true;
            $response['message'] = "Error occurred while saving match results.";
        }
    }
} else {
    // If the form is not submitted, return JSON error response
    $response['error'] = true;
    $response['message'] = "Form submission error.";
}

// Set HTTP header to return JSON response
header('Content-Type: application/json');

// Output JSON response
echo json_encode($response);

// Close database connection
$dbcon->close();
?>
