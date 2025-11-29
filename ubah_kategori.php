<?php 
require("function.php");

// Cek login
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];
$kategori = query("SELECT * FROM kategori WHERE id = $id")[0];

if(isset($_POST['tombol_submit'])){
    if(ubah_kategori($_POST) > 0){
        echo "<script>
                alert('Data kategori berhasil diubah!');
                document.location.href = 'index_kategori.php';
              </script>";
    } else {
        echo "<script>
                alert('Data kategori gagal diubah!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Kategori - SIMBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">SIMBS</a>
            <div class="navbar-text text-white">
                <i class="bi bi-person-circle"></i> <?= $_SESSION['username'] ?>
            </div>
        </div>
    </nav>
   
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning text-dark">
                        <h4 class="mb-0">Ubah Data Kategori</h4>
                    </div>
                    <div class="card-body">
                        <a href="index_kategori.php" class="btn btn-sm btn-secondary mb-3">← Kembali</a>
                        
                        <form action="" method="POST">
                            <input type="hidden" name="id" value="<?= $kategori['id'] ?>">
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Nama Kategori</label>
                                <input type="text" class="form-control" name="nama_kategori" value="<?= $kategori['nama_kategori'] ?>" autocomplete="off" required>
                            </div>
                            
                            <div class="d-grid">
                                <button type="submit" name="tombol_submit" class="btn btn-warning">Update Data</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>