<?php 
include 'koneksi.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';

// Jika tidak ada ID, balikkan ke index
if ($id == "") { header("Location: index.php"); exit; }

// Ambil data buku saat ini
$query_data = mysqli_query($conn, "SELECT * FROM tb_buku WHERE id='$id'");
$data = mysqli_fetch_assoc($query_data);

// Jika data tidak ditemukan
if (!$data) { echo "Data tidak ditemukan!"; exit; }

// Logika Update
if(isset($_POST['update'])){
    $j = mysqli_real_escape_string($conn, $_POST['judul']);
    $p = mysqli_real_escape_string($conn, $_POST['penulis']);
    $t = mysqli_real_escape_string($conn, $_POST['tahun']);
    $s = mysqli_real_escape_string($conn, $_POST['status']);
    
    $update = mysqli_query($conn, "UPDATE tb_buku SET judul='$j', penulis='$p', tahun='$t', status='$s' WHERE id='$id'");
    
    if($update) {
        header("Location: index.php?pesan=updated");
    } else {
        $error = "Gagal memperbarui data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Buku | LibManager Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Tambahan khusus untuk form agar lebih manis */
        .form-label { font-weight: 600; color: var(--text-dark); font-size: 0.9rem; margin-bottom: 8px; }
        .form-control, .form-select { 
            padding: 12px 15px; 
            border-radius: 10px; 
            border: 1px solid var(--border-color); 
            background-color: var(--body-bg);
        }
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-indigo);
            box-shadow: 0 0 0 4px rgba(79, 70, 229, 0.1);
            background-color: #fff;
        }
        .edit-card { max-width: 600px; margin: 0 auto; }
    </style>
</head>
<body>

<div class="app-container">
    <aside class="sidebar">
        <div class="sidebar-header">
            <div class="logo-icon"><i class="bi bi-book-half"></i></div>
            <span class="logo-text">LibManager</span>
        </div>
        <nav class="sidebar-nav">
            <a href="index.php" class="nav-item">
                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>
            </a>
            <a href="#" class="nav-item">
                <i class="bi bi-people-fill"></i>
                <span>Anggota</span>
            </a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div class="header-info">
                <div class="d-flex align-items-center gap-3">
                    <a href="index.php" class="btn btn-outline-secondary btn-sm rounded-circle" style="width: 35px; height: 35px; display: grid; place-items: center;">
                        <i class="bi bi-arrow-left"></i>
                    </a>
                    <h1 class="mb-0">Edit Informasi Buku</h1>
                </div>
            </div>
        </header>

        <section class="content-section">
            <div class="data-card edit-card">
                <div class="mb-4">
                    <h4 class="fw-bold mb-1">Detail Buku</h4>
                    <p class="text-muted small">Perbarui data koleksi Anda pada form di bawah ini.</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger rounded-3"><?= $error ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" value="<?= htmlspecialchars($data['judul']) ?>" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Penulis</label>
                        <input type="text" name="penulis" class="form-control" value="<?= htmlspecialchars($data['penulis']) ?>" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun" class="form-control" value="<?= htmlspecialchars($data['tahun']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Ketersediaan</label>
                            <select name="status" class="form-select" required>
                                <option value="tersedia" <?= ($data['status'] == 'tersedia') ? 'selected' : '' ?>>Tersedia</option>
                                <option value="dipinjam" <?= ($data['status'] == 'dipinjam') ? 'selected' : '' ?>>Dipinjam</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <div class="d-flex gap-2">
                        <button type="submit" name="update" class="btn btn-indigo flex-grow-1 py-3 shadow-sm">
                            <i class="bi bi-cloud-check me-2"></i> Simpan Perubahan
                        </button>
                        <a href="index.php" class="btn btn-light px-4 py-3" style="border-radius: 10px; font-weight: 600;">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>

</body>
</html>