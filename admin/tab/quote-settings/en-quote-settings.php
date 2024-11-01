<?php

/**
 * Quote settings detail array.
 */

namespace EnTrinetQuoteSettings;

if (!class_exists('EnTrinetQuoteSettings')) {

    class EnTrinetQuoteSettings
    {

        /**
         * Domestic services
         * @return array
         */
        static public function domestic_services()
        {
            return
                [
                    [
                        'id' => 'FDX_FEDEX_GROUND',
                        'request' => 'FDX_FEDEX_GROUND',
                        'name' => 'FedEx Ground',
                    ],
                    [
                        'id' => 'FDX_PRIORITY_OVERNIGHT',
                        'request' => 'FDX_PRIORITY_OVERNIGHT',
                        'name' => 'FedEx Priority Overnight',
                    ],
                    [
                        'id' => 'FDX_STANDARD_OVERNIGHT',
                        'request' => 'FDX_STANDARD_OVERNIGHT',
                        'name' => 'FedEx Standard Overnight',
                    ],
                    [
                        'id' => 'FDX_FEDEX_2_DAY_AM',
                        'request' => 'FDX_FEDEX_2_DAY_AM',
                        'name' => 'FedEx 2 Days AM',
                    ],
                    [
                        'id' => 'FDX_FEDEX_2_DAY',
                        'request' => 'FDX_FEDEX_2_DAY',
                        'name' => 'FedEx 2 Days',
                    ],
                    [
                        'id' => 'FDX_FEDEX_EXPRESS_SAVER',
                        'request' => 'FDX_FEDEX_EXPRESS_SAVER',
                        'name' => 'FedEx Express Saver',
                    ],
                    [
                        'id' => 'FDX_GROUND_HOME_DELIVERY',
                        'request' => 'FDX_GROUND_HOME_DELIVERY',
                        'name' => 'FedEx Ground Home Delivery',
                    ],
                    [
                        'id' => 'PUR_PurolatorExpress9AM',
                        'request' => 'PUR_PurolatorExpress9AM',
                        'name' => 'Purolator Express 9AM',
                    ],
                    [
                        'id' => 'PUR_PurolatorExpress10:30AM',
                        'request' => 'PUR_PurolatorExpress10:30AM',
                        'name' => 'Purolator Express 10:30AM',
                    ],
                    [
                        'id' => 'PUR_PurolatorExpress',
                        'request' => 'PUR_PurolatorExpress',
                        'name' => 'Purolator Express',
                    ]
                ];
        }

        /**
         * International services
         * @return array
         */
        static public function international_services()
        {
            return
                [
                    [
                        'id' => 'FDX_INTERNATIONAL_PRIORITY',
                        'request' => 'FDX_INTERNATIONAL_PRIORITY',
                        'name' => 'FedEx International Priority',
                    ],
                    [
                        'id' => 'FDX_INTERNATIONAL_ECONOMY',
                        'request' => 'FDX_INTERNATIONAL_ECONOMY',
                        'name' => 'FedEx International Economy',
                    ],
                    [
                        'id' => 'PUR_PurolatorExpressUS9AM',
                        'request' => 'PUR_PurolatorExpressU.S.9AM',
                        'name' => 'Purolator Express U.S 9AM',
                    ],
                    [
                        'id' => 'PUR_PurolatorExpressUS10:30AM',
                        'request' => 'PUR_PurolatorExpressU.S.10:30AM',
                        'name' => 'Purolator Express U.S 10:30AM',
                    ],
                    [
                        'id' => 'PUR_PurolatorExpressUS',
                        'request' => 'PUR_PurolatorExpressU.S.',
                        'name' => 'Purolator Express U.S',
                    ],
                    [
                        'id' => 'PUR_PurolatorGroundUS',
                        'request' => 'PUR_PurolatorGroundU.S.',
                        'name' => 'Purolator Ground U.S',
                    ]
                ];
        }

        /**
         * Quote Settings Services
         * @return array
         */
        static public function services()
        {
            $alphabets = 'abcdefghijklmnopqrstuvwxyz';
            $domestic = self::domestic_services();
            $international = self::international_services();
            $services = [];
            foreach ($domestic as $key => $service) {

                // Domestic checkbox
                $id = $name = '';
                extract($service);
                $indexing = 'en_trinet_checkbox_' . $id;
                $services[$indexing] = [
                    'name' => __($name, 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'id' => $id,
                    'class' => 'en_trinet_domestic_service en_trinet_service_checkbox',
                ];

                // International checkbox
                $international_service = (isset($international[$key])) ? $international[$key] : [];
                if (!empty($international_service)) {
                    $international_id = $international_service['id'];
                    $international_name = $international_service['name'];
                    $indexing = 'en_trinet_checkbox_' . $international_id;
                    $services[$indexing] = [
                        'name' => __($international_name, 'woocommerce-settings-trinet'),
                        'type' => 'checkbox',
                        'id' => $international_id,
                        'class' => 'en_trinet_international_service en_trinet_service_checkbox',
                    ];
                } else {
                    $rand_string = substr(str_shuffle(str_repeat($alphabets, mt_rand(1, 10))), 1, 5);
                    $services[$rand_string] = [
                        'name' => __('', 'woocommerce-settings-trinet'),
                        'type' => 'checkbox',
                        'id' => $rand_string,
                        'class' => 'en_trinet_international_service hidden en_trinet_service_hide',
                    ];
                }

                // Domestic markup
                $indexing = 'en_trinet_markup_' . $id;
                $services[$indexing] = [
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'id' => $indexing,
                    'class' => 'en_trinet_domestic_service en_trinet_service_markup',
                    'desc' => __('Markup (e.g. Currency: 1.00 or Percentage: 5.0%)', 'woocommerce-settings-trinet'),
                    'placeholder' => 'Markup',
                ];

                // International markup
                if (!empty($international_service)) {
                    $indexing = 'en_trinet_markup_' . $international_id;
                    $services[$indexing] = [
                        'name' => __('', 'woocommerce-settings-trinet'),
                        'type' => 'text',
                        'id' => $indexing,
                        'class' => 'en_trinet_international_service en_trinet_service_markup',
                        'desc' => __('Markup (e.g. Currency: 1.00 or Percentage: 5.0%)', 'woocommerce-settings-trinet'),
                        'placeholder' => 'Markup',
                    ];
                } else {
                    $rand_string = substr(str_shuffle(str_repeat($alphabets, mt_rand(1, 10))), 1, 10);
                    $services[$rand_string] = [
                        'name' => __('', 'woocommerce-settings-trinet'),
                        'type' => 'text',
                        'id' => $rand_string,
                        'class' => 'en_trinet_service_hide en_trinet_international_service en_trinet_service_markup hidden',
                    ];
                }
            }


            $services['shipping_methods_do_not_sort_by_price'] = [
                'name' => __("Don't sort shipping methods by price", 'woocommerce-settings-trinet'),
                'type' => 'checkbox',
                'id' => 'shipping_methods_do_not_sort_by_price',
                'desc' => 'By default, the plugin will sort all shipping methods by price in ascending order.',
            ];

            $services['residential_delivery_options_label'] = [
                'name' => __('Residential Delivery', 'woocommerce-settings-trinet'),
                'type' => 'text',
                'class' => 'hidden',
                'id' => 'residential_delivery'
            ];

            $services['en_trinet_residential_delivery'] = [
                'name' => __('', 'woocommerce-settings-trinet'),
                'type' => 'checkbox',
                'desc' => 'Always quote as residential delivery.',
                'id' => 'en_trinet_residential_delivery'
            ];

            /**
             * ==================================================================
             * Auto-detect residential addresses notification
             * ==================================================================
             */
            $services['avaibility_auto_residential'] = [
                'name' => __('', 'woocommerce-settings-trinet'),
                'type' => 'text',
                'class' => 'hidden',
                'desc' => "Click <a target='_blank' href='" . EN_TRINET_RAD_URL . "'>here</a> to add the Auto-detect residential addresses module. (<a target='_blank' href='https://eniture.com/woocommerce-residential-address-detection/#documentation'>Learn more</a>)",
                'id' => 'en_quote_settings_availability_auto_residential_trinet'
            ];

            /**
             * ==================================================================
             * Standard box sizes notification
             * ==================================================================
             */
            $services['avaibility_box_sizing'] = [
                'name' => __('Use my standard box sizes ', 'woocommerce-settings-trinet'),
                'type' => 'text',
                'class' => 'hidden',
                'desc' => "Click <a target='_blank' href='" . EN_TRINET_SBS_URL . "'>here</a> to add the Standard Box Sizes module. (<a target='_blank' href='https://eniture.com/woocommerce-standard-box-sizes/#documentation'>Learn more</a>)",
                'id' => 'en_quote_settings_availability_sbs_trinet'
            ];

            return $services;
        }

        /**
         * Hazardous material settings
         * @return array
         */
        static public function hazardous_material()
        {
            $option = $message = '';
            if (isset($_REQUEST['tab'])) {
                $feature_option = apply_filters(sanitize_text_field($_REQUEST['tab']) . "_plans_suscription_and_features", 'hazardous_material');
                if (is_array($feature_option)) {
                    $option = 'en_trinet_disabled';
                    $message = apply_filters(sanitize_text_field($_REQUEST['tab']) . "_plans_notification_link", $feature_option);
                }
            }

            return [
                'hazardous_material_settings' => [
                    'name' => __('Hazardous material settings', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => 'hidden',
                    'desc' => $message,
                    'id' => 'hazardous_material_settings'
                ],
                'en_trinet_hazardous_material_settings' => [
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'class' => $option,
                    'desc' => 'Only quote ground service for hazardous materials shipments.',
                    'id' => 'en_trinet_hazardous_material_settings'
                ],
                'en_trinet_hazardous_material_settings_ground_fee' => [
                    'name' => __('Ground Hazardous Material Fee ', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => $option,
                    'desc' => 'Enter an amount, e.g 20. or Leave blank to disable.',
                    'id' => 'en_trinet_hazardous_material_settings_ground_fee'
                ],
                'en_trinet_hazardous_material_settings_international_fee' => [
                    'name' => __('Air Hazardous Material Fee ', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => $option,
                    'desc' => 'Enter an amount, e.g 20. or Leave blank to disable.',
                    'id' => 'en_trinet_hazardous_material_settings_international_fee'
                ],
            ];
        }

        /**
         * Delivery estimate options
         * @return array
         */
        static public function delivery_estimate_option()
        {
            $option = $message = '';
            if (isset($_REQUEST['tab'])) {
                $feature_option = apply_filters(sanitize_text_field($_REQUEST['tab']) . "_plans_suscription_and_features", 'delivery_estimate_option');
                if (is_array($feature_option)) {
                    $option = 'en_trinet_disabled';
                    $message = apply_filters(sanitize_text_field($_REQUEST['tab']) . "_plans_notification_link", $feature_option);
                }
            }

            return [
                'delivery_estimate_options' => [
                    'name' => __('Delivery Estimate Options', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => 'hidden',
                    'desc' => $message,
                    'id' => 'delivery_estimate_options'
                ],
                'en_delivery_estimate_options_trinet' => [
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'type' => 'radio',
                    'class' => $option,
                    'default' => "dont_show_estimates",
                    'options' => [
                        'dont_show_estimates' => __("Don't display delivery estimates.", 'woocommerce-settings-trinet'),
                        'delivery_days' => __('Display estimated number of days until delivery.', 'woocommerce-settings-trinet'),
                        'delivery_date' => __('Display estimated delivery date.', 'woocommerce-settings-trinet'),
                    ],
                    'id' => 'en_delivery_estimate_options_trinet'
                ],
            ];
        }

        /**
         * Transit days
         * @return array
         */
        static public function transit_days()
        {
            $option = $message = '';
            if (isset($_REQUEST['tab'])) {
                $feature_option = apply_filters(sanitize_text_field($_REQUEST['tab']) . "_plans_suscription_and_features", 'transit_days');
                if (is_array($feature_option)) {
                    $option = 'en_trinet_disabled';
                    $message = apply_filters(sanitize_text_field($_REQUEST['tab']) . "_plans_notification_link", $feature_option);
                }
            }

            return [
                'ground_transit' => [
                    'name' => __('Ground transit time restriction', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => 'hidden',
                    'desc' => $message,
                    'id' => 'ground_transit'
                ],
                'en_trinet_transit_days' => [
                    'name' => __('Enter the number of transit days to restrict ground service to. Leave blank to disable this feature.', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => $option,
                    'id' => 'en_trinet_transit_days'
                ],
                'en_trinet_transit_day_options' => [
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'type' => 'radio',
                    'class' => $option,
                    'options' => [
                        'transitDays' => __('Restrict the carriers in transit days metric.', 'woocommerce-settings-trinet'),
                        'CalenderDaysInTransit' => __('Restrict by calendar days in transit.', 'woocommerce-settings-trinet'),
                    ],
                    'id' => 'en_trinet_transit_day_options'
                ],
            ];
        }

        /**
         * Cutt off time
         * @return array
         */
        static public function cutt_off_time()
        {
            $option = $message = '';
            if (isset($_REQUEST['tab'])) {
                $feature_option = apply_filters(sanitize_text_field($_REQUEST['tab']) . "_plans_suscription_and_features", 'cutt_off_time');
                if (is_array($feature_option)) {
                    $option = 'en_trinet_disabled';
                    $message = apply_filters(sanitize_text_field($_REQUEST['tab']) . "_plans_notification_link", $feature_option);
                }
            }

            return [
                'cutt_off_time_and_ship_date_offset' => [
                    'name' => __('Cut Off Time & Ship Date Offset', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => 'hidden',
                    'desc' => $message,
                    'id' => 'cutt_off_time_and_ship_date_offset'
                ],
                'en_trinet_cutt_off_time' => [
                    'name' => __('Order Cut Off Time', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => $option,
                    'placeholder' => '--:-- --',
                    'desc' => 'Enter the cut off time (e.g. 2.00) for the orders. Orders placed after this time will be quoted as shipping the next business day.',
                    'id' => 'en_trinet_cutt_off_time'
                ],
                'en_trinet_fulfilment_offset_days' => [
                    'name' => __('Fulfilment Offset Days', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'class' => $option,
                    'desc' => 'The number of days the ship date needs to be moved to allow the processing of the order.',
                    'id' => 'en_trinet_fulfilment_offset_days'
                ],
                'en_trinet_all_shipment' => [
                    'name' => __("What days do you ship orders?", 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'desc' => 'Select All',
                    'id' => 'en_trinet_all_shipment',
                    'class' => 'en_trinet_all_shipment ' . $option,
                ],
                'en_trinet_monday_shipment' => [
                    'name' => __("", 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'desc' => 'Monday',
                    'id' => 'en_trinet_monday_shipment',
                    'class' => 'en_trinet_shipment_day ' . $option,
                ],
                'en_trinet_tuesday_shipment' => [
                    'name' => __("", 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'desc' => 'Tuesday',
                    'id' => 'en_trinet_tuesday_shipment',
                    'class' => 'en_trinet_shipment_day ' . $option,
                ],
                'en_trinet_wednesday_shipment' => [
                    'name' => __("", 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'desc' => 'Wednesday',
                    'id' => 'en_trinet_wednesday_shipment',
                    'class' => 'en_trinet_shipment_day ' . $option,
                ],
                'en_trinet_thursday_shipment' => [
                    'name' => __("", 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'desc' => 'Thursday',
                    'id' => 'en_trinet_thursday_shipment',
                    'class' => 'en_trinet_shipment_day ' . $option,
                ],
                'en_trinet_friday_shipment' => [
                    'name' => __("", 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'desc' => 'Friday',
                    'id' => 'en_trinet_friday_shipment',
                    'class' => 'en_trinet_shipment_day ' . $option,
                ],
            ];
        }

        static public function Load()
        {
            $services = self::services();
            $settings_start = [
                'en_quote_settings_start_trinet' => [
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'type' => 'title',
                    'id' => 'en_quote_settings_trinet',
                ],
                'en_trinet_domestic_heading' => [
                    'name' => __('Domestic Services', 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'id' => 'en_trinet_domestic_heading',
                    'class' => 'en_trinet_domestic_service en_trinet_service_heading',
                ],
                'en_trinet_international_heading' => [
                    'name' => __('International Services', 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'id' => 'en_trinet_international_heading',
                    'class' => 'en_trinet_international_service en_trinet_service_heading',
                ],
                'en_trinet_domestic_selective' => [
                    'name' => __('Select All', 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'id' => 'en_trinet_domestic_selective',
                    'class' => 'en_trinet_domestic_service en_trinet_service_all_select',
                ],
                'en_trinet_international_selective' => [
                    'name' => __('Select All', 'woocommerce-settings-trinet'),
                    'type' => 'checkbox',
                    'id' => 'en_trinet_international_selective',
                    'class' => 'en_trinet_international_service en_trinet_service_all_select',
                ],
            ];

            $settings_body = [

                'en_trinet_handling_fee' => [
                    'name' => __('Handling Fee / Markup ', 'woocommerce-settings-trinet'),
                    'type' => 'text',
                    'desc' => 'Amount excluding tax. Enter an amount, e.g 3.75, or a percentage, e.g, 5%. Leave blank to disable.',
                    'id' => 'en_trinet_handling_fee'
                ],
                'en_trinet_allow_other_plugin_quotes' => [
                    'name' => __('Show WooCommerce Shipping Options ', 'woocommerce-settings-trinet'),
                    'type' => 'select',
                    'default' => 'yes',
                    'desc' => __('Enabled options on WooCommerce Shipping page are included in quote results.', 'woocommerce-settings-trinet'),
                    'id' => 'en_trinet_allow_other_plugin_quotes',
                    'options' => [
                        'yes' => __('YES', 'YES'),
                        'no' => __('NO', 'NO'),
                    ]
                ],
                /**
                 * ==================================================================
                 * When plugin fail return to rate
                 * ==================================================================
                 */
                'en_quote_settings_clear_both_trinet' => [
                    'title' => __('', 'woocommerce'),
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'desc' => '',
                    'id' => 'en_quote_settings_clear_both_trinet',
                    'css' => '',
                    'type' => 'title',
                ],
                'en_quote_settings_unable_retrieve_shipping_trinet' => [
                    'name' => __('Checkout options if the plugin fails to return a rate ', 'woocommerce-settings-trinet'),
                    'type' => 'title',
                    'desc' => '<span> When the plugin is unable to retrieve shipping quotes and no other shipping options are provided by an alternative source: </span>',
                    'id' => 'en_quote_settings_unable_retrieve_shipping_trinet',
                ],
                'en_trinet_unable_retrieve_shipping' => [
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'type' => 'radio',
                    'id' => 'en_trinet_unable_retrieve_shipping',
                    'default' => 'allow',
                    'options' => [
                        'allow' => __('Allow user to continue to check out and display this message', 'woocommerce-settings-trinet'),
                        'prevent' => __('Prevent user from checking out and display this message', 'woocommerce-settings-trinet'),
                    ]
                ],
                'en_trinet_checkout_error_message' => [
                    'name' => __('', 'woocommerce-settings-trinet'),
                    'type' => 'textarea',
                    'desc' => 'Enter a maximum of 250 characters.',
                    'id' => 'en_trinet_checkout_error_message'
                ],
                'en_quote_settings_end_trinet' => [
                    'type' => 'sectionend',
                    'id' => 'en_quote_settings_end_trinet'
                ],
            ];

            $settings = $settings_start + $services + self::delivery_estimate_option() + self::cutt_off_time() + self::transit_days() + self::hazardous_material() + $settings_body;

            return $settings;
        }

    }

}