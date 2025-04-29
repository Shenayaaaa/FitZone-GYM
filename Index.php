<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - FitZone Fitness Center</title>
    <link rel="icon" type="image/x-icon" href="bo.png">
    <link rel="stylesheet" href="FitZone.css">
    <script>
        function validateForm() {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;

            // Simple email validation
            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                alert("Please enter a valid email address.");
                return false; // Prevent form submission
            }

            // Check for password length
            if (password.length < 6) {
                alert("Password must be at least 6 characters long.");
                return false; // Prevent form submission
            }

            return true; // Form is valid
        }
    </script>
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
            <li class="end702">
                    <a href="#" class="button-link">Login</a>
                    <div class="end702-content">
                        <a href="adminindex.php">Admin Login</a>
                        <a href="Index.php">Customer Login</a>
                        <a href="Staffindex.php">Staff Login</a>

                    </div>
                </li>
                <li><a href="register.php">Register Now</a></li>
                <li><a href="Blog.html">Blog</a></li>
                <li><a href="About.html">About GYM</a></li>
                <li><a href="Contact.php">Contact Us</a></li>
            </ul>
        </nav>
    </header>
    <br><br><br>

    <section class="login-page">
        <div class="illustration">
            <img src="cp.jpg" alt="Illustration">
        </div>
        <div class="login-container">
            <h2>Welcome back!</h2>
            <p>Please enter your details</p>

            <!-- Add the form element here -->
            <form action="loginc.php" method="POST" onsubmit="return validateForm()">
                <div class="input-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" required placeholder="Enter your email">
                </div>
                <div class="input-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" required placeholder="Enter your password">
                </div>

                <!-- Change button type to submit -->
                <button type="submit" class="login-btn">Log In</button>
                <p class="register-link">Don't have an account? <a href="register.html" style="color:aliceblue;">Sign Up</a></p>
            </form> <!-- Closing the form here -->
        </div>
    </section>

</body>
</html>