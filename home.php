<?php
session_start();

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="home.css">
</head>
<body>
<div class="navbar">
    <a href="home.php">Home</a>
    <a href="about.php">About Us</a>
    <a href="contact.php">Contact Us</a>
    <a href="listofservices.php">Services</a>
    <a href="update_profile.php">
        <button id="update-profile-btn">Update Profile</button>
    </a>
    <form action="logout.php" method="POST">
        <button type="submit" id="logout-btn">Logout</button>
    </form>
</div>

<section class="hero">
    <h1>Welcome to Our Website, Boss <?php echo $_SESSION['username']; ?>!</h1>
    <p></p>
    <a href="test.php" class="btn get-started">Get Started</a>
</section>
<br></br>
<br></br>
<br></br>
<br></br>

<br></br>
<br></br>
    
<footer>
    <p>&copy; 2024 Davidson's Barber Shop. All rights reserved.</p>
</footer>
</body>
</html>
