<?php
// Include the file with database connection details
require_once("dbconnect.php");

// Start the session
session_start();

// Array to hold the JSON response data
$response = array();

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get tournament ID, golfer ID, and club ID from POST data
    $tournamentId = $_POST['tournamentId'];
    $golferId = $_POST['golferId'];
    $clubId = $_POST['clubId'];

    // Check if the golfer has already booked the tournament
    $checkQuery = "SELECT COUNT(*) AS total FROM booktournament WHERE tournamentId = :tournamentId AND golferId = :golferId";
    $checkStmt = $conn->prepare($checkQuery);
    $checkStmt->execute(['tournamentId' => $tournamentId, 'golferId' => $golferId]);
    $checkResult = $checkStmt->fetch(PDO::FETCH_ASSOC);

    if ($checkResult['total'] > 0) {
        // If the golfer has already booked the tournament, return an error response
        $response['success'] = false;
        $response['message'] = 'You have already booked this tournament.';
    } else {
        // Validate the number of golfers booking for the tournament from the same club
        $countQuery = "SELECT COUNT(*) AS total FROM booktournament WHERE tournamentId = :tournamentId AND clubId = :clubId";
        $countStmt = $conn->prepare($countQuery);
        $countStmt->execute(['tournamentId' => $tournamentId, 'clubId' => $clubId]);
        $countResult = $countStmt->fetch(PDO::FETCH_ASSOC);

        if ($countResult['total'] >= 5) {
            // If the booking is full for the club, return an error response
            $response['success'] = false;
            $response['message'] = 'Booking is full for your club. Maximum 5 golfers allowed per club.';
        } else {
            // Insert the booking details into the database
            $insertQuery = "INSERT INTO booktournament (tournamentId, golferId, clubId) VALUES (:tournamentId, :golferId, :clubId)";
            $insertStmt = $conn->prepare($insertQuery);
            $insertResult = $insertStmt->execute(['tournamentId' => $tournamentId, 'golferId' => $golferId, 'clubId' => $clubId]);

            if ($insertResult) {
                // Booking successful, set success message in session (if needed)
                $response['success'] = true;
                $response['message'] = 'Tournament booked successfully!';
            } else {
                // Failed to insert booking, return an error response
                $response['success'] = false;
                $response['message'] = 'Failed to book tournament. Please try again later.';
            }
        }
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // Invalid request method
    $response['success'] = false;
    $response['message'] = 'Invalid request method.';
    
    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
