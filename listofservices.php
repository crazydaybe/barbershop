<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Services</title>
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="listofservices.css">
</head>
<body>
    <div class="navbar">
        <a href="home.php">Home</a>
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact Us</a>
        <a href="listofservices.php">Services</a>
    </div>

    <a href="update_profile.php">
        <button id="update-profile-btn">Update Profile</button>
    </a>

    <form action="logout.php" method="POST" style="display:inline;">
        <button type="submit" id="logout-btn">Logout</button>
    </form>

    <section class="hero">
        <h1>Our Services</h1>
        <p>.</p>
    </section>

    <section class="content">
        <h2>What We Offer</h2>
        <div class="service-list">
            <div class="service-item">
                <h3>Haircut</h3>
                <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Aut provident deserunt soluta odio! Earum natus magni assumenda ex optio nesciunt in? Id magni aliquam doloribus, blanditiis sint ullam suscipit quod!</p>
            </div>
            <div class="service-item">
                <h3>Hair Color</h3>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Corporis adipisci voluptas laborum nobis facere iure veniam nam? Maiores doloremque qui inventore laborum fuga ipsa, ratione debitis, dicta, dolorem mollitia quos!</p>
            </div>
            <div class="service-item">
                <h3>Beard Trim</h3>
                <p>Lorem ipsum dolor sit amet consectetur, adipisicing elit. Culpa nulla suscipit, ipsam rerum quasi accusantium porro in perferendis expedita ratione, voluptates temporibus dolores molestias consectetur laudantium provident distinctio veritatis! Doloremque?</p>
            </div>
            <div class="service-item">
                <h3>lorem</h3>
                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Modi necessitatibus debitis accusantium eius possimus qui esse aperiam ipsam, soluta tenetur. Molestiae, excepturi. Doloribus odio perspiciatis velit, cum quam qui non?</p>
            </div>
        </div>
    </section>

    <footer>
        <p>&copy; 2024 Davidson's Barber Shop. All rights reserved.</p>
    </footer>
</body>
</html>
