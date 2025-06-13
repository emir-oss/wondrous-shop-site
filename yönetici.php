<?php
session_start();

// Belirlenen şifre (kendi şifreni buraya yazabilirsin)
$dogru_parola = "Fyhvb7h3";

// Çıkış yapmak için
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: yönetici.php");
    exit;
}

// Giriş yapma işlemi
if (isset($_POST['parola'])) {
    if ($_POST['parola'] === $dogru_parola) {
        $_SESSION['giris'] = true;
        header("Location: yönetici.php");
        exit;
    } else {
        $hata = "Parola yanlış!";
    }
}

// Eğer giriş yapılmamışsa, parola formunu göster
if (!isset($_SESSION['giris']) || $_SESSION['giris'] !== true) {
    ?>
    <!DOCTYPE html>
    <html lang="tr">
    <head>
      <meta charset="UTF-8" />
      <title>Yönetici Girişi</title>
      <style>
        body {
          font-family: Arial, sans-serif;
          max-width: 400px;
          margin: 100px auto;
          padding: 15px;
          border: 1px solid #ccc;
          border-radius: 8px;
          background-color: #f9f9f9;
          text-align: center;
        }
        input[type="password"] {
          width: 80%;
          padding: 10px;
          font-size: 1rem;
          margin-bottom: 15px;
          border: 1px solid #ccc;
          border-radius: 6px;
        }
        button {
          padding: 10px 20px;
          font-size: 1rem;
          background-color: #0066cc;
          color: white;
          border: none;
          border-radius: 6px;
          cursor: pointer;
          transition: background-color 0.3s ease;
        }
        button:hover {
          background-color: #004a99;
        }
        .error {
          color: red;
          margin-bottom: 15px;
        }
      </style>
    </head>
    <body>
      <h2>Yönetici Paneli Girişi</h2>
      <?php if (isset($hata)) echo '<div class="error">'.$hata.'</div>'; ?>
      <form method="POST" action="yönetici.php">
        <input type="password" name="parola" placeholder="Parolayı girin" required />
        <br />
        <button type="submit">Giriş Yap</button>
      </form>
    </body>
    </html>
    <?php
    exit;
}

// Giriş yapılmışsa destek kayıtlarını gösterelim

$dosya = "destekler.json";
$destekler = [];

if (file_exists($dosya)) {
    $json = file_get_contents($dosya);
    $destekler = json_decode($json, true);
    if (!is_array($destekler)) {
        $destekler = [];
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
  <meta charset="UTF-8" />
  <title>Yönetici Paneli | Destek Talepleri</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      max-width: 900px;
      margin: 30px auto;
      padding: 0 15px;
    }
    h1 {
      text-align: center;
      margin-bottom: 30px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 40px;
    }
    th, td {
      border: 1px solid #ccc;
      padding: 10px;
      text-align: left;
      vertical-align: top;
    }
    th {
      background-color: #0066cc;
      color: white;
    }
    tbody tr:nth-child(even) {
      background-color: #f0f8ff;
    }
    .tarih {
      font-size: 0.9rem;
      color: #555;
    }
    .logout-btn {
      display: block;
      margin: 0 auto 30px auto;
      width: 120px;
      padding: 10px;
      background-color: #cc3300;
      color: white;
      border: none;
      border-radius: 6px;
      font-weight: bold;
      cursor: pointer;
      text-align: center;
      text-decoration: none;
      transition: background-color 0.3s ease;
    }
    .logout-btn:hover {
      background-color: #990000;
    }
  </style>
</head>
<body>
  <h1>Destek Talepleri</h1>
  
  <a href="yönetici.php?logout=1" class="logout-btn">Çıkış Yap</a>

  <?php if (count($destekler) === 0): ?>
    <p>Henüz destek talebi yok.</p>
  <?php else: ?>
    <table>
      <thead>
        <tr>
          <th>İsim</th>
          <th>E-posta</th>
          <th>Mesaj</th>
          <th>Tarih</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach (array_reverse($destekler) as $destek): ?>
          <tr>
            <td><?= htmlspecialchars($destek['isim']) ?></td>
            <td><?= htmlspecialchars($destek['email']) ?></td>
            <td><?= nl2br(htmlspecialchars($destek['mesaj'])) ?></td>
            <td class="tarih"><?= htmlspecialchars($destek['tarih']) ?></td>
          </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  <?php endif; ?>

</body>
</html>
