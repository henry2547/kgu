<?php
session_start();
require("dbconnect.php");

$errors = array();
$output = array('error' => false);

$cname = isset($_POST['cname']) ? mysqli_real_escape_string($dbcon, $_POST['cname']) : '';
$region = isset($_POST['region']) ? mysqli_real_escape_string($dbcon, $_POST['region']) : '';
$district = isset($_POST['district']) ? mysqli_real_escape_string($dbcon, $_POST['district']) : '';

if (empty($cname) || empty($region) || empty($district)) {
    $output['error'] = true;
    $output['message'] = "All fields are required.";
} else {
    $sql = "INSERT INTO clubs (ClubName, region, district) VALUES (?, ?, ?)";
    $stmt = $dbcon->prepare($sql);
    $stmt->bind_param("sss", $cname, $region, $district);

    if ($stmt->execute()) {
        $output['message'] = "Club added successfully.";
    } else {
        $output['error'] = true;
        $output['message'] = "Error adding club: " . $stmt->error;
    }
    

    $stmt->close();
}

header('Content-Type: application/json');
echo json_encode($output);
