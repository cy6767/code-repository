<?php
require 'config.php';
require 'auth.php';
require_login();
$stmt = $pdo->prepare('SELECT items.*, users.fullname FROM items JOIN users ON items.user_id = users.id WHERE item_type = ? ORDER BY created_at DESC');
$stmt->execute(['found']);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
include 'header.php';
?>
<main>
    <h2 class="page-title">Found Items</h2>
    <section class="gallery">
        <?php foreach ($items as $item): ?>
            <div class="gallery-item">
                <img src="<?= htmlspecialchars($item['image'] ?: 'images/placehol') ?>" alt="Found Item">
                <div class="item-desc">
                    <p><strong>Item:</strong> <?= htmlspecialchars($item['item_name']) ?></p>
                    <p><strong>Description:</strong> <?= htmlspecialchars($item['description']) ?></p>
                    <p><strong>Location:</strong> <?= htmlspecialchars($item['location']) ?></p>
                    <p><strong>Date Found:</strong> <?= htmlspecialchars($item['item_date']) ?></p>
                    <p><strong>Contact:</strong> <?= htmlspecialchars($item['contact']) ?></p>
                </div>
                <span class="status-label found">FOUND</span>
            </div>
        <?php endforeach; ?>
    </section>
</main>
<?php include 'footer.php'; ?>
