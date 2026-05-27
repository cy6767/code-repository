<?php
require 'config.php';
require 'auth.php';
require_login();

$message = '';
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $itemType = $_POST['itemType'];
    $itemName = trim($_POST['itemName']);
    $description = trim($_POST['description']);
    $location = trim($_POST['location']);
    $itemDate = $_POST['date'];
    $contact = trim($_POST['contact']);
    $imagePath = null;

    if (!in_array($itemType, ['lost', 'found'])) {
        $error = 'Invalid item type.';
    } else {
        if (!empty($_FILES['image']['name'])) {
            $uploadDir = 'uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $ext = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));

            if (in_array($ext, $allowed)) {
                $newName = uniqid('item_', true) . '.' . $ext;
                $target = $uploadDir . $newName;
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target)) {
                    $imagePath = $target;
                }
            }
        }

        $stmt = $pdo->prepare('INSERT INTO items (user_id, item_type, item_name, description, location, item_date, contact, image, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->execute([$_SESSION['user_id'], $itemType, $itemName, $description, $location, $itemDate, $contact, $imagePath, 'unclaimed']);
        $message = 'Item report submitted successfully.';
    }
}
include 'header.php';
?>
<main>
    <section class="form-section">
        <h2>Submit Lost or Found Item</h2>
        <?php if ($message): ?><p class="success"><?= htmlspecialchars($message) ?></p><?php endif; ?>
        <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form action="report-item.php" method="post" enctype="multipart/form-data">
            <label for="itemType">Item Type</label>
            <select id="itemType" name="itemType" required>
                <option value="">Select Type</option>
                <option value="lost">Lost Item</option>
                <option value="found">Found Item</option>
            </select>
            <label for="itemName">Item Name</label>
            <input type="text" id="itemName" name="itemName" placeholder="Enter item name" required>
            <label for="description">Description</label>
            <textarea id="description" name="description" rows="4" placeholder="Describe the item..." required></textarea>
            <label for="location">Location</label>
            <input type="text" id="location" name="location" placeholder="Where was it lost/found?" required>
            <label for="date">Date</label>
            <input type="date" id="date" name="date" required>
            <label for="contact">Contact Information</label>
            <input type="text" id="contact" name="contact" placeholder="Phone number or email" required>
            <label for="image">Upload Item Image</label>
            <input type="file" id="image" name="image" accept="image/*">
            <button type="submit">Submit Report</button>
        </form>
    </section>
</main>
<?php include 'footer.php'; ?>
