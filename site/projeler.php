<?php
$page = [
    'title'       => 'Projeler ve Referanslar',
    'desc'        => 'Birlikte ve tekil olarak tamamlanan sera kurulumu, sulama ve danışmanlık projeleri. Konum, kapalı alan, sera tipi ve kapsam künyeleriyle.',
    'path'        => '/projeler',
    'image'       => 'sera-ic-mekan-domates',
    'breadcrumbs' => [['name' => 'Projeler', 'path' => '/projeler']],
];
require_once __DIR__ . '/inc/bootstrap.php';
require_once APP_ROOT . '/inc/header.php';

$projects = get_projects();
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>">Ana Sayfa</a><span>/</span>Projeler</p>
    <h1>Projeler ve referanslar</h1>
    <p class="lede">Üç firmanın birlikte tamamladığı entegre projeler ile tekil olarak yürütülen işler. Her künyede kapsamın hangi firmaları içerdiği belirtilir.</p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <?php if (IMAGES_ARE_PLACEHOLDER): ?>
      <div class="alert alert-err" style="border-color:var(--accent);color:var(--accent);background:var(--accent-soft)">
        <strong>Bu bölüm yayına hazırlanıyor.</strong>
        Aşağıdaki kartlar yerleşim örnekleridir; gerçek proje künyeleri ve saha fotoğrafları yüklendiğinde değiştirilecektir.
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
              <div><dt>Kapsam</dt><dd><?= e($pr['scope']) ?></dd></div>
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
      <p class="eyebrow">Referans verirken</p>
      <h2>Bir projeyi değerlendirirken nelere bakılmalı?</h2>
      <p>Fotoğraf güzel görünebilir; asıl bilgi künyededir. Teklif topladığınız her firmadan bu dört başlığı isteyin.</p>
    </div>
    <div class="grid-4">
      <div class="pane">
        <h3 style="font-size:var(--s-0)">Kapalı alan ve tip</h3>
        <p style="margin-top:8px;color:var(--ink-2);font-size:14.5px">Dekar cinsinden kapalı alan, sera tipi ve oluk yüksekliği. Ölçek değişince çözüm de değişir.</p>
      </div>
      <div class="pane">
        <h3 style="font-size:var(--s-0)">Teslim tarihi</h3>
        <p style="margin-top:8px;color:var(--ink-2);font-size:14.5px">Sözleşme tarihi ile fiili teslim tarihi arasındaki fark, firmanın takvim disiplinini gösterir.</p>
      </div>
      <div class="pane">
        <h3 style="font-size:var(--s-0)">Kapsam sınırı</h3>
        <p style="margin-top:8px;color:var(--ink-2);font-size:14.5px">Hangi kalemler dahildi, hangileri yatırımcıya bırakıldı? Sınır belirsizse maliyet de belirsizdir.</p>
      </div>
      <div class="pane">
        <h3 style="font-size:var(--s-0)">İlk sezon sonucu</h3>
        <p style="margin-top:8px;color:var(--ink-2);font-size:14.5px">Yapı ayakta durmak için değil üretmek için kurulur. İlk sezon verimi sorulmalıdır.</p>
      </div>
    </div>
  </div>
</section>

<section class="band band-soft">
  <div class="wrap" style="text-align:center">
    <h2 style="font-size:var(--s-3);max-width:26ch;margin:0 auto">Sıradaki proje sizinki olsun.</h2>
    <p style="margin-top:28px"><a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>">Teklif alın</a></p>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
