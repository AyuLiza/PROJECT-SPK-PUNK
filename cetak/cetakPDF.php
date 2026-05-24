<?php
// koneksi
include __DIR__ . '/../tools/connection.php';

// header
include __DIR__ . '/../blade/header.php';

$ranks = [];
$dataAlternatif = $conn->query("SELECT * FROM ta_alternatif ORDER BY alternatif_kode");
while ($alternatif = $dataAlternatif->fetch_assoc()) {
    $totalPreferensi = 0;
    $sqlNilai = $conn->query("SELECT * FROM tb_nilai WHERE alternatif_kode='" . $alternatif['alternatif_kode'] . "' ORDER BY kriteria_kode");
    while ($nilai = $sqlNilai->fetch_assoc()) {
        $kriteria = $conn->query("SELECT * FROM ta_kriteria WHERE kriteria_kode='" . $nilai['kriteria_kode'] . "'")->fetch_assoc();
        $mx = $conn->query("SELECT MAX(nilai_faktor) AS max FROM tb_nilai WHERE kriteria_kode='" . $nilai['kriteria_kode'] . "'")->fetch_assoc()['max'];
        $mn = $conn->query("SELECT MIN(nilai_faktor) AS min FROM tb_nilai WHERE kriteria_kode='" . $nilai['kriteria_kode'] . "'")->fetch_assoc()['min'];

        if ($mx == $mn) {
            $utilitas = 0;
        } elseif (strtolower($kriteria['kriteria_kategori']) === 'benefit') {
            $utilitas = ($nilai['nilai_faktor'] - $mn) / ($mx - $mn);
        } else {
            $utilitas = ($mx - $nilai['nilai_faktor']) / ($mx - $mn);
        }

        $totalPreferensi += $utilitas * $kriteria['kriteria_bobot'];
    }

    $ranks[] = [
        'kode' => $alternatif['alternatif_kode'],
        'nama' => $alternatif['alternatif_nama'],
        'nilai' => $totalPreferensi,
    ];
}

usort($ranks, fn($a, $b) => $b['nilai'] <=> $a['nilai']);
?>

<div class="row">
    <div class="col-lg-1"></div>
    <div class="col-lg-10">
        <div class="text-center mb-4">
            <h2>CV Ruarasa Lombok</h2>
            <p class="m-0">Sistem Pendukung Keputusan Metode SMART</p>
            <p class="m-0">Laporan Perankingan Package</p>
        </div>

        <p class="text-justify">Laporan berikut menampilkan hasil perankingan alternatif package berdasarkan metode SMART dan bobot kriteria yang telah ditentukan. Nilai SMART dihitung dari kombinasi utilitas dan bobot setiap kriteria.</p>

        <?php if (count($ranks) === 0): ?>
            <div class="alert alert-warning">Belum ada data alternatif atau nilai. Silakan tambahkan data terlebih dahulu.</div>
        <?php else: ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Ranking</th>
                        <th>Kode Package</th>
                        <th>Nama Package</th>
                        <th>Nilai SMART</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ranks as $index => $item):
                        $rank = $index + 1;
                        $status = $rank <= 3 ? 'Direkomendasikan' : 'Tidak Direkomendasikan';
                    ?>
                        <tr>
                            <td><?= $rank ?></td>
                            <td><?= $item['kode'] ?></td>
                            <td><?= $item['nama'] ?></td>
                            <td><?= number_format($item['nilai'], 4) ?></td>
                            <td><?= $status ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <p class="text-justify">Demikian laporan ini disampaikan untuk digunakan sebagai referensi dalam pengambilan keputusan paket terbaik.</p>
        <br>
        <p class="text-end">Tanggal: <?= date('d/m/Y') ?></p>
    </div>
    <div class="col-lg-1"></div>
</div>

<script>
    window.print();
</script>