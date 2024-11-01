<?php

/**
 * All App Name messages
 */

namespace EnTrinetMessage;

/**
 * Messages are relate to errors, warnings, headings
 * Class EnTrinetMessage
 * @package EnTrinetMessage
 */
if (!class_exists('EnTrinetMessage')) {

    class EnTrinetMessage
    {

        /**
         * Add all messages
         * EnTrinetMessage constructor.
         */
        public function __construct()
        {
            if (!defined('EN_TRINET_ROOT_URL')){
                define('EN_TRINET_ROOT_URL', 'https://eniture.com');
            }
            define('EN_TRINET_BASIC_PLAN_URL', EN_TRINET_ROOT_URL . '/plan/woocommerce-trinet-small-package-quotes/');
            define('EN_TRINET_STANDARD_PLAN_URL', EN_TRINET_ROOT_URL . '/plan/woocommerce-trinet-small-package-quotes/');
            define('EN_TRINET_ADVANCED_PLAN_URL', EN_TRINET_ROOT_URL . '/plan/woocommerce-trinet-small-package-quotes/');
            define('EN_TRINET_SUBSCRIBE_PLAN_URL', EN_TRINET_ROOT_URL . '/plan/woocommerce-trinet-small-package-quotes/');
            define('EN_TRINET_700', "You are currently on the Trial Plan. Your plan will be expire on ");
            define('EN_TRINET_701', "You are currently on the Basic Plan. The plan renews on ");
            define('EN_TRINET_702', "You are currently on the Standard Plan. The plan renews on ");
            define('EN_TRINET_703', "You are currently on the Advanced Plan. The plan renews on ");
            define('EN_TRINET_704', "Your currently plan subscription is inactive <a href='javascript:void(0)' data-action='en_trinet_get_current_plan' onclick='en_update_plan(this);'>Click here</a> to check the subscription status. If the subscription status remains 
                inactive. Please activate your plan subscription from <a target='_blank' href='" . EN_TRINET_SUBSCRIBE_PLAN_URL . "'>here</a>");
            define('EN_TRINET_715', "<a target='_blank' class='en_plan_notification' href='" . EN_TRINET_BASIC_PLAN_URL . "'>
                        Basic Plan required
                    </a>");
            define('EN_TRINET_705', "<a target='_blank' class='en_plan_notification' href='" . EN_TRINET_STANDARD_PLAN_URL . "'>
                        Standard Plan required
                    </a>");
            define('EN_TRINET_706', "<a target='_blank' class='en_plan_notification' href='" . EN_TRINET_ADVANCED_PLAN_URL . "'>
                        Advanced Plan required
                    </a>");
            define('EN_TRINET_707', "Please verify credentials at connection settings panel.");
            define('EN_TRINET_708', "Please enter valid US or Canada zip code.");
            define('EN_TRINET_709', "Success! The test resulted in a successful connection.");
            define('EN_TRINET_710', "Zip code already exists.");
            define('EN_TRINET_711', "Connection settings are missing.");
            define('EN_TRINET_712', "Shipping parameters are not correct.");
            define('EN_TRINET_713', "Origin address is missing.");
            define('EN_TRINET_714', ' <a href="javascript:void(0)" data-action="en_trinet_get_current_plan" onclick="en_update_plan(this);">Click here</a> to refresh the plan');
        }

    }

}