<?php
$totalCost = isset($_POST['totalCost']) ? $_POST['totalCost'] : 0;
$remitAmount = isset($_POST['remitAmount']) ? $_POST['remitAmount'] : 0;

// Get the services from the URL
$services = isset($_GET['services']) ? $_GET['services'] : '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['remitAmount'])) {
    if ($remitAmount == number_format($totalCost * 0.30, 2)) {
        $message = "Remit successful! Thank you for the payment.";
    } else {
        $message = "Error: The remit amount must be equal to 30% of the total cost.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="remit.css">
    <link rel="shortcut icon" href="favicon.svg" type="image/svg+xml">
    <title>Remit Payment</title>
</head>
<body>
    <div class="content-box">
        <h1>Remit Payment</h1>
        <?php if ($services): ?>
            <p>Selected Services: <?php echo htmlspecialchars($services); ?></p>
        <?php endif; ?>
        <p>Total Cost: $<?php echo $totalCost; ?></p>
        <p>30% Remit Amount: $<?php echo number_format($totalCost * 0.30, 2); ?></p>
        <?php if (isset($message)) echo "<p>$message</p>"; ?>
    </div>
    <form action="logout.php" method="GET">
        <button type="submit">Logout</button>
    </form>
</body>
</html>
