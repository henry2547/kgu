<?php
// Include the file with database connection details
// Start the session
session_start();
// Check if session variables are set
if (
    isset($_SESSION['FirstName']) && isset($_SESSION['SecondName'])
    && isset($_SESSION['golferId']) && isset($_SESSION['clubId'])
) {

    // Assign session variables to local variables
    $fname = $_SESSION['FirstName'];
    $sname = $_SESSION['SecondName'];
    $golferId = $_SESSION['golferId'];
    $clubId = $_SESSION['clubId'];
} else {
    // Redirect to login page if session variables are not set
    header("Location: login.php");
    exit(); // Stop further execution
}
require_once("dbconnect.php");

include("header.php");
include("menubar.php");
?>
<body>
    


<div class="container">
    <?php
    // Get the tournament ID from the URL parameter
    $tournamentId = $_GET['id'];

    // Fetch the tournament details from the database
    $query = "SELECT * FROM tournament WHERE tournmentId = :tournamentId";
    $stmt = $conn->prepare($query);
    $stmt->execute(['tournamentId' => $tournamentId]);
    $tournament = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tournament) {
        // Display the tournament details inside a card
        echo "<div class='card'>";
        echo "<h2>{$tournament['TournamentName']}</h2>";
        echo "<p><b>Venue:</b> {$tournament['TournamentVenue']}</p>";
        echo "<p><b>Start date:</b> <b>{$tournament['StartDate']}</b></p>";
        echo "<p><b>End date:</b> {$tournament['EndDate']}</p>";
        echo "<p><b>Registration deadline:</b> {$tournament['registrationDeadline']}</p>";
        echo "<p><b>Description:</b> {$tournament['Description']}</p>";
        echo "<p><b>Prizes:</br> {$tournament['Prizes']}</p>";


        // Check if golfer is logged in and fetch their golferId and clubId
        if (isset($_SESSION['golferId']) && isset($_SESSION['clubId'])) {

            $golferId = $_SESSION['golferId'];
            $clubId = $_SESSION['clubId'];

            // Include the golferId in a hidden input field
            echo "<form action='bookingtournament.php' id='bookTourn' method='post'>";
            echo "<input type='hidden' name='tournamentId' value='{$tournament['tournmentId']}'>";
            echo "<input type='hidden' name='golferId' value='{$golferId}'>";
            echo "<input type='hidden' name='clubId' value='{$clubId}'>";
            echo "<input type='submit' class='btn btn-success' value='Book Now' style='display: block; margin: 0 auto 20px;'>";


            echo "</form>";


            echo "<center>";

            echo "</center>";
        } else {
            // Golfer is not logged in
            echo "<p>Please <a href='login.php'>login</a> to book this tournament.</p>";
        }

        echo "</div>";
    } else {
        // Tournament not found
        echo "<div class='alert error' role='alert'>Tournament not found.</div>";
    }
    ?>

</div>

<?php include('scripts.php'); ?>

<script type="text/javascript">
    $(document).on('submit', '#bookTourn', function(event) {
        event.preventDefault();
        // This removes the error messages from the page
        $(".list-group-item").remove();

        var formData = $(this).serialize();

        $.ajax({
            url: 'bookingtournament.php',
            type: 'post',
            data: formData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tournament booked',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    setTimeout(function() {
                        window.location = 'index.php';
                    }, 900);
                } else {
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: 'Booking Error',
                        text: response.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    position: 'top-end',
                    icon: 'error',
                    title: 'AJAX Error',
                    text: 'Failed to process booking. Please try again.'
                });
            }
        });
    });
</script>