<?php
require("function.php");

// Cek login
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

// Pagination
$limit = 5; // Data per halaman
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start = ($page - 1) * $limit;

// Query kategori dengan search
if(isset($_POST['tombol_search'])){
    $keyword = mysqli_real_escape_string($conn, $_POST['keyword']);
    $query_count = "SELECT COUNT(*) as total FROM kategori WHERE nama_kategori LIKE '%$keyword%'";
    $query_data = "SELECT * FROM kategori WHERE nama_kategori LIKE '%$keyword%' ORDER BY tanggal_input DESC LIMIT $start, $limit";
} else {
    $query_count = "SELECT COUNT(*) as total FROM kategori";
    $query_data = "SELECT * FROM kategori ORDER BY tanggal_input DESC LIMIT $start, $limit";
}

$total_data = query($query_count)[0]['total'];
$total_pages = ceil($total_data / $limit);
$kategori = query($query_data);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kategori - SIMBS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body>

    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand fw-bold" href="#">📚 SIMBS</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index_buku.php">
                            <i class="bi bi-book"></i> Data Buku
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index_kategori.php">
                            <i class="bi bi-grid"></i> Data Kategori
                        </a>
                    </li>
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <span class="navbar-text text-white me-3">
                            <i class="bi bi-person-circle"></i> <?= $_SESSION['username'] ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="btn btn-sm btn-outline-light" href="logout.php">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- CONTENT -->
    <section class="py-4">
        <div class="container">

            <!-- Welcome Message -->
            <div class="alert alert-success alert-dismissible fade show mb-4" role="alert">
                <h5 class="alert-heading">
                    <i class="bi bi-emoji-smile-fill"></i> Hallo, Selamat Datang <?= ucfirst($_SESSION['username']) ?>!
                </h5>
                <p class="mb-0"><strong>di</strong> <strong>Sistem Informasi Manajemen Buku Sederhana</strong></p>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2><i class="bi bi-grid-fill text-primary"></i> Data Kategori Buku</h2>
            </div>

            <div class="d-flex justify-content-between align-items-center mb-3">
                <a href="tambah_kategori.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Kategori
                </a>

                <form action="" method="POST" class="d-flex">
                    <input type="text" class="form-control me-2" name="keyword" placeholder="Cari kategori..." autocomplete="off" style="width: 300px;" value="<?= isset($_POST['keyword']) ? htmlspecialchars($_POST['keyword']) : '' ?>">
                    <button class="btn btn-outline-primary" type="submit" name="tombol_search">
                        <i class="bi bi-search"></i> Cari
                    </button>
                    <?php if(isset($_POST['tombol_search'])): ?>
                    <a href="index_kategori.php" class="btn btn-outline-secondary ms-2">
                        <i class="bi bi-x-circle"></i> Reset
                    </a>
                    <?php endif; ?>
                </form>
            </div>

            <?php if(isset($_POST['tombol_search'])): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle"></i> Hasil pencarian untuk: <strong>"<?= htmlspecialchars($_POST['keyword']) ?>"</strong> - Ditemukan <strong><?= $total_data ?></strong> data
            </div>
            <?php endif; ?>
            
            <div class="card shadow">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover align-middle">
                            <thead class="table-primary">
                                <tr>
                                    <th>No.</th>
                                    <th>Nama Kategori</th>
                                    <th>Tanggal Input</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(empty($kategori)): ?>
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">
                                        <i class="bi bi-inbox" style="font-size: 3rem;"></i>
                                        <p class="mt-2">Data tidak ditemukan</p>
                                    </td>
                                </tr>
                                <?php else: ?>
                                    <?php $no = $start + 1; ?>
                                    <?php foreach($kategori as $data): ?>
                                    <tr>
                                        <td><?= $no ?></td>
                                        <td><strong><?= htmlspecialchars($data['nama_kategori']) ?></strong></td>
                                        <td>
                                            <i class="bi bi-calendar3"></i> 
                                            <?= date('d/m/Y', strtotime($data['tanggal_input'])) ?>
                                            <small class="text-muted">- <?= date('H:i', strtotime($data['tanggal_input'])) ?> WIB</small>
                                        </td>
                                        <td>
                                            <a href="ubah_kategori.php?id=<?= $data['id'] ?>" class="btn btn-sm btn-warning">
                                                <i class="bi bi-pencil"></i> Edit
                                            </a>
                                            <a href="hapus_kategori.php?id=<?= $data['id'] ?>" 
                                               class="btn btn-sm btn-danger" 
                                               onclick="return confirm('Yakin ingin menghapus kategori ini?')">
                                                <i class="bi bi-trash"></i> Hapus
                                            </a>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
            <nav class="mt-4">
                <ul class="pagination justify-content-center">
                    <!-- Previous Button -->
                    <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page - 1 ?>">
                            <i class="bi bi-chevron-left"></i> Previous
                        </a>
                    </li>
                    
                    <!-- Page Numbers -->
                    <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <li class="page-item <?= $page == $i ? 'active' : '' ?>">
                        <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                    </li>
                    <?php endfor; ?>
                    
                    <!-- Next Button -->
                    <li class="page-item <?= $page >= $total_pages ? 'disabled' : '' ?>">
                        <a class="page-link" href="?page=<?= $page + 1 ?>">
                            Next <i class="bi bi-chevron-right"></i>
                        </a>
                    </li>
                </ul>
            </nav>
            <?php endif; ?>

        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>