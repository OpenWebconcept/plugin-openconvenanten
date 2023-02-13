<?php

declare(strict_types=1);

/**
 * Plugin Name:       Yard | OpenConvenanten
 * Plugin URI:        https://www.yard.nl/
 * Description:       Adds convenanten implementation
 * Version:           0.2.4
 * Author:            Yard | Digital Agency
 * Author URI:        https://www.yard.nl/
 * License:           GPL-3.0
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 * Text Domain:       yard-openconvenanten
 * Domain Path:       /languages
 */

use Yard\OpenConvenanten\Autoloader;
use Yard\OpenConvenanten\Foundation\Plugin;

/**
 * If this file is called directly, abort.
 */
if (! defined('WPINC')) {
    die;
}

define('OCV_FILE', __FILE__);
define('OCV_SLUG', basename(__FILE__, '.php'));
define('OCV_LANGUAGE_DOMAIN', OCV_SLUG);
define('OCV_DIR', basename(__DIR__));
define('OCV_ROOT_PATH', __DIR__);
define('OCV_VERSION', '0.2.4');

/**
 * Manual loaded file: the autoloader.
 */
require_once __DIR__ . '/autoloader.php';
$autoloader = new Autoloader();

if (file_exists(__DIR__ . '/vendor/autoload.php')) {
    require_once(__DIR__ . '/vendor/autoload.php');
}

/**
 * Begin execution of the plugin
 *
 * This hook is called once any activated plugins have been loaded. Is generally used for immediate filter setup, or
 * plugin overrides. The plugins_loaded action hook fires early, and precedes the setup_theme, after_setup_theme, init
 * and wp_loaded action hooks.
 */
add_action('plugins_loaded', function () {
    $plugin = (new Plugin(__DIR__))->boot();
}, 10);
