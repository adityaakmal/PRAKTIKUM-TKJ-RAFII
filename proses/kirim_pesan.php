<?php
require_once "../config/koneksi.php";

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: ../index.php");
    exit;
}

$nama  = trim($_POST['nama'] ?? '');
$email = trim($_POST['email'] ?? '');
$isi   = trim($_POST['isi_pesan'] ?? '');

if ($nama === '' || $isi === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    header("Location: ../index.php?status=gagal#kontak");
    exit;
}

$stmt = mysqli_prepare($koneksi, "INSERT INTO pesan (nama, email, isi_pesan) VALUES (?, ?, ?)");
mysqli_stmt_bind_param($stmt, "sss", $nama, $email, $isi);
$ok = mysqli_stmt_execute($stmt);

header("Location: ../index.php?status=" . ($ok ? "sukses" : "gagal") . "#kontak");
exit;