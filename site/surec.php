<?php
$page = ['path' => '/surec', 'image' => 'celik-konstruksiyon-montaj'];
require_once __DIR__ . '/inc/bootstrap.php';
$page['title']       = t('surec.title', 'Süreç — Sera Projesi Nasıl İlerliyor?');
$page['desc']        = t('surec.desc', 'Keşif ve fizibiliteden devreye almaya kadar beş aşama, aşama süreleri ve hangi firmanın neyi taahhüt ettiği. 20 dekarlık örnek proje takvimi.');
$page['breadcrumbs'] = [['name' => t('surec.crumb', 'Süreç'), 'path' => '/surec']];

$page['schema'][] = [
    '@type'       => 'HowTo',
    'name'        => LANG === 'en' ? 'How does a turnkey greenhouse project progress?' : 'Anahtar teslim sera projesi nasıl ilerler?',
    'description' => LANG === 'en' ? 'Five phases of the greenhouse construction process from discovery and feasibility to commissioning.' : 'Keşif ve fizibiliteden devreye almaya kadar sera kurulum sürecinin beş aşaması.',
    'totalTime'   => 'P9M',
    'step'        => array_map(fn($s) => [
        '@type' => 'HowToStep',
        'name'  => $s['title'],
        'text'  => $s['body'],
    ], get_process()),
];

require_once APP_ROOT . '/inc/header.php';
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>"><?= e(t('home', 'Ana Sayfa')) ?></a><span>/</span><?= e(t('surec.crumb', 'Süreç')) ?></p>
    <h1><?= e(t('surec.h1', 'Sera hayalinizi nasıl gerçeğe dönüştürüyoruz?')) ?></h1>
    <p class="lede"><?= e(t('surec.lede', 'Adımlar sıralıdır: her aşamanın çıktısı bir sonrakinin girdisidir. Aşağıdaki süreler ortalama 20 dekarlık bir projeye göre verilmiştir; ölçek ve zemin koşullarına göre değişir.')) ?></p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="steps">
      <?php foreach (get_process() as $st): ?>
        <div class="step" data-hue="<?= e($st['hue']) ?>">
          <span class="step-no"><?= e($st['no']) ?></span>
          <div>
            <h2 style="font-size:var(--s-1);margin-bottom:7px"><?= e($st['title']) ?></h2>
            <p><?= e($st['body']) ?></p>
          </div>
          <div class="step-owner">
            <span class="tag"><?= e($st['owner']) ?></span>
            <span class="step-dur"><?= e($st['duration']) ?></span>
          </div>
        </div>
      <?php endforeach; ?>
    </div>

    <div class="pane next" style="margin-top:40px;max-width:74ch">
      <h3><?= e(t('surec.overlap.h3', 'Kritik çakışma: 3. ve 4. aşama')) ?></h3>
      <p style="margin-top:10px;color:var(--ink-2);font-size:15px">
        <?= e(t('surec.overlap.p', 'Ayrı firmalarla çalışıldığında sulama, konstrüksiyon tamamen bittikten sonra başlar ve hazır yapıya uydurulmaya çalışılır. Entegre projede sulama güzergâhları, askı noktaları ve geçiş kanalları çelik montajı sürerken hazır bırakılır. Pratikte kazanılan süre 3 – 6 haftadır ve doğrudan ilk hasat tarihine yansır.')) ?>
      </p>
    </div>
  </div>
</section>

<section class="photoband quoteband">
  <?= picture('celik-konstruksiyon-montaj', LANG === 'en' ? 'Greenhouse steel structure installation site' : 'Sera çelik konstrüksiyon montaj sahası', ['sizes' => '100vw']) ?>
  <?= placeholder_badge() ?>
  <div class="wrap">
    <p class="eyebrow"><?= e(t('surec.photo.eyebrow', 'Sahada')) ?></p>
    <h2><?= e(t('surec.photo.h2', 'Takvimi tutan şey planlama değil, koordinasyondur.')) ?></h2>
    <p><?= e(t('surec.photo.p', 'Üç ekip aynı sahada çalışırken kritik yol konstrüksiyondadır. Bu yüzden montaj programı ana takvimi belirler; sulama ve otomasyon ekipleri bu programa göre yerleşir.')) ?></p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow"><?= e(t('surec.docs.eyebrow', 'Teslimde alacağınız belgeler')) ?></p>
      <h2><?= e(t('surec.docs.h2', 'Proje bittiğinde elinizde ne olur?')) ?></h2>
    </div>
    <div class="grid-3">
      <div class="pane">
        <h3><?= e(t('surec.docs.tech.h3', 'Teknik dosya')) ?></h3>
        <ul>
          <?php
          $tech_items = t_array('surec.docs.tech.li') ?: ['Uygulama projeleri ve statik hesap raporu', 'Sulama ve fertigasyon şeması', 'Ekipman listesi ve marka/model künyesi', 'Test ve devreye alma tutanakları'];
          foreach ($tech_items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
        </ul>
      </div>
      <div class="pane">
        <h3><?= e(t('surec.docs.ops.h3', 'İşletme dosyası')) ?></h3>
        <ul>
          <?php
          $ops_items = t_array('surec.docs.ops.li') ?: ['Kullanım ve bakım kılavuzu', 'Dikim planı ve besleme programı', 'Sulama zamanlama şablonları', 'Personel eğitimi kayıtları'];
          foreach ($ops_items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
        </ul>
      </div>
      <div class="pane">
        <h3><?= e(t('surec.docs.comm.h3', 'Ticari dosya')) ?></h3>
        <ul>
          <?php
          $comm_items = t_array('surec.docs.comm.li') ?: ['Kalem bazlı garanti belgeleri', 'Servis müdahale süreleri', 'Yedek parça listesi', 'İlk sezon takip planı'];
          foreach ($comm_items as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="band band-soft">
  <div class="wrap" style="text-align:center">
    <h2 style="font-size:var(--s-3);max-width:26ch;margin:0 auto"><?= e(t('surec.cta.h2', 'Birinci aşamadan başlayalım: keşif ve fizibilite.')) ?></h2>
    <p class="lede" style="margin:16px auto 0"><?= e(t('surec.cta.p', 'İlk görüşme ücretsizdir ve arazi verilerinizin ön değerlendirmesini kapsar.')) ?></p>
    <p style="margin-top:28px"><a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>"><?= e(t('surec.cta.btn', 'Görüşme talep edin')) ?></a></p>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
