<?php
session_start();
include '../config/database.php';

// Cek jika sudah login, langsung lempar ke dashboard
if (isset($_SESSION['admin_logged_in'])) {
    header("Location: dashboard.php");
    exit;
}

$error = "";

if (isset($_POST['login'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    // Hardcoded simple login untuk keperluan project
    // User: admin, Pass: admin123
    if ($username === "admin" && $password === "admin123") {
        $_SESSION['admin_logged_in'] = true;
        header("Location: dashboard.php");
        exit;
    } else {
        $error = "Username atau Password salah!";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin - Tech Vending</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="login-container">
    <div class="login-card">
        <h3>ADMIN LOGIN</h3>
        
        <?php if ($error !== ""): ?>
            <div class="alert alert-danger py-2 small text-center"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST" id="loginForm">
            <div class="mb-3">
                <label class="form-label small fw-bold">Username</label>
                <input type="text" name="username" class="form-control" placeholder="admin" required>
            </div>
            <div class="mb-4">
                <label class="form-label small fw-bold">Password</label>
                <input type="password" name="password" class="form-control" placeholder="••••••••" required>
            </div>
            <button type="submit" name="login" class="btn btn-login w-100">MASUK KE PANEL</button>
        </form>

        <div class="mt-4 text-center">
            <a href="../index.php" class="text-decoration-none small text-muted">
                <i class="bi bi-arrow-left"></i> Kembali ke Layar Vending
            </a>
        </div>
    </div>
</div>

<script src="../assets/js/script.js"></script>
</body>
</html>