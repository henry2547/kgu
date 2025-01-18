
	<div class="col-md-12">
		<div class="panel panel-success">
			<div class="panel-heading" style="padding-bottom: 40px;">
				<center><h3>KENYA GOLF UNION</h3></center>



					
						<?php 
						
						include('session.php');
						include('dbconnect.php');
						
						$query= mysqli_query($dbcon,"select * from userlogin where staffid = '$session_id'")or die(mysqli_error($dbcon));
						$row = mysqli_fetch_array($query);
						
						?>
                            <span class="pull-right">
                               <?php echo $row['surname']." ". $row['othernames']." (" .$row['staffid'].")";  ?> 
                                 
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
								<h3 class="panel-title"> <a href="addGolfer.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								Add Golfer account</a>
								
								</h3>
							</div>
							
						</div>
					</div>

					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="pending.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								Pending account</a>
								
								</h3>
							</div>
							
						</div>
					</div>

					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="approved.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								Approved account</a>
								
								</h3>
							</div>
							
						</div>
					</div>

					

					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="newClub.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								Create new Club</a>
								
								</h3>
							</div>
							
						</div>
					</div>



					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="viewClub.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								View Clubs</a>
								
								</h3>
							</div>
							
						</div>
					</div>


					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="payments_made.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								Supllier Payments made</a>
								
								</h3>
							</div>
							
						</div>
					</div>
					

					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="feedback_history.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								Feedback history</a>
								
								</h3>
							</div>
							
						</div>
					</div>
					

					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="tee_payments.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								Tee time payments</a>
								
								</h3>
							</div>
							
						</div>
					</div>


					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="view_tournaments.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								View tournaments</a>
								
								</h3>
							</div>
							
						</div>
					</div>

					<div class="col-md-3">
						<div class="panel panel-info">
							<div class="panel-heading">
								<h3 class="panel-title"> <a href="view_winners.php">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  
								View tournament winners</a>
								
								</h3>
							</div>
							
						</div>
					</div>

					
					
				</div>
			</div>
		</div>
	</div>