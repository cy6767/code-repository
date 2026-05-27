<?php
require 'config.php';
require 'auth.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM items WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$item || ($item['user_id'] != $_SESSION['user_id'] && !is_admin())) {
    die('Item not found or access denied.');
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemType = $_POST['itemType'];
    $itemName = trim($_POST['itemName']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $itemDate = $_POST['date'];
    $contact = trim($_POST['contact']);
    $status = $_POST['status'];

    $stmt = $pdo->prepare('UPDATE items SET item_type=?, item_name=?, description=?, location=?, item_date=?, contact=?, status=? WHERE id=?');
    $stmt->execute([$itemType, $itemName, $description, $location, $itemDate, $contact, $status, $id]);
    header('Location: my-reports.php');
    exit;
}
include 'header.php';
?>
<main>
    <section class="form-section">
        <h2>Edit Item Report</h2>
        <form action="edit-item.php?id=<?= $id ?>" method="post">
            <label>Item Type</label>
            <select name="itemType" required>
                <option value="lost" <?= $item['item_type'] === 'lost' ? 'selected' : '' ?>>Lost Item</option>
                <option value="found" <?= $item['item_type'] === 'found' ? 'selected' : '' ?>>Found Item</option>
            </select>
            <label>Item Name</label>
            <input type="text" name="itemName" value="<?= htmlspecialchars($item['item_name']) ?>" required>
            <label>Description</label>
            <textarea name="description" rows="4" required><?= htmlspecialchars($item['description']) ?></textarea>
            <label>Location</label>
            <input type="text" name="location" value="<?= htmlspecialchars($item['location']) ?>" required>
            <label>Date</label>
            <input type="date" name="date" value="<?= htmlspecialchars($item['item_date']) ?>" required>
            <label>Contact</label>
            <input type="text" name="contact" value="<?= htmlspecialchars($item['contact']) ?>" required>
            <label>Status</label>
            <select name="status" required>
                <option value="unclaimed" <?= $item['status'] === 'unclaimed' ? 'selected' : '' ?>>Unclaimed</option>
                <option value="claimed" <?= $item['status'] === 'claimed' ? 'selected' : '' ?>>Claimed</option>
            </select>
            <button type="submit">Update Report</button>
        </form>
    </section>
</main>
<?php include 'footer.php'; ?>
