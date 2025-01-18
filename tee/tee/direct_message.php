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
						Payment details
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
						<thead>
							<tr>
								<th>S/N</th>
								<th>Fullname</th>
								
								<th>Message</th>

								<th>Action
							</tr>
						</thead>
						<tbody>
							<?php
							// The serial number variable
							$sn = 0;
							$query = mysqli_query($dbcon, "SELECT feedback.*, golfer.*
                            FROM feedback
                            JOIN golfer ON feedback.golferId = golfer.golferId
                            WHERE feedback.message_to = 'tee_manager'");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['feedbackId'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['FirstName']; ?> <?php echo $row['SecondName']; ?></td>
									
									<td><?php echo $row['Message']; ?></td>


									<td class="empty" width="">
										<a data-placement="left" title="Click to Edit" id="edit<?php echo $id; ?>" href="replyMessage.php<?php echo '?edit=' . $id; ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
										

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