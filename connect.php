<?php
session_start();

// Database connection (adjust with your own credentials)
$servername = "localhost";
$username = "root";
$password = ""; // Change this if you have a different password
$dbname = "iqra";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$username = $_POST['username'];
$password = $_POST['password'];

// Protect against SQL injection and SQL errors by using prepared statements
$sql = $conn->prepare("SELECT * FROM users WHERE username = ?");
$sql->bind_param("s", $username);
$sql->execute();
$result = $sql->get_result();

if ($result->num_rows > 0) {
    // Fetch the user data
    $user = $result->fetch_assoc();

    // Verify the password with the hashed password stored in the database
    if (password_verify($password, $user['password'])) {
        // Password is correct, login successful
        $_SESSION['username'] = $username;
        $_SESSION['login_message'] = "Successfully logged in!"; // Set success message
        header('Location: index1.html'); // Redirect to the home page (or another PHP page)
        exit(); // Ensure script stops executing after redirect
    } else {
        // Password is incorrect
        echo "<script>alert('Invalid username or password');</script>";
        echo "<script>window.location.href='login.html';</script>"; // Redirect back to login
        exit(); // Ensure script stops executing after redirect
    }
} else {
    // Username not found
    echo "<script>alert('Invalid username or password');</script>";
    echo "<script>window.location.href='login.html';</script>"; // Redirect back to login
    exit(); // Ensure script stops executing after redirect
}

$conn->close();
?>
