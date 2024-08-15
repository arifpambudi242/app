<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DNS Lookup Tool</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h1 {
            color: #333;
        }
        form {
            margin-bottom: 20px;
        }
        input[type="text"] {
            width: calc(100% - 20px);
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 20px;
            font-size: 16px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .result {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 5px;
            font-family: monospace;
        }
        pre {
            white-space: pre-wrap;
            word-wrap: break-word;
        }
    </style>
</head>
<body>

<div class="container">
    <h1>DNS Lookup Tool</h1>
    <form method="GET">
        <input type="text" name="domain" placeholder="Enter domain (e.g., example.com)" required>
        <input type="submit" value="Lookup">
    </form>

    <?php
    if (isset($_GET['domain'])) {
        // Ambil input dari pengguna
        $domain = $_GET['domain'];

        // Jalankan perintah dig tanpa sanitasi
        $output = shell_exec("dig " . $domain);

        // Tampilkan hasil
        echo "<div class='result'><h2>Results for: " . htmlspecialchars($domain) . "</h2><pre>$output</pre></div>";
    }
    ?>
</div>

</body>
</html>
