<?php

include('header.php');
include('dbconnect.php');
include('menubar.php');

$resultId = $_GET['edit'];

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

					<h3 class="panel-title">Result Details</h3>
				</div>
				<div class="panel-body">

					<div class="container-fluid">
						<form class="form-horizontal" action="saveawardstatement.php" method="post" role="form" id="awardWinner">


							<div class="form-row">
								<?php
								$query = mysqli_query($dbcon, "SELECT 
													r.resultId,
													r.matchId,
													CASE
														WHEN MAX(r.clubId1) >= MAX(r.clubId2) THEN m.clubId1
														ELSE m.clubId2
													END as clubId,
													CASE
														WHEN MAX(r.clubId1) >= MAX(r.clubId2) THEN (SELECT ClubName FROM clubs WHERE clubId = m.clubId1) 
														ELSE (SELECT ClubName FROM clubs WHERE clubId = m.clubId2)
													END AS Clubname,
													GREATEST(MAX(r.clubId1), MAX(r.clubId2)) AS Points
												FROM results r 
													JOIN matches m ON r.matchId = m.matchId
												WHERE r.resultId = '$resultId'
												GROUP BY r.matchId, r.resultId");

								while ($row = mysqli_fetch_array($query)) {

								?>
									<table class="table">
										<tr>
											<td width="160px">Result ID:</td>
											<td> <input type="text" value="<?php echo $resultId ?>" readonly="" name="resultId"> </td>
										</tr>
										<tr>
											<td>Club name:</td>
											<td><?php echo $row['Clubname'] ?></td>
										</tr>
										<tr>
											<td>Points:</td>
											<td><?php echo $row['Points'] ?></td>
										</tr>



									<?php
								}



								$query = mysqli_query($dbcon, "SELECT matches.*, clubs1.ClubName AS ClubName1, 
										clubs2.ClubName AS ClubName2 
								FROM matches 
								JOIN clubs AS clubs1 ON matches.clubId1 = clubs1.clubId
								JOIN clubs AS clubs2 ON matches.clubId2 = clubs2.clubId");

								while ($row = mysqli_fetch_array($query)) {

									$statement = $row['Statement'];
									$status = $row['matchStatus'];
								}
									?>

									</table>

							</div>

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">

										<div class="col-md-6">
											<div class="form-group">
												<label for="">Select Award type:</label>
												<select name="typeId" class="form-control">
													<option disabled selected></option>
													<?php
													require_once "dbconnect.php";
													$sql = "SELECT * FROM awardType";
													$result = $dbcon->query($sql);

													if ($result->num_rows > 0) {
														while ($row = $result->fetch_assoc()) {
															echo "<option value='" . $row['typeId'] . "'>" . $row['awardName'] . "</option>";
														}
													}
													?>
												</select>
											</div>
										</div>

										<script>

										</script>
									</div>
								</div>







							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-success form-control">Save
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
		$(document).on('submit', '#awardWinner', function(event) {
			event.preventDefault();
			// This removes the error messages from the page
			$(".list-group-item").remove();

			var formData = $(this).serialize();

			$.ajax({
				url: 'saveawardstatement.php',
				type: 'post',
				data: formData,
				dataType: 'json',

				success: function(response) {
					if (response.error) {
						// Handle validation errors
						var errors = response.message;
						Swal.fire({
							position: 'top-end',
							icon: 'error',
							title: errors,
							showConfirmButton: false,
							timer: 3000
						});
					} else {
						// Handle success
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Your Award was Saved!',
							showConfirmButton: false,
							timer: 3000
						});

						// Redirect after success (optional)
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