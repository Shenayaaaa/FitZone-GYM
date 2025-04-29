<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit a Query - Customer Dashboard</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="icon" type="image/x-icon" href="bingo.PNG">
</head>
<body>
    <header>
        <nav class="navbar">
            <div class="logo">
                <a href="FitZone.html"><span class="fitzone">FitZone</span> <span class="fitness">Fitness</span></a>
            </div>
            <ul class="navbar-links">
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <section>
        <h2>Submit a Query</h2>
        <form method="POST">
            <label for="subject">Subject:</label>
            <input type="text" name="subject" id="subject" required>

            <label for="message">Message:</label>
            <textarea name="message" id="message" rows="5" required></textarea>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required>

            <button type="submit" name="submit">Submit Query</button>
        </form>

        <?php
        // Include database connection
        include 'db_connect.php';

        // Check if the form is submitted
        if (isset($_POST['submit'])) {
            // Collect form data
            $subject = $conn->real_escape_string($_POST['subject']);
            $message = $conn->real_escape_string($_POST['message']);
            $email = $conn->real_escape_string($_POST['email']);

            // Retrieve customer_id from the user_roles1 table based on the email
            $user_query = "SELECT user_id FROM user_roles1 WHERE email = '$email'";
            $user_result = $conn->query($user_query);

            // Check if query execution was successful
            if ($user_result === false) {
                echo "<p>Error with the query: " . $conn->error . "</p>";
            } elseif ($user_result->num_rows > 0) {
                $user_row = $user_result->fetch_assoc();
                $user_id = $user_row['user_id']; // user_id should be retrieved

                // Insert the query into the queries7 table
                $insert_query = "INSERT INTO queries7 (customer_id, subject, message, submitted_at, status) 
                                 VALUES ('$user_id', '$subject', '$message', NOW(), 'open')";

                if ($conn->query($insert_query) === TRUE) {
                    echo "<p>Your query has been submitted successfully!</p>";
                } else {
                    echo "<p>Error submitting the query: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>No user found with the provided email. Please check your email and try again.</p>";
            }
        }
        ?>
    </section>
</body>
</html>
