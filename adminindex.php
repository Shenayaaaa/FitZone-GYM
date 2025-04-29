<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - FitZone Fitness Center</title>
    <link rel="icon" type="image/x-icon" href="bo.png">
    <link rel="stylesheet" href="FitZone.css">
    <script>
        function validateForm() {
            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();
            const errorBox = document.getElementById('error-box');
            let isValid = true;
            let errorMessage = "";

            const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailPattern.test(email)) {
                errorMessage = "Please enter a valid email address.";
                isValid = false;
            } else if (password !== "123456789") {
                errorMessage = "Password must be '123456789'.";
                isValid = false;
            }

            if (!isValid) {
                errorBox.textContent = errorMessage;
                errorBox.style.display = "block";
            }

            return isValid;
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
                <li class="dropdown">

                    <div class="dropdown-content">
                        <a href="adminindex.php">Admin Login</a>
                        <a href="Index.php">Customer Login</a>
                        <a href="Staffindex.php">Staff Login</a>
                    </div>
                </li>
                <li><a href="FitZone.html">Home</a></li>
            </ul>
        </nav>
    </header><br><br>

    <section class="login-page">
        <div class="illustration">
            <img src="cp.jpg" alt="Illustration of a fit person exercising">
        </div>
        <div class="login-container">
            <h2>Admin Sign-in Portal</h2>
            <p>Please enter your details to access the admin panel</p>

            <!-- Error box for validation -->
            <div id="error-box" class="error-message" style="display: none;" aria-live="polite"></div>

            <!-- Admin Login Form -->
            <form action="loginc.php" method="POST" onsubmit="return validateForm()">
                <div class="input-group">
                    <label for="email" aria-label="Enter your email">Email</label>
                    <input type="email" id="email" name="email" autocomplete="email" required placeholder="Enter your email" aria-describedby="email-helper">
                </div>
                <div class="input-group">
                    <label for="password" aria-label="Enter your password">Password</label>
                    <input type="password" id="password" name="password" autocomplete="current-password" required placeholder="Enter your password" aria-describedby="password-helper">
                </div>
                <button type="submit" class="login-btn">Log In</button>
                <p class="register-link">Don't have an account? <a href="register.html">Sign Up</a></p>
            </form>
        </div>
    </section>
</body>
</html>
