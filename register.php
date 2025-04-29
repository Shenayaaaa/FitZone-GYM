<?php
// Database connection
include 'DB_connect.php';

// Initialize variables for error and success messages
$error = "";
$success = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize form data
    $username = htmlspecialchars(trim($_POST['Name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = trim($_POST['psw']);
    $confirm_password = trim($_POST['psw-repeat']);

    // Set the default role to 'customer'
    $role = 'customer';

    // Validate inputs
    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $error = "All fields are required!";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Invalid email format!";
    } elseif ($password !== $confirm_password) {
        $error = "Passwords do not match!";
    } elseif (strlen($password) < 8 || !preg_match("/[A-Za-z]/", $password) || !preg_match("/[0-9]/", $password)) {
        $error = "Password must be at least 8 characters long and include both letters and numbers.";
    }

    // If no errors, proceed with the registration
    if (empty($error)) {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL statement to insert data into the user_roles1 table
        $stmt = $conn->prepare("INSERT INTO user_roles1 (username, password, role, email, created_at) VALUES (?, ?, ?, ?, NOW())");

        // Check if the statement was prepared successfully
        if ($stmt) {
            // Bind parameters: s = string
            $stmt->bind_param("ssss", $username, $hashed_password, $role, $email);

            // Execute the statement
            if ($stmt->execute()) {
                $success = "Registration successful! Redirecting to login page...";
                echo "<script>alert('$success'); window.location.href='Index.php';</script>";
                exit;
            } else {
                $error = "Database error: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        } else {
            $error = "SQL Error: " . $conn->error;
        }
    }

    // Close the database connection
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - FitZone Fitness</title>
    <link rel="icon" type="image/x-icon" href="bo.png">
    <link rel="stylesheet" href="FitZone.css"> 
</head>
<body>
    <div class="bg"></div>
    <div class="bg bg2"></div>
    <div class="bg bg3"></div>

    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="FitZone.html"><span class="fitzone">FitZone</span> <span class="fitness">Fitness</span></a>
            </div>
            <ul class="navbar-links">
                <li><a href="Index.php">Login</a></li>
                <li><a href="register.php">Register Now</a></li>
                <li><a href="Blog.html">Blog</a></li>
                <li><a href="About.html">About GYM</a></li>
                <li><a href="Contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>

    <br><br>

    <section class="register-page">
        <div class="illustration">
            <img src="cp.jpg" alt="Illustration">
        </div>
       
        <div class="register-container">
            <h2>Register Now!</h2>
            <p>Please fill in this form to create an account.</p>

            <!-- Display error or success messages -->
            <?php if (!empty($error)): ?>
                <div class="error-message"><?= $error ?></div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
                <div class="success-message"><?= $success ?></div>
            <?php endif; ?>

            <form action="register.php" method="POST">
                <div class="input-group">
                    <label for="Name">Username</label>
                    <input type="text" placeholder="Enter Username" name="Name" id="Name" required>
                </div>
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" placeholder="Enter Email" name="email" id="email" required>
                </div>
                
                <div class="input-group">
                    <label for="psw">Password</label>
                    <input type="password" placeholder="Enter Password" name="psw" id="psw" required>
                </div>
                
                <div class="input-group">
                    <label for="psw-repeat">Confirm Password</label>
                    <input type="password" placeholder="Confirm Password" name="psw-repeat" id="psw-repeat" required>
                </div>
                
                <p>By creating an account, you agree to our <a href="#">privacy & policy</a></p>
                
                <button type="submit" class="register-btn">Register</button>
            </form>
            
            <div class="signin-container">
                <p>Already have an account? <a href="Index.php">Log in</a>.</p>
            </div>
        </div>
    </section>
</body>
</html>
