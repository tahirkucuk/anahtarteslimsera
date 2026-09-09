<?php
require_once dirname(__DIR__) . '/inc/bootstrap.php';

$slug = preg_replace('/[^a-z0-9\-]/', '', (string) ($_GET['slug'] ?? ''));
$post = $slug !== '' ? get_post($slug) : null;

if (!$post) {
    http_response_code(404);
    require APP_ROOT . '/404.php';
    exit;
}

$page = array_merge($page, [
    'title'       => $post['meta_title'],
    'desc'        => $post['meta_desc'],
    'path'        => '/blog/' . $post['slug'],
    'image'       => $post['image'],
    'type'        => 'article',
    'breadcrumbs' => [
        ['name' => 'Blog', 'path' => '/blog'],
        ['name' => $post['title'], 'path' => '/blog/' . $post['slug']],
    ],
    'schema'      => [schema_article($post)],
]);

require_once APP_ROOT . '/inc/header.php';

$others = array_values(array_filter(get_posts(), fn($p) => $p['slug'] !== $post['slug']));
?>

<article>
  <section class="pagehead">
    <div class="wrap">
      <p class="crumbs">
        <a href="<?= e(url('/')) ?>">Ana Sayfa</a><span>/</span>
        <a href="<?= e(url('/blog')) ?>">Blog</a><span>/</span><?= e($post['category']) ?>
      </p>
      <h1><?= e($post['title']) ?></h1>
      <p class="post-meta" style="margin-top:18px">
        <b><?= e($post['category']) ?></b>
        <span><?= e(tr_date($post['date'])) ?></span>
        <span><?= e($post['author']) ?></span>
      </p>
    </div>
  </section>

  <section class="band">
    <div class="wrap">
      <div class="article">
        <figure class="article-hero">
          <?= picture($post['image'], $post['title'], ['sizes' => '(max-width:900px) 92vw, 70ch', 'loading' => 'eager']) ?>
          <?= placeholder_badge() ?>
        </figure>

        <div class="prose">
          <?= $post['body'] /* içerik dosyadan gelir, güvenilir kaynak */ ?>
        </div>

        <div class="article-cta">
          <h2>Bu konuyu kendi arazinizde konuşalım</h2>
          <p>Yazıdaki aralıklar genel değerlerdir. Sizin arazinizde neyin geçerli olduğunu keşif ve fizibilite aşaması söyler — ilk görüşme ücretsizdir.</p>
          <a class="btn btn-primary" href="<?= e(url('/iletisim')) ?>">Fizibilite görüşmesi talep edin</a>
        </div>
      </div>
    </div>
  </section>
</article>

<section class="band band-alt">
  <div class="wrap">
    <div class="shead"><p class="eyebrow">Devamı</p><h2>Diğer yazılar</h2></div>
    <div class="postlist">
      <?php foreach (array_slice($others, 0, 3) as $p): ?>
        <a class="post-card" href="<?= e(url('/blog/' . $p['slug'])) ?>">
          <div class="ph"><?= picture($p['image'], $p['title'], ['sizes' => '(max-width:900px) 92vw, 33vw']) ?></div>
          <div class="post-body">
            <p class="post-meta"><b><?= e($p['category']) ?></b> <span><?= e(tr_date($p['date'])) ?></span></p>
            <h3><?= e($p['title']) ?></h3>
            <p><?= e(excerpt($p['excerpt'], 120)) ?></p>
            <span class="post-more">Yazıyı okuyun →</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
