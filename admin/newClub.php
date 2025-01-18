<?php

include('header.php');
include('dbconnect2.php');

?>


<div class="container-fluid">


	<?php include('menubar.php') ?>
	<?php // include('menubar1.php');


	?>
	<div class="container-fluid">

		<div class="col-md-2"></div>
		<div class="col-md-8">
			<ul class="list-group" id="myinfo">

				<li class="list-group-item" id="mylist"></li>

			</ul>
			<div class="panel panel-success">
				<div class="panel-heading">

					<h3 class="panel-title">Enter Club Details</h3>
				</div>

				<div class="panel-body">
					<div class="container-fluid">
						<form class="form-horizontal" method="post" role="form" id="saveClub">

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="name">Club name:</label>
										<select name="cname" class="form-control" id="">
											
											<option disabled selected>--Select club--</option>
											<option value="Karen Country Club">Karen Country Club</option>
											<option value="Muthaiga Golf Club">Muthaiga Golf Club</option>
											<option value="Royal Nairobi Golf Club">Royal Nairobi Golf Club</option>
											<option value="Sigona Golf Club">Sigona Golf Club</option>
											<option value="Limuru Country Club">Limuru Country Club</option>
											<option value="Nyeri Golf Club">Nyeri Golf Club</option>
											<option value="Nanyuki Sports Club">Nanyuki Sports Club</option>
											<option value="Ruiru Sports Club">Ruiru Sports Club</option>
											<option value="Eldoret Club">Eldoret Club</option>
											<option value="Machakos Golf Club">Machakos Golf Club</option>
											<option value="Kiambu Golf Club">Kiambu Golf Club</option>
											<option value="Kakamega Golf CLub">Kakamega Golf CLub</option>
											<option value="Nyahururu Golf Club">Nyahururu Golf Club</option>
											<option value="Kitale Golf Club">Kitale Golf Club</option>
											<option value="Kisumu Yacht Club">Kisumu Yacht Club</option>
											<option value="Thika Sports Club">Thika Sports Club</option>
											<option value="Vet Lab Sports Club">Vet Lab Sports Club</option>
											<option value="Mt. Kenya Safari Club">Mt. Kenya Safari Club</option>
											<option value="Nyanza Club">Nyanza Club</option>
											<option value="Malindi Golf & Country Club">Malindi Golf & Country Club</option>
											<option value="Vipingo Ridge Golf Club">Vipingo Ridge Golf Club</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="region">Region:</label>
										<script type="text/javascript" src="js/regions.js"></script>
										<select class="form-control" required onchange="print_state('state', this.selectedIndex);" id="country" name="region"></select>
									</div>
								</div>
							</div>
							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="state">District/Municipal:</label>
										<select required class="form-control" name="district" id="state"></select>
										<script language="javascript">
											print_country("country");
										</script>
									</div>
								</div>
							</div>

							<div class="form-group">
								<button type="submit" class="btn btn-success form-control">Save and Continue
									<span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
								</button>
							</div>
						</form>
					</div>
				</div>

			</div>
		</div>
	</div>
	<div class="col-md-2"></div>
</div>

<?php include('scripts.php'); ?>



<script type="text/javascript">
	$(document).on('submit', '#saveClub', function(event) {
		event.preventDefault();
		$(".list-group-item").remove();

		var formData = $(this).serialize();

		$.ajax({
			url: 'saveclub.php',
			type: 'post',
			data: formData,
			dataType: 'json',
			success: function(response) {
				if (response.error) {
					Swal.fire({
						position: 'top-end',
						icon: 'error',
						title: 'Error',
						text: response.message
					});
				} else {
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Club Saved',
						showConfirmButton: false,
						timer: 3000
					});
					setTimeout(function() {
						window.location = 'newClub.php';
					}, 300);
				}
			},
			error: function(jqXHR, textStatus, errorThrown) {
				console.log(jqXHR.responseText); // Log the detailed error message for debugging
				Swal.fire({
					position: 'top-end',
					icon: 'error',
					title: 'AJAX Error',
					text: 'Failed to save club. Please try again.'
				});
			}
		});
	});
</script>



</body>

</html>