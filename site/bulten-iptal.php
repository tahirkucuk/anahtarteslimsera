<?php
// Bülten abonelik iptali — e-postadaki "iptal et / unsubscribe" linkine tıklanınca buraya gelir
require_once __DIR__ . '/inc/config.php';

$token = preg_replace('/[^a-f0-9]/', '', strtolower($_GET['token'] ?? ''));

$basari    = false;
$zatenIptal = false;
$gecersiz  = false;
$dil       = 'tr';

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
                $dil   = $k['dil'] ?? 'tr';
                $durum = $k['durum'] ?? 'onaylandi';
                if ($durum === 'iptal') {
                    $zatenIptal = true;
                } else {
                    $k['durum'] = 'iptal';
                    $k['iptal_tarihi'] = date('c');
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
?><!DOCTYPE html>
<html lang="<?= $dil ?>">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= $dil === 'en' ? 'Unsubscribed — Anahtar Teslim Sera' : 'Abonelik İptali — Anahtar Teslim Sera' ?></title>
  <meta name="robots" content="noindex, nofollow">
  <style>
    *,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
    body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Arial,sans-serif;background:#F2F4EE;color:#3A4A42;min-height:100vh;display:flex;flex-direction:column;align-items:center;justify-content:center;padding:24px}
    .card{background:#fff;border:1px solid #D7DDD2;border-radius:16px;padding:48px 40px;max-width:480px;width:100%;text-align:center;box-shadow:0 4px 24px rgba(14,26,21,.07)}
    .icon{font-size:52px;margin-bottom:20px;line-height:1}
    h1{font-size:22px;font-weight:700;color:#0F4430;margin-bottom:12px;letter-spacing:-0.02em}
    p{font-size:15px;line-height:1.7;color:#65756B;margin-bottom:24px}
    .btn{display:inline-flex;align-items:center;padding:12px 24px;background:#0F4430;color:#fff;border-radius:10px;font-weight:700;font-size:15px;text-decoration:none;transition:opacity .2s}
    .btn:hover{opacity:.85}
    .btn-ghost{background:transparent;color:#26654A;border:1.5px solid #D7DDD2;margin-top:12px}
    .btn-ghost:hover{border-color:#26654A}
    .logo{font-size:14px;font-weight:700;color:#0F4430;margin-bottom:28px;letter-spacing:-.01em;opacity:.65}
  </style>
</head>
<body>
  <div class="logo">Anahtar Teslim Sera</div>
  <div class="card">
    <?php if ($basari): ?>
      <div class="icon">👋</div>
      <?php if ($dil === 'en'): ?>
        <h1>You've been unsubscribed</h1>
        <p>You won't receive any more newsletters. You can resubscribe any time if you change your mind.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/en') ?>" class="btn">Go to homepage</a><br>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/en/blog') ?>" class="btn btn-ghost" style="display:inline-flex;margin-top:12px;">Browse guides</a>
      <?php else: ?>
        <h1>Aboneliğiniz İptal Edildi</h1>
        <p>Artık bülten almayacaksınız. Pişman olursanız istediğiniz zaman yeniden abone olabilirsiniz.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/')) ?>" class="btn">Ana Sayfaya Dön</a><br>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/blog') ?>" class="btn btn-ghost" style="display:inline-flex;margin-top:12px;">Rehberleri İncele</a>
      <?php endif; ?>
    <?php elseif ($zatenIptal): ?>
      <div class="icon">✓</div>
      <?php if ($dil === 'en'): ?>
        <h1>Already Unsubscribed</h1>
        <p>This subscription was already cancelled. You are not receiving any newsletters.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/en') ?>" class="btn">Go to homepage</a>
      <?php else: ?>
        <h1>Zaten İptal Edilmiş</h1>
        <p>Bu abonelik daha önce iptal edildi. Artık bülten almıyorsunuz.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/')) ?>" class="btn">Ana Sayfaya Dön</a>
      <?php endif; ?>
    <?php else: ?>
      <div class="icon">⚠️</div>
      <?php if ($dil === 'en'): ?>
        <h1>Invalid Link</h1>
        <p>This unsubscribe link is invalid. If you're still receiving emails, use the unsubscribe link in the latest newsletter you received.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/') . '/en') ?>" class="btn">Go to homepage</a>
      <?php else: ?>
        <h1>Geçersiz Link</h1>
        <p>Bu iptal bağlantısı geçersiz. Hâlâ bülten alıyorsanız, aldığınız son e-postadaki iptal linkini kullanın.</p>
        <a href="<?= htmlspecialchars(rtrim(SITE_URL, '/')) ?>" class="btn">Ana Sayfaya Dön</a>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</body>
</html>
