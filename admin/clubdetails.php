<?php
//require_once('session_login.php');
include('dbconnect.php');
include('header.php');

?>


<br />
<div class="container-fluid">
	<?php include('menubar.php'); ?>
	<?php
	$clubId = $_GET['id'];
	?>
	<div class="col-md-1"></div>
	<div class="col-md-8">
		<div class="panel panel-success">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">
						Golfer and Club Details
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>S/N</th>

								<th>
									<center>Clubname</center>
								</th>
								<th>
									<center>Fullname</center>
								</th>
								
								<th>
									<center>Email</center>
								</th>
								<th>
									<center>Address</center>
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
							$query = mysqli_query($dbcon, "SELECT golfer.*, clubs.*
									FROM golfer
									JOIN clubs ON golfer.clubId = clubs.clubId
									WHERE clubs.clubId = '$clubId'");

							while ($row = mysqli_fetch_array($query)) {


								$golferId = $row['golferId'];

								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>

									<td><?php echo $row['ClubName']; ?></td>
									<td><?php echo $row['FirstName']; ?> <?php echo $row['SecondName']; ?></td>
									<td><?php echo $row['Email']; ?></td>
									<td><?php echo $row['Address']; ?></td>

									<td class="empty" width="">
										<button type="button" data-toggle="modal" data-target="#<?php echo $golferId; ?>" data-placement="left" class="btn btn-danger"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></button>

										<?php include('modal_delete_club.php'); ?>

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