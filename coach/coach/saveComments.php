<?php
require("dbconnect.php");

// Initialize an array to store error messages
$errors = array();

// Variables to hold the form data
$statement = '';
$golferId = '';

// Check if statement field is empty
if (empty($_POST['statement'])) {
    $errors[] = "The Statement field cannot be empty.";
} else {
    $statement = $_POST['statement'];
}


// Check if golferId field is empty
if (empty($_POST['golferId'])) {
    $errors[] = "Enter the golfer ID.";
} else {
    $golferId = $_POST['golferId'];
}

// If there are errors, return JSON response with errors
if (!empty($errors)) {
    $response = array('error' => true, 'message' => $errors);
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // insert comments in the database
    $sql = "INSERT INTO coach(golferId, comments) VALUES(?, ?)";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute(array($golferId, $statement));

    if ($success) {
        // Comments added successfully
        $response = array('success' => true, 'message' => 'Comments added successfully');
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Error adding the comments
        $response = array('error' => true, 'message' => 'Failed to add comments.');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
