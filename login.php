<?php
session_start();
if (isset($_SESSION['message'])) {
    echo "<div class='alert alert-warning'>" . $_SESSION['message'] . "</div>";
    unset($_SESSION['message']);
}
?>

<!-- Login form code here -->
