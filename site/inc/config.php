<?php
/**
 * ANAHTAR TESLİM SERA — Site yapılandırması
 * ------------------------------------------------------------------
 * Sitedeki bütün değişken bilgi bu dosyada toplanır.
 * Yayına almadan önce YAPILACAK olarak işaretli satırları doldurun.
 */

// --- Alan adı ve kurulum ------------------------------------------------
// Sondaki eğik çizgi OLMADAN yazın.
define('SITE_URL',  'https://www.anahtarteslimsera.com');

// Site alan adının kökünde ise boş bırakın.
// Alt klasöre kurarsanız örn: '/sera'
define('BASE_PATH', '');

define('SITE_NAME',    'Anahtar Teslim Sera');
define('SITE_TAGLINE', 'Entegre Tarım Çözümleri');
define('SITE_LOCALE',  'tr_TR');

// CSS/JS önbelleğini kırmak için: dosyaları her değiştirdiğinizde artırın.
define('ASSET_VER', '1.0.0');

// --- İletişim -----------------------------------------------------------
define('CONTACT_PHONE',         '+90 533 471 20 80');
define('CONTACT_PHONE_DISPLAY', '0 (533) 471 20 80');
define('CONTACT_WHATSAPP',      '905334712080');
define('CONTACT_EMAIL',         'bilgi@anahtarteslimsera.com');
define('CONTACT_ADDRESS',       'Konak / İzmir');
define('CONTACT_MAPS_URL',      '');               // Google Maps paylaşım bağlantısı — sonra ekle

// Teklif formunun düşeceği kutu (birden fazlaysa virgülle ayırın)
define('FORM_TO',      'bilgi@anahtarteslimsera.com');
define('FORM_FROM',    'site@anahtarteslimsera.com'); // alan adına ait olmalı, SPF için şart
define('FORM_SUBJECT', 'Yeni teklif talebi — anahtarteslimsera.com');

// --- Ölçümleme ----------------------------------------------------------
// Boş bırakılırsa etiketler basılmaz.
define('GA4_ID',              '');  // örn: G-XXXXXXXXXX
define('GSC_VERIFICATION',    '');  // Search Console meta doğrulama kodu
define('META_PIXEL_ID',       '');  // Facebook / Instagram reklamları için

// --- Sosyal -------------------------------------------------------------
define('SOCIAL_FACEBOOK',  '');
define('SOCIAL_INSTAGRAM', '');
define('SOCIAL_YOUTUBE',   '');
define('SOCIAL_LINKEDIN',  '');

// --- Çözüm ortakları ----------------------------------------------------
const PARTNERS = [
    'prtarim' => [
        'name'  => 'PR Tarım',
        'role'  => 'Tarımsal danışmanlık',
        'slug'  => 'tarimsal-danismanlik',
        'hue'   => 'agro',
        'short' => 'Fizibilite, ürün planı, bitki besleme ve hibe dosyası.',
    ],
    'ozdemirler' => [
        'name'  => 'Özdemirler Sera',
        'role'  => 'Sera kurulumu',
        'slug'  => 'sera-kurulumu',
        'hue'   => 'steel',
        'short' => 'Galvaniz çelik konstrüksiyon, örtü sistemi, iklimlendirme ve montaj.',
    ],
    'irriga' => [
        'name'  => 'İrriga Mühendislik',
        'role'  => 'Sulama sistemleri',
        'slug'  => 'sulama-sistemleri',
        'hue'   => 'water',
        'short' => 'Damla sulama, fertigasyon, filtre istasyonu ve otomasyon.',
    ],
];

// --- Görsel envanteri ---------------------------------------------------
// picture() yardımcısı buradan srcset üretir.
// [ 'w' => native genişlik, 'h' => native yükseklik, 'sizes' => üretilmiş genişlikler ]
const IMAGES = [
    'sera-kompleksi-havadan'       => ['w' => 1376, 'h' => 768, 'sizes' => [480, 800, 1200, 1376]],
    'sera-ic-mekan-domates'        => ['w' => 1376, 'h' => 768, 'sizes' => [480, 800, 1200, 1376]],
    'celik-konstruksiyon-montaj'   => ['w' => 1376, 'h' => 768, 'sizes' => [480, 800, 1200, 1376]],
    'sera-alacakaranlik'           => ['w' => 1376, 'h' => 768, 'sizes' => [480, 800, 1200, 1376]],
    'plastik-tunel-sera'           => ['w' => 1376, 'h' => 768, 'sizes' => [480, 800, 1200, 1376]],
    'fertigasyon-filtre-istasyonu' => ['w' => 1200, 'h' => 896, 'sizes' => [480, 800, 1200]],
    'damla-sulama-damlatici'       => ['w' => 1200, 'h' => 896, 'sizes' => [480, 800, 1200]],
    'tarimsal-danismanlik-agronom' => ['w' => 1200, 'h' => 896, 'sizes' => [480, 800, 1200]],
];

// --- Görsel künyesi -----------------------------------------------------
// Şu an sitedeki fotoğraflar temsilidir. Gerçek saha fotoğrafları
// yüklendiğinde bunu false yapın; "Temsili görsel" rozetleri kaybolur.
define('IMAGES_ARE_PLACEHOLDER', true);
