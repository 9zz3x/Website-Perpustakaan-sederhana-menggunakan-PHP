<?php
include 'koneksi.php';

// Cek apakah ID sudah dikirim melalui URL
if (isset($_GET['id']) && isset($_GET['id_buku'])) {
    $id_pinjam = $_GET['id'];
    $id_buku = $_GET['id_buku'];

    // 1. Update status peminjaman menjadi 'kembali'
    $update_pinjam = mysqli_query($conn, "UPDATE tb_peminjaman SET status_kembali='kembali' WHERE id_pinjam='$id_pinjam'");
    
    // 2. Update status buku menjadi 'tersedia' lagi
    $update_buku = mysqli_query($conn, "UPDATE tb_buku SET status='tersedia' WHERE id='$id_buku'");

    // 3. Kembali ke halaman peminjaman dengan pesan sukses
    if ($update_pinjam && $update_buku) {
        header("Location: peminjaman.php?pesan=berhasil_kembali");
    } else {
        echo "Gagal mengembalikan buku: " . mysqli_error($conn);
    }
} else {
    echo "ID tidak valid!";
}
?>