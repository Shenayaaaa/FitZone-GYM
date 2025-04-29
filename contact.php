<?php
// Database connection settings
$servername = "localhost"; // Replace with your database server
$username = "root";        // Replace with your database username
$password = "";            // Replace with your database password
$dbname = "fitzonefitness";       // Replace with your database name

// Function to sanitize input
function sanitizeInput($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Function to handle form submission
function handleContactForm() {
    global $servername, $username, $password, $dbname;

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Sanitize inputs
        $name = sanitizeInput($_POST['name']);
        $email = sanitizeInput($_POST['email']);
        $phone = sanitizeInput($_POST['phone']);
        $message = sanitizeInput($_POST['message']);

        // Validate inputs
        if (empty($name) || empty($email) || empty($phone) || empty($message)) {
            return "All fields are required!";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format!";
        }

        // Save submission to database
        try {
            // Create a database connection
            $conn = new mysqli($servername, $username, $password, $dbname);

            // Check connection
            if ($conn->connect_error) {
                throw new Exception("Connection failed: " . $conn->connect_error);
            }

            // Prepare and bind SQL statement
            $stmt = $conn->prepare("INSERT INTO ContactSubmissions (name, email, phone, message) VALUES (?, ?, ?, ?)");
            $stmt->bind_param("ssss", $name, $email, $phone, $message);

            // Execute statement
            if ($stmt->execute()) {
                $stmt->close();
                $conn->close();
                return "Thank you, $name! Your message has been received successfully.";
            } else {
                throw new Exception("Error inserting data: " . $stmt->error);
            }
        } catch (Exception $e) {
            return "An error occurred: " . $e->getMessage();
        }
    }
    return "";
}

// Handle form submission
$feedback = handleContactForm();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - FitZone Fitness Center</title>
    <link rel="icon" type="image/x-icon" href="bo.png">
    <link rel="stylesheet" href="FitZone.css">
</head>
<body>
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

    <section class="contact-section">
        <div class="container">
            <h1>Contact Us Online</h1>
            <!-- Display feedback message -->
            <?php if (!empty($feedback)): ?>
                <p class="feedback-message"><?= $feedback ?></p>
            <?php endif; ?>

            <form action="Contact.php" method="POST" class="contact-form" id="contact-form">
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" placeholder="Full Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" placeholder="Email Address" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" id="phone" name="phone" placeholder="Phone" required>
                </div>

                <div class="form-group">
                    <label for="message">Message / Feedback</label>
                    <textarea id="message" name="message" placeholder="Message" required></textarea>
                </div>

                <!-- Submit button -->
                <button type="submit" class="cta-button">Send</button>
            </form>
        </div>

        <!-- Contact details -->
        <div class="contact-details">
            <p><strong>Email:</strong> support@fitzone.com</p>
            <p><strong>Phone:</strong> +94 11 2 688 461</p>
            <p><strong>Address:</strong> 12 A, Main Road, Kurunegala.</p>
        </div>
        <footer>
            <nav>
                <ul class="navbar">
                    <li>
                        <span>MEMBERSHIP</span>
                        <ul>
                            <li><a href="Index.php">Login</a></li>
                            <li><a href="Contact.php">Contact Us</a></li>
                            <li><a href="register.php">Register Now</a></li>
                        </ul>
                    </li>
                    <li>
                        <span>OUR SERVICES</span>
                        <ul>
                            <li><a href="Trainers.html">Trainers Booking</a></li>
                            <li><a href="Membership.html">Membership Plans & Class Schedule</a></li>
                            <li><a href="Nutrition.html">Nutrition & Counseling</a></li>
                            <li><a href="Blog.html">Blog</a></li>
                            <li><a href="Events.html"> Upcoming Events & Workshops</a></li>
                        </ul>
                    </li>
                    <li>
                        <span>OTHER SUPPORTIVE LINKS</span>
                        <ul>
                            <li><a href="Success.html">Testimonials</a></li>
                            <li><a href="Terms.html">Privacy & Policy</a></li>
                            <li><a href="Careers.html">Careers</a></li>
                            <li><a href="FAQ'S.html">FAQs</a></li>
                        </ul>
                    </li>
                </ul>
            </nav>
            <p>&copy; 2024 FitZone Fitness Center. All rights reserved.</p>
        </footer>
    </section>
</body>
</html>
