<?php

/**
 * Test connection details.
 */

namespace EnTrinetConnectionSettings;

/**
 * Add array for test connection.
 * Class EnTrinetConnectionSettings
 * @package EnTrinetConnectionSettings
 */
if (!class_exists('EnTrinetConnectionSettings')) {

    class EnTrinetConnectionSettings
    {

        static $get_connection_details = [];

        /**
         * Connection settings template.
         * @return array
         */
        static public function en_load()
        {
            $start_settings = [
                'en_connection_settings_start_trinet' => [
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'type' => 'title',
                    'id' => 'en_connection_settings_trinet',
                ],
            ];

            // App Name Connection Settings Detail
            $eniture_settings = self::en_set_connection_settings_detail();

            $end_settings = [
                'en_connection_settings_end_trinet' => [
                    'type' => 'sectionend',
                    'id' => 'en_connection_settings_end_trinet'
                ]
            ];

            $settings = array_merge($start_settings, $eniture_settings, $end_settings);

            return $settings;
        }

        /**
         * Connection Settings Detail
         * @return array
         */
        static public function en_get_connection_settings_detail()
        {
            $connection_request = self::en_static_request_detail();
            $en_request_indexing = json_decode(EN_TRINET_SET_CONNECTION_SETTINGS, true);
            foreach ($en_request_indexing as $key => $value) {
                $saved_connection_detail = get_option($key);
                $connection_request[$value['eniture_action']] = $saved_connection_detail;
                strlen($saved_connection_detail) > 0 ?
                    self::$get_connection_details[$value['eniture_action']] = $saved_connection_detail : '';
            }

            add_filter('en_trinet_reason_quotes_not_returned', [__CLASS__, 'en_trinet_reason_quotes_not_returned'], 99, 1);

            return $connection_request;
        }

        /**
         * Saving reasons to show proper error message on the cart or checkout page
         * When quotes are not returning
         * @param array $reasons
         * @return array
         */
        static public function en_trinet_reason_quotes_not_returned($reasons)
        {
            return empty(self::$get_connection_details) ? array_merge($reasons, [EN_TRINET_711]) : $reasons;
        }

        /**
         * Static Detail Set
         * @return array
         */
        static public function en_static_request_detail()
        {
            return
                [
                    'serverName' => EN_TRINET_SERVER_NAME,
                    'platform' => 'WordPress',
                    'carrierType' => 'small',
                    'carrierName' => 'trinetExpress',
                    'carrierMode' => 'pro',
                    'requestVersion' => '2.0',
                    'requestKey' => time(),
                ];
        }

        /**
         * Connection Settings Detail Set
         * @return array
         */
        static public function en_set_connection_settings_detail()
        {
            return
                [
                    'en_connection_settings_username_trinet' => [
                        'eniture_action' => 'username',
                        'name' => __('Username ', 'woocommerce-settings-trinet'),
                        'type' => 'text',
                        'desc' => __('', 'woocommerce-settings-trinet'),
                        'id' => 'en_connection_settings_username_trinet'
                    ],
                    'en_connection_settings_password_trinet' => [
                        'eniture_action' => 'password',
                        'name' => __('Password ', 'woocommerce-settings-trinet'),
                        'type' => 'text',
                        'desc' => __('', 'woocommerce-settings-trinet'),
                        'id' => 'en_connection_settings_password_trinet'
                    ],
                    'en_connection_settings_account_number_trinet' => [
                        'eniture_action' => 'accountNo',
                        'name' => __('Account number ', 'woocommerce-settings-trinet'),
                        'type' => 'text',
                        'desc' => __('', 'woocommerce-settings-trinet'),
                        'id' => 'en_connection_settings_account_number_trinet'
                    ],
                    'en_connection_settings_license_key_trinet' => [
                        'eniture_action' => 'licenseKey',
                        'name' => __('Plugin License Key ', 'woocommerce-settings-trinet'),
                        'type' => 'text',
                        'desc' => __('Obtain a License Key from <a href="' . EN_TRINET_ROOT_URL_PRODUCTS . '" target="_blank" >eniture.com </a>', 'woocommerce-settings-trinet'),
                        'id' => 'en_connection_settings_license_key_trinet'
                    ],
                ];
        }

    }

}