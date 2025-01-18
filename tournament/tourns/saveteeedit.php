<?php 

include('header.php');
include('dbconnect.php');

	$teeId = $_POST['username'];
	$tname =$_POST['tname'];
	$description =$_POST['description'];
	$holes =$_POST['holes'];
	$status =$_POST['status'];
	
	if($holes==''){
mysqli_query($dbcon,"UPDATE teetime SET TeeName ='$tname', Description = '$description', NumberOfHoles = '$holes', TeeStatus = '$status' WHERE teeId ='$teeId'")or die(mysqli_error());
}
if(!empty($holes)){
mysqli_query($dbcon,"UPDATE teetime SET TeeName = '$tname', Description='$description', NumberOfHoles = '$holes', TeeStatus = '$status' WHERE teeId='$teeId'")or die(mysqli_error());
}

	
	 echo "<script type='text/javascript'>alert('Tee time Editted');
	  document.location='index.php'</script>";
	  

 ?>

