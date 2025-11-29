<?php 
require("function.php");

// Cek login
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

// Ambil data kategori untuk dropdown
$kategori = query("SELECT * FROM kategori ORDER BY nama_kategori ASC");

if(isset($_POST['tombol_submit'])){
    if(tambah_buku($_POST) > 0){
        echo "<script>
                alert('Data buku berhasil ditambahkan!');
                document.location.href = 'index_buku.php';
              </script>";
    } else {
        echo "<script>
                alert('Data buku gagal ditambahkan!');
              </script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku - SIMBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">📚 SIMBS</a>
            <div class="navbar-text text-white">
                <i class="bi bi-person-circle"></i> <?= $_SESSION['username'] ?>
            </div>
        </div>
    </nav>
   
    <div class="container py-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="bi bi-plus-circle"></i> Tambah Data Buku</h4>
                    </div>
                    <div class="card-body">
                        <a href="index_buku.php" class="btn btn-sm btn-secondary mb-3">
                            <i class="bi bi-arrow-left"></i> Kembali
                        </a>
                        
                        <form action="" method="POST" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Judul Buku <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="judul" placeholder="Masukkan judul buku" autocomplete="off" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Penulis <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="penulis" placeholder="Masukkan nama penulis" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Penerbit <span class="text-danger">*</span></label>
                                        <input type="text" class="form-control" name="penerbit" placeholder="Masukkan nama penerbit" autocomplete="off" required>
                                    </div>
                                </div>
                                
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Kategori <span class="text-danger">*</span></label>
                                        <select class="form-select" name="id_kategori" required>
                                            <option value="">-- Pilih Kategori --</option>
                                            <?php foreach($kategori as $kat): ?>
                                            <option value="<?= $kat['id'] ?>"><?= $kat['nama_kategori'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Tahun Terbit <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="tahun_terbit" placeholder="Contoh: 2023" min="1900" max="2099" autocomplete="off" required>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label fw-bold">Harga <span class="text-danger">*</span></label>
                                        <input type="number" class="form-control" name="harga" placeholder="Contoh: 95000" min="0" autocomplete="off" required>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="mb-3">
                                <label class="form-label fw-bold">Foto Cover Buku</label>
                                <input type="file" class="form-control" name="foto" id="foto" accept="image/*">
                                <small class="text-muted">
                                    <i class="bi bi-info-circle"></i> Format: JPG, JPEG, PNG, GIF. Maksimal 2MB. 
                                    (Opsional - jika tidak diisi akan menggunakan foto default)
                                </small>
                            </div>
                            
                            <hr>
                            
                            <div class="d-grid gap-2">
                                <button type="submit" name="tombol_submit" class="btn btn-primary">
                                    <i class="bi bi-save"></i> Simpan Data
                                </button>
                                <a href="index_buku.php" class="btn btn-outline-secondary">
                                    <i class="bi bi-x-circle"></i> Batal
                                </a>
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