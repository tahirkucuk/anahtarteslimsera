<?php
$page = [
    'title'       => 'İletişim ve Teklif Formu',
    'desc'        => 'Sera projeniz için ücretsiz fizibilite görüşmesi talep edin. Arazi bilgilerinizi paylaşın, kapsamı birlikte belirleyelim.',
    'path'        => '/iletisim',
    'breadcrumbs' => [['name' => 'İletişim', 'path' => '/iletisim']],
];
require_once __DIR__ . '/inc/bootstrap.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$errors = $_SESSION['form_errors'] ?? [];
$old    = $_SESSION['form_old']    ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);

/** Eski değeri geri yazar (hata sonrası form boşalmasın). */
$v = function (string $k, string $def = '') use ($old) {
    return e((string) ($old[$k] ?? $def));
};
$checked = function (string $val) use ($old) {
    return in_array($val, (array) ($old['kapsam'] ?? []), true) ? ' checked' : '';
};

require_once APP_ROOT . '/inc/header.php';
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>">Ana Sayfa</a><span>/</span>İletişim</p>
    <h1>Projenizi anlatın, fizibilite görüşmesiyle başlayalım.</h1>
    <p class="lede">Formu doldurduğunuzda talebiniz doğrudan proje ekibine iletilir. İlk görüşme ücretsizdir ve arazi verilerinizin ön değerlendirmesini kapsar.</p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="contact-grid">

      <div id="form">
        <?php if ($errors): ?>
          <div class="alert alert-err" role="alert">
            <strong>Form gönderilemedi.</strong>
            <ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
          </div>
        <?php endif; ?>

        <div class="alert alert-err" id="form-uyari" role="alert" hidden></div>

        <form id="teklif-form" action="<?= e(url('/api/teklif.php')) ?>" method="post" novalidate>
          <?= csrf_field() ?>
          <!-- bot tuzağı: gerçek kullanıcı bunu görmez ve doldurmaz -->
          <div class="hp" aria-hidden="true">
            <label for="website">Web siteniz</label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
          </div>
          <input type="hidden" name="ts" value="<?= time() ?>">

          <div class="formgrid">
            <div class="field">
              <label for="ad">Ad Soyad *</label>
              <input id="ad" name="ad" type="text" autocomplete="name" data-label="Ad Soyad" value="<?= $v('ad') ?>" required>
            </div>
            <div class="field">
              <label for="telefon">Telefon *</label>
              <input id="telefon" name="telefon" type="tel" inputmode="tel" autocomplete="tel"
                     data-label="Telefon" placeholder="05__ ___ __ __" value="<?= $v('telefon') ?>" required>
            </div>
            <div class="field">
              <label for="eposta">E-posta</label>
              <input id="eposta" name="eposta" type="email" autocomplete="email" value="<?= $v('eposta') ?>">
            </div>
            <div class="field">
              <label for="sehir">İl / İlçe *</label>
              <input id="sehir" name="sehir" type="text" data-label="İl / İlçe"
                     placeholder="Örn. Antalya / Kumluca" value="<?= $v('sehir') ?>" required>
            </div>
            <div class="field">
              <label for="alan">Arazi büyüklüğü (dekar)</label>
              <input id="alan" name="alan" type="number" min="0" step="0.5" placeholder="20" value="<?= $v('alan') ?>">
            </div>
            <div class="field">
              <label for="urun">Planlanan ürün</label>
              <select id="urun" name="urun">
                <?php
                $urunler = ['Belirtilmedi' => 'Seçiniz', 'Domates' => 'Domates', 'Salatalık' => 'Salatalık',
                            'Biber / patlıcan' => 'Biber / patlıcan', 'Çilek' => 'Çilek',
                            'Yeşillik / marul' => 'Yeşillik / marul', 'Fide üretimi' => 'Fide üretimi',
                            'Süs bitkisi' => 'Süs bitkisi', 'Henüz karar vermedim' => 'Henüz karar vermedim'];
                foreach ($urunler as $val => $lbl): ?>
                  <option value="<?= e($val) ?>"<?= ($old['urun'] ?? '') === $val ? ' selected' : '' ?>><?= e($lbl) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="field full">
              <label>İlgilendiğiniz kapsam *</label>
              <div class="checks">
                <?php
                $kapsamlar = ['Anahtar teslim sera', 'Tarımsal danışmanlık', 'Sera kurulumu',
                              'Sulama sistemi', 'Hibe / IPARD dosyası'];
                foreach ($kapsamlar as $k): ?>
                  <label class="chk">
                    <input type="checkbox" name="kapsam[]" value="<?= e($k) ?>"<?= $checked($k) ?>>
                    <span><?= e($k) ?></span>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="field full">
              <label for="notlar">Eklemek istedikleriniz</label>
              <textarea id="notlar" name="notlar" placeholder="Su kaynağı, mevcut yapı, hedef teslim tarihi gibi bilgiler süreci hızlandırır."><?= $v('notlar') ?></textarea>
            </div>

            <div class="field full">
              <label class="chk" style="display:block">
                <input type="checkbox" name="kvkk" value="1" required>
                <span style="font-family:var(--serif);text-transform:none;letter-spacing:0;font-size:14px;line-height:1.5;display:block;max-width:60ch">
                  <a href="<?= e(url('/gizlilik')) ?>">Aydınlatma metnini</a> okudum; iletişim bilgilerimin
                  teklif hazırlığı amacıyla işlenmesine izin veriyorum. *
                </span>
              </label>
            </div>
          </div>

          <div class="formfoot">
            <button class="btn btn-primary btn-lg" type="submit">Teklif talebini gönderin</button>
            <span class="small">* işaretli alanlar zorunludur.</span>
          </div>
        </form>
      </div>

      <aside>
        <div class="contact-card">
          <h2>Tek muhatap</h2>
          <dl>
            <div class="contact-line">
              <dt>Telefon</dt>
              <dd><a href="tel:<?= e(str_replace(' ', '', CONTACT_PHONE)) ?>"><?= e(CONTACT_PHONE_DISPLAY) ?></a></dd>
            </div>
            <div class="contact-line">
              <dt>WhatsApp</dt>
              <dd><a href="https://wa.me/<?= e(CONTACT_WHATSAPP) ?>" target="_blank" rel="noopener">Mesaj gönderin</a></dd>
            </div>
            <div class="contact-line">
              <dt>E-posta</dt>
              <dd><a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a></dd>
            </div>
            <div class="contact-line">
              <dt>Adres</dt>
              <dd style="font-weight:400;font-size:14.5px"><?= e(CONTACT_ADDRESS) ?></dd>
            </div>
          </dl>
          <p class="note" style="margin-top:18px">
            Üç firmaya da tek numaradan ulaşırsınız. Talebiniz kapsam seçiminize göre ilgili ekibe yönlendirilir.
          </p>
        </div>

        <div class="contact-card" style="margin-top:20px">
          <h2>Ne hazırlamalısınız?</h2>
          <ul class="foot-list" style="gap:12px">
            <li>Arazinin konumu ve büyüklüğü (dekar)</li>
            <li>Tapu / arazi niteliği bilgisi</li>
            <li>Su kaynağı: kuyu, gölet, şebeke</li>
            <li>Varsa mevcut yapı ve ekipman</li>
            <li>Hedef ürün ve pazar</li>
          </ul>
          <p class="note">Hepsi hazır olmasa da görüşebiliriz; bu liste yalnızca süreci hızlandırır.</p>
        </div>
      </aside>

    </div>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
