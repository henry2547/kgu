<div class="col-md-12">
	<div class="panel panel-success">
		<div class="panel-heading" style="padding-bottom: 40px;">
			<center>
				<h3>KENYA GOLF UNION</h3>
			</center>




			<?php

			include('session.php');
			include('dbconnect.php');

			$query = mysqli_query($dbcon, "SELECT * FROM userlogin WHERE staffid = '$session_id'") or die(mysqli_error());
			$row = mysqli_fetch_array($query);

			?>
			<span class="pull-right">
				<?php echo $row['surname'] . " " . $row['othernames'] . " (" . $row['staffid'] . ")";  ?>

				<a href="profile.php"><i class="icon-signout icon-large"></i>&nbsp;Edit</a>
				<a href="logout.php"><i class="icon-signout icon-large"></i>&nbsp;Logout</a>
			</span>

		</div>




	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="index.php">
								<span class="glyphicon glyphicon-home" aria-hidden="true"></span> Home</a>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="addTeeTime.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Add Tee Time</a>

						</h3>
					</div>

				</div>
			</div>


			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="pending.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Pending Tee Time</a>

						</h3>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="approved.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Approved Tee Time</a>

						</h3>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="pendingbooked.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Pending Booked Tee Time</a>

						</h3>
					</div>

				</div>
			</div>


			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="approvedbooked.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Approved Booked Tee Time</a>

						</h3>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="direct_message.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Direct Messages</a>

						</h3>
					</div>

				</div>
			</div>





		</div>
	</div>
</div>
</div>