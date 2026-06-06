<?php 
include 'koneksi.php'; 

// Logika Pencarian
$cari = isset($_GET['cari']) ? mysqli_real_escape_string($conn, $_GET['cari']) : '';
$query_sql = "SELECT * FROM tb_buku WHERE judul LIKE '%$cari%' OR penulis LIKE '%$cari%' ORDER BY id DESC";
$query = mysqli_query($conn, $query_sql);

// Statistik
$total = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM tb_buku"))['total'];
$tersedia = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as tot FROM tb_buku WHERE status='tersedia'"))['tot'];
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LibManager Pro | Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
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
            <a href="index.php" class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'index.php') ? 'active' : '' ?>">
                <i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span>
            </a>
            <a href="anggota.php" class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'anggota.php') ? 'active' : '' ?>">
                <i class="bi bi-people-fill"></i> <span>Anggota</span>
            </a>
            <a href="peminjaman.php" class="nav-item <?= (basename($_SERVER['PHP_SELF']) == 'peminjaman.php') ? 'active' : '' ?>">
                <i class="bi bi-clock-history"></i> <span>Peminjaman</span>
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div class="header-info">
                <h1>Selamat Datang, Admin</h1>
                <p>Pantau koleksi perpustakaan Anda secara real-time.</p>
            </div>
            <div class="header-actions">
                <a href="tambah.php" class="btn btn-indigo shadow-sm">
                    <i class="bi bi-plus-lg"></i> Tambah Buku
                </a>
            </div>
        </header>

        <?php if(isset($_GET['pesan'])): ?>
            <?php 
                $pesan = $_GET['pesan'];
                $alert_type = ($pesan == 'success') ? 'alert-success' : 'alert-info';
                $text = ($pesan == 'success') ? 'Buku berhasil ditambahkan!' : 'Data berhasil diperbarui!';
            ?>
            <div class="alert <?= $alert_type ?> alert-dismissible fade show rounded-3 mb-4 shadow-sm" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> <?= $text ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>

        <section class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon indigo"><i class="bi bi-collection"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Total Koleksi</span>
                    <span class="stat-value"><?= $total ?></span>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon emerald"><i class="bi bi-check2-circle"></i></div>
                <div class="stat-data">
                    <span class="stat-label">Buku Tersedia</span>
                    <span class="stat-value"><?= $tersedia ?></span>
                </div>
            </div>
        </section>

        <section class="content-section">
            <div class="data-card">
                <div class="card-header-flex">
                    <h3>Daftar Inventaris Buku</h3>
                    <form action="" method="GET" class="search-form">
                        <i class="bi bi-search"></i>
                        <input type="text" name="cari" placeholder="Cari judul atau penulis..." value="<?= htmlspecialchars($cari) ?>">
                    </form>
                </div>

                <div class="table-responsive">
                    <table class="table custom-table">
                        <thead>
                            <tr>
                                <th>NO</th><th>INFORMASI BUKU</th><th>TAHUN</th><th>STATUS</th><th class="text-center">AKSI</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $no = 1;
                            if(mysqli_num_rows($query) > 0) {
                                while($row = mysqli_fetch_assoc($query)) { ?>
                                <tr>
                                    <td class="text-muted"><?= $no++ ?></td>
                                    <td>
                                        <div class="buku-info">
                                            <span class="judul-buku"><?= $row['judul'] ?></span>
                                            <span class="penulis-buku"><?= $row['penulis'] ?></span>
                                        </div>
                                    </td>
                                    <td><?= $row['tahun'] ?></td>
                                    <td>
                                        <span class="badge-status <?= ($row['status'] == 'tersedia') ? 'is-available' : 'is-borrowed' ?>">
                                            <?= ucfirst($row['status']) ?>
                                        </span>
                                    </td>
                                    <td class="text-center">
                                        <div class="action-btns">
                                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn-icon edit" title="Edit"><i class="bi bi-pencil-square"></i></a>
                                            <a href="hapus.php?id=<?= $row['id'] ?>" class="btn-icon delete" title="Hapus" onclick="return confirm('Hapus buku ini?')"><i class="bi bi-trash3"></i></a>
                                        </div>
                                    </td>
                                </tr>
                            <?php } 
                            } else { ?>
                                <tr><td colspan="5" class="text-center py-5 text-muted">Data tidak ditemukan.</td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>