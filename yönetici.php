<?php
session_start();

// Yönetici parolası (buraya kendi şifreni yaz)
$adminSifre = 'Fyhvb7h3';

// Giriş kontrolü
if (isset($_POST['sifre'])) {
    if ($_POST['sifre'] === $adminSifre) {
        $_SESSION['giris'] = true;
    } else {
        $hata = 'Parola yanlış!';
    }
}

if (!isset($_SESSION['giris']) || $_SESSION['giris'] !== true) {
    // Giriş formu göster
    ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
      <meta charset="UTF-8" />
      <title>Yönetici Girişi</title>
    </head>
    <body>
      <h2>Yönetici Girişi</h2>
      <?php if (isset($hata)) echo '<p style="color:red;">'.$hata.'</p>'; ?>
      <form method="POST">
        <label for="sifre">Parola:</label>
        <input type="password" id="sifre" name="sifre" required />
        <button type="submit">Giriş</button>
      </form>
    </body>
    </html>
    <?php
    exit;
}

// Giriş başarılı, destek kayıtlarını göster

$dosya = 'destekler.json';

$destekler = [];
if (file_exists($dosya)) {
    $icerik = file_get_contents($dosya);
    $destekler = json_decode($icerik, true);
    if (!is_array($destekler)) {
        $destekler = [];
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <title>Yönetici Paneli - Destek Talepleri</title>
</head>
<body>
  <h1>Destek Talepleri</h1>
  <table border="1" cellpadding="5" cellspacing="0">
    <thead>
      <tr>
        <th>İsim</th>
        <th>E-posta</th>
        <th>Mesaj</th>
        <th>Tarih</th>
      </tr>
    </thead>
    <tbody>
      <?php if (count($destekler) === 0): ?>
        <tr><td colspan="4">Destek talebi yok.</td></tr>
      <?php else: ?>
        <?php foreach ($destekler as $d): ?>
          <tr>
            <td><?=htmlspecialchars($d['isim'])?></td>
            <td><?=htmlspecialchars($d['email'])?></td>
            <td><?=nl2br(htmlspecialchars($d['mesaj']))?></td>
            <td><?=htmlspecialchars($d['tarih'])?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
  </table>
  <p><a href="yönetici.php?logout=1">Çıkış Yap</a></p>

<?php
// Çıkış işlemi
if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: yönetici.php');
    exit;
}
?>

</body>
</html>
