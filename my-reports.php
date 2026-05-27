<?php
require 'config.php';
require 'auth.php';
require_login();

$stmt = $pdo->prepare('SELECT * FROM items WHERE user_id = ? ORDER BY created_at DESC');
$stmt->execute([$_SESSION['user_id']]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
include 'header.php';
?>
<main>
    <section class="items">
        <h2>My Reports</h2>
        <table>
            <tr>
                <th>Type</th>
                <th>Item</th>
                <th>Location</th>
                <th>Date</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= htmlspecialchars(ucfirst($item['item_type'])) ?></td>
                <td><?= htmlspecialchars($item['item_name']) ?></td>
                <td><?= htmlspecialchars($item['location']) ?></td>
                <td><?= htmlspecialchars($item['item_date']) ?></td>
                <td><?= htmlspecialchars(ucfirst($item['status'])) ?></td>
                <td>
                    <a class="small-btn" href="edit-item.php?id=<?= $item['id'] ?>">Edit</a>
                    <a class="small-btn danger" href="delete-item.php?id=<?= $item['id'] ?>" onclick="return confirm('Delete this report?');">Delete</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    </section>
</main>
<?php include 'footer.php'; ?>
