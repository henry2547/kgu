<div class="col-md-12">
	<div class="panel panel-success">
		<div class="panel-heading" style="padding-bottom: 40px;">
			<center>
				<h3>KENYA GOLF UNION</h3>
			</center>




			<?php

			include('session.php');
			include('dbconnect.php');

			$query = mysqli_query($dbcon, "select * from userlogin where staffid = '$session_id'") or die(mysqli_error());
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
						<h3 class="panel-title"> <a href="pending.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Pending Payments</a>

						</h3>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="approved.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Approved Payments</a>

						</h3>
					</div>

				</div>
			</div>

			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="rejected.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Rejected Payment</a>

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
						<h3 class="panel-title"> <a href="supplier_payment.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Supplier Payment</a>

						</h3>
					</div>

				</div>
			</div>





			<div class="col-md-3">
				<div class="panel panel-info">
					<div class="panel-heading">
						<h3 class="panel-title"> <a href="payments_made.php">
								<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>

								Payments made</a>

						</h3>
					</div>

				</div>
			</div>




		</div>
	</div>
</div>
</div>