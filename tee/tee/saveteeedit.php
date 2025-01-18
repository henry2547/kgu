<?php

include('header.php');
include('dbconnect.php');

$teeId = $_POST['username'];
$tname = $_POST['tname'];
$description = $_POST['description'];
$holes = $_POST['holes'];
$status = $_POST['status'];

// Validate and sanitize input
$teeId = mysqli_real_escape_string($dbcon, $teeId);
$tname = mysqli_real_escape_string($dbcon, $tname);
$description = mysqli_real_escape_string($dbcon, $description);
$holes = mysqli_real_escape_string($dbcon, $holes);
$status = mysqli_real_escape_string($dbcon, $status);

// Prepare the update statement
$query = "UPDATE teetime SET TeeName = ?, Description = ?, NumberOfHoles = ?, TeeStatus = ? WHERE teeId = ?";
$stmt = mysqli_prepare($dbcon, $query);

if ($stmt) {
    mysqli_stmt_bind_param($stmt, 'ssssi', $tname, $description, $holes, $status, $teeId);
    
    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo "<script type='text/javascript'>alert('Tee time edited successfully');
              document.location='index.php';</script>";
    } else {
        echo "<script type='text/javascript'>alert('Error updating tee time: " . mysqli_stmt_error($stmt) . "');
              document.location='index.php';</script>";
    }

    // Close the statement
    mysqli_stmt_close($stmt);
} else {
    echo "<script type='text/javascript'>alert('Failed to prepare the SQL statement.');
          document.location='index.php';</script>";
}

// Close the database connection
mysqli_close($dbcon);
?>
