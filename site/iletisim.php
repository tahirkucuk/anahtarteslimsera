<?php
$page = ['path' => '/iletisim'];
require_once __DIR__ . '/inc/bootstrap.php';
$page['title']       = t('iletisim.title', 'İletişim ve Teklif Formu');
$page['desc']        = t('iletisim.desc', 'Sera projeniz için ücretsiz fizibilite görüşmesi talep edin. Arazi bilgilerinizi paylaşın, kapsamı birlikte belirleyelim.');
$page['breadcrumbs'] = [['name' => t('iletisim.crumb', 'İletişim'), 'path' => '/iletisim']];

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
$errors = $_SESSION['form_errors'] ?? [];
$old    = $_SESSION['form_old']    ?? [];
unset($_SESSION['form_errors'], $_SESSION['form_old']);

$v = function (string $k, string $def = '') use ($old) {
    return e((string) ($old[$k] ?? $def));
};
$checked = function (string $val) use ($old) {
    return in_array($val, (array) ($old['kapsam'] ?? []), true) ? ' checked' : '';
};

// Ürün listesi: value (TR key) → display label
$en_products = t_array('iletisim.products');
$urunler = [
    'Belirtilmedi'         => $en_products['Belirtilmedi']         ?? 'Seçiniz',
    'Domates'              => $en_products['Domates']              ?? 'Domates',
    'Salatalık'            => $en_products['Salatalık']            ?? 'Salatalık',
    'Biber / patlıcan'     => $en_products['Biber / patlıcan']     ?? 'Biber / patlıcan',
    'Çilek'                => $en_products['Çilek']                ?? 'Çilek',
    'Yeşillik / marul'     => $en_products['Yeşillik / marul']     ?? 'Yeşillik / marul',
    'Fide üretimi'         => $en_products['Fide üretimi']         ?? 'Fide üretimi',
    'Süs bitkisi'          => $en_products['Süs bitkisi']          ?? 'Süs bitkisi',
    'Henüz karar vermedim' => $en_products['Henüz karar vermedim'] ?? 'Henüz karar vermedim',
];

// Kapsam listesi: value (TR key) → display label
$en_scopes = t_array('iletisim.scopes');
$kapsamlar_raw = ['Anahtar teslim sera', 'Tarımsal danışmanlık', 'Sera kurulumu', 'Sulama sistemi', 'Hibe / IPARD dosyası'];

require_once APP_ROOT . '/inc/header.php';
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>"><?= e(t('home', 'Ana Sayfa')) ?></a><span>/</span><?= e(t('iletisim.crumb', 'İletişim')) ?></p>
    <h1><?= e(t('iletisim.h1', 'Projenizi anlatın, fizibilite görüşmesiyle başlayalım.')) ?></h1>
    <p class="lede"><?= e(t('iletisim.lede', 'Formu doldurduğunuzda talebiniz doğrudan proje ekibine iletilir. İlk görüşme ücretsizdir ve arazi verilerinizin ön değerlendirmesini kapsar.')) ?></p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="contact-grid">

      <div id="form">
        <?php if ($errors): ?>
          <div class="alert alert-err" role="alert">
            <strong><?= e(t('iletisim.err.title', 'Form gönderilemedi.')) ?></strong>
            <ul><?php foreach ($errors as $err): ?><li><?= e($err) ?></li><?php endforeach; ?></ul>
          </div>
        <?php endif; ?>

        <div class="alert alert-err" id="form-uyari" role="alert" hidden></div>

        <form id="teklif-form" action="<?= e(url('/api/teklif.php')) ?>" method="post" novalidate>
          <?= csrf_field() ?>
          <div class="hp" aria-hidden="true">
            <label for="website"><?= LANG === 'en' ? 'Your website' : 'Web siteniz' ?></label>
            <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
          </div>
          <input type="hidden" name="ts" value="<?= time() ?>">

          <div class="formgrid">
            <div class="field">
              <label for="ad"><?= e(t('iletisim.label.name', 'Ad Soyad *')) ?></label>
              <input id="ad" name="ad" type="text" autocomplete="name" data-label="<?= e(t('iletisim.label.name', 'Ad Soyad')) ?>" value="<?= $v('ad') ?>" required>
            </div>
            <div class="field">
              <label for="telefon"><?= e(t('iletisim.label.phone', 'Telefon *')) ?></label>
              <input id="telefon" name="telefon" type="tel" inputmode="tel" autocomplete="tel"
                     data-label="<?= e(t('iletisim.label.phone', 'Telefon')) ?>" placeholder="05__ ___ __ __" value="<?= $v('telefon') ?>" required>
            </div>
            <div class="field">
              <label for="eposta"><?= e(t('iletisim.label.email', 'E-posta')) ?></label>
              <input id="eposta" name="eposta" type="email" autocomplete="email" value="<?= $v('eposta') ?>">
            </div>
            <div class="field">
              <label for="sehir"><?= e(t('iletisim.label.city', 'İl / İlçe *')) ?></label>
              <input id="sehir" name="sehir" type="text" data-label="<?= e(t('iletisim.label.city', 'İl / İlçe')) ?>"
                     placeholder="<?= e(t('iletisim.label.city.ph', 'Örn. Antalya / Kumluca')) ?>" value="<?= $v('sehir') ?>" required>
            </div>
            <div class="field">
              <label for="alan"><?= e(t('iletisim.label.area', 'Arazi büyüklüğü (dekar)')) ?></label>
              <input id="alan" name="alan" type="number" min="0" step="0.5" placeholder="20" value="<?= $v('alan') ?>">
            </div>
            <div class="field">
              <label for="urun"><?= e(t('iletisim.label.product', 'Planlanan ürün')) ?></label>
              <select id="urun" name="urun">
                <?php foreach ($urunler as $val => $lbl): ?>
                  <option value="<?= e($val) ?>"<?= ($old['urun'] ?? '') === $val ? ' selected' : '' ?>><?= e($lbl) ?></option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="field full">
              <label><?= e(t('iletisim.label.scope', 'İlgilendiğiniz kapsam *')) ?></label>
              <div class="checks">
                <?php foreach ($kapsamlar_raw as $k):
                  $lbl = $en_scopes[$k] ?? $k; ?>
                  <label class="chk">
                    <input type="checkbox" name="kapsam[]" value="<?= e($k) ?>"<?= $checked($k) ?>>
                    <span><?= e($lbl) ?></span>
                  </label>
                <?php endforeach; ?>
              </div>
            </div>

            <div class="field full">
              <label for="notlar"><?= e(t('iletisim.label.notes', 'Eklemek istedikleriniz')) ?></label>
              <textarea id="notlar" name="notlar" placeholder="<?= e(t('iletisim.label.notes.ph', 'Su kaynağı, mevcut yapı, hedef teslim tarihi gibi bilgiler süreci hızlandırır.')) ?>"><?= $v('notlar') ?></textarea>
            </div>

            <div class="field full">
              <label class="chk" style="display:block">
                <input type="checkbox" name="kvkk" value="1" required>
                <span style="font-family:var(--serif);text-transform:none;letter-spacing:0;font-size:14px;line-height:1.5;display:block;max-width:60ch">
                  <?= sprintf(t('iletisim.kvkk', '<a href="%s">Aydınlatma metnini</a> okudum; iletişim bilgilerimin teklif hazırlığı amacıyla işlenmesine izin veriyorum. *'), e(url('/gizlilik'))) ?>
                </span>
              </label>
            </div>
          </div>

          <div class="formfoot">
            <button class="btn btn-primary btn-lg" type="submit"><?= e(t('iletisim.submit', 'Teklif talebini gönderin')) ?></button>
            <span class="small"><?= e(t('iletisim.required', '* işaretli alanlar zorunludur.')) ?></span>
          </div>
        </form>
      </div>

      <aside>
        <div class="contact-card">
          <h2><?= e(t('iletisim.card.h2', 'Tek muhatap')) ?></h2>
          <dl>
            <div class="contact-line">
              <dt><?= e(t('iletisim.card.phone', 'Telefon')) ?></dt>
              <dd><a href="tel:<?= e(str_replace(' ', '', CONTACT_PHONE)) ?>"><?= e(CONTACT_PHONE_DISPLAY) ?></a></dd>
            </div>
            <div class="contact-line">
              <dt><?= e(t('iletisim.card.wa', 'WhatsApp')) ?></dt>
              <dd><a href="https://wa.me/<?= e(CONTACT_WHATSAPP) ?>" target="_blank" rel="noopener"><?= e(t('iletisim.card.wa.link', 'Mesaj gönderin')) ?></a></dd>
            </div>
            <div class="contact-line">
              <dt><?= e(t('iletisim.card.email', 'E-posta')) ?></dt>
              <dd><a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a></dd>
            </div>
            <div class="contact-line">
              <dt><?= e(t('iletisim.card.addr', 'Adres')) ?></dt>
              <dd style="font-weight:400;font-size:14.5px"><?= e(CONTACT_ADDRESS) ?></dd>
            </div>
          </dl>
          <p class="note" style="margin-top:18px">
            <?= e(t('iletisim.card.note', 'Üç firmaya da tek numaradan ulaşırsınız. Talebiniz kapsam seçiminize göre ilgili ekibe yönlendirilir.')) ?>
          </p>
        </div>

        <div class="contact-card" style="margin-top:20px">
          <h2><?= e(t('iletisim.card2.h2', 'Ne hazırlamalısınız?')) ?></h2>
          <ul class="foot-list" style="gap:12px">
            <?php
            $prep = t_array('iletisim.card2.li') ?: ['Arazinin konumu ve büyüklüğü (dekar)', 'Tapu / arazi niteliği bilgisi', 'Su kaynağı: kuyu, gölet, şebeke', 'Varsa mevcut yapı ve ekipman', 'Hedef ürün ve pazar'];
            foreach ($prep as $item): ?><li><?= e($item) ?></li><?php endforeach; ?>
          </ul>
          <p class="note"><?= e(t('iletisim.card2.note', 'Hepsi hazır olmasa da görüşebiliriz; bu liste yalnızca süreci hızlandırır.')) ?></p>
        </div>
      </aside>

    </div>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
