<?php
// Include the file with database connection details
require_once("dbconnect.php");

// Initialize output array
$output = array('error' => false);

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get club IDs from POST data
    $clubId1 = $_POST['club1'];
    $clubId2 = $_POST['club2'];

    // Check if club1 and club2 are the same
    if ($clubId1 == $clubId2) {
        // If club1 is the same as club2, set error message in output
        $output['error'] = true;
        $output['message'] = 'A club cannot play against itself.';
    } else {
        // SQL query to check if the match already exists
        $checkQuery = "SELECT * FROM matches WHERE clubId1 = :clubId1 AND clubId2 = :clubId2";
        $stmtCheck = $conn->prepare($checkQuery);
        $stmtCheck->execute(['clubId1' => $clubId1, 'clubId2' => $clubId2]);
        $matchExists = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($matchExists) {
            // If the match already exists, set message in output
            $output['message'] = "Match is already assigned";
            
        } else {
            // SQL query to insert match into matches table
            $query = "INSERT INTO matches (clubId1, clubId2) VALUES (:clubId1, :clubId2)";

            try {
                // Prepare and execute the SQL query
                $stmt = $conn->prepare($query);
                $stmt->execute(['clubId1' => $clubId1, 'clubId2' => $clubId2]);

                // Set success message in output
                $output['message'] = "Match assigned successfully";
            } catch (PDOException $e) {
                // Set error message in output if there's a PDO exception
                $output['error'] = true;
                $output['message'] = "Error adding match: " . $e->getMessage();
            }
        }
    }
} else {
    // Invalid request method
    $output['error'] = true;
    $output['message'] = 'Invalid request method.';
}

// Set HTTP header to return JSON response
header('Content-Type: application/json');

// Return JSON-encoded output
echo json_encode($output);
?>
