<?php
// Include database connection file
require("../../dbconnect.php");

// Function to sanitize inputs
function sanitize_input($data, $dbcon)
{
    // Remove whitespace and escape special characters
    $data = trim($data);
    $data = mysqli_real_escape_string($dbcon, $data);
    return $data;
}

// Retrieve and sanitize form data
$kitId = sanitize_input($_POST['kitId'], $dbcon);
$quantity = sanitize_input($_POST['quantity'], $dbcon);
$requestId = sanitize_input($_POST['requestId'], $dbcon);

// Update query with corrected field name and parameterized query
$sql_update = "UPDATE golf_tools SET kit_quantity = kit_quantity + ? WHERE kitId = ?";
$stmt_update = $dbcon->prepare($sql_update);
$stmt_update->bind_param("ii", $quantity, $kitId);

if ($stmt_update->execute()) {
    // Update successful, proceed with updating request_this table
    $sql_update_request_this = "UPDATE requested_kit SET isUpdated = 1 WHERE requestId = ?";
    $stmt_update_request_this = $dbcon->prepare($sql_update_request_this);
    $stmt_update_request_this->bind_param("i", $requestId);
    
    if ($stmt_update_request_this->execute()) {
        // Update request_this successful
        $response = array("success" => true);
    } else {
        // Update request_this failed
        $response = array("success" => false, "error" => $stmt_update_request_this->error);
    }

    $stmt_update_request_this->close();
} else {
    // Update raw_material failed
    $response = array("success" => false, "error" => $stmt_update->error);
}

$stmt_update->close();

// Close database connection
$dbcon->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
