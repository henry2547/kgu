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

					<h3 class="panel-title">Enter Login Details</h3>
				</div>
				<div class="panel-body">





					<div class="container-fluid">
						<form class="form-horizontal" method="post" role="form" id="addTutor">

							<div class="form-row">
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Tutorial name:</label>
										<select name="name" class="form-control" id="">
											<option selected disabled>--Select tutor name</option>
											<option value="How to Score">How to Score!</option>
											<option value="Golf Game Basics">Golf basics</option>
											<option value="Beginner games">Beginner Games</option>
											<option value="Expert games">Expert games</option>
										</select>
									</div>
								</div>
								<div class="col-md-6">
									<div class="form-group">
										<label for="">Description:</label>
										<textarea class="ckeditor" name="statement" id="ckeditor" rows="60" cols="100">

										</textarea>
										<script>
											// Replace the <textarea id="editor1"> with a CKEditor 4
											// instance, using default configuration.
											CKEDITOR.replace('editor1');
										</script>
									</div>
								</div>
							</div>




					</div>
					<div class="form-group">
						<button type="submit" name="save_case" class="btn btn-success form-control">Save and Continue
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
<script type="text/javascript" src="ckeditor/ckeditor.js"></script>

<script type="text/javascript">
	$(document).on('submit', '#addTutor', function(event) {
		event.preventDefault();

		// Remove existing error messages
		$(".list-group-item").remove();

		var formData = $(this).serialize();

		$.ajax({
			url: 'saveTutorial.php',
			type: 'post',
			data: formData,
			dataType: 'json',

			success: function(response) {
				if (response.error) {
					// Display validation errors
					var errors = response[0];
					var len = errors.length;
					for (var i = 0; i < len; i++) {
						$('#myinfo').append('<li class="list-group-item alert alert-danger">' + errors[i] + '</li>');
					}
				} else {
					// Payment saved successfully
					Swal.fire({
						position: 'top-end',
						icon: 'success',
						title: 'Tutorial Saved!',
						showConfirmButton: false,
						timer: 3000
					});

					// Clear form input after success
					$('input[name=statement]').val('');

					// Redirect to index.php after a delay
					setTimeout(function() {
						window.location.href = 'new_tutorial.php';
					}, 3000);
				}
			},
			error: function(xhr, status, error) {
				// Handle AJAX errors if any
				console.error('AJAX Error:', status, error);
				Swal.fire({
					position: 'top-end',
					icon: 'error',
					title: 'Oops...',
					text: 'Something went wrong! Please try again later.',
				});
			}
		});
	});
</script>

</body>

</html>