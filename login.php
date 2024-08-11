<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="/">App</a>
        <div class="collapse navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="register.php">Register</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="login.php">Login</a>
                </li>
                <?php if (isset($_SESSION['username'])): ?>
                <li class="nav-item">
                    <a class="nav-link" href="profile.php">Profile</a>
                </li>
            <li class="nav-item">
                <a class="nav-link" href="profile.php">Profile</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="logout.php">Logout</a>
            </li>
            <?php endif; ?>
            </ul>
        </div>
    </nav>

    <div class="container mt-4">
        <h2>Login</h2>
        <?php
        session_start(); // Start the session

        // Redirect already logged-in users to the profile page
        if (isset($_SESSION['username'])) {
            header("Location: profile.php");
            exit();
        }

        // Handle login form submission
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
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

            // Sanitize and prepare input
            $user = $conn->real_escape_string($_POST['username']);
            $pass = md5($_POST['password']); // Hash the password with MD5

            // Check credentials
            $stmt = $conn->prepare("SELECT username FROM users WHERE username=? AND password=?");
            $stmt->bind_param("ss", $user, $pass);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Valid user, set session variables
                $_SESSION['username'] = $user;
                header("Location: profile.php"); // Redirect to profile page
                exit();
            } else {
                echo "<div class='alert alert-danger'>Invalid username or password.</div>";
            }

            $stmt->close();
            $conn->close();
        }
        ?>

        <form method="post" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
