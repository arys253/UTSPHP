<?php
require_once 'classes/Buku.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    if (ctype_digit($id)) {
        (new Buku())->delete((int)$id);
    }
}
header('Location: index.php');
exit;