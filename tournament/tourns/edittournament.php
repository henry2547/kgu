<?php 

include('header.php');
include('dbconnect.php');

 ?>


<div class="container-fluid">
	

      <?php include('menubar.php')?> 
	<?php // include('menubar1.php');

	//$trans_id= uniqid();
	  
	 
	$tournmentId=$_GET['edit'];
	$casetype='';

    $statement='';
    $status='';

	
	?>

	

<div class="container-fluid">

	<div class="col-md-2"></div>
	<div class="col-md-8">
		<ul class="list-group" id="myinfo" >

			<li class="list-group-item" id="mylist"></li>

		</ul>
			<div class="panel panel-success">
					  	<div class="panel-heading">
		
					  		<h3 class="panel-title">Tournament Details</h3>
					  	</div>
			<div class="panel-body">

			 <div class="container-fluid">
					<form class="form-horizontal" action="savetournament.php" method="post" role="form">
				
					  	
					  	<div class="form-row">
					  <?php
			 		$query=mysqli_query($dbcon,"SELECT * FROM tournament 
                     WHERE tournament.tournmentId = '$tournmentId'");
                     
                    while($row = mysqli_fetch_array($query)){
                        ?>
			 			 <table class="table">
			 			 	<tr>
			 			 		<td width="160px">tournmentId:</td><td> <input type="text" value="<?php echo $tournmentId?>" readonly="" name="tournmentId"> </td>
			 			 	</tr>
			 			 	<tr>
			 			 		<td>Tournmanent name:</td><td><?php echo $row['TournamentName']?></td>
			 			 	</tr>
			 			 	<tr>
			 			 		<td>Tournament venue:</td><td><?php echo $row['TournamentVenue']?></td>
			 			 	</tr>
			 			 	<tr>
			 			 		<td>Start date:</td><td><?php echo $row['StartDate']?></td>
			 			 	</tr>
			 			 	
			 			 	<tr>
			 			 		<td>End date:</td><td><?php echo $row['EndDate']?></td>
			 			 	</tr>
			 			 	
			 			 	<tr>
			 			 		<td>Entry fee </td><td><?php echo $row['EntryFee']?></td>
			 			 	</tr>

                              <tr>
			 			 		<td>Registration deadline </td><td><?php echo $row['registrationDeadline']?></td>
			 			 	</tr>

                              <tr>
			 			 		<td>Description</td><td><?php echo $row['Description']?></td>
			 			 	</tr>

                              <tr>
			 			 		<td>Created At </td><td><?php echo $row['CreateAt']?></td>
			 			 	</tr>
			 			 	
			 			 	
			 			 <?php
			 			 }
			 			


			 			 $query=mysqli_query($dbcon,"SELECT * FROM tournament");

		                while($row = mysqli_fetch_array($query)){
			
			 			 		$statement= $row['Description'];
			 			 		$status = $row['TournamentStatus']; 
			 			 	
			 			 	
			 			 	
			 			 	
			 			 
			 			 }
			 			 ?>
			 			 	
			 			 </table>

					  	 </div>
					  	
					  	<div class="form-row">
					  	<div class="col-md-6">
					  	<div class="form-group">
						<textarea class="ckeditor"  name="statement" id="ckeditor" rows="60" cols="100">
                 <?php echo $statement; ?>
            </textarea>
            <script>
                // Replace the <textarea id="editor1"> with a CKEditor 4
                // instance, using default configuration.
                CKEDITOR.replace( 'editor1' );
            </script>
							 </div>
						</div>

<div class="col-md-6">
					  	<div class="form-group">
									    <label for="">Select Status:</label>
									    <select class="form-control" name="status" id ="crime" required="">
									    	 <option  value="<?php echo $status; ?>"><?php if($status==''){echo 'Select';}else{echo $status;}  ?></option>
									    <option value="approved">Approved</option>
									    <option  value="pending">Pending</option>



									    	</select>
							 </div>
						</div>





					  	 </div>

					  <div class="form-group">
					  <button  type="submit" name="savecidstatement" class="btn btn-success form-control">Save
					  <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
					  </button>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>

<?php include('scripts.php'); ?>
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>
<script type="text/javascript">

	$(document).on('submit', '#addaction', function(event) {
		event.preventDefault();
		// This removes the error messages from the page
		 $(".list-group-item").remove();
		 
		var formData = $(this).serialize();

			$.ajax({
					url: 'saveassigncase.php',
					type: 'post',
					data: formData,
					dataType: 'JSON',

					success: function(response){

						if(response.error){

							var len = response[0].length;

							for(var i=0; i<len; i++){


								$('#myinfo').append('<li class="list-group-item alert alert-danger"> ' + response[0][i] + '</li>');
													}
										}
					

						else{
							
							Swal.fire({
							  position: 'top-end',
							  icon: 'success',
							  title: 'Your Booking was Saved',
							  showConfirmButton: false,
							  timer: 3000
							});
							
							$('input[name=statement]').val('');
							setTimeout( function(){
								window.location='../tee/tee';
							}, 900);
							

						}

					}
					
					
				});
		


	});

</script>

</body>
</html>