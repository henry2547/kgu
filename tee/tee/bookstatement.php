<?php

include('header.php');
include('dbconnect.php');

?>


<div class="container-fluid">


	<?php include('menubar.php') ?>
	<?php // include('menubar1.php');

	//$trans_id= uniqid();
	$bookingId = $_GET['edit'];
	$casetype = '';
	$statement = '';
	$status = '';


	?>



	<div class="container-fluid">

		<div class="col-md-2"></div>
		<div class="col-md-8">
			<ul class="list-group" id="myinfo">

				<li class="list-group-item" id="mylist"></li>

			</ul>
			<div class="panel panel-success">
				<div class="panel-heading">

					<h3 class="panel-title">User Details</h3>
				</div>
				<div class="panel-body">

					<div class="container-fluid">

						<form class="form-horizontal" action="savebookingstatement.php" method="post" id="saveBooking" role="form">


							<div class="form-row">
								<?php
								$query = mysqli_query($dbcon, "SELECT booktee.*, golfer.*, teetime.*
								FROM booktee
								JOIN golfer ON booktee.golferId = golfer.golferId
								JOIN teetime ON booktee.teeId = teetime.teeId
								WHERE booktee.bookingId = '$bookingId'");

								while ($row = mysqli_fetch_array($query)) {
								?>
									<table class="table">
										<tr>
											<td width="160px">Booking Number:</td>
											<td> <input type="text" value="<?php echo $bookingId ?>" readonly="" name="bookingId"> </td>
										</tr>
										<tr>
											<td>Firstname:</td>
											<td><?php echo $row['FirstName'] ?></td>
										</tr>
										<tr>
											<td>Secondname:</td>
											<td><?php echo $row['SecondName'] ?></td>
										</tr>
										<tr>
											<td>Email address:</td>
											<td><?php echo $row['Email'] ?></td>
										</tr>

										<tr>
											<td>Phone number:</td>
											<td><?php echo $row['Phone'] ?></td>
										</tr>

										<tr>
											<td>Registration Date </td>
											<td><?php echo $row['RegistrationDate'] ?></td>
										</tr>


									<?php
								}



								$query = mysqli_query($dbcon, "SELECT booktee.*, golfer.*, teetime.*
								FROM booktee
								JOIN golfer ON booktee.golferId = golfer.golferId
								JOIN teetime ON booktee.teeId = teetime.teeId");

								while ($row = mysqli_fetch_array($query)) {

									$statement = $row['Statement'];
									$status = $row['BookingStatus'];
								}
									?>

									</table>

							</div>

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<textarea class="ckeditor" name="statement" id="ckeditor" rows="60" cols="100">
											<?php echo $statement; ?>
										</textarea>
										<script>
											// Replace the <textarea id="editor1"> with a CKEditor 4
											// instance, using default configuration.
											CKEDITOR.replace('editor1');
										</script>
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="">Select Status:</label>
										<select class="form-control" name="status" id="crime" required="">
											<option value="<?php echo $status; ?>"><?php if ($status == '') {
																						echo 'Select';
																					} else {
																						echo $status;
																					}  ?></option>
											<option value="approved">Approved</option>
											<option value="pending">Pending</option>



										</select>
									</div>
								</div>





							</div>

							<div class="form-group">
								<button type="submit" name="savecidstatement" class="btn btn-success form-control">Save
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
		$(document).on('submit', '#saveBooking', function(event) {
			event.preventDefault();
			// This removes the error messages from the page
			$(".list-group-item").remove();

			var formData = $(this).serialize();

			$.ajax({
				url: 'savebookingstatement.php',
				type: 'post',
				data: formData,
				dataType: 'json', // Expect JSON response

				success: function(response) {
					if (response.error) {
						// If there are errors, display them
						var errors = response.errors;

						$.each(errors, function(index, error) {
							$('#myinfo').append('<li class="list-group-item alert alert-danger">' + error + '</li>');
						});
					} else {
						// If booking was successful, show success message
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Booking status Saved',
							showConfirmButton: false,
							timer: 3000
						});

						// Clear form input
						$('input[name=statement]').val('');

						// Redirect after a delay
						setTimeout(function() {
							window.location = 'index.php';
						}, 900);
					}
				},
				error: function(xhr, status, error) {
					console.error("Error:", error);
					// Handle AJAX errors if necessary
				}
			});
		});

	</script>


	</body>

	</html>