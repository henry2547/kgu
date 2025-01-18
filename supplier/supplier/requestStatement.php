<?php

include('header.php');
include('dbconnect.php');
include('menubar.php');

$requestId = $_GET['edit'];


?>


<div class="container-fluid">

	<div class="container-fluid">

		<div class="col-md-2"></div>
		<div class="col-md-8">
			<ul class="list-group" id="myinfo">

				<li class="list-group-item" id="mylist"></li>

			</ul>
			<div class="panel panel-success">
				<div class="panel-heading">

					<h3 class="panel-title">Request Details</h3>
				</div>
				<div class="panel-body">

					<div class="container-fluid">

						<form class="form-horizontal" method="post" role="form" id="saveSupply">


							<div class="form-row">
								<?php
								$query = mysqli_query($dbcon, "SELECT requested_kit.*, golf_tools.* 
								FROM requested_kit
								JOIN golf_tools ON requested_kit.kitId = golf_tools.kitId
								WHERE requested_kit.isUpdated = 0
								AND requested_kit.requestId = '$requestId'");

								while ($row = mysqli_fetch_array($query)) {
								?>
									<table class="table">
										<tr>
											<td width="160px">Request ID:</td>
											<td> <input type="text" value="<?php echo $requestId ?>" readonly="" name="requestId"> </td>
										</tr>
										<tr>
											<td>Kit name:</td>
											<td><?php echo $row['tool_name'] ?></td>
										</tr>
										<tr>
											<td>Quantity:</td>
											<td>
												<input type="number" name="quantity" readonly value="<?php echo $row['quantity']; ?>" id="quantity">
											</td>
										</tr>



									<?php
								}
									?>

									</table>

							</div>

							<div class="form-row">


								<div class="col-md-6">
									<div class="form-group">
										<label for="amount">Enter amount(each):</label>
										<input type="number" name="quantity_each" class="form-control" id="quantity_each" oninput="calculateTotal()">

									</div>

									<div class="form-group">
										<label for="amount">Total amount(Kshs):</label>
										<input type="number" name="amount" readonly class="form-control" id="totalAmount">

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

	<script type="text/javascript">
		$(document).on('submit', '#saveSupply', function(event) {
			event.preventDefault();

			// Remove existing error messages
			$(".list-group-item").remove();

			// Serialize form data
			var formData = $(this).serialize();

			// Send AJAX request
			$.ajax({
				url: 'saveSupply.php',
				type: 'post',
				data: formData,
				dataType: 'json',

				success: function(response) {
					if (response.error) {
						// Handle validation errors
						var errors = response.errors;

						for (var i = 0; i < errors.length; i++) {
							$('#myinfo').append('<li class="list-group-item alert alert-danger">' + errors[i] + '</li>');
						}
					} else {
						// Handle success
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Supply saved!',
							showConfirmButton: false,
							timer: 3000
						});

						// Clear form inputs or perform other actions
						$('input[name=statement]').val('');

						// Redirect after success
						setTimeout(function() {
							window.location = 'index.php';
						}, 3000);
					}
				},

				error: function(xhr, status, error) {
					console.error('AJAX Error:', error);
					// Handle AJAX errors if necessary
				}
			});
		});
	</script>

	<script>
		function calculateTotal() {
			// Get the values from the input fields
			var quantity_each = parseFloat(document.getElementById('quantity_each').value) || 0; // Get the 'quantity_each' value and default to 0 if empty
			var quantity = parseFloat(document.getElementById('quantity').value) || 0; // Get the 'quantity' value

			// Calculate the total amount
			var totalAmount = Math.floor(quantity_each * quantity); // Use Math.floor() to ensure the result is an integer

			// Update the total amount input field
			document.getElementById('totalAmount').value = totalAmount; // Set the total amount as an integer
		}
	</script>


	</body>

	</html>