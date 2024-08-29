<?php
session_start();

if (isset($_SESSION['login_message'])) {
    echo "<script>alert('" . $_SESSION['login_message'] . "');</script>";
    unset($_SESSION['login_message']); // Clear the message after displaying it
}

// Continue with your page content here
?>

<!-- Your HTML content -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
</head>
<body>
    <h1>Welcome, <?php echo $_SESSION['username']; ?>!</h1>
    <!-- Other content -->
</body>
</html>
