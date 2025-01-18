<?php
include "sessions.php";
include "header.php";
include "menubar.php";
include "dbconnect.php";
?>

<br />
<div class="container-fluid">
	<div class="col-md-1"></div>
	<div class="col-md-8">
        
		<div class="panel panel-success">
			<div class="panel panel-success">
				<div class="panel-heading">
					<h3 class="panel-title">
						My History
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
						<thead>
							<tr>
								<th>S/N</th>

								<th>Tee time</th>
								<th>Price (Kshs)</th>
								<th>Holes</th>
								<th>Code</th>
								<th>Total</th>
								<th>Mode of payment</th>
							</tr>
						</thead>
						<tbody>
							<?php
							// The serial number variable
							$sn = 0;
							$query = mysqli_query($dbcon, "SELECT booktee.*, 
                                teetime.*, 
                                golfer.*, 
								payment.*,
								available_tees.*,
                                GROUP_CONCAT(booktee.BookedHoles) AS allHoles,
                                GROUP_CONCAT(teetime.Price) AS allPrices,
                                GROUP_CONCAT(available_tees.tee_name) AS allTees
                            FROM booktee
                            JOIN teetime ON booktee.teeId = teetime.teeId
                            JOIN golfer ON booktee.golferId = golfer.golferId
							JOIN available_tees ON  teetime.availableTeeId = available_tees.id
							JOIN payment ON  booktee.golferId = payment.golferId
                            WHERE booktee.golferId = '$golferId'
                            AND booktee.BookingStatus = 'approved'
                            AND booktee.isPaid = 'paid'
                            GROUP BY booktee.bookingId;");

							while ($row = mysqli_fetch_array($query)) {

								$price = $row['allPrices'];
								$holes = $row['allHoles'];

								$total = $price * $holes;

								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									
									<td><?php echo $row['allTees']; ?></td>
									<td><?php echo number_format($price, 2) ?></td>
									<td><?php echo  $holes?></td>
									<td><?php echo $row['PaymentCode']; ?></td>
									<td>Kshs <?php echo  number_format($total, 2)?></td>
									<td><?php echo $row['mode_payment']; ?></td>
									
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