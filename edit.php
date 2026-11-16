<?php
require_once 'classes/Buku.php';

$buku = new Buku();
$id = $_GET['id'] ?? $_POST['id'] ?? '';
$pesan = [];

if (!ctype_digit((string)$id) || !($data = $buku->find((int)$id))) {
    die('Buku tidak ditemukan');
}

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
        $buku->update((int)$id, $judul, $penulis, (int)$tahun, (int)$stok);
        header('Location: index.php');
        exit;
    }
    $data = ['id' => $id, 'judul' => $judul, 'penulis' => $penulis,
             'tahun' => $tahun, 'stok' => $stok];
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Buku</title>
</head>
<body>
    <h2>Edit Buku</h2>
    <?php foreach ($pesan as $p): ?>
        <p><b><?= htmlspecialchars($p) ?></b></p>
    <?php endforeach; ?>

    <form method="post" action="edit.php">
        <input type="hidden" name="id" value="<?= (int)$data['id'] ?>">
        <p>Judul<br><input type="text" name="judul" value="<?= htmlspecialchars($data['judul']) ?>"></p>
        <p>Penulis<br><input type="text" name="penulis" value="<?= htmlspecialchars($data['penulis']) ?>"></p>
        <p>Tahun<br><input type="number" name="tahun" value="<?= htmlspecialchars($data['tahun']) ?>"></p>
        <p>Stok<br><input type="number" name="stok" value="<?= htmlspecialchars($data['stok']) ?>"></p>
        <button type="submit">Simpan Perubahan</button>
        <a href="index.php">Batal</a>
    </form>
</body>
</html>