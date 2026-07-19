<?php
// Include header (session starts inside)
include 'includes/header.php';
include 'config/db_connect.php';

// Get filter values
$car_type = isset($_GET['car_type']) ? $_GET['car_type'] : '';
$min_price = isset($_GET['min_price']) ? $_GET['min_price'] : '';
$max_price = isset($_GET['max_price']) ? $_GET['max_price'] : '';

// Build query
$sql = "SELECT * FROM cars WHERE Availability_Status = 'Available'";

if (!empty($car_type)) {
    $sql .= " AND Car_Type = '$car_type'";
}
if (!empty($min_price)) {
    $sql .= " AND Price_Per_Day >= $min_price";
}
if (!empty($max_price)) {
    $sql .= " AND Price_Per_Day <= $max_price";
}

$sql .= " ORDER BY CreatedAt DESC";
$result = $conn->query($sql);

// Get car types for filter dropdown
$types_sql = "SELECT DISTINCT Car_Type FROM cars";
$types_result = $conn->query($types_sql);
?>

<div class="container">
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>🚗 Rent the Perfect Car for Your Journey</h1>
            <p>Explore Nepal with our reliable and affordable car rental service.</p>
            <p class="hero-sub">📍 Available in Kathmandu, Pokhara, Chitwan, and more</p>
            <a href="#cars" class="btn btn-hero">Browse Cars</a>
        </div>
    </section>

    <!-- Filter Section -->
    <section class="filter-section">
        <div class="filter-box">
            <h3>🔍 Filter Cars</h3>
            <form method="GET" action="index.php">
                <div class="filter-grid">
                    <div class="form-group">
                        <label>Car Type</label>
                        <select name="car_type">
                            <option value="">All Types</option>
                            <?php while ($type = $types_result->fetch_assoc()): ?>
                                <option value="<?php echo $type['Car_Type']; ?>" <?php echo ($car_type == $type['Car_Type']) ? 'selected' : ''; ?>>
                                    <?php echo $type['Car_Type']; ?>
                                </option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Min Price (NPR)</label>
                        <input type="number" name="min_price" placeholder="0" value="<?php echo $min_price; ?>">
                    </div>
                    <div class="form-group">
                        <label>Max Price (NPR)</label>
                        <input type="number" name="max_price" placeholder="10000" value="<?php echo $max_price; ?>">
                    </div>
                    <div class="form-group" style="display: flex; align-items: flex-end;">
                        <button type="submit" class="btn">Apply Filter</button>
                        <a href="index.php" class="btn btn-reset">Reset</a>
                    </div>
                </div>
            </form>
        </div>
    </section>

    <!-- Cars Section -->
    <section id="cars">
        <h2>Available Cars</h2>
        <p class="section-sub">Choose from our fleet of well-maintained vehicles</p>

        <?php if ($result->num_rows > 0): ?>
            <div class="car-grid">
                <?php while ($row = $result->fetch_assoc()): ?>
                    <div class="car-card">
                        <?php if (!empty($row['Image'])): ?>
                            <img src="assets/images/<?php echo $row['Image']; ?>" alt="<?php echo $row['Brand'] . ' ' . $row['Model']; ?>">
                        <?php else: ?>
                            <img src="assets/images/car-placeholder.jpg" alt="Car">
                        <?php endif; ?>
                        <div class="car-info">
                            <h3><?php echo $row['Brand'] . ' ' . $row['Model']; ?></h3>
                            <p class="car-details">
                                <span>🚗 <?php echo $row['Car_Type']; ?></span>
                                <span>⛽ <?php echo $row['Fuel_Type']; ?></span>
                                <span>👥 <?php echo $row['Seating_Capacity']; ?> seats</span>
                            </p>
                            <p class="price">NPR <?php echo number_format($row['Price_Per_Day']); ?> <span>/ day</span></p>
                            <p class="status">
                                <span class="status-available">✅ Available</span>
                            </p>
                            <a href="car_detail.php?id=<?php echo $row['CarID']; ?>" class="btn btn-primary btn-small">View Details</a>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        <?php else: ?>
            <div class="no-cars">
                <p>😕 No cars available matching your criteria.</p>
                <a href="index.php" class="btn">Clear Filters</a>
            </div>
        <?php endif; ?>
    </section>
</div>

<?php
// Add extra CSS for homepage
$extra_css = '
    .hero {
        background: linear-gradient(135deg, #1a1a2e, #16213e, #0f3460);
        color: white;
        padding: 60px 40px;
        border-radius: 12px;
        text-align: center;
        margin-bottom: 40px;
    }
    .hero h1 {
        font-size: 36px;
        margin-bottom: 15px;
    }
    .hero p {
        font-size: 18px;
        opacity: 0.9;
        margin-bottom: 10px;
    }
    .hero-sub {
        font-size: 16px;
        opacity: 0.8;
        margin-bottom: 20px;
    }
    .btn-hero {
        background: #4CAF50;
        padding: 14px 40px;
        font-size: 18px;
        border-radius: 30px;
    }
    .btn-hero:hover {
        background: #388E3C;
    }
    .filter-section {
        margin-bottom: 40px;
    }
    .filter-box {
        background: white;
        padding: 25px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
    }
    .filter-box h3 {
        margin-bottom: 15px;
    }
    .filter-grid {
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr;
        gap: 15px;
        align-items: end;
    }
    .filter-grid .form-group {
        margin-bottom: 0;
    }
    .filter-grid .form-group label {
        font-size: 13px;
        color: #555;
    }
    .btn-reset {
        background: #666;
        margin-left: 10px;
    }
    .btn-reset:hover {
        background: #444;
    }
    .section-sub {
        color: #777;
        margin-bottom: 20px;
    }
    .no-cars {
        text-align: center;
        padding: 40px;
        background: white;
        border-radius: 8px;
    }
    .no-cars p {
        font-size: 18px;
        margin-bottom: 15px;
    }
    .car-card {
        background: white;
        border-radius: 10px;
        overflow: hidden;
        box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
    }
    .car-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.15);
    }
    .car-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: #eee;
    }
    .car-info {
        padding: 15px;
    }
    .car-info h3 {
        font-size: 18px;
        margin-bottom: 8px;
    }
    .car-details {
        display: flex;
        gap: 12px;
        font-size: 13px;
        color: #666;
        margin-bottom: 10px;
        flex-wrap: wrap;
    }
    .price {
        font-size: 22px;
        font-weight: bold;
        color: #4CAF50;
    }
    .price span {
        font-size: 14px;
        font-weight: normal;
        color: #888;
    }
    .status {
        margin: 8px 0 12px;
    }
    .status-available {
        display: inline-block;
        padding: 3px 12px;
        border-radius: 20px;
        font-size: 12px;
        background: #d4edda;
        color: #155724;
    }

    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr 1fr;
        }
        .hero h1 {
            font-size: 24px;
        }
    }
    @media (max-width: 480px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }
';

// Add extra CSS to the page
echo '<style>' . $extra_css . '</style>';

include 'includes/footer.php';
?>