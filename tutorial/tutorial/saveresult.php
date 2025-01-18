<?php
// Include the database connection file
include('dbconnect.php');

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

    // If match results already exist, redirect back with an error message
    if ($existingResults) {
        session_start();
        $_SESSION['error'] = "Match results for this match ID already exist.";
        header("Location: uploadresults.php?edit={$matchId}");
        exit();
    } else {
        // Insert the match results into the results table
        $query = "INSERT INTO results (matchId, clubId1, clubId2, resultDate) VALUES (?, ?, ?, NOW())";
        $stmt = $dbcon->prepare($query);
        $stmt->bind_param('iii', $matchId, $club1Points, $club2Points);

        // Execute the query
        if ($stmt->execute()) {
            // Redirect to the uploadresults.php page with success message
            session_start();
            $_SESSION['success'] = "Match results saved successfully.";
            header("Location: uploadresults.php?edit={$matchId}");
            exit();
        } else {
            // Redirect to the uploadresults.php page with error message
            session_start();
            $_SESSION['error'] = "Error occurred while saving match results.";
            header("Location: uploadresults.php?edit={$matchId}");
            exit();
        }
    }
} else {
    // Redirect to the uploadresults.php page if the form is not submitted
    header("Location: uploadresults.php");
    exit();
}
?>
