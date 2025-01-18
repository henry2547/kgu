<?php
//require_once('session_login.php');
include('dbconnect.php');
include('header.php');

?>


<br />
<div class="container-fluid">
	<?php include('menubar.php'); ?>
	<div class="col-md-1"></div>
	<div class="col-md-8">
		<div class="panel panel-success">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">
						Tournament List
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>S/N</th>

								<th>
									<center>Name</center>
								</th>
								<th>
									<center>Location</center>
								</th>
								<th>
									<center>Stat date</center>
								</th>
								<th>
									<center>End date</center>
								</th>
								<th>
									<center>Deadline</center>
								</th>
								<th>
									<center>Description</center>
								</th>
								<th>
									<center>Status</center>
								</th>

								<th>
									<center>Action</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// The serial number variable
							$sn = 0;
							$query = mysqli_query($dbcon, "SELECT * FROM tournament WHERE TournamentStatus = 'pending'");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['tournmentId'];
								$status = $row['TournamentStatus'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['TournamentName']; ?></td>
									<td><?php echo $row['TournamentVenue']; ?></td>
									<td><?php echo $row['StartDate']; ?></td>
									<td><?php echo $row['EndDate']; ?></td>
									<td><?php echo $row['registrationDeadline']; ?></td>
									<td><?php echo $row['Description']; ?></td>
									<td><?php echo $row['TournamentStatus']; ?></td>


									<td class="empty" width="">
										<a data-placement="left" title="Click to Edit" id="edit<?php echo $id; ?>" href="edittournament.php<?php echo '?edit=' . $id; ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>



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