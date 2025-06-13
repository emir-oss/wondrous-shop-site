<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen veriler
    $isim = strip_tags(trim($_POST["isim"] ?? ''));
    $email = filter_var(trim($_POST["email"] ?? ''), FILTER_VALIDATE_EMAIL);
    $mesaj = strip_tags(trim($_POST["mesaj"] ?? ''));

    if (!$isim || !$email || !$mesaj) {
        // Eksik veya geçersiz veri varsa hata ile geri dön
        header("Location: destek.html?status=error");
        exit;
    }

    // Mail içeriği
    $to = "wondrousshopws.iletisim@gmail.com";  // Destek için gelen mail adresi
    $subject = "Yeni Destek Talebi - $isim";
    $body = "İsim: $isim\n";
    $body .= "E-posta: $email\n\n";
    $body .= "Mesaj:\n$mesaj\n";

    // Mail başlıkları
    $headers = "From: $isim <$email>\r\n";
    $headers .= "Reply-To: $email\r\n";

    // Mail gönderimi
    if (mail($to, $subject, $body, $headers)) {
        // Başarılıysa teşekkür sayfasına yönlendir
        header("Location: destek.html?status=success");
    } else {
        // Mail gönderilemediyse hata sayfasına yönlendir
        header("Location: destek.html?status=error");
    }
} else {
    // POST değilse destek sayfasına yönlendir
    header("Location: destek.html");
    exit;
}
