<?php
require 'config.php';
require 'auth.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $pdo->prepare('SELECT * FROM users WHERE email = ?');
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['fullname'] = $user['fullname'];
        $_SESSION['role'] = $user['role'];
        header('Location: home.php');
        exit;
    } else {
        $error = 'Invalid email or password.';
    }
}
include 'header.php';
?>
<main>
    <section class="form-section">
        <h2>Login to Your Account</h2>
        <?php if ($error): ?><p class="error"><?= htmlspecialchars($error) ?></p><?php endif; ?>
        <form action="index.php" method="post">
            <input type="email" name="email" placeholder="CvSU Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
        <p>Don't have an account? <a href="register.php">Register here</a></p>
        <p class="note">Demo admin: admin@cvsu.edu.ph / admin123</p>
    </section>
</main>
<?php include 'footer.php'; ?>
