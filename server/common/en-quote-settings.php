<?php

/**
 * App Name settings.
 */

namespace EnTrinetQuoteSettingsDetail;

/**
 * Get and save settings.
 * Class EnTrinetQuoteSettingsDetail
 * @package EnTrinetQuoteSettingsDetail
 */
if (!class_exists('EnTrinetQuoteSettingsDetail')) {

    class EnTrinetQuoteSettingsDetail
    {
        static public $en_trinet_accessorial = [];

        /**
         * Set quote settings detail
         */
        static public function en_trinet_get_quote_settings()
        {
            $accessorials = [];
            $en_settings = json_decode(EN_TRINET_SET_QUOTE_SETTINGS, EN_TRINET_DECLARED_TRUE);
            $en_settings['residential_delivery'] == 'yes' ? $accessorials['residentialDelivery'] = EN_TRINET_DECLARED_TRUE : "";


            return $accessorials;
        }

        /**
         * Set quote settings detail
         */
        static public function en_trinet_always_accessorials()
        {
            $accessorials = [];
            $en_settings = self::en_trinet_quote_settings();
            $en_settings['residential_delivery'] == 'yes' ? $accessorials[] = 'R' : "";

            return $accessorials;
        }

        /**
         * Set quote settings detail
         */
        static public function en_trinet_quote_settings()
        {
            $trinet_shipment_days = ['all', 'monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
            $shipment_days = [];
            foreach ($trinet_shipment_days as $key => $day) {
                get_option('en_trinet_' . $day . '_shipment') == 'yes' ? $shipment_days[] = $key : '';
            }
            $quote_settings = [
                // Cut Off Time & Ship Date Offset
                'delivery_estimate_option' => get_option('en_delivery_estimate_options_trinet'),
                'cutt_off_time' => get_option('en_trinet_cutt_off_time'),
                'fulfilment_offset_days' => get_option('en_trinet_fulfilment_offset_days'),
                'shipment_days' => $shipment_days,
                // Ground transit time restriction
                'transit_days' => get_option('en_trinet_transit_days'),
                'transit_day_option' => get_option('en_trinet_transit_day_options'),
                // Hazardous material settings
                'hazardous_material' => get_option('en_trinet_hazardous_material_settings'),
                'hazardous_ground_fee' => get_option('en_trinet_hazardous_material_settings_ground_fee'),
                'hazardous_international_fee' => get_option('en_trinet_hazardous_material_settings_international_fee'),
                'handling_fee' => get_option('en_trinet_handling_fee'),
                'residential_delivery' => get_option('en_trinet_residential_delivery'),
                'custom_error_message' => get_option('en_trinet_checkout_error_message'),
                'custom_error_enabled' => get_option('en_trinet_unable_retrieve_shipping'),
            ];

            return $quote_settings;
        }

        /**
         * Get quote settings detail
         * @param array $en_settings
         * @return array
         */
        static public function en_trinet_compare_accessorial($en_settings)
        {
            self::$en_trinet_accessorial[] = ['S'];
            return self::$en_trinet_accessorial;
        }

    }

}