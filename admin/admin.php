<?php
//login
session_start();

if (!isset($_SESSION["login_admin"])) {
    header("location: ../login/adminLogin.php");
    exit();
}
?>

<?php
// koneksi
include __DIR__ . '/../tools/connection.php';
// icon
include __DIR__ . '/../blade/icon.php';
// header
include __DIR__ . '/../blade/header.php';
?>

<?php include __DIR__ . '/../blade/namaProgram.php'; ?>
<?php include __DIR__ . '/../blade/navAdmin.php'; ?>

<div class="spk-main">

    <div class="spk-card" style="margin-top:18px;">
        <div class="spk-card-header">
            <h2>Dashboard Admin</h2>
        </div>
        <div class="spk-card-body">
            <p class="text-muted-spk">Selamat datang, Admin. Gunakan panel ini untuk mengelola data aplikasi.</p>

            <?php
            // ringkasan cepat: hitung jumlah record
            $countAlt = $conn->query("SELECT COUNT(*) AS cnt FROM ta_alternatif")->fetch_assoc()['cnt'];
            $countKri = $conn->query("SELECT COUNT(*) AS cnt FROM ta_kriteria")->fetch_assoc()['cnt'];
            $countUser = $conn->query("SELECT COUNT(*) AS cnt FROM ta_user")->fetch_assoc()['cnt'];
            $countNilai = $conn->query("SELECT COUNT(*) AS cnt FROM tb_nilai")->fetch_assoc()['cnt'];
            ?>

            <div class="stat-grid">
                <div class="stat-card">
                    <div class="num"><?= $countAlt ?></div>
                    <div class="label">Alternatif</div>
                </div>
                <div class="stat-card">
                    <div class="num"><?= $countKri ?></div>
                    <div class="label">Kriteria</div>
                </div>
                <div class="stat-card">
                    <div class="num"><?= $countNilai ?></div>
                    <div class="label">Nilai</div>
                </div>
                <div class="stat-card">
                    <div class="num"><?= $countUser ?></div>
                    <div class="label">User</div>
                </div>
            </div>

            <div class="divider"></div>

            <p class="text-muted-spk small">Admin hanya dapat menambah pengguna melalui halaman "Pengguna". Tugas manajemen lain tidak tersedia di akun ini.</p>
        </div>
    </div>
</div>

<?php include __DIR__ . '/../blade/footer.php' ?>