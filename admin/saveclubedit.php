<?php 

include('header.php');
include('dbconnect.php');

	$clubId = $_POST['username'];
	$cname = $_POST['cname'];
	$region = $_POST['region'];
    $district = $_POST['district'];
	
	mysqli_query($dbcon,"UPDATE clubs SET ClubName ='$cname', region = '$region', district = '$district' WHERE clubId ='$clubId'")or die(mysqli_error());
		
	
	 echo "<script type='text/javascript'>alert('Club Editted');
	  document.location='viewClub.php'</script>";
	  

 ?>

