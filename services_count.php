<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bshop";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT service_name, count, price FROM services";
$result = $conn->query($sql);

$services = [];
$totalCost = 0;

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $services[] = $row;
        $totalCost += $row['count'] * $row['price'];
    }
} else {
    $services = [];
}

$selectedServices = isset($_POST['selectedServices']) ? $_POST['selectedServices'] : '';
$selectedServicesArray = !empty($selectedServices) ? explode(',', $selectedServices) : [];

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="selectedservices.css">
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml">
    <title>Service Count</title>
</head>
<body>
    <div class="content-box">
        <h1>Service Count</h1>
        <p>Here are the counts and prices for all submitted services:</p>
        
        <?php if (!empty($selectedServicesArray)): ?>
            <h2>Selected Services:</h2>
            <ul>
                <?php foreach ($selectedServicesArray as $service): ?>
                    <li><?php echo htmlspecialchars($service); ?></li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p>No services have been selected.</p>
        <?php endif; ?>

        <ul>
            <?php if (count($services) > 0): ?>
                <?php foreach ($services as $service): ?>
                    <li>
                        <strong><?php echo htmlspecialchars($service['service_name']); ?></strong>: 
                        <?php echo $service['count']; ?> times | 
                        Price per service: $<?php echo number_format($service['price'], 2); ?> | 
                        Total for this service: $<?php echo number_format($service['count'] * $service['price'], 2); ?>
                    </li>
                <?php endforeach; ?>
                <li><strong>Total cost of all services:</strong> $<?php echo number_format($totalCost, 2); ?></li>
            <?php else: ?>
                <li>No services have been submitted yet.</li>
            <?php endif; ?>
        </ul>
        
        <form action="remit.php" method="POST">
            <input type="hidden" name="totalCost" value="<?php echo $totalCost; ?>">
            <input type="hidden" name="remitAmount" value="<?php echo number_format($totalCost * 0.30, 2); ?>">
            <button type="submit">Remit</button>
        </form>

        <form action="selectservices.php" method="GET">
            <button type="submit">Go Back to Select Services</button>
        </form>
    </div>
</body>
</html>
