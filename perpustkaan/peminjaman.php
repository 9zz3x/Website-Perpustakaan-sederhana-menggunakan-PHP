<?php include 'koneksi.php'; ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Peminjaman | LibManager Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

<div class="app-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="bi bi-book-half"></i></div>
            <span class="logo-text">LibManager</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-item"><i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span></a>
            <a href="anggota.php" class="nav-item"><i class="bi bi-people-fill"></i> <span>Anggota</span></a>
            <a href="peminjaman.php" class="nav-item active"><i class="bi bi-clock-history"></i> <span>Peminjaman</span></a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div>
                <h1 class="mb-1">Transaksi Peminjaman</h1>
                <p class="text-muted">Kelola sirkulasi buku dengan mudah.</p>
            </div>
        </header>

        <div class="row">
            <div class="col-lg-5">
                <div class="data-card">
                    <h5 class="mb-4 fw-bold"><i class="bi bi-plus-circle me-2"></i>Tambah Peminjaman</h5>
                    <form action="proses_pinjam.php" method="POST">
                        <div class="mb-3">
                            <label class="small text-muted fw-bold mb-1">BUKU YANG DIPINJAM</label>
                            <select name="id_buku" class="form-select py-2" required>
                                <option value="">Pilih Buku...</option>
                                <?php 
                                $buku = mysqli_query($conn, "SELECT * FROM tb_buku WHERE status='tersedia'");
                                while($b = mysqli_fetch_assoc($buku)) echo "<option value='".$b['id']."'>".$b['judul']."</option>";
                                ?>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="small text-muted fw-bold mb-1">ANGGOTA PEMINJAM</label>
                            <select name="id_anggota" class="form-select py-2" required>
                                <option value="">Pilih Anggota...</option>
                                <?php 
                                $anggota = mysqli_query($conn, "SELECT * FROM tb_anggota");
                                while($a = mysqli_fetch_assoc($anggota)) echo "<option value='".$a['id']."'>".$a['nama']."</option>";
                                ?>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-indigo w-100 py-3 rounded-3 fw-bold">
                            <i class="bi bi-bookmark-check me-2"></i>Konfirmasi Peminjaman
                        </button>
                    </form>
                </div>
            </div>

            <div class="col-lg-7">
                <div class="data-card">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="fw-bold">Riwayat Transaksi</h5>
                    </div>
                    <div class="table-responsive">
                        <table class="table custom-table">
                            <thead>
                                <tr class="text-muted"><th>#</th><th>PEMINJAM</th><th>BUKU</th><th>STATUS</th><th>AKSI</th></tr>
                            </thead>
                            <tbody>
                                <?php 
                                $query = mysqli_query($conn, "SELECT p.*, b.judul, a.nama FROM tb_peminjaman p LEFT JOIN tb_buku b ON p.id_buku = b.id LEFT JOIN tb_anggota a ON p.id_anggota = a.id ORDER BY p.id_pinjam DESC");
                                $no = 1;
                                while($row = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td><?= $no++ ?></td>
                                    <td><?= htmlspecialchars($row['nama'] ?? 'Unknown') ?></td>
                                    <td><?= htmlspecialchars($row['judul'] ?? 'Unknown') ?></td>
                                    <td>
                                        <span class="badge-status <?= ($row['status_kembali'] == 'pinjam') ? 'is-borrowed' : 'is-available' ?>">
                                            <?= ucfirst($row['status_kembali']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <?php if($row['status_kembali'] == 'pinjam') { ?>
                                            <a href="kembali.php?id=<?= $row['id_pinjam'] ?>&id_buku=<?= $row['id_buku'] ?>" class="btn btn-sm btn-outline-success">Kembalikan</a>
                                        <?php } ?>
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>