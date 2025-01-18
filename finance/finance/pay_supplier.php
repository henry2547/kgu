<?php
// Include database connection file
require("../../dbconnect.php");

// Function to sanitize inputs
function sanitize_input($data)
{
    // Remove whitespace and escape special characters
    return htmlspecialchars(trim($data));
}

// Function to validate code format (10 characters, uppercase letters and numbers only)
function validate_code($code)
{
    // Check if code is exactly 10 characters long
    if (strlen($code) !== 10) {
        return false;
    }
    // Check if code contains only uppercase letters and numbers
    if (!preg_match('/^(?=.*[A-Z])(?=.*[0-9])[A-Z0-9]{10}$/', $code)) {
        return false;
    }
    return true;
}

// Retrieve and sanitize form data
$mode_payment = sanitize_input($_POST['mode_payment']);
$supplyId = sanitize_input($_POST['supplyId']);
$comments = sanitize_input($_POST['comments']);
$code = sanitize_input($_POST['code']);

// Validate the code format
if (!validate_code($code)) {
    // Invalid code format
    $response = array("success" => false, "error" => "Invalid code format. It should be 10 characters long and contain only uppercase letters and numbers.");
    // Return JSON response and exit
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}

// Check if the code already exists in the table
$sql_check_code = "SELECT COUNT(*) AS count FROM saveSupply WHERE code = ?";
$stmt_check_code = $dbcon->prepare($sql_check_code);
$stmt_check_code->bind_param("s", $code);
$stmt_check_code->execute();
$stmt_check_code->bind_result($count);
$stmt_check_code->fetch();
$stmt_check_code->close();

// If code already exists, notify the user
if ($count > 0) {
    // Code already used
    $response = array("success" => false, "error" => "Code is already used.");
} else {
    // Prepare SQL statement to update the code
    $sql_update = "UPDATE saveSupply SET mode_payment = ?, comments = ?, code = ?, payment = 1 WHERE supplyId = ?";
    $stmt_update = $dbcon->prepare($sql_update);
    $stmt_update->bind_param("sssi", $mode_payment, $comments, $code, $supplyId);

    if ($stmt_update->execute()) {
        // Update successful
        $response = array("success" => true);
    } else {
        // Update failed
        $response = array("success" => false, "error" => $stmt_update->error);
    }

    $stmt_update->close();
}

// Close database connection
$dbcon->close();

// Return JSON response
header('Content-Type: application/json');
echo json_encode($response);
?>
