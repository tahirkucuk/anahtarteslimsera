<?php
/**
 * İÇERİK KATMANI — Tüm dinamik içerik LANG'e göre döner.
 */

// ======================================================================
// HİZMETLER
// ======================================================================
function get_services(): array
{
    if (defined('LANG') && LANG === 'en') {
        return [
            'anahtar-teslim-sera' => [
                'slug'    => 'anahtar-teslim-sera',
                'title'   => 'Turnkey Greenhouse Solution',
                'partner' => null,
                'image'   => 'sera-kompleksi-havadan',
                'lead'    => 'One contract from land survey to the end of the first harvest season. Three firms work under one project manager, jointly committing to delivery date and technical performance.',
                'bullets' => [
                    'Land, soil and water source survey',
                    'Crop selection and yield modelling',
                    'Greenhouse type decision and structural design',
                    'Heating and climate control design',
                    'Drip irrigation and fertigation project',
                    'Automation and remote monitoring installation',
                    'Grant / IPARD application file and technical annexes',
                    'Assembly, testing and commissioning',
                    'Staff training and user manual',
                    'First-season agronomic monitoring',
                ],
                'meta_title' => 'Turnkey Greenhouse Construction | Consulting, Construction and Irrigation in One Contract',
                'meta_desc'  => 'Turnkey greenhouse construction from feasibility to first harvest. Agricultural consulting, steel structure and irrigation automation under one project manager, on one schedule.',
            ],
            'tarimsal-danismanlik' => [
                'slug'    => 'tarimsal-danismanlik',
                'title'   => 'Agricultural Consulting',
                'partner' => 'prtarim',
                'image'   => 'tarimsal-danismanlik-agronom',
                'lead'    => 'The yield and market side of the investment. What to grow, at what yield and at what cost — all settled before construction begins. The decisions that define greenhouse type and irrigation flow rate happen at this stage.',
                'bullets' => [
                    'Crop and market feasibility',
                    'Soil, irrigation water and climate analysis',
                    'Plant nutrition and growing programme',
                    'Grant / IPARD application file preparation',
                    'Business plan and cost model',
                    'First-season on-site agronomic monitoring',
                ],
                'meta_title' => 'Greenhouse Investment Consulting | Feasibility, Yield Plan and Grant Application',
                'meta_desc'  => 'Agricultural consulting for greenhouse investment: crop and market feasibility, soil and water analysis, plant nutrition programme, IPARD grant application and business plan.',
            ],
            'sera-kurulumu' => [
                'slug'    => 'sera-kurulumu',
                'title'   => 'Greenhouse Construction',
                'partner' => 'ozdemirler',
                'image'   => 'celik-konstruksiyon-montaj',
                'lead'    => 'The structure itself. Galvanized steel frame, cladding system, heating and ventilation — from structural calculation to on-site installation, all from one hand.',
                'bullets' => [
                    'Galvanized steel structure manufacturing',
                    'Venlo glass, polycarbonate and plastic tunnel greenhouses',
                    'Heating, ventilation and shading systems',
                    'Structural calculations for snow and wind loads',
                    'Ground preparation and foundation works',
                    'Site installation, testing and handover',
                ],
                'meta_title' => 'Modern Greenhouse Construction | Venlo Glass, Polycarbonate and Plastic Tunnel',
                'meta_desc'  => 'Modern greenhouse construction with galvanized steel structure. Venlo glass, polycarbonate and plastic tunnel types; structural calculation, heating/ventilation and site installation.',
            ],
            'sulama-sistemleri' => [
                'slug'    => 'sulama-sistemleri',
                'title'   => 'Irrigation Systems',
                'partner' => 'irriga',
                'image'   => 'fertigasyon-filtre-istasyonu',
                'lead'    => 'The line that delivers water to the plant. From pump capacity to dripper flow rate, every component is calculated together with the greenhouse bay width and plant row count.',
                'bullets' => [
                    'Drip irrigation design and installation',
                    'Fertigation (liquid fertilization) unit',
                    'Sand and disc filter station, pump group',
                    'Irrigation automation and sensors',
                    'Remote monitoring and reporting',
                    'Commissioning and user training',
                ],
                'meta_title' => 'Greenhouse Irrigation Automation and Drip Irrigation Systems',
                'meta_desc'  => 'Drip irrigation, fertigation unit, filter station and irrigation automation for greenhouses and open fields. Design, installation, commissioning and remote monitoring.',
            ],
        ];
    }

    // Türkçe
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
// ======================================================================
function get_process(): array
{
    if (defined('LANG') && LANG === 'en') {
        return [
            ['no' => '01', 'hue' => 'agro',   'owner' => 'PR Tarım',         'duration' => '2 – 4 weeks',
             'title' => 'Discovery and feasibility',
             'body'  => 'Site visit, soil and irrigation water analysis, climate data. Decisions on what to grow, at what yield and for which market are made. Output: investment size and target yield.'],

            ['no' => '02', 'hue' => 'canopy', 'owner' => 'All three firms',   'duration' => '3 – 5 weeks',
             'title' => 'Project, specification and quote',
             'body'  => 'Greenhouse type, gutter height, heating capacity and irrigation flow rate are jointly determined based on the crop plan. Single technical specification, single price, single schedule. The grant application file is prepared at this stage if required.'],

            ['no' => '03', 'hue' => 'steel',  'owner' => 'Özdemirler Sera',  'duration' => '10 – 20 weeks',
             'title' => 'Construction and installation',
             'body'  => 'Ground preparation, foundations, galvanized steel erection, cladding system, heating and ventilation equipment installation. Irrigation routing channels are left ready during this phase.'],

            ['no' => '04', 'hue' => 'water',  'owner' => 'İrriga',           'duration' => '3 – 6 weeks',
             'title' => 'Irrigation, fertigation and automation',
             'body'  => 'Pump group, filter station, main and sub-lines, dripper installation, fertigation unit and control panel. System handed over with pressure and flow testing.'],

            ['no' => '05', 'hue' => 'canopy', 'owner' => 'PR Tarım + Service', 'duration' => '12 months',
             'title' => 'Commissioning and first-season monitoring',
             'body'  => 'Staff training, implementing the planting plan, calibrating the nutrition programme on site. Periodic agronomic check and technical service throughout the first growing season.'],
        ];
    }

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
// ======================================================================
function get_types(): array
{
    if (defined('LANG') && LANG === 'en') {
        return [
            ['name' => 'Venlo glass greenhouse', 'hue' => 'canopy',
             'light' => '89 – 92%', 'gutter' => '4.5 – 6.5 m', 'snow' => '40 – 75 kg/m²',
             'crops' => 'Tomato, cucumber, ornamental plants', 'level' => 'High',
             'bars'  => ['light' => 95, 'gutter' => 88, 'snow' => 62]],

            ['name' => 'Polycarbonate greenhouse', 'hue' => 'steel',
             'light' => '80 – 83%', 'gutter' => '4.0 – 5.5 m', 'snow' => '60 – 90 kg/m²',
             'crops' => 'Seedling production, medicinal plants, cuttings', 'level' => 'Medium – high',
             'bars'  => ['light' => 82, 'gutter' => 74, 'snow' => 80]],

            ['name' => 'Plastic tunnel (double-layer PE)', 'hue' => 'water',
             'light' => '85 – 88%', 'gutter' => '3.0 – 4.5 m', 'snow' => '25 – 40 kg/m²',
             'crops' => 'Tomato, pepper, strawberry, greens', 'level' => 'Medium',
             'bars'  => ['light' => 88, 'gutter' => 56, 'snow' => 38]],
        ];
    }

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
// ======================================================================
function get_projects(int $limit = 0): array
{
    if (defined('LANG') && LANG === 'en') {
        $rows = [
            [
                'slug'     => 'anahtar-teslim-domates-serasi',
                'title'    => 'Turnkey tomato greenhouse',
                'image'    => 'sera-ic-mekan-domates',
                'hue'      => 'agro',
                'scope'    => 'Consulting + Construction + Irrigation',
                'featured' => true,
                'meta'     => [
                    'Location'      => '—',
                    'Enclosed area' => '— decares',
                    'Type'          => 'Venlo glass',
                    'Delivery'      => '—',
                ],
            ],
            [
                'slug'     => 'fide-uretim-tesisi',
                'title'    => 'Seedling production facility',
                'image'    => 'plastik-tunel-sera',
                'hue'      => 'steel',
                'scope'    => 'Construction + Irrigation',
                'featured' => true,
                'meta'     => [
                    'Location'      => '—',
                    'Enclosed area' => '— decares',
                    'Type'          => 'Plastic tunnel',
                    'Delivery'      => '—',
                ],
            ],
            [
                'slug'     => 'acik-arazi-damla-sulama',
                'title'    => 'Open-field drip irrigation',
                'image'    => 'damla-sulama-damlatici',
                'hue'      => 'water',
                'scope'    => 'Irrigation only',
                'featured' => true,
                'meta'     => [
                    'Location'       => '—',
                    'Irrigated area' => '— decares',
                    'System'         => 'Drip + fertigation',
                    'Delivery'       => '—',
                ],
            ],
        ];
        return $limit > 0 ? array_slice($rows, 0, $limit) : $rows;
    }

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
// ======================================================================
function get_posts(int $limit = 0): array
{
    $lang     = defined('LANG') ? LANG : 'tr';
    $jsonFile = $lang === 'en'
        ? dirname(__DIR__) . '/content/blog/posts.en.json'
        : dirname(__DIR__) . '/content/blog/posts.json';

    // Fallback: İngilizce JSON yoksa Türkçeyi göster
    if (!is_readable($jsonFile)) {
        $jsonFile = dirname(__DIR__) . '/content/blog/posts.json';
    }

    $rows = [];
    if (is_readable($jsonFile)) {
        $decoded = json_decode(file_get_contents($jsonFile), true);
        if (is_array($decoded)) {
            $rows = $decoded;
        }
    }

    usort($rows, fn($a, $b) => strcmp($b['date'] ?? '', $a['date'] ?? ''));
    return $limit > 0 ? array_slice($rows, 0, $limit) : $rows;
}

function get_post(string $slug): ?array
{
    foreach (get_posts() as $p) {
        if ($p['slug'] === $slug) {
            $lang = defined('LANG') ? LANG : 'tr';
            if ($lang === 'en') {
                $file = dirname(__DIR__) . '/content/blog/en/' . $slug . '.html';
                // Fallback to Turkish if English body not yet available
                if (!is_file($file)) {
                    $file = dirname(__DIR__) . '/content/blog/' . $slug . '.html';
                }
            } else {
                $file = dirname(__DIR__) . '/content/blog/' . $slug . '.html';
            }
            $body    = is_file($file) ? file_get_contents($file) : '';
            $p['body'] = str_replace('{{u}}', BASE_PATH, $body);
            return $p;
        }
    }
    return null;
}

// ======================================================================
// SIK SORULAN SORULAR
// ======================================================================
function get_faqs(): array
{
    if (defined('LANG') && LANG === 'en') {
        return [
            ['q' => 'What determines the cost of a turnkey greenhouse?',
             'a' => 'Three main items determine cost: greenhouse type and gutter height, heating and climate control capacity, and irrigation and automation level. The site\'s snow and wind load drives the structural calculation and therefore the steel tonnage. After the survey we provide per-item pricing against a single technical specification.'],

            ['q' => 'How long does the whole project take?',
             'a' => 'For a typical 20-decare project, 5 – 9 months from survey to commissioning. The factors that affect duration most are ground conditions, import equipment lead times and grant approval timelines. A single delivery date is specified in the contract.'],

            ['q' => 'Can I benefit from grants and IPARD support?',
             'a' => 'Eligibility depends on land classification, investor status and the conditions of the current call. We check eligibility during the feasibility phase and prepare the application file in exact technical alignment with the construction and irrigation specifications — technical inconsistencies in the annexes are among the most common rejection reasons.'],

            ['q' => 'How do warranty and service work?',
             'a' => 'In a turnkey project we provide a single service line. Item-level warranty periods for structure, equipment and irrigation system are defined in a contract annex; in the event of a fault, your single point of contact is the same project manager.'],

            ['q' => 'Can I commission only irrigation or only consulting?',
             'a' => 'Yes. All three firms continue to operate independently in their own fields. You can use the same contact channel to retrofit irrigation automation to an existing greenhouse or to commission a feasibility study only.'],

            ['q' => 'Which regions do you operate in?',
             'a' => 'We carry out projects throughout Turkey. Team deployment for site visits and installation is planned according to project size; sharing your province in the contact form will speed up scheduling.'],
        ];
    }

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
