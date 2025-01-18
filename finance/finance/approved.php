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
								<th>
									<center>Fullname</center>
								</th>
								
								<th>
									<center>Email</center>
								</th>
								<th>
									<center>code</center>
								</th>
								<th>
									<center>Amount</center>
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
							$query = mysqli_query($dbcon, "SELECT payment.*, golfer.*
                            FROM payment
                            JOIN golfer ON payment.golferId = golfer.golferId
                            WHERE payment.paymentStatus = 'approved'");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['paymentId'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['FirstName']; ?> <?php echo $row['SecondName']; ?></td>
									<td><?php echo $row['Email']; ?></td>
									<td><?php echo $row['PaymentCode']; ?></td>
									<td><?php echo $row['Amount']; ?></td>
									<td><?php echo $row['paymentStatus']; ?></td>


									<td class="empty" width="">
										<a data-placement="left" title="Click to Edit" id="edit<?php echo $id; ?>" href="paymentstatement.php<?php echo '?edit=' . $id; ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
										<a data-placement="left" title="Click to view" id="view<?php echo $id; ?>" href="paymentdetails.php<?php echo '?id=' . $id; ?>" class="btn btn-success">Details<i class="icon-pencil icon-large"></i></a>



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