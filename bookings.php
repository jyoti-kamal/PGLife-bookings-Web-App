<?php
session_start();
require "includes/database_connect.php";

$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL;
$property_id = $_GET["property_id"];

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
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Booking | <?= htmlspecialchars($property['property_name']); ?> | PG Life</title>
    <?php include "includes/head_links.php"; ?>
    <link href="css/bookings.css" rel="stylesheet" />
</head>

<body>
    <?php include "includes/header.php"; ?>

    <div class="booking-page container">
        <h1>Book Your Stay</h1>
        <div class="property-details">
            <div class="property-info">
                <h2><?= htmlspecialchars($property['property_name']); ?></h2>
                <p><strong>Address:</strong> <?= htmlspecialchars($property['address']); ?></p>
                <p><strong>Rent:</strong> ₹ <?= number_format($property['rent']); ?> /- per month</p>
            </div>
        </div>

        <div class="checkout-section">
            <h3>Checkout</h3>
            <form action="confirm_bookings.php" method="post">
                <input type="hidden" name="property_id" value="<?= htmlspecialchars($property['property_id']); ?>">
                <input type="hidden" name="user_id" value="<?= htmlspecialchars($user_id); ?>">
                
                <div class="form-group">
                    <label for="start_date">Check-in Date</label>
                    <input type="date" id="start_date" name="start_date" required onchange="updateEndDate()">
                </div>
                
                <div class="form-group">
                    <label for="end_date">Check-out Date</label>
                    <input type="text" id="end_date" name="end_date" readonly>
                </div>

                <div class="form-group">
                    <label for="total_amount">Total Amount</label>
                    <input type="text" id="total_amount" name="total_amount" value="₹ <?= number_format($property['rent']); ?>" readonly>
                </div>

                <h3>Payment Details</h3>

                <div class="form-group">
                    <label for="card_number">Card Number</label>
                    <input type="text" id="card_number" name="card_number" placeholder="Enter your card number" required>
                </div>

                <div class="form-group">
                    <label for="expiry_date">Expiry Date</label>
                    <input type="text" id="expiry_date" name="expiry_date" placeholder="MM/YY" required>
                </div>

                <div class="form-group">
                    <label for="cvv">CVV</label>
                    <input type="text" id="cvv" name="cvv" placeholder="CVV" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Proceed to Pay</button>
            </form>
        </div>
    </div>

    <?php include "includes/footer.php"; ?>

    <script>
        function updateEndDate() {
            const startDate = document.getElementById('start_date').value;
            const endDateInput = document.getElementById('end_date');
            
            if (startDate) {
                const startDateObj = new Date(startDate);
                const endDateObj = new Date(startDateObj);
                endDateObj.setMonth(endDateObj.getMonth() + 1);
                
                const year = endDateObj.getFullYear();
                const month = String(endDateObj.getMonth() + 1).padStart(2, '0');
                const day = String(endDateObj.getDate()).padStart(2, '0');
                
                const formattedEndDate = `${month}-${day}-${year}`;
                endDateInput.value = formattedEndDate;
            } else {
                endDateInput.value = '';
            }
        }
    </script>
</body>

</html>
