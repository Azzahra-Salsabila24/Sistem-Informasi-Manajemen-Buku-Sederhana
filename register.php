<?php
require("function.php");

// Jika sudah login, redirect ke halaman buku
if(is_logged_in()){
    header("Location: index_buku.php");
    exit;
}

$error = "";
$success = "";

if(isset($_POST['tombol_register'])){
    $result = register($_POST);
    
    if($result === true){
        $success = "Register berhasil! Silakan login.";
    } else {
        $error = $result;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - SIMBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }
        .register-card {
            padding: 40px;
            border-radius: 15px;
            background: white;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">

            <div class="register-card">

                <h3 class="text-center mb-4">Register SIMBS</h3>
                <p class="text-center text-muted mb-4">Sistem Informasi Manajemen Buku Sederhana</p>

                <?php if($error) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> <?= $error ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <?php if($success) : ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> <?= $success ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
                <?php endif; ?>

                <form action="" method="POST">

                    <div class="mb-3">
                        <label class="form-label fw-bold">Username</label>
                        <input type="text" name="username" class="form-control" placeholder="Masukkan username..." autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Email</label>
                        <input type="email" name="email" class="form-control" placeholder="Masukkan email..." autocomplete="off" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Masukkan password (min. 8 karakter)..." autocomplete="off" required>
                        <small class="text-muted">Password harus minimal 8 karakter</small>
                    </div>

                    <button type="submit" name="tombol_register" class="btn btn-primary w-100 mb-3">Register</button>
                    
                    <p class="text-center mb-0">Sudah punya akun? <a href="login.php">Login</a></p>
                </form>

            </div>

        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>