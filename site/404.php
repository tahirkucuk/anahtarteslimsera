<?php
if (!defined('APP_ROOT')) {
    $page = [];
    require_once __DIR__ . '/inc/bootstrap.php';
}
http_response_code(404);
$page = array_merge($page, [
    'title'   => 'Sayfa bulunamadı',
    'desc'    => 'Aradığınız sayfa taşınmış veya kaldırılmış olabilir.',
    'path'    => '/404',
    'noindex' => true,
]);
require_once APP_ROOT . '/inc/header.php';
?>

<section class="band" style="padding-top:96px;padding-bottom:96px">
  <div class="wrap" style="max-width:680px;text-align:center">
    <p class="eyebrow" style="justify-content:center">Hata 404</p>
    <h1 style="font-size:var(--s-4)">Aradığınız sayfayı bulamadık.</h1>
    <p class="lede" style="margin:18px auto 0">
      Bağlantı eskimiş ya da adres yanlış yazılmış olabilir. Aşağıdaki sayfalardan devam edebilirsiniz.
    </p>
    <div class="hero-cta" style="justify-content:center;margin-top:30px">
      <a class="btn btn-primary" href="<?= e(url('/')) ?>">Ana sayfa</a>
      <a class="btn btn-ghost" href="<?= e(url('/hizmetler')) ?>">Hizmetler</a>
      <a class="btn btn-ghost" href="<?= e(url('/iletisim')) ?>">İletişim</a>
    </div>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
