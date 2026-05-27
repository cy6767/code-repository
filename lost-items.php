<?php
require 'config.php';
require 'auth.php';
require_login();
$stmt = $pdo->prepare('SELECT items.*, users.fullname FROM items JOIN users ON items.user_id = users.id WHERE item_type = ? ORDER BY created_at DESC');
$stmt->execute(['lost']);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
include 'header.php';
?>
<main>
    <h2 class="page-title">Lost Items</h2>
    <section class="gallery">
        <?php foreach ($items as $item): ?>
            <div class="gallery-item">
                <img src="<?= htmlspecialchars($item['image'] ?: 'images/placeholder.png') ?>" alt="Lost Item">
                <div class="item-desc">
                    <p><strong>Item:</strong> <?= htmlspecialchars($item['item_name']) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($item['location']) ?></p>
                    <p><strong>Date:</strong> <?= htmlspecialchars($item['item_date']) ?></p>
                    <p><strong>Contact:</strong> <?= htmlspecialchars($item['contact']) ?></p>
                </div>
                <span class="status-label unclaimed">LOST</span>
            </div>
        <?php endforeach; ?>
    </section>
</main>
<?php include 'footer.php'; ?>
