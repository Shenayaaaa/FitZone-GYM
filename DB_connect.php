<?php
$servername = "localhost"; // Replace with your server name
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "fitzonefitness";       // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// This script should remain open to be included in other files
?>
