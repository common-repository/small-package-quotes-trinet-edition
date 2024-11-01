<?php

/**
 * Identified subscription.
 */

namespace EnTrinetPlans;

/**
 * Eniture plan.
 * Class EnTrinetPlans
 * @package EnTrinetPlans
 */
if (!class_exists('EnTrinetPlans')) {

    class EnTrinetPlans
    {
        /**
         * Hook for call.
         * EnTrinetPlans constructor.
         */
        public function __construct()
        {
            add_filter('en_register_activation_hook', [$this, 'en_get_current_plan'], 10);
            register_activation_hook(EN_TRINET_MAIN_FILE, [$this, 'en_get_current_plan'], 10, 1);
            add_filter('trinet_plans_notification_link', [$this, 'en_notification'], 10, 1);
            add_filter('trinet_plans_suscription_and_features', [$this, 'en_plans'], 10, 1);
            // Click here to update the plan
            add_action('wp_ajax_en_trinet_get_current_plan', [$this, 'en_get_current_plan'], 10);
        }

        /**
         * Eniture subscription status
         */
        public function en_get_current_plan($network_wide = null)
        {
            if (is_multisite() && $network_wide) {

                foreach (get_sites(['fields' => 'ids']) as $blog_id) {

                    switch_to_blog($blog_id);
                    $pakg_price = $pakg_duration = $expiry_date = $plan_type = '';
                    $index = 'small-package-quotes-trinet-edition/small-package-quotes-trinet-edition.php';
                    $plugin_info = get_plugins();
                    $plugin_version = (isset($plugin_info[$index]['Version'])) ? $plugin_info[$index]['Version'] : 0;
                    $plugin_dir_url = EN_TRINET_DIR_FILE . 'en-hit-to-update-plan.php';
                    $post_data = array(
                        'platform' => 'wordpress',
                        'carrier' => '83',
                        'store_url' => EN_TRINET_SERVER_NAME,
                        'webhook_url' => $plugin_dir_url,
                        'plugin_version' => $plugin_version,
                    );

                    extract(json_decode(\EnTrinetCurl\EnTrinetCurl::en_trinet_sent_http_request(EN_TRINET_PLAN_HITTING_URL, $post_data, 'GET', 'Plan'), true), null);

                    $pakg_price == '0' ? $pakg_group = '0' : '';

                    // Get plan message
                    $this->en_filter_current_plan_name($pakg_group, $expiry_date);

                    update_option('en_trinet_plan_number', $pakg_group);
                    update_option('en_trinet_plan_expire_days', $pakg_duration);
                    update_option('en_trinet_plan_expire_date', $expiry_date);
                    update_option('en_trinet_store_type', $plan_type);
                    restore_current_blog();

                }


            } else {
                $pakg_price = $pakg_duration = $expiry_date = $plan_type = '';
                $index = 'small-package-quotes-trinet-edition/small-package-quotes-trinet-edition.php';
                $plugin_info = get_plugins();
                $plugin_version = (isset($plugin_info[$index]['Version'])) ? $plugin_info[$index]['Version'] : 0;
                $plugin_dir_url = EN_TRINET_DIR_FILE . 'en-hit-to-update-plan.php';
                $post_data = array(
                    'platform' => 'wordpress',
                    'carrier' => '83',
                    'store_url' => EN_TRINET_SERVER_NAME,
                    'webhook_url' => $plugin_dir_url,
                    'plugin_version' => $plugin_version,
                );

                extract(json_decode(\EnTrinetCurl\EnTrinetCurl::en_trinet_sent_http_request(EN_TRINET_PLAN_HITTING_URL, $post_data, 'GET', 'Plan'), true), null);

                $pakg_price == '0' ? $pakg_group = '0' : '';

                // Get plan message
                $this->en_filter_current_plan_name($pakg_group, $expiry_date);

                update_option('en_trinet_plan_number', $pakg_group);
                update_option('en_trinet_plan_expire_days', $pakg_duration);
                update_option('en_trinet_plan_expire_date', $expiry_date);
                update_option('en_trinet_store_type', $plan_type);
            }
        }

        /**
         * Eniture filter subscription plan name
         */
        public function en_filter_current_plan_name($pakg_group, $expiry_date)
        {
            $expiry_date .= EN_TRINET_714;
            switch ($pakg_group) {
                case 3:
                    $plan_message = EN_TRINET_703 . $expiry_date;
                    break;
                case 2:
                    $plan_message = EN_TRINET_702 . $expiry_date;
                    break;
                case 1:
                    $plan_message = EN_TRINET_701 . $expiry_date;
                    break;
                case 0:
                    $plan_message = EN_TRINET_700 . $expiry_date;
                    break;
                default:
                    $plan_message = EN_TRINET_704;
                    break;
            }

            update_option('en_trinet_plan_message', "$plan_message .");
        }

        /**
         * Eniture plans
         * @param $feature
         * @return bool|mixed|string
         */
        public function en_plans($feature)
        {
            $package = EN_TRINET_PLAN;
            $features = [
                'instore_pickup_local_delivery' => ['3'],
                'hazardous_material' => ['2', '3'],
                'multi_warehouse' => ['2', '3'],
                'transit_days' => ['3'],
                'cutt_off_time' => ['2', '3'],
                'delivery_estimate_option' => ['1', '2', '3'],
            ];

            return (isset($features[$feature]) && (in_array($package, $features[$feature]))) ?
                TRUE : ((isset($features[$feature])) ? $features[$feature] : '');
        }

        /**
         * Plans notification link
         * @param array $plans
         * @return string
         */
        public function en_notification($plans)
        {
            $plan_to_upgrade = "";
            switch (current($plans)) {
                case 1:
                    $plan_to_upgrade = EN_TRINET_715;
                    break;
                case 2:
                    $plan_to_upgrade = EN_TRINET_705;
                    break;
                case 3:
                    $plan_to_upgrade = EN_TRINET_706;
                    break;
            }

            return $plan_to_upgrade;
        }

    }

}