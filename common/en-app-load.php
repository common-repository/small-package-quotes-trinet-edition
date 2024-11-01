<?php

/**
 * App Name load classes.
 */

namespace EnTrinetLoad;

use EnTrinetCsvExport\EnTrinetCsvExport;
use EnTrientOrderWidget\EnTrientOrderWidget;
use EnTrinetConfig\EnTrinetConfig;
use EnTrinetCreateLTLClass\EnTrinetCreateLTLClass;
use EnTrinetLocationAjax\EnTrinetLocationAjax;
use EnTrinetMessage\EnTrinetMessage;
use EnTrinetOrderRates\EnTrinetOrderRates;
use EnTrinetOrderScript\EnTrinetOrderScript;
use EnTrinetPlans\EnTrinetPlans;
use EnTrinetWarehouse\EnTrinetWarehouse;
use EnTrinetTestConnection\EnTrinetTestConnection;

/**
 * Load classes.
 * Class EnTrinetLoad
 * @package EnTrinetLoad
 */
if (!class_exists('EnTrinetLoad')) {

    class EnTrinetLoad
    {
        /**
         * Load classes of App Name plugin
         */
        static public function Load()
        {
            new EnTrinetMessage();
            new EnTrinetPlans();
            EnTrinetConfig::do_config();
            new \WC_EnTrinetShippingRates();

            if (is_admin()) {
                new EnTrinetWarehouse();
                new EnTrinetTestConnection();
                new EnTrinetLocationAjax();
                new EnTrinetOrderRates();
                new EnTrinetOrderScript();
                !class_exists('EnOrderWidget') ? new EnTrientOrderWidget() : '';
                !class_exists('EnCsvExport') ? new EnTrinetCsvExport() : '';
            }
        }
    }
}