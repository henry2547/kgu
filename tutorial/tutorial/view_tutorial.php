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
						Matches to play
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
						<thead>
							<tr>
								<th>S/N</th>
								<th>
									Tutorial name
								</th>
								<th>
									Description
								</th>
								
							</tr>
						</thead>
						<tbody>
							<?php
							// The serial number variable
							$sn = 0;
							$query = mysqli_query($dbcon, "SELECT * FROM tutorials");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['matchId'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['name']; ?></td>
									<td><?php echo $row['description']; ?></td>

									
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