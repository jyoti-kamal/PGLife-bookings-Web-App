<?php
session_start();

// Mock processing time
sleep(2); // Simulates processing delay

// Assuming the payment is successful
$property_id = $_POST['property_id'];
$user_id = $_POST['user_id'];
$start_date = $_POST['start_date'];
$end_date = $_POST['end_date'];
$total_amount = $_POST['total_amount'];

header("Location: booking_confirmation.php?property_id=$property_id&user_id=$user_id&start_date=$start_date&end_date=$end_date&amount=$total_amount");
exit();
?>

