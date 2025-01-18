<?php
// Start the session
session_start();
include("dbconnect.php");

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

$select_club_name = "SELECT ClubName FROM clubs WHERE clubId = '$clubId'";
$result_select = mysqli_query($dbcon, $select_club_name);

if ($result_select) {
    // Check if the query returned any rows
    if (mysqli_num_rows($result_select) > 0) {
        // Fetch the clubName
        $row = mysqli_fetch_assoc($result_select);
        $clubName = $row['ClubName'];


        // Or assign it to another variable, pass to a function, etc.
    } else {
        echo "No club found for clubId: " . $clubId;
    }
} else {
    echo "Error executing query: " . mysqli_error($dbcon);
}

// Don't forget to free the result set
mysqli_free_result($result_select);


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournaments</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap-theme.min.css">

    <!-- Custom CSS -->
    <link href="../../assets/css/simple-sidebar.css" rel="stylesheet">
    <link href="../../assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <style>
        /* Base card styles */
        .card {
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            /* Add box shadow for elevation effect */
            margin: 10px;
            width: calc(50% - 20px);
            /* Set card width to 50% of the viewport width minus margin */
            display: inline-block;
            text-align: start;
            box-sizing: border-box;
            /* Include padding and border in the width calculation */
            background-color: whitesmoke;
        }


        .card h4,
        p {
            margin-left: 10px;
        }

        h3 {
            text-align: center;
            color: #000;
        }

        /* Media query for screens smaller than 768px (phones) */
        @media (max-width: 768px) {
            .card {
                width: calc(100% - 20px);
                /* Set card width to 100% of the viewport width minus margin */
            }


        }

        .banner {
            background-color: #007bff;
            color: #fff;
            padding: 10px;
            text-align: center;
            font-size: 24px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        /* Hamburger menu styles */
        .hamburger {
            position: fixed;
            top: 10px;
            left: 10px;
            cursor: pointer;
            z-index: 1000;
            /* Ensure hamburger icon stays on top */
        }

        .menu {
            position: fixed;
            top: 0;
            left: 0;
            width: 300px;
            height: 100%;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transform: translateX(-100%);
            transition: transform 0.3s ease;
            z-index: 999;
            /* Ensure menu stays on top */
        }

        .menu.open {
            transform: translateX(0);
        }

        .menu ul {
            list-style: none;
            padding: 0;
            margin: 50px 0 0 20px;
        }

        .menu ul li {
            margin-bottom: 20px;
        }

        .menu ul li a {
            text-decoration: none;
            color: #000;
            font-size: 18px;
            transition: color 0.3s ease;
        }

        .menu ul li a:hover {
            color: #007bff;
        }

        .card img {
            max-width: 100%;
            height: 100px;
            width: auto;
            object-fit: cover;
        }
    </style>

</head>

<body>
    <div class="banner">
        <?php echo $clubName ?>!
    </div>


    <!-- Hamburger menu -->
    <div class="hamburger" onclick="toggleMenu()">
        &#9776;
    </div>
    <div class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>

            <li><a href="matches.php">Matches</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <h3>Available Tournaments</h3>

    <?php
    // Include the file with database connection details
    require_once("dbconnect.php");

    // Assuming you have already executed the SQL query and fetched the data into $result
    $query = "SELECT * FROM `tournament` WHERE tournament.TournamentStatus = 'approved'";
    $result = $dbcon->query($query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='card' onclick=\"window.location.href='viewtournament.php?id={$row['tournmentId']}&golferId={$golferId}&clubId={$clubId}';\">";

        echo "<h4>{$row['TournamentName']}</h4>";
        echo "<p>Venue: {$row['TournamentVenue']}</p>";
        echo "<p>Start date:{$row['StartDate']}</p>";
        echo "<p>End date: {$row['EndDate']}</p>";
        echo "</div>";
    }

    ?>


    <?php

    // Initialize variable to track claimed status
    $awardClaimed = false;

    // First query to get the top 3 clubs based on points
    $sql_top_clubs = "SELECT
                    r.resultId,
                    a.*,
                    m.matchId,
                    CASE
                        WHEN r.clubId1 > r.clubId2 THEN c1.clubName
                        ELSE c2.clubName
                    END AS ClubName,
                    GREATEST(r.clubId1, r.clubId2) AS points
                FROM
                    results r
                JOIN
                    matches m ON r.matchId = m.matchId
                JOIN 
                    awards a ON r.resultId = a.resultId
                JOIN
                    clubs c1 ON m.clubId1 = c1.clubId
                JOIN
                    clubs c2 ON m.clubId2 = c2.clubId
                WHERE
                    m.matchStatus = 'ended'
                ORDER BY
                    points DESC
                LIMIT 3;";

    $result_top_clubs = mysqli_query($dbcon, $sql_top_clubs);

    if ($result_top_clubs) {
        // Check if the query returned any rows
        if (mysqli_num_rows($result_top_clubs) > 0) {
            // Array to store club names and corresponding IDs
            $clubNames = [];

            // Fetch each row to get ClubName
            while ($row = mysqli_fetch_assoc($result_top_clubs)) {
                $clubName = $row['ClubName'];
                $awardId = $row['awardId'];
                $points = $row['points'];
                $status = $row['claim_award'];

                // Store club names in array for later reference
                $clubNames[] = $clubName;

                // Update $awardClaimed based on status
                if ($status == 'claimed') {
                    $awardClaimed = true;
                }
            }

            // Display UI based on claimed status
            if ($awardClaimed) {
                echo "<h3 style='text-align: center;'>AWARD ALREADY CLAIMED</h3>";
                // Additional logic to disable menu or overlay
                // Example: disable menu using JavaScript
                //echo "<script>document.getElementById('menu').classList.add('disabled');</script>";
            } else {
                // Continue with the rest of your logic
                // Prepare an IN clause for ClubNames
                $clubNamesList = "'" . implode("', '", $clubNames) . "'";

                // Second query to find clubId based on ClubName
                $sql_club_ids = "SELECT clubId, clubName FROM clubs WHERE clubName IN ($clubNamesList)";
                $result_club_ids = mysqli_query($dbcon, $sql_club_ids);

                if ($result_club_ids) {
                    // Array to store clubId and clubName pairs
                    $clubIdNamePairs = [];

                    // Fetch each row to get clubId and clubName pairs
                    while ($row = mysqli_fetch_assoc($result_club_ids)) {
                        $clubIdQuery = $row['clubId'];
                        $clubName = $row['clubName'];
                        $clubIdNamePairs[$clubName] = $clubIdQuery;
                    }

                    if ($clubIdQuery != $clubId) {
                        echo "<p style='text-align: center;'>Your club, <b>$clubName</b>, has not won the match. Try again harder next time.</p>";
                    } else {
                        // Now $clubIdNamePairs array contains ClubName => ClubId mapping
                        // You can use $clubIdNamePairs array to associate ClubName with ClubId
                        foreach ($clubNames as $clubName) {

                            if (isset($clubIdNamePairs[$clubName])) {
                                $clubIdQuery = $clubIdNamePairs[$clubName];
                                //echo "Club Name: $clubName, Club ID: $clubIdQuery <br />";
                                // Here you can perform further processing as needed

                                // Example UI rendering for claiming award
                                echo "<div class='card'>";
                                echo "<h3 style='margin-top: 20px'>Claim award</h3>";
                                echo "<p style='margin-top: 20px'>Club Name: $clubName</p>";
                                echo "<p>Points scored: $points</p>";
                                echo "<form id='claimAward' method='POST'>";
                                echo "<input type='hidden' name='awardId' value='$awardId'>";
                                echo "<div style='text-align: center; margin-bottom: 10px;'>";
                                echo "<button type='submit' class='btn btn-success'>Claim Award</button>";
                                echo "</div>"; // End of centered div
                                echo "</form>";
                                echo "</div>"; // End of card div
                            }
                        }
                    }
                } else {
                    echo "Error executing second query: " . mysqli_error($dbcon);
                }
            }

            // Free result set
            mysqli_free_result($result_club_ids);
        } else {
            echo "<p style='text-align: center;'>Your club, <b>$clubName</b>, has not been assigned to a match yet.</p>";
        }

        // Free result set
        mysqli_free_result($result_top_clubs);
    } else {
        echo "Error executing first query: " . mysqli_error($dbcon);
    }
    ?>



</body>
<!-- menu open and close -->
<script>
    function toggleMenu() {
        document.querySelector('.menu').classList.toggle('open');
    }

    // JavaScript to toggle button visibility based on scroll direction
    let lastScrollTop = 0;
    let isScrollingUp = false;

    window.addEventListener('scroll', function() {
        let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

        if (currentScroll > lastScrollTop) {
            // Scrolling down
            isScrollingUp = false;
        } else {
            // Scrolling up
            isScrollingUp = true;
        }

        lastScrollTop = currentScroll;

        // Show or hide the logout button based on scroll direction
        if (isScrollingUp) {
            document.querySelector('.logout-btn').style.opacity = '1';
        } else {
            document.querySelector('.logout-btn').style.opacity = '0';
        }
    });
</script>

<?php include('scripts.php'); ?>
<!-- sweet alert -->
<script type="text/javascript">
    $(document).on('submit', '#claimAward', function(event) {

        event.preventDefault();
        // This removes the error messages from the page
        $(".list-group-item").remove();

        var formData = $(this).serialize();

        $.ajax({
            url: 'claim_award.php',
            type: 'post',
            data: formData,
            dataType: 'JSON',

            success: function(response) {

                if (response.error) {

                    console.log(response.error);

                } else {

                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: 'Award claimed',
                        showConfirmButton: false,
                        timer: 3000
                    });


                    setTimeout(function() {
                        window.location = 'index.php';
                    }, 900);


                }

            }


        });



    });
</script>



</html>