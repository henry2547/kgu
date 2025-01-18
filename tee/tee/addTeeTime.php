<?php

include('header.php');
include('dbconnect.php');

?>


<div class="container-fluid">


	<?php include('menubar.php') ?>
	<?php // include('menubar1.php');


	?>
	<div class="container-fluid">

		<div class="col-md-2"></div>
		<div class="col-md-8">
			<ul class="list-group" id="myinfo">

				<li class="list-group-item" id="mylist"></li>

			</ul>
			<div class="panel panel-success">
				<div class="panel-heading">

					<h3 class="panel-title">Enter Tee time Details</h3>
				</div>
				<div class="panel-body">


					<div class="container-fluid">
						<form class="form-horizontal" id="uploadTeeTime" action="uploadTeeTime.php" method="post" role="form" enctype="multipart/form-data">
							<div class="form-row">


								<div class="col-md-6">
									<div class="form-group">
										<label for="teeName">Tee Name:</label>
										<select name="tname" class="form-control" id="tname">
											<option disabled selected>--available tees--</option>
											<?php
											$select_tees = "SELECT * FROM available_tees";
											$results = mysqli_query($dbcon, $select_tees);

											// Check if query executed successfully
											if ($results) {
												// Fetch each row as an associative array
												while ($row = mysqli_fetch_assoc($results)) {
													// Output each option with tee_name as value and description as text
													echo '<option value="' . $row['id'] . '">' . $row['tee_name'] . '</option>';
												}
											} else {
												// Query execution failed
												echo '<option value="">No tees available</option>';
											}

											// Free result set
											mysqli_free_result($results);

											// Close database connection
											mysqli_close($dbcon);
											?>
										</select>

									</div>

									<!-- <div class="form-group">
										<label for="teeImage">Tee Image:</label>
										<input type="file" name="image" class="form-control" id="teeImage" required>
									</div> -->
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="teeHoles">Number of holes:</label>
										<input type="number" name="holes" class="form-control" id="teeHoles" required>
									</div>
								</div>

							</div>

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="description">Select course:</label>
										<select name="club" class="form-control">
											<option disabled selected>--select course--</option>
											<?php
											require "dbconnect.php";
											$select_tees = "SELECT * FROM clubs";
											$results = mysqli_query($dbcon, $select_tees);

											// Check if query executed successfully
											if ($results) {
												// Fetch each row as an associative array
												while ($row = mysqli_fetch_assoc($results)) {
													echo '<option value="' . $row['clubId'] . '">' . $row['ClubName'] . '</option>';
												}
											} else {
												// Query execution failed
												echo '<option value="">No courses available</option>';
											}

											// Free result set
											mysqli_free_result($results);

											// Close database connection
											mysqli_close($dbcon);
											?>
										</select>
									</div>
								</div>
							</div>

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="price">Price per hole:</label>
										<input type="number" name="price" class="form-control" id="price" required>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-success form-control">Save and Continue
									<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
								</button>
							</div>
						</form>
					</div>



				</div>
			</div>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>

<?php include('scripts.php'); ?>

<script type="text/javascript">
	$(document).on('submit', '#uploadTeeTime', function(event) {
		event.preventDefault();

		// Clear previous error messages
		$(".list-group-item").remove();

		var formData = new FormData(this);

		$.ajax({
			url: 'uploadTeeTime.php',
			type: 'post',
			data: formData,
			dataType: 'json', // Expect JSON response
			contentType: false,
			processData: false,

			success: function(response) {
				if (response.status === 'success') {
					// Success scenario
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Tee time Saved',
						showConfirmButton: false,
						timer: 3000
					});

					// Redirect after a delay
					setTimeout(function() {
						window.location = 'addTeeTime.php';
					}, 3000); // Adjust the delay as needed
				} else {
					// Handle server-side validation errors or other errors
					console.log(response.message);
					Swal.fire({
						icon: 'error',
						title: 'Oops...',
						text: 'Failed to save tee time!',
					});
				}
			},

			error: function(xhr, status, error) {
				// Handle AJAX errors
				console.error(xhr.responseText);
				Swal.fire({
					icon: 'error',
					title: 'Oops...',
					text: 'An error occurred!',
				});
			}
		});
	});
</script>



</body>

</html>