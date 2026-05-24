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
            <h2><?php echo spk_icon('bookmark'); ?> Data Sub Kriteria</h2>
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah</button>
        </div>
        <div class="spk-card-body">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kriteria</th>
                        <th>Kode Sub</th>
                        <th>Keterangan</th>
                        <th>Nilai/Bobot</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $conn->query("SELECT * FROM ta_subkriteria INNER JOIN ta_kriteria ON ta_subkriteria.kriteria_kode = ta_kriteria.kriteria_kode ORDER BY ta_subkriteria.kriteria_kode, subkriteria_bobot");
                    $no = 1;
                    while ($row = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span style="color:var(--gold);font-weight:700;"><?= $row['kriteria_kode'] ?></span> <?= $row['kriteria_nama'] ?></td>
                            <td><?= $row['subkriteria_kode'] ?></td>
                            <td><?= $row['subkriteria_keterangan'] ?></td>
                            <td><strong style="color:var(--teal);"><?= $row['subkriteria_bobot'] ?></strong></td>
                            <td>
                                <div class="action-wrap">
                                    <a href="" class="btn-spk-edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['subkriteria_id'] ?>">Edit</a>
                                    <a href="subkriteriaDelete.php?id=<?= $row['subkriteria_id'] ?>" class="btn-spk-delete" onclick="return confirm('Hapus data ini?')">Hapus</a>
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
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Sub Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="subkriteriaAdd.php">
                    <div class="form-group">
                        <label class="spk-label">Kode</label>
                        <?php
                        $d = $conn->query("SELECT * FROM ta_subkriteria ORDER BY subkriteria_id DESC LIMIT 1");
                        if (mysqli_num_rows($d) == 0): ?>
                            <input type="text" class="spk-input" name="subkriKode" value="SC1-1" required>
                        <?php else:
                            $last = $d->fetch_assoc();
                            $next = (int)$last['subkriteria_id'] + 1; ?>
                            <input type="text" class="spk-input" name="subkriKode" value="SC<?= $next ?>" required>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="spk-label">Kriteria</label>
                        <select class="spk-input" name="kriKode">
                            <option>Pilih Kriteria...</option>
                            <?php
                            $d = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                            while ($k = $d->fetch_assoc()): ?>
                                <option value="<?= $k['kriteria_kode'] ?>"><?= $k['kriteria_kode'] ?> – <?= $k['kriteria_nama'] ?></option>
                            <?php endwhile; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="spk-label">Nilai/Bobot</label>
                        <select class="spk-input" name="subkriBobot">
                            <option value="1">1 – Sangat Rendah</option>
                            <option value="2">2 – Rendah</option>
                            <option value="3">3 – Sedang</option>
                            <option value="4">4 – Tinggi</option>
                            <option value="5">5 – Sangat Tinggi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="spk-label">Keterangan</label>
                        <input type="text" class="spk-input" name="subkriKeterangan" required placeholder="cth: Sangat Tinggi">
                    </div>
                    <div style="text-align:right;margin-top:20px;">
                        <button type="submit" name="save" class="btn-spk-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal Edit -->
<?php
$data = $conn->query("SELECT * FROM ta_subkriteria ORDER BY subkriteria_id");
while ($row = mysqli_fetch_array($data)): ?>
    <div class="modal fade" id="modalEdit<?= $row['subkriteria_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Sub Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="subkriteriaEdit.php">
                        <input type="hidden" name="subkriId" value="<?= $row['subkriteria_id'] ?>">
                        <div class="form-group">
                            <label class="spk-label">Kode</label>
                            <input type="text" class="spk-input" name="subkriKode" value="<?= $row['subkriteria_kode'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="spk-label">Kriteria</label>
                            <select class="spk-input" name="kriKode">
                                <?php
                                $sql = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                                while ($k = mysqli_fetch_array($sql)): ?>
                                    <option value="<?= $k['kriteria_kode'] ?>" <?= $k['kriteria_kode'] == $row['kriteria_kode'] ? 'selected' : '' ?>>
                                        <?= $k['kriteria_kode'] ?> – <?= $k['kriteria_nama'] ?>
                                    </option>
                                <?php endwhile; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="spk-label">Nilai/Bobot</label>
                            <select class="spk-input" name="subkriBobot">
                                <?php foreach ([1, 2, 3, 4, 5] as $v): ?>
                                    <option value="<?= $v ?>" <?= $row['subkriteria_bobot'] == $v ? 'selected' : '' ?>><?= $v ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="spk-label">Keterangan</label>
                            <input type="text" class="spk-input" name="subkriKeterangan" value="<?= $row['subkriteria_keterangan'] ?>">
                        </div>
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