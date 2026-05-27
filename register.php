<?php
require 'config.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fullname = trim($_POST['fullname']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm_password'];

    if ($password !== $confirm) {
        $error = 'Passwords do not match.';
    } elseif (strlen($password) < 6) {
        $error = 'Password must be at least 6 characters.';
    } else {
        $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
        $stmt->execute([$email]);

        if ($stmt->fetch()) {
            $error = 'Email already registered.';
        } else {
            $hashed = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $pdo->prepare("INSERT INTO users (fullname, email, password, role) VALUES (?, ?, ?, ?)");
            $stmt->execute([$fullname, $email, $hashed, 'user']);

            $success = 'Registration successful. You may now login.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - CvSU Lost & Found</title>
    <link rel="stylesheet" href="style.css">

    <style>
        * {
            font-family: "Poppins", Arial, sans-serif;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>

<header>
    <h1>Lost & Found Item Monitoring System</h1>
    <p>Cavite State University - Main Campus</p>
</header>

<nav>
    <a href="index.php">Login</a>
    <a href="register.php">Register</a>
</nav>

<main>
    <section class="form-section">
        <h2>Create a New Account</h2>

        <?php if ($error): ?>
            <p class="error"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <?php if ($success): ?>
            <p class="success"><?php echo htmlspecialchars($success); ?></p>
        <?php endif; ?>

        <form action="register.php" method="post">
            <input type="text" name="fullname" placeholder="Full Name" required>
            <input type="email" name="email" placeholder="CvSU Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>

            <button type="submit">Register</button>
        </form>

        <p>Already have an account? <a href="index.php">Login here</a></p>
    </section>
</main>

<footer>
    <p>&copy; 2026 CvSU Lost & Found System</p>
</footer>

</body>
</html>