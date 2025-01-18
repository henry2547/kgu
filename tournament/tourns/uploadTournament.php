<?php
require("dbconnect.php");

// Initialize response array
$output = array('error' => false);

// Variables to hold the form data
$name = mysqli_real_escape_string($dbcon, $_POST['name']);
$location = mysqli_real_escape_string($dbcon, $_POST['location']);
$start = mysqli_real_escape_string($dbcon, $_POST['start']);
$end = mysqli_real_escape_string($dbcon, $_POST['end']);
$deadline = mysqli_real_escape_string($dbcon, $_POST['deadline']);
$prizes = mysqli_real_escape_string($dbcon, nl2br($_POST['prizes'])); // Convert newlines to <br> tags
$description = mysqli_real_escape_string($dbcon, $_POST['description']);

// SQL query to insert data into database
$sql = "INSERT INTO `tournament` (`TournamentName`, `TournamentVenue`, `StartDate`, `EndDate`, `registrationDeadline`, `Description`, `Prizes`) 
        VALUES ('$name', '$location', '$start', '$end', '$deadline', '$description', '$prizes')";

// Perform the query
$success = mysqli_query($dbcon, $sql);

// Check if insertion was successful
if ($success) {
    $output['message'] = 'Tournament Added Successfully';
} else {
    $output['error'] = true;
    $output['message'] = 'Failed to add tournament: ' . mysqli_error($dbcon);
}

// Return JSON response
header('Content-Type: application/json');
echo json_encode($output);
?>
