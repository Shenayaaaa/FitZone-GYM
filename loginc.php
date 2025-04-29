<?php
session_start();
include 'DB_connect.php'; // Ensure this file contains a secure database connection

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Trim and sanitize input
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $password = trim($_POST['password']);

    // Check database connection
    if (!$conn || $conn->connect_error) {
        die("Database connection error: " . $conn->connect_error);
    }

    try {
        // Use a prepared statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT user_id, username, password, role FROM user_roles1 WHERE email = ?");
        if (!$stmt) {
            throw new Exception("Failed to prepare the SQL statement.");
        }

        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 1) {
            $row = $result->fetch_assoc();

            // Handle admin login with hardcoded password
            if ($row['role'] === 'admin' && $password === '123456789') {
                // Set session variables for admin
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                
                // Redirect admin to AdminDB.php
                header("Location: /fitzone77/AdminDB.php");
                exit();
            }

            // Verify password for non-admin users
            if (password_verify($password, $row['password'])) {
                // Set session variables based on user role
                $_SESSION['user_id'] = $row['user_id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['role'] = $row['role'];
                $_SESSION['is_logged_in'] = true;

                // Redirect based on user role
                if ($row['role'] === 'customer') {
                    $_SESSION['customer_logged_in'] = true;
                    header("Location: /fitzone77/IndexDB.php");
                } elseif ($row['role'] === 'staff') {
                    $_SESSION['staff_logged_in'] = true;
                    header("Location: /fitzone77/StaffDB.php");
                } else {
                    throw new Exception("Invalid user role. Access denied.");
                }
                exit();
            } else {
                // Invalid password
                echo "<script>alert('Incorrect password. Please try again.'); window.location.href='Index.php';</script>";
            }
        } else {
            // No user found with the given email
            echo "<script>alert('No user found with that email. Please try again.'); window.location.href='Index.php';</script>";
        }

        $stmt->close();
    } catch (Exception $e) {
        // Log the error message (optional) and display an alert to the user
        error_log("Error in login script: " . $e->getMessage());
        echo "<script>alert('An error occurred: " . htmlspecialchars($e->getMessage()) . "'); window.location.href='Index.php';</script>";
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    // Invalid request method
    echo "<script>alert('Invalid request method. Please use the login form.'); window.location.href='Index.php';</script>";
}
?>
