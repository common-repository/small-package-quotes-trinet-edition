jQuery(document).ready(function () {

    // Common settings.
    jQuery('#en_connection_settings_username_trinet').closest('table').attr('id', 'en_trinet_connection_settings');
    jQuery('#en_trinet_residential_delivery').closest('table').attr('id', 'en_trinet_quote_settings');
    jQuery("#order_shipping_line_items .shipping .display_meta").css('display', 'none');

    // Quote Settings Tab
    if (jQuery('#en_trinet_quote_settings').length > 0) {

        jQuery(".en_trinet_disabled").on('click', function () {
            return false;
        });

        // Always include lift gate delivery when a residential address is detected.
        jQuery(".en_woo_addons_liftgate_with_auto_residential_trinet").attr("disabled", true);

        jQuery('.en_trinet_domestic_service,.en_trinet_international_service').closest('tr').addClass('en_trinet_services');
        jQuery('.en_trinet_service_checkbox').closest('tr').addClass('en_trinet_service_checkbox');
        jQuery('.en_trinet_service_markup').closest('tr').addClass('en_trinet_service_markup');
        jQuery('.en_trinet_service_hide').closest('tr').addClass('en_trinet_service_hide');
        jQuery('.en_trinet_service_heading').closest('tr').addClass('en_trinet_service_heading');
        jQuery('.en_trinet_shipment_day').closest('tr').addClass('en_trinet_shipment_day');
        jQuery('.en_trinet_all_shipment').closest('tr').addClass('en_trinet_all_shipment');
        jQuery('.en_trinet_service_all_select').closest('tr').addClass('en_trinet_service_all_select');

        // Delivery estimate options changed
        jQuery("input[name=en_delivery_estimate_options_trinet]").on('change load', function () {
            var en_delivery_estimate_val = jQuery('input[name=en_delivery_estimate_options_trinet]:checked').val();
            if (en_delivery_estimate_val == 'dont_show_estimates') {
                jQuery("#en_trinet_cutt_off_time").prop('disabled', true);
                jQuery("#en_trinet_fulfilment_offset_days").prop('disabled', true);
            } else {
                jQuery("#en_trinet_cutt_off_time").prop('disabled', false);
                jQuery("#en_trinet_fulfilment_offset_days").prop('disabled', false);
            }
        });

        let en_trinet_cutt_off_time = jQuery('#en_trinet_cutt_off_time').val().length > 0 ? jQuery('#en_trinet_cutt_off_time').val() : '';
        jQuery('#en_trinet_cutt_off_time').wickedpicker({
            now: en_trinet_cutt_off_time,
            title: 'Cut Off Time'
        });

        // What days do you ship orders?
        jQuery(".en_trinet_shipment_day input[type=checkbox]").on('change load', function () {
            var enabled = jQuery('.en_trinet_shipment_day input[type=checkbox]:checked').length;
            var disabled = jQuery('.en_trinet_shipment_day input[type=checkbox]').length;
            let action = enabled === disabled ? true : false;
            jQuery('#en_trinet_all_shipment').prop('checked', action);
        });

        jQuery('#en_trinet_all_shipment').on('change', function () {
            if (this.checked) {
                jQuery(".en_trinet_shipment_day input[type=checkbox]").prop('checked', true);
            } else {
                jQuery(".en_trinet_shipment_day input[type=checkbox]").prop('checked', false);
            }
        });

        // Domestic Services
        jQuery(".en_trinet_service_checkbox .en_trinet_domestic_service").on('change load', function () {
            var enabled = jQuery('.en_trinet_service_checkbox .en_trinet_domestic_service:checked').length;
            var disabled = jQuery('.en_trinet_service_checkbox .en_trinet_domestic_service').length;
            let action = enabled === disabled ? true : false;
            jQuery('#en_trinet_domestic_selective').prop('checked', action);
        });

        jQuery('#en_trinet_domestic_selective').on('change', function () {
            if (this.checked) {
                jQuery(".en_trinet_service_checkbox .en_trinet_domestic_service").prop('checked', true);
            } else {
                jQuery(".en_trinet_service_checkbox .en_trinet_domestic_service").prop('checked', false);
            }
        });

        // International Services
        jQuery(".en_trinet_service_checkbox .en_trinet_international_service").on('change load', function () {
            var enabled = jQuery('.en_trinet_service_checkbox .en_trinet_international_service:checked').length;
            var disabled = jQuery('.en_trinet_service_checkbox .en_trinet_international_service').length;
            let action = enabled === disabled ? true : false;
            jQuery('#en_trinet_international_selective').prop('checked', action);
        });

        jQuery('#en_trinet_international_selective').on('change', function () {
            if (this.checked) {
                jQuery(".en_trinet_service_checkbox .en_trinet_international_service").prop('checked', true);
            } else {
                jQuery(".en_trinet_service_checkbox .en_trinet_international_service").prop('checked', false);
            }
        });

        jQuery("#en_trinet_residential_delivery," +
            "#en_quote_settings_availability_auto_residential_trinet," +
            "#en_trinet_all_shipment," +
            ".en_trinet_shipment_day," +
            "#en_trinet_transit_days," +
            "#en_trinet_cutt_off_time," +
            "#en_trinet_hazardous_material_settings," +
            "#en_trinet_hazardous_material_settings_ground_fee," +
            "#en_trinet_hazardous_material_settings_international_fee," +
            "#en_trinet_fulfilment_offset_days"
        ).closest('tr').addClass("en_quote_settings_sub_options");

        // Making the generic function regarding validation which will work for all text fields.
        jQuery('#en_trinet_quote_settings').parents().find('.button-primary').on('click', function (event) {

            let en_validate_settings = {};
            let en_data_error = true;

            en_validate_settings['#en_trinet_handling_fee'] = {
                'en_data_type': 'isNumeric',
                'en_decimal': true,
                'en_after_decimal': 2,
                'en_add_percentage': true,
                'en_minus_sign': true,
                'en_max_length': false,
                'en_error_msg': 'Handling fee format should be 100.20 or 10% and only 2 digits are allowed after decimal point.',
            };

            en_validate_settings['#en_trinet_hazardous_material_settings_ground_fee'] = {
                'en_data_type': 'isNumeric',
                'en_decimal': true,
                'en_after_decimal': 2,
                'en_add_percentage': true,
                'en_minus_sign': true,
                'en_max_length': false,
                'en_error_msg': 'Ground hazardous material fee format should be 100.20 or 10%.',
            };

            en_validate_settings['#en_trinet_hazardous_material_settings_international_fee'] = {
                'en_data_type': 'isNumeric',
                'en_decimal': true,
                'en_after_decimal': 2,
                'en_add_percentage': true,
                'en_minus_sign': true,
                'en_max_length': false,
                'en_error_msg': 'Air hazardous material fee format should be 100.20 or 10%.',
            };

            en_validate_settings['#en_trinet_fulfilment_offset_days'] = {
                'en_data_type': 'isNumeric',
                'en_decimal': false,
                'en_after_decimal': 0,
                'en_add_percentage': false,
                'en_minus_sign': false,
                'en_max_length': 1,
                'en_error_msg': 'Entered Days are not valid.',
            };

            en_validate_settings['#en_trinet_transit_days'] = {
                'en_data_type': 'isNumeric',
                'en_decimal': false,
                'en_after_decimal': 0,
                'en_add_percentage': false,
                'en_minus_sign': false,
                'en_max_length': 2,
                'en_error_msg': 'Maximum 2 numeric characters are allowed for transit day field.',
            };

            en_validate_settings['#en_trinet_checkout_error_message'] = {
                'en_data_type': 'isNotEmpty',
                'en_decimal': false,
                'en_after_decimal': 0,
                'en_add_percentage': false,
                'en_minus_sign': false,
                'en_max_length': 250,
                'en_error_msg': 'Error message field should not be empty. Maximum of 250 alpha numeric characters allowed.',
            };

            en_validate_settings['.en_trinet_service_markup'] = {
                'en_data_type': 'isNumeric',
                'en_decimal': true,
                'en_after_decimal': 2,
                'en_add_percentage': true,
                'en_minus_sign': true,
                'en_max_length': false,
                'en_error_msg': 'Service Level Markup fee format should be 100.20 or 10%',
            };

            jQuery('.en_settings_message').remove();

            jQuery.each(en_validate_settings, function (index, item) {

                let is_data = jQuery(index).val();

                let is_regex_decimal = typeof item.en_decimal !== undefined && item.en_decimal ? '?:\\.?' : '';
                let is_regex_after_decimal = typeof item.en_after_decimal !== undefined && is_regex_decimal.length > 0 ? item.en_after_decimal : '';
                let is_regex_add_percentage = typeof item.en_add_percentage !== undefined && item.en_add_percentage ? '%?' : '';
                let is_regex_minus_sign = typeof item.en_minus_sign !== undefined && item.en_minus_sign ? '-?' : '';
                let is_regex_en_max_length = typeof item.en_max_length !== undefined && item.en_max_length ? item.en_max_length : 0;
                // let is_data_regex = typeof item.en_data_type !== undefined && item.en_data_type == 'isNumeric' ? '^' + is_regex_minus_sign + '\\d*(?:\\.?\\d{0,' + is_regex_after_decimal + '}?)' + is_regex_add_percentage + '$' : '';

                let is_data_regex = '';
                if (typeof item.en_data_type !== undefined) {
                    switch (item.en_data_type) {
                        case "isNumeric":
                            is_data_regex = '^' + is_regex_minus_sign + '\\d*(' + is_regex_decimal + '\\d{0,' + is_regex_after_decimal + '}?)' + is_regex_add_percentage + '$';
                            break;
                        case "isNotEmpty":
                            is_data_regex = '^[0-9a-zA-Z_\\. ]+$';
                            if (index == '#en_quote_settings_checkout_error_message_trinet') {
                                is_data_regex = jQuery("input[name='en_quote_settings_option_select_when_unable_retrieve_shipping_trinet']").is(':checked') ? is_data_regex : '';
                            }
                            break;
                    }
                }

                let en_error_msg = typeof item.en_error_msg !== undefined ? item.en_error_msg : '';
                let is_data_valid = true;
                // Service level markup validation
                if (index.length > 0) {
                    jQuery(index).each(function (ind, obj) {
                        let is_data = jQuery(obj).val();
                        let is_data_valid_in_repeat = is_validate_regex(is_data, is_data_regex);
                        !is_data_valid_in_repeat ? is_data_valid = false : '';
                    });
                } else {
                    is_data_valid = is_validate_regex(is_data, is_data_regex);
                }

                if (!is_data_valid || (is_data_valid && is_regex_en_max_length > 0 && typeof is_data !== undefined && is_data.length > is_regex_en_max_length)) {
                    en_data_error = false;
                    jQuery('.subsubsub').next('.clear').after('<div class="notice notice-error en_settings_message"><p><strong>Error! </strong>' + en_error_msg + '</p></div>');
                }
            });

            if (!en_data_error) {
                jQuery('#en_settings_message').delay(200).animate({scrollTop: 0}, 1000);
                jQuery('html, body').animate({scrollTop: 0}, 'slow');
                return false;
            }

            var enabled_international = jQuery('.en_trinet_service_checkbox .en_trinet_international_service:checked').length;
            var enabled_domestic = jQuery('.en_trinet_service_checkbox .en_trinet_domestic_service:checked').length;
            if (!(enabled_international > 0 || enabled_domestic > 0)) {
                jQuery('.en_settings_message').remove();
                jQuery('.subsubsub').next('.clear').after('<div class="notice notice-error en_settings_message"><p><strong>Error! </strong>Please select at least one carrier service.</p></div>');
                jQuery('#en_settings_message').delay(200).animate({scrollTop: 0}, 1000);
                jQuery('html, body').animate({scrollTop: 0}, 'slow');
                return false;
            }

        });
    }

    // Connection Settings Tab
    if (jQuery('#en_trinet_connection_settings').length > 0) {

        jQuery('#en_connection_settings_username_trinet').attr('title', 'Username');
        jQuery('#en_connection_settings_password_trinet').attr('title', 'Password');
        jQuery('#en_connection_settings_account_number_trinet').attr('title', 'Account number');
        jQuery('#en_connection_settings_license_key_trinet').attr('title', 'Plugin License Key');

        jQuery('#en_trinet_connection_settings').before("<div class='en_warning_message'><p>Note! You must have a Trinet Express account to use this application. If you do not have one, call 888.874.6388, or <a href='https://www.trinet.com/' target='_blank' >register</a> online.</p></div>");

        jQuery('#wpfooter').hide();

        /**
         * Add en_location_error class on connection settings page
         */
        jQuery('#en_trinet_connection_settings input[type="text"]').each(function () {
            if (jQuery(this).parent().find('.en_connection_error').length < 1) {
                jQuery(this).after('<span class="en_connection_error"></span>');
            }
        });

        //Append "Test Connection" Btn
        jQuery('.woocommerce-save-button').before('<button name="en_trinet_test_connection" class="button-primary en_trinet_test_connection" id="en_trinet_test_connection" type="submit" value="Test Connection">Test Connection</button>');

        jQuery('.button-primary').on('click', function (event) {
            let validate = en_validate_input('#en_trinet_connection_settings');

            if (validate === false) {
                return false;
            }

            if (event.target.id == 'en_trinet_test_connection') {

                let postForm = {
                    'action': 'en_trinet_test_connection',
                    'en_post_data': jQuery('#en_trinet_connection_settings input').serializeArray(),
                };

                let params = {
                    en_ajax_loading_id: '#en_connection_settings_username_trinet,#en_connection_settings_password_trinet,#en_connection_settings_account_number_trinet,#en_connection_settings_license_key_trinet',
                };

                en_ajax_request(params, postForm, en_action_test_connection);

                return false;
            }
        });
    }
    // fdo va
    jQuery('#fd_online_id_trinet').click(function (e) {
        var postForm = {
            'action': 'trinet_fd',
            'company_id': jQuery('#freightdesk_online_id').val(),
            'disconnect': jQuery('#fd_online_id_trinet').attr("data")
        }
        var id_lenght = jQuery('#freightdesk_online_id').val();
        var disc_data = jQuery('#fd_online_id_trinet').attr("data");
        if(typeof (id_lenght) != "undefined" && id_lenght.length < 1) {
            jQuery(".en_connection_message").remove();
            jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error!</strong> FreightDesk Online ID is Required.</p></div>');
            return;
        }
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: postForm,
            beforeSend: function () {
                jQuery('#freightdesk_online_id').css('background',
                    'rgba(255, 255, 255, 1) url("' + EN_TRINET_DIR_FILE + '' +
                    '/admin/tab/location/assets/images/processing.gif") no-repeat scroll 50% 50%');
            },
            success: function (data_response) {
                if(typeof (data_response) == "undefined"){
                    return;
                }
                var fd_data = JSON.parse(data_response);
                jQuery('#freightdesk_online_id').css('background', '#fff');
                jQuery(".en_connection_message").remove();
                if((typeof (fd_data.is_valid) != 'undefined' && fd_data.is_valid == false) || (typeof (fd_data.status) != 'undefined' && fd_data.is_valid == 'ERROR')) {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error! ' + fd_data.message + '</strong></p></div>');
                }else if(typeof (fd_data.status) != 'undefined' && fd_data.status == 'SUCCESS') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-success en_connection_message"><p><strong>Success! ' + fd_data.message + '</strong></p></div>');
                    window.location.reload(true);
                }else if(typeof (fd_data.status) != 'undefined' && fd_data.status == 'ERROR') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error! ' + fd_data.message + '</strong></p></div>');
                }else if (fd_data.is_valid == 'true') {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error!</strong> FreightDesk Online ID is not valid.</p></div>');
                } else if (fd_data.is_valid == 'true' && fd_data.is_connected) {
                    jQuery('.user_guide_fdo').before('<div class="notice notice-error en_connection_message"><p><strong>Error!</strong> Your store is already connected with FreightDesk Online.</p></div>');

                } else if (fd_data.is_valid == true && fd_data.is_connected == false && fd_data.redirect_url != null) {
                    window.location = fd_data.redirect_url;
                } else if (fd_data.is_connected == true) {
                    jQuery('#con_dis').empty();
                    jQuery('#con_dis').append('<a href="#" id="fd_online_id_trinet" data="disconnect" class="button-primary">Disconnect</a>')
                }
            }
        });
        e.preventDefault();
    });

});

// Update plan
if (typeof en_update_plan != 'function') {
    function en_update_plan(input) {
        let action = jQuery(input).attr('data-action');
        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: {action: action},
            success: function (data_response) {
                window.location.reload(true);
            }
        });
    }
}

if (typeof is_validate_regex != 'function') {
    function is_validate_regex(is_data, is_data_regex) {
        return jQuery.trim(is_data).match(new RegExp(is_data_regex)) ? true : false;
    }
}

/**
 * ==============================================================
 *  Carrier Tab
 * ==============================================================
 */

/**
 * click on carrier checkbox
 */
if (typeof en_action_test_connection != 'function') {
    function en_action_test_connection(params, response) {
        let en_message = '';
        let data = JSON.parse(response);
        let en_class_name = 'notice notice-error en_connection_message';
        jQuery('.en_connection_message').remove();
        let data_severity = typeof data.severity !== undefined ? data.severity : '';
        let data_severity_type = 'Error! ';

        switch (data_severity) {
            case 'SUCCESS':
                en_message = data.Message;
                data_severity_type = 'Success! ';
                en_class_name = 'notice notice-success en_connection_message';
                break;
            case 'ERROR':
                en_message = data.Message;
                break;
            default:
                en_message = 'Unknown error';
                break;
        }

        jQuery('.en_warning_message').after('<div class="' + en_class_name + '"><p><strong>' + data_severity_type + '</strong>' + en_message + '</p></div>');
    }
}

/**
 * ==============================================================
 *  Quote Settings Tab
 * ==============================================================
 */

/**
 * Eniture Validation Form JS
 */
if (typeof en_validate_input != 'function') {
    function en_validate_input(form_id) {
        let has_err = true;
        jQuery(form_id + " input[type='text']").each(function () {

            let input = jQuery(this).val();
            let response = en_validate_string(input);
            let errorText = jQuery(this).attr('title');
            let optional = jQuery(this).data('optional');

            let en_error_element = jQuery(this).parent().find('.en_location_error,.en_connection_error');
            jQuery(en_error_element).html('');

            optional = (optional === undefined) ? 0 : 1;
            errorText = (errorText != undefined) ? errorText : '';

            if ((optional == 0) && (response == false || response == 'empty')) {
                errorText = (response == 'empty') ? errorText + ' is required.' : 'Invalid input.';
                jQuery(en_error_element).html(errorText);
            }
            has_err = (response != true && optional == 0) ? false : has_err;
        });
        return has_err;
    }
}

/**
 * Validate Input String
 */
if (typeof en_validate_string != 'function') {
    function en_validate_string(string) {
        if (string == '')
            return 'empty';
        else
            return true;

    }
}

/**
 * Variable exist
 */
if (typeof en_is_var_exist != 'function') {
    function en_is_var_exist(index, item) {
        return typeof item[index] != 'undefined' ? true : false;
    }
}

/**
 * Ajax common resource
 * @param params.en_ajax_loading_id The loading Path Id
 * @param params.en_ajax_disabled_id The disabled Path Id
 * @param params.en_ajax_loading_msg_btn The message show on button during load
 */
if (typeof en_ajax_request != 'function') {
    function en_ajax_request(params, data, call_back_function) {

        jQuery.ajax({
            type: "POST",
            url: ajaxurl,
            data: data,
            beforeSend: function () {

                (typeof params.en_ajax_loading_id != 'undefined' &&
                    params.en_ajax_loading_id.length > 0) ?
                    jQuery(params.en_ajax_loading_id).css('background',
                        'rgba(255, 255, 255, 1) url("' + EN_TRINET_DIR_FILE + '' +
                        '/admin/tab/location/assets/images/processing.gif") no-repeat scroll 50% 50%') : "";

                (typeof params.en_ajax_disabled_id != 'undefined' &&
                    params.en_ajax_disabled_id.length > 0) ?
                    jQuery(params.en_ajax_disabled_id).prop({disabled: true}) : "";

                (typeof params.en_ajax_loading_msg_btn != 'undefined' &&
                    params.en_ajax_loading_msg_btn.length > 0) ?
                    jQuery(params.en_ajax_loading_msg_btn).addClass('spinner_disable').val("Loading ..") : "";

                (typeof params.en_ajax_loading_msg_ok_btn != 'undefined' &&
                    params.en_ajax_loading_msg_ok_btn.length > 0) ?
                    jQuery(params.en_ajax_loading_msg_ok_btn).addClass('spinner_disable').text("Loading ..") : "";
            },
            success: function (response) {
                (typeof params.en_ajax_loading_id != 'undefined' &&
                    params.en_ajax_loading_id.length > 0) ?
                    jQuery(params.en_ajax_loading_id).removeAttr('style') : "";

                (typeof params.en_ajax_disabled_id != 'undefined' &&
                    params.en_ajax_disabled_id.length > 0) ?
                    jQuery(params.en_ajax_disabled_id).prop({disabled: false}) : "";

                (typeof params.en_ajax_loading_msg_btn != 'undefined' &&
                    params.en_ajax_loading_msg_btn.length > 0) ?
                    jQuery(params.en_ajax_loading_msg_btn).removeClass('spinner_disable').val("Save") : "";

                (typeof params.en_ajax_loading_msg_ok_btn != 'undefined' &&
                    params.en_ajax_loading_msg_ok_btn.length > 0) ?
                    jQuery(params.en_ajax_loading_msg_ok_btn).removeClass('spinner_disable').text("Ok") : "";

                return call_back_function(params, response);
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(textStatus, errorThrown);
            }
        });
    }
}
