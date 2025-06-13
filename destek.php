<?php if (isset($_GET['durum']) && $_GET['durum'] === 'basarili'): ?>
  <p style="color: green;">Destek talebiniz başarıyla gönderildi. Teşekkürler!</p>
<?php endif; ?>

<?php
// destek.php

// Dosya adı
$dosya = 'destekler.json';

// POST verilerini al
$isim = trim($_POST['isim'] ?? '');
$email = trim($_POST['email'] ?? '');
$mesaj = trim($_POST['mesaj'] ?? '');

// Basit doğrulama
if (!$isim || !$email || !$mesaj) {
    die('Lütfen tüm alanları doldurun.');
}

// Yeni destek kaydı dizisi
$yeniKayit = [
    'isim' => htmlspecialchars($isim, ENT_QUOTES),
    'email' => htmlspecialchars($email, ENT_QUOTES),
    'mesaj' => htmlspecialchars($mesaj, ENT_QUOTES),
    'tarih' => date('Y-m-d H:i:s')
];

// Var olan kayıtları oku
if (file_exists($dosya)) {
    $icerik = file_get_contents($dosya);
    $destekler = json_decode($icerik, true);
    if (!is_array($destekler)) {
        $destekler = [];
    }
} else {
    $destekler = [];
}

// Yeni kaydı ekle
$destekler[] = $yeniKayit;

// JSON olarak kaydet
file_put_contents($dosya, json_encode($destekler, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

// Yönlendir (destek.html'ye) ve başarı mesajı ile
header('Location: destek.html?durum=basarili');
exit;
?>
