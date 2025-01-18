<?php

// Start the session
session_start();

// Check if session variables are set
if (
    isset($_SESSION['FirstName']) && isset($_SESSION['SecondName'])
    && isset($_SESSION['golferId']) && isset($_SESSION['clubId'])
) {

    // Assign session variables to local variables
    $fname = $_SESSION['FirstName'];
    $sname = $_SESSION['SecondName'];
    $golferId = $_SESSION['golferId'];
    $clubId = $_SESSION['clubId'];
} else {
    // Redirect to login page if session variables are not set
    header("Location: login.php");
    exit(); // Stop further execution
}
?>