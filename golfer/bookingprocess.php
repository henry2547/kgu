<?php
// Start the session
session_start();

// Initialize error message
$errors = [];

// Check if POST data is received
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if tee ID and number of tees to book are provided
    if (isset($_POST['teeId']) && isset($_POST['numTees'])) {
        // Get golfer ID from session
        $golferId = $_SESSION['golferId'];
        
        // Get tee ID and number of tees to book from POST data
        $teeId = $_POST['teeId'];
        $numTees = $_POST['numTees'];

        // Include database connection file
        require_once("../config/dbconnect.php");

        // Check if the number of tees to book is valid
        $query = "SELECT NumberOfHoles FROM teetime WHERE teeId = :teeId";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':teeId', $teeId);
        $stmt->execute();
        $tee = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($tee) {
            $availableHoles = $tee['NumberOfHoles'];
            
            // Check if the number of tees to book is greater than the available holes
            if ($numTees <= $availableHoles) {
                // Prepare and execute SQL query to insert booking details into booktee table
                $query = "INSERT INTO booktee (golferId, teeId, BookedHoles) VALUES (:golferId, :teeId, :numTees)";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':golferId', $golferId);
                $stmt->bindParam(':teeId', $teeId);
                $stmt->bindParam(':numTees', $numTees);
                
                if ($stmt->execute()) {
                    // Update the number of available holes
                    $newAvailableHoles = $availableHoles - $numTees;
                    $updateQuery = "UPDATE teetime SET NumberOfHoles = :newAvailableHoles WHERE teeId = :teeId";
                    $updateStmt = $conn->prepare($updateQuery);
                    $updateStmt->bindParam(':newAvailableHoles', $newAvailableHoles);
                    $updateStmt->bindParam(':teeId', $teeId);
                    $updateStmt->execute();

                    // Booking successful
                    $response = [
                        'success' => true,
                        'message' => 'Booking successful!'
                    ];
                } else {
                    // Booking failed
                    $response = [
                        'success' => false,
                        'message' => 'Booking failed!'
                    ];
                }
            } else {
                // Number of tees to book exceeds available holes
                $response = [
                    'success' => false,
                    'message' => 'Number of tees to book exceeds available holes!'
                ];
            }
        } else {
            // Tee time not found
            $response = [
                'success' => false,
                'message' => 'Tee time not found!'
            ];
        }
    } else {
        // Required data not provided
        $response = [
            'success' => false,
            'message' => 'Please provide tee ID and number of tees to book!'
        ];
    }
} else {
    // Invalid request method
    $response = [
        'success' => false,
        'message' => 'Invalid request method!'
    ];
}

// Set HTTP header to return JSON response
header('Content-Type: application/json');

// Output JSON response
echo json_encode($response);
?>
