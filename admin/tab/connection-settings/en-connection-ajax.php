<?php

/**
 * Curl http request.
 */

namespace EnTrinetTestConnection;

use EnTrinetCurl\EnTrinetCurl;

/**
 * Test connection request.
 * Class EnTrinetTestConnection
 * @package EnTrinetTestConnection
 */
if (!class_exists('EnTrinetTestConnection')) {

    class EnTrinetTestConnection
    {

        /**
         * Hook in ajax handlers.
         */
        public function __construct()
        {
            add_action('wp_ajax_nopriv_en_trinet_test_connection', [$this, 'en_trinet_test_connection']);
            add_action('wp_ajax_en_trinet_test_connection', [$this, 'en_trinet_test_connection']);
        }

        /**
         * Handle Connection Settings Ajax Request
         */
        public function en_trinet_test_connection()
        {
            $en_post_data = (isset($_POST['en_post_data'])) ? $_POST['en_post_data'] : '';
            $en_request_indexing = json_decode(EN_TRINET_SET_CONNECTION_SETTINGS, true);
            $en_connection_request = json_decode(EN_TRINET_GET_CONNECTION_SETTINGS, true);

            foreach ($en_post_data as $key => $value) {
                $en_request_name = (isset($value['name'])) ? sanitize_text_field($value['name']) : '';
                $en_request_value = (isset($value['value'])) ? sanitize_text_field($value['value']) : '';

                $en_connection_request[$en_request_indexing[$en_request_name]['eniture_action']] = $en_request_value;
            }

            $en_connection_request['carrierMode'] = 'test';

            $en_connection_request['receiverCity'] = 'Chicago';
            $en_connection_request['receiverState'] = 'IL';
            $en_connection_request['receiverZip'] = '60603';
            $en_connection_request['receiverCountryCode'] = 'US';

            $en_connection_request = apply_filters('en_trinet_add_connection_request', $en_connection_request);

            echo EnTrinetCurl::en_trinet_sent_http_request(
                EN_TRINET_HITTING_API_URL, $en_connection_request, 'POST', 'Connection'
            );
            exit;
        }

    }

}