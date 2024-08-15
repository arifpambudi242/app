<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
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
        <h2>Register</h2>
        <?php
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

            // Handle file upload
            $uploadDir = './uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            
            $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));
            
            // Check if file is an image
            $check = getimagesize($_FILES['photo']['tmp_name']);
            if ($check === false) {
                echo "<div class='alert alert-danger'>File is not an image.</div>";
                $uploadOk = 0;
            }
            
            // Check file size (limit to 5MB)
            if ($_FILES['photo']['size'] > 5000000) {
                echo "<div class='alert alert-danger'>File is too large.</div>";
                $uploadOk = 0;
            }
            
            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "<div class='alert alert-danger'>Only JPG, JPEG, PNG & GIF files are allowed.</div>";
                $uploadOk = 0;
            }


            
            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                echo "<div class='alert alert-danger'>Your file was not uploaded.</div>";
            } else {
                if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
                    echo "<div class='alert alert-success'>The file ". htmlspecialchars(basename($_FILES['photo']['name'])). " has been uploaded.</div>";
                } else {
                    echo "<div class='alert alert-danger'>There was an error uploading your file.</div>";
                }
            }

            if ($uploadOk == 1)
            {// Insert user into database
            $user = $conn->real_escape_string($_POST['username']);
            $pass = md5($_POST['password']); // Hash the password with MD5
            $photo = basename($_FILES['photo']['name']); // Store the photo filename

            $stmt = $conn->prepare("INSERT INTO users (username, password, photo) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $user, $pass, $photo);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>Registration successful!</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: " . $stmt->error . "</div>";
            }

            $stmt->close();
            $conn->close();}
        }
        ?>

        <form method="post" action="" enctype="multipart/form-data">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" class="form-control" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="photo">Profile Photo:</label>
                <input type="file" class="form-control-file" id="photo" name="photo" accept="image/*" required>
            </div>
            <button type="submit" class="btn btn-primary">Register</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
</body>
</html>
