<?php if (!defined('APP_ROOT')) { exit; } ?>
</main>

<footer class="site-foot">
  <div class="wrap">
    <div class="foot-grid">
      <div class="foot-brand">
        <p class="foot-name">Anahtar Teslim Sera</p>
        <p class="foot-tag"><?= e(t('foot.tagline', 'Entegre Tarım Çözümleri')) ?></p>
        <p class="foot-text"><?= e(t('foot.desc', 'Tarımsal danışmanlık, sera kurulumu ve sulama sistemleri tek proje yönetimi altında. Fizibiliteden ilk hasada kadar tek muhatap.')) ?></p>
      </div>

      <div>
        <h2 class="foot-h"><?= e(t('foot.services', 'Hizmetler')) ?></h2>
        <ul class="foot-list">
          <?php foreach (get_services() as $s): ?>
            <li><a href="<?= e(url('/hizmetler/' . $s['slug'])) ?>"><?= e($s['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div>
        <h2 class="foot-h"><?= e(t('foot.corporate', 'Kurumsal')) ?></h2>
        <ul class="foot-list">
          <li><a href="<?= e(url('/surec')) ?>"><?= e(t('foot.process', 'Süreç')) ?></a></li>
          <li><a href="<?= e(url('/projeler')) ?>"><?= e(t('foot.projects', 'Projeler')) ?></a></li>
          <li><a href="<?= e(url('/blog')) ?>"><?= e(t('foot.blog', 'Blog')) ?></a></li>
          <li><a href="<?= e(url('/iletisim')) ?>"><?= e(t('foot.contact-quote', 'İletişim ve teklif')) ?></a></li>
        </ul>
      </div>

      <div>
        <h2 class="foot-h"><?= e(t('foot.contact', 'İletişim')) ?></h2>
        <ul class="foot-list foot-contact">
          <li><a href="tel:<?= e(str_replace(' ', '', CONTACT_PHONE)) ?>"><?= e(CONTACT_PHONE_DISPLAY) ?></a></li>
          <li><a href="mailto:<?= e(CONTACT_EMAIL) ?>"><?= e(CONTACT_EMAIL) ?></a></li>
          <li><?= e(CONTACT_ADDRESS) ?></li>
        </ul>
      </div>
    </div>

    <div class="foot-partners">
      <span class="foot-h"><?= e(t('foot.partners', 'Çözüm ortakları')) ?></span>
      <div class="partner-row">
        <?php foreach (PARTNERS as $key => $p): ?>
          <div class="partner" data-hue="<?= e($p['hue']) ?>">
            <span class="partner-name"><?= e($p['name']) ?></span>
            <span class="partner-role"><?= e(t('partner.' . $key . '.role', $p['role'])) ?></span>
          </div>
        <?php endforeach; ?>
      </div>
    </div>

    <div class="foot-newsletter">
      <p class="foot-h"><?= e(t('bulten.label', 'Bülten')) ?></p>
      <p class="foot-nl-desc"><?= e(t('bulten.desc', 'Yeni rehberler yayınlandığında e-posta ile haberdar olun.')) ?></p>
      <form class="foot-nl-form" id="footBultenForm" novalidate>
        <input type="hidden" name="dil" value="<?= LANG === 'en' ? 'en' : 'tr' ?>">
        <input type="hidden" name="page" value="footer">
        <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
        <input type="email" name="email" class="foot-nl-input" placeholder="<?= e(t('bulten.placeholder', 'e-posta adresiniz')) ?>" required autocomplete="email">
        <button type="submit" class="foot-nl-btn"><?= e(t('bulten.btn', 'Abone Ol')) ?></button>
      </form>
      <p class="foot-nl-msg" id="footBultenMsg" hidden></p>
    </div>

    <div class="foot-bottom">
      <span>© <?= date('Y') ?> <?= e(SITE_NAME) ?>. <?= e(t('foot.rights', 'Tüm hakları saklıdır.')) ?></span>
      <span><a href="<?= e(url('/gizlilik')) ?>"><?= e(t('foot.privacy', 'Gizlilik ve KVKK')) ?></a></span>
    </div>
  </div>
</footer>

<div id="nlpOverlay" class="nlp-overlay" hidden>
  <div class="nlp-card" role="dialog" aria-modal="true" aria-labelledby="nlpTitle">
    <button class="nlp-close" id="nlpClose" aria-label="<?= LANG === 'en' ? 'Close' : 'Kapat' ?>">×</button>
    <div class="nlp-icon">🌿</div>
    <h2 class="nlp-title" id="nlpTitle">
      <?= LANG === 'en' ? e(t('nlp.title', 'Subscribe to Greenhouse Guides')) : e(t('nlp.title', 'Sera Rehberlerine Abone Olun')) ?>
    </h2>
    <p class="nlp-desc">
      <?= LANG === 'en' ? e(t('nlp.desc', 'Be the first to know when new guides are published. No spam, unsubscribe any time.')) : e(t('nlp.desc', 'Yeni rehber yayınlandığında ilk siz haberdar olun. Reklam yok, istediğiniz zaman çıkabilirsiniz.')) ?>
    </p>
    <form class="nlp-form" id="nlpForm" novalidate>
      <input type="hidden" name="dil" value="<?= LANG === 'en' ? 'en' : 'tr' ?>">
      <input type="hidden" name="page" value="popup">
      <input type="text" name="website" style="display:none" tabindex="-1" autocomplete="off">
      <input type="email" name="email" class="nlp-input" placeholder="<?= e(t('bulten.placeholder', 'e-posta adresiniz')) ?>" required autocomplete="email">
      <button type="submit" class="nlp-btn"><?= e(t('bulten.btn', 'Abone Ol')) ?></button>
    </form>
    <p class="nlp-msg" id="nlpMsg" hidden></p>
    <button class="nlp-skip" id="nlpSkip"><?= LANG === 'en' ? 'No thanks' : 'Hayır, teşekkürler' ?></button>
  </div>
</div>

<a class="wa-float" href="https://wa.me/<?= e(CONTACT_WHATSAPP) ?>" target="_blank" rel="noopener" aria-label="WhatsApp">
  <svg viewBox="0 0 24 24" aria-hidden="true" focusable="false">
    <path fill="currentColor" d="M12.04 2C6.58 2 2.13 6.45 2.13 11.91c0 1.75.46 3.45 1.32 4.95L2 22l5.25-1.38a9.9 9.9 0 0 0 4.79 1.22h.01c5.46 0 9.91-4.45 9.91-9.91 0-2.65-1.03-5.14-2.9-7.01A9.82 9.82 0 0 0 12.04 2Zm0 18.15h-.01a8.2 8.2 0 0 1-4.19-1.15l-.3-.18-3.12.82.83-3.04-.2-.31a8.19 8.19 0 0 1-1.26-4.38c0-4.54 3.7-8.23 8.25-8.23a8.2 8.2 0 0 1 8.24 8.24c0 4.54-3.7 8.23-8.24 8.23Zm4.52-6.16c-.25-.12-1.47-.72-1.69-.81-.23-.08-.39-.12-.56.13-.16.24-.64.8-.79.97-.14.16-.29.19-.54.06-.25-.12-1.05-.39-1.99-1.23-.74-.66-1.23-1.47-1.38-1.72-.14-.25-.01-.38.11-.5.11-.11.25-.29.37-.43.13-.15.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.34-.76-1.84-.2-.48-.4-.42-.56-.43h-.47c-.17 0-.43.06-.66.31-.23.25-.86.84-.86 2.05s.89 2.38 1.01 2.54c.12.17 1.74 2.66 4.22 3.73.59.25 1.05.4 1.41.52.59.19 1.13.16 1.56.1.48-.07 1.47-.6 1.68-1.18.21-.58.21-1.07.14-1.18-.06-.1-.22-.16-.47-.29Z"/>
  </svg>
</a>

<script src="<?= e(asset('js/site.js')) ?>" defer></script>
<script>
(function(){
  var form=document.getElementById('footBultenForm');
  if(!form)return;
  form.addEventListener('submit',function(e){
    e.preventDefault();
    var msg=document.getElementById('footBultenMsg');
    var btn=form.querySelector('button[type=submit]');
    var email=form.querySelector('input[name=email]');
    if(!email.value.trim()){email.focus();return;}
    btn.disabled=true;
    var fd=new FormData(form);
    fetch('<?= e(rtrim(BASE_PATH, '/')) ?>/bulten-abone.php',{method:'POST',body:fd})
      .then(function(r){return r.json();})
      .then(function(d){
        msg.hidden=false;
        msg.className='foot-nl-msg '+(d.ok?'foot-nl-ok':'foot-nl-err');
        msg.textContent=d.mesaj||d.error||'Hata oluştu.';
        if(d.ok)form.reset();
        btn.disabled=false;
      })
      .catch(function(){
        msg.hidden=false;msg.className='foot-nl-msg foot-nl-err';
        msg.textContent='<?= e(t('bulten.err', 'Bağlantı hatası. Lütfen tekrar deneyin.')) ?>';
        btn.disabled=false;
      });
  });
})();
</script>
<script>
(function(){
  var LSKEY='nlp_v1';
  if(localStorage.getItem(LSKEY))return;
  var overlay=document.getElementById('nlpOverlay');
  if(!overlay)return;
  function closePopup(){
    overlay.hidden=true;
    document.body.style.overflow='';
    localStorage.setItem(LSKEY,'1');
  }
  setTimeout(function(){
    overlay.hidden=false;
    document.body.style.overflow='hidden';
  },7000);
  document.getElementById('nlpClose').addEventListener('click',closePopup);
  document.getElementById('nlpSkip').addEventListener('click',closePopup);
  overlay.addEventListener('click',function(e){if(e.target===overlay)closePopup();});
  document.addEventListener('keydown',function(e){if(e.key==='Escape')closePopup();});
  var form=document.getElementById('nlpForm');
  form.addEventListener('submit',function(e){
    e.preventDefault();
    var msg=document.getElementById('nlpMsg');
    var btn=form.querySelector('button[type=submit]');
    var email=form.querySelector('input[name=email]');
    if(!email.value.trim()){email.focus();return;}
    btn.disabled=true;
    fetch('<?= e(rtrim(BASE_PATH,'/')) ?>/bulten-abone.php',{method:'POST',body:new FormData(form)})
      .then(function(r){return r.json();})
      .then(function(d){
        msg.hidden=false;
        msg.className='nlp-msg '+(d.ok?'nlp-ok':'nlp-err');
        msg.textContent=d.mesaj||d.error||'Hata oluştu.';
        if(d.ok){form.reset();setTimeout(closePopup,3000);}
        btn.disabled=false;
      })
      .catch(function(){
        msg.hidden=false;msg.className='nlp-msg nlp-err';
        msg.textContent='<?= e(t('bulten.err','Bağlantı hatası. Lütfen tekrar deneyin.')) ?>';
        btn.disabled=false;
      });
  });
})();
</script>
</body>
</html>
