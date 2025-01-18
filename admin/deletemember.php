<?php
include('dbconnect.php');
if (isset($_POST['delete'])){
	$delete = mysqli_real_escape_string($dbcon,trim($_POST['deleted']));

mysqli_query($dbcon,"UPDATE `golfer` SET `clubId` = NULL WHERE `golfer`.`golferId` = '$delete';");


header("location: viewClub.php");
}
?>