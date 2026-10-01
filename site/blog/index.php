<?php
$page = ['path' => '/blog'];
require_once dirname(__DIR__) . '/inc/bootstrap.php';
$page['title']       = t('blog.title', 'Blog — Sera Yatırımı, Kurulum ve Sulama Rehberleri');
$page['desc']        = t('blog.desc', 'Sera kurulumu maliyetleri, sulama otomasyonu, fizibilite ve hibe süreçleri üzerine saha deneyiminden çıkmış rehberler.');
$page['breadcrumbs'] = [['name' => t('blog.crumb', 'Blog'), 'path' => '/blog']];
require_once APP_ROOT . '/inc/header.php';

$posts = get_posts();
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>"><?= e(t('home', 'Ana Sayfa')) ?></a><span>/</span><?= e(t('blog.crumb', 'Blog')) ?></p>
    <h1><?= e(t('blog.h1', 'Sera yatırımı rehberleri')) ?></h1>
    <p class="lede"><?= e(t('blog.lede', 'Maliyet, teknik seçim ve süreç konularında sahadan çıkmış yazılar. Amaç reklam değil; teklif toplarken doğru soruları sorabilmeniz.')) ?></p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="postlist">
      <?php foreach ($posts as $p): ?>
        <a class="post-card" href="<?= e(url('/blog/' . $p['slug'])) ?>">
          <div class="ph">
            <?= picture($p['image'], $p['title'], ['sizes' => '(max-width:900px) 92vw, 33vw']) ?>
          </div>
          <div class="post-body">
            <p class="post-meta"><b><?= e($p['category']) ?></b> <span><?= e(tr_date($p['date'])) ?></span></p>
            <h2><?= e($p['title']) ?></h2>
            <p><?= e(excerpt($p['excerpt'], 145)) ?></p>
            <span class="post-more"><?= e(t('blog.read', 'Yazıyı okuyun →')) ?></span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="band band-soft">
  <div class="wrap" style="text-align:center">
    <h2 style="font-size:var(--s-3);max-width:28ch;margin:0 auto"><?= e(t('blog.cta.h2', 'Yazıda cevabını bulamadığınız bir sorunuz mu var?')) ?></h2>
    <p class="lede" style="margin:16px auto 0"><?= e(t('blog.cta.p', 'Arazinizi anlatın, ilk değerlendirmeyi ücretsiz yapalım.')) ?></p>
    <p style="margin-top:28px"><a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>"><?= e(t('blog.cta.btn', 'Bize sorun')) ?></a></p>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
