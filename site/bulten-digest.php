<?php
// Bülten digest — yeni blog yazıları abonelere gönderilir (TR ve EN ayrı ayrı)
// POST: token=... [gun=7] [limit=3] [test_eposta=...] [force=1]
// Dil ayrımı: TR aboneler TR posts.json, EN aboneler posts.en.json alır
header('Content-Type: application/json; charset=utf-8');

if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['ok'=>false]); exit; }

require_once __DIR__ . '/inc/config.php';
$BULTEN_TOKEN = '7e3a91f2c4b8d06e5f1a29b7c3d8e4f0'; // .smtp-ayar.json ile aynı dizinde saklayın veya burada tutun
if (!hash_equals($BULTEN_TOKEN, $_POST['token'] ?? '')) { http_response_code(404); exit; }

$gun   = min((int)($_POST['gun']   ?? 7),  14);
$limit = min((int)($_POST['limit'] ?? 3),   6);
$force = ($_POST['force'] ?? '') === '1';
$testEposta = trim($_POST['test_eposta'] ?? '');

// Durum sorgusu (göndermez)
if (($_POST['eylem'] ?? '') === 'durum') {
    $stateFile = dirname(__DIR__) . '/lead-kayitlari/digest-son-gonderim.txt';
    echo json_encode(['ok'=>true,'eylem'=>'durum',
        'sonGonderilenTarih'=>is_readable($stateFile)?trim(file_get_contents($stateFile)):'',
        'sonGonderimZamani'=>is_readable($stateFile)?date('c',filemtime($stateFile)):'']);
    exit;
}

// SMTP config
$cfgPath = dirname(__DIR__) . '/.smtp-ayar-sera.json';
$cfg = is_readable($cfgPath) ? json_decode(file_get_contents($cfgPath), true) : null;
if (!$cfg || empty($cfg['kullanici'])) { echo json_encode(['ok'=>false,'error'=>'smtp yok']); exit; }

// Aboneleri dile göre grupla
$trAboneler = [];
$enAboneler = [];
$aboneDosya = dirname(__DIR__) . '/lead-kayitlari/aboneler.jsonl';
if (is_readable($aboneDosya)) {
    foreach (file($aboneDosya, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES) as $s) {
        $k = json_decode($s, true);
        if (!$k || empty($k['eposta'])) continue;
        if (($k['durum'] ?? 'onaylandi') !== 'onaylandi') continue;
        $ep = strtolower($k['eposta']);
        $tok = $k['token'] ?? '';
        if (($k['dil'] ?? 'tr') === 'en') { $enAboneler[$ep] = $tok; }
        else                               { $trAboneler[$ep] = $tok; }
    }
}
if ($testEposta !== '') {
    if (!filter_var($testEposta, FILTER_VALIDATE_EMAIL)) { echo json_encode(['ok'=>false,'error'=>'geçersiz test_eposta']); exit; }
    $ep = strtolower($testEposta);
    $trAboneler = [$ep => '']; $enAboneler = [$ep => ''];
}

// posts.json oku ve filtrele (son $gun gün, max $limit)
function digest_posts(string $jsonPath, int $gun, int $limit): array {
    if (!is_readable($jsonPath)) return [];
    $all  = json_decode(file_get_contents($jsonPath), true) ?: [];
    $esik = date('Y-m-d', strtotime("-{$gun} days"));
    $new  = array_values(array_filter($all, fn($y) => ($y['date'] ?? '1970-01-01') >= $esik));
    usort($new, fn($a,$b) => strcmp($b['date'], $a['date']));
    return array_slice($new, 0, $limit);
}

$trPosts = digest_posts(__DIR__ . '/content/blog/posts.json', $gun, $limit);
$enPosts = digest_posts(__DIR__ . '/content/blog/posts.en.json', $gun, $limit);

if (empty($trPosts) && empty($enPosts)) {
    echo json_encode(['ok'=>true,'gonderilen'=>0,'not'=>"Son {$gun} günde yeni yazı yok"]); exit;
}

// DEDUP: en yeni TR tarihine göre — her iki dil aynı yazıları içerdiğinden TR referans
$stateFile    = dirname(__DIR__) . '/lead-kayitlari/digest-son-gonderim.txt';
$sonGonderilen = is_readable($stateFile) ? trim(file_get_contents($stateFile)) : '';
$enYeniTarih  = $trPosts[0]['date'] ?? ($enPosts[0]['date'] ?? '');

if (!$force) {
    if ($enYeniTarih !== '' && $enYeniTarih <= $sonGonderilen) {
        echo json_encode(['ok'=>true,'gonderilen'=>0,'not'=>"Yeni yazı yok (son gönderim: {$sonGonderilen})"]); exit;
    }
    if (is_readable($stateFile) && (time() - filemtime($stateFile)) < 20*3600) {
        echo json_encode(['ok'=>true,'gonderilen'=>0,'not'=>'Son gönderimden 20 saatten az geçti']); exit;
    }
}

// E-posta HTML şablonu
function digest_html_card(array $p, string $base, string $langPfx): string {
    $url   = $base . $langPfx . '/blog/' . htmlspecialchars($p['slug'] ?? '');
    $title = htmlspecialchars($p['title'] ?? '');
    $exc   = htmlspecialchars($p['excerpt'] ?? '');
    $cat   = htmlspecialchars($p['category'] ?? '');
    $date  = htmlspecialchars($p['date'] ?? '');
    $img   = $p['image'] ?? '';
    $thumb = $img !== '' ? $base . '/assets/img/' . $img . '-480.jpg' : '';

    $gorsel = $thumb !== '' ? "
      <td width='160' style='vertical-align:top;padding:0;'>
        <a href='$url' style='display:block;'><img src='$thumb' width='160' height='110' alt='' style='display:block;width:160px;height:110px;object-fit:cover;border-radius:0 10px 10px 0;'></a>
      </td>" : '';

    return "
<tr><td style='padding:0 16px 10px;'>
  <table width='100%' cellpadding='0' cellspacing='0' style='background:#fff;border:1px solid #D7DDD2;border-left:3px solid #26654A;border-radius:10px;overflow:hidden;'>
    <tr>
      <td style='padding:16px 18px 16px 20px;vertical-align:top;'>
        <div style='margin-bottom:8px;'>
          <span style='font-size:10px;font-weight:700;color:#26654A;letter-spacing:.08em;text-transform:uppercase;'>$cat</span>
          <span style='font-size:10px;color:#94A3B8;margin-left:8px;'>$date</span>
        </div>
        <h2 style='margin:0 0 8px;font-size:16px;font-weight:700;color:#0E1A15;line-height:1.4;'>
          <a href='$url' style='color:#0E1A15;text-decoration:none;'>$title</a>
        </h2>
        <p style='margin:0 0 12px;font-size:13px;color:#65756B;line-height:1.65;'>$exc</p>
        <a href='$url' style='font-size:12px;font-weight:600;color:#26654A;text-decoration:none;'>Devamını oku →</a>
      </td>$gorsel
    </tr>
  </table>
</td></tr>
<tr><td style='height:6px;'></td></tr>";
}

function digest_html_card_en(array $p, string $base): string {
    $url   = $base . '/en/blog/' . htmlspecialchars($p['slug'] ?? '');
    $title = htmlspecialchars($p['title'] ?? '');
    $exc   = htmlspecialchars($p['excerpt'] ?? '');
    $cat   = htmlspecialchars($p['category'] ?? '');
    $date  = htmlspecialchars($p['date'] ?? '');
    $img   = $p['image'] ?? '';
    $thumb = $img !== '' ? $base . '/assets/img/' . $img . '-480.jpg' : '';

    $gorsel = $thumb !== '' ? "
      <td width='160' style='vertical-align:top;padding:0;'>
        <a href='$url' style='display:block;'><img src='$thumb' width='160' height='110' alt='' style='display:block;width:160px;height:110px;object-fit:cover;border-radius:0 10px 10px 0;'></a>
      </td>" : '';

    return "
<tr><td style='padding:0 16px 10px;'>
  <table width='100%' cellpadding='0' cellspacing='0' style='background:#fff;border:1px solid #D7DDD2;border-left:3px solid #26654A;border-radius:10px;overflow:hidden;'>
    <tr>
      <td style='padding:16px 18px 16px 20px;vertical-align:top;'>
        <div style='margin-bottom:8px;'>
          <span style='font-size:10px;font-weight:700;color:#26654A;letter-spacing:.08em;text-transform:uppercase;'>$cat</span>
          <span style='font-size:10px;color:#94A3B8;margin-left:8px;'>$date</span>
        </div>
        <h2 style='margin:0 0 8px;font-size:16px;font-weight:700;color:#0E1A15;line-height:1.4;'>
          <a href='$url' style='color:#0E1A15;text-decoration:none;'>$title</a>
        </h2>
        <p style='margin:0 0 12px;font-size:13px;color:#65756B;line-height:1.65;'>$exc</p>
        <a href='$url' style='font-size:12px;font-weight:600;color:#26654A;text-decoration:none;'>Read more →</a>
      </td>$gorsel
    </tr>
  </table>
</td></tr>
<tr><td style='height:6px;'></td></tr>";
}

function digest_html_wrapper(string $kartlar, string $subjLine, string $blogLink, string $base, string $lang): string {
    $iptal_placeholder = '%%IPTAL_LINK%%';
    $unsub = $lang === 'en' ? 'Unsubscribe' : 'Abonelikten çık';
    $footer = $lang === 'en'
        ? "Greenhouse investment newsletter &nbsp;·&nbsp; <a href='$base/en' style='color:#65756B;'>anahtarteslimsera.com</a><br>$iptal_placeholder"
        : "Sera yatırımı rehberleri bülteni &nbsp;·&nbsp; <a href='$base' style='color:#65756B;'>anahtarteslimsera.com</a><br>$iptal_placeholder";
    $cta = $lang === 'en' ? 'View all guides →' : 'Tüm rehberleri gör →';

    return "<!DOCTYPE html><html><head><meta charset='UTF-8'><meta name='viewport' content='width=device-width,initial-scale=1'></head>
<body style='margin:0;padding:20px 0;background:#E8EBE2;font-family:-apple-system,BlinkMacSystemFont,Arial,sans-serif;'>
<table width='100%' cellpadding='0' cellspacing='0'><tr><td align='center'>
<table width='620' cellpadding='0' cellspacing='0' style='max-width:620px;width:100%;'>

<tr><td style='background:#0F4430;padding:24px 28px 20px;border-radius:12px 12px 0 0;'>
  <span style='font-size:20px;font-weight:700;color:#fff;letter-spacing:-.02em;'>Anahtar Teslim Sera</span>
  <span style='display:block;font-size:12px;color:#6aad8a;margin-top:3px;'>anahtarteslimsera.com</span>
</td></tr>

<tr><td style='background:#163d29;padding:14px 28px;border-bottom:2px solid #B26A16;'>
  <p style='margin:0;font-size:14px;font-weight:600;color:#E7EEE9;'>$subjLine</p>
</td></tr>

<tr><td style='background:#F2F4EE;padding:16px 0 8px;'>
  <table width='100%' cellpadding='0' cellspacing='0'>$kartlar</table>
</td></tr>

<tr><td style='padding:0 16px 16px;'>
  <table width='100%' cellpadding='0' cellspacing='0'><tr>
    <td style='background:#0F4430;padding:14px 24px;border-radius:10px;text-align:center;'>
      <a href='$blogLink' style='font-size:13px;font-weight:600;color:#B26A16;text-decoration:none;'>$cta</a>
    </td>
  </tr></table>
</td></tr>

<tr><td style='background:#0F4430;padding:16px 28px;border-radius:0 0 12px 12px;'>
  <p style='margin:0;font-size:11px;color:#6aad8a;line-height:1.7;'>$footer</p>
</td></tr>

</table></td></tr></table>
</body></html>";
}

// SMTP gönderim fonksiyonu
function bulten_smtp_digest($host,$port,$user,$pass,$to,$subj,$html,$text) {
    $fp=@fsockopen(($port===465?'ssl://':'').$host,$port,$e,$s,15);if(!$fp)return false;
    stream_set_timeout($fp,15);
    $r=function()use($fp){$d='';while($l=fgets($fp,515)){$d.=$l;if(strlen($l)<4||$l[3]===' ')break;}return $d;};
    $c=function($cmd)use($fp,$r){fwrite($fp,$cmd."\r\n");return $r();};
    $h=parse_url(SITE_URL,PHP_URL_HOST);
    $r();$c("EHLO $h");
    if($port===587){if(strpos($c('STARTTLS'),'220')!==0){fclose($fp);return false;}if(!stream_socket_enable_crypto($fp,true,STREAM_CRYPTO_METHOD_TLS_CLIENT)){fclose($fp);return false;}$c("EHLO $h");}
    $c('AUTH LOGIN');$c(base64_encode($user));
    if(strpos($c(base64_encode($pass)),'235')!==0){fclose($fp);return false;}
    if(strpos($c("MAIL FROM:<$user>"),'250')!==0){fclose($fp);return false;}
    if(strpos($c("RCPT TO:<$to>"),'250')!==0){fclose($fp);return false;}
    if(strpos($c('DATA'),'354')!==0){fclose($fp);return false;}
    $b='bd_'.md5($to.microtime());
    $hd="From: =?UTF-8?B?".base64_encode("Anahtar Teslim Sera")."?= <$user>\r\nTo: $to\r\nSubject: $subj\r\nDate: ".date('r')."\r\nMessage-ID: <".uniqid('',true)."@$h>\r\nMIME-Version: 1.0\r\nContent-Type: multipart/alternative; boundary=\"$b\"\r\n";
    $body="--$b\r\nContent-Type: text/plain; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n$text\r\n--$b\r\nContent-Type: text/html; charset=UTF-8\r\nContent-Transfer-Encoding: 8bit\r\n\r\n$html\r\n--$b--";
    if(strpos($c($hd."\r\n".preg_replace('/^\./m','..',$body)."\r\n."),'250')!==0){fclose($fp);return false;}
    $c('QUIT');fclose($fp);return true;
}

$base     = rtrim(SITE_URL, '/');
$smtpHost = $cfg['sunucu'] ?? 'localhost';
$smtpPort = (int)($cfg['port'] ?? 465);
$gonderilen = 0;
$basarisiz  = 0;

// ── TR gönderimi ──
if (!empty($trPosts) && !empty($trAboneler)) {
    $aylar = ['','Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'];
    $tarih  = date('j').' '.$aylar[(int)date('n')].' '.date('Y');
    $sayi   = count($trPosts);
    $kartlar = '';
    foreach ($trPosts as $p) $kartlar .= digest_html_card($p, $base, '');
    $subjLine = "Bu hafta $sayi yeni rehber · $tarih";
    $subjEncoded = '=?UTF-8?B?' . base64_encode("Anahtar Teslim Sera · $tarih — $sayi yeni rehber") . '?=';
    $htmlTpl = digest_html_wrapper($kartlar, $subjLine, "$base/blog", $base, 'tr');
    $textTpl = "Anahtar Teslim Sera — $tarih\n\n";
    foreach ($trPosts as $p) $textTpl .= "• {$p['title']}\n  $base/blog/{$p['slug']}\n\n";

    foreach ($trAboneler as $eposta => $tok) {
        $iptal   = $tok ? "$base/bulten-iptal.php?token=$tok" : "$base/bulten-iptal.php";
        $aboHtml = str_replace('%%IPTAL_LINK%%', "<a href='$iptal' style='color:#6aad8a;'>Abonelikten çık</a>", $htmlTpl);
        $aboText = $textTpl . "---\nAbonelikten çıkmak için: $iptal";
        $ok = bulten_smtp_digest($smtpHost, $smtpPort, $cfg['kullanici'], $cfg['sifre'], $eposta, $subjEncoded, $aboHtml, $aboText);
        $ok ? $gonderilen++ : $basarisiz++;
        if (count($trAboneler) > 1) usleep(350000);
    }
}

// ── EN gönderimi ──
if (!empty($enPosts) && !empty($enAboneler)) {
    $months = ['','January','February','March','April','May','June','July','August','September','October','November','December'];
    $tarih  = $months[(int)date('n')] . ' ' . date('j') . ', ' . date('Y');
    $sayi   = count($enPosts);
    $kartlar = '';
    foreach ($enPosts as $p) $kartlar .= digest_html_card_en($p, $base);
    $subjLine = "$sayi new guides this week · $tarih";
    $subjEncoded = '=?UTF-8?B?' . base64_encode("Anahtar Teslim Sera · $tarih — $sayi new guides") . '?=';
    $htmlTpl = digest_html_wrapper($kartlar, $subjLine, "$base/en/blog", $base, 'en');
    $textTpl = "Anahtar Teslim Sera — $tarih\n\n";
    foreach ($enPosts as $p) $textTpl .= "• {$p['title']}\n  $base/en/blog/{$p['slug']}\n\n";

    foreach ($enAboneler as $eposta => $tok) {
        $iptal   = $tok ? "$base/bulten-iptal.php?token=$tok" : "$base/bulten-iptal.php";
        $aboHtml = str_replace('%%IPTAL_LINK%%', "<a href='$iptal' style='color:#6aad8a;'>Unsubscribe</a>", $htmlTpl);
        $aboText = $textTpl . "---\nUnsubscribe: $iptal";
        $ok = bulten_smtp_digest($smtpHost, $smtpPort, $cfg['kullanici'], $cfg['sifre'], $eposta, $subjEncoded, $aboHtml, $aboText);
        $ok ? $gonderilen++ : $basarisiz++;
        if (count($enAboneler) > 1) usleep(350000);
    }
}

// DEDUP işaretini güncelle (sadece gerçek gönderimde, test değilse)
if ($testEposta === '' && $gonderilen > 0 && $enYeniTarih !== '') {
    @file_put_contents($stateFile, $enYeniTarih);
}

echo json_encode(['ok'=>true,'gonderilen'=>$gonderilen,'basarisiz'=>$basarisiz,
    'tr_abone'=>count($trAboneler),'en_abone'=>count($enAboneler),
    'tr_yazi'=>count($trPosts),'en_yazi'=>count($enPosts)], JSON_UNESCAPED_UNICODE);
