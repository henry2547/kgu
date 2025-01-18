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
						Club Winner details
					</h3>
				</div>
				<div id="trans-table">
					<table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
						<thead>
							<tr>
								<th>S/N</th>
								<th>
									<center>Clubname</center>
								</th>
								<th>
									<center>Points</center>
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
							$query = mysqli_query($dbcon, "SELECT 
										r.resultId,
										r.matchId,
										CASE
											WHEN MAX(r.clubId1) >= MAX(r.clubId2) THEN m.clubId1
											ELSE m.clubId2
										END as clubId,
										CASE
											WHEN MAX(r.clubId1) >= MAX(r.clubId2) THEN (SELECT ClubName FROM clubs WHERE clubId = m.clubId1) 
											ELSE (SELECT ClubName FROM clubs WHERE clubId = m.clubId2)
										END AS Clubname,
										GREATEST(MAX(r.clubId1), MAX(r.clubId2)) AS Points
									FROM results r 
									JOIN matches m ON r.matchId = m.matchId
									GROUP BY r.matchId, r.resultId
									ORDER BY Points DESC");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['resultId'];
								$clubId = $row['clubId'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['Clubname']; ?></td>
									<td><?php echo $row['Points']; ?></td>


									<td class="empty" width="">
										<a data-placement="left" title="Click to Edit" id="edit<?php echo $id; ?>" href="awardstatement.php<?php echo '?edit=' . $id; ?>" class="btn btn-success"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
										<a data-placement="left" title="Click to view" id="view<?php echo $id; ?>" href="awarddetails.php<?php echo '?id=' . $clubId; ?>" class="btn btn-success">Details<i class="icon-pencil icon-large"></i></a>



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