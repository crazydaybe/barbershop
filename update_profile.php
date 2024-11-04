<?php
include("connection.php");

session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$errorMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['register'])) {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $date_of_birth = $_POST['dateofbirth'];
    $gender = $_POST['gender'];

    $query = "INSERT INTO users (username, password, email, date_of_birth, gender) VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $username, $password, $email, $date_of_birth, $gender);

    if ($stmt->execute()) {
        $successMessage = "User registered successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update'])) {
    $username = $_SESSION['username'];
    $newUsername = $_POST['username'] ?? $username;
    $password = $_POST['password'] ?? null;
    $confirmPassword = $_POST['confirmPassword'] ?? null;
    $email = $_POST['email'] ?? '';
    $date_of_birth = $_POST['dateofbirth'] ?? '';
    $gender = $_POST['gender'] ?? '';

    if ($password && $password !== $confirmPassword) {
        $errorMessage = "Passwords do not match!";
    } else {
        $updateFields = [];
        $params = [];
        $paramTypes = "";

        if ($newUsername !== $username) {
            $updateFields[] = "username = ?";
            $params[] = $newUsername;
            $paramTypes .= "s";
        }
        if ($password) {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $updateFields[] = "password = ?";
            $params[] = $hashedPassword;
            $paramTypes .= "s";
        }
        if ($email) {
            $updateFields[] = "email = ?";
            $params[] = $email;
            $paramTypes .= "s";
        }
        if ($date_of_birth) {
            $updateFields[] = "date_of_birth = ?";
            $params[] = $date_of_birth;
            $paramTypes .= "s";
        }
        if ($gender) {
            $updateFields[] = "gender = ?";
            $params[] = $gender;
            $paramTypes .= "s";
        }

        if (!empty($updateFields)) {
            $query = "UPDATE users SET " . implode(", ", $updateFields) . " WHERE username = ?";
            $params[] = $username;
            $paramTypes .= "s";

            $stmt = $conn->prepare($query);
            $stmt->bind_param($paramTypes, ...$params);

            if ($stmt->execute()) {
                $_SESSION['success_message'] = "Profile updated successfully!";
                header("Location: update_profile.php");
                exit();
            } else {
                $errorMessage = "Error updating profile: " . $stmt->error;
            }

            $stmt->close();
        } else {
            $errorMessage = "No fields to update.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete'])) {
    $usernameToDelete = $_POST['username'];

    $query = "DELETE FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $usernameToDelete);

    if ($stmt->execute()) {
        $successMessage = "User deleted successfully!";
    } else {
        $errorMessage = "Error: " . $stmt->error;
    }

    $stmt->close();
}

$query = "SELECT * FROM users";
$result = $conn->query($query);
$users = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
</head>
<body>

<div class="navbar">
    <a href="test.php">Home</a>
</div>

<section>
    <h1>Manage Users</h1>

    <?php if (!empty($errorMessage)): ?>
        <div class="error-message"><?= $errorMessage; ?></div>
    <?php endif; ?>
    
    <?php if (!empty($successMessage)): ?>
        <div class="success-message"><?= $successMessage; ?></div>
    <?php endif; ?>

    <h2>Register New User</h2>
    <form action="update_profile.php" method="POST">
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <input type="email" name="email" placeholder="Email" required>
        <input type="date" name="dateofbirth" placeholder="Date of Birth" required>
        <select name="gender">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
            <option value="prefer_not_to_say">Prefer not to say</option>
        </select>
        <button type="submit" name="register">Register User</button>
    </form>

    <h2>Update Profile</h2>
    <form action="update_profile.php" method="POST">
        <input type="text" name="username" placeholder="New Username (leave blank to keep)" value="<?= htmlspecialchars($_SESSION['username']); ?>">
        <input type="password" name="password" placeholder="New Password (leave blank to keep)">
        <input type="password" name="confirmPassword" placeholder="Confirm New Password">
        <input type="email" name="email" placeholder="Email" required>
        <input type="date" name="dateofbirth" placeholder="Date of Birth" required>
        <select name="gender">
            <option value="">Select Gender</option>
            <option value="male">Male</option>
            <option value="female">Female</option>
            <option value="other">Other</option>
            <option value="prefer_not_to_say">Prefer not to say</option>
        </select>
        <button type="submit" name="update">Update Profile</button>
    </form>

    <h2>Delete User</h2>
    <form action="update_profile.php" method="POST">
        <input type="text" name="username" placeholder="Username to delete" required>
        <button type="submit" name="delete">Delete User</button>
    </form>

    <h2>Current Users</h2>
    <table>
        <tr>
            <th>Username</th>
            <th>Email</th>
            <th>Date of Birth</th>
            <th>Gender</th>
        </tr>
        <?php foreach ($users as $user): ?>
        <tr>
            <td><?= htmlspecialchars($user['username']) ?></td>
            <td><?= htmlspecialchars($user['email']) ?></td>
            <td><?= htmlspecialchars($user['date_of_birth']) ?></td>
            <td><?= htmlspecialchars($user['gender']) ?></td>
        </tr>
        <?php endforeach; ?>
    </table>
</section>

</body>
</html>
