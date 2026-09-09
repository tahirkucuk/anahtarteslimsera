<?php
$page = [
    'title' => 'Anahtar Teslim Sera Kurulumu',
    'desc'  => 'Tarımsal danışmanlık, sera kurulumu ve sulama sistemleri tek proje yönetimi altında. Fizibiliteden ilk hasada kadar anahtar teslim sera kurulumu — tek takvim, tek şartname, tek muhatap.',
    'path'  => '/',
];
require_once __DIR__ . '/inc/bootstrap.php';

$services = get_services();
$page['schema'][] = schema_faq(get_faqs());
foreach ($services as $s) {
    $page['schema'][] = schema_service($s);
}

require_once APP_ROOT . '/inc/header.php';
?>

<!-- HERO -->
<section class="photoband hero">
  <?= picture('sera-kompleksi-havadan', 'Akdeniz vadisinde modern sera kompleksinin havadan görünümü', [
        'sizes' => '100vw', 'loading' => 'eager', 'fetchpriority' => 'high']) ?>
  <?= placeholder_badge() ?>
  <div class="wrap">
    <div class="hero-partners">
      <?php foreach (PARTNERS as $p): ?>
        <span class="tag"><?= e($p['name']) ?></span>
      <?php endforeach; ?>
    </div>
    <h1>Sera yatırımınız tek takvimde, tek muhatapla teslim edilir.</h1>
    <p class="lede">Tarımsal danışmanlık, sera kurulumu ve sulama sistemleri üç ayrı firmadan değil, tek çatı altından. Fizibiliteden ilk hasada kadar anahtar teslim sera kurulumu — tek proje müdürü, tek şartname, tek servis hattı.</p>
    <div class="hero-cta">
      <a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>">Ücretsiz fizibilite görüşmesi</a>
      <a class="btn btn-ghost btn-lg" href="<?= e(url('/surec')) ?>">Süreci inceleyin</a>
    </div>
  </div>
</section>

<section class="band-sm" style="padding-top:0">
  <div class="wrap">
    <dl class="specstrip">
      <div><dt>Sera tipleri</dt><dd>Venlo cam · Polikarbon · Plastik tünel</dd></div>
      <div><dt>Proje ölçeği</dt><dd>2 – 250 dekar kapalı alan</dd></div>
      <div><dt>Teslim süresi</dt><dd>Ortalama 5 – 9 ay</dd></div>
      <div><dt>Kapsam</dt><dd>Etüt → Kurulum → Devreye alma</dd></div>
    </dl>
  </div>
</section>

<!-- NEDEN TEK ÇATI -->
<section class="band">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Neden tek çatı</p>
      <h2>Sera projelerinin çoğu inşaatta değil, firmalar arasındaki boşlukta gecikir.</h2>
      <p>Danışman ürün planını çıkarır, konstrüksiyon firması onu görmeden çelik keser, sulamacı en son gelip hazır yapıya sistem uydurmaya çalışır. Aynı projeyi üç firma birlikte kurguladığında bu boşluk kapanır.</p>
    </div>

    <div class="grid-2">
      <div class="pane now">
        <h3>Ayrı ayrı çalışıldığında</h3>
        <ul>
          <li>Üç ayrı sözleşme, üç ayrı takvim, üç ayrı ödeme planı</li>
          <li>Sulama ve fertigasyon, konstrüksiyon bittikten sonra mevcut yapıya uydurulur</li>
          <li>Bir sorun çıktığında sorumluluk firmalar arasında dolaşır</li>
          <li>Danışmanın verim hedefi, kurulan yapının kapasitesiyle tutmaz</li>
          <li>Hibe dosyasındaki teknik veriler birbirini doğrulamaz</li>
        </ul>
      </div>
      <div class="pane next">
        <h3>Anahtar Teslim Sera ile</h3>
        <ul>
          <li>Tek takvim, tek proje müdürü, tek teknik şartname</li>
          <li>Sulama, iklimlendirme ve gübreleme, konstrüksiyonla birlikte tasarlanır</li>
          <li>Tek servis hattı — sorumluluk aramakla vakit kaybetmezsiniz</li>
          <li>Ürün planı, sera tipini ve sulama debisini baştan belirler</li>
          <li>Hibe dosyası tek şartnameden üretilir, çelişki çıkmaz</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- ÜÇ DİSİPLİN -->
<section class="band band-alt">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Çözüm ortakları</p>
      <h2>Üç uzmanlık alanı, tek proje ekibi.</h2>
      <p>Her firma kendi alanında bağımsız olarak da hizmet verir. Anahtar teslim projede üçü aynı şartname ve aynı takvim üzerinde çalışır.</p>
    </div>

    <div class="discs">
      <?php
      $home_discs = [
        ['slug'=>'tarimsal-danismanlik','stat'=>'Etüt süresi <b>2 – 4 hafta</b>','n'=>4],
        ['slug'=>'sera-kurulumu','stat'=>'Oluk yüksekliği <b>4,0 – 6,5 m</b>','n'=>4],
        ['slug'=>'sulama-sistemleri','stat'=>'Damlatıcı debisi <b>1,6 – 4,0 l/saat</b>','n'=>4],
      ];
      foreach ($home_discs as $d):
        $s = $services[$d['slug']];
        $p = PARTNERS[$s['partner']];
      ?>
      <article class="disc" data-hue="<?= e($p['hue']) ?>">
        <div class="disc-photo">
          <?= picture($s['image'], $s['title'] . ' — ' . $p['name'], ['sizes' => '(max-width:900px) 92vw, 33vw']) ?>
        </div>
        <p class="disc-firm"><?= e($p['name']) ?></p>
        <h3><?= e($s['title']) ?></h3>
        <p><?= e(excerpt($s['lead'], 130)) ?></p>
        <ul>
          <?php foreach (array_slice($s['bullets'], 0, $d['n']) as $b): ?>
            <li><?= e($b) ?></li>
          <?php endforeach; ?>
        </ul>
        <p class="disc-stat"><?= $d['stat'] ?></p>
        <a class="disc-more" href="<?= e(url('/hizmetler/' . $s['slug'])) ?>">Ayrıntılar →</a>
      </article>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PAKET -->
<section class="band">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Hizmet paketleri</p>
      <h2>Anahtar teslim sera çözümü — ya da yalnızca ihtiyacınız olan bölüm.</h2>
    </div>

    <div class="pkg">
      <div class="pkg-main">
        <p class="eyebrow" style="margin-bottom:10px">Entegre paket</p>
        <h3><?= e($services['anahtar-teslim-sera']['title']) ?></h3>
        <p style="margin-top:12px;color:var(--ink-2);max-width:58ch"><?= e($services['anahtar-teslim-sera']['lead']) ?></p>
        <ul class="pkg-list">
          <?php foreach ($services['anahtar-teslim-sera']['bullets'] as $b): ?>
            <li><?= e($b) ?></li>
          <?php endforeach; ?>
        </ul>
        <p style="margin-top:26px">
          <a class="btn btn-primary" href="<?= e(url('/hizmetler/anahtar-teslim-sera')) ?>">Paketi inceleyin</a>
        </p>
      </div>

      <div class="pkg-side">
        <?php foreach (['tarimsal-danismanlik','sera-kurulumu','sulama-sistemleri'] as $slug):
          $s = $services[$slug]; $p = PARTNERS[$s['partner']]; ?>
          <a class="single" href="<?= e(url('/hizmetler/' . $slug)) ?>" data-hue="<?= e($p['hue']) ?>">
            <p class="disc-firm"><?= e($p['name']) ?></p>
            <h4>Yalnızca <?= e(mb_strtolower($s['title'], 'UTF-8')) ?></h4>
            <p><?= e($p['short']) ?></p>
          </a>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- ALINTI BANDI -->
<section class="photoband quoteband">
  <?= picture('sera-alacakaranlik', 'Alacakaranlıkta içeriden aydınlanan cam sera', ['sizes' => '100vw']) ?>
  <?= placeholder_badge() ?>
  <div class="wrap">
    <p class="eyebrow">Neden biz</p>
    <h2>Fiyatla değil, tek muhatapla yarışıyoruz.</h2>
    <p>Sera pazarında herkes metrekare fiyatı verir. Danışmanlık, kurulum ve sulamanın tek proje yönetiminde toplanması ise kopyalanması en zor farktır — çünkü rakibin önce ortaklık kurması gerekir.</p>
  </div>
</section>

<!-- SÜREÇ ÖZET -->
<section class="band band-alt">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Süreç</p>
      <h2>Sera hayalinizi nasıl gerçeğe dönüştürüyoruz?</h2>
      <p>Adımlar sıralıdır: her aşamanın çıktısı bir sonrakinin girdisidir. Süreler ortalama 20 dekarlık bir projeye göre verilmiştir.</p>
    </div>

    <div class="steps">
      <?php foreach (array_slice(get_process(), 0, 3) as $st): ?>
        <div class="step" data-hue="<?= e($st['hue']) ?>">
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

    <p style="margin-top:28px">
      <a class="btn btn-ghost" href="<?= e(url('/surec')) ?>">Beş aşamanın tamamı →</a>
    </p>
  </div>
</section>

<!-- PROJELER -->
<section class="band">
  <div class="wrap">
    <div class="shead">
      <p class="eyebrow">Projeler</p>
      <h2>Birlikte ve tekil olarak tamamlanan işler.</h2>
    </div>
    <div class="projects">
      <?php foreach (get_projects(3) as $pr): ?>
        <article class="proj" data-hue="<?= e($pr['hue']) ?>">
          <div class="proj-photo">
            <?= picture($pr['image'], $pr['title'], ['sizes' => '(max-width:900px) 92vw, 33vw']) ?>
            <?= placeholder_badge() ?>
          </div>
          <div class="proj-body">
            <h3><?= e($pr['title']) ?></h3>
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
    <p style="margin-top:28px"><a class="btn btn-ghost" href="<?= e(url('/projeler')) ?>">Tüm projeler →</a></p>
  </div>
</section>

<!-- SSS -->
<section class="band band-alt">
  <div class="wrap">
    <div class="shead"><p class="eyebrow">Sık sorulanlar</p><h2>Yatırım kararından önce en çok sorulanlar</h2></div>
    <div class="faq">
      <?php foreach (get_faqs() as $i => $f): ?>
        <details<?= $i === 0 ? ' open' : '' ?>>
          <summary><?= e($f['q']) ?></summary>
          <p><?= e($f['a']) ?></p>
        </details>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- KAPANIŞ CTA -->
<section class="band band-soft">
  <div class="wrap" style="text-align:center">
    <h2 style="font-size:var(--s-3);max-width:24ch;margin:0 auto">Projenizi anlatın, fizibilite görüşmesiyle başlayalım.</h2>
    <p class="lede" style="margin:16px auto 0">İlk görüşme ücretsizdir ve arazi verilerinizin ön değerlendirmesini kapsar.</p>
    <p style="margin-top:28px"><a class="btn btn-primary btn-lg" href="<?= e(url('/iletisim')) ?>">Teklif formunu doldurun</a></p>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
