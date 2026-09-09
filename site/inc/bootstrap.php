<?php
/**
 * Her sayfanın ilk satırı burayı çağırır.
 *   Kök sayfalar     : require_once __DIR__ . '/inc/bootstrap.php';
 *   Alt klasördekiler: require_once dirname(__DIR__) . '/inc/bootstrap.php';
 */

declare(strict_types=1);

date_default_timezone_set('Europe/Istanbul');
mb_internal_encoding('UTF-8');
setlocale(LC_ALL, 'tr_TR.UTF-8', 'tr_TR', 'turkish');

// Yayında hataları ekrana basmayın; cPanel'de error_log dosyasına düşer.
// Geliştirirken şu iki satırı 1 / E_ALL yapın.
ini_set('display_errors', '0');
error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE);

define('APP_ROOT', dirname(__DIR__));

require_once APP_ROOT . '/inc/config.php';
require_once APP_ROOT . '/inc/functions.php';
require_once APP_ROOT . '/inc/data.php';
require_once APP_ROOT . '/inc/seo.php';

// Şablonların beklediği varsayılanlar
$page = array_merge([
    'title'       => SITE_NAME,
    'desc'        => '',
    'path'        => '/',
    'image'       => 'og-anahtar-teslim-sera',
    'type'        => 'website',
    'noindex'     => false,
    'breadcrumbs' => [],
    'schema'      => [],
    'body_class'  => '',
], $page ?? []);
