<?php
// İçerik ajanının yayın / hata bildirimi için iç uç nokta.
// Token korumalı. Sadece POST kabul eder.
// hata=1 parametresiyle hata bildirimi, yoksa başarı bildirimi gönderir.
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false]);
    exit;
}

if (!hash_equals('sera2026bildirim9f4a8c2e1d7b3f6a', $_POST['token'] ?? '')) {
    http_response_code(404);
    exit;
}

$hata   = !empty($_POST['hata']) && $_POST['hata'] !== '0';
$baslik = mb_substr(trim($_POST['baslik'] ?? ''), 0, 300);
$url    = mb_substr(trim($_POST['url']    ?? ''), 0, 500);
$ozet   = mb_substr(trim($_POST['ozet']   ?? ''), 0, 1000);

if ($baslik === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'baslik zorunlu']);
    exit;
}

$gonderen = defined('FORM_FROM') ? FORM_FROM : 'site@anahtarteslimsera.com';

if ($hata) {
    $konu = '=?UTF-8?B?' . base64_encode('[HATA] Sera İçerik Ajanı: ' . $baslik) . '?=';

    $icerik  = "Anahtar Teslim Sera içerik ajanı bir hatayla karşılaştı.\n\n";
    $icerik .= "Hata   : $baslik\n";
    $icerik .= "Zaman  : " . date('d.m.Y H:i') . "\n";
    if ($ozet !== '') {
        $icerik .= "\n--- Detay ---\n$ozet\n";
    }
    $icerik .= "\nOturum kaydını https://claude.ai/code/routines adresinden inceleyebilirsin.\n";
} else {
    if ($url === '') {
        http_response_code(422);
        echo json_encode(['ok' => false, 'error' => 'basarili bildirimde url zorunlu']);
        exit;
    }
    $konu = '=?UTF-8?B?' . base64_encode('Yeni Blog Yazısı: ' . $baslik) . '?=';

    $icerik  = "Anahtar Teslim Sera içerik ajanı yeni bir yazı yayınladı.\n\n";
    $icerik .= "Başlık : $baslik\n";
    $icerik .= "URL    : $url\n";
    $icerik .= "Tarih  : " . date('d.m.Y H:i') . "\n";
    if ($ozet !== '') {
        $icerik .= "\n--- Özet ---\n$ozet\n";
    }
    $icerik .= "\nDüzeltme istersen Claude'a söylemen yeterli.\n";
}

$headers  = "From: =?UTF-8?B?" . base64_encode("Anahtar Teslim Sera Ajan") . "?= <$gonderen>\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";
$headers .= "Content-Transfer-Encoding: 8bit\r\n";
$headers .= "Date: " . date('r') . "\r\n";
$headers .= "Message-ID: <" . uniqid('yayin', true) . "@anahtarteslimsera.com.tr>\r\n";

$ok = @mail('tahirkucuk@gmail.com', $konu, $icerik, $headers);

echo json_encode(['ok' => (bool)$ok]);
