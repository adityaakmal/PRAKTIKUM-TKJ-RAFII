<?php
require_once "config/koneksi.php";

$profil = mysqli_fetch_assoc(mysqli_query($koneksi, "SELECT * FROM profil LIMIT 1"));
$skills = mysqli_query($koneksi, "SELECT * FROM skill ORDER BY persen DESC");
$proyek = mysqli_query($koneksi, "SELECT * FROM proyek ORDER BY id DESC");

$status = $_GET['status'] ?? '';
$fotoAda = file_exists("assets/img/" . $profil['foto']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portofolio - <?= htmlspecialchars($profil['nama']) ?></title>
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<!-- NAVBAR -->
<header class="navbar">
  <div class="container nav-wrap">
    <a href="#home" class="logo"><?= htmlspecialchars(explode(' ', $profil['nama'])[0]) ?><span>.</span></a>
    <button class="menu-btn" id="menuBtn">☰</button>
    <nav id="menu">
      <a href="#home">Beranda</a>
      <a href="#tentang">Tentang</a>
      <a href="#skill">Skill</a>
      <a href="#proyek">Proyek</a>
      <a href="#kontak">Kontak</a>
    </nav>
  </div>
</header>

<!-- HERO -->
<section class="hero" id="home">
  <div class="container hero-wrap">
    <div class="hero-text">
      <p class="sapaan">👋 Halo, saya</p>
      <h1><?= htmlspecialchars($profil['nama']) ?></h1>
      <h2 class="profesi"><?= htmlspecialchars($profil['profesi']) ?></h2>
      <p class="deskripsi">Saya membuat website modern yang rapi dan nyaman digunakan.</p>
      <div class="hero-btn">
        <a href="#proyek" class="btn">Lihat Proyek</a>
        <a href="#kontak" class="btn btn-outline">Hubungi Saya</a>
      </div>
    </div>
    <div class="hero-foto">
      <?php if ($fotoAda): ?>
        <img src="assets/img/<?= htmlspecialchars($profil['foto']) ?>" alt="Foto profil">
      <?php else: ?>
        <div class="avatar"><?= strtoupper(substr($profil['nama'], 0, 1)) ?></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<!-- TENTANG -->
<section class="section" id="tentang">
  <div class="container">
    <h3 class="judul">Tentang <span>Saya</span></h3>
    <div class="tentang-box">
      <p><?= nl2br(htmlspecialchars($profil['tentang'])) ?></p>
      <ul class="info">
        <li>📧 <?= htmlspecialchars($profil['email']) ?></li>
        <li>📱 <?= htmlspecialchars($profil['telepon']) ?></li>
        <li>📍 <?= htmlspecialchars($profil['lokasi']) ?></li>
      </ul>
    </div>
  </div>
</section>

<!-- SKILL -->
<section class="section gelap" id="skill">
  <div class="container">
    <h3 class="judul">Keahlian <span>Saya</span></h3>
    <div class="skill-grid">
      <?php while ($s = mysqli_fetch_assoc($skills)): ?>
        <div class="skill-item">
          <div class="skill-head">
            <span><?= htmlspecialchars($s['nama_skill']) ?></span>
            <span><?= (int)$s['persen'] ?>%</span>
          </div>
          <div class="bar"><div class="bar-isi" data-persen="<?= (int)$s['persen'] ?>"></div></div>
        </div>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- PROYEK -->
<section class="section" id="proyek">
  <div class="container">
    <h3 class="judul">Proyek <span>Saya</span></h3>
    <div class="proyek-grid">
      <?php while ($p = mysqli_fetch_assoc($proyek)): ?>
        <article class="card">
          <div class="card-ikon">💻</div>
          <h4><?= htmlspecialchars($p['judul']) ?></h4>
          <p><?= htmlspecialchars($p['deskripsi']) ?></p>
          <small><?= htmlspecialchars($p['teknologi']) ?></small>
          <a href="<?= htmlspecialchars($p['link']) ?>" class="link">Lihat Detail →</a>
        </article>
      <?php endwhile; ?>
    </div>
  </div>
</section>

<!-- KONTAK -->
<section class="section gelap" id="kontak">
  <div class="container">
    <h3 class="judul">Hubungi <span>Saya</span></h3>

    <?php if ($status === 'sukses'): ?>
      <div class="alert sukses">✅ Pesan berhasil dikirim. Terima kasih!</div>
    <?php elseif ($status === 'gagal'): ?>
      <div class="alert gagal">❌ Pesan gagal dikirim. Periksa kembali isian Anda.</div>
    <?php endif; ?>

    <form action="proses/kirim_pesan.php" method="POST" class="form">
      <input type="text" name="nama" placeholder="Nama Anda" required>
      <input type="email" name="email" placeholder="Email Anda" required>
      <textarea name="isi_pesan" rows="5" placeholder="Tulis pesan..." required></textarea>
      <button type="submit" class="btn">Kirim Pesan</button>
    </form>
  </div>
</section>

<footer class="footer">
  <p>© <?= date('Y') ?> <?= htmlspecialchars($profil['nama']) ?>. Semua hak dilindungi.</p>
</footer>

<script src="assets/js/script.js"></script>
</body>
</html>