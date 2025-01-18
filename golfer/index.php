<?php
include("sessions.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Tee Times</title>

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Raleway:wght@600;800&display=swap" rel="stylesheet">

    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">


    <style>
        /* Basic styling for FAQ items */
        .faq-container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            font-family: Arial, sans-serif;
        }

        .faq-item {
            margin-bottom: 15px;
        }

        .faq-question {
            background-color: #f1f1f1;
            padding: 10px;
            cursor: pointer;
        }

        .faq-answer {
            display: none;
            padding: 10px;
            border: 1px solid #ddd;
            background-color: #fff;
        }

        .blink {
            animation: blinker 1s linear infinite;
        }

        @keyframes blinker {
            50% {
                opacity: 0;
            }
        }
    </style>

</head>

<body>

    <!-- Libraries Stylesheet -->
    <link href="lib/lightbox/css/lightbox.min.css" rel="stylesheet">
    <link href="lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">


    <!-- Navbar start -->
    <div class="container-fluid fixed-top">
        <div class="container topbar bg-primary d-none d-lg-block">
            <div class="d-flex justify-content-between">
                <div class="top-info ps-2">
                    <small class="me-3"><i class="fas fa-map-marker-alt me-2 text-secondary"></i> <a href="#" class="text-white">Nairobi, Kenya</a></small>
                    <small class="me-3"><i class="fas fa-envelope me-2 text-secondary"></i><a href="#" class="text-white">info@kenyagolfunion.com</a></small>
                </div>
                <div class="top-link pe-2">
                    <a href="#" class="text-white"><small class="text-white mx-2">Privacy Policy</small>/</a>
                    <a href="#" class="text-white"><small class="text-white mx-2">Terms of Use</small>/</a>
                    <a href="#" class="text-white"><small class="text-white ms-2">Sales and Refunds</small></a>
                </div>
            </div>
        </div>

        <div class="container px-0">
            <nav class="navbar navbar-light bg-white navbar-expand-xl">
                <a href="" class="navbar-brand">
                    <h1 class="text-primary display-6">KGU</h1>
                </a>
                <button class="navbar-toggler py-2 px-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
                    <span class="fa fa-bars text-primary"></span>
                </button>
                <div class="collapse navbar-collapse bg-white" id="navbarCollapse">
                    <div class="navbar-nav mx-auto">
                        <a href="" class="nav-item nav-link active">Home</a>
                        <div class="nav-item dropdown">

                            <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">Pages</a>
                            <div class="dropdown-menu m-0 bg-secondary rounded-0">
                                <a href="teetimebooked.php" class="dropdown-item">Payment for tees</a>
                                <a href="history.php" class="dropdown-item">Tee History</a>
                                <a href="tournament.php" class="dropdown-item">Tournaments</a>
                                <a href="feedback.php" class="dropdown-item">Feedback</a>
                                <a href="about.php" class="dropdown-item">About us</a>
                                <a href="contact.php" class="dropdown-item">Contact us</a>

                            </div>
                        </div>
                        <a href="logout.php" class="nav-item nav-link">Logout</a>
                    </div>
                    <div class="d-flex m-3 me-0">
                        
                        <a href="account.php" class="my-auto">
                            <i class="fas fa-user fa-2x"></i>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </div>
    <!-- Navbar End -->



    <!-- start of the tee times -->
    <div class="container-fluid fruite py-1">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>All Available tee times</h1>
                    </div>
                    <div class="col-lg-8 text-end">
                        <ul class="nav nav-pills d-inline-flex text-center mb-5">
                            <li class="nav-item">
                                <a class="d-flex m-2 py-2 bg-light rounded-pill active" data-bs-toggle="pill" href="#tab-1">
                                    <span class="text-dark" style="width: 130px;">All tee times</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <?php
                                    include("dbconnect.php");

                                    $sql = "SELECT teetime.*, available_tees.* 
                                        FROM teetime
                                        JOIN available_tees ON teetime.availableTeeId = available_tees.id
                                        WHERE teetime.TeeStatus = 'approved' 
                                        AND teetime.NumberOfHoles > 0";

                                    $result = mysqli_query($dbcon, $sql);

                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                            $tee_name = $row['tee_name'];
                                            $image_filename = $row['Image'];
                                            $remaining = $row['NumberOfHoles'];
                                            $price = $row['Price'];
                                            $tee_id = $row['teeId']; // Assuming 'teeId' is the correct field name

                                            // Determine the image URL
                                            if ($image_filename) {
                                                $image_url = '../tee/tee/uploads/' . $image_filename;
                                                // Check if the image exists (may not work as intended in this context)
                                                if (!file_exists($image_url)) {
                                                    $image_url = 'kgu.jpeg'; // Default image if not found
                                                }
                                            } else {
                                                $image_url = 'kgu.jpeg'; // Default image URL
                                            }
                                    ?>
                                            <div class="col-md-6 col-lg-4 col-xl-3">
                                                <a href="viewteetime.php?id=<?php echo $tee_id; ?>&golferId=<?php echo $golferId; ?>" class="text-decoration-none">
                                                    <div class="rounded position-relative fruite-item">
                                                        <div class="fruite-img">
                                                            <img src="<?php echo htmlspecialchars($image_url); ?>" class="img-fluid w-100 rounded-top" alt="<?php echo htmlspecialchars($tee_name); ?>">
                                                        </div>
                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"></div>
                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                            <h3 style="text-align: start;"><?php echo htmlspecialchars($tee_name); ?></h3>
                                                            <h5 style="text-align: start;">Holes left: <?php echo htmlspecialchars($remaining); ?></h5>
                                                            <div class="d-flex justify-content-between flex-lg-wrap">
                                                                <p class="text-dark fs-5 fw-bold mb-0">Kshs <?php echo number_format($price, 2); ?> / per hole</p>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "No items found in inventory.";
                                    }

                                    mysqli_close($dbcon);
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- end of tee times -->


    <!-- start of help module -->
    <div class="container-fluid vesitable py-5">
        <div class="col-lg-6 mx-auto">
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Help Module</h3>
                </div>
                <div class="card-body">
                    <div class="faq-container">
                        <div class="faq-item">
                            <div class="faq-question">How do I book for a tee time?</div>
                            <div class="faq-answer">
                                To book for a tee time, please follow these steps...
                                <ol>
                                    <li>Go to the <a href="index.php">Home page</a>, scroll down to view all available tee times, and click on any to book.</li>
                                    <li>Enter the number of holes you want to book, and then click the button to book now to continue.</li>
                                </ol>
                            </div>
                        </div>
                        <div class="faq-item">
                            <div class="faq-question">How do I pay for my tees?</div>
                            <div class="faq-answer">
                                <ol>
                                    <li>On the menu at the top on the banner click the menu under PAGES select <strong>Payment for tees</strong> to view your tee times once the tee manager approves your tee times.</li>
                                    <li>View the total amount and pay using M-Pesa, amount listed as total amount.</li>
                                    <li>After paying using M-Pesa, click on the proceed to pay button and fill in the form using the correct transaction code that you paid the amount with.</li>
                                    <li>Payment will be processed, and you will be able to download the receipt.</li>
                                </ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- end of help module -->


    <!-- comments from the coach -->
    <div class="container-fluid fruite py-1">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-4 text-start">
                        <h1>Coach Comments</h1>
                    </div>
                </div>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <div class="col-lg-12">
                                <div class="row g-4">
                                    <?php
                                    include("dbconnect.php");

                                    // Assuming $golferId is initialized and sanitized.
                                    // Use prepared statements to avoid SQL injection
                                    $stmt = $dbcon->prepare("SELECT comments FROM coach WHERE golferId = ?");
                                    $stmt->bind_param("i", $golferId); // assuming golferId is an integer

                                    if ($stmt->execute()) {
                                        $result = $stmt->get_result();

                                        if ($result->num_rows > 0) {
                                            while ($row = $result->fetch_assoc()) {
                                                $comments =$row['comments']; // Sanitize output
                                    ?>
                                                <div class="col-md-6 col-lg-4 col-xl-3">
                                                    <div class="rounded position-relative fruite-item">
                                                        <div class="text-white bg-secondary px-3 py-1 rounded position-absolute" style="top: 10px; left: 10px;"></div>
                                                        <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                            <h3 style="text-align: start;"><?php echo $comments; ?></h3>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            }
                                        } else {
                                            echo "<div class='col-12'><p>No comments for you.</p></div>";
                                        }
                                    } else {
                                        echo "<div class='col-12'><p>Error fetching comments: " . htmlspecialchars($stmt->error) . "</p></div>";
                                    }

                                    $stmt->close();
                                    $dbcon->close();
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end of coach comments -->


    <!-- start of tutorials -->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            <div class="tab-class text-center">
                <div class="row g-4">
                    <div class="col-lg-12 text-start">
                        <h1>Tutorials</h1>
                    </div>
                </div>

                <div class="tab-content">
                    <div id="tab-1" class="tab-pane fade show p-0 active">
                        <div class="row g-4">
                            <?php
                            include("dbconnect.php");

                            $sql = "SELECT * FROM tutorials";
                            $result = mysqli_query($dbcon, $sql);

                            if (mysqli_num_rows($result) > 0) {
                                $counter = 1; // Initialize counter
                                while ($row = mysqli_fetch_assoc($result)) {
                                    $name = $row['name'];
                                    $description = $row['description'];
                            ?>
                                    <div class="col-md-6 col-lg-4 col-xl-3">
                                        <div class="card h-100">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $counter . ". " . $name; ?></h5> <!-- Display number -->
                                                <p class="card-text"><?php echo $description; ?></p>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                    $counter++; // Increment counter
                                }
                            } else {
                                echo "<div class='col-12'><p>No tutorials found.</p></div>"; // Message if no tutorials
                            }

                            mysqli_close($dbcon);
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- end of tutorials -->


    <!-- start of sport module -->
    <div class="container-fluid vesitable py-5">
        <div class="container py-5">
            <h1 class="mb-0">Sports module</h1>

            <div class="owl-carousel vegetable-carousel justify-content-center">
                <?php
                include("dbconnect.php");

                // SQL Query to fetch matches with associated clubs
                $sql = "SELECT matches.*, clubs1.ClubName AS ClubName1, clubs2.ClubName AS ClubName2 
                FROM matches 
                JOIN clubs AS clubs1 ON matches.clubId1 = clubs1.clubId
                JOIN clubs AS clubs2 ON matches.clubId2 = clubs2.clubId";

                $result = mysqli_query($dbcon, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // Loop through each match
                    while ($row = mysqli_fetch_assoc($result)) {
                        $matchImage = $row['matchImage'] ?: 'kgu.jpeg'; // Use provided match image or default
                        $clubName1 = htmlspecialchars($row['ClubName1']);
                        $clubName2 = htmlspecialchars($row['ClubName2']);
                        $matchStatus = $row['matchStatus'];
                ?>
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <img src="<?php echo htmlspecialchars($matchImage); ?>" class="img-fluid w-100 rounded-top" alt="Match Image">
                            </div>
                            <div class="text-white bg-info px-3 py-1 rounded position-absolute" style="top: 10px; right: 10px;"><?php echo $matchStatus; ?></div>
                            <div class="p-4 rounded-bottom">
                                <h4>Matches Playing</h4>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold mb-0"><?php echo $clubName1; ?></p>
                                    <p class="text-dark fs-5 fw-bold mb-0">vs</p>
                                    <p class="text-dark fs-5 fw-bold mb-0"><?php echo $clubName2; ?></p>
                                    <!-- Blinking indicator -->
                                    <div class="blink-indicator">
                                        <?php if ($matchStatus === 'playing') { ?>
                                            <span class="blink">🟢</span>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                <?php
                    }
                } else {
                    echo "<p>No matches found.</p>"; // Message if no matches
                }

                mysqli_close($dbcon);
                ?>
            </div>
        </div>
    </div>
    <!-- end of sport module -->


    <!-- Back to Top -->
    <a href="#" class="btn btn-info border-3 border-success rounded-circle back-to-top"><i class="fa fa-arrow-up"></i></a>


</body>

<!-- JavaScript Libraries -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="lib/easing/easing.min.js"></script>
<script src="lib/waypoints/waypoints.min.js"></script>
<script src="lib/lightbox/js/lightbox.min.js"></script>
<script src="lib/owlcarousel/owl.carousel.min.js"></script>

<!-- Template Javascript -->
<script src="js/main.js"></script>


<script>
    $(document).ready(function() {
        $('.faq-question').click(function() {
            $(this).next('.faq-answer').slideToggle();
            $('.faq-answer').not($(this).next('.faq-answer')).slideUp();
        });
    });
</script>




</html>