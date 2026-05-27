<?php
require 'config.php';
require 'auth.php';
require_login();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare('SELECT * FROM items WHERE id = ?');
$stmt->execute([$id]);
$item = $stmt->fetch(PDO::FETCH_ASSOC);

if ($item && ($item['user_id'] == $_SESSION['user_id'] || is_admin())) {
    $delete = $pdo->prepare('DELETE FROM items WHERE id = ?');
    $delete->execute([$id]);
}

header('Location: my-reports.php');
exit;
?>
