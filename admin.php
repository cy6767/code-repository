<?php
require 'config.php';
require 'auth.php';
require_login();
if (!is_admin()) { die('Admin access only.'); }

$stmt = $pdo->query('SELECT items.*, users.fullname FROM items JOIN users ON items.user_id = users.id ORDER BY items.created_at DESC');
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
include 'header.php';
?>
<main>
    <section class="items">
        <h2>Admin Panel - All Reports</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Type</th>
                <th>Item</th>
                <th>Location</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php foreach ($items as $item): ?>
            <tr>
                <td><?= $item['id'] ?></td>
                <td><?= htmlspecialchars($item['fullname']) ?></td>
                <td><?= htmlspecialchars($item['item_type']) ?></td>
                <td><?= htmlspecialchars($item['item_name']) ?></td>
                <td><?= htmlspecialchars($item['location']) ?></td>
                <td><?= htmlspecialchars($item['status']) ?></td>
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
