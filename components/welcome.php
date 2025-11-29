<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}

if (isset($_GET["logout"])) {
    session_destroy();
    header("Location: login.php");
    exit;
}

$username = $_SESSION["username"] ?? "User";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome - Dashboard</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="login-card welcome-card">

        <div class="text-center mb-4">
            <h2>Hello, <span style="color: #667eea; font-weight: 700;"><?= htmlspecialchars($username) ?></span>!</h2>
            <p class="text-muted">You are now logged in successfully</p>
        </div>

        <div class="text-center mb-4">
            <div style="font-size: 60px; color: #56ab2f;">✅</div>
        </div>

        <div class="info-box">
            <p><strong>Email:</strong> <?= htmlspecialchars($_SESSION["email"] ?? "Not shown") ?></p>
            <p><strong>User ID:</strong> #<?= $_SESSION["user_id"] ?></p>
            <p><strong>Logged in at:</strong> <?= date("d M Y, h:i A") ?></p>
        </div>

        <div class="mt-4">
            <a href="?logout=true" class="btn btn-danger w-100">Logout</a>
        </div>
        <br>
        <p class="mt-3 text-center text-muted small">
            Thanks for using our app! 
        </p>
    </div>
</div>

</body>
</html>
