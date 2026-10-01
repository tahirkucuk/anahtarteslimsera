<?php
$page = ['path' => '/projeler', 'image' => 'sera-ic-mekan-domates'];
require_once __DIR__ . '/inc/bootstrap.php';
$page['title']       = t('projeler.title', 'Projeler ve Referanslar');
$page['desc']        = t('projeler.desc', 'Birlikte ve tekil olarak tamamlanan sera kurulumu, sulama ve danışmanlık projeleri. Konum, kapalı alan, sera tipi ve kapsam künyeleriyle.');
$page['breadcrumbs'] = [['name' => t('projeler.crumb', 'Projeler'), 'path' => '/projeler']];
require_once APP_ROOT . '/inc/header.php';

$projects = get_projects();
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>"><?= e(t('home', 'Ana Sayfa')) ?></a><span>/</span><?= e(t('projeler.crumb', 'Projeler')) ?></p>
    <h1><?= e(t('projeler.h1', 'Projeler ve referanslar')) ?></h1>
    <p class="lede"><?= e(t('projeler.lede', 'Üç firmanın birlikte tamamladığı entegre projeler ile tekil olarak yürütülen işler. Her künyede kapsamın hangi firmaları içerdiği belirtilir.')) ?></p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <?php if (IMAGES_ARE_PLACEHOLDER): ?>
      <div class="alert alert-err" style="border-color:var(--accent);color:var(--accent);background:var(--accent-soft)">
        <strong><?= e(t('projeler.wip', 'Bu bölüm yayına hazırlanıyor.')) ?></strong>
        <?= e(t('projeler.wip.p', 'Aşağıdaki kartlar yerleşim örnekleridir; gerçek proje künyeleri ve saha fotoğrafları yüklendiğinde değiştirilecektir.')) ?>
      </div>
    <?php endif; ?>

    <div class="projects">
      <?php foreach ($projects as $pr): ?>
        <article class="proj" data-hue="<?= e($pr['hue']) ?>">
          <div class="proj-photo">
            <?= picture($pr['image'], $pr['title'], ['sizes' => '(max-width:900px) 92vw, 33vw']) ?>
            <?= placeholder_badge() ?>
          </div>
          <div class="proj-body">
            <h2 style="font-size:var(--s-1);margin-bottom:14px"><?= e($pr['title']) ?></h2>
            <dl class="kunye">
              <?php foreach ($pr['meta'] as $k => $v): ?>
                <div><dt><?= e($k) ?></dt><dd><?= e($v) ?></dd></div>
              <?php endforeach; ?>
              <div><dt><?= e(t('projeler.scope', 'Kapsam')) ?></dt><dd><?= e($pr['scope']) ?></dd></div>
            </dl>
          </div>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="band band-alt">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow"><?= e(t('projeler.ref.eyebrow', 'Referans verirken')) ?></p>
      <h2><?= e(t('projeler.ref.h2', 'Bir projeyi değerlendirirken nelere bakılmalı?')) ?></h2>
      <p><?= e(t('projeler.ref.p', 'Fotoğraf güzel görünebilir; asıl bilgi künyededir. Teklif topladığınız her firmadan bu dört başlığı isteyin.')) ?></p>
    </div>
    <div class="grid-4">
      <?php if (LANG === 'en'):
        $ref_items = t_array('projeler.ref.items') ?: [];
        if (!$ref_items) { $ref_items = [
          ['h'=>'Enclosed area & type','p'=>'Enclosed area in decares, greenhouse type and gutter height. The solution changes with scale.'],
          ['h'=>'Delivery date','p'=>"The gap between contract date and actual delivery date shows a firm's schedule discipline."],
          ['h'=>'Scope boundary','p'=>'Which items were included, which left to the investor? An unclear boundary means an unclear cost.'],
          ['h'=>'First-season result','p'=>'A structure is built to produce, not just to stand. Ask for first-season yield data.'],
        ]; }
        foreach ($ref_items as $item): ?>
          <div class="pane">
            <h3 style="font-size:var(--s-0)"><?= e($item['h']) ?></h3>
            <p style="margin-top:8px;color:var(--ink-2);font-size:14.5px"><?= e($item['p']) ?></p>
          </div>
        <?php endforeach;
      else: ?>
        <div class="pane"><h3 style="font-size:var(--s-0)">Kapalı alan ve tip</h3><p style="margin-top:8px;color:var(--ink-2);font-size:14.5px">Dekar cinsinden kapalı alan, sera tipi ve oluk yüksekliği. Ölçek değişince çözüm de değişir.</p></div>
        <div class="pane"><h3 style="font-size:var(--s-0)">Teslim tarihi</h3><p style="margin-top:8px;color:var(--ink-2);font-size:14.5px">Sözleşme tarihi ile fiili teslim tarihi arasındaki fark, firmanın takvim disiplinini gösterir.</p></div>
        <div class="pane"><h3 style="font-size:var(--s-0)">Kapsam sınırı</h3><p style="margin-top:8px;color:var(--ink-2);font-size:14.5px">Hangi kalemler dahildi, hangileri yatırımcıya bırakıldı? Sınır belirsizse maliyet de belirsizdir.</p></div>
        <div class="pane"><h3 style="font-size:var(--s-0)">İlk sezon sonucu</h3><p style="margin-top:8px;color:var(--ink-2);font-size:14.5px">Yapı ayakta durmak için değil üretmek için kurulur. İlk sezon verimi sorulmalıdır.</p></div>
      <?php endif; ?>
    </div>
  </div>
</section>

<section class="band band-soft">
  <div class="wrap" style="text-align:center">
    <h2 style="font-size:var(--s-3);max-width:26ch;margin:0 auto"><?= e(t('projeler.cta.h2', 'Sıradaki proje sizinki olsun.')) ?></h2>
    <p style="margin-top:28px"><a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>"><?= e(t('projeler.cta.btn', 'Teklif alın')) ?></a></p>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
