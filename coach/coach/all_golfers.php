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
						Golfer List
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>S/N</th>

								<th>
									<center>Fullname</center>
								</th>
								
								<th>
									<center>Email address</center>
								</th>

								<th>Phone</th>
								
								<th>
									<center>Action</center>
								</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// The serial number variable
							$sn = 0;
							$query = mysqli_query($dbcon, "SELECT booktee.*, golfer.* 
							FROM booktee
							JOIN golfer ON booktee.golferId = golfer.golferId
							WHERE golfer.GolferStatus = 'approved'
							AND booktee.BookingStatus = 'approved'");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['golferId'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['FirstName']; ?> <?php echo $row['SecondName']; ?></td>
									<td><?php echo $row['Email']; ?></td>
									<td><?php echo $row['Phone']; ?></td>

									<td class="empty" width="">
										<a data-placement="left" title="Click to monitor" id="view<?php echo $id; ?>" href="monitorGolfer.php<?php echo '?id=' . $id; ?>" class="btn btn-success">Monitor<i class="icon-pencil icon-large"></i></a>



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