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
						Booked Tournament
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
						<thead>
							<tr>
								<th>S/N</th>
								<th>
									<center>Fullname</center>
								</th>
								
								<th>
									<center>Club name</center>
								</th>
								<th>
									<center>Booking Date</center>
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
							$query = mysqli_query($dbcon, "SELECT booktournament.*, golfer.*, tournament.TournamentName, clubs.* 
							FROM booktournament
							JOIN golfer ON booktournament.golferId = golfer.golferId
							JOIN tournament ON booktournament.tournamentId = tournament.tournmentId
							JOIN clubs ON booktournament.clubId = clubs.clubId
							WHERE BookingStatus = 'pending'
							GROUP BY golfer.golferId;");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['bookId'];
								$golferId = $row['golferId'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['FirstName']; ?> <?php echo $row['SecondName']; ?></td>
									<td><?php echo $row['ClubName']; ?></td>
									<td><?php echo $row['bookingDate']; ?></td>


									<td class="empty" width="">
										<a data-placement="left" title="Click to Edit" id="edit<?php echo $id; ?>" href="bookstatement.php<?php echo '?edit=' . $id; ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
										<a data-placement="left" title="Click to view" id="view<?php echo $id; ?>" href="bookdetails.php<?php echo '?id=' . $id . '&golferId=' . $golferId; ?>" class="btn btn-success">Details<i class="icon-pencil icon-large"></i></a>



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