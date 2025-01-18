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
								<th>
									<center>Phone number</center>
								</th>
								<th>
									<center>Addres</center>
								</th>
								<th>
									<center>Gender</center>
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
							$query = mysqli_query($dbcon, "SELECT * FROM golfer WHERE GolferStatus = 'rejected'");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['golferId'];
								$status = $row['GolferStatus'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['FirstName']; ?> <?php echo $row['SecondName']; ?></td>
									<td><?php echo $row['Email']; ?></td>
									<td><?php echo $row['Phone']; ?></td>
									<td><?php echo $row['Address']; ?></td>
									<td><?php echo $row['Gender']; ?></td>
									<td><?php echo $row['GolferStatus']; ?></td>

									<td class="empty" width="">
										<button type="button" data-toggle="modal" data-target="#edit<?php echo $row['golferId']; ?>" data-placement="left" title="Click to edit" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>


										<?php include('modal_edit_user.php'); ?>


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