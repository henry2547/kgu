<?php
// Start the session
session_start();

// Check if session variables are set
if (
    isset($_SESSION['FirstName']) && isset($_SESSION['SecondName'])
    && isset($_SESSION['golferId']) && $clubId = $_SESSION['clubId']
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

if (isset($_GET['alert']) && isset($_GET['message'])) {
    $alert_type = $_GET['alert'];
    $alert_message = $_GET['message'];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Tee Times</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-theme.min.css">

    <!-- Custom CSS -->
    <link href="../assets/css/simple-sidebar.css" rel="stylesheet">
    <link href="../assets/css/dataTables.bootstrap.min.css" rel="stylesheet">

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
        }

        .card img {
            max-width: 100%;
            height: 100px;
            width: auto;
            object-fit: cover;
        }

        .card h3,
        p {
            margin-left: 10px;
        }

        /* Media query for screens smaller than 768px (phones) */
        @media (max-width: 768px) {
            .card {
                width: calc(100% - 20px);
                /* Set card width to 100% of the viewport width minus margin */
            }

            .card img {
                height: auto;
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

        /* Button styles */
        .total-price-btn {
            background-color: #28a745;
            /* Green color */
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 18px;
            margin-top: 20px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .total-price-btn:hover {
            background-color: #218838;
            /* Darker shade of green on hover */
        }



        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            border-radius: 10px;
        }

        /* Close button */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        /* Input field */
        #transactionCode {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        /* Button styles */
        button {
            background-color: #4CAF50;
            /* Green */
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #45a049;
            /* Darker shade of green on hover */
        }

        /* Error message */
        .error-message {
            color: #dc3545;
            /* Red color for danger */
            margin-top: 10px;
            background-color: rgba(255, 0, 0, 0.1);
            /* Light red background */
            padding: 10px;
            border-radius: 5px;
        }

        /* Success message */
        .success-message {
            color: #28a745;
            /* Green color for success */
            margin-top: 10px;
            background-color: rgba(0, 128, 0, 0.1);
            /* Light green background */
            padding: 10px;
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
    </style>


</head>

<body>


    <div class="banner">
        Pay for your tee bookings
    </div>

    <!-- Hamburger menu -->
    <div class="hamburger" onclick="toggleMenu()">
        &#9776;
    </div>

    <div class="menu">
        <ul>
            <li><a href="index.php">Home</a></li>
            <li><a href="teetimebooked.php">Booked Tee Time</a></li>
            <li><a href="history.php">Tee history</a></li>
            <li><a href="clubs/">Tournament</a></li>
            <li><a href="feedback.php">Feedback</a></li>
            <li><a href="#">Contact us</a></li>
            <li><a href="#">About us</a></li>
        </ul>
    </div>

    <?php
    // Include the file with database connection details
    require_once("../config/dbconnect.php");

    // Initialize total price variable
    $totalPrice = 0;

    // Assuming you have already executed the SQL query and fetched the data into $result
    $query = "SELECT booktee.*, golfer.*, teetime.*, available_tees.*, clubs.*
    FROM booktee
    JOIN golfer ON booktee.golferId = golfer.golferId
    JOIN teetime ON booktee.teeId = teetime.teeId
    JOIN available_tees ON teetime.availableTeeId = available_tees.id
    JOIN clubs ON teetime.golf_course = clubs.clubId
    WHERE golfer.golferId = '$golferId' AND DATE(booktee.bookingDate) = CURDATE()
    AND booktee.BookingStatus = 'approved' AND booktee.isPaid = 'unpaid'";


    $result = $dbcon->query($query);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<div class='container-fluid>'";
        echo "<div class='col-md-1'>";
        echo "</div>";
        echo "<div class='col-md-8'>";
        echo "<div class='card'>";
        echo "<img src='../tee/tee/uploads/{$row['Image']}' alt='{$row['tee_name']}' class='small-image'>";
        echo "<h3>{$row['tee_name']}</h3>";
        echo "<p><strong>Golf course:</strong> {$row['ClubName']} </p> <br>";
        echo "<p>KSHs <strong>{$row['Price']}</strong> per hole</p>";
        echo "<p>You booked for <strong>{$row['BookedHoles']}</strong> holes</p>";
        
        echo "</div>";
        echo "</div>";
        echo "</div>";

        // Compute subtotal price for each tee time and add to total price
        $subtotal = $row['Price'] * $row['BookedHoles'];
        $totalPrice += $subtotal;
    }

    ?>

    <div class="panel-body">
        <div class="form-group">
            <div class="col md-6">
                <?php if ($totalPrice > 0) : ?>
                    <h3>
                        <?php
                        echo "Total Price: KSHs " . number_format($totalPrice, 2); ?>
                    </h3>
                    <!-- Button to show modal -->

                    <button class="total-price-btn" onclick="openModal()">Proceed to Payment</button>

                <?php else : ?>

                    <button class="btn btn-default" onclick="downloadReceipt('<?php echo $golferId ?>')">Download Receipt</button>


                <?php endif; ?>

            </div>
        </div>
    </div>


    <!-- Modal -->
    <div id="myModal" class="modal">
        <!-- Modal content -->
        <div class="modal-content">

            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Enter Transaction Code</h2>
            <label for="mode_payment">Mode of payment:</label>
            <select name="mode_payment" class="form-control" id="mode_payment">
                <option disabled selected></option>
                <option value="Mpesa">Mpesa</option>
                <option value="Bank">Bank</option>
            </select>
            <label for="code">Enter transaction code:</label>
            <input type="text" id="transactionCode" maxlength="10"><br>
            <button onclick="verifyTransaction()">Verify Transaction</button>

            <!-- Add response message container -->
            <div id="responseMessage"></div>
        </div>
    </div>

    <?php include "scripts.php" ?>

    <script>
        function toggleMenu() {
            document.querySelector('.menu').classList.toggle('open');
        }
        // Function to open modal
        function openModal() {
            document.getElementById('myModal').style.display = 'block';
        }

        // Function to close modal
        function closeModal() {
            document.getElementById('myModal').style.display = 'none';
            document.getElementById('errorMessage').innerHTML = ''; // Clear error message
        }

        // Function to verify transaction code and insert payment data
        function verifyTransaction() {
            // Get transaction code value
            var transactionCode = document.getElementById('transactionCode').value;
            var mode_payment = document.getElementById('mode_payment').value;

            // Regular expression to check if the transaction code has at least one number and one letter and its length is 10
            var regex = /^(?=.*[A-Z])(?=.*[0-9])[A-Z0-9]{10}$/;

            if (regex.test(transactionCode)) {
                // Transaction code format is valid, fetch total price and proceed with payment
                var totalPrice = '<?php echo $totalPrice; ?>';
                var golferId = '<?php echo $golferId; ?>';

                // Make an AJAX call to insert payment data
                var xhr = new XMLHttpRequest();
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        var response = JSON.parse(xhr.responseText);
                        if (response.success) {
                            // Payment successful, display success message using SweetAlert
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Payment Saved',
                                showConfirmButton: false,
                                timer: 3000
                            });


                            setTimeout(function() {
                                window.location = 'index.php';
                            }, 3000);

                        } else {
                            // Payment code already used or other error, display error message using SweetAlert
                            Swal.fire({
                                icon: 'error',
                                title: 'Payment Error',
                                text: response.message,
                                timer: 2000, // Close alert after 5 seconds
                                timerProgressBar: true
                            });
                        }
                    }
                };
                xhr.open("POST", "processpayment.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.send("golferId=" + golferId + "&transactionCode=" + transactionCode + "&totalAmount=" + totalPrice + "&mode_payment=" + mode_payment);
            } else {
                // Transaction code format is invalid, display error message using SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Transaction Code',
                    text: 'Transaction code must contain NUMBERS and CAPITAL LETTERS, and have a length of 10 characters.',
                });
            }
        }



        document.addEventListener("DOMContentLoaded", function() {
            document.getElementById('myModal').style.display = 'none';
        });
    </script>

    <script>
        var sessionVars = {
            golferId: '<?php echo $_SESSION['golferId']; ?>',
            firstName: '<?php echo $_SESSION['FirstName']; ?>',
            secondName: '<?php echo $_SESSION['SecondName']; ?>'
            
        };

        function downloadReceipt(golferId) {
            var url = 'receipt.php?golferId=' + golferId +
                '&firstName=' + encodeURIComponent(sessionVars.firstName) +
                '&secondName=' + encodeURIComponent(sessionVars.secondName);
                

            // Open the default browser with the URL
            window.open(url, '_system');
        }
    </script>


</body>

</html>