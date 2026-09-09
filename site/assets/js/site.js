/* Anahtar Teslim Sera — arayüz betikleri. Bağımlılık yok. */
(function () {
  'use strict';

  /* --- mobil menü --- */
  var toggle = document.querySelector('.nav-toggle');
  var nav    = document.getElementById('ana-menu');

  if (toggle && nav) {
    toggle.addEventListener('click', function () {
      var open = nav.classList.toggle('open');
      toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
      toggle.setAttribute('aria-label', open ? 'Menüyü kapat' : 'Menüyü aç');
    });

    // Menü dışına tıklayınca kapat
    document.addEventListener('click', function (e) {
      if (!nav.classList.contains('open')) return;
      if (nav.contains(e.target) || toggle.contains(e.target)) return;
      nav.classList.remove('open');
      toggle.setAttribute('aria-expanded', 'false');
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && nav.classList.contains('open')) {
        nav.classList.remove('open');
        toggle.setAttribute('aria-expanded', 'false');
        toggle.focus();
      }
    });
  }

  /* --- teklif formu: gönderim öncesi istemci tarafı kontrol --- */
  var form = document.getElementById('teklif-form');
  if (!form) return;

  form.addEventListener('submit', function (e) {
    var eksik = [];
    ['ad', 'telefon', 'sehir'].forEach(function (n) {
      var el = form.elements[n];
      if (el && !el.value.trim()) eksik.push(el.dataset.label || n);
    });

    var kapsam = form.querySelectorAll('input[name="kapsam[]"]:checked');
    if (kapsam.length === 0) eksik.push('İlgilendiğiniz kapsam');

    if (eksik.length) {
      e.preventDefault();
      var box = document.getElementById('form-uyari');
      if (box) {
        box.innerHTML = '<strong>Eksik alan var:</strong> ' + eksik.join(', ');
        box.hidden = false;
        box.scrollIntoView({ behavior: 'smooth', block: 'center' });
      }
      return;
    }

    // Çift gönderimi engelle
    var btn = form.querySelector('button[type="submit"]');
    if (btn) {
      btn.disabled = true;
      btn.textContent = 'Gönderiliyor…';
    }
  });
})();
