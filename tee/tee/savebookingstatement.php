<?php
include('dbconnect.php');

// Array to hold error messages
$errors = [];

// Variables to hold the form data
$statement = '';
$status = '';
$bookingId = '';

// Validate form fields
if (empty($_POST['statement'])) {
    $errors[] = "The Statement field cannot be empty.";
} else {
    $statement = $_POST['statement'];
}

if (empty($_POST['status'])) {
    $errors[] = "You need to select the status field.";
} else {
    $status = $_POST['status'];
}

if (empty($_POST['bookingId'])) {
    $errors[] = "Enter the booking ID.";
} else {
    $bookingId = $_POST['bookingId'];
}

// If there are errors, return JSON response
if (!empty($errors)) {
    $response = [
        'error' => true,
        'message' => $errors
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
} else {
    // If no errors, proceed with database update
    $sql = "UPDATE booktee SET Statement = ?, BookingStatus = ? WHERE bookingId = ?";
    $q = $conn->prepare($sql);
    $success = $q->execute([$statement, $status, $bookingId]);

    if ($success) {
        // Return success message as JSON
        $response = [
            'error' => false,
            'message' => 'The Tee saved successfully.'
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    } else {
        // Handle database update failure (though ideally, this should not happen if validation passed)
        $response = [
            'error' => true,
            'message' => 'Failed to update the Tee.'
        ];
        
        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
?>
