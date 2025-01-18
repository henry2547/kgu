<?php

include('header.php');
include('dbconnect.php');
include('menubar.php');

$matchId = $_GET['edit'];


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

					<h3 class="panel-title">Match Details</h3>
				</div>
				<div class="panel-body">

					<div class="container-fluid">

						<form class="form-horizontal" method="post" role="form" id="saveMatch">


							<div class="form-row">
								<?php
								$query = mysqli_query($dbcon, "SELECT matches.matchId, matches.matchStatus, clubs1.ClubName AS ClubName1, clubs2.ClubName AS ClubName2 
								FROM matches 
								JOIN clubs AS clubs1 ON matches.clubId1 = clubs1.clubId
								JOIN clubs AS clubs2 ON matches.clubId2 = clubs2.clubId
								WHERE matches.matchId = '$matchId'");

								while ($row = mysqli_fetch_array($query)) {
								?>
									<table class="table">
										<tr>
											<td width="160px">Match ID:</td>
											<td> <input type="text" value="<?php echo $matchId ?>" readonly="" name="matchId"> </td>
										</tr>
										<tr>
											<td>Club name:</td>
											<td><?php echo $row['ClubName1'] ?></td>
										</tr>
										<tr>
											<td>Club name:</td>
											<td><?php echo $row['ClubName2'] ?></td>
										</tr>



									<?php
								}
									?>

									</table>

							</div>

							<div class="form-row">


								<div class="col-md-6">
									<div class="form-group">
										<label for="">Select match status:</label>
										<select class="form-control" name="status" id="status" required="">

											<option value="pending">Pending</option>
											<option value="playing">Playing</option>
											<option value="ended">Ended</option>
											<option value="postponed">Postponed</option>
											<option value="cancelled">Cancelled</option>



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

	<script type="text/javascript">
		$(document).on('submit', '#saveMatch', function(event) {
			event.preventDefault();

			// Remove existing error messages
			$(".list-group-item").remove();

			// Serialize form data
			var formData = $(this).serialize();

			// Send AJAX request
			$.ajax({
				url: 'savematchstatement.php',
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
							title: 'Match status changed!',
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


	</body>

	</html>