<?php
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
    header("Location: ../login.php");
    exit(); // Stop further execution
}
require("dbconnect.php");

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
    <title>Dashboard</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../assets/css/bootstrap-theme.min.css">

    <!-- Custom CSS -->
    <link href="../../assets/css/simple-sidebar.css" rel="stylesheet">
    <link href="../../assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

    <style>
        .blink-indicator {
            animation: blink-animation 1s infinite;
            /* Apply the blink animation */
        }

        @keyframes blink-animation {
            0% {
                opacity: 1.0;
            }

            50% {
                opacity: 0.1;
            }

            100% {
                opacity: 1.0;
            }
        }

        .playing-status {
            font-weight: bold;
            color: blue;
            /* Example color for playing status */
        }

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

    <div class="container-fluid">

        <div class="col-md-1"></div>
        <div class="col-md-8">

            <div class="panel panel-success">

                <!-- start of all matches -->
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Matches to play
                    </h3>
                </div>
                <div id="trans-table">
                    <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>
                                    Club name
                                </th>
                                <th>Vs</th>
                                <th>
                                    Club name
                                </th>

                                <th>
                                    Match Status
                                </th>
                                <th>
                                    Indicator
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // The serial number variable
                            $sn = 0;
                            $query = mysqli_query($dbcon, "SELECT matches.*, clubs1.ClubName AS ClubName1, clubs2.ClubName AS ClubName2 
							FROM matches 
							JOIN clubs AS clubs1 ON matches.clubId1 = clubs1.clubId
							JOIN clubs AS clubs2 ON matches.clubId2 = clubs2.clubId");

                            while ($row = mysqli_fetch_array($query)) {
                                $id = $row['matchId'];
                                $sn++;
                            ?>
                                <tr>

                                    <td><?php echo $sn; ?></td>


                                    <td><?php echo $row['ClubName1']; ?></td>
                                    <th>vs</th>
                                    <td><?php echo $row['ClubName2']; ?></td>
                                    <td><?php echo $row['matchStatus']; ?></td>

                                    <td>
                                        <?php
                                        $matchStatus = $row['matchStatus'];

                                        if ($matchStatus == 'playing') {
                                            // Display a blinking indicator and apply appropriate styles
                                            echo '<span class="blink-indicator playing-status">🟢</span>';
                                        } elseif ($matchStatus == 'ended') {
                                            echo 'Ended';
                                        } elseif ($matchStatus == 'pending') {
                                            echo 'Pending';
                                        } elseif ($matchStatus == 'cancelled') {
                                            echo 'Cancelled';
                                        } elseif ($matchStatus == 'postponed') {
                                            echo 'Postponed';
                                        } else {
                                            echo 'Match status unknown';
                                        }
                                        ?>
                                    </td>



                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of all matches -->


                <!-- start of showing results -->
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Showing results
                    </h3>
                </div>
                <div id="trans-table">
                    <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>
                                    Club name
                                </th>
                                <th>Points</th>
                                <th>Vs</th>
                                <th>
                                    Club name
                                </th>

                                <th>
                                    Points
                                </th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // The serial number variable
                            $sn = 0;
                            $query = mysqli_query($dbcon, "SELECT
                                m.matchId,
                                c1.clubName AS ClubName1,
                                r.clubId1 AS Points1,
                                c2.clubName AS ClubName2,
                                r.clubId2 AS Points2
                            FROM
                                results r
                            JOIN
                                matches m ON r.matchId = m.matchId
                            JOIN
                                clubs c1 ON m.clubId1 = c1.clubId
                            JOIN
                                clubs c2 ON m.clubId2 = c2.clubId
                            WHERE m.matchStatus = 'ended'
                            ORDER BY
                                GREATEST(r.clubId1, r.clubId2) DESC
                            LIMIT 3;");

                            while ($row = mysqli_fetch_array($query)) {
                                $sn++;
                            ?>
                                <tr>

                                    <td><?php echo $sn; ?></td>


                                    <td><?php echo $row['ClubName1']; ?></td>
                                    <td><?php echo $row['Points1']; ?></td>
                                    <td>vs</td>
                                    <td><?php echo $row['ClubName2']; ?></td>
                                    <td><?php echo $row['Points2']; ?></td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- end of showing results -->



                <!-- start of showing all ended matches -->
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Tournament winners
                    </h3>
                </div>
                <div id="trans-table">
                    <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0">
                        <thead>
                            <tr>
                                <th>S/N</th>
                                <th>
                                    Club name
                                </th>
                                <th>Points</th>

                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // The serial number variable
                            $sn = 0;
                            $query = mysqli_query($dbcon, "SELECT
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
                                clubs c1 ON m.clubId1 = c1.clubId
                            JOIN
                                clubs c2 ON m.clubId2 = c2.clubId
                            WHERE m.matchStatus = 'ended'
                            ORDER BY
                                points DESC
                            LIMIT 3;
                            ");

                            while ($row = mysqli_fetch_array($query)) {
                                $sn++;
                            ?>
                                <tr>

                                    <td><?php echo $sn; ?></td>


                                    <td><?php echo $row['ClubName']; ?></td>
                                    <td><?php echo $row['points']; ?></td>


                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <!-- ens of showing all the matches -->

            </div>
            <div class="col-md-1"></div>
        </div>


        <?php include('scripts.php'); ?>

</body>

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

</html>