<?php
// İçerik ajanının yayın bildirimi için iç uç nokta.
// Token korumalı. Sadece POST kabul eder.
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

$baslik = mb_substr(trim($_POST['baslik'] ?? ''), 0, 300);
$url    = mb_substr(trim($_POST['url']    ?? ''), 0, 500);
$ozet   = mb_substr(trim($_POST['ozet']   ?? ''), 0, 1000);

if ($baslik === '' || $url === '') {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'baslik ve url zorunlu']);
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

$gonderen = defined('FORM_FROM') ? FORM_FROM : 'site@anahtarteslimsera.com';

$basliklar  = "From: =?UTF-8?B?" . base64_encode("Anahtar Teslim Sera Ajan") . "?= <$gonderen>\r\n";
$basliklar .= "Content-Type: text/plain; charset=UTF-8\r\n";
$basliklar .= "Content-Transfer-Encoding: 8bit\r\n";
$basliklar .= "Date: " . date('r') . "\r\n";
$basliklar .= "Message-ID: <" . uniqid('yayin', true) . "@anahtarteslimsera.com.tr>\r\n";

$ok = @mail('tahirkucuk@gmail.com', $konu, $icerik, $basliklar);

echo json_encode(['ok' => (bool)$ok]);
