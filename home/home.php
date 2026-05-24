<?php
session_start();
if (!isset($_SESSION["login_user"]) && !isset($_SESSION["login_admin"])) {
    header("location: ../login/userLogin.php");
    exit();
}
include '../tools/connection.php';
include '../blade/header.php';
$jmlAlt = $conn->query("SELECT COUNT(*) as n FROM ta_alternatif")->fetch_assoc()['n'];
$jmlKri = $conn->query("SELECT COUNT(*) as n FROM ta_kriteria")->fetch_assoc()['n'];
$jmlSub = $conn->query("SELECT COUNT(*) as n FROM ta_subkriteria")->fetch_assoc()['n'];
$jmlNil = $conn->query("SELECT COUNT(DISTINCT alternatif_kode) as n FROM tb_nilai")->fetch_assoc()['n'];
?>
<?php include '../blade/namaProgram.php'; ?>
<?php include '../blade/nav.php'; ?>

<div class="spk-main">
    <!-- Stats -->
    <div class="stat-grid">
        <div class="stat-card">
            <div class="num"><?= $jmlAlt ?></div>
            <div class="label">Alternatif</div>
        </div>
        <div class="stat-card">
            <div class="num"><?= $jmlKri ?></div>
            <div class="label">Kriteria</div>
        </div>
        <div class="stat-card">
            <div class="num"><?= $jmlSub ?></div>
            <div class="label">Sub Kriteria</div>
        </div>
        <div class="stat-card">
            <div class="num"><?= $jmlNil ?></div>
            <div class="label">Data Nilai Terisi</div>
        </div>
    </div>

    <div class="spk-card">
        <div class="spk-card-header">
            <h2>Tentang Sistem Ini</h2>
        </div>
        <div class="spk-card-body">
            <p style="color:var(--muted);line-height:1.7;margin-bottom:20px;">
                Sistem ini menggunakan metode <strong style="color:var(--gold)">SMART (Simple Multi-Attribute Rating Technique)</strong>
                untuk menentukan <strong style="color:var(--white)">3 Package Unggulan</strong> CV Ruarasa Lombok
                yang paling layak diprioritaskan dalam kegiatan penjualan dan promosi.
            </p>
            <hr class="divider">
            <p style="color:var(--muted);font-size:0.85rem;font-weight:600;text-transform:uppercase;letter-spacing:0.05em;margin-bottom:14px;">
                Alur Penggunaan Sistem
            </p>
            <div style="display:flex;flex-direction:column;gap:10px;">
                <?php
                $steps = [
                    ['num' => '1', 'title' => 'Kriteria', 'desc' => 'Pastikan 5 kriteria sudah ada (C1–C5) beserta bobotnya', 'href' => '../kriteria/kriteriaView.php'],
                    ['num' => '2', 'title' => 'Sub Kriteria', 'desc' => 'Pastikan skala nilai (1–5) untuk setiap kriteria sudah ada', 'href' => '../subKriteria/subKriteriaView.php'],
                    ['num' => '3', 'title' => 'Alternatif', 'desc' => 'Pastikan 6 package event (A1–A6) sudah terdaftar', 'href' => '../alternatif/alternatifView.php'],
                    ['num' => '4', 'title' => 'Faktor / Nilai', 'desc' => 'Input skor setiap alternatif terhadap setiap kriteria', 'href' => '../faktor/faktorView.php'],
                    ['num' => '5', 'title' => 'Ranking', 'desc' => 'Lihat hasil perhitungan SMART dan rekomendasi 3 package terbaik', 'href' => '../ranking/ranking.php'],
                ];
                foreach ($steps as $s): ?>
                    <div style="display:flex;align-items:center;gap:14px;padding:12px 16px;background:rgba(255,255,255,0.03);border-radius:8px;border:1px solid rgba(255,255,255,0.06);">
                        <div style="width:32px;height:32px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--gold-lt));display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;color:var(--navy);font-size:0.85rem;flex-shrink:0;">
                            <?= $s['num'] ?>
                        </div>
                        <div style="flex:1;">
                            <div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:0.9rem;"><?= $s['title'] ?></div>
                            <div style="color:var(--muted);font-size:0.8rem;"><?= $s['desc'] ?></div>
                        </div>
                        <a href="<?= $s['href'] ?>" class="btn-spk-edit" style="flex-shrink:0;">Buka →</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php include '../blade/footer.php'; ?>