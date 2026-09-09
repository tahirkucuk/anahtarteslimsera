<?php
/**
 * Hizmet sayfası şablonu.
 * Çağıran dosya $service_slug tanımlar, sonra burayı include eder.
 */
if (!defined('APP_ROOT')) { exit; }

$s = get_service($service_slug ?? '');
if (!$s) {
    http_response_code(404);
    require APP_ROOT . '/404.php';
    exit;
}
$partner = $s['partner'] ? PARTNERS[$s['partner']] : null;
$hue     = $partner['hue'] ?? 'canopy';

$page = array_merge($page, [
    'title'       => $s['meta_title'],
    'desc'        => $s['meta_desc'],
    'path'        => '/hizmetler/' . $s['slug'],
    'image'       => $s['image'],
    'breadcrumbs' => [
        ['name' => 'Hizmetler', 'path' => '/hizmetler'],
        ['name' => $s['title'], 'path' => '/hizmetler/' . $s['slug']],
    ],
    'schema'      => [schema_service($s)],
]);

require_once APP_ROOT . '/inc/header.php';
?>

<section class="pagehead" data-hue="<?= e($hue) ?>">
  <div class="wrap">
    <p class="crumbs">
      <a href="<?= e(url('/')) ?>">Ana Sayfa</a><span>/</span>
      <a href="<?= e(url('/hizmetler')) ?>">Hizmetler</a><span>/</span>
      <?= e($s['title']) ?>
    </p>
    <?php if ($partner): ?>
      <p class="disc-firm"><?= $partner['url'] ? '<a href="' . e($partner['url']) . '" target="_blank" rel="noopener">' . e($partner['name']) . '</a>' : e($partner['name']) ?> · <?= e($partner['role']) ?></p>
    <?php else: ?>
      <p class="disc-firm">Üç firma ortak · Entegre paket</p>
    <?php endif; ?>
    <h1><?= e($s['title']) ?></h1>
    <p class="lede"><?= e($s['lead']) ?></p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="grid-2" style="gap:40px;align-items:start">
      <div>
        <h2 style="font-size:var(--s-2);margin-bottom:20px">Kapsamımız</h2>
        <ul class="pkg-list" style="grid-template-columns:1fr;margin-top:0">
          <?php foreach ($s['bullets'] as $b): ?>
            <li style="font-size:15px"><?= e($b) ?></li>
          <?php endforeach; ?>
        </ul>

        <?php if ($s['slug'] === 'anahtar-teslim-sera'): ?>
          <p class="note">Entegre pakette teslim tarihi ve teknik performans üç firma tarafından birlikte taahhüt edilir; tek proje müdürü atanır.</p>
        <?php else: ?>
          <div class="pane next" style="margin-top:32px">
            <h3>Anahtar teslim projede</h3>
            <p style="margin-top:10px;color:var(--ink-2);font-size:15px">
              Bu hizmet, <a href="<?= e(url('/hizmetler/anahtar-teslim-sera')) ?>">anahtar teslim sera çözümünün</a>
              bir parçası olarak da alınabilir. O zaman kapsam, diğer iki disiplinle aynı teknik şartname
              ve aynı takvim üzerinden planlanır.
            </p>
          </div>
        <?php endif; ?>
      </div>

      <figure style="margin:0;border:1px solid var(--line);border-radius:3px;overflow:hidden;position:relative">
        <?= picture($s['image'], $s['title'], ['sizes' => '(max-width:900px) 92vw, 46vw']) ?>
        <?= placeholder_badge() ?>
      </figure>
    </div>
  </div>
</section>

<!-- SÜREÇTEKİ YERİ -->
<section class="band band-alt">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Süreçteki yeri</p>
      <h2>Bu iş projenin neresinde duruyor?</h2>
    </div>
    <div class="steps">
      <?php
      $ownerMatch = $partner['name'] ?? null;
      foreach (get_process() as $st):
          $mine = $ownerMatch && str_contains($st['owner'], explode(' ', $ownerMatch)[0]);
      ?>
        <div class="step" data-hue="<?= e($st['hue']) ?>" style="<?= $ownerMatch && !$mine ? 'opacity:.55' : '' ?>">
          <span class="step-no"><?= e($st['no']) ?></span>
          <div>
            <h3><?= e($st['title']) ?></h3>
            <p><?= e($st['body']) ?></p>
          </div>
          <div class="step-owner">
            <span class="tag"><?= e($st['owner']) ?></span>
            <span class="step-dur"><?= e($st['duration']) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- DİĞER HİZMETLER -->
<section class="band">
  <div class="wrap">
    <div class="shead"><p class="eyebrow">Diğer hizmetler</p><h2>Aynı çatı altındaki diğer kalemler</h2></div>
    <div class="grid-3">
      <?php foreach (get_services() as $o):
        if ($o['slug'] === $s['slug']) continue;
        $op = $o['partner'] ? PARTNERS[$o['partner']] : null; ?>
        <a class="single" href="<?= e(url('/hizmetler/' . $o['slug'])) ?>" data-hue="<?= e($op['hue'] ?? 'canopy') ?>">
          <p class="disc-firm"><?= e($op['name'] ?? 'Entegre paket') ?></p>
          <h4><?= e($o['title']) ?></h4>
          <p><?= e(excerpt($o['lead'], 110)) ?></p>
        </a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="band band-soft">
  <div class="wrap" style="text-align:center">
    <h2 style="font-size:var(--s-3);max-width:26ch;margin:0 auto">Arazinizi ve hedefinizi anlatın, kapsamı birlikte çıkaralım.</h2>
    <p style="margin-top:28px"><a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>">Teklif alın</a></p>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
