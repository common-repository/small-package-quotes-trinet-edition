<?php
/**
 * App Name tabs.
 */

use EnTrinetConnectionSettings\EnTrinetConnectionSettings;
use EnTrinetCarriers\EnTrinetCarriers;

if (!class_exists('EnTrinetTab')) {
    /**
     * Tabs show on admin side.
     * Class EnTrinetTab
     */
    class EnTrinetTab extends WC_Settings_Page
    {
        /**
         * Hook for call.
         */
        public function en_load()
        {
            $this->id = 'trinet';
            add_filter('woocommerce_settings_tabs_array', [$this, 'add_settings_tab'], 50);
            add_action('woocommerce_sections_' . $this->id, [$this, 'output_sections']);
            add_action('woocommerce_settings_' . $this->id, [$this, 'output']);
            add_action('woocommerce_settings_save_' . $this->id, [$this, 'save']);
        }

        /**
         * Setting Tab For Woocommerce
         * @param $settings_tabs
         * @return string
         */
        public function add_settings_tab($settings_tabs)
        {
            $settings_tabs[$this->id] = __('Trinet Express', 'woocommerce-settings-trinet');
            return $settings_tabs;
        }

        /**
         * Setting Sections
         * @return array
         */
        public function get_sections()
        {
            $sections = array(
                '' => __('Connection Settings', 'woocommerce-settings-trinet'),
                'section-2' => __('Quote Settings', 'woocommerce-settings-trinet'),
                'section-3' => __('Warehouses', 'woocommerce-settings-trinet'),
                'section-4' => __('User Guide', 'woocommerce-settings-trinet'),
                // fdo va
                'section-5' => __('FreightDesk Online', 'woocommerce-settings-trinet'),
                'section-6' => __('Validate Addresses', 'woocommerce-settings-trinet')
            );

            $sections = apply_filters('en_trinet_add_sections', $sections);
            $sections = apply_filters('en_woo_addons_sections', $sections, EN_TRINET_SHIPPING_NAME);
            return apply_filters('woocommerce_get_sections_' . $this->id, $sections);
        }


        /**
         * Display all pages on wc settings tabs
         * @param $section
         * @return array
         */
        public function get_settings($section = null)
        {
            ob_start();
            switch ($section) {

                case 'section-2' :
                    $settings = \EnTrinetQuoteSettings\EnTrinetQuoteSettings::Load();
                    break;

                case 'section-3':
                    EnLocation::en_load();
                    $settings = [];
                    break;

                case 'section-4' :
                    \EnTrinetUserGuide\EnTrinetUserGuide::en_load();
                    $settings = [];
                    break;
                // fdo va
                case 'section-5' :
                    \EnTrinetFreightdeskOnline\EnTrinetFreightdeskOnline::en_load();
                    $settings = [];
                    break;

                case 'section-6' :
                    \EnTrinetValidateAddress\EnTrinetValidateAddress::en_load();
                    $settings = [];
                    break;

                default:
                    $settings = EnTrinetConnectionSettings::en_load();
                    break;
            }

            $settings = apply_filters('en_trinet_add_settings', $settings, $section);
            $settings = apply_filters('en_woo_addons_settings', $settings, $section, EN_TRINET_SHIPPING_NAME);
            $settings = $this->avaibility_addon($settings);
            return apply_filters('woocommerce-settings-trinet', $settings, $section);
        }

        /**
         * RAD addon activated or not
         * @param array type $settings
         * @return array type
         */
        function avaibility_addon($settings)
        {
            if (!function_exists('is_plugin_active')) {
                require_once(EN_TRINET_ABSPATH . '/wp-admin/includes/plugin.php');
            }

            if (is_plugin_active('residential-address-detection/residential-address-detection.php')) {
                unset($settings['avaibility_lift_gate']);
                unset($settings['avaibility_auto_residential']);
            }

            if (is_plugin_active('standard-box-sizes/standard-box-sizes.php') || is_plugin_active('standard-box-sizes/en-standard-box-sizes.php')) {
                unset($settings['avaibility_box_sizing']);
            }

            return $settings;
        }

        /**
         * WooCommerce Settings Tabs
         * @global $current_section
         */
        public function output()
        {
            global $current_section;
            $settings = $this->get_settings($current_section);
            WC_Admin_Settings::output_fields($settings);
        }

        /**
         * Woocommerce Save Settings
         * @global $current_section
         */
        public function save()
        {
            global $current_section;
            $settings = $this->get_settings($current_section);
            if (isset($_POST['en_trinet_cutt_off_time']) && strlen($_POST['en_trinet_cutt_off_time']) > 0) {
                $_POST['en_trinet_cutt_off_time'] = $this->get_time_in_24_hours(sanitize_text_field($_POST['en_trinet_cutt_off_time']));
            }
            WC_Admin_Settings::save_fields($settings);
        }

        /**
         * Change time format.
         * @param $timeStr
         * @return false|string
         */
        public function get_time_in_24_hours($time_str)
        {
            $cutOffTime = explode(' ', $time_str);
            $hours = $cutOffTime[0];
            $separator = $cutOffTime[1];
            $minutes = $cutOffTime[2];
            $meridiem = $cutOffTime[3];
            $cutOffTime = "{$hours}{$separator}{$minutes} $meridiem";
            return date("H:i", strtotime($cutOffTime));
        }
    }

    $en_tab = new EnTrinetTab();
    return $en_tab->en_load();
}
