<?php

namespace EnTrinetDistance;

use EnTrinetCurl\EnTrinetCurl;

if (!class_exists('EnTrinetDistance')) {

    class EnTrinetDistance
    {
        static public function get_address($map_address, $en_access_level, $en_destination_address = [])
        {
            $post_data = array(
                'acessLevel' => $en_access_level,
                'address' => $map_address,
                'originAddresses' => $map_address,
                'destinationAddress' => (isset($en_destination_address)) ? $en_destination_address : '',
                'eniureLicenceKey' => get_option('en_connection_settings_license_key_trinet'),
                'ServerName' => EN_TRINET_SERVER_NAME,
            );

            return EnTrinetCurl::en_trinet_sent_http_request(EN_TRINET_ADDRESS_HITTING_URL, $post_data, 'POST', 'Address');
        }
    }
}