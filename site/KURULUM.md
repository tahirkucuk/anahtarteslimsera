# Anahtar Teslim Sera — Kurulum ve Geliştirme Notları

Natro / cPanel paylaşımlı hosting için hazırlanmış, bağımlılıksız PHP sitesi.
Composer yok, Node yok, veritabanı zorunlu değil. Dosyaları yükleyip
`inc/config.php` dosyasını doldurduğunuzda çalışır.

---

## 1. Gereksinimler

| | |
|---|---|
| PHP | 8.1+ önerilir · 7.4 minimum (uyumluluk katmanı var) |
| Apache modülleri | `mod_rewrite` (zorunlu), `mod_deflate` ve `mod_expires` (önerilir) |
| PHP eklentileri | `mbstring` (zorunlu), `json` (zorunlu) |
| Veritabanı | Gerekmez — panelinizi bağlarken eklenecek |

cPanel → **MultiPHP Manager** üzerinden alan adının PHP sürümünü seçebilirsiniz.

---

## 2. Dosya yapısı

```
/
├── index.php               Ana sayfa
├── surec.php               Süreç
├── projeler.php            Projeler / referanslar
├── iletisim.php            İletişim + teklif formu
├── tesekkurler.php         Form sonrası teşekkür sayfası
├── gizlilik.php            KVKK aydınlatma metni (taslak)
├── 404.php                 Hata sayfası
├── sitemap.php             /sitemap.xml olarak sunulur
├── robots.txt
├── favicon.svg
├── .htaccess               Temiz adresler, güvenlik, önbellek
├── dev-router.php          Yerel geliştirme sunucusu için
│
├── hizmetler/
│   ├── index.php
│   ├── anahtar-teslim-sera.php
│   ├── tarimsal-danismanlik.php
│   ├── sera-kurulumu.php
│   └── sulama-sistemleri.php
│
├── blog/
│   ├── index.php           Yazı listesi
│   └── yazi.php            Tekil yazı (?slug= ile)
│
├── inc/                    ← tarayıcıdan erişilemez
│   ├── config.php          ★ AYARLAR — önce burayı doldurun
│   ├── bootstrap.php       Ortak başlatma
│   ├── functions.php       Yardımcılar (e(), url(), picture(), csrf…)
│   ├── data.php            ★ İÇERİK — panel entegrasyon noktası
│   ├── seo.php             Meta etiketleri + JSON-LD
│   ├── header.php          Üst şablon
│   ├── footer.php          Alt şablon
│   └── tpl-service.php     Hizmet sayfası şablonu
│
├── api/
│   └── teklif.php          Form işleyicisi (★ PANEL KANCASI burada)
│
├── content/blog/           Yazı gövdeleri (.html)
├── storage/leads/          Gelen talepler (JSONL) — dışarı kapalı
└── assets/
    ├── css/site.css
    ├── js/site.js
    └── img/                Duyarlı görseller (jpg + webp, 4 boyut)
```

---

## 3. cPanel'e yükleme

1. cPanel → **File Manager** → `public_html` klasörünü açın.
2. Bu klasörün içeriğini (kök klasörün kendisini değil, **içindekileri**) yükleyin.
   Zip yüklerseniz File Manager içinde **Extract** edin.
3. **Gizli dosyaları görünür yapın:** Settings → *Show Hidden Files*. `.htaccess`
   yüklenmiş olmalı; yoksa tekrar yükleyin.
4. Klasör izinleri: klasörler `755`, dosyalar `644`.
   `storage/` klasörünün yazılabilir olduğundan emin olun (`755`, gerekirse `775`).
5. cPanel → **SSL/TLS Status** → sertifikayı kurun (AutoSSL genelde otomatiktir).
6. Sertifika aktifken `.htaccess` içindeki **1. bölümdeki iki satırın** başındaki
   `#` işaretini kaldırın (HTTPS zorunlu). Ardından **2. bölümde** www'lu ya da
   www'suz adresten **yalnızca birini** açın.

---

## 4. Yayına almadan önce doldurulacaklar

Tamamı `inc/config.php` içinde, `YAPILACAK` olarak işaretli:

- [ ] `SITE_URL` — gerçek alan adı (sonda `/` yok)
- [ ] `CONTACT_PHONE`, `CONTACT_PHONE_DISPLAY`, `CONTACT_WHATSAPP`
- [ ] `CONTACT_EMAIL`, `CONTACT_ADDRESS`, `CONTACT_MAPS_URL`
- [ ] `FORM_TO` — teklif taleplerinin düşeceği kutu
- [ ] `FORM_FROM` — **alan adına ait** bir adres olmalı (SPF için şart, aksi
      hâlde mailler spam'e düşer)
- [ ] `GA4_ID` ve `GSC_VERIFICATION`
- [ ] Sosyal medya adresleri
- [ ] `robots.txt` içindeki `Sitemap:` satırındaki alan adı
- [ ] `gizlilik.php` — hukuk müşavirinden gelecek metinle değiştirin
- [ ] Gerçek saha fotoğrafları yüklendiğinde `IMAGES_ARE_PLACEHOLDER` → `false`
      (bütün "Temsili görsel" rozetleri tek seferde kaybolur)

> **Tek muhatap uyarısı:** İletişim bilgisi olarak üç ayrı numara koymayın.
> Sitenin bütün argümanı tek muhatap vaadi üzerine kurulu; üç numara bu vaadi çürütür.

---

## 5. İçerik nasıl düzenlenir

Sitedeki bütün dinamik içerik `inc/data.php` içindedir ve şablonlar veriye
**yalnızca** bu dosyadaki fonksiyonlardan erişir.

| Fonksiyon | Neyi yönetir |
|---|---|
| `get_services()` | Hizmet sayfaları: başlık, açıklama, madde listesi, meta etiketleri |
| `get_process()` | Süreç aşamaları, süreleri ve sorumlu firma |
| `get_types()` | Sera tipi karşılaştırma tablosu |
| `get_projects()` | Proje / referans künyeleri |
| `get_posts()` / `get_post()` | Blog yazılarının künyesi; gövde `content/blog/<slug>.html` |
| `get_faqs()` | Sık sorulan sorular (Google SSS zenginleştirmesini de besler) |

### Yeni blog yazısı eklemek

1. `content/blog/yeni-yazi-adresi.html` dosyasını oluşturun — **sadece gövde
   HTML'i** yazın (`<h2>`, `<p>`, `<ul>`, `<div class="callout">`…).
   İç bağlantılarda site kökü için `{{u}}` yazın: `href="{{u}}/hizmetler"`.
2. `inc/data.php` içindeki `get_posts()` dizisine künyeyi ekleyin.
3. Yazı otomatik olarak listeye, site haritasına ve JSON-LD'ye girer.

### Yeni görsel eklemek

Görseller `assets/img/` içinde `ad-genislik.jpg` ve `.webp` olarak durur
(480 / 800 / 1200 / orijinal). Yeni bir görsel eklerken aynı boyutları üretin ve
`inc/config.php` içindeki `IMAGES` dizisine kaydı ekleyin:

```php
'yeni-gorsel-adi' => ['w' => 1600, 'h' => 900, 'sizes' => [480, 800, 1200, 1600]],
```

Şablonda kullanımı:

```php
<?= picture('yeni-gorsel-adi', 'Alternatif metin', ['sizes' => '(max-width:900px) 92vw, 33vw']) ?>
```

`alt` metni zorunludur — hem erişilebilirlik hem görsel araması için.

---

## 6. Kendi panelinizi bağlamak

Site, panelinizi bekleyecek şekilde kurgulandı. Dokunacağınız **iki nokta** var.

### 6.1 İçerik okuma — `inc/data.php`

Her fonksiyonun gövdesini veritabanı sorgusuyla değiştirin, **dönüş şemasını
aynen koruyun**. Şablonlarda hiçbir değişiklik gerekmez. Örnek:

```php
function get_projects(int $limit = 0): array
{
    $pdo = db();                       // kendi bağlantınız
    $sql = 'SELECT * FROM projeler WHERE yayinda = 1 ORDER BY sira ASC';
    if ($limit > 0) { $sql .= ' LIMIT ' . (int) $limit; }

    $rows = [];
    foreach ($pdo->query($sql) as $r) {
        $rows[] = [
            'slug'  => $r['slug'],
            'title' => $r['baslik'],
            'image' => $r['gorsel'],
            'hue'   => $r['renk'],
            'scope' => $r['kapsam'],
            'featured' => (bool) $r['one_cikan'],
            'meta'  => json_decode($r['kunye'], true),   // ['Konum'=>'…', …]
        ];
    }
    return $rows;
}
```

Her fonksiyonun beklediği anahtarlar `inc/data.php` içinde, fonksiyonun üstünde
yorum olarak yazılıdır.

### 6.2 Talep yazma — `api/teklif.php`

Dosyanın içinde `===== PANEL KANCASI =====` ile işaretli blok var. Şu an talebi
`storage/leads/YYYY-MM.jsonl` dosyasına ekliyor. Onu veritabanı yazımıyla
değiştirin; `$lead` dizisi hazır gelir.

Önerilen tablo şeması:

```sql
CREATE TABLE teklif_talepleri (
  id           BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  ref          VARCHAR(32)  NOT NULL UNIQUE,   -- $lead['id']
  created_at   DATETIME     NOT NULL,
  ad           VARCHAR(120) NOT NULL,
  telefon      VARCHAR(40)  NOT NULL,
  eposta       VARCHAR(160) NULL,
  sehir        VARCHAR(120) NOT NULL,
  alan         DECIMAL(10,2) NULL,             -- dekar
  urun         VARCHAR(80)  NULL,
  kapsam       JSON         NOT NULL,          -- seçilen kapsamlar
  notlar       TEXT         NULL,
  ekip         VARCHAR(120) NOT NULL,          -- yönlendirilen firma(lar)
  kaynak       VARCHAR(300) NULL,              -- geldiği sayfa
  ip           VARCHAR(45)  NULL,
  ua           VARCHAR(250) NULL,
  durum        ENUM('yeni','arandi','teklif_verildi','kazanildi','kaybedildi')
               NOT NULL DEFAULT 'yeni',
  atanan       VARCHAR(80)  NULL,
  INDEX (created_at), INDEX (durum), INDEX (sehir)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;
```

`route_team()` fonksiyonu, seçilen kapsama göre talebi hangi firmaya
yönlendireceğini zaten hesaplıyor — panelde atama alanının varsayılanı olarak
kullanabilirsiniz.

### 6.3 Panelin kendisi

Paneli `/panel/` altına koyup kendi oturum yönetiminizi kullanabilirsiniz.
`.htaccess` içindeki `RedirectMatch 404 ^/(inc|storage|content)/` satırı panelinizi
etkilemez. Panel `inc/config.php` ve `inc/functions.php` dosyalarını
`require` ederek aynı yardımcıları kullanabilir.

---

## 7. SEO kurulumu

Site tarafında hazır olanlar:

- Sayfa bazlı `<title>`, `description`, `canonical`, Open Graph, Twitter Card
- JSON-LD: `ProfessionalService`, `BreadcrumbList`, `Service`, `FAQPage`,
  `Article`, `HowTo`
- Duyarlı görseller (`srcset` + WebP), `width`/`height` ile CLS koruması
- `/sitemap.xml` (içerik eklendikçe kendini günceller) ve `robots.txt`
- Temiz adresler + `.php` uzantılı adreslerden 301 yönlendirme

Yapılacaklar:

1. **Search Console**: alan adını ekleyin → doğrulama kodunu `GSC_VERIFICATION`
   sabitine yazın → `sitemap.xml` adresini gönderin.
2. **Google Analytics 4**: ölçüm kimliğini `GA4_ID` sabitine yazın.
3. **Google Business Profile**: işletme kaydını açın; adres ve telefon bilgisi
   sitedekiyle **birebir aynı** olsun (NAP tutarlılığı yerel aramada belirleyici).
4. **PageSpeed Insights** ile mobil skoru ölçün. Fontlar Google'dan geldiği için
   ilk yüklemede küçük bir gecikme olur; skoru yükseltmek isterseniz
   `assets/fonts/` klasörüne woff2 dosyalarını indirip `inc/header.php` içindeki
   `<link>` satırını yerel `@font-face` tanımlarıyla değiştirin.

---

## 8. Form ve güvenlik

Teklif formunda hazır olanlar:

- CSRF anahtarı (oturum bazlı)
- Bal küpü (honeypot) alanı ve 3 saniye altı gönderim engeli
- Aynı oturumdan 60 saniye içinde ikinci gönderim engeli
- Sunucu tarafı doğrulama + başlık enjeksiyonu koruması
- KVKK onay kutusu (zorunlu)

**Mail gitmiyorsa** sırayla kontrol edin:

1. `FORM_FROM` alan adına ait mi? (`site@alanadiniz.com.tr` gibi)
2. cPanel → **Email Deliverability** → SPF ve DKIM kayıtları yeşil mi?
3. cPanel → **Track Delivery** ile gönderimi izleyin.
4. Sorun sürerse `mail()` yerine SMTP kullanın: `api/teklif.php` içindeki
   `@mail(...)` çağrısını PHPMailer ile değiştirin (cPanel'de bir e-posta hesabı
   açıp onun SMTP bilgilerini kullanmak en güvenilir yoldur).

Gelen talepler ayrıca `storage/leads/YYYY-MM.jsonl` dosyasına yazılır; mail
gitmese bile talep kaybolmaz. Bu klasör `.htaccess` ile dışarıya kapalıdır.

---

## 9. Yerel geliştirme (IDE)

Apache kurmadan, proje klasöründe:

```bash
php -S localhost:8000 dev-router.php
```

`dev-router.php`, `.htaccess`'teki temiz adres kurallarını taklit eder.
Geliştirirken hataları görmek için `inc/bootstrap.php` içinde:

```php
ini_set('display_errors', '1');
error_reporting(E_ALL);
```

Yayına alırken bu iki satırı eski hâline döndürmeyi unutmayın.

CSS veya JS değiştirdiğinizde `inc/config.php` içindeki `ASSET_VER` değerini
artırın — ziyaretçilerin tarayıcı önbelleği böylece temizlenir.

---

## 10. Bilinen eksikler / sonraki adımlar

- **Proje künyeleri ve fotoğraflar** yer tutucudur (`get_projects()`).
  Gerçek verilerle değiştirilmeli.
- **Görsellerin tamamı temsilidir.** Sahadan gelen fotoğraflarla değiştirin ve
  `IMAGES_ARE_PLACEHOLDER` değerini `false` yapın.
- **KVKK metni taslaktır**; veri sorumlusu ve saklama süreleri hukuk müşaviri
  tarafından kesinleştirilmeli.
- **Teknik aralıklar** (oluk yüksekliği, kar yükü, debi, süreler) sektörde makul
  değerlerdir ancak firmalarınızın kendi değerleriyle doğrulanmalıdır.
- **Amortisman / geri ödeme hesaplayıcısı** henüz yok. Eklenecekse
  `hizmetler/` altında ayrı bir sayfa olarak kurulup forma bağlanması,
  katsayıların da `inc/data.php` üzerinden yönetilmesi öneriliyor.
