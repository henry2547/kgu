<?php
$clubId = $_GET['id'];
require_once('dbconnect.php');
include('header.php');

?>






<div class="container-fluid">
	<div class="col-md-1"></div>
	<div class="col-md-10">


	</div>

	<div class="container-fluid">
		<?php include('menubar.php') ?>
		<div class="col-md-2"></div>
		<div class="col-md-8">
			<a href="#" onClick="window_print()" class="btn btn-info" style="margin-bottom:20px"><i class="icon-print icon-large"></i> Print</a>



			</script>
			<div class="panel panel-success" id="outprint">
				<div class="panel panel-success">
					<div class="panel-heading">
						<h3 class="panel-title">Awards Details</h3>
					</div>
					<div class="panel-body">
						<br />

						<div class="panel panel-success">
							<div class="panel-heading">

								<h3 class="panel-title"> Club Details</h3>
							</div>
							<div class="panel-body">
								<?php
								$query = mysqli_query($dbcon, "SELECT * FROM clubs
                     WHERE clubs.clubId = '$clubId'");

								while ($row = mysqli_fetch_array($query)) {
								?>
									<table class="table">
										<tr>
											<td width="160px">Club ID:</td>
											<td> <input type="text" value="<?php echo $clubId ?>" readonly="" name="clubId"> </td>
										</tr>
										<tr>
											<td>Club name:</td>
											<td><?php echo $row['ClubName'] ?></td>
										</tr>
										<tr>
											<td>Region:</td>
											<td><?php echo $row['region'] ?></td>
										</tr>

										<tr>
											<td>District:</td>
											<td><?php echo $row['district'] ?></td>
										</tr>





									<?php
								}
									?>

									</table>

							</div>
						</div>

						<div class="panel panel-success">
							<div class="panel-heading">
								<h3 class="panel-title"> <span class="glyphicon glyphicon-user" aria-hidden="true"></span> Users in the club</h3>
							</div>
							<div class="panel-body">
								<table id="myTable-party" class="table table-bordered table-hover" cellspacing="0" width="100%">
									<thead>
										<tr>
											<th>
												<center>
													First name
												</center>
											</th>

											<th>
												<center>
													Second name
												</center>
											</th>

											<th>
												<center>
													Email
												</center>
											</th>

											<th>
												<center>
													Address
												</center>
											</th>

											<th>
												<center>
													Phone number
												</center>
											</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sn = 0;
										$query = mysqli_query($dbcon, "SELECT * FROM `golfer` WHERE golfer.clubId = '$clubId'");

										while ($row = mysqli_fetch_array($query)) {
											$sn++;
										?>
											<tr>
												<td><?php echo $row['FirstName'] ?></td>
												<td><?php echo $row['SecondName'] ?></td>
												<td><?php echo $row['Email'] ?></td>
												<td><?php echo $row['Address'] ?></td>
												<td><?php echo $row['Phone'] ?></td>


											</tr>
										<?php }
										?>
									</tbody>
								</table>

							</div>
						</div>


					</div>
				</div>
			</div>

			<center>
				<a href="awards.php" class="btn btn-success">Return Home
					<span class="glyphicon glyphicon-backward" aria-hidden="true"></span>
				</a>
			</center>


		</div>
	</div>
	<div class="col-md-2"></div>
</div>

<?php include('scripts.php') ?>

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