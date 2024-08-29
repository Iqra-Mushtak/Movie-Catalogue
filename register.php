<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = ""; // Change this if you have a different password
$dbname = "iqra";

// Create a connection to the database
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Create the users table if it doesn't exist
$tableQuery = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    email VARCHAR(100) NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$conn->query($tableQuery);

// Initialize message variable
$success_message = "";

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and validate the form data
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($username) || empty($email) || empty($password)) {
        echo "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Invalid email format.";
    } elseif (strlen($password) < 6) {
        echo "Password must be at least 6 characters long.";
    } else {
        // Hash the password before storing it
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare and bind the SQL statement
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful, redirect to login page
            header("Location: login.html");
            exit(); // Ensure no further code is executed after redirect
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }
}

// Close the connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CINEFY Register</title>
  <!-- Link to CSS -->
  <!-- <link rel="stylesheet" href="./style1.css" /> -->
  <!-- Fav Icon -->
  <link rel="shortcut icon" href="logo3.png" type="image/x-icon" />
  <!-- Box Icons -->
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet" />
  <style>
    /* Google Fonts */
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap");

* {
  font-family: "Poppins", sans-serif;
  margin: 0;
  padding: 0;
  scroll-behavior: smooth;
  box-sizing: border-box;
  scroll-padding-top: 2rem;
}

/* Variables */
:root {
  --main-color: #ffb43a;
  --hover-color: hsl(37, 94%, 57);
  --body-color: #1e1e2a;
  --container-color: #2d2e37;
  --text-color: #fcfeff;
}
/* Custom Scroll Bar */
html::-webkit-scrollbar {
  width: 0.3rem;
  background: transparent;
}
html::-webkit-scrollbar-thumb {
  background: var(--main-color);
}
/* Selection Color */
::selection {
  background: var(--main-color);
  color: var(--text-color);
}

a {
  text-decoration: none;
}

li {
  list-style: none;
}

section {
  padding: 3rem 0 2rem;
}
img {
  width: 100%;
}

.bx {
  cursor: pointer;
}

body {
  background: var(--body-color);
  color: var(--text-color);
}

.container {
  max-width: 1060px;
  margin: auto;
  width: 100%;
}
header {
  position: fixed;
  top: 0;
  left: 0;
  width: 100%;
  background: var(--body-color);
  z-index: 100;
}
/* login */
.wrapper{
  display: flex;
  justify-content: center;
  margin-top: 100px;
  background: var(--body-color);
  color: var(--main-color);
  width: 420px;
  margin-left: auto;
  margin-right: auto;
}
.wrapper h1{
  font-size: 36px;
  text-align: center;
  margin-top: 15px;
}
.wrapper .input-box{
  position: relative;
  width: 100%;
  height: 50px;
  margin: 30px 0;
}
.input-box input{
  width: 100%;
  height: 100%;
  background: transparent;
  border: none;
  outline: none;
  border: 2px solid rgba(255, 255, 255, .2);
  border-radius: 40px;
  font-size: 16px;
  color: var(--text-color);
  padding: 20px 45px 20px 20px;
}
.input-box i{
  position: absolute;
  right: 20px;
  top: 30%;
  transform: translate(-50);
  font-size: 20px;
}
.wrapper .remember-forgot{
  display: flex;
  justify-content: space-between;
  font-size: 14.5px;
  margin: -15px 0 15px;
}
.remember-forgot label input{
  accent-color: var(--main-color);
  margin-right: 3px;
}
.remember-forgot a{
  color: var(--main-color);
  text-decoration: none;
}
.remember-forgot a:hover{
  text-decoration: underline;
}
.wrapper .btn{
  width: 100%;
  height: 45px;
  background: var(--main-color);
  border: none;
  border-radius: 40px;
  box-shadow: 0 0 10px rgba(0 0 0 .1);
  cursor: pointer;
  font-size: 16px;
  color: var(--container-color);
  font-weight: 600;
}
.wrapper .btn:active{
  background: var(--container-color);
  color: var(--main-color);
}
.wrapper .register-link{
  font-size: 14.5px;
  text-align: center;
  margin: 20px 0 15px;
}
.register-link p a{
  color: var(--text-color);
  text-decoration: none;
  font-weight: 600;
}
.register-link p a:hover{
  text-decoration: underline;
}
/* Nav */
.nav {
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 20px 0;
}

/* Logo */
.logo {
  font-size: 1.4rem;
  color: var(--text-color);
  font-weight: 600;
  text-transform: uppercase;
  margin: 0 auto 0 0;
}
.logo span {
  color: var(--main-color);
}

/* Search Box */
.search-box {
  max-width: 240px;
  width: 100%;
  display: flex;
  align-items: center;
  column-gap: 0.7rem;
  padding: 8px 15px;
  background: var(--container-color);
  border-radius: 4rem;
  margin-right: 1rem;
}

.search-box .bx {
  font-size: 1.1rem;
}

.search-box .bx:hover {
  color: var(--main-color);
}

#search-input {
  width: 100%;
  border: none;
  outline: none;
  color: var(--text-color);
  background: transparent;
  font-size: 0.938rem;
}

/* User */
.user {
  display: flex;
}

.user-img {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  object-fit: cover;
  object-position: center;
}

/* Navbar */
.navbar {
  position: fixed;
  top: 50%;
  transform: translateY(-50%);
  left: 18px;
  display: flex;
  flex-direction: column;
  row-gap: 2.1rem;
}

.nav-link {
  display: flex;
  flex-direction: column;
  align-items: center;
  color: #b7b7b7;
}

.nav-link:hover,
.nav-active {
  color: var(--text-color);
  transition: 0.3s all linear;
  transform: scale(1.1);
}

.nav-link .bx {
  font-size: 1.6rem;
}

.nav-link-title {
  font-size: 0.7rem;
}

/* Home */
.home {
  position: relative;
  min-height: 500px;
  display: flex;
  align-items: center;
  margin-top: 5rem !important;
  border-radius: 0.5rem;
}

.home-img {
  position: absolute;
  height: 100%;
  width: 100%;
  z-index: -1;
  object-fit: cover;
  border-radius: 0.5rem;
}

.home-text {
  padding-left: 25px;
}

.home-title {
  font-size: 2rem;
  font-weight: 600;
}

.home-text p {
  font-size: 0.938rem;
  margin: 10px 0 20px;
  color: var(--main-color);
}

.watch-btn {
  display: flex;
  align-items: center;
  column-gap: 0.8rem;
  color: var(--text-color);
}

.watch-btn .bx {
  font-size: 21px;
  background: var(--main-color);
  height: 40px;
  width: 40px;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.watch-btn .bx:hover {
  background: var(--hover-color);
}

.watch-btn span {
  font-size: 1rem;
  font-weight: 400;
}

/* heading */
.heading {
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: var(--container-color);
  padding: 8px 14px;
  border: 1px solid hsl(200 100% 99% /5%);
  margin-bottom: 2rem;
}

.heading-title {
  font-size: 1.2rem;
  font: 500;
}

.movie-box {
  position: relative;
  width: 100%;
  height: 380px;
  overflow: hidden;
}
.movie-box-img {
  width: 100%;
  height: 100%;
  object-fit: cover;
}

.movie-box .box-text {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 14px;
  background: linear-gradient(
    8deg,
    hsl(240 17% 14% / 74%) 14%,
    hsl(240 17% 14% / 14%) 44%
  );
  overflow: hidden;
}
.movie-title {
  font-size: 1.1rem;
  font-weight: 500;
}
.movie-type {
  font-size: 0.938rem;
  font-weight: 500;
}

.play-btn {
  position: absolute;
  bottom: 0.8rem;
  right: 0.8rem;
}
/* Swiper Buttons */
.swiper-btn {
  display: flex;
}
.swiper-button-next,
.swiper-button-prev {
  position: static !important;
  margin: 0 0 0 10px !important;
}

.swiper-button-next::after,
.swiper-button-prev::after {
  color: var(--text-color);
  font-size: 18px !important;
  font-weight: 700;
}

.movies .heading {
  padding: 10px 14px;
}
.movies-content {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(247px, 1fr));
  gap: 1.5rem;
}
.movies-content .movie-box:hover .movie-box-img {
  transform: scale(1.1);
  transition: 0.5s;
}
.next-page {
  display: flex;
  align-items: center;
  justify-content: center;
  margin-top: 2.5rem;
}

.next-btn {
  background: var(--main-color);
  padding: 12px 20px;
  color: var(--text-color);
  font-weight: 500;
}

.next-btn:hover {
  background: var(--hover-color);
  transition: 0.3s all linear;
}

/* Copyright */
.copyright {
  text-align: center;
  padding: 20px;
}
.play-container {
  position: relative;
  min-height: 540px;
  margin-top: 5rem !important;
}
.play-img {
  position: absolute;
  width: 100%;
  height: 100%;
  object-fit: cover;
  object-position: center;
  z-index: -1;
}
.play-text {
  position: absolute;
  bottom: 0;
  left: 0;
  width: 100%;
  height: 100%;
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 40px;
  background: linear-gradient(
    8deg,
    hsl(240 17% 14% / 74%) 14%,
    hsl(240 17% 14% / 14%) 44%
  );
}
.play-text h2 {
  font-size: 1.5rem;
  font-weight: 600;
}
.rating {
  display: flex;
  align-items: center;
  column-gap: 2px;
  font-size: 1.1rem;
  color: var(--main-color);
  margin-top: 4px;
}
.tags {
  display: flex;
  align-items: center;
  column-gap: 8px;
  margin: 1rem 0;
}
.tags span {
  background: var(--container-color);
  padding: 0 4px;
}
.play-movie {
  position: absolute;
  bottom: 18rem;
  right: 10rem;
  display: flex !important;
  align-items: center;
  justify-content: center;
  width: 45px;
  height: 45px;
  border-radius: 50%;
  background: var(--main-color);
  font-size: 24px;
  animation: animate 1s linear infinite;
}
@keyframes animate {
  0% {
    box-shadow: 0 0 0 0 rgb(255, 180, 58, 0.7);
  }
  40% {
    box-shadow: 0 0 0 50 rgb(255, 193, 7, 0);
  }
  80% {
    box-shadow: 0 0 0 50px rgb(255, 193, 7, 0);
  }
  100% {
    box-shadow: 0 0 0 rgb(255, 193, 7, 0);
  }
}
/* Video Container */
.video-container {
  position: fixed;
  top: 0;
  left: 0;
  display: none;
  align-items: center;
  justify-content: center;
  width: 100%;
  height: 100%;
  background: hsl(234 10% 20% / 60%);
  z-index: 400;
}
.video-container.show-video {
  display: flex;
}

.video-box {
  position: relative;
  width: 82%;
}
.video-box #myvideo {
  width: 100%;
  aspect-ratio: 16/9;
}
.close-video {
  position: absolute;
  top: -1rem;
  right: 0;
  font-size: 40px;
  color: var(--main-color);
}

/* About Movie */
.about-movie {
  margin-top: 2rem !important;
}

.about-movie h2 {
  font-size: 1.4rem;
  font-weight: 600;
  color: var(--main-color);
}
.about-movie p {
  max-width: 600px;
  font-size: 0.938rem;
  margin: 10px 0;
}
/* Cast */
.cast-heading {
  font-size: 1.2rem;
  font-weight: 600;
  margin-bottom: 1rem;
  color: var(--main-color);
}
.cast {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(150px, 150px));
  gap: 1rem;
}
.cast-img {
  width: 150px;
  height: 180px;
  object-fit: cover;
  object-position: center;
}
/* Dowmload */
.download {
  max-width: 800px;
  width: 100%;
  margin: auto;
  display: grid;
  justify-content: center;
  margin-top: 2rem;
}
.download-title {
  text-align: center;
  font-size: 1.4rem;
  font-weight: 500;
  margin: 1.6rem 0;
  color: var(--main-color);
}
.download-links {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 10px;
  margin-bottom: 2rem;
}
.download-links a {
  text-align: center;
  background: var(--main-color);
  padding: 12px 24px;
  color: var(--body-color);
  letter-spacing: 1px;
  font-weight: 500;
}
.download-links a:hover {
  background: var(--hover-color);
  color: var(--main-color);
}

/* Responsive */
@media (max-width: 1170px) {
  .navbar {
    bottom: 0;
    left: 0;
    right: 0;
    top: auto;
    transform: translateY(0);
    flex-direction: row;
    justify-content: space-evenly;
    row-gap: 1px;
    padding: 10px;
    border-top: 1px solid hsl(200 100% 99% / 5%);
    background: linear-gradient(
      8deg,
      hsl(240 17% 14% / 100%) 5%,
      hsl(240 17% 14% /90%) 100%
    );
  }

  .nav-link .bx {
    font-size: 1.5rem;
  }
  .copyright {
    margin-bottom: 4rem;
  }
}

@media (max-width: 1060px) {
  .container {
    margin: 0 auto;
    width: 95%;
  }
}

@media (max-width: 991px) {
  .movie-box {
    height: 340px;
  }
  .movies-content {
    grid-template-columns: repeat(auto-fit, minmax(214px, 1fr));
  }
}

@media (max-width: 888px) {
  .nav {
    padding: 14px 0;
  }
  .home {
    min-height: 440px;
    margin-top: 4rem !important;
  }
  .home-text {
    padding-left: 25px;
  }
  .home-title {
    font-size: 1.6rem;
  }
  .watch-btn span {
    font-size: 0.9rem;
  }
  .movie-title {
    font-size: 1rem;
    padding-right: 30px;
  }
  .play-container {
    min-height: 440px;
    margin-top: 4rem !important;
  }
  .play-movie {
    bottom: 14rem;
    right: 4rem;
  }
  .cast {
    justify-content: center;
  }
}

/* For Medium Devices */
@media (max-width: 768px) {
  .nav {
    padding: 11px 0;
  }
  .logo {
    font-size: 1.2rem;
  }
  .section {
    padding: 2rem 0;
  }
  .home-img {
    object-position: left;
  }
  .movie-type {
    font-size: 0.875rem;
    margin-top: 2px;
  }
  .tags span,
  .about-movie p {
    font-size: 0.875rem;
  }
  p {
    font-size: 0.875rem;
  }
  .play-text h2,
  .about-movie h2 {
    font-size: 1.3rem;
  }
  .play-movie {
    bottom: 10rem;
    right: 2rem;
  }
}
@media (max-width: 514px) {
  .home {
    min-height: 380px;
  }
  .heading {
    padding: 2px;
  }
  .heading-title {
    font-size: 1rem;
  }
  .play-text {
    padding: 20px;
  }
  .play-movie {
    bottom: 4rem;
  }
  .video-box {
    width: 94%;
  }
  .cast-heading {
    font-size: 1.1rem;
  }
  .cast-title {
    font-size: 0.9rem;
  }
}
@media (max-width: 408px) {
  * {
    scroll-padding-top: 5rem;
  }
  .nav {
    display: grid;
    grid-template-columns: 1fr;
    grid-template-rows: 1fr 1fr;
    row-gap: 5px;
  }
  .search-box {
    max-width: 100%;
    width: 100%;
    border-radius: 4px;
    order: 3;
    grid-column-start: 1;
    grid-column-end: 3;
  }
  .home,
  .play-container {
    margin-top: 7rem !important;
  }
  .movie-box {
    height: 300px;
  }
  .movies-content {
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: 1rem;
  }
}
/* For Small Devices */
@media (max-width: 370px) {
  .home {
    min-height: 300px;
  }
  .movie-box {
    height: 285px;
  }
  .user-img,
  .watch-btn .bx {
    width: 35px;
    height: 35px;
  }
  .navbar {
    justify-content: space-around;
    padding: 8px 0;
  }
  .nav-link .bx {
    font-size: 1.4rem;
  }
  .about-movie p {
    text-align: justify;
  }
  .download-links {
    grid-template-columns: 1fr;
  }
}

  </style>
</head>

<body>
  <!-- Header -->
  <header>
    <div class="nav container">
      <a href="#" class="logo"> Cine<span>fy</span> </a>
      <a href="#" class="user">
        <img src="logo3.png" alt="" class="user-img" />
      </a>
    </div>
  </header>

  <div class="wrapper">
    <form action="register.php" method="POST">
      <h1>Register</h1>
      <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
      <?php endif; ?>
      <div class="input-box">
        <input type="text" placeholder="Username" id="username" name="username" required>
        <i class='bx bxs-user'></i>
      </div>
      <div class="input-box">
        <input type="email" placeholder="Email" id="email" name="email" required>
        <i class='bx bxs-envelope'></i>
      </div>
      <div class="input-box">
        <input type="password" placeholder="Password" id="password" name="password" required>
        <i class='bx bxs-lock-alt'></i>
      </div>

      <div class="remember-forgot">
        <label><input type="checkbox">Remember Me</label>
      </div>

      <button type="submit" class="btn">Register</button>

      <div class="register-link">
        <p>Already have an account? <a href="login.html">Login</a></p>
      </div>
    </form>
  </div>
  
  <div class="copyright">
    <p>&#169; CINEFY All rights reserved</p>
  </div>
  
  <script src="js/swiper-bundle.min.js"></script>
  <script src="js/movie.js"></script>
</body>

</html>
