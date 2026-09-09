<?php
$page = [
    'title'       => 'Hizmetler — Sera Kurulumu, Sulama ve Tarımsal Danışmanlık',
    'desc'        => 'Anahtar teslim sera çözümü, tarımsal danışmanlık, sera kurulumu ve sulama sistemleri. Entegre paket olarak ya da tek tek alınabilir.',
    'path'        => '/hizmetler',
    'breadcrumbs' => [['name' => 'Hizmetler', 'path' => '/hizmetler']],
];
require_once dirname(__DIR__) . '/inc/bootstrap.php';

foreach (get_services() as $s) {
    $page['schema'][] = schema_service($s);
}
require_once APP_ROOT . '/inc/header.php';
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>">Ana Sayfa</a><span>/</span>Hizmetler</p>
    <h1>Hizmetler</h1>
    <p class="lede">Üç disiplin, tek proje yönetimi. Anahtar teslim paketi bir bütün olarak alabilir ya da yalnızca ihtiyacınız olan kalemi seçebilirsiniz.</p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <?php $svc = get_services(); $ats = $svc['anahtar-teslim-sera']; ?>
    <div class="pkg">
      <div class="pkg-main">
        <p class="eyebrow" style="margin-bottom:10px">Entegre paket</p>
        <h3><?= e($ats['title']) ?></h3>
        <p style="margin-top:12px;color:var(--ink-2);max-width:58ch"><?= e($ats['lead']) ?></p>
        <ul class="pkg-list">
          <?php foreach ($ats['bullets'] as $b): ?><li><?= e($b) ?></li><?php endforeach; ?>
        </ul>
        <p style="margin-top:26px"><a class="btn btn-primary" href="<?= e(url('/hizmetler/anahtar-teslim-sera')) ?>">Paketi inceleyin</a></p>
      </div>
      <figure style="margin:0;border:1px solid var(--line);border-radius:3px;overflow:hidden;position:relative">
        <?= picture('sera-ic-mekan-domates', 'Modern serada sıralı domates üretimi ve damla sulama hatları', ['sizes' => '(max-width:900px) 92vw, 40vw']) ?>
        <?= placeholder_badge() ?>
      </figure>
    </div>
  </div>
</section>

<section class="band band-alt">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Tekil hizmetler</p>
      <h2>Her firma kendi alanında bağımsız da çalışır.</h2>
      <p>Mevcut seranıza sulama otomasyonu kurulması, projesi hazır bir yatırımın montajı veya yalnızca fizibilite hizmeti — hepsi aynı iletişim kanalından.</p>
    </div>

    <div class="discs">
      <?php foreach (['tarimsal-danismanlik','sera-kurulumu','sulama-sistemleri'] as $slug):
        $s = $svc[$slug]; $p = PARTNERS[$s['partner']]; ?>
        <article class="disc" data-hue="<?= e($p['hue']) ?>">
          <div class="disc-photo">
            <?= picture($s['image'], $s['title'], ['sizes' => '(max-width:900px) 92vw, 33vw']) ?>
          </div>
          <p class="disc-firm"><?= $p['url'] ? '<a href="' . e($p['url']) . '" target="_blank" rel="noopener">' . e($p['name']) . '</a>' : e($p['name']) ?></p>
          <h3><?= e($s['title']) ?></h3>
          <p><?= e(excerpt($s['lead'], 140)) ?></p>
          <ul>
            <?php foreach ($s['bullets'] as $b): ?><li><?= e($b) ?></li><?php endforeach; ?>
          </ul>
          <a class="disc-more" href="<?= e(url('/hizmetler/' . $s['slug'])) ?>">Ayrıntılar →</a>
        </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Teknik karar</p>
      <h2>Hangi sera tipi? Kararı ürün ve iklim verir, bütçe değil.</h2>
      <p>Aşağıdaki aralıklar yaygın uygulamalar için tipik değerlerdir. Kesin değerler arazinin kar ve rüzgâr yüküne, sulama suyu kalitesine ve hedef ürüne göre projede belirlenir.</p>
    </div>

    <div class="tablewrap">
      <table>
        <thead>
          <tr>
            <th scope="col">Sera tipi</th>
            <th scope="col">Işık geçirgenliği</th>
            <th scope="col">Oluk yüksekliği</th>
            <th scope="col">Kar yükü kapasitesi</th>
            <th scope="col">Öne çıkan ürünler</th>
            <th scope="col">Yatırım seviyesi</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach (get_types() as $t): ?>
            <tr>
              <th scope="row"><?= e($t['name']) ?></th>
              <td class="num"><?= e($t['light']) ?></td>
              <td class="num"><?= e($t['gutter']) ?></td>
              <td class="num"><?= e($t['snow']) ?></td>
              <td><?= e($t['crops']) ?></td>
              <td><span class="tag" style="color:var(--accent)"><?= e($t['level']) ?></span></td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
    <p class="note">Her üç tipte de sulama, fertigasyon ve iklim otomasyonu aynı entegre şartname içinde projelendirilir.</p>
  </div>
</section>

<section class="band band-soft">
  <div class="wrap" style="text-align:center">
    <h2 style="font-size:var(--s-3);max-width:26ch;margin:0 auto">Hangi kapsam size uygun, birlikte belirleyelim.</h2>
    <p style="margin-top:28px"><a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>">Teklif alın</a></p>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
