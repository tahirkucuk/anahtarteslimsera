<?php
/** Dinamik site haritası — /sitemap.xml adresinden sunulur (.htaccess yönlendirir). */
$page = [];
require_once __DIR__ . '/inc/bootstrap.php';

header('Content-Type: application/xml; charset=UTF-8');

$urls = [
    ['loc' => '/',           'pri' => '1.0', 'freq' => 'weekly'],
    ['loc' => '/hizmetler',  'pri' => '0.9', 'freq' => 'monthly'],
    ['loc' => '/surec',      'pri' => '0.8', 'freq' => 'monthly'],
    ['loc' => '/projeler',   'pri' => '0.8', 'freq' => 'monthly'],
    ['loc' => '/blog',       'pri' => '0.7', 'freq' => 'weekly'],
    ['loc' => '/iletisim',   'pri' => '0.9', 'freq' => 'monthly'],
    ['loc' => '/gizlilik',   'pri' => '0.2', 'freq' => 'yearly'],
];
foreach (get_services() as $s) {
    $urls[] = ['loc' => '/hizmetler/' . $s['slug'], 'pri' => '0.9', 'freq' => 'monthly'];
}
foreach (get_posts() as $p) {
    $urls[] = ['loc' => '/blog/' . $p['slug'], 'pri' => '0.6', 'freq' => 'yearly', 'mod' => $p['date']];
}

echo '<?xml version="1.0" encoding="UTF-8"?>' . "\n";
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $u): ?>
  <url>
    <loc><?= e(abs_url($u['loc'])) ?></loc>
    <lastmod><?= e($u['mod'] ?? date('Y-m-d')) ?></lastmod>
    <changefreq><?= e($u['freq']) ?></changefreq>
    <priority><?= e($u['pri']) ?></priority>
  </url>
<?php endforeach; ?>
</urlset>
