<?php 
//require_once('session_login.php');
include('dbconnect.php');
include('header.php');

 ?>

 
<br />
<div class="container-fluid">
	<?php include('menubar.php');?>
	<div class="col-md-1"></div>
	<div class="col-md-8">
		<div class="panel panel-success">
			<div class="panel panel-success">
			 	<div class="panel-heading">
			 		<h3 class="panel-title">
			 			Club Details
			 		</h3>
			 	</div>
<div id="trans-table">
<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
	<thead>
	    <tr>
	        <th>S/N</th>
	        
	        <th ><center>Clubname</center></th>
	        <th><center>Region</center></th>
			<th><center>District</center></th>
	    
	        <th><center>Action</center></th>
	    </tr>
	</thead>
    <tbody>
    	<?php
		// The serial number variable
		$sn=0;
		$query=mysqli_query($dbcon,"SELECT * FROM clubs");

		while($row = mysqli_fetch_array($query)){
		$id = $row['clubId'];
		$sn++;
		?>
		<tr>
       
        <td><?php echo $sn;?></td>
       
       
		<td><?php echo $row['ClubName'];?></td>
		<td><?php echo $row['region']; ?></td>
		<td><?php echo $row['district']; ?></td>
		
		<td class="empty" width="">
            
			<button type="button" data-toggle="modal" data-target="#edit<?php echo $row['clubId'];?>" data-placement="left" title="Click to edit"   class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>
            <a data-placement="left" title="Click to view" id="view<?php echo $id;?>" href="clubdetails.php<?php echo'?id='.$id; ?>" class="btn btn-success">Details<i class="icon-pencil icon-large"></i></a>
			
			
            <?php include('modal_edit_club.php'); ?> 
			
			
		</td>
		</tr>
	<?php } ?>    
    </tbody>
</table>
</div>
</div>

	</div>
	<div class="col-md-1"></div>
</div>


<?php include('scripts.php'); ?>


	

<script type="text/javascript">
	$(document).ready(function() {
		$('#myTable-trans').DataTable();
	});
</script>
</body>
</html>