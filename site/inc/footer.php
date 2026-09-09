<?php if (!defined('APP_ROOT')) { exit; } ?>
</main>

<footer class="site-foot">
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <p class="foot-name">Anahtar Teslim Sera</p>
        <p class="foot-tag">Entegre Tarım Çözümleri</p>
        <p class="foot-text">Tarımsal danışmanlık, sera kurulumu ve sulama sistemleri tek proje yönetimi altında. Fizibiliteden ilk hasada kadar tek muhatap.</p>
      </div>

      <div>
        <h2 class="foot-h">Hizmetler</h2>
        <ul class="foot-list">
          <?php foreach (get_services() as $s): ?>
            <li><a href="<?= e(url('/hizmetler/' . $s['slug'])) ?>"><?= e($s['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h2 class="foot-h">Kurumsal</h2>
        <ul class="foot-list">
          <li><a href="<?= e(url('/surec')) ?>">Süreç</a></li>
          <li><a href="<?= e(url('/projeler')) ?>">Projeler</a></li>
          <li><a href="<?= e(url('/blog')) ?>">Blog</a></li>
          <li><a href="<?= e(url('/iletisim')) ?>">İletişim ve teklif</a></li>
        </ul>
      </div>

      <div>
        <h2 class="foot-h">İletişim</h2>
        <ul class="foot-list foot-contact">
          <li><a href="tel:<?= e(str_replace(' ', '', CONTACT_PHONE)) ?>"><?= e(CONTACT_PHONE_DISPLAY) ?></a></li>
          <li><a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a></li>
          <li><?= e(CONTACT_ADDRESS) ?></li>
        </ul>
      </div>
    </div>

    <div class="foot-partners">
      <span class="foot-h">Çözüm ortakları</span>
      <div class="partner-row">
        <?php foreach (PARTNERS as $p): ?>
          <div class="partner" data-hue="<?= e($p['hue']) ?>">
            <span class="partner-name"><?= e($p['name']) ?></span>
            <span class="partner-role"><?= e($p['role']) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="foot-bottom">
      <span>© <?= date('Y') ?> <?= e(SITE_NAME) ?>. Tüm hakları saklıdır.</span>
      <span><a href="<?= e(url('/gizlilik')) ?>">Gizlilik ve KVKK</a></span>
    </div>
  </div>
</footer>

<a class="wa-float" href="https://wa.me/<?= e(CONTACT_WHATSAPP) ?>" target="_blank" rel="noopener" aria-label="WhatsApp ile yazın">
  <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
    <path fill="currentColor" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.23 8.25-8.23a8.2 8.2 0 0 1 8.24 8.24c0 4.54-3.7 8.23-8.24 8.23Zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.79.97-.14.16-.29.19-.54.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.01-.38.11-.5.11-.11.25-.29.37-.43.13-.15.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.43h-.47c-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.05s.89 2.38 1.01 2.54c.12.17 1.74 2.66 4.22 3.73.59.25 1.05.4 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.14-1.18-.06-.1-.22-.16-.47-.29Z"/>
  </svg>
</a>

<script src="<?= e(asset('js/site.js')) ?>" defer></script>
</body>
</html>
