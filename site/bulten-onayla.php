<?php
// Bülten onay sayfası — e-postadaki link buraya gelir
require_once __DIR__ . '/inc/config.php';

$token = preg_replace('/[^a-f0-9]/', '', strtolower($_GET['token'] ?? ''));

$basari         = false;
$zatenOnaylandi = false;
$gecersiz       = false;
$onaylananEposta = '';
$dil            = 'tr'; // aboneden okunur, fallback tr

if (strlen($token) === 32) {
    $dosya = dirname(__DIR__) . '/lead-kayitlari/aboneler.jsonl';
    $fh = @fopen($dosya, 'c+');
    if ($fh) {
        flock($fh, LOCK_EX);
        $kayitlar = [];
        $bulundu  = false;
        rewind($fh);
        while (($satir = fgets($fh)) !== false) {
            $satir = trim($satir);
            if ($satir === '') continue;
            $k = json_decode($satir, true);
            if (!$k) continue;
            if (($k['token'] ?? '') === $token) {
                $bulundu = true;
                $dil = $k['dil'] ?? 'tr';
                $durum = $k['durum'] ?? 'beklemede';
                if ($durum === 'onaylandi') {
                    $zatenOnaylandi = true;
                } elseif ($durum === 'beklemede') {
                    $k['durum'] = 'onaylandi';
                    $k['onay_tarihi'] = date('c');
                    $onaylananEposta = $k['eposta'] ?? '';
                    $basari = true;
                }
            }
            $kayitlar[] = json_encode($k, JSON_UNESCAPED_UNICODE);
        }
        if (!$bulundu) { $gecersiz = true; }
        if ($basari) {
            ftruncate($fh, 0);
            rewind($fh);
            fwrite($fh, implode("\n", $kayitlar) . "\n");
        }
        fflush($fh);
        flock($fh, LOCK_UN);
        fclose($fh);
    } else {
        $gecersiz = true;
    }
} else {
    $gecersiz = true;
}

// Karşılama maili — onaylayan aboneye gönder
if ($basari && $onaylananEposta !== '') {
    $cfgPath = dirname(__DIR__) . '/.smtp-ayar.json';
    $cfg = is_readable($cfgPath) ? json_decode(file_get_contents($cfgPath), true) : null;
    if ($cfg && !empty($cfg['kullanici']) && !empty($cfg['sifre'])) {
        $smtpHost  = $cfg['sunucu'] ?? 'localhost';
        $smtpPort  = (int)($cfg['port'] ?? 465);
        $base      = rtrim(SITE_URL, '/');
        $iptalLink = $base . '/bulten-iptal.php?token=' . $token;
        $blogLink  = $dil === 'en' ? $base . '/en/blog' : $base . '/blog';

        if ($dil === 'en') {
            $subject  = '=?UTF-8?B?' . base64_encode('Welcome! Your subscription is active — Anahtar Teslim Sera') . '?=';
            $htmlBody = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="font-family:Arial,sans-serif;max-width:560px;margin:0 auto;background:#f4f6f2;color:#334155;">
<div style="background:#0F4430;padding:28px 32px;border-radius:12px 12px 0 0;">
  <span style="font-weight:800;font-size:18px;color:#fff;">Anahtar Teslim Sera</span>
  <span style="display:block;font-size:12px;color:#6aad8a;margin-top:4px;">anahtarteslimsera.com</span>
</div>
<div style="background:#fff;padding:32px;border:1px solid #dce7df;border-top:none;">
  <h2 style="font-size:20px;font-weight:700;color:#0F4430;margin:0 0 16px;">Welcome to the newsletter!</h2>
  <p style="font-size:15px;line-height:1.7;color:#475569;margin:0 0 16px;">
    Your subscription is confirmed. Greenhouse investment guides and irrigation insights will now land directly in your inbox.
  </p>
  <a href="' . htmlspecialchars($blogLink) . '"
     style="display:inline-block;padding:14px 28px;background:#26654A;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;">
    Browse guides →
  </a>
</div>
<div style="background:#f4f6f2;padding:14px 32px;border-radius:0 0 12px 12px;border:1px solid #dce7df;border-top:none;">
  <p style="font-size:12px;color:#94A3B8;margin:0;">
    <a href="' . $base . '" style="color:#26654A;text-decoration:none;">anahtarteslimsera.com</a>
    &nbsp;·&nbsp;
    <a href="' . htmlspecialchars($iptalLink) . '" style="color:#94A3B8;">Unsubscribe</a>
  </p>
</div>
</body></html>';
            $textBody  = "Welcome — Anahtar Teslim Sera\n\n";
            $textBody .= "Your subscription is confirmed. Guides will now land in your inbox.\n\n";
            $textBody .= "Browse guides: $blogLink\n\n---\nUnsubscribe: $iptalLink\n";
        } else {
            $subject  = '=?UTF-8?B?' . base64_encode('Hoş geldiniz! Bülteniniz aktif — Anahtar Teslim Sera') . '?=';
            $htmlBody = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head>
<body style="font-family:Arial,sans-serif;max-width:560px;margin:0 auto;background:#f4f6f2;color:#334155;">
<div style="background:#0F4430;padding:28px 32px;border-radius:12px 12px 0 0;">
  <span style="font-weight:800;font-size:18px;color:#fff;">Anahtar Teslim Sera</span>
  <span style="display:block;font-size:12px;color:#6aad8a;margin-top:4px;">anahtarteslimsera.com</span>
</div>
<div style="background:#fff;padding:32px;border:1px solid #dce7df;border-top:none;">
  <h2 style="font-size:20px;font-weight:700;color:#0F4430;margin:0 0 16px;">Bültene hoş geldiniz!</h2>
  <p style="font-size:15px;line-height:1.7;color:#475569;margin:0 0 16px;">
    Aboneliğiniz onaylandı. Bundan böyle sera yatırımı ve sulama rehberleri doğrudan gelen kutunuza gelecek.
  </p>
  <a href="' . htmlspecialchars($blogLink) . '"
     style="display:inline-block;padding:14px 28px;background:#26654A;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;">
    Rehberleri İncele →
  </a>
</div>
<div style="background:#f4f6f2;padding:14px 32px;border-radius:0 0 12px 12px;border:1px solid #dce7df;border-top:none;">
  <p style="font-size:12px;color:#94A3B8;margin:0;">
    <a href="' . $base . '" style="color:#26654A;text-decoration:none;">anahtarteslimsera.com</a>
    &nbsp;·&nbsp;
    <a href="' . htmlspecialchars($iptalLink) . '" style="color:#94A3B8;">Abonelikten çık</a>
  </p>
</div>
</body></html>';
            $textBody  = "Hoş geldiniz — Anahtar Teslim Sera\n\n";
            $textBody .= "Aboneliğiniz onaylandı. Sera rehberleri artık doğrudan gelen kutunuza gelecek.\n\n";
            $textBody .= "Rehberleri inceleyin: $blogLink\n\n---\nAbonelikten çıkmak için: $iptalLink\n";
        }

        $fp = @fsockopen(($smtpPort === 465 ? 'ssl://' : '') . $smtpHost, $smtpPort, $e, $s, 15);
        if ($fp) {
            stream_set_timeout($fp, 15);
            $r = function () use ($fp) { $d = ''; while ($l = fgets($fp, 515)) { $d .= $l; if (strlen($l) < 4 || $l[3] === ' ') break; } return $d; };
            $c = function ($cmd) use ($fp, $r) { fwrite($fp, $cmd . "\r\n"); return $r(); };
            $host = parse_url(SITE_URL, PHP_URL_HOST);
            $r(); $c("EHLO $host");
            if ($smtpPort === 587) { $c('STARTTLS'); stream_socket_enable_crypto($fp, true, STREAM_CRYPTO_METHOD_TLS_CLIENT); $c("EHLO $host"); }
            $c('AUTH LOGIN'); $c(base64_encode($cfg['kullanici']));
            if (strpos($c(base64_encode($cfg['sifre'])), '235') === 0) {
                $c("MAIL FROM:<{$cfg['kullanici']}>"); $c("RCPT TO:<$onaylananEposta>");
                if (strpos($c('DATA'), '354') === 0) {
                    $b = 'bo_' . md5($onaylananEposta . $token);
                    $h  = "From: =?UTF-8?B?" . base64_encode('Anahtar Teslim Sera') . "?= <{$cfg['kullanici']}>\r\n";
                    $h .= "To: $onaylananEposta\r\nSubject: $subject\r\n";
                    $h .= "Date: " . date('r') . "\r\nMessage-ID: <" . uniqid('', true) . "@$host>\r\n";
                    $h .= "MIME-Version: 1.0\r\nContent-Type: multipart/alternative; boundary=\"$b\"\r\n";
                    $body  = "--$b\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n$textBody\r\n";
                    $body .= "--$b\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n$htmlBody\r\n--$b--";
                    $c($h . "\r\n" . preg_replace('/^\./m', '..', $body) . "\r\n.");
                }
            }
            fwrite($fp, "QUIT\r\n"); fclose($fp);
        }
    }
}
?><!DOCTYPE html>
<html lang="<?= $dil ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $dil === 'en' ? 'Newsletter Confirmed — Anahtar Teslim Sera' : 'Bülten Onayı — Anahtar Teslim Sera' ?></title>
  <meta name="robots" content="noindex, nofollow">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;background:#F2F4EE;color:#3A4A42;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px}
    .card{background:#fff;border:1px solid #D7DDD2;border-radius:16px;padding:48px 40px;max-width:480px;width:100%;text-align:center;box-shadow:0 4px 24px rgba(14,26,21,.07)}
    .icon{font-size:52px;margin-bottom:20px;line-height:1}
    h1{font-size:22px;font-weight:700;color:#0F4430;margin-bottom:12px;letter-spacing:-0.02em}
    p{font-size:15px;line-height:1.7;color:#65756B;margin-bottom:24px}
    .btn{display:inline-flex;align-items:center;gap:8px;padding:12px 24px;background:#26654A;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;transition:opacity .2s}
    .btn:hover{opacity:.88}
    .logo{font-size:14px;font-weight:700;color:#0F4430;margin-bottom:28px;letter-spacing:-.01em;opacity:.65}
  </style>
</head>
<body>
  <div class="logo">Anahtar Teslim Sera</div>
  <div class="card">
    <?php if ($basari): ?>
      <div class="icon">✅</div>
      <?php if ($dil === 'en'): ?>
        <h1>Subscription Confirmed!</h1>
        <p>You'll now receive greenhouse investment and irrigation guides directly in your inbox. You can unsubscribe any time.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/en/blog') ?>" class="btn">Browse guides →</a>
      <?php else: ?>
        <h1>Aboneliğiniz Onaylandı!</h1>
        <p>Sera yatırımı ve sulama rehberlerini artık doğrudan gelen kutunuzda alacaksınız. İstediğiniz zaman abonelikten çıkabilirsiniz.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/blog') ?>" class="btn">Rehberleri İncele →</a>
      <?php endif; ?>
    <?php elseif ($zatenOnaylandi): ?>
      <div class="icon">👍</div>
      <?php if ($dil === 'en'): ?>
        <h1>Already Subscribed</h1>
        <p>This email address is already on our newsletter list. New guides land in your inbox automatically.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/')) ?>" class="btn">Go to homepage</a>
      <?php else: ?>
        <h1>Zaten Abonesiniz</h1>
        <p>Bu e-posta adresi zaten bültenimize kayıtlı. Yeni rehberler otomatik olarak gelen kutunuza ulaşıyor.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/')) ?>" class="btn">Ana Sayfaya Dön</a>
      <?php endif; ?>
    <?php else: ?>
      <div class="icon">⚠️</div>
      <?php if ($dil === 'en'): ?>
        <h1>Invalid or Expired Link</h1>
        <p>This confirmation link is invalid or has already been used. Try subscribing again.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/en/blog') ?>" class="btn">Back to site</a>
      <?php else: ?>
        <h1>Geçersiz veya Süresi Dolmuş Link</h1>
        <p>Bu onay bağlantısı geçersiz veya daha önce kullanılmış. Yeniden abone olmayı deneyin.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/blog') ?>" class="btn">Siteye Dön</a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</body>
</html>
