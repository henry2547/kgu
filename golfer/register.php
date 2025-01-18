<?php
// Database connection
require_once "dbconnect.php"; // Include database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $fname = $_POST["fname"];
    $sname = $_POST["sname"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $address = $_POST["address"];
    $gender = $_POST["gender"];
    $password = sha1($_POST["password"]); // Hash the password using SHA1
    $club = $_POST['club'];

    // Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<div class='alert'>Invalid email format. Please enter a valid email address.</div>";
    }
    // Validate phone number format
    elseif (!preg_match("/^\d{10}$/", $phone)) {
        // Phone number does not match the format (10 digits)
        echo "<div class='alert'>Invalid phone number format. Please enter a 10-digit phone number.</div>";
    }
    // Check if email or phone already exists
    else {
        $query = "SELECT * FROM golfer WHERE Email = :email OR Phone = :phone";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->execute();
        $existingUser = $stmt->fetch();

        if ($existingUser) {
            // Email or phone number already exists
            echo "<div class='alert'>Email or phone number already exists.</div>";
        } else {
            // Insert user data into the database
            $sql = "INSERT INTO golfer (clubId, FirstName, SecondName, Email, Phone, Address, Gender, Password) 
                    VALUES (:club, :fname, :sname, :email, :phone, :address, :gender, :password)";

            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':club', $club);
            $stmt->bindParam(':fname', $fname);
            $stmt->bindParam(':sname', $sname);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':phone', $phone);
            $stmt->bindParam(':address', $address);
            $stmt->bindParam(':gender', $gender);
            $stmt->bindParam(':password', $password);

            if ($stmt->execute()) {
                // Registration successful, redirect to login page
                echo "<script>alert('Registration successful! Please login.');</script>";
                header("Location: login.php");
                exit;
            } else {
                // Registration failed
                echo "<div class='alert'>Error: Unable to register user.</div>";
            }
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../assets/css/bootstrap-theme.min.css">

    <!-- Custom CSS -->
    <link href="../assets/css/simple-sidebar.css" rel="stylesheet">
    <link href="../assets/css/dataTables.bootstrap.min.css" rel="stylesheet">


    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff8ff;
            border-radius: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }


        .alert {
            background-color: #f44336;
            color: white;
            padding: 10px;
            margin: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.5);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            /* Ensure a high z-index */
        }

        .loading-icon {
            width: 50px;
            height: 50px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #3498db;
            border-radius: 50%;
            animation: spin 1s linear infinite;
            display: inline-block;
            /* Make the loading icon visible */
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>User Registration</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" id="login-form">

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <label for="fname">First Name:</label>
                    <input type="text" id="fname" name="fname" class="form-control" required maxlength="10">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <label for="sname">Surname:</label>
                    <input type="text" id="sname" name="sname" class="form-control" required maxlength="10">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required maxlength="50">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" class="form-control" required maxlength="10" minlength="10">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" class="form-control" required maxlength="20">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <label for="gender">Gender:</label>
                    <select id="gender" name="gender" class="form-control" required>
                        <option disabled selected></option>
                        <option value="male">Male</option>
                        <option value="female">Female</option>
                        <option value="other">Other</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <label for="club">Select Club:</label>
                    <select name="club" class="form-control">
                        <option disabled selected></option>
                        <?php
                        require_once "../config/dbconnect.php";
                        $sql = "SELECT * FROM clubs";
                        $result = $dbcon->query($sql);

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                echo "<option value='" . $row['clubId'] . "'>" . $row['ClubName'] . "</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <label for="password">Password:</label>
                    <input type="password" id="password" class="form-control" name="password" required maxlength="10" minlength="5">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="login" class="btn btn-success">Create
                        <span class="glyphicon glyphicon-check"></span>
                    </button>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="button" class="btn btn-default">
                        <a href="login.php">Login to my account</a>

                    </button>
                </div>
            </div>
        </form>



    </div>

    <script>
        // Function to show loading overlay
        function showLoadingOverlay() {
            document.getElementById('loading-overlay').style.display = 'flex';
        }

        // Function to hide loading overlay
        function hideLoadingOverlay() {
            document.getElementById('loading-overlay').style.display = 'none';
        }

        // Attach event listener to form submit
        document.getElementById('login-form').addEventListener('submit', function() {
            // Show loading overlay when form is submitted
            showLoadingOverlay();
        });
    </script>

</body>

</html>