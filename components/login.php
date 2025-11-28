<?php
session_start();                
include "db.php";               

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    $stmt = $conn->prepare("SELECT id, username, password_hash FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $row = $result->fetch_assoc()) {
        if (password_verify($password, $row["password_hash"])) {
            $_SESSION["user_id"] = $row["id"];
            $_SESSION["username"] = $row["username"];
            $_SESSION["email"] = $email;                    
            header("Location: welcome.php");
            exit;
        } else {
            $message = "<div class='alert alert-danger'>Incorrect Password!</div>";
        }
    } else {
        $message = "<div class='alert alert-danger'>No account found with this email!</div>";
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<div class="container">
    <div class="login-card">
        <h2>Welcome Back</h2>

        <?= $message ?>

        <form method="POST">
            <input type="email" name="email" class="form-control" placeholder="Email address" required autofocus style="margin-bottom: 10px;">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
            <button type="submit" class="btn btn-success">Sign In</button>
        </form>

        <p class="mt-2">Don't have an account? <a href="register.php">Create one</a></p>
    </div>
</div>

</body>
</html>