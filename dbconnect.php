<?php  
$dbcon = mysqli_connect ("localhost", "USERNAME", "PASSWORD", "kenya_golf");

mysqli_set_charset($dbcon, 'utf8'); 

$servername = "localhost";
$username = "USERNAME";
$password = "PASSWORD";

$dbname = "kenya_golf";
$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
  // set the PDO error mode to exception
  $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

?>
