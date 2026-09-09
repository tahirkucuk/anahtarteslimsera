<?php
/**
 * Yardımcı fonksiyonlar. Şablonlarda kullanılan her şey burada.
 */

// PHP 7.4 uyumluluğu (Natro'da PHP sürümü 8.0 altındaysa devreye girer)
if (!function_exists('str_contains')) {
    function str_contains(string $h, string $n): bool { return $n === '' || strpos($h, $n) !== false; }
}
if (!function_exists('str_starts_with')) {
    function str_starts_with(string $h, string $n): bool { return strncmp($h, $n, strlen($n)) === 0; }
}

/** HTML kaçışı. Şablonda yazdırılan HER değişken bundan geçmeli. */
function e(?string $s): string
{
    return htmlspecialchars((string) $s, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}

/** Site içi bağlantı üretir: url('/hizmetler') */
function url(string $path = '/'): string
{
    if (preg_match('#^(https?:)?//#', $path)) {
        return $path;
    }
    return BASE_PATH . '/' . ltrim($path, '/');
}

/** Mutlak bağlantı (canonical, OG, sitemap için) */
function abs_url(string $path = '/'): string
{
    if (preg_match('#^https?://#', $path)) {
        return $path;
    }
    return rtrim(SITE_URL, '/') . url($path);
}

/** Varlık bağlantısı + sürüm damgası */
function asset(string $path): string
{
    return url('/assets/' . ltrim($path, '/')) . '?v=' . ASSET_VER;
}

/** Görsel dosyası (sürüm damgasız — srcset içinde gereksiz) */
function img_src(string $name, int $w, string $ext = 'jpg'): string
{
    return url("/assets/img/{$name}-{$w}.{$ext}");
}

/**
 * Duyarlı <picture> üretir.
 *
 * @param string $name  IMAGES anahtarı
 * @param string $alt   Alternatif metin (SEO ve erişilebilirlik için zorunlu)
 * @param array  $o     sizes, class, loading, fetchpriority, ratio
 */
function picture(string $name, string $alt, array $o = []): string
{
    if (!isset(IMAGES[$name])) {
        return '<!-- görsel bulunamadı: ' . e($name) . ' -->';
    }
    $m       = IMAGES[$name];
    $sizes   = $o['sizes']    ?? '100vw';
    $class   = $o['class']    ?? '';
    $loading = $o['loading']  ?? 'lazy';
    $prio    = $o['fetchpriority'] ?? null;

    $jpg = $webp = [];
    foreach ($m['sizes'] as $w) {
        $jpg[]  = img_src($name, $w, 'jpg')  . " {$w}w";
        $webp[] = img_src($name, $w, 'webp') . " {$w}w";
    }
    $fallback = img_src($name, $m['sizes'][min(1, count($m['sizes']) - 1)], 'jpg');

    $attrs = sprintf(
        'src="%s" srcset="%s" sizes="%s" width="%d" height="%d" alt="%s" loading="%s" decoding="async"',
        e($fallback), e(implode(', ', $jpg)), e($sizes), $m['w'], $m['h'], e($alt), e($loading)
    );
    if ($prio) {
        $attrs .= ' fetchpriority="' . e($prio) . '"';
    }
    if ($class !== '') {
        $attrs .= ' class="' . e($class) . '"';
    }

    return '<picture>'
        . '<source type="image/webp" srcset="' . e(implode(', ', $webp)) . '" sizes="' . e($sizes) . '">'
        . '<img ' . $attrs . '>'
        . '</picture>';
}

/** "Temsili görsel" rozeti — gerçek fotoğraflar gelince config'ten kapatılır. */
function placeholder_badge(string $class = 'shot-badge'): string
{
    if (!IMAGES_ARE_PLACEHOLDER) {
        return '';
    }
    return '<span class="' . e($class) . '">Temsili görsel</span>';
}

/** Menüde aktif bağlantıyı işaretler. */
function nav_active(string $path): string
{
    $cur = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    $cur = rtrim($cur, '/');
    $tgt = rtrim(url($path), '/');
    if ($tgt === '' ) {
        $tgt = '/';
    }
    if ($cur === '' ) {
        $cur = '/';
    }
    if ($cur === $tgt || ($tgt !== '/' && str_starts_with($cur, $tgt . '/'))) {
        return ' aria-current="page"';
    }
    return '';
}

/** Tarihi Türkçe yazar: 12 Mart 2026 */
function tr_date(string $iso): string
{
    static $ay = [1=>'Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'];
    $t = strtotime($iso);
    return $t ? date('j', $t) . ' ' . $ay[(int) date('n', $t)] . ' ' . date('Y', $t) : $iso;
}

/** Metni belirli uzunlukta kırpar (meta açıklama üretirken kullanışlı). */
function excerpt(string $text, int $len = 155): string
{
    $text = trim(preg_replace('/\s+/u', ' ', strip_tags($text)));
    if (mb_strlen($text, 'UTF-8') <= $len) {
        return $text;
    }
    $cut = mb_substr($text, 0, $len, 'UTF-8');
    $sp  = mb_strrpos($cut, ' ', 0, 'UTF-8');
    return rtrim(mb_substr($cut, 0, $sp ?: $len, 'UTF-8'), ' ,.;:') . '…';
}

/** CSRF anahtarı üretir/okur. */
function csrf_token(): string
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    if (empty($_SESSION['csrf'])) {
        $_SESSION['csrf'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf'];
}

function csrf_field(): string
{
    return '<input type="hidden" name="_token" value="' . e(csrf_token()) . '">';
}

function csrf_check(?string $token): bool
{
    if (session_status() !== PHP_SESSION_ACTIVE) {
        session_start();
    }
    return !empty($_SESSION['csrf']) && is_string($token) && hash_equals($_SESSION['csrf'], $token);
}

/** Başlıktan URL parçası üretir (Türkçe karakter duyarlı). */
function slugify(string $s): string
{
    $tr = ['ı'=>'i','İ'=>'i','ş'=>'s','Ş'=>'s','ğ'=>'g','Ğ'=>'g','ü'=>'u','Ü'=>'u','ö'=>'o','Ö'=>'o','ç'=>'c','Ç'=>'c'];
    $s  = strtr($s, $tr);
    $s  = mb_strtolower($s, 'UTF-8');
    $s  = preg_replace('/[^a-z0-9]+/u', '-', $s);
    return trim($s, '-');
}
