<?php
/**
 * Plugin Name: Small Package Quotes - Trinet Edition
 * Plugin URI: https://eniture.com/products/
 * Description: Dynamically retrieves your negotiated shipping rates from Trinet Express and displays the results in the WooCommerce shopping cart.
 * Version: 2.1.1
 * Author: Eniture Technology
 * Author URI: http://eniture.com/
 * Text Domain: eniture-technology
 * License: GPL version 2 or later - http://www.eniture.com/
 * WC requires at least: 5.7
 * WC tested up to: 7.0.1
 */

if (!defined('ABSPATH')) exit; // Exit if accessed directly

require_once 'vendor/autoload.php';

define('EN_TRINET_MAIN_DIR', __DIR__);
define('EN_TRINET_MAIN_FILE', __FILE__);

if (empty(\EnTrinetGuard\EnTrinetGuard::en_check_prerequisites('Trinet Express', '5.6', '4.0', '2.3'))) {
    require_once 'en-install.php';
}