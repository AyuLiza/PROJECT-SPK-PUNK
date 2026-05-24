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
            <h2><?php echo spk_icon('box'); ?> Data Alternatif</h2>
            <button class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah</button>
        </div>
        <div class="spk-card-body">
            <table class="spk-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Kode</th>
                        <th>Nama Package</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $data = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
                    $no = 1;
                    while ($row = $data->fetch_assoc()): ?>
                        <tr>
                            <td><?= $no++ ?></td>
                            <td><span style="color:var(--gold);font-weight:700;"><?= $row['alternatif_kode'] ?></span></td>
                            <td><?= $row['alternatif_nama'] ?></td>
                            <td>
                                <div class="action-wrap">
                                    <a href="" class="btn-spk-edit" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $row['alternatif_id'] ?>">Edit</a>
                                    <a href="alternatifDelete.php?id=<?= $row['alternatif_id'] ?>" class="btn-spk-delete" onclick="return confirm('Hapus data ini?')">Hapus</a>
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
                <h5 class="modal-title">Tambah Alternatif</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="alternatifAdd.php">
                    <div class="form-group">
                        <label class="spk-label">Kode</label>
                        <?php
                        $d = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_id DESC LIMIT 1");
                        $total = mysqli_num_rows($d);
                        if ($total == 0): ?>
                            <input type="text" class="spk-input" name="altKode" value="A001" required>
                        <?php else:
                            $last = $d->fetch_assoc();
                            $next = (int)$last['alternatif_id'] + 1;
                            $kode = 'A' . str_pad($next, 3, '0', STR_PAD_LEFT); ?>
                            <input type="text" class="spk-input" name="altKode" value="<?= $kode ?>" required>
                        <?php endif; ?>
                    </div>
                    <div class="form-group">
                        <label class="spk-label">Nama Package</label>
                        <input type="text" class="spk-input" name="altNama" required placeholder="cth: Wedding Package">
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
$data = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_id");
while ($row = mysqli_fetch_array($data)): ?>
    <div class="modal fade" id="modalEdit<?= $row['alternatif_id'] ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Alternatif</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="alternatifEdit.php">
                        <input type="hidden" name="altId" value="<?= $row['alternatif_id'] ?>">
                        <div class="form-group">
                            <label class="spk-label">Kode</label>
                            <input type="text" class="spk-input" name="altKode" value="<?= $row['alternatif_kode'] ?>">
                        </div>
                        <div class="form-group">
                            <label class="spk-label">Nama Package</label>
                            <input type="text" class="spk-input" name="altNama" value="<?= $row['alternatif_nama'] ?>" required>
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