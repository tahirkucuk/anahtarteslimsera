<?php
// Bülten aboneliği — double opt-in, iki dilli (TR/EN)
// POST: email, dil (tr|en), page (isteğe bağlı), website (honeypot)
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['ok' => false]);
    exit;
}

// Honeypot
if (!empty($_POST['website'])) {
    echo json_encode(['ok' => true]);
    exit;
}

$email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
if (!$email) {
    http_response_code(422);
    echo json_encode(['ok' => false, 'error' => 'Geçerli bir e-posta girin. / Please enter a valid email.']);
    exit;
}
$email = strtolower($email);
$dil   = ($_POST['dil'] ?? 'tr') === 'en' ? 'en' : 'tr';

$logDir = dirname(__DIR__) . '/lead-kayitlari';
if (!is_dir($logDir)) { @mkdir($logDir, 0700, true); }
$dosya  = $logDir . '/aboneler.jsonl';

$fh = fopen($dosya, 'c+');
if ($fh === false) {
    http_response_code(500);
    echo json_encode(['ok' => false, 'error' => 'Kayıt açılamadı. Lütfen tekrar deneyin.']);
    exit;
}
flock($fh, LOCK_EX);

$kayitlar = [];
rewind($fh);
while (($satir = fgets($fh)) !== false) {
    $satir = trim($satir);
    if ($satir === '') continue;
    $k = json_decode($satir, true);
    if ($k) $kayitlar[] = $k;
}

$mevcutOnaylandi = false;
$mevcutBeklemede = null;
foreach ($kayitlar as $k) {
    if (strtolower($k['eposta'] ?? '') !== $email) continue;
    $durum = $k['durum'] ?? 'onaylandi';
    if ($durum === 'onaylandi') { $mevcutOnaylandi = true; break; }
    if ($durum === 'beklemede') { $mevcutBeklemede = $k; break; }
}

if ($mevcutOnaylandi) {
    flock($fh, LOCK_UN);
    fclose($fh);
    $mesaj = $dil === 'en'
        ? 'Confirmation email sent. Please check your inbox.'
        : 'Onay e-postası gönderildi. Gelen kutunuzu kontrol edin.';
    echo json_encode(['ok' => true, 'mesaj' => $mesaj]);
    exit;
}

$token = bin2hex(random_bytes(16));

if ($mevcutBeklemede) {
    $yeni = [];
    foreach ($kayitlar as $k) {
        if (strtolower($k['eposta'] ?? '') === $email && ($k['durum'] ?? '') === 'beklemede') {
            $k['token'] = $token;
            $k['tarih'] = date('c');
            $k['dil']   = $dil;
        }
        $yeni[] = json_encode($k, JSON_UNESCAPED_UNICODE);
    }
    ftruncate($fh, 0);
    rewind($fh);
    fwrite($fh, implode("\n", $yeni) . "\n");
} else {
    $kayit = [
        'eposta' => $email,
        'tarih'  => date('c'),
        'durum'  => 'beklemede',
        'token'  => $token,
        'dil'    => $dil,
        'sayfa'  => mb_substr(trim(strip_tags($_POST['page'] ?? '')), 0, 300),
        'ip'     => $_SERVER['REMOTE_ADDR'] ?? '',
    ];
    fseek($fh, 0, SEEK_END);
    fwrite($fh, json_encode($kayit, JSON_UNESCAPED_UNICODE) . "\n");
}

fflush($fh);
flock($fh, LOCK_UN);
fclose($fh);

// SMTP
require_once __DIR__ . '/inc/config.php';
$cfgPath = dirname(__DIR__) . '/.smtp-ayar.json';
$cfg = is_readable($cfgPath) ? json_decode(file_get_contents($cfgPath), true) : null;
if (!$cfg || empty($cfg['kullanici']) || empty($cfg['sifre'])) {
    http_response_code(500);
    $hata = $dil === 'en'
        ? 'Confirmation email could not be sent. Please try again later.'
        : 'Onay e-postası gönderilemedi. Lütfen daha sonra tekrar deneyin.';
    echo json_encode(['ok' => false, 'error' => $hata]);
    exit;
}

$base      = rtrim(SITE_URL, '/');
$onayLink  = $base . '/bulten-onayla.php?token=' . $token;
$iptalLink = $base . '/bulten-iptal.php?token=' . $token;

if ($dil === 'en') {
    $subject  = '=?UTF-8?B?' . base64_encode('Confirm your newsletter subscription — Anahtar Teslim Sera') . '?=';
    $htmlBody = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="font-family:Arial,sans-serif;max-width:560px;margin:0 auto;background:#f4f6f2;color:#334155;">
<div style="background:#0F4430;padding:28px 32px;border-radius:12px 12px 0 0;">
  <span style="font-weight:800;font-size:18px;color:#fff;letter-spacing:-0.01em;">Anahtar Teslim Sera</span>
  <span style="display:block;font-size:12px;color:#6aad8a;margin-top:4px;">anahtarteslimsera.com</span>
</div>
<div style="background:#fff;padding:32px;border:1px solid #dce7df;border-top:none;">
  <h2 style="font-size:20px;font-weight:700;color:#0F4430;margin:0 0 16px;line-height:1.3;">Confirm your newsletter subscription</h2>
  <p style="font-size:15px;line-height:1.7;color:#475569;margin:0 0 24px;">
    Hello,<br><br>
    We received a request to subscribe this email address to the <strong>Anahtar Teslim Sera</strong> newsletter.
    Click the button below to confirm your subscription and receive greenhouse guides directly in your inbox.
  </p>
  <a href="' . htmlspecialchars($onayLink) . '"
     style="display:inline-block;padding:14px 28px;background:#26654A;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;">
    ✓ Confirm Subscription
  </a>
  <p style="font-size:13px;color:#94A3B8;margin:28px 0 0;line-height:1.6;">
    If you did not make this request, you can ignore this email — nothing will happen.<br>
    To cancel immediately: <a href="' . htmlspecialchars($iptalLink) . '" style="color:#26654A;font-weight:600;">Unsubscribe</a>
  </p>
</div>
<div style="background:#f4f6f2;padding:14px 32px;border-radius:0 0 12px 12px;border:1px solid #dce7df;border-top:none;">
  <p style="font-size:12px;color:#94A3B8;margin:0;">
    Greenhouse investment &amp; irrigation guides &nbsp;·&nbsp;
    <a href="' . $base . '" style="color:#26654A;text-decoration:none;">anahtarteslimsera.com</a>
  </p>
</div>
</body></html>';
    $textBody  = "Confirm your newsletter subscription — Anahtar Teslim Sera\n\n";
    $textBody .= "We received a request to subscribe this email to the Anahtar Teslim Sera newsletter.\n\n";
    $textBody .= "Confirm here: " . $onayLink . "\n\n";
    $textBody .= "If you did not make this request, ignore this email.\n";
    $textBody .= "To cancel immediately: " . $iptalLink . "\n";
    $fromName  = 'Anahtar Teslim Sera';
} else {
    $subject  = '=?UTF-8?B?' . base64_encode('Bülten aboneliğinizi onaylayın — Anahtar Teslim Sera') . '?=';
    $htmlBody = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="font-family:Arial,sans-serif;max-width:560px;margin:0 auto;background:#f4f6f2;color:#334155;">
<div style="background:#0F4430;padding:28px 32px;border-radius:12px 12px 0 0;">
  <span style="font-weight:800;font-size:18px;color:#fff;letter-spacing:-0.01em;">Anahtar Teslim Sera</span>
  <span style="display:block;font-size:12px;color:#6aad8a;margin-top:4px;">anahtarteslimsera.com</span>
</div>
<div style="background:#fff;padding:32px;border:1px solid #dce7df;border-top:none;">
  <h2 style="font-size:20px;font-weight:700;color:#0F4430;margin:0 0 16px;line-height:1.3;">Bülten aboneliğinizi onaylayın</h2>
  <p style="font-size:15px;line-height:1.7;color:#475569;margin:0 0 24px;">
    Merhaba,<br><br>
    <strong>Anahtar Teslim Sera</strong> bültenine bu e-posta adresiyle abone olma isteği aldık.
    Sera yatırımı rehberlerini doğrudan gelen kutunuzda almak için aşağıdaki butona tıklayarak aboneliğinizi onaylayın.
  </p>
  <a href="' . htmlspecialchars($onayLink) . '"
     style="display:inline-block;padding:14px 28px;background:#26654A;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;">
    ✓ Aboneliği Onayla
  </a>
  <p style="font-size:13px;color:#94A3B8;margin:28px 0 0;line-height:1.6;">
    Bu isteği siz yapmadıysanız bu e-postayı görmezden gelebilirsiniz — hiçbir şey olmaz.<br>
    Hemen iptal etmek için: <a href="' . htmlspecialchars($iptalLink) . '" style="color:#26654A;font-weight:600;">Aboneliği iptal et</a>
  </p>
</div>
<div style="background:#f4f6f2;padding:14px 32px;border-radius:0 0 12px 12px;border:1px solid #dce7df;border-top:none;">
  <p style="font-size:12px;color:#94A3B8;margin:0;">
    Sera yatırımı &amp; sulama rehberleri &nbsp;·&nbsp;
    <a href="' . $base . '" style="color:#26654A;text-decoration:none;">anahtarteslimsera.com</a>
  </p>
</div>
</body></html>';
    $textBody  = "Bülten aboneliğinizi onaylayın — Anahtar Teslim Sera\n\n";
    $textBody .= "Bu e-posta ile Anahtar Teslim Sera bültenine abone olma isteği aldık.\n\n";
    $textBody .= "Onaylamak için: " . $onayLink . "\n\n";
    $textBody .= "Bu isteği siz yapmadıysanız bu maili silebilirsiniz.\n";
    $textBody .= "Hemen iptal etmek için: " . $iptalLink . "\n";
    $fromName  = 'Anahtar Teslim Sera';
}

function bulten_smtp_abone($host, $port, $user, $pass, $to, $subject, $htmlBody, $textBody, $fromName)
{
    $fp = @fsockopen(($port === 465 ? 'ssl://' : '') . $host, $port, $e, $s, 15);
    if (!$fp) return false;
    stream_set_timeout($fp, 15);
    $r = function () use ($fp) {
        $d = '';
        while ($l = fgets($fp, 515)) { $d .= $l; if (strlen($l) < 4 || $l[3] === ' ') break; }
        return $d;
    };
    $c = function ($cmd) use ($fp, $r) { fwrite($fp, $cmd . "\r\n"); return $r(); };
    $r();
    $c('EHLO ' . parse_url(SITE_URL, PHP_URL_HOST));
    if ($port === 587) {
        if (strpos($c('STARTTLS'), '220') !== 0) { fclose($fp); return false; }
        if (!stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT)) { fclose($fp); return false; }
        $c('EHLO ' . parse_url(SITE_URL, PHP_URL_HOST));
    }
    $c('AUTH LOGIN');
    $c(base64_encode($user));
    if (strpos($c(base64_encode($pass)), '235') !== 0) { fclose($fp); return false; }
    if (strpos($c("MAIL FROM:<$user>"), '250') !== 0) { fclose($fp); return false; }
    if (strpos($c("RCPT TO:<$to>"), '250') !== 0) { fclose($fp); return false; }
    if (strpos($c('DATA'), '354') !== 0) { fclose($fp); return false; }
    $b = 'ba_' . md5($to . time());
    $h  = "From: =?UTF-8?B?" . base64_encode($fromName) . "?= <$user>\r\n";
    $h .= "To: $to\r\nSubject: $subject\r\n";
    $h .= "Date: " . date('r') . "\r\nMessage-ID: <" . uniqid('', true) . "@" . parse_url(SITE_URL, PHP_URL_HOST) . ">\r\n";
    $h .= "MIME-Version: 1.0\r\nContent-Type: multipart/alternative; boundary=\"$b\"\r\n";
    $body  = "--$b\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n$textBody\r\n";
    $body .= "--$b\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n$htmlBody\r\n--$b--";
    if (strpos($c($h . "\r\n" . preg_replace('/^\./m', '..', $body) . "\r\n."), '250') !== 0) {
        fclose($fp); return false;
    }
    $c('QUIT');
    fclose($fp);
    return true;
}

$smtpHost = $cfg['sunucu'] ?? 'localhost';
$smtpPort = (int)($cfg['port'] ?? 465);
$ok = bulten_smtp_abone($smtpHost, $smtpPort, $cfg['kullanici'], $cfg['sifre'], $email, $subject, $htmlBody, $textBody, $fromName);

if (!$ok) {
    @file_put_contents($logDir . '/smtp-hatalar.log',
        date('c') . ' [bulten-abone] ' . $email . "\n", FILE_APPEND | LOCK_EX);
    $hata = $dil === 'en'
        ? 'Confirmation email could not be sent. Please try again later.'
        : 'Onay e-postası gönderilemedi. Lütfen daha sonra tekrar deneyin.';
    echo json_encode(['ok' => false, 'error' => $hata]);
    exit;
}

$mesaj = $dil === 'en'
    ? 'Confirmation email sent. Please check your inbox.'
    : 'Onay e-postası gönderildi. Gelen kutunuzu kontrol edin.';
echo json_encode(['ok' => true, 'mesaj' => $mesaj]);
