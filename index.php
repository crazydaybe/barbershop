<?php 
include("connection.php");

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['user'];
    $password = $_POST['pass'];

    if (empty($username) || empty($password)) {
        $errorMessage = "Username and Password are required!";
    } else {
        $query = "SELECT * FROM users WHERE username = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();

            if (password_verify($password, $user['password'])) {
                session_start();
                $_SESSION['username'] = $user['username'];
                $_SESSION['user_id'] = $user['id'];

                header("Location: test.php");
                exit();
            } else {
                $errorMessage = "Incorrect password!";
            }
        } else {
            $errorMessage = "Username not found!";
        }

        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="element"></div>
    <div id="form">
        <h1>Login</h1>

        <?php if ($errorMessage): ?>
            <div class="error-message"><?= $errorMessage; ?></div>
        <?php endif; ?>

        <form name="form" action="index.php" method="POST">
            <label>Username: </label>
            <input type="text" id="user" name="user" required></br></br>

            <label>Password: </label>
            <input type="password" id="pass" name="pass" required></br></br>

            <input type="submit" id="btn" value="Login" name="submit"/>
        </form>

        <br>
        <a href="register.php">
            <button type="button" id="create-account-btn">Create Account</button>
        </a>
    </div>

    <script>
        function isvalid(){
            var user = document.form.user.value;
            var pass = document.form.pass.value;
            if(user.length=="" && pass.length==""){
                alert("Please Input Username and Password");
                return false;
            }
            else if(user.length==""){
                alert("Username Required!!!");
                return false;
            }
            else if(pass.length==""){
                alert("Password Required!!!");
                return false;
            }
        }
    </script>
</body>
</html>
