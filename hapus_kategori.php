<?php 
require("function.php");

// Cek login
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

if(hapus_kategori($id) > 0){
    echo "<script>
            alert('Data kategori berhasil dihapus!');
            document.location.href = 'index_kategori.php';
          </script>";
} else {
    echo "<script>
            alert('Data kategori gagal dihapus!');
            document.location.href = 'index_kategori.php';
          </script>";
}
?>