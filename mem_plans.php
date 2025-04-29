<?php
// Start the session to access session variables like user_id
session_start();

// Include the database connection file
include 'db_connect.php';

// Function to fetch and display membership plans from membership_plans4
function displayMembershipPlans($conn) {
    // SQL query to get membership plans from membership_plans4
    $query = "SELECT membership_id, name, price, benefits, duration, created_at FROM membership_plans4";
    $result = $conn->query($query);

    // Check if the query executed successfully
    if (!$result) {
        echo "<tr><td colspan='6'>Error in query execution: " . $conn->error . "</td></tr>";
        return;
    }

    // Check if there are any results
    if ($result->num_rows > 0) {
        // Loop through the result and display each membership plan
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                <td>" . htmlspecialchars($row['membership_id']) . "</td>
                <td>" . htmlspecialchars($row['name']) . "</td>
                <td>Rs. " . htmlspecialchars($row['price']) . "</td>
                <td>" . htmlspecialchars($row['benefits']) . "</td>
                <td>" . htmlspecialchars($row['duration']) . " days</td>
                <td>" . htmlspecialchars($row['created_at']) . "</td>
                <td>
                    <form method='POST' action=''>
                        <input type='hidden' name='membership_id' value='" . htmlspecialchars($row['membership_id']) . "' />
                        <button type='submit' name='activate_plan' class='activate-btn'>Activate</button>
                    </form>
                </td>
            </tr>";
        }
    } else {
        echo "<tr><td colspan='6'>No membership plans available.</td></tr>";
    }
}

// Handle activation of membership plans
if (isset($_POST['activate_plan'])) {
    // Ensure the user is logged in
    if (!isset($_SESSION['user_id'])) {
        die("You must be logged in to activate a membership plan.");
    }

    // Get the user_id and the selected membership_id
    $user_id = $_SESSION['user_id']; // Make sure the user is logged in
    $membership_id = $_POST['membership_id'];

    // SQL query to store the selected plan in session (or a simplified activation method)
    $_SESSION['active_membership'] = $membership_id;  // Store in session instead of database

    echo "<p>Your membership has been successfully activated!</p>";
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Membership Plans - Customer Dashboard</title>
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
        <h2>Your Active Membership</h2>
        <?php
        // Display active membership if it exists in the session
        if (isset($_SESSION['user_id'])) {
            if (isset($_SESSION['active_membership'])) {
                $membership_id = $_SESSION['active_membership'];

                // Fetch the membership details from the membership_plans4 table based on active membership
                $query = "SELECT name, price, benefits, duration, created_at FROM membership_plans4 WHERE membership_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $membership_id);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    $active_membership = $result->fetch_assoc();
                    echo "<div class='active-membership-box'>
                            <h3>Active Plan: " . htmlspecialchars($active_membership['name']) . "</h3>
                            <p>Price: Rs. " . htmlspecialchars($active_membership['price']) . "</p>
                            <p>Benefits: " . htmlspecialchars($active_membership['benefits']) . "</p>
                            <p>Duration: " . htmlspecialchars($active_membership['duration']) . " days</p>
                            <p>Start Date: " . htmlspecialchars($active_membership['created_at']) . "</p>
                          </div>";
                } else {
                    echo "<p>No active membership found. Please select a membership plan.</p>";
                }
            } else {
                echo "<p>No active membership found. Please select a membership plan.</p>";
            }
        } else {
            echo "<p>Please log in to view your active membership.</p>";
        }
        ?>

        <h2>Available Membership Plans</h2>
        <table>
            <thead>
                <tr>
                    <th>Membership ID</th>
                    <th>Plan Name</th>
                    <th>Price</th>
                    <th>Benefits</th>
                    <th>Duration (Days)</th>
                    <th>Created At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                // Call the function to display membership plans
                displayMembershipPlans($conn);
                ?>
            </tbody>
        </table>
    </section>
</body>
</html>
