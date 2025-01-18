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

					<h3 class="panel-title">Enter Tournament Details</h3>
				</div>

				<div class="panel-body">


					<div class="container-fluid">
						<form class="form-horizontal" action="uploadTournament.php" id="addTournament" method="post" role="form" enctype="multipart/form-data">

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Tournament Name:</label>
										<select name="name" id="tournament" class="form-control">
											<option disabled selected></option>
											<option value="Kenya Amateur Match Play Championship">Kenya Amateur Match Play Championship</option>
											<option value="Kenya Amateur Stroke Play Championship">Kenya Amateur Stroke Play Championship</option>
											<option value="Kenya Ladies Amateur Stroke Play Championship">Kenya Ladies Amateur Stroke Play Championship</option>
											<option value="Barclays Kenya Open">Barclays Kenya Open</option>
											<option value="Karen Country Club Masters">Karen Country Club Masters</option>
											<option value="Sigona Bowl">Sigona Bowl</option>
											<option value="Windsor Classic">Windsor Classic</option>
											<option value="Muthaiga Open">Muthaiga Open</option>
											<option value="Nakuru Open">Nakuru Open</option>
											<option value="VetLab Sports Club Tournament">VetLab Sports Club Tournament</option>
										</select>

									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="">Tournament Venue:</label>
										<input type="text" name="location" class="form-control" id="venue" required="">
									</div>
								</div>

								<div class="col-md-6">
									<div class="form-group">
										<label for="">Start date:</label>
										<input type="date" name="start" class="form-control" id="start" required="">
									</div>
								</div>


								<div class="col-md-6">
									<div class="form-group">
										<label for="">End date:</label>
										<input type="date" name="end" class="form-control" id="end" required="">
									</div>
								</div>

							</div>

					</div>


					<div class="form-row">
						<div class="col-md-6">
							<div class="form-group">
								<label for="">Registration deadline:</label>
								<input type="date" name="deadline" class="form-control" id="deadline" required="">
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="">Description:</label>
								<textarea name="description" class="form-control" id="description"></textarea>
							</div>
						</div>

						<div class="col-md-6">
							<div class="form-group">
								<label for="">Prizes:</label>
								<textarea name="prizes" class="form-control" id="prizes"></textarea>
							</div>
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
<div class="col-md-2"></div>
</div>

<?php include('scripts.php'); ?>
<script type="text/javascript">
	$(document).on('submit', '#addTournament', function(event) {

		event.preventDefault();
		// This removes the error messages from the page
		$(".list-group-item").remove();

		var formData = $(this).serialize();

		$.ajax({
			url: 'uploadTournament.php',
			type: 'post',
			data: formData,
			dataType: 'JSON',

			success: function(response) {

				if (response.error) {

					console.log(response.error);

				} else {

					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Tournament Saved',
						showConfirmButton: false,
						timer: 3000
					});


					setTimeout(function() {
						window.location = 'addTournament.php';
					}, 900);


				}

			}


		});



	});
</script>

</body>

</html>