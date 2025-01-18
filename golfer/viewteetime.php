<?php
// Include the file with database connection details
require_once("../config/dbconnect.php");

// Start the session
session_start();

// Check if there are any errors in the session
if (isset($_SESSION['errors']) && !empty($_SESSION['errors'])) {
    echo "<div class='alert alert-danger' role='alert'>";
    foreach ($_SESSION['errors'] as $error) {
        echo "<p>$error</p>";
    }
    echo "</div>";

    // Clear errors from session
    unset($_SESSION['errors']);
}

include("header.php");
include("menubar.php");
include("style.php");

?>
<div class="container">

    <?php


    // Get the tee time ID from the URL parameter
    $teeId = $_GET['id'];

    // Fetch the tee time details from the database
    $query = "SELECT teetime.*, available_tees.*, clubs.*
    FROM teetime 
    JOIN available_tees ON teetime.availableTeeId = available_tees.id
    JOIN clubs ON teetime.golf_course = clubs.clubId
    WHERE teeId = :teeId";
    $stmt = $conn->prepare($query);
    $stmt->execute(['teeId' => $teeId]);
    $tee_time = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($tee_time) {
        // Display the tee time details
        echo "<div class='tee-time-details'>";
        echo "<img src='../tee/tee/uploads/{$tee_time['Image']}' alt='Tee Time Image'>";
        echo "<h2>{$tee_time['tee_name']}</h2>";
        echo "<p><strong>Price per hole:</strong> Kshs {$tee_time['Price']}</p>";
        echo "<p><strong>Available holes:</strong> {$tee_time['NumberOfHoles']}</p>";
        echo "<p><strong>Golf course:</strong> {$tee_time['ClubName']}</p>";
        echo "<p><strong>Description:</strong> {$tee_time['description']}</p>";

        // Check if golfer is logged in and fetch their golferId
        if (isset($_SESSION['golferId'])) {
            $golferId = $_SESSION['golferId'];
            // Include the golferId in a hidden input field
            echo "<form method='post' id='bookTeeTime' class='form-horizontal'>";
            echo "<input type='number' class='form-control' name='numTees' min='1' required placeholder='Number of holes to book'>";
            echo "<input type='hidden' name='teeId' value='{$tee_time['teeId']}'>";
            echo "<input type='hidden' name='golferId' value='{$golferId}'>";

            echo "<div class='form-group'>";
            echo "<button type='submit' class='btn btn-success form-control' value='Book Now'>";
            echo "Book and continue ";
            echo "<span class='glyphicon glyphicon-arrow-right' aria-hidden='true'></span>";
            echo "</button>";
            echo "</div>";

            echo "<center>";
            echo "<a href='index.php' class='btn btn-primary'>Return Home";
            echo "<span class='glyphicon glyphicon-backward' aria-hidden='true'></span>";
            echo "</a>";
            echo "</center>";


            echo "</form>";
        } else {
            // Golfer is not logged in
            echo "<p>Please <a href='login.php'>login</a> to book this tee time.</p>";
        }

        echo "</div>";
    } else {
        // Tee time not found
        echo "<p>Tee time not found.</p>";
    }

    ?>

</div>

<?php include('scripts.php'); ?>

<script type="text/javascript">
    $(document).on('submit', '#bookTeeTime', function(event) {
        event.preventDefault();
        // This removes the error messages from the page
        $(".list-group-item").remove();

        var formData = $(this).serialize();

        $.ajax({
            url: 'bookingprocess.php',
            type: 'post',
            data: formData,
            dataType: 'json',

            success: function(response) {
                if (response.error) {
                    // Handle validation errors
                    var errors = response.message;
                    Swal.fire({
                        position: 'top-end',
                        icon: 'error',
                        title: errors,
                        showConfirmButton: false,
                        timer: 3000
                    });
                } else {
                    // Handle success
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: 'Tee time booking success!',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    // Redirect after success (optional)
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