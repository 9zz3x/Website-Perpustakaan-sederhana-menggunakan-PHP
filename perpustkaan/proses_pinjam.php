<?php
include 'koneksi.php';
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id_buku = $_POST['id_buku'];
    $id_anggota = $_POST['id_anggota'];
    $tgl = date('Y-m-d');

    // Insert ke tabel peminjaman
    mysqli_query($conn, "INSERT INTO tb_peminjaman (id_buku, id_anggota, tgl_pinjam, status_kembali) VALUES ('$id_buku', '$id_anggota', '$tgl', 'pinjam')");
    
    // Update status buku
    mysqli_query($conn, "UPDATE tb_buku SET status='dipinjam' WHERE id='$id_buku'");
    
    header("Location: peminjaman.php?pesan=success");
}
?>