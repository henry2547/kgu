<?php

include('header.php');
include('dbconnect.php');

?>


<div class="container-fluid">


	<?php include('menubar.php') ?>
	<?php // include('menubar1.php');

	//$trans_id= uniqid();


	$paymentId = $_GET['edit'];
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
						<form class="form-horizontal" action="savepaymentstatement.php" id="savePayment" method="post" role="form">


							<div class="form-row">
								<?php
								$query = mysqli_query($dbcon, "SELECT payment.*, golfer.*
								FROM payment
								JOIN golfer ON payment.golferId = golfer.golferId
								WHERE payment.paymentId = '$paymentId'");

								while ($row = mysqli_fetch_array($query)) {
								?>
									<table class="table">
										<tr>
											<td width="160px">Payment ID:</td>
											<td> <input type="text" value="<?php echo $paymentId ?>" readonly="" name="paymentId"> </td>
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



								$query = mysqli_query($dbcon, "SELECT payment.*, golfer.*
								FROM payment
								JOIN golfer ON payment.golferId = golfer.golferId");

								while ($row = mysqli_fetch_array($query)) {

									$statement = $row['Statement'];
									$status = $row['paymentStatus'];
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
											<option value="<?php echo $status; ?>">
												<?php if ($status == '') {
													echo 'Select';
												} else {
													echo $status;
												}  ?></option>
											<option value="approved">Approved</option>
											<option value="pending">Pending</option>
											<option value="rejected">Rejected</option>



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
		$(document).on('submit', '#savePayment', function(event) {
			event.preventDefault();

			// Remove existing error messages
			$(".list-group-item").remove();

			var formData = $(this).serialize();

			$.ajax({
				url: 'savepaymentstatement.php',
				type: 'post',
				data: formData,
				dataType: 'json',

				success: function(response) {
					if (response.error) {
						// Display validation errors
						var errors = response[0];
						var len = errors.length;
						for (var i = 0; i < len; i++) {
							$('#myinfo').append('<li class="list-group-item alert alert-danger">' + errors[i] + '</li>');
						}
					} else {
						// Payment saved successfully
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Payment Saved!',
							showConfirmButton: false,
							timer: 3000
						});

						// Clear form input after success
						$('input[name=statement]').val('');

						// Redirect to index.php after a delay
						setTimeout(function() {
							window.location.href = 'index.php';
						}, 3000);
					}
				},
				error: function(xhr, status, error) {
					// Handle AJAX errors if any
					console.error('AJAX Error:', status, error);
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'Oops...',
						text: 'Something went wrong! Please try again later.',
					});
				}
			});
		});
	</script>


	</body>

	</html>