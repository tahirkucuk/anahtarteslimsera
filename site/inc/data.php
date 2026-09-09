<?php
/**
 * İÇERİK KATMANI — PANEL ENTEGRASYON NOKTASI
 * ==================================================================
 * Sitedeki bütün dinamik içerik yalnızca aşağıdaki fonksiyonlardan okunur.
 * Şablonlar veriye başka hiçbir yerden erişmez.
 *
 * Kendi yönetim panelinizi bağlarken:
 *   1. Her fonksiyonun GÖVDESİNİ veritabanı sorgusuyla değiştirin.
 *   2. DÖNÜŞ ŞEMASINI (aşağıdaki anahtar isimleri) aynen koruyun.
 *   3. Şablonlarda hiçbir değişiklik gerekmez.
 *
 * Şemalar her fonksiyonun üstünde yazılıdır.
 */

// ======================================================================
// HİZMETLER
// Şema: slug, title, partner (PARTNERS anahtarı ya da null), lead,
//       image, bullets[], meta_title, meta_desc
// ======================================================================
function get_services(): array
{
    return [
        'anahtar-teslim-sera' => [
            'slug'    => 'anahtar-teslim-sera',
            'title'   => 'Anahtar Teslim Sera Çözümü',
            'partner' => null,
            'image'   => 'sera-kompleksi-havadan',
            'lead'    => 'Arazi etüdünden ilk hasat sezonunun sonuna kadar tek sözleşme. Üç firma tek proje müdürü altında çalışır; teslim tarihini ve teknik performansı birlikte taahhüt eder.',
            'bullets' => [
                'Arazi, toprak ve su kaynağı etüdü',
                'Ürün seçimi ve verim modellemesi',
                'Sera tipi kararı ve statik proje',
                'Isıtma ve iklimlendirme tasarımı',
                'Damla sulama ve fertigasyon projesi',
                'Otomasyon ve uzaktan izleme kurulumu',
                'Hibe / IPARD dosyası ve teknik ekler',
                'Montaj, test ve devreye alma',
                'Personel eğitimi ve kullanım kılavuzu',
                'İlk sezon agronomik takip',
            ],
            'meta_title' => 'Anahtar Teslim Sera Kurulumu | Danışmanlık, Kurulum ve Sulama Tek Sözleşmede',
            'meta_desc'  => 'Fizibiliteden ilk hasada kadar anahtar teslim sera kurulumu. Tarımsal danışmanlık, çelik konstrüksiyon ve sulama otomasyonu tek proje müdürü altında, tek takvimle.',
        ],
        'tarimsal-danismanlik' => [
            'slug'    => 'tarimsal-danismanlik',
            'title'   => 'Tarımsal Danışmanlık',
            'partner' => 'prtarim',
            'image'   => 'tarimsal-danismanlik-agronom',
            'lead'    => 'Yatırımın verim ve pazar tarafı. Ne ekileceği, hangi verimle ve hangi maliyetle üretileceği kurulumdan önce netleşir. Sera tipini ve sulama debisini belirleyen kararlar bu aşamada alınır.',
            'bullets' => [
                'Ürün ve pazar fizibilitesi',
                'Toprak, sulama suyu ve iklim analizi',
                'Bitki besleme ve yetiştirme programı',
                'Hibe / IPARD dosya hazırlığı',
                'İşletme planı ve maliyet modeli',
                'İlk sezon agronomik saha takibi',
            ],
            'meta_title' => 'Sera Yatırımı Danışmanlığı | Fizibilite, Verim Planı ve Hibe Dosyası',
            'meta_desc'  => 'Sera yatırımı için tarımsal danışmanlık: ürün ve pazar fizibilitesi, toprak ve su analizi, bitki besleme programı, IPARD hibe dosyası ve işletme planı.',
        ],
        'sera-kurulumu' => [
            'slug'    => 'sera-kurulumu',
            'title'   => 'Sera Kurulumu',
            'partner' => 'ozdemirler',
            'image'   => 'celik-konstruksiyon-montaj',
            'lead'    => 'Yapının kendisi. Galvaniz çelik konstrüksiyon, örtü sistemi, ısıtma ve havalandırma; statik hesaptan saha montajına kadar tek elden.',
            'bullets' => [
                'Galvaniz çelik konstrüksiyon imalatı',
                'Venlo cam, polikarbon ve plastik tünel sera',
                'Isıtma, havalandırma ve gölgeleme sistemleri',
                'Kar ve rüzgâr yüküne göre statik hesap',
                'Zemin hazırlığı ve temel uygulaması',
                'Saha montajı, test ve teslim',
            ],
            'meta_title' => 'Modern Sera Kurulumu | Venlo Cam, Polikarbon ve Plastik Tünel Sera',
            'meta_desc'  => 'Galvaniz çelik konstrüksiyonlu modern sera kurulumu. Venlo cam, polikarbon ve plastik tünel sera tipleri; statik hesap, ısıtma-havalandırma ve saha montajı.',
        ],
        'sulama-sistemleri' => [
            'slug'    => 'sulama-sistemleri',
            'title'   => 'Sulama Sistemleri',
            'partner' => 'irriga',
            'image'   => 'fertigasyon-filtre-istasyonu',
            'lead'    => 'Suyun bitkiye ulaştığı hat. Pompa kapasitesinden damlatıcı debisine kadar her kalem, sera açıklığı ve bitki sıra sayısıyla birlikte hesaplanır.',
            'bullets' => [
                'Damla sulama projesi ve montajı',
                'Fertigasyon (gübreleme) ünitesi',
                'Kum ve disk filtre istasyonu, pompa grubu',
                'Sulama otomasyonu ve sensörler',
                'Uzaktan izleme ve raporlama',
                'Devreye alma ve kullanıcı eğitimi',
            ],
            'meta_title' => 'Sera Sulama Otomasyonu ve Damla Sulama Sistemleri',
            'meta_desc'  => 'Sera ve tarla için damla sulama, fertigasyon ünitesi, filtre istasyonu ve sulama otomasyonu. Proje, montaj, devreye alma ve uzaktan izleme.',
        ],
    ];
}

function get_service(string $slug): ?array
{
    return get_services()[$slug] ?? null;
}

// ======================================================================
// SÜREÇ AŞAMALARI
// Şema: no, title, body, owner, duration, hue
// ======================================================================
function get_process(): array
{
    return [
        ['no' => '01', 'hue' => 'agro',  'owner' => 'PR Tarım',        'duration' => '2 – 4 hafta',
         'title' => 'Keşif ve fizibilite',
         'body'  => 'Arazi ziyareti, toprak ve sulama suyu analizi, iklim verisi. Hangi ürünün, hangi verimle ve hangi pazara üretileceğine karar verilir. Çıktı: yatırım büyüklüğü ve hedef verim.'],

        ['no' => '02', 'hue' => 'canopy','owner' => 'Üç firma ortak',  'duration' => '3 – 5 hafta',
         'title' => 'Proje, şartname ve teklif',
         'body'  => 'Ürün planına göre sera tipi, oluk yüksekliği, ısıtma kapasitesi ve sulama debisi birlikte belirlenir. Tek teknik şartname, tek fiyat, tek takvim. Gerekiyorsa hibe dosyası bu aşamada hazırlanır.'],

        ['no' => '03', 'hue' => 'steel', 'owner' => 'Özdemirler Sera', 'duration' => '10 – 20 hafta',
         'title' => 'Konstrüksiyon ve montaj',
         'body'  => 'Zemin hazırlığı, temel, galvaniz çelik montajı, örtü sistemi, ısıtma ve havalandırma ekipmanlarının kurulumu. Sulama hatlarının geçeceği güzergâhlar bu aşamada hazır bırakılır.'],

        ['no' => '04', 'hue' => 'water', 'owner' => 'İrriga',          'duration' => '3 – 6 hafta',
         'title' => 'Sulama, fertigasyon ve otomasyon',
         'body'  => 'Pompa grubu, filtre istasyonu, ana ve tali hatlar, damlatıcı serimi, gübreleme ünitesi ve kontrol panosu. Sistem basınç ve debi testleriyle teslim edilir.'],

        ['no' => '05', 'hue' => 'canopy','owner' => 'PR Tarım + Servis','duration' => '12 ay',
         'title' => 'Devreye alma ve ilk sezon takibi',
         'body'  => 'Personel eğitimi, dikim planının uygulanması, besleme programının sahada kalibre edilmesi. İlk üretim sezonu boyunca periyodik agronomik kontrol ve teknik servis.'],
    ];
}

// ======================================================================
// SERA TİPLERİ
// Şema: name, light, gutter, snow, crops, level, hue, bars{light,gutter,snow}
// ======================================================================
function get_types(): array
{
    return [
        ['name' => 'Venlo cam sera', 'hue' => 'canopy',
         'light' => '%89 – 92', 'gutter' => '4,5 – 6,5 m', 'snow' => '40 – 75 kg/m²',
         'crops' => 'Domates, salatalık, süs bitkisi', 'level' => 'Yüksek',
         'bars'  => ['light' => 95, 'gutter' => 88, 'snow' => 62]],

        ['name' => 'Polikarbon sera', 'hue' => 'steel',
         'light' => '%80 – 83', 'gutter' => '4,0 – 5,5 m', 'snow' => '60 – 90 kg/m²',
         'crops' => 'Fide üretimi, tıbbi bitkiler, çelik', 'level' => 'Orta – yüksek',
         'bars'  => ['light' => 82, 'gutter' => 74, 'snow' => 80]],

        ['name' => 'Plastik tünel (çift kat PE)', 'hue' => 'water',
         'light' => '%85 – 88', 'gutter' => '3,0 – 4,5 m', 'snow' => '25 – 40 kg/m²',
         'crops' => 'Domates, biber, çilek, yeşillik', 'level' => 'Orta',
         'bars'  => ['light' => 88, 'gutter' => 56, 'snow' => 38]],
    ];
}

// ======================================================================
// PROJELER / REFERANSLAR
// Şema: slug, title, image, scope, hue, featured(bool),
//       meta[] => ['Konum'=>'…','Kapalı alan'=>'…', …]
//
// YAPILACAK: aşağıdaki üç kayıt yer tutucudur. Gerçek proje künyeleri
// ve saha fotoğrafları geldiğinde bunları değiştirin.
// ======================================================================
function get_projects(int $limit = 0): array
{
    $rows = [
        [
            'slug'  => 'anahtar-teslim-domates-serasi',
            'title' => 'Anahtar teslim domates serası',
            'image' => 'sera-ic-mekan-domates',
            'hue'   => 'agro',
            'scope' => 'Danışmanlık + Kurulum + Sulama',
            'featured' => true,
            'meta'  => [
                'Konum'       => '—',
                'Kapalı alan' => '— dekar',
                'Sera tipi'   => 'Venlo cam',
                'Teslim'      => '—',
            ],
        ],
        [
            'slug'  => 'fide-uretim-tesisi',
            'title' => 'Fide üretim tesisi',
            'image' => 'plastik-tunel-sera',
            'hue'   => 'steel',
            'scope' => 'Kurulum + Sulama',
            'featured' => true,
            'meta'  => [
                'Konum'       => '—',
                'Kapalı alan' => '— dekar',
                'Sera tipi'   => 'Plastik tünel',
                'Teslim'      => '—',
            ],
        ],
        [
            'slug'  => 'acik-arazi-damla-sulama',
            'title' => 'Açık arazi damla sulama',
            'image' => 'damla-sulama-damlatici',
            'hue'   => 'water',
            'scope' => 'Yalnızca sulama',
            'featured' => true,
            'meta'  => [
                'Konum'        => '—',
                'Sulanan alan' => '— dekar',
                'Sistem'       => 'Damla + fertigasyon',
                'Teslim'       => '—',
            ],
        ],
    ];

    return $limit > 0 ? array_slice($rows, 0, $limit) : $rows;
}

// ======================================================================
// BLOG
// Şema: slug, title, date (Y-m-d), author, category, image, excerpt,
//       meta_title, meta_desc
// Yazının gövdesi: content/blog/<slug>.html
// ======================================================================
function get_posts(int $limit = 0): array
{
    $rows = [
        [
            'slug'     => 'sera-sulama-otomasyonunun-onemi',
            'title'    => 'Modern seralarda sulama otomasyonunun önemi',
            'date'     => '2026-08-18',
            'author'   => 'İrriga Mühendislik',
            'category' => 'Sulama',
            'image'    => 'damla-sulama-damlatici',
            'excerpt'  => 'Otomasyon, sulamayı "kolaylaştıran" bir konfor değil; kök bölgesindeki nem ve tuzluluk dalgalanmasını kapatan bir üretim aracıdır. Elle sulanan serada verimin neden dalgalandığını açıklıyoruz.',
            'meta_title' => 'Modern Seralarda Sulama Otomasyonunun Önemi',
            'meta_desc'  => 'Sera sulama otomasyonu verimi nasıl etkiler? Kök bölgesi nem dengesi, EC-pH kontrolü, su ve gübre tasarrufu ile elle sulamanın gizli maliyeti.',
        ],
        [
            'slug'     => 'sera-kurmadan-once-5-danismanlik-hizmeti',
            'title'    => 'Sera kurmadan önce bilinmesi gereken 5 danışmanlık hizmeti',
            'date'     => '2026-08-11',
            'author'   => 'PR Tarım',
            'category' => 'Danışmanlık',
            'image'    => 'tarimsal-danismanlik-agronom',
            'excerpt'  => 'Sera yatırımlarında en pahalı hatalar inşaat aşamasında değil, ondan önceki karar aşamasında yapılır. Çelik kesilmeden önce cevaplanması gereken beş başlık.',
            'meta_title' => 'Sera Kurmadan Önce Alınması Gereken 5 Danışmanlık Hizmeti',
            'meta_desc'  => 'Sera yatırımı öncesi fizibilite, su analizi, ürün seçimi, hibe uygunluğu ve işletme planı. Çelik kesilmeden önce cevaplanması gereken beş soru.',
        ],
        [
            'slug'     => 'anahtar-teslim-sera-kurulumu-maliyetleri',
            'title'    => 'Anahtar teslim sera kurulumu maliyetleri nelerdir?',
            'date'     => '2026-08-04',
            'author'   => 'Anahtar Teslim Sera',
            'category' => 'Yatırım',
            'image'    => 'celik-konstruksiyon-montaj',
            'excerpt'  => 'Metrekare fiyatı sormak yanlış soru. Maliyeti belirleyen beş kalemi ve bunların hangi kararla değiştiğini, teklif karşılaştırırken nelere bakılacağıyla birlikte anlatıyoruz.',
            'meta_title' => 'Anahtar Teslim Sera Kurulumu Maliyetleri Nasıl Hesaplanır?',
            'meta_desc'  => 'Sera kurulumu maliyetini belirleyen kalemler: sera tipi, oluk yüksekliği, statik yük, iklimlendirme ve sulama seviyesi. Teklif karşılaştırma rehberi.',
        ],
        [
            'slug'     => 'dogru-sulama-sistemini-secmenin-puf-noktalari',
            'title'    => 'Sera projenizde doğru sulama sistemini seçmenin püf noktaları',
            'date'     => '2026-07-28',
            'author'   => 'İrriga Mühendislik',
            'category' => 'Sulama',
            'image'    => 'fertigasyon-filtre-istasyonu',
            'excerpt'  => 'Sulama sistemi seçimi damlatıcı markasıyla başlamaz; suyun analiziyle başlar. Filtre seçiminden lateral aralığına kadar kararların hangi sırayla verilmesi gerektiği.',
            'meta_title' => 'Sera İçin Doğru Sulama Sistemi Nasıl Seçilir?',
            'meta_desc'  => 'Sulama suyu analizi, filtre seçimi, damlatıcı debisi ve lateral aralığı. Sera sulama sistemi seçiminde kararların doğru sırası ve sık yapılan hatalar.',
        ],
    ];

    usort($rows, fn($a, $b) => strcmp($b['date'], $a['date']));
    return $limit > 0 ? array_slice($rows, 0, $limit) : $rows;
}

function get_post(string $slug): ?array
{
    foreach (get_posts() as $p) {
        if ($p['slug'] === $slug) {
            $file = dirname(__DIR__) . '/content/blog/' . $slug . '.html';
            $body = is_file($file) ? file_get_contents($file) : '';
            // Yazı içindeki {{u}} işaretçisi site köküne çevrilir; böylece
            // site alt klasöre kurulsa bile iç bağlantılar bozulmaz.
            $p['body'] = str_replace('{{u}}', BASE_PATH, $body);
            return $p;
        }
    }
    return null;
}

// ======================================================================
// SIK SORULAN SORULAR
// Şema: q, a  — FAQPage JSON-LD'si buradan üretilir.
// ======================================================================
function get_faqs(): array
{
    return [
        ['q' => 'Anahtar teslim sera kurulumu maliyeti neye göre değişir?',
         'a' => 'Maliyeti belirleyen üç ana kalem var: sera tipi ve oluk yüksekliği, ısıtma–iklimlendirme kapasitesi, sulama ve otomasyon seviyesi. Arazinin kar ve rüzgâr yükü statik hesabı, dolayısıyla çelik tonajını doğrudan etkiler. Etüt sonrası tek şartname üzerinden kalem kalem fiyatlandırma sunuyoruz.'],

        ['q' => 'Projenin tamamı ne kadar sürüyor?',
         'a' => '20 dekar ölçeğinde tipik bir projede etütten devreye almaya kadar 5 – 9 ay. Süreyi en çok etkileyen kalemler zemin koşulları, ithal ekipman tedarik süresi ve hibe onay takvimidir. Sözleşmede tek teslim tarihi verilir.'],

        ['q' => 'Hibe ve IPARD desteklerinden yararlanabilir miyim?',
         'a' => 'Uygunluk arazinin niteliğine, yatırımcı statüsüne ve dönemin çağrı şartlarına bağlıdır. Fizibilite aşamasında uygunluk kontrolü yapılır ve dosya, kurulum ile sulama şartnameleriyle birebir uyumlu hazırlanır — teknik eklerdeki çelişki en sık ret sebeplerinden biridir.'],

        ['q' => 'Garanti ve servis nasıl işliyor?',
         'a' => 'Anahtar teslim projede tek servis hattı veriyoruz. Konstrüksiyon, ekipman ve sulama sistemi için kalem bazlı garanti süreleri sözleşme ekinde tanımlanır; arıza durumunda muhatabınız yine tek proje müdürüdür.'],

        ['q' => 'Sadece sulama sistemi veya sadece danışmanlık alabilir miyim?',
         'a' => 'Evet. Üç firma kendi alanında bağımsız çalışmaya devam ediyor. Mevcut seranıza sulama otomasyonu kurulması veya yalnızca fizibilite hizmeti almak için de aynı iletişim kanalını kullanabilirsiniz.'],

        ['q' => 'Hangi bölgelerde çalışıyorsunuz?',
         'a' => 'Türkiye genelinde proje yürütüyoruz. Keşif ziyareti ve saha montajı için ekip yönlendirmesi proje büyüklüğüne göre planlanır; iletişim formunda il bilgisini paylaşmanız planlamayı hızlandırır.'],
    ];
}
