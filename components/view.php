<!-- <?php include "header.php"; ?> -->
 
<?php
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit;
}
?>
 
<h1>Welcome to the Dashboard</h1>
<p>You have successfully logged in.</p>
 
</div>
</body>
</html>