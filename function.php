<?php 
session_start();

// Koneksi ke database SIMBS
$conn = mysqli_connect("localhost", "root", "", "simbs");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Fungsi untuk menampilkan data dari database
function query($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while($row = mysqli_fetch_assoc($result)) {
        $rows[] = $row;
    }
    return $rows;
}

// ==================== FUNGSI UNTUK UPLOAD FOTO ====================

function upload_foto() {
    $namaFile = $_FILES['foto']['name'];
    $ukuranFile = $_FILES['foto']['size'];
    $error = $_FILES['foto']['error'];
    $tmpName = $_FILES['foto']['tmp_name'];

    // Cek apakah tidak ada foto yang diupload
    if($error === 4) {
        return 'default.jpg'; // Gunakan foto default
    }

    // Cek apakah yang diupload adalah gambar
    $ekstensiFotoValid = ['jpg', 'jpeg', 'png', 'gif'];
    $ekstensiFoto = explode('.', $namaFile);
    $ekstensiFoto = strtolower(end($ekstensiFoto));
    
    if(!in_array($ekstensiFoto, $ekstensiFotoValid)) {
        echo "<script>
                alert('Yang anda upload bukan gambar!');
              </script>";
        return false;
    }

    // Cek jika ukurannya terlalu besar (max 2MB)
    if($ukuranFile > 2000000) {
        echo "<script>
                alert('Ukuran foto terlalu besar! Maksimal 2MB');
              </script>";
        return false;
    }

    // Generate nama file baru
    $namaFileBaru = uniqid();
    $namaFileBaru .= '.';
    $namaFileBaru .= $ekstensiFoto;

    // Upload file
    move_uploaded_file($tmpName, 'uploads/' . $namaFileBaru);

    return $namaFileBaru;
}

// ==================== FUNGSI UNTUK BUKU ====================

// Fungsi untuk menambahkan data buku
function tambah_buku($data){
    global $conn;

    $judul = mysqli_real_escape_string($conn, $data['judul']);
    $penulis = mysqli_real_escape_string($conn, $data['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $data['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $data['tahun_terbit']);
    $harga = mysqli_real_escape_string($conn, $data['harga']);
    $id_kategori = mysqli_real_escape_string($conn, $data['id_kategori']);
    
    // Upload foto
    $foto = upload_foto();
    if(!$foto) {
        return false;
    }

    $query = "INSERT INTO buku (judul, penulis, penerbit, tahun_terbit, harga, foto, id_kategori)
              VALUES ('$judul', '$penulis', '$penerbit', '$tahun_terbit', '$harga', '$foto', '$id_kategori')";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);    
}

// Fungsi untuk menghapus data buku
function hapus_buku($id){
    global $conn;
    
    // Ambil nama foto
    $buku = query("SELECT foto FROM buku WHERE id = $id")[0];
    
    // Hapus foto jika bukan default
    if($buku['foto'] != 'default.jpg') {
        unlink('uploads/' . $buku['foto']);
    }
    
    $query = "DELETE FROM buku WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);    
}

// Fungsi untuk mengubah data buku
function ubah_buku($data){
    global $conn;

    $id = $data['id'];
    $judul = mysqli_real_escape_string($conn, $data['judul']);
    $penulis = mysqli_real_escape_string($conn, $data['penulis']);
    $penerbit = mysqli_real_escape_string($conn, $data['penerbit']);
    $tahun_terbit = mysqli_real_escape_string($conn, $data['tahun_terbit']);
    $harga = mysqli_real_escape_string($conn, $data['harga']);
    $id_kategori = mysqli_real_escape_string($conn, $data['id_kategori']);
    $fotoLama = $data['fotoLama'];

    // Cek apakah user pilih foto baru
    if($_FILES['foto']['error'] === 4) {
        $foto = $fotoLama;
    } else {
        $foto = upload_foto();
        if(!$foto) {
            return false;
        }
        // Hapus foto lama jika bukan default
        if($fotoLama != 'default.jpg') {
            unlink('uploads/' . $fotoLama);
        }
    }

    $query = "UPDATE buku SET
                judul = '$judul',
                penulis = '$penulis',
                penerbit = '$penerbit',
                tahun_terbit = '$tahun_terbit',
                harga = '$harga',
                foto = '$foto',
                id_kategori = '$id_kategori'
              WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn); 
}

// ==================== FUNGSI UNTUK KATEGORI ====================

// Fungsi untuk menambahkan data kategori
function tambah_kategori($data){
    global $conn;

    $nama_kategori = mysqli_real_escape_string($conn, $data['nama_kategori']);

    $query = "INSERT INTO kategori (nama_kategori) VALUES ('$nama_kategori')";
    
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);    
}

// Fungsi untuk menghapus data kategori
function hapus_kategori($id){
    global $conn;
    $query = "DELETE FROM kategori WHERE id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);    
}

// Fungsi untuk mengubah data kategori
function ubah_kategori($data){
    global $conn;

    $id = $data['id'];
    $nama_kategori = mysqli_real_escape_string($conn, $data['nama_kategori']);

    $query = "UPDATE kategori SET nama_kategori = '$nama_kategori' WHERE id = $id";

    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn); 
}

// Fungsi untuk mencari data kategori
function search_kategori($keyword){
    global $conn;

    $query = "SELECT * FROM kategori
              WHERE nama_kategori LIKE '%$keyword%'
              ORDER BY tanggal_input DESC";
    
    return query($query);
}

// ==================== FUNGSI UNTUK USER ====================

// Fungsi untuk register
function register($data_register){
    global $conn;

    $username = strtolower(mysqli_real_escape_string($conn, $data_register['username']));
    $email = mysqli_real_escape_string($conn, $data_register['email']);
    $password = mysqli_real_escape_string($conn, $data_register['password']);

    // Cek panjang password
    if(strlen($password) < 8){
        return "password harus mengandung minimal 8 karakter";
    }

    // Cek username (GANTI: user -> users)
    $result = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_fetch_assoc($result)){
        return "username atau email sudah terdaftar, gunakan yang lain";
    }

    // Cek email sudah ada atau belum (GANTI: user -> users)
    $result = mysqli_query($conn, "SELECT email FROM users WHERE email = '$email'");
    if(mysqli_fetch_assoc($result)){
        return "username atau email sudah terdaftar, gunakan yang lain";
    }

    // Enkripsi password
    $password = password_hash($password, PASSWORD_DEFAULT);

    // Tambahkan user baru ke database (GANTI: user -> users)
    mysqli_query($conn, "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')");
   
    return true;
}

// Fungsi untuk login
function login($data){
    global $conn;

    $username = mysqli_real_escape_string($conn, $data['username']);
    $password = $data['password'];

    // Cek username (GANTI: user -> users)
    $query = "SELECT * FROM users WHERE username = '$username'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) === 1){
        $row = mysqli_fetch_assoc($result);

        // Verify password
        if(password_verify($password, $row["password"])) {
            $_SESSION['login'] = true;
            $_SESSION['username'] = $username;
            return true;
        } else {
            return "salah password";
        }
    } else {
        return "username salah";
    }
}

// Fungsi untuk cek login
function is_logged_in(){
    return isset($_SESSION['login']);
}

?>