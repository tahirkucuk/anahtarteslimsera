<?php
$page = ['path' => '/gizlilik'];
require_once __DIR__ . '/inc/bootstrap.php';
$page['title']       = t('gizlilik.title', 'Gizlilik ve KVKK Aydınlatma Metni');
$page['desc']        = t('gizlilik.desc', 'Kişisel verilerin işlenmesine ilişkin aydınlatma metni ve çerez politikası.');
$page['breadcrumbs'] = [['name' => t('gizlilik.crumb', 'Gizlilik ve KVKK'), 'path' => '/gizlilik']];
require_once APP_ROOT . '/inc/header.php';
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>"><?= e(t('home', 'Ana Sayfa')) ?></a><span>/</span><?= e(t('gizlilik.crumb', 'Gizlilik ve KVKK')) ?></p>
    <h1><?= e(t('gizlilik.h1', 'Gizlilik ve KVKK aydınlatma metni')) ?></h1>
    <p class="lede"><?= e(t('gizlilik.lede', '6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında, site üzerinden paylaştığınız bilgilerin nasıl işlendiğine dair bilgilendirme.')) ?></p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="article prose">

      <div class="callout">
        <?= e(t('gizlilik.draft.warning', 'Yayına almadan önce doldurulacak')) ?>
        <?= e(t('gizlilik.draft.p', 'Bu metin bir taslaktır. Veri sorumlusunun unvanı, adresi, VERBİS kaydı ve saklama süreleri üç firmanın hukuk müşaviri tarafından kesinleştirilmelidir.')) ?>
      </div>

      <?php if (LANG === 'en'): ?>

      <h2>1. Data Controller</h2>
      <p>Personal data submitted through the site is processed by the solution partners operating under the <strong><?= e(SITE_NAME) ?></strong> umbrella. The data controller's legal name and contact details will be added to this section before publication.</p>

      <h2>2. Data Collected</h2>
      <p>Only the following data is collected through the quote form:</p>
      <ul>
        <li>Full name, phone number and e-mail address (if provided)</li>
        <li>Province and district of the planned investment</li>
        <li>Land size and planned crop</li>
        <li>Selected service scope and free-text notes</li>
        <li>Technical records: IP address, browser information and referring page</li>
      </ul>

      <h2>3. Purpose and Legal Basis</h2>
      <p>Data is processed solely for the purpose of preparing a quote, contacting you, and routing your request to the relevant solution partner. The legal basis is your explicit consent and pre-contractual negotiations. Your data will not be sold or transferred to third parties for marketing purposes.</p>

      <h2>4. Data Sharing</h2>
      <p>Your request is shared only with the relevant partner based on your selected scope. Beyond that, data is not shared with third parties except as required by law.</p>

      <h2>5. Retention Period</h2>
      <p>Quote requests are retained for <strong>[period to be determined]</strong> after the quote process concludes; they are then deleted or anonymised.</p>

      <h2>6. Your Rights</h2>
      <p>Under applicable data protection law, you have the right to learn whether your data is being processed, request correction or deletion, and object to processing. Please send your requests to <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a>.</p>

      <h2>7. Cookies</h2>
      <p>The site uses a session cookie required for operation. When Google Analytics is active, you can block these cookies through your browser settings. This section will be updated when advertising measurement is enabled.</p>

      <?php else: ?>

      <h2>1. Veri sorumlusu</h2>
      <p>Site üzerinden iletilen kişisel veriler, <strong><?= e(SITE_NAME) ?></strong> çatısı altında hizmet veren çözüm ortakları tarafından işlenmektedir. Veri sorumlusunun unvanı ve iletişim bilgileri yayın öncesinde bu bölüme eklenecektir.</p>

      <h2>2. İşlenen veriler</h2>
      <p>Teklif formu üzerinden yalnızca aşağıdaki veriler toplanır:</p>
      <ul>
        <li>Ad soyad, telefon numarası ve varsa e-posta adresi</li>
        <li>Yatırımın planlandığı il ve ilçe bilgisi</li>
        <li>Arazi büyüklüğü ve planlanan ürün bilgisi</li>
        <li>İlgilendiğiniz hizmet kapsamı ve serbest metin notlarınız</li>
        <li>Teknik kayıtlar: IP adresi, tarayıcı bilgisi ve talebin geldiği sayfa</li>
      </ul>

      <h2>3. İşleme amacı ve hukuki sebep</h2>
      <p>Veriler yalnızca teklif hazırlığı, sizinle iletişim kurulması ve talebinizin ilgili çözüm ortağına yönlendirilmesi amacıyla işlenir. Hukuki sebep, açık rızanız ve sözleşme öncesi görüşmelerin yürütülmesidir. Verileriniz pazarlama amacıyla üçüncü taraflara satılmaz veya devredilmez.</p>

      <h2>4. Aktarım</h2>
      <p>Talebiniz, seçtiğiniz kapsama göre çözüm ortaklarından yalnızca ilgili olanla paylaşılır. Bunun dışında yasal yükümlülükler saklı kalmak kaydıyla üçüncü kişilerle paylaşılmaz.</p>

      <h2>5. Saklama süresi</h2>
      <p>Teklif talepleri, teklif süreci sonuçlandıktan sonra <strong>[süre belirlenecek]</strong> boyunca saklanır; sonrasında silinir veya anonim hale getirilir.</p>

      <h2>6. Haklarınız</h2>
      <p>KVKK'nın 11. maddesi uyarınca; verilerinizin işlenip işlenmediğini öğrenme, düzeltilmesini veya silinmesini isteme ve işlemeye itiraz etme haklarına sahipsiniz. Taleplerinizi <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a> adresine iletebilirsiniz.</p>

      <h2>7. Çerezler</h2>
      <p>Site, çalışması için gerekli oturum çerezini kullanır. Ölçümleme amacıyla Google Analytics kullanıldığında, tarayıcı ayarlarınızdan bu çerezleri engelleyebilirsiniz. Reklam ölçümlemesi etkinleştirildiğinde bu bölüm güncellenecektir.</p>

      <?php endif; ?>

    </div>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
