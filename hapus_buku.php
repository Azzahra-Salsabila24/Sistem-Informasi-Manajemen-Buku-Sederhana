<?php 
require("function.php");

// Cek login
if(!is_logged_in()){
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

if(hapus_buku($id) > 0){
    echo "<script>
            alert('Data buku berhasil dihapus!');
            document.location.href = 'index_buku.php';
          </script>";
} else {
    echo "<script>
            alert('Data buku gagal dihapus!');
            document.location.href = 'index_buku.php';
          </script>";
}
?>