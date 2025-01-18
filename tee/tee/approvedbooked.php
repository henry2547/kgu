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
						Booked Tee Time
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
						<thead>
							<tr>
								<th>S/N</th>
								<th>
									<center>Image</center>
								</th>
								<th>
									<center>Teename</center>
								</th>
								<th>
									<center>Fullname</center>
								</th>
								<th>
									<center>Number of Holes</center>
								</th>
								<th>
									<center>Price Per Hole</center>
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
							$query = mysqli_query($dbcon, "SELECT booktee.*, available_tees.*, golfer.FirstName, golfer.SecondName, golfer.Email, teetime.*
							FROM booktee
							JOIN golfer ON booktee.golferId = golfer.golferId
							JOIN teetime ON booktee.teeId = teetime.teeId
							JOIN available_tees ON teetime.availableTeeId = available_tees.id
							WHERE booktee.BookingStatus	= 'approved'");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['bookingId'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>

									<td><img height='70px' src='../../tee/tee/uploads/<?php echo $row["Image"]; ?>' alt="Tee Image"></td>
									<td><?php echo $row['tee_name']; ?></td>
									<td><?php echo $row['FirstName']; ?> <?php echo $row['SecondName']; ?></td>
									<td><?php echo $row['BookedHoles']; ?></td>
									<td><?php echo number_format($row['Price'],2) ?></td>
									<td><?php echo $row['BookingStatus']; ?></td>


									<td class="empty" width="">
										<a data-placement="left" title="Click to Edit" id="edit<?php echo $id; ?>" href="bookstatement.php<?php echo '?edit=' . $id; ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
										<a data-placement="left" title="Click to view" id="view<?php echo $id; ?>" href="bookdetails.php<?php echo '?id=' . $id; ?>" class="btn btn-success">Details<i class="icon-pencil icon-large"></i></a>



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