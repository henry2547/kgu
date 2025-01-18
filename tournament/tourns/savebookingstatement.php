<?php
// Include the file with database connection details
require_once("dbconnect.php");

// Ensure this PHP script is called with POST method
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Assume $_POST contains 'bookId', 'statement' and 'bookingStatus'
    $bookId = $_POST['bookId'];
    $statement = $_POST['statement'];
    $bookingStatus = $_POST['status'];

    try {
        // Prepare UPDATE query
        $query = "UPDATE booktournament SET Statement = :statement, BookingStatus = :bookingStatus WHERE bookId = :bookId";
        $stmt = $conn->prepare($query);

        // Bind parameters
        $stmt->bindParam(':statement', $statement);
        $stmt->bindParam(':bookingStatus', $bookingStatus);
        $stmt->bindParam(':bookId', $bookId);

        // Execute the query
        $stmt->execute();

        // Check if update was successful
        $rowCount = $stmt->rowCount();
        if ($rowCount > 0) {
            // Update successful, prepare JSON response
            $response = [
                'success' => true,
                'message' => "Booking (ID: $bookId) updated successfully."
            ];
        } else {
            // No rows affected, likely bookId not found
            $response = [
                'success' => false,
                'message' => "No booking found with ID: $bookId."
            ];
        }
    } catch (PDOException $e) {
        // Database error
        $response = [
            'success' => false,
            'message' => "Database error: " . $e->getMessage()
        ];
    }

    // Return JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // If not a POST request, return an error
    $response = [
        'success' => false,
        'message' => 'Invalid request method.'
    ];
    header('Content-Type: application/json');
    echo json_encode($response);
}
