<?php
$page = [
    'title'       => 'Süreç — Sera Projesi Nasıl İlerliyor?',
    'desc'        => 'Keşif ve fizibiliteden devreye almaya kadar beş aşama, aşama süreleri ve hangi firmanın neyi taahhüt ettiği. 20 dekarlık örnek proje takvimi.',
    'path'        => '/surec',
    'image'       => 'celik-konstruksiyon-montaj',
    'breadcrumbs' => [['name' => 'Süreç', 'path' => '/surec']],
];
require_once __DIR__ . '/inc/bootstrap.php';

$page['schema'][] = [
    '@type' => 'HowTo',
    'name'  => 'Anahtar teslim sera projesi nasıl ilerler?',
    'description' => 'Keşif ve fizibiliteden devreye almaya kadar sera kurulum sürecinin beş aşaması.',
    'totalTime' => 'P9M',
    'step' => array_map(fn($s) => [
        '@type' => 'HowToStep',
        'name'  => $s['title'],
        'text'  => $s['body'],
    ], get_process()),
];

require_once APP_ROOT . '/inc/header.php';
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>">Ana Sayfa</a><span>/</span>Süreç</p>
    <h1>Sera hayalinizi nasıl gerçeğe dönüştürüyoruz?</h1>
    <p class="lede">Adımlar sıralıdır: her aşamanın çıktısı bir sonrakinin girdisidir. Aşağıdaki süreler ortalama 20 dekarlık bir projeye göre verilmiştir; ölçek ve zemin koşullarına göre değişir.</p>
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
      <h3>Kritik çakışma: 3. ve 4. aşama</h3>
      <p style="margin-top:10px;color:var(--ink-2);font-size:15px">
        Ayrı firmalarla çalışıldığında sulama, konstrüksiyon tamamen bittikten sonra başlar ve hazır yapıya
        uydurulmaya çalışılır. Entegre projede sulama güzergâhları, askı noktaları ve geçiş kanalları
        çelik montajı sürerken hazır bırakılır. Pratikte kazanılan süre 3 – 6 haftadır ve doğrudan
        ilk hasat tarihine yansır.
      </p>
    </div>
  </div>
</section>

<section class="photoband quoteband">
  <?= picture('celik-konstruksiyon-montaj', 'Sera çelik konstrüksiyon montaj sahası', ['sizes' => '100vw']) ?>
  <?= placeholder_badge() ?>
  <div class="wrap">
    <p class="eyebrow">Sahada</p>
    <h2>Takvimi tutan şey planlama değil, koordinasyondur.</h2>
    <p>Üç ekip aynı sahada çalışırken kritik yol konstrüksiyondadır. Bu yüzden montaj programı ana takvimi belirler; sulama ve otomasyon ekipleri bu programa göre yerleşir.</p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Teslimde alacağınız belgeler</p>
      <h2>Proje bittiğinde elinizde ne olur?</h2>
    </div>
    <div class="grid-3">
      <div class="pane">
        <h3>Teknik dosya</h3>
        <ul>
          <li>Uygulama projeleri ve statik hesap raporu</li>
          <li>Sulama ve fertigasyon şeması</li>
          <li>Ekipman listesi ve marka/model künyesi</li>
          <li>Test ve devreye alma tutanakları</li>
        </ul>
      </div>
      <div class="pane">
        <h3>İşletme dosyası</h3>
        <ul>
          <li>Kullanım ve bakım kılavuzu</li>
          <li>Dikim planı ve besleme programı</li>
          <li>Sulama zamanlama şablonları</li>
          <li>Personel eğitimi kayıtları</li>
        </ul>
      </div>
      <div class="pane">
        <h3>Ticari dosya</h3>
        <ul>
          <li>Kalem bazlı garanti belgeleri</li>
          <li>Servis müdahale süreleri</li>
          <li>Yedek parça listesi</li>
          <li>İlk sezon takip planı</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<section class="band band-soft">
  <div class="wrap" style="text-align:center">
    <h2 style="font-size:var(--s-3);max-width:26ch;margin:0 auto">Birinci aşamadan başlayalım: keşif ve fizibilite.</h2>
    <p class="lede" style="margin:16px auto 0">İlk görüşme ücretsizdir ve arazi verilerinizin ön değerlendirmesini kapsar.</p>
    <p style="margin-top:28px"><a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>">Görüşme talep edin</a></p>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
