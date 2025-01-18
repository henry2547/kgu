<?php

  require_once('database/Database.php');

  $db = new Database(); 

  if(session_status() == PHP_SESSION_NONE)
  {
    include('session.php');
    include('dbconnect.php');
  }



  //array created to handle the error msgs
  $errors = array();

  // array to hold the json econded data
  $output = array('error' => false);


    //Variables to hold the form data
  $password=$_POST['pwd']; 
  $gender=$_POST['gender']; 
  $address=$_POST['address']; 
  $fname=$_POST['fname'];
  $sname=$_POST['sname'];
  $phone=$_POST['phone'];
  $email=$_POST['email'];


  $sql = "INSERT INTO `golfer` (`golferId`, `FirstName`, `SecondName`, `Email`, `Phone`, `Address`, `Gender`, `Password`, `GolferStatus`) 
  VALUES (NULL, '$fname', '$sname', '$email', '$phone', '$address', '$gender', SHA1('$password'), 'approved');";

  $success = mysqli_query($dbcon,$sql);

  if( $success )
  {
      
    echo "<script type='text/javascript'>alert('Golfer Added');
    document.location='approved.php'</script>";
  }
            



        

?>
