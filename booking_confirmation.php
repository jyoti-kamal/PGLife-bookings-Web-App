<?php
session_start();
require "includes/database_connect.php";

$property_id = $_GET['property_id'];
$user_id = $_GET['user_id'];
$start_date = $_GET['start_date'];
$end_date = $_GET['end_date'];
$amount = $_GET['amount'];

$sql_1 = "SELECT *, p.id AS property_id, p.name AS property_name, c.name AS city_name 
            FROM properties p
            INNER JOIN cities c ON p.city_id = c.id 
            WHERE p.id = $property_id";
$result_1 = mysqli_query($conn, $sql_1);
if (!$result_1) {
    echo "Something went wrong!";
    return;
}
$property = mysqli_fetch_assoc($result_1);
if (!$property) {
    echo "Something went wrong!";
    return;
}

$sql_2 = "SELECT * FROM users WHERE id = $user_id";
$result_2 = mysqli_query($conn, $sql_2);
if (!$result_2) {
    echo "Something went wrong!";
    return;
}
$user = mysqli_fetch_assoc($result_2);
if (!$user) {
    echo "Something went wrong!";
    return;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking Confirmed | PG Life</title>
    <?php include "includes/head_links.php"; ?>
    <link href="css/bookings.css" rel="stylesheet" />
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div class="confirmation-page container">
        <h1>Booking Confirmed!</h1>
        <p>Thank you, <?= htmlspecialchars($user['full_name']); ?>. Your booking has been confirmed.</p>
        <div class="booking-details">
            <h2>Booking Details</h2>
            <p><strong>Property:</strong> <?= htmlspecialchars($property['property_name']); ?></p>
            <p><strong>Address:</strong> <?= htmlspecialchars($property['address']); ?></p>
            <p><strong>Check-in Date:</strong> <?= htmlspecialchars($start_date); ?></p>
            <p><strong>Check-out Date:</strong> <?= htmlspecialchars($end_date); ?></p>
            <p><strong>Total Amount:</strong> ₹ <?= htmlspecialchars($amount); ?></p>
        </div>
        <p class="thanks-message">We look forward to your stay!</p>
    </div>

    <?php include "includes/footer.php"; ?>
</body>

</html>
