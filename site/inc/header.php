<?php if (!defined('APP_ROOT')) { exit; } ?>
<!doctype html>
<html lang="tr">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="theme-color" content="#0F4436" media="(prefers-color-scheme: light)">
<meta name="theme-color" content="#06100D" media="(prefers-color-scheme: dark)">
<?php seo_meta($page); ?>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Archivo:wght@400;500;600;700&family=IBM+Plex+Mono:wght@400;500&family=Source+Serif+4:opsz,wght@8..60,400;8..60,600&display=swap">
<link rel="stylesheet" href="<?= e(asset('css/site.css')) ?>">

<link rel="icon" href="<?= e(url('/favicon.svg')) ?>" type="image/svg+xml">
<link rel="apple-touch-icon" href="<?= e(url('/assets/img/og-anahtar-teslim-sera.jpg')) ?>">
<link rel="sitemap" type="application/xml" href="<?= e(url('/sitemap.xml')) ?>">

<?php seo_schema($page); ?>

<?php if (GA4_ID !== ''): ?>
<script async src="https://www.googletagmanager.com/gtag/js?id=<?= e(GA4_ID) ?>"></script>
<script>
window.dataLayer=window.dataLayer||[];function gtag(){dataLayer.push(arguments)}
gtag('js',new Date());gtag('config','<?= e(GA4_ID) ?>');
</script>
<?php endif; ?>
</head>
<body class="<?= e($page['body_class']) ?>">

<a class="skip" href="#icerik">İçeriğe geç</a>

<header class="site-head">
  <div class="wrap head-inner">
    <a class="brand" href="<?= e(url('/')) ?>">
      <img class="brand-mark" src="<?= e(url('/favicon.svg')) ?>" alt="" width="34" height="34" aria-hidden="true">
      <span class="brand-text">
        <span class="brand-name">ANAHTAR TESLİM SERA</span>
        <span class="brand-tag">Entegre Tarım Çözümleri</span>
      </span>
    </a>

    <button class="nav-toggle" type="button" aria-expanded="false" aria-controls="ana-menu" aria-label="Menüyü aç">
      <span></span><span></span><span></span>
    </button>

    <nav id="ana-menu" class="nav" aria-label="Ana menü">
      <ul>
        <li class="has-sub">
          <a href="<?= e(url('/hizmetler')) ?>"<?= nav_active('/hizmetler') ?>>Hizmetler</a>
          <ul class="sub">
            <?php foreach (get_services() as $s): ?>
              <li><a href="<?= e(url('/hizmetler/' . $s['slug'])) ?>"><?= e($s['title']) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </li>
        <li><a href="<?= e(url('/surec')) ?>"<?= nav_active('/surec') ?>>Süreç</a></li>
        <li><a href="<?= e(url('/projeler')) ?>"<?= nav_active('/projeler') ?>>Projeler</a></li>
        <li><a href="<?= e(url('/blog')) ?>"<?= nav_active('/blog') ?>>Blog</a></li>
        <li><a href="<?= e(url('/iletisim')) ?>"<?= nav_active('/iletisim') ?>>İletişim</a></li>
      </ul>
      <a class="btn btn-primary nav-cta" href="<?= e(url('/iletisim')) ?>">Teklif Al</a>
    </nav>
  </div>
</header>

<main id="icerik">
