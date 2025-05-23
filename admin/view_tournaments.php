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

		<a href="#" onClick="window_print()" class="btn btn-info" style="margin-bottom:20px"><i class="icon-print icon-large"></i> Print</a>

		<div class="panel panel-success" id="outprint">
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
									Club name
								</th>
								<th>Vs</th>
								<th>
									Club name
								</th>

								<th>
									Match Status
								</th>
								<th>Date</th>

							</tr>
						</thead>
						<tbody>
							<?php
							// The serial number variable
							$sn = 0;
							$query = mysqli_query($dbcon, "SELECT matches.*, clubs1.ClubName AS ClubName1, clubs2.ClubName AS ClubName2 
							FROM matches 
							JOIN clubs AS clubs1 ON matches.clubId1 = clubs1.clubId
							JOIN clubs AS clubs2 ON matches.clubId2 = clubs2.clubId
							");

							while ($row = mysqli_fetch_array($query)) {
								$id = $row['matchId'];
								$sn++;
							?>
								<tr>

									<td><?php echo $sn; ?></td>


									<td><?php echo $row['ClubName1']; ?></td>
									<th>vs</th>
									<td><?php echo $row['ClubName2']; ?></td>
									<td><?php echo $row['matchStatus']; ?></td>
									<td><?php echo $row['matchDate']; ?></td>


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

	<script type="text/javascript">
		function window_print() {
			var _head = $('head').clone();
			var _p = $('#outprint').clone();
			var _html = $('<div>')
			_html.append("<head>" + _head.html() + "</head>")
			_html.append("<h3 class='text-center'>KENYA GOLF UNION</h3>")
			_html.append(_p)
			console.log(_html.html())
			var nw = window.open("", "_blank", "width:900;height:800")
			nw.document.write(_html.html())
			nw.document.close()
			nw.print()
			setTimeout(() => {
				nw.close()
			}, 500);
		}
	</script>

	</body>

	</html>