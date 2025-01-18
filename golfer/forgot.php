<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Login</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> <!-- Font Awesome for icons -->
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
            max-width: 500px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff8ff;
            border-radius: 20px;

            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .alert {
            background-color: #f44336;
            color: white;
            padding: 10px;
            margin: 20px;
            border-radius: 5px;
            text-align: center;
        }

        .account {
            font-family: Arial, Helvetica, sans-serif;
            font-style: normal;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .account a {
            font-size: large;
            font-style: normal;
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
        <h2>Reset password</h2>
        <form method="post" id="login-form">

            <div class="form-row">

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>

                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        <button type="submit" name="login" class="btn btn-success">Reset password
                            <span class="glyphicon glyphicon-check"></span>
                        </button>
                    </div>
                </div>




                <div class="form-group">
                    <div class="account">
                        Already have an account? <a href="login.php" class="text-primary">Login</a>
                    </div>
                </div>



            </div>
        </form>



    </div>

    <!-- Loading overlay with loading icon -->
    <div class="loading-overlay" id="loading-overlay">
        <div class="loading-icon">

        </div>
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