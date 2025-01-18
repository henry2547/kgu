<?php
require("dbconnect.php");

// Initialize an array to store error messages
$errors = array();

// Variables to hold the form data
$statement = '';
$name = '';

// Check if statement field is empty
if (empty($_POST['statement'])) {
    $errors[] = "The Statement field cannot be empty.";
} else {
    $statement = $_POST['statement'];
}


// Check if name field is empty
if (empty($_POST['name'])) {
    $errors[] = "The tutorial cannot be empty";
} else {
    $name = $_POST['name'];
}

// If there are errors, return JSON response with errors
if (!empty($errors)) {
    $response = array('error' => true, 'message' => $errors);
    header('Content-Type: application/json');
    echo json_encode($response);
} else {
    // insert tutorials in the database
    $sql = "INSERT INTO tutorials(name, description) VALUES(?, ?)";
    $stmt = $conn->prepare($sql);
    $success = $stmt->execute(array($name, $statement));

    if ($success) {
        // tutorials added successfully
        $response = array('success' => true, 'message' => 'Tutorials added successfully');
        header('Content-Type: application/json');
        echo json_encode($response);
    } else {
        // Error adding the tutorials
        $response = array('error' => true, 'message' => 'Failed to add tutorial.');
        header('Content-Type: application/json');
        echo json_encode($response);
    }
}
?>
