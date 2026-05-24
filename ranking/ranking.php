<?php
session_start();
if (!isset($_SESSION["login_user"]) && !isset($_SESSION["login_admin"])) {
    header("location: ../login/userLogin.php");
    exit();
}
include __DIR__ . '/../tools/connection.php';
include __DIR__ . '/../blade/header.php';
$ranks = [];
?>
<?php include __DIR__ . '/../blade/namaProgram.php'; ?>
<?php include __DIR__ . '/../blade/nav.php'; ?>

<div class="spk-main">

    <!-- Tombol Cetak -->
    <div style="display:flex;justify-content:flex-end;margin-bottom:16px;">
        <button class="btn-spk-primary" onclick="window.open('../cetak/cetakPDF.php','_blank')">Cetak PDF</button>
    </div>

    <!-- Tabel 1: Nilai Awal -->
    <div class="spk-card" style="margin-bottom:20px;">
        <div class="spk-card-header">
            <h2>Langkah 1 · Tabel Nilai Awal</h2>
        </div>
        <div class="spk-card-body" style="overflow-x:auto;">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Package</th>
                        <?php
                        $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                        $kriteriaRows = mysqli_num_rows($data);
                        ?>
                        <th colspan="<?= $kriteriaRows ?>" style="text-align:center;">Nilai per Kriteria</th>
                    </tr>
                    <tr>
                        <?php $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                        while ($k = $data->fetch_assoc()): ?>
                            <th title="<?= $k['kriteria_nama'] ?>"><?= $k['kriteria_kode'] ?></th>
                        <?php endwhile; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $data = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
                    $no = 1;
                    while ($alt = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span style="color:var(--gold);font-weight:700;"><?= $alt['alternatif_kode'] ?></span> <?= $alt['alternatif_nama'] ?></td>
                            <?php $sql = $conn->query("SELECT * FROM tb_nilai WHERE alternatif_kode='{$alt['alternatif_kode']}' ORDER BY kriteria_kode");
                            while ($n = $sql->fetch_assoc()): ?>
                                <td style="text-align:center;"><?= $n['nilai_faktor'] ?></td>
                            <?php endwhile; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel 2: Nilai Utiliti -->
    <div class="spk-card" style="margin-bottom:20px;">
        <div class="spk-card-header">
            <h2>Langkah 2 · Tabel Nilai Utiliti</h2>
            <span style="font-size:0.75rem;color:var(--muted);">Rumus Benefit: (nilai − Cmin) / (Cmax − Cmin)</span>
        </div>
        <div class="spk-card-body" style="overflow-x:auto;">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Package</th>
                        <?php $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                        $kriteriaRows = mysqli_num_rows($data); ?>
                        <th colspan="<?= $kriteriaRows ?>" style="text-align:center;">Nilai Utiliti per Kriteria</th>
                    </tr>
                    <tr>
                        <?php $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                        while ($k = $data->fetch_assoc()): ?>
                            <th title="<?= $k['kriteria_nama'] ?>"><?= $k['kriteria_kode'] ?></th>
                        <?php endwhile; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $data = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
                    $no = 1;
                    while ($alt = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span style="color:var(--gold);font-weight:700;"><?= $alt['alternatif_kode'] ?></span> <?= $alt['alternatif_nama'] ?></td>
                            <?php $sql = $conn->query("SELECT * FROM tb_nilai WHERE alternatif_kode='{$alt['alternatif_kode']}' ORDER BY kriteria_kode");
                            while ($n = $sql->fetch_assoc()):
                                $kk = $n['kriteria_kode'];
                                $kr = $conn->query("SELECT * FROM ta_kriteria WHERE kriteria_kode='$kk'")->fetch_assoc();
                                $mx = $conn->query("SELECT MAX(nilai_faktor) AS max FROM tb_nilai WHERE kriteria_kode='$kk'")->fetch_assoc()['max'];
                                $mn = $conn->query("SELECT MIN(nilai_faktor) AS min FROM tb_nilai WHERE kriteria_kode='$kk'")->fetch_assoc()['min'];
                                if ($mx == $mn) {
                                    $u = 0;
                                } elseif (strtolower($kr['kriteria_kategori']) == 'benefit') {
                                    $u = ($n['nilai_faktor'] - $mn) / ($mx - $mn);
                                } else {
                                    $u = ($mx - $n['nilai_faktor']) / ($mx - $mn);
                                }
                            ?>
                                <td style="text-align:center;"><?= number_format($u, 2) ?></td>
                            <?php endwhile; ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel 3: Nilai Preferensi -->
    <div class="spk-card" style="margin-bottom:20px;">
        <div class="spk-card-header">
            <h2>Langkah 3 · Tabel Nilai Preferensi</h2>
            <span style="font-size:0.75rem;color:var(--muted);">Nilai Utiliti × Bobot Kriteria</span>
        </div>
        <div class="spk-card-body" style="overflow-x:auto;">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Package</th>
                        <?php $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                        $kriteriaRows = mysqli_num_rows($data); ?>
                        <th colspan="<?= $kriteriaRows ?>" style="text-align:center;">Preferensi per Kriteria</th>
                        <th rowspan="2">Nilai Akhir</th>
                    </tr>
                    <tr>
                        <?php $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                        while ($k = $data->fetch_assoc()): ?>
                            <th title="<?= $k['kriteria_nama'] ?>"><?= $k['kriteria_kode'] ?></th>
                        <?php endwhile; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php $data = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
                    $no = 1;
                    while ($alt = $data->fetch_assoc()):
                        $total = 0;
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span style="color:var(--gold);font-weight:700;"><?= $alt['alternatif_kode'] ?></span> <?= $alt['alternatif_nama'] ?></td>
                            <?php $sql = $conn->query("SELECT * FROM tb_nilai WHERE alternatif_kode='{$alt['alternatif_kode']}' ORDER BY kriteria_kode");
                            while ($n = $sql->fetch_assoc()):
                                $kk = $n['kriteria_kode'];
                                $kr = $conn->query("SELECT * FROM ta_kriteria WHERE kriteria_kode='$kk'")->fetch_assoc();
                                $mx = $conn->query("SELECT MAX(nilai_faktor) AS max FROM tb_nilai WHERE kriteria_kode='$kk'")->fetch_assoc()['max'];
                                $mn = $conn->query("SELECT MIN(nilai_faktor) AS min FROM tb_nilai WHERE kriteria_kode='$kk'")->fetch_assoc()['min'];
                                if ($mx == $mn) {
                                    $u = 0;
                                } elseif (strtolower($kr['kriteria_kategori']) == 'benefit') {
                                    $u = ($n['nilai_faktor'] - $mn) / ($mx - $mn);
                                } else {
                                    $u = ($mx - $n['nilai_faktor']) / ($mx - $mn);
                                }
                                $pref = $u * $kr['kriteria_bobot'];
                                $total += $pref;
                            ?>
                                <td style="text-align:center;"><?= number_format($pref, 2) ?></td>
                            <?php endwhile; ?>
                            <td style="text-align:center;"><strong style="color:var(--gold-lt);"><?= number_format($total, 4) ?></strong></td>
                            <?php
                            $ranks[] = ['nilai' => $total, 'nama' => $alt['alternatif_nama'], 'kode' => $alt['alternatif_kode']];
                            ?>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Tabel 4: Ranking Final -->
    <?php
    $hasRanks = count($ranks) > 0;
    if ($hasRanks) {
        usort($ranks, fn($a, $b) => $b['nilai'] <=> $a['nilai']);
        $maxVal = $ranks[0]['nilai'];
    }
    ?>
    <div class="spk-card">
        <div class="spk-card-header">
            <?php include __DIR__ . '/../blade/icon.php'; ?>
            <h2><?php echo spk_icon('trophy'); ?> Hasil Akhir & Perankingan</h2>
        </div>
        <div class="spk-card-body">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th>Rank</th>
                        <th>Kode</th>
                        <th>Nama Package</th>
                        <th>Nilai SMART</th>
                        <th>Progress</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!$hasRanks): ?>
                        <tr>
                            <td colspan="6" style="text-align:center;padding:20px;color:var(--muted);">Belum ada data ranking. Pastikan alternatif dan nilai sudah terisi.</td>
                        </tr>
                        <?php else:
                        foreach ($ranks as $i => $r):
                            $rank = $i + 1;
                            $pct = $maxVal > 0 ? ($r['nilai'] / $maxVal) * 100 : 0;
                            $recommended = $rank <= 3;
                        ?>
                            <tr>
                                <td>
                                    <?php if ($rank == 1): ?>
                                        <span class="badge-rank badge-rank-1">1</span>
                                    <?php elseif ($rank == 2): ?>
                                        <span class="badge-rank badge-rank-2">2</span>
                                    <?php elseif ($rank == 3): ?>
                                        <span class="badge-rank badge-rank-3">3</span>
                                    <?php else: ?>
                                        <span style="color:var(--muted);font-weight:600;"><?= $rank ?></span>
                                    <?php endif; ?>
                                </td>
                                <td><span style="color:var(--gold);font-weight:700;"><?= $r['kode'] ?></span></td>
                                <td><?= $r['nama'] ?></td>
                                <td><strong style="color:var(--gold-lt);"><?= number_format($r['nilai'], 4) ?></strong></td>
                                <td>
                                    <div class="rank-bar-wrap">
                                        <div class="rank-bar-bg">
                                            <div class="rank-bar-fill" style="width:<?= $pct ?>%"></div>
                                        </div>
                                        <span class="rank-val"><?= number_format($pct, 0) ?>%</span>
                                    </div>
                                </td>
                                <td>
                                    <?php if ($recommended): ?>
                                        <span style="display:inline-flex;align-items:center;gap:5px;padding:4px 12px;background:rgba(60,185,142,0.15);color:var(--success);border:1px solid rgba(60,185,142,0.3);border-radius:20px;font-size:0.78rem;font-weight:600;">
                                            ✓ Direkomendasikan
                                        </span>
                                    <?php else: ?>
                                        <span style="color:var(--muted);font-size:0.8rem;">–</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                    <?php endforeach;
                    endif; ?>
                </tbody>
            </table>

            <?php if ($hasRanks): ?>
                <!-- Highlight 3 teratas -->
                <div style="margin-top:24px;padding:20px;background:rgba(212,168,75,0.06);border:1px solid rgba(212,168,75,0.2);border-radius:10px;">
                    <p style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--gold);margin-bottom:12px;"><svg width="18" height="18" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" style="vertical-align:middle;margin-right:6px;fill:currentColor">
                            <path d="M12 2l2.9 6.26L22 9.27l-5 4.87L18.18 22 12 18.56 5.82 22 7 14.14l-5-4.87 7.1-1.01L12 2z" />
                        </svg>3 Package Unggulan yang Direkomendasikan:</p>
                    <?php foreach (array_slice($ranks, 0, 3) as $i => $r): ?>
                        <div style="display:flex;align-items:center;gap:10px;margin-bottom:8px;">
                            <span style="font-weight:800;color:var(--gold);min-width:20px;"><?= $i + 1 ?>.</span>
                            <span style="color:var(--white);"><?= $r['nama'] ?></span>
                            <span style="color:var(--muted);font-size:0.82rem;">(<?= number_format($r['nilai'], 4) ?>)</span>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php include '../blade/footer.php'; ?>