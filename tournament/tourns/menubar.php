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
						<h3 class="panel-title"> <a href="addTournament.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Add Tournament</a>

						</h3>
					</div>

				</div>
			</div>


			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="pending.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Pending Tournament</a>

						</h3>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="approved.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Approved Tournament</a>

						</h3>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="booked.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Booked Tournament</a>

						</h3>
					</div>

				</div>
			</div>


			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="play.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Assign Matches</a>

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



			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="all_golf_kits.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								All golf kits</a>

						</h3>
					</div>

				</div>
			</div>


			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="update_golf_kits.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Update all golf kits</a>

						</h3>
					</div>

				</div>
			</div>






		</div>
	</div>
</div>
</div>