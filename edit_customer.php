<?php
session_start();

// Check if the user is logged in as admin or staff
if (
    !(isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) &&
    !(isset($_SESSION['staff_logged_in']) && $_SESSION['staff_logged_in'] === true)
) {
    header("Location: loginc.php");
    exit;
}

include 'db_connect.php'; // Ensure that the database connection is included

// Check if 'id' is passed via GET
if (isset($_GET['id'])) {
    $customer_id = $_GET['id'];

    // Fetch the customer details based on the provided ID
    $query = "SELECT * FROM user_roles1 WHERE user_id = ? AND role = 'customer'";  // Ensure the customer role is checked
    $stmt = $conn->prepare($query);
    
    if ($stmt === false) {
        echo "Failed to prepare the SQL statement. Error: " . $conn->error;
        exit;
    }

    $stmt->bind_param("i", $customer_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $customer = $result->fetch_assoc();

    if (!$customer) {
        echo "Customer not found.";
        exit;
    }

    // If form is submitted, update customer data
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Collect updated data from form
        $username = $_POST['username'];
        $email = $_POST['email'];

        // Update query
        $update_query = "UPDATE user_roles1 SET username = ?, email = ? WHERE user_id = ?";
        $update_stmt = $conn->prepare($update_query);
        
        if ($update_stmt === false) {
            echo "Failed to prepare the update statement. Error: " . $conn->error;
            exit;
        }

        $update_stmt->bind_param("ssi", $username, $email, $customer_id);
        $update_stmt->execute();

        if ($update_stmt->affected_rows > 0) {
            echo "Customer details updated successfully.";
        } else {
            echo "No changes were made or error updating customer details.";
        }
    }
} else {
    echo "No customer ID provided.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
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
        <h2>Edit Customer</h2>
        <form action="edit_customer.php?id=<?php echo $customer['user_id']; ?>" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($customer['username']); ?>" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($customer['email']); ?>" required>

            <button type="submit">Update Customer</button>
        </form>
    </section>
</body>
</html>
