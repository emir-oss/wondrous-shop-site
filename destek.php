<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $isim = strip_tags(trim($_POST["isim"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_VALIDATE_EMAIL);
    $mesaj = strip_tags(trim($_POST["mesaj"] ?? ''));

    if (!$isim || !$email || !$mesaj) {
        header("Location: destek.html?status=error");
        exit;
    }

    $data = [
        "isim" => $isim,
        "email" => $email,
        "mesaj" => $mesaj,
        "tarih" => date("Y-m-d H:i:s")
    ];

    $dosya = "destekler.json";

    // Var olan dosyadan destekleri oku
    if (file_exists($dosya)) {
        $json = file_get_contents($dosya);
        $destekler = json_decode($json, true);
        if (!is_array($destekler)) {
            $destekler = [];
        }
    } else {
        $destekler = [];
    }

    // Yeni destek kaydını ekle
    $destekler[] = $data;

    // Dosyaya tekrar kaydet
    if (file_put_contents($dosya, json_encode($destekler, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE))) {
        header("Location: destek.html?status=success");
    } else {
        header("Location: destek.html?status=error");
    }
} else {
    header("Location: destek.html");
    exit;
}
