<?php

include('header.php');
include('dbconnect.php');

?>


<div class="container-fluid">


	<?php include('menubar.php') ?>
	<?php // include('menubar1.php');

	//$trans_id= uniqid();


	$kitId = $_GET['edit'];


	?>



	<div class="container-fluid">

		<div class="col-md-2"></div>
		<div class="col-md-8">
			<ul class="list-group" id="myinfo">

				<li class="list-group-item" id="mylist"></li>

			</ul>
			<div class="panel panel-success">
				<div class="panel-heading">

					<h3 class="panel-title">Golf kit details</h3>
				</div>
				<div class="panel-body">

					<div class="container-fluid">
						<form class="form-horizontal" method="post" role="form" id="requestKit">


							<div class="form-row">
								<?php
								$query = mysqli_query($dbcon, "SELECT * FROM golf_tools WHERE kitId = '$kitId'");

								while ($row = mysqli_fetch_array($query)) {
								?>
									<table class="table">
										<tr>
											<td width="160px">ID:</td>
											<td> <input type="text" value="<?php echo $kitId ?>" readonly="" name="kitId"> </td>
										</tr>
										<tr>
											<td>Golf kit:</td>
											<td><?php echo $row['tool_name'] ?></td>
										</tr>
										<tr>
											<td>Quantity:</td>
											<td><?php echo $row['kit_quantity'] ?></td>
										</tr>
										<tr>
											<td>Upload date:</td>
											<td><?php echo $row['date'] ?></td>
										</tr>

										


									<?php
								}



								
									?>

									</table>

							</div>

							<div class="form-row">
								
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Enter quantity to request:</label>
                                        <input type="number" name="quantity" class="form-control" id="">
										
									</div>
								</div>

							</div>

							<div class="form-group">
								<button type="submit" name="savecidstatement" class="btn btn-success form-control">Save and continue
									<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-2"></div>
	</div>

	<?php include('scripts.php'); ?>

	<script type="text/javascript">
		$(document).on('submit', '#requestKit', function(event) {
			event.preventDefault();
			// This removes the error messages from the page
			$(".list-group-item").remove();

			var formData = $(this).serialize();

			$.ajax({
				url: 'request_kit_send.php',
				type: 'post',
				data: formData,
				dataType: 'JSON',

				success: function(response) {

					if (response.error) {

						Swal.fire({
							position: 'top-end',
							icon: 'error',
							title: 'Error occurred!',
							showConfirmButton: false,
							timer: 3000
						});

					} else {

						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Request sent!',
							showConfirmButton: false,
							timer: 3000
						});

						$('input[name=statement]').val('');
						setTimeout(function() {
							window.location = 'all_golf_kits.php';
						}, 2000);


					}

				}


			});



		});
	</script>

	</body>

	</html>