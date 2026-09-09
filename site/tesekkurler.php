<?php
$page = [
    'title'   => 'Talebiniz alındı',
    'desc'    => 'Teklif talebiniz proje ekibine iletildi.',
    'path'    => '/tesekkurler',
    'noindex' => true,
];
require_once __DIR__ . '/inc/bootstrap.php';
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$lead_id = $_SESSION['lead_id'] ?? null;
unset($_SESSION['lead_id']);

require_once APP_ROOT . '/inc/header.php';
?>

<section class="band" style="padding-top:88px">
  <div class="wrap" style="max-width:760px;text-align:center">
    <p class="eyebrow" style="justify-content:center">Talebiniz alındı</p>
    <h1 style="font-size:var(--s-4)">Teşekkürler. Talebiniz proje ekibine iletildi.</h1>
    <p class="lede" style="margin:20px auto 0">
      Bir iş günü içinde size dönüş yapacağız. Acil bir durumda doğrudan arayabilirsiniz —
      hangi kapsam olursa olsun muhatabınız aynı numaradır.
    </p>

    <?php if ($lead_id): ?>
      <p class="note">Talep numaranız: <strong><?= e($lead_id) ?></strong></p>
    <?php endif; ?>

    <div class="hero-cta" style="justify-content:center;margin-top:32px">
      <a class="btn btn-primary btn-lg" href="tel:<?= e(str_replace(' ', '', CONTACT_PHONE)) ?>"><?= e(CONTACT_PHONE_DISPLAY) ?></a>
      <a class="btn btn-ghost btn-lg" href="<?= e(url('/blog')) ?>">Rehberleri okuyun</a>
    </div>
  </div>
</section>

<section class="band band-alt">
  <div class="wrap">
    <div class="shead" style="text-align:center;margin:0 auto 34px">
      <h2 style="font-size:var(--s-2)">Görüşmeye kadar okumaya değer</h2>
    </div>
    <div class="postlist">
      <?php foreach (get_posts(3) as $p): ?>
        <a class="post-card" href="<?= e(url('/blog/' . $p['slug'])) ?>">
          <div class="ph"><?= picture($p['image'], $p['title'], ['sizes' => '(max-width:900px) 92vw, 33vw']) ?></div>
          <div class="post-body">
            <p class="post-meta"><b><?= e($p['category']) ?></b></p>
            <h3><?= e($p['title']) ?></h3>
            <span class="post-more">Yazıyı okuyun →</span>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
