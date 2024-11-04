<?php
$servername = "localhost";
$username = "root"; 
$password = ""; 
$dbname = "bshop"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$output = ""; 
$totalCost = 0; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $selectedServices = isset($_POST['selectedServices']) ? $_POST['selectedServices'] : '';
    $servicesArray = explode(',', $selectedServices);

    foreach ($servicesArray as $service) {
        $service = trim($service);

        $sql = "SELECT price FROM services WHERE service_name = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $service);
        $stmt->execute();
        $stmt->bind_result($price);
        $stmt->fetch();
        $stmt->close();

        if ($price !== null) {
            $updateSql = "INSERT INTO services (service_name, count, price) VALUES (?, 1, ?)
                ON DUPLICATE KEY UPDATE count = count + 1";

            if ($updateStmt = $conn->prepare($updateSql)) {
                $updateStmt->bind_param("sd", $service, $price);
                $updateStmt->execute();
                $updateStmt->close();

                $totalCost += $price;
                $output .= "Service '$service' was inserted/updated successfully with price: $$price.<br>";
            } else {
                $output .= "Error updating the database: " . $conn->error . "<br>";
            }
        } else {
            $output .= "Service '$service' not found.<br>";
        }
    }

    $output .= "Total cost for all services: $$totalCost.<br>";
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="selectedservices.css">
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml">
    <title>Services Submitted</title>
</head>
<body>
    <div class="content-box">
        <h1>Services Submitted</h1>
        <p>Your services have been recorded successfully!</p>
        <div class="output-messages">
            <?php echo $output; ?>
        </div>
        <form action="services_count.php" method="POST">
            <button type="submit">View Service Count and Total Cost</button>
        </form>
        <form action="selectservices.php" method="GET">
            <button type="submit">Go Back to Select Services</button>
        </form>
    </div>
</body>
</html>
