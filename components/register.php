<?php
session_start();           // Must be first!
include "db.php";

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email    = trim($_POST["email"]);
    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    if (empty($email) || empty($username) || empty($password)) {
        $message = "<div class='alert alert-danger'>All fields are required!</div>";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "<div class='alert alert-danger'>Invalid email format!</div>";
    } elseif (strlen($password) < 6) {
        $message = "<div class='alert alert-danger'>Password must be at least 6 characters!</div>";
    } else {
        // Check if email already exists
        $check = $conn->prepare("SELECT id FROM users WHERE email = ?");
        $check->bind_param("s", $email);
        $check->execute();
        $check->store_result();

        if ($check->num_rows > 0) {
            $message = "<div class='alert alert-danger'>This email is already registered!</div>";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $conn->prepare("INSERT INTO users (email, username, password_hash) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $email, $username, $hash);

            if ($stmt->execute()) {
                $message = "<div class='alert alert-success'>Account created successfully! <a href='login.php'>Click here to login</a></div>";
            } else {
                $message = "<div class='alert alert-danger'>Registration failed. Please try again.</div>";
            }
            $stmt->close();
        }
        $check->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Account</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="login-card"> <!-- Reusing the same card class for consistency -->

        <h2>Create Your Account</h2>

        <?= $message ?>

        <form method="POST">
            <input style="margin-bottom: 10px;" type="email" name="email" class="form-control" placeholder="Email address" required autofocus>
            <input style="margin-bottom: 10px;" type="text" name="username" class="form-control" placeholder="Choose a username" required minlength="3" maxlength="20">
            <input style="margin-bottom: 10px;" type="password" name="password" class="form-control" placeholder="Create a strong password" required minlength="6">
            
            <button type="submit" class="btn btn-success">Register Now</button>
        </form>

        <p class="mt-2">Already have an account? <a href="login.php">Sign in here</a></p>
    </div>
</div>

</body>
</html>