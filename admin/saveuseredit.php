<?php 

include('header.php');
include('dbconnect.php');

	$golferId = $_POST['username'];
	$fname =$_POST['fname'];
	$oname =$_POST['oname'];
	$GolferStatus =$_POST['status'];
	
	if($GolferStatus==''){
mysqli_query($dbcon,"UPDATE golfer SET FirstName ='$fname', SecondName = '$oname' WHERE golferId='$golferId'")or die(mysqli_error());
}
if(!empty($GolferStatus)){
mysqli_query($dbcon,"UPDATE golfer SET FirstName = '$fname', GolferStatus = '$GolferStatus', SecondName='$oname' WHERE golferId='$golferId'")or die(mysqli_error());
}

	
	 echo "<script type='text/javascript'>alert('Golfer Editted Successfully');
	  document.location='index.php'</script>";
	  

 ?>

