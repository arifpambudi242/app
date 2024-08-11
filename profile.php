<?php session_start(); // Start the session ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">App</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <?php if (isset($_SESSION['username'])): ?>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Logout</a>
                    </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="login.php">Login</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="register.php">Register</a>
                        </li>
                        <?php endif; ?>
                    </ul>
            </div>
        </nav>
        
    <div class="container mt-4">
        <h2>Profile</h2>
        <?php
        session_start(); // Start the session

        // Check if the user is logged in
        if (!isset($_SESSION['username'])) {
            echo "<div class='alert alert-danger'>Please log in to view your profile.</div>";
            exit;
        }

        // Database configuration
        $servername = "localhost";
        $username = "admin";
        $password = "p@ssw0rd"; // Database password
        $dbname = "admin";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Retrieve username from session
        $user = $conn->real_escape_string($_SESSION['username']);

        // Retrieve user information
        $stmt = $conn->prepare("SELECT username, photo FROM users WHERE username=?");
        $stmt->bind_param("s", $user);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($username, $photo);
        $stmt->fetch();

        if ($stmt->num_rows > 0) {
            echo "<h3>Welcome, " . htmlspecialchars($username) . "!</h3>";
            if ($photo) {
                echo "<img src='uploads/" . htmlspecialchars($photo) . "' alt='Profile Photo' class='img-fluid'>";
            } else {
                echo "<p>No profile photo uploaded.</p>";
            }
        } else {
            echo "<div class='alert alert-danger'>User not found.</div>";
        }

        $stmt->close();
        $conn->close();
        ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
