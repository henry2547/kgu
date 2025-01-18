<?php
include("sessions.php");
?>
<!DOCTYPE html>
<html lang="">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Feedback</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-theme.min.css">

    <!-- Custom CSS -->
    <link href="../assets/css/simple-sidebar.css" rel="stylesheet">
    <link href="../assets/css/dataTables.bootstrap.min.css" rel="stylesheet">


</head>

<style>
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
</style>

<body>



    <!-- Hamburger menu -->
    <div class="hamburger" onclick="toggleMenu()">
        &#9776;
    </div>
    <div class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="teetimebooked.php">Booked Tee Time</a></li>
            <li><a href="history.php">Tee history</a></li>
            <li><a href="tournament.php">Tournament</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="contact.php">Contact us</a></li>
            <li><a href="about.php">About us</a></li>
        </ul>
    </div>


    <div class="container-fluid">

        <div class="col-md-2"></div>
        <div class="col-md-8">
            <ul class="list-group" id="myinfo">

                <li class="list-group-item" id="mylist"></li>

            </ul>
            <div class="panel panel-success">
                <div class="panel-heading">

                    <h3 class="panel-title">Feedback</h3>
                </div>
                <div class="panel-body">

                    <div class="container-fluid">
                        <form class="form-horizontal" action="submitfeedback.php" method="post" role="form" id="submitFeedback">

                            <div class="form-row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>
                                            <input type="radio" name="feedback_type" value="finance_manager" id="option1">
                                            <i class="fas fa-check-circle"></i> Finance manager
                                        </label>
                                        <br>
                                        <label>
                                            <input type="radio" name="feedback_type" value="tournament_manager" id="option2">
                                            <i class="fas fa-check-circle"></i> Tournament manager
                                        </label>
                                        <br>
                                        <label>
                                            <input type="radio" name="feedback_type" value="tee_manager" id="option3">
                                            <i class="fas fa-check-circle"></i> Tee time manager
                                        </label>
                                        <br>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <input type="hidden" name="golferId" class="form-control" id="golferId" value="<?php echo $golferId; ?>">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="message">Message:</label>
                                        <textarea name="message" id="message" class="form-control" required></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" name="save_feedback" class="btn btn-success form-control">
                                    Save and Continue <span class="glyphicon glyphicon-arrow-right" aria-hidden="true"></span>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>



            <div class="col-md-2"></div>
            <div class="col-md-8">
                <ul class="list-group" id="myinfo">

                    <li class="list-group-item" id="mylist"></li>

                </ul>
                <div class="panel panel-success">
                    <div class="panel-heading">

                        <h3 class="panel-title">Replies</h3>
                    </div>

                    <div id="trans-table">
                        <table id="myTable-trans" class="table table-bordered table-hover" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th>S/N</th>

                                    <th>From</th>
                                    <th>
                                        <center>My message</center>
                                    </th>
                                    <th>
                                        <center>Reply</center>
                                    </th>
                                    

                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                // The serial number variable
                                require("dbconnect.php");
                                $sn = 0;
                                $query = mysqli_query($dbcon, "SELECT replies.*, feedback.*, golfer.golferId
                                FROM replies
                                JOIN feedback ON replies.feedbackId = feedback.feedbackId
                                JOIN golfer ON feedback.golferId = golfer.golferId
                                WHERE golfer.golferId = '$golferId';");

                                while ($row = mysqli_fetch_array($query)) {
                                    
                                    $sn++;
                                ?>
                                    <tr>

                                        <td><?php echo $sn; ?></td>
                                        <td>
                                            <?php
                                            if($row['message_to'] == 'finance_manager'){
                                                echo "Finance manager";
                                            }
                                            elseif($row['message_to'] == 'tee_manager'){
                                                echo "Tee manager";
                                            }elseif($row['message_to'] == 'tournament_manager'){
                                                echo "Tournament manager";
                                            }
                                            ?>
                                        </td>
                                        <td><?php echo $row['Message']; ?></td>
                                        <td><?php echo $row['message_reply']; ?></td>

                                        
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>


        </div>
    </div>
    <div class="col-md-2"></div>
    </div>



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

<?php include('scripts.php'); ?>

<script type="text/javascript">
    $(document).on('submit', '#submitFeedback', function(event) {
        event.preventDefault();
        // This removes the error messages from the page
        $(".list-group-item").remove();

        var formData = $(this).serialize();

        $.ajax({
            url: 'submitfeedback.php',
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
                        title: 'Feedback sent!',
                        showConfirmButton: false,
                        timer: 3000
                    });

                    // Redirect after success (optional)
                    setTimeout(function() {
                        window.location = 'feedback.php';
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


<script type="text/javascript">
    $(document).ready(function() {
        $('#myTable-trans').DataTable();
    });
</script>

</html>