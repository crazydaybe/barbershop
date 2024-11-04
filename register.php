<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $password = $confirmPassword = $email = $gender = $dateOfBirth = "";
$usernameErr = $passwordErr = $confirmPasswordErr = $emailErr = $genderErr = $dateOfBirthErr = "";
$successMessage = $errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"])) {
        $usernameErr = "Username is required.";
    } else {
        $username = trim($_POST["username"]);
    }

    if (empty($_POST["email"])) {
        $emailErr = "Email is required.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $emailErr = "Invalid email format.";
        }
    }

    if (empty($_POST["gender"])) {
        $genderErr = "Gender is required.";
    } else {
        $gender = $_POST["gender"];
    }

    if (empty($_POST["dateOfBirth"])) {
        $dateOfBirthErr = "Date of birth is required.";
    } else {
        $dateOfBirth = $_POST["dateOfBirth"];
    }

    if (empty($_POST["password"])) {
        $passwordErr = "Password is required.";
    } else {
        $password = $_POST["password"];
        if (strlen($password) < 6) {
            $passwordErr = "Password must be at least 6 characters.";
        }
    }

    if (empty($_POST["confirmPassword"])) {
        $confirmPasswordErr = "Confirm password is required.";
    } else {
        $confirmPassword = $_POST["confirmPassword"];
        if ($password !== $confirmPassword) {
            $confirmPasswordErr = "Passwords do not match.";
        }
    }

    if (empty($usernameErr) && empty($passwordErr) && empty($confirmPasswordErr) && empty($emailErr) && empty($genderErr) && empty($dateOfBirthErr)) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO users (username, password, email, gender, date_of_birth) VALUES (?, ?, ?, ?, ?)";
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssss", $username, $hashedPassword, $email, $gender, $dateOfBirth);
            if ($stmt->execute()) {
                $successMessage = "Registration successful!";
            } else {
                $errorMessage = "Error: " . $stmt->error;
            }
            $stmt->close();
        } else {
            $errorMessage = "Error preparing the SQL query.";
        }
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml">
    <link rel="stylesheet" href="register.css">
    <title>Registration Form</title>
</head>
<body>

    <div class="form-container">
        <h2>Register</h2>

        <?php if ($successMessage): ?>
            <div class="success"><?php echo $successMessage; ?></div>
        <?php endif; ?>

        <?php if ($errorMessage): ?>
            <div class="error"><?php echo $errorMessage; ?></div>
        <?php endif; ?>

        <form action="register.php" method="POST">
            <div>
                <input type="text" name="username" placeholder="Username" value="<?php echo htmlspecialchars($username); ?>">
                <span class="error"><?php echo $usernameErr; ?></span>
            </div>
            <div>
                <input type="email" name="email" placeholder="Email" value="<?php echo htmlspecialchars($email); ?>">
                <span class="error"><?php echo $emailErr; ?></span>
            </div>
            <div>
                <label for="gender">Gender:</label>
                <select name="gender">
                    <option value="">Select</option>
                    <option value="male" <?php if ($gender === 'male') echo 'selected'; ?>>Male</option>
                    <option value="female" <?php if ($gender === 'female') echo 'selected'; ?>>Female</option>
                    <option value="other" <?php if ($gender === 'other') echo 'selected'; ?>>Other</option>
                </select>
                <span class="error"><?php echo $genderErr; ?></span>
            </div>
            <div>
                <input type="date" name="dateOfBirth" value="<?php echo htmlspecialchars($dateOfBirth); ?>">
                <span class="error"><?php echo $dateOfBirthErr; ?></span>
            </div>
            <div>
                <input type="password" name="password" placeholder="Password">
                <span class="error"><?php echo $passwordErr; ?></span>
            </div>
            <div>
                <input type="password" name="confirmPassword" placeholder="Confirm Password">
                <span class="error"><?php echo $confirmPasswordErr; ?></span>
            </div>
            <div>
                <input type="submit" value="Register">
            </div>
        </form>

        <a href="index.php" class="login-link">Already Registered? Login here</a>
    </div>

</body>
</html>
