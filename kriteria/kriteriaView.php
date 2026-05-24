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
            <h2><?php echo spk_icon('chart'); ?> Data Kriteria</h2>
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah</button>
        </div>
        <div class="spk-card-body">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Kriteria</th>
                        <th>Tipe</th>
                        <th>Bobot</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_kode");
                    $no = 1;
                    while ($row = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span style="color:var(--gold);font-weight:700;"><?= $row['kriteria_kode'] ?></span></td>
                            <td><?= $row['kriteria_nama'] ?></td>
                            <td>
                                <?php if (strtolower($row['kriteria_kategori']) == 'benefit'): ?>
                                    <span class="badge-benefit">Benefit</span>
                                <?php else: ?>
                                    <span class="badge-cost">Cost</span>
                                <?php endif; ?>
                            </td>
                            <td><strong style="color:var(--gold-lt);"><?= ($row['kriteria_bobot'] * 100) ?>%</strong></td>
                            <td>
                                <div class="action-wrap">
                                    <a href="" class="btn-spk-edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['kriteria_id'] ?>">Edit</a>
                                    <a href="kriteriaDelete.php?id=<?= $row['kriteria_id'] ?>" class="btn-spk-delete" onclick="return confirm('Hapus data ini?')">Hapus</a>
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
                <h5 class="modal-title">Tambah Kriteria</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="kriteriaAdd.php">
                    <div class="form-group">
                        <label class="spk-label">Kode</label>
                        <?php
                        $d = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_id DESC LIMIT 1");
                        if (mysqli_num_rows($d) == 0): ?>
                            <input type="text" class="spk-input" name="kriKode" value="C1" required>
                        <?php else:
                            $last = $d->fetch_assoc();
                            $next = (int)$last['kriteria_id'] + 1; ?>
                            <input type="text" class="spk-input" name="kriKode" value="C<?= $next ?>" required>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="spk-label">Nama Kriteria</label>
                        <input type="text" class="spk-input" name="kriNama" required placeholder="cth: Potensi Pendapatan">
                    </div>
                    <div class="form-group">
                        <label class="spk-label">Tipe</label>
                        <select class="spk-input" name="kriKategori">
                            <option value="Benefit">Benefit</option>
                            <option value="Cost">Cost</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="spk-label">Bobot (desimal, cth: 0.30)</label>
                        <input type="text" class="spk-input" name="kriBobot" required placeholder="0.30">
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
$data = $conn->query("SELECT * FROM ta_kriteria ORDER BY kriteria_id");
while ($row = mysqli_fetch_array($data)): ?>
    <div class="modal fade" id="modalEdit<?= $row['kriteria_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Kriteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="kriteriaEdit.php">
                        <input type="hidden" name="kriId" value="<?= $row['kriteria_id'] ?>">
                        <div class="form-group">
                            <label class="spk-label">Kode</label>
                            <input type="text" class="spk-input" name="kriKode" value="<?= $row['kriteria_kode'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="spk-label">Nama Kriteria</label>
                            <input type="text" class="spk-input" name="kriNama" value="<?= $row['kriteria_nama'] ?>" required>
                        </div>
                        <div class="form-group">
                            <label class="spk-label">Tipe</label>
                            <select class="spk-input" name="kriKategori">
                                <option value="Benefit" <?= strtolower($row['kriteria_kategori']) == 'benefit' ? 'selected' : '' ?>>Benefit</option>
                                <option value="Cost" <?= strtolower($row['kriteria_kategori']) == 'cost' ? 'selected' : '' ?>>Cost</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="spk-label">Bobot</label>
                            <input type="text" class="spk-input" name="kriBobot" value="<?= $row['kriteria_bobot'] ?>" required>
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

<!-- footer -->
<?php include '../blade/footer.php' ?>