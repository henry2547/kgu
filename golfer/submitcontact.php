<?php
    include("dbconnect.php");
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Check if all required fields are filled
        if (isset($_POST['name']) && isset($_POST['email']) && isset($_POST['message']) &&
            !empty($_POST['name']) && !empty($_POST['email']) && !empty($_POST['message'])) {

            // Sanitize input data to prevent SQL injection
            $username = htmlspecialchars($_POST['name']);
            $email = htmlspecialchars($_POST['email']);
            $message = htmlspecialchars($_POST['message']);

            
            // Prepare and execute SQL query to insert data into the contact table
            $sql = "INSERT INTO contact (username, email, message) VALUES (?, ?, ?)";
            $stmt = $dbcon->prepare($sql);
            $stmt->bind_param("sss", $username, $email, $message);

            if ($stmt->execute()) {
                // Data inserted successfully
                echo "<script>alert('Your message has been submitted successfully. We will get back to you soon.');</script>";
            } else {
                // Error inserting data
                echo "<script>alert('Error: " . $dbcon->error . "');</script>";
            }

            // Close statement and database dbconection
            $stmt->close();
            $dbcon->close();
        } else {
            // If any required field is missing, show an error message
            echo "<script>alert('Please fill in all required fields.');</script>";
        }
    } else {
        // If form is not submitted, show an error message
        echo "<script>alert('Form submission failed.');</script>";
    }

    // Redirect back to the contact page
    echo "<script>window.location.href = 'contact.php';</script>";
    exit();
?>
