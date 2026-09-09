<?php
$page = [
    'title'       => 'Gizlilik ve KVKK Aydınlatma Metni',
    'desc'        => 'Kişisel verilerin işlenmesine ilişkin aydınlatma metni ve çerez politikası.',
    'path'        => '/gizlilik',
    'breadcrumbs' => [['name' => 'Gizlilik ve KVKK', 'path' => '/gizlilik']],
];
require_once __DIR__ . '/inc/bootstrap.php';
require_once APP_ROOT . '/inc/header.php';
?>

<section class="pagehead">
  <div class="wrap">
    <p class="crumbs"><a href="<?= e(url('/')) ?>">Ana Sayfa</a><span>/</span>Gizlilik ve KVKK</p>
    <h1>Gizlilik ve KVKK aydınlatma metni</h1>
    <p class="lede">6698 sayılı Kişisel Verilerin Korunması Kanunu kapsamında, site üzerinden paylaştığınız bilgilerin nasıl işlendiğine dair bilgilendirme.</p>
  </div>
</section>

<section class="band">
  <div class="wrap">
    <div class="article prose">

      <div class="callout">
        <b>Yayına almadan önce doldurulacak</b>
        Bu metin bir taslaktır. Veri sorumlusunun unvanı, adresi, VERBİS kaydı ve saklama süreleri
        üç firmanın hukuk müşaviri tarafından kesinleştirilmelidir. Ticari model kararı
        (tek sözleşme mi ayrı sözleşmeler mi) veri sorumlusunun kim olduğunu da belirler.
      </div>

      <h2>1. Veri sorumlusu</h2>
      <p>Site üzerinden iletilen kişisel veriler, <strong><?= e(SITE_NAME) ?></strong> çatısı altında
      hizmet veren çözüm ortakları tarafından işlenmektedir. Veri sorumlusunun unvanı ve iletişim
      bilgileri yayın öncesinde bu bölüme eklenecektir.</p>

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
      <p>Veriler yalnızca teklif hazırlığı, sizinle iletişim kurulması ve talebinizin ilgili çözüm
      ortağına yönlendirilmesi amacıyla işlenir. Hukuki sebep, açık rızanız ve sözleşme öncesi
      görüşmelerin yürütülmesidir. Verileriniz pazarlama amacıyla üçüncü taraflara satılmaz veya
      devredilmez.</p>

      <h2>4. Aktarım</h2>
      <p>Talebiniz, seçtiğiniz kapsama göre çözüm ortaklarından yalnızca ilgili olanla paylaşılır.
      Bunun dışında yasal yükümlülükler saklı kalmak kaydıyla üçüncü kişilerle paylaşılmaz.</p>

      <h2>5. Saklama süresi</h2>
      <p>Teklif talepleri, teklif süreci sonuçlandıktan sonra <strong>[süre belirlenecek]</strong>
      boyunca saklanır; sonrasında silinir veya anonim hale getirilir.</p>

      <h2>6. Haklarınız</h2>
      <p>KVKK'nın 11. maddesi uyarınca; verilerinizin işlenip işlenmediğini öğrenme, düzeltilmesini
      veya silinmesini isteme ve işlemeye itiraz etme haklarına sahipsiniz. Taleplerinizi
      <a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a> adresine iletebilirsiniz.</p>

      <h2>7. Çerezler</h2>
      <p>Site, çalışması için gerekli oturum çerezini kullanır. Ölçümleme amacıyla Google Analytics
      kullanıldığında, tarayıcı ayarlarınızdan bu çerezleri engelleyebilirsiniz. Reklam ölçümlemesi
      etkinleştirildiğinde bu bölüm güncellenecektir.</p>

    </div>
  </div>
</section>

<?php require_once APP_ROOT . '/inc/footer.php'; ?>
