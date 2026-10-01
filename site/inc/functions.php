<?php
/**
 * Yardımcı fonksiyonlar. Şablonlarda kullanılan her şey burada.
 */

// PHP 7.4 uyumluluğu
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

/**
 * Site içi bağlantı üretir: url('/hizmetler')
 * LANG === 'en' olduğunda /en/ öneki eklenir.
 */
function url(string $path = '/'): string
{
    if (preg_match('#^(https?:)?//#', $path)) {
        return $path;
    }
    // API uç noktaları dil öneki almaz.
    if (str_starts_with($path, '/api/') || str_starts_with($path, 'api/')) {
        return BASE_PATH . '/' . ltrim($path, '/');
    }
    $prefix = (defined('LANG') && LANG === 'en') ? '/en' : '';
    return $prefix . BASE_PATH . '/' . ltrim($path, '/');
}

/** Mutlak bağlantı (canonical, OG, sitemap için) */
function abs_url(string $path = '/'): string
{
    if (preg_match('#^https?://#', $path)) {
        return $path;
    }
    return rtrim(SITE_URL, '/') . url($path);
}

/**
 * Aynı sayfanın belirli bir dildeki mutlak URL'si.
 * hreflang ve dil değiştirici için kullanılır.
 */
function lang_url(string $path, string $lang): string
{
    $base   = rtrim(SITE_URL, '/');
    $prefix = $lang === 'en' ? '/en' : '';
    return $base . $prefix . BASE_PATH . '/' . ltrim($path, '/');
}

/** Varlık bağlantısı + sürüm damgası */
function asset(string $path): string
{
    return url('/assets/' . ltrim($path, '/')) . '?v=' . ASSET_VER;
}

/** Görsel dosyası (sürüm damgasız) */
function img_src(string $name, int $w, string $ext = 'jpg'): string
{
    return url("/assets/img/{$name}-{$w}.{$ext}");
}

/**
 * Duyarlı <picture> üretir.
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

/** "Temsili görsel" rozeti. */
function placeholder_badge(string $class = 'shot-badge'): string
{
    if (!IMAGES_ARE_PLACEHOLDER) {
        return '';
    }
    $label = (defined('LANG') && LANG === 'en') ? 'Stock image' : 'Temsili görsel';
    return '<span class="' . e($class) . '">' . $label . '</span>';
}

/** Menüde aktif bağlantıyı işaretler. */
function nav_active(string $path): string
{
    $cur = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
    $cur = rtrim($cur, '/');
    $tgt = rtrim(url($path), '/');
    if ($tgt === '') { $tgt = '/'; }
    if ($cur === '') { $cur = '/'; }
    // Türkçe ana sayfa özel durumu
    if ($tgt === '' && ($cur === '' || $cur === '/')) {
        return ' aria-current="page"';
    }
    // İngilizce ana sayfa
    if ($tgt === '/en' && ($cur === '/en' || $cur === '/en/')) {
        return ' aria-current="page"';
    }
    if ($cur === $tgt || ($tgt !== '/' && $tgt !== '/en' && str_starts_with($cur, $tgt . '/'))) {
        return ' aria-current="page"';
    }
    return '';
}

/** Tarihi yerelleştirilmiş biçimde yazar. */
function tr_date(string $iso): string
{
    $t = strtotime($iso);
    if (!$t) return $iso;

    if (defined('LANG') && LANG === 'en') {
        return date('F j, Y', $t);
    }

    static $ay = [1=>'Ocak','Şubat','Mart','Nisan','Mayıs','Haziran','Temmuz','Ağustos','Eylül','Ekim','Kasım','Aralık'];
    return date('j', $t) . ' ' . $ay[(int) date('n', $t)] . ' ' . date('Y', $t);
}

/** Metni belirli uzunlukta kırpar. */
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

/** Başlıktan URL parçası üretir. */
function slugify(string $s): string
{
    $tr = ['ı'=>'i','İ'=>'i','ş'=>'s','Ş'=>'s','ğ'=>'g','Ğ'=>'g','ü'=>'u','Ü'=>'u','ö'=>'o','Ö'=>'o','ç'=>'c','Ç'=>'c'];
    $s  = strtr($s, $tr);
    $s  = mb_strtolower($s, 'UTF-8');
    $s  = preg_replace('/[^a-z0-9]+/u', '-', $s);
    return trim($s, '-');
}

/**
 * Çeviri yardımcısı. LANG === 'en' olduğunda lang/en.php'den çeker.
 * LANG === 'tr' ya da anahtar bulunamazsa $tr_fallback döner.
 *
 * @param string $key         lang/en.php'deki anahtar
 * @param string $tr_fallback Türkçe yedek metin (şablonlarda orijinal)
 * @param bool   $raw         true → e() uygulanmaz (HTML içeriyorsa)
 */
function t(string $key, string $tr_fallback = '', bool $raw = false): string
{
    if (!defined('LANG') || LANG !== 'en') {
        return $tr_fallback;
    }
    static $strings = null;
    if ($strings === null) {
        $file = defined('APP_ROOT') ? APP_ROOT . '/inc/lang/en.php' : __DIR__ . '/lang/en.php';
        $strings = is_file($file) ? (require $file) : [];
    }
    $val = $strings[$key] ?? $tr_fallback;
    return $raw ? $val : $val;
}

/**
 * Çeviri dizisi döner (iletisim.php ürün/kapsam listeleri için).
 */
function t_array(string $key): array
{
    if (!defined('LANG') || LANG !== 'en') {
        return [];
    }
    static $strings = null;
    if ($strings === null) {
        $file = defined('APP_ROOT') ? APP_ROOT . '/inc/lang/en.php' : __DIR__ . '/lang/en.php';
        $strings = is_file($file) ? (require $file) : [];
    }
    return $strings[$key] ?? [];
}
