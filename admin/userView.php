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
            <h2>Data User</h2>
            <div>
                <button type="button" class="btn-spk-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">+ Tambah User</button>
            </div>
        </div>
        <div class="spk-card-body">
            <p class="text-muted-spk">Kelola akun pengguna. Admin hanya dapat menambahkan user melalui form di bawah.</p>

            <div style="overflow-x:auto;">
                <table class="spk-table">
                    <thead>
                        <tr>
                            <th style="width:60px">No</th>
                            <th>User Kode</th>
                            <th>User Nama</th>
                            <th style="width:180px">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $data = $conn->query("SELECT * FROM ta_user");
                        $no = 1;
                        if ($data->num_rows === 0) { ?>
                            <tr>
                                <td colspan="3" class="text-muted-spk">Belum ada user. Gunakan tombol "Tambah User" untuk menambah akun.</td>
                            </tr>
                            <?php } else {
                            while ($user = $data->fetch_assoc()) { ?>
                                <tr>
                                    <td><?= $no++; ?></td>
                                    <td><?= htmlspecialchars($user['user_kode']) ?></td>
                                    <td><?= htmlspecialchars($user['user_nama']) ?></td>
                                    <td>
                                        <div class="action-wrap">
                                            <button type="button" class="btn-spk-edit" data-bs-toggle="modal" data-bs-target="#modalEdit"
                                                data-id="<?= $user['user_id'] ?>" data-kode="<?= htmlspecialchars($user['user_kode']) ?>" data-nama="<?= htmlspecialchars($user['user_nama']) ?>">Edit</button>
                                            <a href="userDelete.php?id=<?= $user['user_id'] ?>" class="btn-spk-delete" onclick="return confirm('Hapus user ini?')">Hapus</a>
                                        </div>
                                    </td>
                                </tr>
                        <?php }
                        } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal ADD -->
<div class="modal fade" id="modalAdd" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Data User</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form disini -->
                <form method="post" action="userAdd.php">
                    <?php
                    $data = $conn->query("SELECT * FROM ta_user ORDER BY user_id DESC LIMIT 1");
                    $total_row = mysqli_num_rows($data);
                    if ($total_row == 0) {
                        $nextKode = 'U001';
                    } else {
                        $last = $data->fetch_assoc();
                        $nextId = (int)$last['user_id'] + 1;
                        $nextKode = $nextId < 10 ? sprintf('U00%d', $nextId) : sprintf('U0%d', $nextId);
                    }
                    ?>

                    <div class="form-group mb-3">
                        <label class="spk-label" for="userKode">Kode</label>
                        <input type="text" class="spk-input" id="userKode" name="userKode" value="<?= htmlspecialchars($nextKode) ?>" required readonly>
                    </div>

                    <div class="form-group mb-3">
                        <label class="spk-label" for="userNama">Nama</label>
                        <input type="text" class="spk-input" id="userNama" name="userNama" required placeholder="Nama pengguna">
                    </div>

                    <div class="form-group mb-3">
                        <label class="spk-label" for="userPassword">Password</label>
                        <input type="password" class="spk-input" id="userPassword" name="userPassword" required placeholder="Buat password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-spk-primary" name="save">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal EDIT -->
<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="modalEditLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalEditLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="userEdit.php">
                    <input type="hidden" name="userId" id="editUserId">
                    <div class="form-group mb-3">
                        <label class="spk-label" for="editUserKode">Kode</label>
                        <input type="text" class="spk-input" id="editUserKode" name="userKode" readonly>
                    </div>
                    <div class="form-group mb-3">
                        <label class="spk-label" for="editUserNama">Nama</label>
                        <input type="text" class="spk-input" id="editUserNama" name="userNama" required>
                    </div>
                    <div class="form-group mb-3">
                        <label class="spk-label" for="editUserPassword">Password</label>
                        <input type="password" class="spk-input" id="editUserPassword" name="userPassword" placeholder="Kosongkan jika tidak ingin mengubah">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn-spk-primary" name="update">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- footer -->
<?php include __DIR__ . '/../blade/footer.php' ?>

<script>
    var modalEdit = document.getElementById('modalEdit');
    modalEdit.addEventListener('show.bs.modal', function(event) {
        var button = event.relatedTarget;
        var id = button.getAttribute('data-id');
        var kode = button.getAttribute('data-kode');
        var nama = button.getAttribute('data-nama');

        document.getElementById('editUserId').value = id;
        document.getElementById('editUserKode').value = kode;
        document.getElementById('editUserNama').value = nama;
        document.getElementById('editUserPassword').value = '';
    });
</script>