<?php

/**
 * App Name details.
 */

namespace EnTrinetConfig;

use EnTrinetConnectionSettings\EnTrinetConnectionSettings;
use EnTrinetQuoteSettingsDetail\EnTrinetQuoteSettingsDetail;

/**
 * Config values.
 * Class EnTrinetConfig
 * @package EnTrinetConfig
 */
if (!class_exists('EnTrinetConfig')) {

    class EnTrinetConfig
    {
        /**
         * Save config settings
         */
        static public function do_config()
        {
            define('EN_TRINET_PLAN', get_option('en_trinet_plan_number'));
            !empty(get_option('en_trinet_plan_message')) ? define('EN_TRINET_PLAN_MESSAGE', get_option('en_trinet_plan_message')) : define('EN_TRINET_PLAN_MESSAGE', EN_TRINET_704);
            define('EN_TRINET_NAME', 'Trinet Express');
            define('EN_TRINET_PLUGIN_URL', plugins_url());
            define('EN_TRINET_ABSPATH', ABSPATH);
            define('EN_TRINET_DIR', plugins_url(EN_TRINET_MAIN_DIR));
            define('EN_TRINET_DIR_FILE', plugin_dir_url(EN_TRINET_MAIN_FILE));
            define('EN_TRINET_FILE', plugins_url(EN_TRINET_MAIN_FILE));
            define('EN_TRINET_BASE_NAME', plugin_basename(EN_TRINET_MAIN_FILE));
            define('EN_TRINET_SERVER_NAME', self::en_get_server_name());

            define('EN_TRINET_DECLARED_ZERO', 0);
            define('EN_TRINET_DECLARED_ONE', 1);
            define('EN_TRINET_DECLARED_ARRAY', []);
            define('EN_TRINET_DECLARED_FALSE', false);
            define('EN_TRINET_DECLARED_TRUE', true);
            define('EN_TRINET_SHIPPING_NAME', 'trinet');

            $weight_threshold = get_option('en_weight_threshold_lfq');
            $weight_threshold = isset($weight_threshold) && $weight_threshold > 0 ? $weight_threshold : 150;
            define('EN_TRINET_SHIPMENT_WEIGHT_EXCEEDS_PRICE', $weight_threshold);
            define('EN_TRINET_SHIPMENT_WEIGHT_EXCEEDS', get_option('en_quote_settings_return_ltl_rates_trinet'));
            if (!defined('EN_TRINET_ROOT_URL')){
                define('EN_TRINET_ROOT_URL', 'https://eniture.com');
            }

            define('EN_TRINET_ROOT_URL_PRODUCTS', EN_TRINET_ROOT_URL . '/products/');
            define('EN_TRINET_RAD_URL', EN_TRINET_ROOT_URL . '/woocommerce-residential-address-detection/');
            define('EN_TRINET_SBS_URL', EN_TRINET_ROOT_URL . '/woocommerce-standard-box-sizes/');
            define('EN_TRINET_SUPPORT_URL', 'https://support.eniture.com/');
            define('EN_TRINET_DOCUMENTATION_URL', EN_TRINET_ROOT_URL . '/woocommerce-trinet-small-package-quotes');
            define('EN_TRINET_HITTING_API_URL', EN_TRINET_ROOT_URL . '/ws/trinet-express/quotes.php');
            define('EN_TRINET_ADDRESS_HITTING_URL', EN_TRINET_ROOT_URL . '/ws/addon/google-location.php');
            define('EN_TRINET_PLAN_HITTING_URL', EN_TRINET_ROOT_URL . '/ws/web-hooks/subscription-plans/create-plugin-webhook.php?');

            define('EN_TRINET_SET_CONNECTION_SETTINGS', wp_json_encode(EnTrinetConnectionSettings::en_set_connection_settings_detail()));
            define('EN_TRINET_GET_CONNECTION_SETTINGS', wp_json_encode(EnTrinetConnectionSettings::en_get_connection_settings_detail()));
            define('EN_TRINET_SET_QUOTE_SETTINGS', wp_json_encode(EnTrinetQuoteSettingsDetail::en_trinet_quote_settings()));
            define('EN_TRINET_GET_QUOTE_SETTINGS', wp_json_encode(EnTrinetQuoteSettingsDetail::en_trinet_get_quote_settings()));

            $en_app_set_quote_settings = json_decode(EN_TRINET_SET_QUOTE_SETTINGS, true);

            define('EN_TRINET_ALWAYS_ACCESSORIAL', wp_json_encode(EnTrinetQuoteSettingsDetail::en_trinet_always_accessorials($en_app_set_quote_settings)));
            define('EN_TRINET_ACCESSORIAL', wp_json_encode(EnTrinetQuoteSettingsDetail::en_trinet_compare_accessorial($en_app_set_quote_settings)));
        }

        /**
         * Get Host
         * @param type $url
         * @return type
         */
        static public function en_get_host($url)
        {
            $parse_url = parse_url(trim($url));
            if (isset($parse_url['host'])) {
                $host = $parse_url['host'];
            } else {
                $path = explode('/', $parse_url['path']);
                $host = $path[0];
            }
            return trim($host);
        }

        /**
         * Get Domain Name
         */
        static public function en_get_server_name()
        {
            global $wp;
            $wp_request = (isset($wp->request)) ? $wp->request : '';
            $url = home_url($wp_request);
            return self::en_get_host($url);
        }

    }

}