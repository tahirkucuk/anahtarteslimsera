<?php
/**
 * TEKLİF FORMU İŞLEYİCİSİ
 * ==================================================================
 * Akış:  doğrula → kaydet → e-posta gönder → /tesekkurler'e yönlendir
 *
 * PANEL ENTEGRASYONU
 * ------------------
 * Aşağıda "PANEL KANCASI" yazan blok, talebi JSON dosyasına yazar.
 * Kendi paneliniz için o bloğu veritabanı INSERT'i ile değiştirin;
 * $lead dizisinin anahtarları değişmediği sürece formda ve şablonlarda
 * hiçbir düzenleme gerekmez.
 */

require_once dirname(__DIR__) . '/inc/bootstrap.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

$back = url('/iletisim') . '#form';

/** Hata ile forma geri döner (bu fonksiyondan dönüş yoktur). */
function fail(array $errors, array $old, string $back)
{
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_old']    = $old;
    header('Location: ' . $back, true, 303);
    exit;
}

if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    header('Location: ' . url('/iletisim'), true, 303);
    exit;
}

// --- gelen veri ---------------------------------------------------------
$in = [
    'ad'      => trim((string) ($_POST['ad'] ?? '')),
    'telefon' => trim((string) ($_POST['telefon'] ?? '')),
    'eposta'  => trim((string) ($_POST['eposta'] ?? '')),
    'sehir'   => trim((string) ($_POST['sehir'] ?? '')),
    'alan'    => trim((string) ($_POST['alan'] ?? '')),
    'urun'    => trim((string) ($_POST['urun'] ?? 'Belirtilmedi')),
    'notlar'  => trim((string) ($_POST['notlar'] ?? '')),
    'kapsam'  => array_values(array_filter((array) ($_POST['kapsam'] ?? []), 'is_string')),
];

// --- spam filtreleri ----------------------------------------------------
// 1) Bal küpü alanı doluysa bot demektir. Sessizce başarı sayfasına gönder.
if (trim((string) ($_POST['website'] ?? '')) !== '') {
    header('Location: ' . url('/tesekkurler'), true, 303);
    exit;
}
// 2) Form açıldıktan 3 saniyeden kısa sürede gönderildiyse bot.
$ts = (int) ($_POST['ts'] ?? 0);
if ($ts > 0 && (time() - $ts) < 3) {
    header('Location: ' . url('/tesekkurler'), true, 303);
    exit;
}
// 3) Aynı oturumdan 60 saniye içinde ikinci gönderim.
if (!empty($_SESSION['last_lead']) && (time() - (int) $_SESSION['last_lead']) < 60) {
    fail(['Talebiniz az önce alındı. Yeni bir talep için lütfen bir dakika bekleyin.'], $in, $back);
}

// --- doğrulama ----------------------------------------------------------
$errors = [];

if (!csrf_check($_POST['_token'] ?? null)) {
    $errors[] = 'Oturum süresi doldu. Lütfen sayfayı yenileyip tekrar deneyin.';
}
if ($in['ad'] === '' || mb_strlen($in['ad']) < 3) {
    $errors[] = 'Ad Soyad alanını doldurun.';
}
$digits = preg_replace('/\D+/', '', $in['telefon']);
if (strlen($digits) < 10) {
    $errors[] = 'Geçerli bir telefon numarası girin.';
}
if ($in['sehir'] === '') {
    $errors[] = 'İl / ilçe bilgisini girin.';
}
if ($in['eposta'] !== '' && !filter_var($in['eposta'], FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'E-posta adresi geçerli görünmüyor.';
}
if (!$in['kapsam']) {
    $errors[] = 'En az bir kapsam seçin.';
}
if (empty($_POST['kvkk'])) {
    $errors[] = 'Aydınlatma metnini onaylamanız gerekiyor.';
}
// Başlık enjeksiyonu koruması
foreach (['ad', 'eposta', 'sehir'] as $f) {
    if (preg_match('/[\r\n]/', $in[$f])) {
        $errors[] = 'Girdilerde geçersiz karakter var.';
        break;
    }
}

if ($errors) {
    fail($errors, $in, $back);
}

// --- talep kaydı --------------------------------------------------------
$lead = [
    'id'         => date('Ymd-His') . '-' . substr(bin2hex(random_bytes(4)), 0, 6),
    'created_at' => date('c'),
    'ad'         => $in['ad'],
    'telefon'    => $in['telefon'],
    'eposta'     => $in['eposta'],
    'sehir'      => $in['sehir'],
    'alan'       => $in['alan'],
    'urun'       => $in['urun'],
    'kapsam'     => $in['kapsam'],
    'notlar'     => $in['notlar'],
    'ekip'       => route_team($in['kapsam']),
    'kaynak'     => substr((string) ($_SERVER['HTTP_REFERER'] ?? ''), 0, 300),
    'ip'         => $_SERVER['REMOTE_ADDR'] ?? '',
    'ua'         => substr((string) ($_SERVER['HTTP_USER_AGENT'] ?? ''), 0, 250),
];

/** Kapsam seçimine göre talebi hangi ekibin karşılayacağını belirler. */
function route_team(array $kapsam): string
{
    if (in_array('Anahtar teslim sera', $kapsam, true)) {
        return 'Proje müdürü (PR Tarım + Özdemirler Sera + İrriga)';
    }
    $t = [];
    if (array_intersect(['Tarımsal danışmanlık', 'Hibe / IPARD dosyası'], $kapsam)) {
        $t[] = 'PR Tarım';
    }
    if (in_array('Sera kurulumu', $kapsam, true)) {
        $t[] = 'Özdemirler Sera';
    }
    if (in_array('Sulama sistemi', $kapsam, true)) {
        $t[] = 'İrriga Mühendislik';
    }
    return $t ? implode(' + ', $t) : 'Proje müdürü';
}

// ===== PANEL KANCASI ====================================================
// Şu an: aylık JSONL dosyasına ekler (storage/leads/2026-09.jsonl).
// Panelinizi bağlarken bu bloğu veritabanı yazımıyla değiştirin.
try {
    $dir = APP_ROOT . '/storage/leads';
    if (!is_dir($dir)) {
        @mkdir($dir, 0750, true);
    }
    $file = $dir . '/' . date('Y-m') . '.jsonl';
    @file_put_contents(
        $file,
        json_encode($lead, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . PHP_EOL,
        FILE_APPEND | LOCK_EX
    );
} catch (Throwable $ex) {
    error_log('[teklif] kayit hatasi: ' . $ex->getMessage());
}
// ===== /PANEL KANCASI ===================================================

// --- e-posta bildirimi --------------------------------------------------
$satirlar = [
    'Talep no    : ' . $lead['id'],
    'Tarih       : ' . date('d.m.Y H:i'),
    'Ad Soyad    : ' . $lead['ad'],
    'Telefon     : ' . $lead['telefon'],
    'E-posta     : ' . ($lead['eposta'] !== '' ? $lead['eposta'] : '—'),
    'İl / İlçe   : ' . $lead['sehir'],
    'Arazi       : ' . ($lead['alan'] !== '' ? $lead['alan'] . ' dekar' : '—'),
    'Ürün        : ' . $lead['urun'],
    'Kapsam      : ' . implode(', ', $lead['kapsam']),
    'Yönlendirme : ' . $lead['ekip'],
    '',
    'Notlar:',
    $lead['notlar'] !== '' ? $lead['notlar'] : '—',
    '',
    'Geldiği sayfa: ' . ($lead['kaynak'] !== '' ? $lead['kaynak'] : '—'),
];

$headers = [
    'From: ' . SITE_NAME . ' <' . FORM_FROM . '>',
    'Content-Type: text/plain; charset=UTF-8',
    'X-Mailer: PHP/' . phpversion(),
];
if ($lead['eposta'] !== '') {
    $headers[] = 'Reply-To: ' . $lead['eposta'];
}

@mail(
    FORM_TO,
    '=?UTF-8?B?' . base64_encode(FORM_SUBJECT . ' — ' . $lead['sehir']) . '?=',
    implode("\n", $satirlar),
    implode("\r\n", $headers),
    '-f' . FORM_FROM
);

$_SESSION['last_lead'] = time();
$_SESSION['lead_id']   = $lead['id'];

header('Location: ' . url('/tesekkurler'), true, 303);
exit;
