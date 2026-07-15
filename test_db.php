<?php
include 'config/db_connect.php';

echo "<h1>NepalRent - Database Test</h1>";

// Test 1: Check connection
if ($conn) {
    echo "<p style='color:green;'>✅ Database connection successful!</p>";
} else {
    echo "<p style='color:red;'>❌ Database connection failed!</p>";
}

// Test 2: Check if tables exist
$tables = ['admins', 'customers', 'cars', 'bookings', 'payments', 'booking_updates', 'cancellations', 'reviews', 'invoices'];
echo "<h2>Checking Tables...</h2>";

foreach ($tables as $table) {
    $result = $conn->query("SHOW TABLES LIKE '$table'");
    if ($result->num_rows > 0) {
        echo "<p style='color:green;'>✅ Table '$table' exists</p>";
    } else {
        echo "<p style='color:red;'>❌ Table '$table' does NOT exist</p>";
    }
}

// Test 3: Show sample data from cars
echo "<h2>Sample Cars in Database</h2>";
$sql = "SELECT * FROM cars LIMIT 5";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1' cellpadding='8' style='border-collapse: collapse;'>";
    echo "<tr style='background: #f4f4f4;'><th>ID</th><th>Brand</th><th>Model</th><th>Type</th><th>Price/Day</th><th>Status</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row['CarID'] . "</td>";
        echo "<td>" . $row['Brand'] . "</td>";
        echo "<td>" . $row['Model'] . "</td>";
        echo "<td>" . $row['Car_Type'] . "</td>";
        echo "<td>NPR " . number_format($row['Price_Per_Day']) . "</td>";
        echo "<td>" . $row['Availability_Status'] . "</td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "<p>No cars found in database.</p>";
}

// Test 4: Show connection info
echo "<h2>Connection Information</h2>";
echo "<p><strong>Server:</strong> " . $conn->server_info . "</p>";
echo "<p><strong>Database:</strong> " . $dbname . "</p>";
echo "<p><strong>Host:</strong> " . $conn->host_info . "</p>";

$conn->close();
?>