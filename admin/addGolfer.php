<?php 

include('header.php');
include('dbconnect2.php');

 ?>


<div class="container-fluid">
	

      <?php include('menubar.php')?> 
	<?php // include('menubar1.php');

	
	?>
<div class="container-fluid">

	<div class="col-md-2"></div>
	<div class="col-md-8">
		<ul class="list-group" id="myinfo" >

			<li class="list-group-item" id="mylist"></li>

		</ul>
			<div class="panel panel-success">
					  	<div class="panel-heading">
		
					  		<h3 class="panel-title">Enter Login Details</h3>
					  	</div>
			<div class="panel-body">

			 
				


				<div class="container-fluid">
					<form class="form-horizontal" action="saveuserlogin.php"  method="post" role="form">

						<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Firstname:</label>
										<input type="text" name="fname" class="form-control" id="staffid" required="" >
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Secondname:</label>
										<input type="text" name="sname" class="form-control" id="staffid" required="" >
									</div>
								</div>
						</div>

						<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Email:</label>
										<input type="email" name="email" class="form-control" id="golferEmail" required="" >
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Phone:</label>
										<input type="number" name="phone" class="form-control" id="golferPhone" required="" >
									</div>
								</div>
						</div>

						<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Address:</label>
										<input type="text" name="address" class="form-control" id="golferAddress" required="" >
									</div>
								</div>
								
						</div>

						<div class="form-row">
							
							<div class="col-md-6">
								<div class="form-group">
									<label for="">Select Gender:</label>
									    <select class="form-control" name="gender" id ="sdcrime">
											<option selected="selected" value="">Select</option>

												<option value="male"> Male </option>
												<option value="female"> Female </option>
										
										</select>
								</div>
							</div>

                        	<div class="col-md-6">
					       		<div class="form-group">
					       		 <label for="">Password:</label>
					       	
					        		<input type="password" readonly="" name="pwd" value="123456" class="form-control" id="pname"
					    		autofocus=""  >
					       		</div>
					   		</div>

					   		

					  	</div>

					  
					  </div>
					  	<div class="form-group">
							<button  type="submit" name="save_case" class="btn btn-success form-control">Save and Continue
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
<script type="text/javascript">

	$(document).on('submit', '#addsdtaff', function(event) {
		
		event.preventDefault();
		// This removes the error messages from the page
		 $(".list-group-item").remove();
		
		var formData = $(this).serialize();

			$.ajax({
					url: 'saveuserlogin.php',
					type: 'post',
					data: formData,
					dataType: 'JSON',

					success: function(response){

						if(response.error){

							console.log(response.error);
					}

						else{

							Swal.fire({
							  position: 'top-end',
							  icon: 'success',
							  title: 'Staff Saved',
							  showConfirmButton: false,
							  timer: 3000
							});
							
							
							setTimeout( function(){
								window.location='addstaff.php';
							}, 900);
							

						}

					}
					
					
				});
		


	});

</script>

</body>
</html>