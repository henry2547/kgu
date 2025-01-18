<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "kenya_golf";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['supplyId']) && !empty($_POST['supplyId'])) {
    $supplyId = $_POST['supplyId'];

    $sql = "UPDATE saveSupply SET supPayment = 1 WHERE supplyId = $supplyId";

    if ($conn->query($sql) === TRUE) {
        echo "Record updated successfully";
    } else {
        echo "Error updating record: " . $conn->error;
    }
} else {
    echo "Error: saveSupplyId parameter not set or empty";
}

$conn->close();
?>
