<?php 
include 'koneksi.php';

$id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : '';
if($id == "") { header("Location: anggota.php"); exit; }

// Ambil data anggota
$query = mysqli_query($conn, "SELECT * FROM tb_anggota WHERE id='$id'");
$data = mysqli_fetch_assoc($query);

if(isset($_POST['update'])){
    $nama = mysqli_real_escape_string($conn, $_POST['nama']);
    $nim  = mysqli_real_escape_string($conn, $_POST['nim_nis']);
    $jur  = mysqli_real_escape_string($conn, $_POST['jurusan']);
    $telp = mysqli_real_escape_string($conn, $_POST['telepon']);
    
    $update = mysqli_query($conn, "UPDATE tb_anggota SET nama='$nama', nim_nis='$nim', jurusan='$jur', telepon='$telp' WHERE id='$id'");
    
    if($update) {
        header("Location: anggota.php?pesan=updated");
    } else {
        $error = "Gagal mengupdate data.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Anggota | LibManager Pro</title>
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
            <a href="index.php" class="nav-item"><i class="bi bi-grid-1x2-fill"></i> <span>Dashboard</span></a>
            <a href="anggota.php" class="nav-item active"><i class="bi bi-people-fill"></i> <span>Anggota</span></a>
        </nav>
    </aside>

    <main class="main-content">
        <header class="top-header">
            <div class="d-flex align-items-center gap-3">
                <a href="anggota.php" class="btn btn-outline-secondary btn-sm rounded-circle" style="width: 35px; height: 35px; display: grid; place-items: center;">
                    <i class="bi bi-arrow-left"></i>
                </a>
                <h1>Edit Data Anggota</h1>
            </div>
        </header>

        <section class="content-section">
            <div class="data-card" style="max-width: 600px; margin: 0 auto;">
                <form action="" method="POST">
                    <div class="mb-3">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" name="nama" class="form-control" value="<?= htmlspecialchars($data['nama']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">NIM / NIS</label>
                        <input type="text" name="nim_nis" class="form-control" value="<?= htmlspecialchars($data['nim_nis']) ?>" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Jurusan</label>
                        <input type="text" name="jurusan" class="form-control" value="<?= htmlspecialchars($data['jurusan']) ?>" required>
                    </div>
                    <div class="mb-4">
                        <label class="form-label">Nomor WhatsApp</label>
                        <input type="number" name="telepon" class="form-control" value="<?= htmlspecialchars($data['telepon']) ?>" required>
                    </div>

                    <div class="d-flex gap-2">
                        <button type="submit" name="update" class="btn btn-indigo flex-grow-1 py-3 shadow-sm">
                            <i class="bi bi-cloud-check me-2"></i> Update Data
                        </button>
                        <a href="anggota.php" class="btn btn-light px-4 py-3" style="border-radius: 10px; font-weight: 600; color: #64748b;">Batal</a>
                    </div>
                </form>
            </div>
        </section>
    </main>
</div>
</body>
</html>