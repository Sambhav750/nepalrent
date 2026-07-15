<?php
include 'config/db_connect.php';

// Get total cars
$total_cars = $conn->query("SELECT COUNT(*) FROM cars")->fetch_row()[0];
$available_cars = $conn->query("SELECT COUNT(*) FROM cars WHERE Availability_Status='Available'")->fetch_row()[0];

// Get total bookings
$total_bookings = $conn->query("SELECT COUNT(*) FROM bookings")->fetch_row()[0];

echo "<h1>NepalRent Quick Stats</h1>";
echo "<p>Total Cars: <strong>$total_cars</strong></p>";
echo "<p>Available Cars: <strong>$available_cars</strong></p>";
echo "<p>Total Bookings: <strong>$total_bookings</strong></p>";

$conn->close();
?>