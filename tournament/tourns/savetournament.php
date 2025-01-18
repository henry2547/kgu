

<?php
require_once('database/Database.php');
$db = new Database();
include('header.php');
include('menubar.php');

include('dbconnect.php');
if (session_status() == PHP_SESSION_NONE) {
  include('session.php');
}



//array created to handle the error msgs
$errors = array();

//Variables to hold the form data
$statement = '';
$status = '';
$tournmentId = '';


if (empty($_POST['statement'])) {
  array_push($errors, "The Statefield field cannot be empty, ensure is entered");
} else {
  $statement = $_POST['statement'];
}

if (empty($_POST['status'])) {
  array_push($errors, "You need select the status field");
} else {
  $status = $_POST['status'];
}
if (empty($_POST['tournmentId'])) {
  array_push($errors, "Enter the tournment id");
} else {
  $tournmentId = $_POST['tournmentId'];
}





if ($errors) {

  // $output = array('error' => true, $errors);
  foreach ($errors as $value) {

    echo '<span>' . $value . ' </span> </br>';
  }
} else {

  $sql = "UPDATE tournament SET Description = ?, TournamentStatus = ? WHERE tournmentId =?";


  $q = $conn->prepare($sql);
  $success = $q->execute(array($statement, $status, $tournmentId));

  if ($success) {

    echo "<script>alert('The Tournament saved successfully')</script>";
    echo "<script>window.open('index.php','_self')</script>";
  }
}





$db->Disconnect();
?>
