<?php
include 'includes/header.php';
?>

<div class="container">
    <div style="text-align: center; padding: 40px 0;">
        <h1>Header and Footer Test</h1>
        <p>If you can see the navigation bar at the top and the footer at the bottom, everything is working correctly!</p>
        <p style="color: green; font-weight: bold;">✅ Header and Footer are working!</p>
        <p>Current Time: <?php echo date('Y-m-d H:i:s'); ?></p>
    </div>
</div>

<?php
include 'includes/footer.php';
?>