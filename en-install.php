<?php
/**
 * App install hook
 */
use EnTrinetConfig\EnTrinetConfig;
if (!function_exists('en_trinet_installation')) {

    function en_trinet_installation()
    {
        apply_filters('en_register_activation_hook', false);
    }

    register_activation_hook(EN_TRINET_MAIN_FILE, 'en_trinet_installation');
}
/**
 * Unishippers plugin update now
 */
if (!function_exists('en_trinet_small_update_now')) {

    function en_trinet_small_update_now()
    {
        $index = 'small-package-quotes-trinet-edition/small-package-quotes-trinet-edition.php';
        $plugin_info = get_plugins();
        $plugin_version = (isset($plugin_info[$index]['Version'])) ? $plugin_info[$index]['Version'] : '';
        $update_now = get_option('en_trinet_small_update_now');
        if ($update_now != $plugin_version) {
            en_trinet_installation();
            update_option('en_trinet_small_update_now', $plugin_version);
        }
    }
    add_action('init', 'en_trinet_small_update_now');
}
/**
 * App uninstall hook
 */
if (!function_exists('en_trinet_uninstall')) {

    function en_trinet_uninstall()
    {
        apply_filters('en_register_deactivation_hook', false);
    }

    register_deactivation_hook(EN_TRINET_MAIN_FILE, 'en_trinet_uninstall');
}

/**
 * App load admin side files of css and js hook
 */
if (!function_exists('en_trinet_admin_enqueue_scripts')) {

    function en_trinet_admin_enqueue_scripts()
    {
        wp_enqueue_script('EnTrinetTagging', EN_TRINET_DIR_FILE . '/admin/tab/location/assets/js/en-trinet-tagging.js', [], '1.0.1');
        wp_localize_script('EnTrinetTagging', 'script', [
            'pluginsUrl' => EN_TRINET_PLUGIN_URL,
        ]);

        wp_enqueue_script('EnTrinetAdminJs', EN_TRINET_DIR_FILE . '/admin/assets/en-trinet-admin.js', [], '1.0.2');
        wp_localize_script('EnTrinetAdminJs', 'script', [
            'pluginsUrl' => EN_TRINET_PLUGIN_URL,
        ]);

        wp_enqueue_script('EnWickedPicker', EN_TRINET_DIR_FILE . '/admin/assets/en-wicked-picker.js', [], '1.0.0');
        wp_localize_script('EnWickedPicker', 'script', [
            'pluginsUrl' => EN_TRINET_PLUGIN_URL,
        ]);

        wp_register_style('EnWickedPickerCss', EN_TRINET_DIR_FILE . '/admin/assets/en-wicked-picker.css', [], '1.0.0');
        wp_enqueue_style('EnWickedPickerCss');

        wp_enqueue_script('EnTrinetLocationScript', EN_TRINET_DIR_FILE . '/admin/tab/location/assets/js/en-trinet-location.js', [], '1.0.2');
        wp_localize_script('EnTrinetLocationScript', 'script', array(
            'pluginsUrl' => EN_TRINET_PLUGIN_URL,
        ));

        wp_register_style('EnTrinetLocationStyle', EN_TRINET_DIR_FILE . '/admin/tab/location/assets/css/en-trinet-location.css', false, '1.0.0');
        wp_enqueue_style('EnTrinetLocationStyle');

        wp_register_style('EnTrinetAdminCss', EN_TRINET_DIR_FILE . '/admin/assets/en-trinet-admin.css', false, '1.0.3');
        wp_enqueue_style('EnTrinetAdminCss');
    }

    add_action('admin_enqueue_scripts', 'en_trinet_admin_enqueue_scripts');
}

/**
 * App load front-end side files of css and js hook
 */
if (!function_exists('en_trinet_frontend_enqueue_scripts')) {

    function en_trinet_frontend_enqueue_scripts()
    {
        wp_enqueue_script('EnTrinetFrontEnd', EN_TRINET_DIR_FILE . '/admin/assets/en-trinet-frontend.js', ['jquery'], '1.0.0');
        wp_localize_script('EnTrinetFrontEnd', 'script', [
            'pluginsUrl' => EN_TRINET_PLUGIN_URL,
        ]);
    }

    add_action('wp_enqueue_scripts', 'en_trinet_frontend_enqueue_scripts');
}

/**
 * Load tab file
 * @param $settings
 * @return array
 */
if (!function_exists('en_trinet_shipping_sections')) {

    function en_trinet_shipping_sections($settings)
    {
        $settings[] = include('admin/tab/en-tab.php');
        return $settings;
    }

    add_filter('woocommerce_get_settings_pages', 'en_trinet_shipping_sections', 10, 1);
}

/**
 * Show action links on plugins page
 * @param $actions
 * @param $plugin_file
 * @return array
 */
if (!function_exists('en_trinet_freight_action_links')) {

    function en_trinet_freight_action_links($actions, $plugin_file)
    {
        static $plugin;
        if (!isset($plugin)) {
            $plugin = EN_TRINET_BASE_NAME;
        }

        if ($plugin == $plugin_file) {
            $settings = array('settings' => '<a href="admin.php?page=wc-settings&tab=trinet">' . __('Settings', 'General') . '</a>');
            $site_link = array('support' => '<a href="' . EN_TRINET_SUPPORT_URL . '" target="_blank">Support</a>');
            $actions = array_merge($settings, $actions);
            $actions = array_merge($site_link, $actions);
        }

        return $actions;
    }

    add_filter('plugin_action_links', 'en_trinet_freight_action_links', 10, 2);
}

/**
 * globally script variable
 */
if (!function_exists('en_trinet_admin_inline_js')) {

    function en_trinet_admin_inline_js()
    {
        ?>
        <script>
            let EN_TRINET_DIR_FILE
                = "<?php echo EN_TRINET_DIR_FILE; ?>";
        </script>
        <?php
    }

    add_action('admin_print_scripts', 'en_trinet_admin_inline_js');
}

/**
 * Transportation insight action links
 * @staticvar $plugin
 * @param $actions
 * @param $plugin_file
 * @return array
 */
if (!function_exists('en_trinet_admin_action_links')) {

    function en_trinet_admin_action_links($actions, $plugin_file)
    {
        static $plugin;
        if (!isset($plugin))
            $plugin = plugin_basename(__FILE__);
        if ($plugin == $plugin_file) {
            $settings = array('settings' => '<a href="admin.php?page=wc-settings&tab=trinet">' . __('Settings', 'General') . '</a>');
            $site_link = array('support' => '<a href="' . EN_TRINET_SUPPORT_URL . '" target="_blank">Support</a>');
            $actions = array_merge($settings, $actions);
            $actions = array_merge($site_link, $actions);
        }
        return $actions;
    }

    add_filter('plugin_action_links_' . EN_TRINET_BASE_NAME, 'en_trinet_admin_action_links', 10, 2);
}

/**
 * Transportation insight method in woo method list
 * @param $methods
 * @return string
 */
if (!function_exists('en_trinet_add_shipping_app')) {

    function en_trinet_add_shipping_app($methods)
    {
        $methods['trinet'] = 'EnTrinetShippingRates';
        return $methods;
    }

    add_filter('woocommerce_shipping_methods', 'en_trinet_add_shipping_app', 10, 1);
}
/**
 * The message show when no rates will display on the cart page
 */
if (!function_exists('en_none_shipping_rates')) {

    function en_none_shipping_rates()
    {
        $en_eniture_shipment = apply_filters('en_eniture_shipment', []);
        if (isset($en_eniture_shipment['LTL'])) {
            return esc_html("<div><p>There are no shipping methods available. 
                    Please double check your address, or contact us if you need any help.</p></div>");
        }
    }

    add_filter('woocommerce_cart_no_shipping_available_html', 'en_none_shipping_rates');
}

/**
 * Transportation insight plan status
 * @param array $plan_status
 * @return array
 */
if (!function_exists('en_trinet_plan_status')) {

    function en_trinet_plan_status($plan_status)
    {
        // Hazardous plan status
        $plan_required = '0';
        $hazardous_material_status = EN_TRINET_NAME . ': Enabled.';
        $hazardous_material = apply_filters("trinet_plans_suscription_and_features", 'hazardous_material');
        if (is_array($hazardous_material)) {
            $plan_required = '1';
            $hazardous_material_status = EN_TRINET_NAME . ': Upgrade to Standard Plan to enable.';
        }

        $plan_status['hazardous_material']['trinet'][] = 'trinet';
        $plan_status['hazardous_material']['plan_required'][] = $plan_required;
        $plan_status['hazardous_material']['status'][] = $hazardous_material_status;

        return $plan_status;
    }

    add_filter('en_app_common_plan_status', 'en_trinet_plan_status', 10, 1);
}
/**
 * The message show when no rates will display on the cart page
 */
if (!function_exists('en_app_load_restricted_duplicate_classes')) {

    function en_app_load_restricted_duplicate_classes()
    {
        new \EnTrinetProductDetail\EnTrinetProductDetail();
    }

    en_app_load_restricted_duplicate_classes();
}

/**
 * Hide third party shipping rates
 * @param mixed $available_methods
 * @return mixed
 */
if (!function_exists('en_trinet_hide_shipping')) {

    function en_trinet_hide_shipping($available_methods)
    {
        $en_eniture_shipment = apply_filters('en_eniture_shipment', []);
        $en_shipping_applications = apply_filters('en_shipping_applications', []);
        $eniture_old_plugins = get_option('EN_Plugins');
        $eniture_old_plugins = $eniture_old_plugins ? json_decode($eniture_old_plugins, true) : [];
        $en_eniture_apps = array_merge($en_shipping_applications, $eniture_old_plugins);

        if (get_option('en_trinet_allow_other_plugin_quotes') == 'no' &&
            (isset($en_eniture_shipment['LTL'])) && count($available_methods) > 0) {
            foreach ($available_methods as $index => $method) {
                if (!in_array($method->method_id, $en_eniture_apps)) {
                    unset($available_methods[$index]);
                }
            }
        }

        return $available_methods;
    }

    add_filter('woocommerce_package_rates', 'en_trinet_hide_shipping', 99, 1);
}

/**
 * Eniture save app name
 * @param array $en_applications
 * @return array
 */
if (!function_exists('en_trinet_shipping_applications')) {

    function en_trinet_shipping_applications($en_applications)
    {
        return array_merge($en_applications, ['trinet']);
    }

    add_filter('en_shipping_applications', 'en_trinet_shipping_applications', 10, 1);
}

/**
 * Eniture admin notices
 */
if (!function_exists('en_trinet_admin_notices')) {

    function en_trinet_admin_notices()
    {
        $en_trinet_tabs = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : '';
        if (isset($en_trinet_tabs) && ($en_trinet_tabs == "trinet")) {
            echo '<div class="notice notice-success is-dismissible"> <p>' . EN_TRINET_PLAN_MESSAGE . '</p> </div>';
        }
    }

    add_filter('admin_notices', 'en_trinet_admin_notices');
}

/**
 * Custom error message.
 * @param string $message
 * @return string|void
 */
if (!function_exists('en_trinet_error_message')) {

    function en_trinet_error_message($message)
    {
        $en_eniture_shipment = apply_filters('en_eniture_shipment', []);
        $reasons = apply_filters('en_trinet_reason_quotes_not_returned', []);

        if (isset($en_eniture_shipment['SPQ']) || !empty($reasons)) {
            $en_settings = json_decode(EN_TRINET_SET_QUOTE_SETTINGS, true);
            $message = (isset($en_settings['custom_error_message'])) ? $en_settings['custom_error_message'] : '';
            $custom_error_enabled = (isset($en_settings['custom_error_enabled'])) ? $en_settings['custom_error_enabled'] : '';

            switch ($custom_error_enabled) {
                case 'prevent':
                    remove_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20, 2);
                    break;
                case 'allow':
                    add_action('woocommerce_proceed_to_checkout', 'woocommerce_button_proceed_to_checkout', 20, 2);
                    break;
                default:
                    $message = '<div><p>There are no shipping methods available. Please double check your address, or contact us if you need any help.</p></div>';
                    break;
            }

            $message = !empty($reasons) ? implode(", ", $reasons) : $message;
        }

        return __($message);
    }

    add_filter('woocommerce_cart_no_shipping_available_html', 'en_trinet_error_message', 999, 1);
    add_filter('woocommerce_no_shipping_available_html', 'en_trinet_error_message', 999, 1);
}
// Create plugin option
if (!function_exists('en_trinet_create_option')) {

    function en_trinet_create_option()
    {
        $eniture_plugins = get_option('EN_Plugins');
        if (!$eniture_plugins) {
            add_option('EN_Plugins', json_encode(array('EnTrinetShippingRates')));
        } else {
            $plugins_array = json_decode($eniture_plugins);
            if (!in_array('EnTrinetShippingRates', $plugins_array)) {
                array_push($plugins_array, 'EnTrinetShippingRates');
                update_option('EN_Plugins', json_encode($plugins_array));
            }
        }
    }

    en_trinet_create_option();
}

/**
 * Filter For CSV Import
 */
if (!function_exists('en_import_dropship_location_csv')) {

    /**
     * Import drop ship location CSV
     * @param $data
     * @param $this
     * @return array
     */
    function en_import_dropship_location_csv($data, $parseData)
    {
        $_product_freight_class = $_product_freight_class_variation = '';
        $_dropship_location = $locations = [];
        foreach ($data['meta_data'] as $key => $metaData) {
            $location = explode(',', trim($metaData['value']));
            switch ($metaData['key']) {
                // Update new columns
                case '_product_freight_class':
                    $_product_freight_class = trim($metaData['value']);
                    unset($data['meta_data'][$key]);
                    break;
                case '_product_freight_class_variation':
                    $_product_freight_class_variation = trim($metaData['value']);
                    unset($data['meta_data'][$key]);
                    break;
                case '_dropship_location_nickname':
                    $locations[0] = $location;
                    unset($data['meta_data'][$key]);
                    break;
                case '_dropship_location_zip_code':
                    $locations[1] = $location;
                    unset($data['meta_data'][$key]);
                    break;
                case '_dropship_location_city':
                    $locations[2] = $location;
                    unset($data['meta_data'][$key]);
                    break;
                case '_dropship_location_state':
                    $locations[3] = $location;
                    unset($data['meta_data'][$key]);
                    break;
                case '_dropship_location_country':
                    $locations[4] = $location;
                    unset($data['meta_data'][$key]);
                    break;
                case '_dropship_location':
                    $_dropship_location = $location;
            }
        }

        // Update new columns
        if (strlen($_product_freight_class) > 0) {
            $data['meta_data'][] = [
                'key' => '_ltl_freight',
                'value' => $_product_freight_class,
            ];
        }

        // Update new columns
        if (strlen($_product_freight_class_variation) > 0) {
            $data['meta_data'][] = [
                'key' => '_ltl_freight_variation',
                'value' => $_product_freight_class_variation,
            ];
        }

        if (!empty($locations) || !empty($_dropship_location)) {
            if (isset($locations[0]) && is_array($locations[0])) {
                foreach ($locations[0] as $key => $location_arr) {
                    $metaValue = [];
                    if (isset($locations[0][$key], $locations[1][$key], $locations[2][$key], $locations[3][$key])) {
                        $metaValue[0] = $locations[0][$key];
                        $metaValue[1] = $locations[1][$key];
                        $metaValue[2] = $locations[2][$key];
                        $metaValue[3] = $locations[3][$key];
                        $metaValue[4] = $locations[4][$key];
                        $dsId[] = en_serialize_dropship($metaValue);
                    }
                }
            } else {
                $dsId[] = en_serialize_dropship($_dropship_location);
            }

            $sereializedLocations = maybe_serialize($dsId);
            $data['meta_data'][] = [
                'key' => '_dropship_location',
                'value' => $sereializedLocations,
            ];
        }
        return $data;
    }

    add_filter('woocommerce_product_importer_parsed_data', 'en_import_dropship_location_csv', '99', '2');
}

/**
 * Serialize drop ship
 * @param $metaValue
 * @return string
 * @global $wpdb
 */

if (!function_exists('en_serialize_dropship')) {
    function en_serialize_dropship($metaValue)
    {
        global $wpdb;
        $dropship = (array)reset($wpdb->get_results(
            "SELECT id
                        FROM " . $wpdb->prefix . "warehouse WHERE nickname='$metaValue[0]' AND zip='$metaValue[1]' AND city='$metaValue[2]' AND state='$metaValue[3]' AND country='$metaValue[4]'"
        ));

        $dropship = array_map('intval', $dropship);

        if (empty($dropship['id'])) {
            $data = en_csv_import_dropship_data($metaValue);
            $wpdb->insert(
                $wpdb->prefix . 'warehouse', $data
            );

            $dsId = $wpdb->insert_id;
        } else {
            $dsId = $dropship['id'];
        }

        return $dsId;
    }
}

/**
 * Filtered Data Array
 * @param $metaValue
 * @return array
 */
if (!function_exists('en_csv_import_dropship_data')) {
    function en_csv_import_dropship_data($metaValue)
    {
        return array(
            'city' => $metaValue[2],
            'state' => $metaValue[3],
            'zip' => $metaValue[1],
            'country' => $metaValue[4],
            'location' => 'dropship',
            'nickname' => (isset($metaValue[0])) ? $metaValue[0] : "",
        );
    }
}

// Define reference
function en_trinet_plugin($plugins)
{
    $plugins['spq'] = (isset($plugins['spq'])) ? array_merge($plugins['lfq'], ['trinet' => 'EnTrinetShippingRates']) : ['trinet' => 'EnTrinetShippingRates'];
    return $plugins;
}

add_filter('en_plugins', 'en_trinet_plugin');

/**
 * Update warehouse table
 */
function en_trinet_update_warehouse_db()
{
    global $wpdb;
    $warehouse_table = $wpdb->prefix . "warehouse";
    $warehouse_address = $wpdb->get_row("SHOW COLUMNS FROM " . $warehouse_table . " LIKE 'phone_instore'");
    if (!(isset($warehouse_address->Field) && $warehouse_address->Field == 'phone_instore')) {
        $wpdb->query(sprintf("ALTER TABLE %s ADD COLUMN address VARCHAR(255) NOT NULL", $warehouse_table));
        $wpdb->query(sprintf("ALTER TABLE %s ADD COLUMN phone_instore VARCHAR(255) NOT NULL", $warehouse_table));
    }
}

en_trinet_update_warehouse_db();
// fdo va
add_action('wp_ajax_nopriv_trinet_fd', 'trinet_fd_api');
add_action('wp_ajax_trinet_fd', 'trinet_fd_api');
/**
 * UPS AJAX Request
 */
function trinet_fd_api()
{
    $store_name =  EntrinetConfig::en_get_server_name();
    $company_id = $_POST['company_id'];
    $data = [
        'plateform'  => 'wp',
        'store_name' => $store_name,
        'company_id' => $company_id,
        'fd_section' => 'tab=trinet&section=section-5',
    ];
    if (is_array($data) && count($data) > 0) {
        if($_POST['disconnect'] != 'disconnect') {
            $url =  'https://freightdesk.online/validate-company';
        }else {
            $url = 'https://freightdesk.online/disconnect-woo-connection';
        }
        $response = wp_remote_post($url, [
                'method' => 'POST',
                'timeout' => 60,
                'redirection' => 5,
                'blocking' => true,
                'body' => $data,
            ]
        );
        $response = wp_remote_retrieve_body($response);
    }
    if($_POST['disconnect'] == 'disconnect') {
        $result = json_decode($response);
        if ($result->status == 'SUCCESS') {
            update_option('en_fdo_company_id_status', 0);
        }
    }
    echo $response;
    exit();
}
add_action('rest_api_init', 'en_rest_api_init_status_trinet');
function en_rest_api_init_status_trinet()
{
    register_rest_route('fdo-company-id', '/update-status', array(
        'methods' => 'POST',
        'callback' => 'en_trinet_fdo_data_status',
        'permission_callback' => '__return_true'
    ));
}

/**
 * Update FDO coupon data
 * @param array $request
 * @return array|void
 */
function en_trinet_fdo_data_status(WP_REST_Request $request)
{
    $status_data = $request->get_body();
    $status_data_decoded = json_decode($status_data);
    if (isset($status_data_decoded->connection_status)) {
        update_option('en_fdo_company_id_status', $status_data_decoded->connection_status);
        update_option('en_fdo_company_id', $status_data_decoded->fdo_company_id);
    }
    return true;
}