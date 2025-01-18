<?php
include('header.php');
include('dbconnect.php');

// Check if matchId is provided in the URL
if (!isset($_GET['edit'])) {
    header('Location: index.php'); // Redirect if matchId is not provided
    exit();
}

$matchId = $_GET['edit'];

// Fetch match details based on matchId
$query = "SELECT matches.matchId, matches.matchStatus, clubs1.ClubName AS ClubName1, clubs2.ClubName AS ClubName2 
          FROM matches 
          JOIN clubs AS clubs1 ON matches.clubId1 = clubs1.clubId
          JOIN clubs AS clubs2 ON matches.clubId2 = clubs2.clubId
          WHERE matches.matchId = ?";

$stmt = $dbcon->prepare($query);
$stmt->bind_param('i', $matchId);
$stmt->execute();
$result = $stmt->get_result();

// Check if match details are found
if ($result->num_rows == 0) {
    header('Location: index.php'); // Redirect if match details not found
    exit();
}

$row = $result->fetch_assoc();
$clubName1 = $row['ClubName1'];
$clubName2 = $row['ClubName2'];

$stmt->close();

?>

<div class="container-fluid">
    <?php include('menubar.php') ?>
    <div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">Upload Results</h3>
            </div>
            <div class="panel-body">
                

                <form class="form-horizontal" method="post" id="saveResult">
                    <div class="form-group">
                        <label for="club1"><?php echo $clubName1; ?> Points:</label>
                        <input type="number" name="club1" class="form-control" required placeholder="Enter points for <?php echo $clubName1; ?>">
                    </div>
                    <div class="form-group">
                        <label for="club2"><?php echo $clubName2; ?> Points:</label>
                        <input type="number" name="club2" class="form-control" required placeholder="Enter points for <?php echo $clubName2; ?>">
                    </div>
                    <input type="hidden" name="matchId" value="<?php echo $matchId;?>">
                    <button type="submit" class="btn btn-success">Save Results</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-2"></div>
</div>

<?php include('scripts.php'); ?>
<script type="text/javascript">
		$(document).on('submit', '#saveResult', function(event) {
			event.preventDefault();

			// Remove existing error messages
			$(".list-group-item").remove();

			// Serialize form data
			var formData = $(this).serialize();

			// Send AJAX request
			$.ajax({
				url: 'saveresult.php',
				type: 'post',
				data: formData,
				dataType: 'json',

				success: function(response) {
					if (response.error) {
						// Handle validation errors
						var errors = response.errors;

						for (var i = 0; i < errors.length; i++) {
							$('#myinfo').append('<li class="list-group-item alert alert-danger">' + errors[i] + '</li>');
						}
					} else {
						// Handle success
						Swal.fire({
							position: 'top-end',
							icon: 'success',
							title: 'Result uploaded!',
							showConfirmButton: false,
							timer: 3000
						});

						// Clear form inputs or perform other actions
						$('input[name=statement]').val('');

						// Redirect after success
						setTimeout(function() {
							window.location = 'index.php';
						}, 3000);
					}
				},

				error: function(xhr, status, error) {
					console.error('AJAX Error:', error);
					// Handle AJAX errors if necessary
				}
			});
		});
	</script>

</body>
</html>
