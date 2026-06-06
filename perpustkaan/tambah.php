<?php 
include 'koneksi.php';

// Logika Simpan Data
if(isset($_POST['simpan'])){
    $j = mysqli_real_escape_string($conn, $_POST['judul']);
    $p = mysqli_real_escape_string($conn, $_POST['penulis']);
    $t = mysqli_real_escape_string($conn, $_POST['tahun']);
    $s = mysqli_real_escape_string($conn, $_POST['status']);
    
    $query_tambah = "INSERT INTO tb_buku (judul, penulis, tahun, status) VALUES ('$j', '$p', '$t', '$s')";
    $simpan = mysqli_query($conn, $query_tambah);
    
    if($simpan) {
        header("Location: index.php?pesan=success");
    } else {
        $error = "Gagal menambahkan buku baru.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Buku Baru | LibManager Pro</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <style>
        /* Form Styling */
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
        .add-card { max-width: 600px; margin: 0 auto; }
        .input-group-text { border-radius: 10px 0 0 10px; background-color: #f1f5f9; border: 1px solid var(--border-color); }
        .form-control.with-icon { border-radius: 0 10px 10px 0; }
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
                    <h1 class="mb-0">Tambah Koleksi Baru</h1>
                </div>
            </div>
        </header>

        <section class="content-section">
            <div class="data-card add-card">
                <div class="mb-4 text-center">
                    <div class="icon-badge mb-3 mx-auto" style="width: 60px; height: 60px; background: #eef2ff; color: #4f46e5; border-radius: 50%; display: grid; place-items: center; font-size: 1.5rem;">
                        <i class="bi bi-plus-circle-fill"></i>
                    </div>
                    <h4 class="fw-bold mb-1">Registrasi Buku</h4>
                    <p class="text-muted small">Lengkapi formulir di bawah ini untuk menambah inventaris.</p>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger rounded-3 text-sm py-2"><i class="bi bi-exclamation-triangle me-2"></i><?= $error ?></div>
                <?php endif; ?>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Judul Buku</label>
                        <input type="text" name="judul" class="form-control" placeholder="Masukkan judul lengkap buku..." required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Nama Penulis</label>
                        <input type="text" name="penulis" class="form-control" placeholder="Contoh: J.K. Rowling" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label">Tahun Terbit</label>
                            <input type="number" name="tahun" class="form-control" placeholder="Tahun" value="<?= date('Y') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Status Awal</label>
                            <select name="status" class="form-select" required>
                                <option value="tersedia" selected>Tersedia</option>
                                <option value="dipinjam">Dipinjam</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4 opacity-50">

                    <div class="d-flex gap-2">
                        <button type="submit" name="simpan" class="btn btn-indigo flex-grow-1 py-3 shadow-sm">
                            <i class="bi bi-plus-lg me-2"></i> Tambahkan ke Koleksi
                        </button>
                        <a href="index.php" class="btn btn-light px-4 py-3" style="border-radius: 10px; font-weight: 600; color: #64748b;">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>

</body>
</html>