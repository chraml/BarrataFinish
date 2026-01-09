<?php
session_start();
include '../config/db.php';

$error = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM admin_users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        
        // PERBAIKAN: Support plain text DAN hashed password
        $isPasswordCorrect = false;
        
        // Cek jika password di-hash (starts with $2y$)
        if (strpos($user['password'], '$2y$') === 0) {
            $isPasswordCorrect = password_verify($password, $user['password']);
        } 
        // Jika plain text
        else {
            $isPasswordCorrect = ($password === $user['password']);
        }
        
        if ($isPasswordCorrect) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_email'] = $user['email'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = "Password salah!";
        }
    } else {
        $error = "Email tidak ditemukan!";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Admin - Barrata Global</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
  <link href="../assets/css/login.css" rel="stylesheet">
</head>

<body>
  <div class="login-container">
    <div class="login-card">
      <div class="logo-section">
        <div class="logo-icon"><i class="bi bi-shield-lock"></i></div>
        <h1 class="login-title">Admin Login</h1>
        <p class="login-subtitle">Barrata Global Technology</p>
      </div>

      <?php if (!empty($error)): ?>
        <div class="alert alert-danger">
          <i class="bi bi-exclamation-circle me-2"></i> <?= $error; ?>
        </div>
      <?php endif; ?>

      <form method="POST" id="loginForm">
        <div class="mb-3">
          <label class="form-label">Email</label>
          <div class="input-group">
            <i class="bi bi-envelope input-icon"></i>
            <input type="email" name="email" class="form-control with-icon" placeholder="admin@barrata.com" required autofocus>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Password</label>
          <div class="input-group">
            <i class="bi bi-lock input-icon"></i>
            <input type="password" name="password" class="form-control with-icon" placeholder="••••••••" required>
          </div>
        </div>

        <div class="form-check mb-3">
          <input class="form-check-input" type="checkbox" name="remember" id="remember">
          <label class="form-check-label" for="remember">Ingat saya</label>
        </div>

        <button type="submit" class="btn btn-login w-100">
          <span class="btn-text">Masuk</span>
          <span class="spinner-border spinner-border-sm d-none" role="status"></span>
        </button>
      </form>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        const btn = this.querySelector('.btn-login');
        const btnText = btn.querySelector('.btn-text');
        const spinner = btn.querySelector('.spinner-border');
        btnText.classList.add('d-none');
        spinner.classList.remove('d-none');
        btn.disabled = true;
    });
  </script>
</body>
</html>
