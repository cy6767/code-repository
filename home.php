<?php
require 'auth.php';
require_login();
include 'header.php';
?>

<main>
    <section class="home-section">
        <h2>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?>!</h2>
        <p>Use the system to report and check lost and found items inside the campus.</p>

        <div class="auth-buttons">
            <a href="report-item.php" class="btn">Report Item</a>
            <a href="lost-items.php" class="btn">View Lost Items</a>
            <a href="found-items.php" class="btn">View Found Items</a>
        </div>
    </section>

    <section class="items">
        <h2>System Features</h2>

        <a href="found-items.php" class="card-link">
            <div class="card found-card">
                <div>
                    <h3>Found Items</h3>
                    <p>Browse items found inside the campus.</p>
                </div>
            </div>
        </a>

        <a href="lost-items.php" class="card-link">
            <div class="card lost-card">
                <div>
                    <h3>Lost Items</h3>
                    <p>Check reported lost items and possible matches.</p>
                </div>
            </div>
        </a>
    </section>
</main>

<?php include 'footer.php'; ?>