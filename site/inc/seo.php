<?php
/**
 * SEO — meta etiketleri ve yapısal veri (JSON-LD).
 * Google'ın "Hizmet", "Makale", "SSS" ve "İçerik haritası" zenginleştirmeleri
 * bu dosyadan üretilir.
 */

/** Tarayıcı başlığı: sayfa başlığı + marka. */
function seo_title(array $page): string
{
    $t = trim((string) ($page['title'] ?? ''));
    if ($t === '' || $t === SITE_NAME) {
        return SITE_NAME . ' — ' . SITE_TAGLINE;
    }
    return $t . ' | ' . SITE_NAME;
}

/** OG görselinin mutlak adresi. */
function seo_image(array $page): string
{
    $img = $page['image'] ?? 'og-anahtar-teslim-sera';
    if (preg_match('#^https?://#', $img)) {
        return $img;
    }
    if (isset(IMAGES[$img])) {
        return abs_url("/assets/img/{$img}-1200.jpg");
    }
    return abs_url("/assets/img/{$img}.jpg");
}

/** <head> içine basılan bütün meta etiketleri. */
function seo_meta(array $page): void
{
    $url   = abs_url($page['path'] ?? '/');
    $title = seo_title($page);
    $desc  = excerpt((string) ($page['desc'] ?? ''), 158);
    $img   = seo_image($page);
    ?>
    <title><?= e($title) ?></title>
    <meta name="description" content="<?= e($desc) ?>">
    <link rel="canonical" href="<?= e($url) ?>">
    <?php if (!empty($page['noindex'])): ?>
    <meta name="robots" content="noindex, nofollow">
    <?php else: ?>
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1">
    <?php endif; ?>

    <meta property="og:type" content="<?= e($page['type'] ?? 'website') ?>">
    <meta property="og:site_name" content="<?= e(SITE_NAME) ?>">
    <meta property="og:locale" content="<?= e(SITE_LOCALE) ?>">
    <meta property="og:title" content="<?= e($title) ?>">
    <meta property="og:description" content="<?= e($desc) ?>">
    <meta property="og:url" content="<?= e($url) ?>">
    <meta property="og:image" content="<?= e($img) ?>">
    <meta property="og:image:width" content="1200">
    <meta property="og:image:height" content="630">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($title) ?>">
    <meta name="twitter:description" content="<?= e($desc) ?>">
    <meta name="twitter:image" content="<?= e($img) ?>">
    <?php if (GSC_VERIFICATION !== ''): ?>
    <meta name="google-site-verification" content="<?= e(GSC_VERIFICATION) ?>">
    <?php endif; ?>
    <?php
}

/** Kuruluş + yerel işletme düğümü — her sayfada basılır. */
function schema_organization(): array
{
    $sameAs = array_values(array_filter([
        SOCIAL_FACEBOOK, SOCIAL_INSTAGRAM, SOCIAL_YOUTUBE, SOCIAL_LINKEDIN,
    ]));

    $node = [
        '@type'       => 'ProfessionalService',
        '@id'         => abs_url('/') . '#organization',
        'name'        => SITE_NAME,
        'description' => 'Tarımsal danışmanlık, sera kurulumu ve sulama sistemlerini tek sözleşmede birleştiren anahtar teslim sera çözümleri.',
        'url'         => abs_url('/'),
        'image'       => abs_url('/assets/img/og-anahtar-teslim-sera.jpg'),
        'telephone'   => CONTACT_PHONE,
        'email'       => CONTACT_EMAIL,
        'areaServed'  => ['@type' => 'Country', 'name' => 'Türkiye'],
        'address'     => [
            '@type'           => 'PostalAddress',
            'streetAddress'   => CONTACT_ADDRESS,
            'addressCountry'  => 'TR',
        ],
        'knowsAbout'  => [
            'Anahtar teslim sera kurulumu',
            'Venlo cam sera',
            'Damla sulama sistemleri',
            'Fertigasyon',
            'Sera sulama otomasyonu',
            'Tarımsal danışmanlık',
        ],
    ];
    if ($sameAs) {
        $node['sameAs'] = $sameAs;
    }
    return $node;
}

/** Kırıntı navigasyonu düğümü. */
function schema_breadcrumbs(array $crumbs): ?array
{
    if (!$crumbs) {
        return null;
    }
    $items = [['@type' => 'ListItem', 'position' => 1, 'name' => 'Ana Sayfa', 'item' => abs_url('/')]];
    $i = 2;
    foreach ($crumbs as $c) {
        $items[] = [
            '@type'    => 'ListItem',
            'position' => $i++,
            'name'     => $c['name'],
            'item'     => abs_url($c['path'] ?? '/'),
        ];
    }
    return ['@type' => 'BreadcrumbList', 'itemListElement' => $items];
}

/** Sık sorulan sorular düğümü. */
function schema_faq(array $faqs): array
{
    return [
        '@type'      => 'FAQPage',
        'mainEntity' => array_map(fn($f) => [
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f['a']],
        ], $faqs),
    ];
}

/** Hizmet düğümü. */
function schema_service(array $s): array
{
    return [
        '@type'       => 'Service',
        'name'        => $s['title'],
        'description' => $s['lead'],
        'serviceType' => $s['title'],
        'provider'    => ['@id' => abs_url('/') . '#organization'],
        'areaServed'  => ['@type' => 'Country', 'name' => 'Türkiye'],
        'url'         => abs_url('/hizmetler/' . $s['slug']),
    ];
}

/** Makale düğümü. */
function schema_article(array $p): array
{
    return [
        '@type'            => 'Article',
        'headline'         => $p['title'],
        'description'      => $p['excerpt'],
        'datePublished'    => $p['date'],
        'dateModified'     => $p['date'],
        'author'           => ['@type' => 'Organization', 'name' => $p['author']],
        'publisher'        => ['@id' => abs_url('/') . '#organization'],
        'image'            => abs_url('/assets/img/' . $p['image'] . '-1200.jpg'),
        'mainEntityOfPage' => abs_url('/blog/' . $p['slug']),
        'articleSection'   => $p['category'],
        'inLanguage'       => 'tr-TR',
    ];
}

/** Toplanan bütün düğümleri tek bir @graph olarak basar. */
function seo_schema(array $page): void
{
    $graph = [schema_organization()];

    if ($bc = schema_breadcrumbs($page['breadcrumbs'] ?? [])) {
        $graph[] = $bc;
    }
    foreach (($page['schema'] ?? []) as $node) {
        if ($node) {
            $graph[] = $node;
        }
    }

    $json = json_encode(
        ['@context' => 'https://schema.org', '@graph' => $graph],
        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
    );
    echo '<script type="application/ld+json">' . $json . '</script>';
}
