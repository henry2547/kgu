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
						Tee Time List
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>S/N</th>

								<th>
									<center>Image</center>
								</th>
								<th>
									<center>Tee name</center>
								</th>
								<th>
									<center>Description</center>
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
							$query = mysqli_query($dbcon, "SELECT teetime.*, available_tees.* 
							FROM teetime
							JOIN available_tees ON teetime.availableTeeId = available_tees.id
							WHERE teetime.TeeStatus = 'pending'");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['teeId'];
								$status = $row['TeeStatus'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><img height='70px' src='uploads/<?php echo $row["Image"]; ?>' alt="Tee Image"></td>
									<td><?php echo $row['tee_name']; ?></td>
									<td><?php echo $row['description']; ?></td>
									<td><?php echo $row['NumberOfHoles']; ?></td>
									<td><?php echo $row['Price']; ?></td>
									<td><?php echo $row['TeeStatus']; ?></td>

									<td class="empty" width="">
										<button type="button" data-toggle="modal" data-target="#edit<?php echo $row['teeId']; ?>" data-placement="left" title="Click to edit" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></button>



										<?php include('modal_edit.php'); ?>


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