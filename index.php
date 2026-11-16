<?php
require_once 'classes/Buku.php';

$buku = new Buku();
$pesan = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $judul   = trim($_POST['judul'] ?? '');
    $penulis = trim($_POST['penulis'] ?? '');
    $tahun   = trim($_POST['tahun'] ?? '');
    $stok    = trim($_POST['stok'] ?? '');

    if ($judul === '')   $pesan[] = 'Judul wajib diisi';
    if ($penulis === '') $pesan[] = 'Penulis wajib diisi';
    if (!ctype_digit($tahun)) $pesan[] = 'Tahun harus angka';
    if (!is_numeric($stok) || (int)$stok < 0) $pesan[] = 'Stok tidak boleh negatif';

    if (!$pesan) {
        if ($buku->create($judul, $penulis, (int)$tahun, (int)$stok)) {
            header('Location: index.php?status=ok');
            exit;
        } else {
            $pesan[] = 'Gagal menyimpan data';
        }
    }
}

$sukses = (($_GET['status'] ?? '') === 'ok') ? 'Buku berhasil ditambahkan' : '';
$q = trim($_GET['q'] ?? '');
$daftar = ($q !== '') ? $buku->cari($q) : $buku->all();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Perpustakaan</title>
</head>
<body>
    <h2>Mini Proyek Perpustakaan</h2>

    <?php foreach ($pesan as $p): ?>
        <p><b><?= htmlspecialchars($p) ?></b></p>
    <?php endforeach; ?>
    <?php if ($sukses): ?>
        <p><b><?= htmlspecialchars($sukses) ?></b></p>
    <?php endif; ?>

    <h3>Tambah Buku</h3>
    <form method="post" action="index.php">
        <p>Judul<br><input type="text" name="judul"></p>
        <p>Penulis<br><input type="text" name="penulis"></p>
        <p>Tahun<br><input type="number" name="tahun"></p>
        <p>Stok<br><input type="number" name="stok" value="0"></p>
        <button type="submit">Simpan</button>
    </form>

        <form method="get" action="index.php">
        <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari judul...">
        <button type="submit">Cari</button>
        <a href="index.php">Reset</a>
    </form>

    <h3>Daftar Buku</h3>
    <table border="1" cellpadding="6">
        <tr>
            <th>ID</th><th>Judul</th><th>Penulis</th><th>Tahun</th><th>Stok</th><th>Aksi</th>
        </tr>
        <?php foreach ($daftar as $b): ?>
        <tr>
            <td><?= (int)$b['id'] ?></td>
            <td><?= htmlspecialchars($b['judul']) ?></td>
            <td><?= htmlspecialchars($b['penulis']) ?></td>
            <td><?= (int)$b['tahun'] ?></td>
            <td><?= (int)$b['stok'] ?></td>
            <td>
                <a href="edit.php?id=<?= (int)$b['id'] ?>">Edit</a>
                <form method="post" action="hapus.php" style="display:inline"
                      onsubmit="return confirm('Hapus buku ini?')">
                    <input type="hidden" name="id" value="<?= (int)$b['id'] ?>">
                    <button type="submit">Hapus</button>
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
        <?php if (!$daftar): ?>
        <p>Tidak ada data</p>
    <?php endif; ?>
</body>
</html>