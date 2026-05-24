<?php
session_start();
if (!isset($_SESSION["login_user"]) && !isset($_SESSION["login_admin"])) {
    header("location: ../login/userLogin.php");
    exit();
}
include __DIR__ . '/../tools/connection.php';
include __DIR__ . '/../blade/header.php';
?>
<?php include __DIR__ . '/../blade/namaProgram.php'; ?>
<?php include __DIR__ . '/../blade/nav.php'; ?>
<?php include __DIR__ . '/../blade/icon.php'; ?>

<div class="spk-main">
    <div class="spk-card">
        <div class="spk-card-header">
            <h2><?php echo spk_icon('gear'); ?> Data Nilai Faktor</h2>
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah</button>
        </div>
        <div class="spk-card-body" style="overflow-x:auto;">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th rowspan="2">No</th>
                        <th rowspan="2">Nama Package</th>
                        <?php
                        $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                        $kriteriaRows = mysqli_num_rows($data);
                        ?>
                        <th colspan="<?= $kriteriaRows ?>" style="text-align:center;">Nilai per Kriteria</th>
                        <th rowspan="2">Aksi</th>
                    </tr>
                    <tr>
                        <?php
                        $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                        while ($k = $data->fetch_assoc()): ?>
                            <th title="<?= $k['kriteria_nama'] ?>"><?= $k['kriteria_kode'] ?></th>
                        <?php endwhile; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
                    $no = 1;
                    while ($alt = $data->fetch_assoc()):
                        $alt_kode = $alt['alternatif_kode'];
                        $nilaiCheck = $conn->query("SELECT COUNT(*) as n FROM tb_nilai WHERE alternatif_kode='$alt_kode'")->fetch_assoc()['n'];
                    ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td>
                                <span style="color:var(--gold);font-weight:700;font-size:0.8rem;"><?= $alt_kode ?></span><br>
                                <?= $alt['alternatif_nama'] ?>
                            </td>
                            <?php if ($nilaiCheck > 0):
                                $sql = $conn->query("SELECT * FROM tb_nilai WHERE alternatif_kode='$alt_kode' ORDER BY kriteria_kode");
                                while ($n = $sql->fetch_assoc()): ?>
                                    <td style="text-align:center;"><strong style="color:var(--teal)"><?= $n['nilai_faktor'] ?></strong></td>
                                <?php endwhile;
                            else: ?>
                                <?php $kr = $conn->query("SELECT COUNT(*) as n FROM ta_kriteria")->fetch_assoc()['n'];
                                for ($i = 0; $i < $kr; $i++): ?>
                                    <td style="text-align:center;color:var(--muted);">–</td>
                                <?php endfor; ?>
                            <?php endif; ?>
                            <td>
                                <div class="action-wrap">
                                    <a href="" class="btn-spk-edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $alt_kode ?>">Edit</a>
                                    <a href="faktorDelete.php?id=<?= $alt_kode ?>" class="btn-spk-delete" onclick="return confirm('Hapus semua nilai untuk alternatif ini?')">Hapus</a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Modal Add -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Input Nilai Faktor</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="faktorAdd.php">
                    <div class="form-group">
                        <label class="spk-label">Pilih Alternatif</label>
                        <select class="spk-input" name="altKode">
                            <option>Pilih Package...</option>
                            <?php
                            $d = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
                            while ($a = $d->fetch_assoc()): ?>
                                <option value="<?= $a['alternatif_kode'] ?>"><?= $a['alternatif_kode'] ?> – <?= $a['alternatif_nama'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <hr class="divider">
                    <p class="spk-label" style="margin-bottom:14px;">Nilai tiap kriteria (1=Sangat Rendah s/d 5=Sangat Tinggi)</p>
                    <?php
                    $d = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                    while ($k = $d->fetch_assoc()): ?>
                        <div class="form-group">
                            <label class="spk-label"><?= $k['kriteria_kode'] ?> – <?= $k['kriteria_nama'] ?></label>
                            <input type="hidden" name="kriKode[]" value="<?= $k['kriteria_kode'] ?>">
                            <select class="spk-input" name="nilaiFaktor[]">
                                <option>Pilih Nilai...</option>
                                <?php
                                $kri = $k['kriteria_kode'];
                                $sub = $conn->query("SELECT * FROM ta_subkriteria WHERE kriteria_kode='$kri' ORDER BY subkriteria_bobot");
                                while ($s = $sub->fetch_assoc()): ?>
                                    <option value="<?= $s['subkriteria_bobot'] ?>"><?= $s['subkriteria_bobot'] ?> – <?= $s['subkriteria_keterangan'] ?></option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                    <?php endwhile; ?>
                    <div style="text-align:right;margin-top:20px;">
                        <button type="submit" name="save" class="btn-spk-primary">Simpan Nilai</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php
$data = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
while ($alt = mysqli_fetch_array($data)):
    $alt_kode = $alt['alternatif_kode'];
?>
    <div class="modal fade" id="modalEdit<?= $alt_kode ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Nilai – <?= $alt['alternatif_nama'] ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="faktorEdit.php">
                        <?php
                        $sql = $conn->query("SELECT * FROM tb_nilai WHERE alternatif_kode='$alt_kode' ORDER BY kriteria_kode");
                        while ($n = $sql->fetch_assoc()):
                            $kri = $n['kriteria_kode'];
                            $sqli = $conn->query("SELECT * FROM ta_kriteria WHERE kriteria_kode='$kri'");
                            $dk = $sqli->fetch_assoc();
                        ?>
                            <div class="form-group">
                                <input type="hidden" name="nilaiId[]" value="<?= $n['nilai_id'] ?>">
                                <input type="hidden" name="altKode[]" value="<?= $n['alternatif_kode'] ?>">
                                <input type="hidden" name="kriKode[]" value="<?= $n['kriteria_kode'] ?>">
                                <label class="spk-label"><?= $dk['kriteria_kode'] ?> – <?= $dk['kriteria_nama'] ?></label>
                                <select class="spk-input" name="nilaiFaktor[]">
                                    <?php
                                    $sub = $conn->query("SELECT * FROM ta_subkriteria WHERE kriteria_kode='$kri' ORDER BY subkriteria_bobot");
                                    while ($s = $sub->fetch_assoc()): ?>
                                        <option value="<?= $s['subkriteria_bobot'] ?>" <?= $s['subkriteria_bobot'] == $n['nilai_faktor'] ? 'selected' : '' ?>>
                                            <?= $s['subkriteria_bobot'] ?> – <?= $s['subkriteria_keterangan'] ?>
                                        </option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        <?php endwhile; ?>
                        <div style="text-align:right;margin-top:20px;">
                            <button type="submit" name="update" class="btn-spk-primary" style="background:linear-gradient(135deg,var(--teal),#26a69a);box-shadow:none;">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php endwhile; ?>

<?php include '../blade/footer.php'; ?>