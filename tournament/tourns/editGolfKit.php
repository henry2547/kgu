<?php

include('header.php');
include('dbconnect.php');

?>


<div class="container-fluid">


	<?php include('menubar.php') ?>
	<?php // include('menubar1.php');

	//$trans_id= uniqid();


	$kitId = $_GET['edit'];
    $requestId = $_GET['requestId'];


	?>



	<div class="container-fluid">

		<div class="col-md-2"></div>
		<div class="col-md-8">
			<ul class="list-group" id="myinfo">

				<li class="list-group-item" id="mylist"></li>

			</ul>
			<div class="panel panel-success">
				<div class="panel-heading">

					<h3 class="panel-title">User Details</h3>
				</div>
				<div class="panel-body">

					<div class="container-fluid">
						<form class="form-horizontal" method="post" role="form" id="updateKit">


							<div class="form-row">
								<?php
								$query = mysqli_query($dbcon, "SELECT golf_tools.*, requested_kit.*, saveSupply.* 
                                FROM golf_tools
                                JOIN requested_kit ON requested_kit.kitId = golf_tools.kitId
                                JOIN saveSupply ON saveSupply.requestId = requested_kit.requestId
                                WHERE  requested_kit.isUpdated = 0
                                AND golf_tools.kitId = '$kitId'
                                ");

								while ($row = mysqli_fetch_array($query)) {
								?>
									<table class="table">
										<tr>
											<td width="160px">ID:</td>
											<td> <input type="text" value="<?php echo $kitId ?>" readonly="" name="kitId"> </td>
										</tr>

                                        <tr>
											<td width="160px">Request ID:</td>
											<td> <input type="text" value="<?php echo $requestId ?>" readonly="" name="requestId"> </td>
										</tr>

										<tr>
											<td>Golf kit:</td>
											<td><?php echo $row['tool_name'] ?></td>
										</tr>
										
										<tr>
											<td>Upload date:</td>
											<td><?php echo $row['date'] ?></td>
										</tr>

                                        <tr>
											<td>Quantity requested:</td>
											<td>
                                                <input type="number" name="quantity" readonly value="<?php echo $row['quantity'] ?>" id="">
                                            </td>
										</tr>

										

										


									<?php
								}



								
									?>

									</table>

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
		$(document).on('submit', '#updateKit', function(event) {
			event.preventDefault();
			// This removes the error messages from the page
			$(".list-group-item").remove();

			var formData = $(this).serialize();

			$.ajax({
				url: 'updateKit.php',
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
							title: 'Golf kit update!',
							showConfirmButton: false,
							timer: 3000
						});

						$('input[name=statement]').val('');
						setTimeout(function() {
							window.location = 'index.php';
						}, 2000);


					}

				}


			});



		});
	</script>

	</body>

	</html>