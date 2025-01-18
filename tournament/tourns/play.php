<?php
// Include the file with database connection details
require_once("dbconnect.php");


// SQL query to fetch club names from clubs table
$query = "SELECT clubs.ClubName, booktournament.* 
            FROM clubs
            JOIN booktournament ON clubs.clubId = booktournament.clubId
            GROUP BY booktournament.clubId";

try {
    // Prepare and execute the SQL query
    $stmt = $conn->prepare($query);
    $stmt->execute();

    // Fetch all club data as an associative array
    $clubsData = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    // Handle database errors
    $errorMsg = 'Error fetching clubs: ' . $e->getMessage();
}

include("header.php");
include("menubar.php");
?>



<div class="container-fluid">

    <div class="col-md-2"></div>
    <div class="col-md-8">
        <ul class="list-group" id="myinfo">

            <li class="list-group-item" id="mylist"></li>

        </ul>

        <div class="panel panel-success">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Assign clubs to play
                </h3>
            </div>

            <div class="panel-body">
                <div class="container-fluid">
                    <form action="assignmatch.php" method="post" id="assignMatches">
                        <div class="form-row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="club1">Select Club 1:</label>
                                    <select name="club1" id="club1" class="form-control">
                                        <option disabled selected></option>
                                        <?php
                                        // Loop through club data and populate select options
                                        foreach ($clubsData as $club) {
                                            echo "<option value='{$club['clubId']}'>{$club['ClubName']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="club2">Select Club 2:</label>
                                    <select name="club2" id="club2" class="form-control">
                                        <option disabled selected></option>
                                        <?php
                                        // Loop through club data and populate select options
                                        foreach ($clubsData as $club) {
                                            echo "<option value='{$club['clubId']}'>{$club['ClubName']}</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <input type="submit" class="btn btn-success" value="Assign Clubs">
                    </form>
                </div>

            </div>

        </div>

    </div>
</div>

</div>


<?php include('scripts.php'); ?>


<script type="text/javascript">
    $(document).on('submit', '#assignMatches', function(event) {
        event.preventDefault();
        $(".list-group-item").remove();

        var formData = $(this).serialize();

        $.ajax({
            url: 'assignmatch.php',
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
                        title: 'Matches Saved',
                        showConfirmButton: false,
                        timer: 3000
                    });
                    setTimeout(function() {
                        window.location = 'play.php';
                    }, 3000);
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