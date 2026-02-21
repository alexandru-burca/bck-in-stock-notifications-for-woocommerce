<?php

/**
 * Plugin Name: Back in stock notifications for WooCommerce
 * Plugin URI: https://www.getinnovation.dev/wordpres-plugins/woocommerce-stock-notify-me/
 * Description: Woocommerce subscribe system for out of stock products. 
 * Version: 1.0.2
 * Requires at least: 6.4
 * Requires PHP: 8.3
 * Author: Get Innovation Dev.
 * Author URI: https://getinnovation.dev/
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: back-in-stock-notifications-for-woocommerce
 * Domain Path: /languages
 *
 * WC tested up to: 9.4
 */

// Exit if accessed directly.
if (!defined('ABSPATH')) {
    exit;
}


defined('WSNM_PATH') or define('WSNM_PATH', plugin_dir_path(__FILE__));
defined('WSNM_URL')  or define('WSNM_URL',  plugin_dir_url(__FILE__));
defined('WSNM_BASE') or define('WSNM_BASE', plugin_basename(__FILE__));
$version = get_file_data(WSNM_PATH . basename(WSNM_BASE), array('Version'), 'plugin');
$textDomain = get_file_data(WSNM_PATH . basename(WSNM_BASE), array('Text Domain'), 'plugin');
$pluginName = get_file_data(WSNM_PATH . basename(WSNM_BASE), array('Plugin Name'), 'plugin');

/**
 * Currently plugin version.
 */
defined('WSNM_VERSION') or define('WSNM_VERSION', $version[0]);

/**
 * The unique identifier.
 */
defined('WSNM_DOMAIN') or define('WSNM_DOMAIN', $textDomain[0]);

/**
 * Plugin Name
 */
defined('WSNM_NAME') or define('WSNM_NAME', $pluginName[0]);


/**
 * activate_wsnm
 *
 * @return void
 */
function activate_wsnm()
{
    require_once WSNM_PATH . 'includes/class-wsnm-activator.php';
    WSNM_Woo_Stock_Notify_Me_Activator::activate();
}


/**
 * deactivate_wsnm
 * 
 * @return void
 */
function deactivate_wsnm()
{
    require_once WSNM_PATH . 'includes/class-wsnm-deactivator.php';
    WSNM_Woo_Stock_Notify_Me_Deactivator::deactivate();
}

register_activation_hook(__FILE__, 'activate_wsnm');
register_deactivation_hook(__FILE__, 'deactivate_wsnm');

/**
 * Run database migrations when the plugin is updated (not just on first activation).
 * Uses a db version option so this only runs once per schema version.
 *
 * @return void
 */
function wsnm_maybe_upgrade_db(): void
{
    if ( get_option( 'wsnm_db_version' ) !== '1.1' ) {
        require_once WSNM_PATH . 'includes/class-wsnm-activator.php';
        WSNM_Woo_Stock_Notify_Me_Activator::create_table();
        update_option( 'wsnm_db_version', '1.1' );
    }
}
add_action( 'plugins_loaded', 'wsnm_maybe_upgrade_db' );

/**
 * Declare compatibility with WooCommerce High-Performance Order Storage (HPOS).
 */
add_action( 'before_woocommerce_init', function () {
    if ( class_exists( \Automattic\WooCommerce\Utilities\FeaturesUtil::class ) ) {
        \Automattic\WooCommerce\Utilities\FeaturesUtil::declare_compatibility( 'custom_order_tables', __FILE__, true );
    }
} );

/**
 * Include the main class.
 */
require WSNM_PATH . 'includes/class-wsnm.php';


/**
 * @return void
 */
function run_WSNM_Woo_Stock_Notify_Me(): void
{
    $plugin = new WSNM_Woo_Stock_Notify_Me();
    $plugin->run();
}

run_WSNM_Woo_Stock_Notify_Me();