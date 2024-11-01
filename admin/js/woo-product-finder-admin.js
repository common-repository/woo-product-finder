(function($) {
    'use strict';
    $(window).on('load',function() {
        $('a[href="admin.php?page=wpfp-list"]').parents().addClass( 'current wp-has-current-submenu' );
        $('a[href="admin.php?page=wpfp-list"]').addClass( 'current' );

        var admin_path = wizard_path.WizardPath;
        jQuery('.attribute-value').chosen({max_selected_options: 1});

        jQuery('.multiselect2').chosen();
        $('#wpfp_free_dialog').dialog({
            modal: true, title: 'Subscribe To Our Newsletter', zIndex: 10000, autoOpen: true,
            width: '500', resizable: false,
            position: {my: 'center', at: 'center', of: window},
            dialogClass: 'dialogButtons',
            buttons: [
                {
                    id: 'Delete',
                    text: 'YES',
                    click: function() {
                        // $(obj).removeAttr('onclick');
                        // $(obj).parents('.Parent').remove();
                        var email_id = jQuery('#txt_user_sub_wprw_free').val();
                        var data = {
                            'action': 'wp_add_plugin_userfn_free_wpfp',
                            'email_id': email_id
                        };
                        // since 2.8 ajaxurl is always defined in the admin header and points to admin-ajax.php
                        jQuery.post(ajaxurl, data, function() {
                            jQuery('#wpfp_free_dialog').html('<h2>You have been successfully subscribed');
                            jQuery('.ui-dialog-buttonpane').remove();
                        });
                    }
                },
                {
                    id: 'No',
                    text: 'No, Remind Me Later',
                    click: function() {

                        jQuery(this).dialog('close');
                    }
                },
            ]
        });
        jQuery('div.dialogButtons .ui-dialog-buttonset button').removeClass('ui-state-default');
        jQuery('div.dialogButtons .ui-dialog-buttonset button').addClass('button-primary woocommerce-save-button');

        jQuery('#backend_limit,#show_attribute_field').keyup(function() {
            this.value = this.value.replace(/[^0-9\+]/g, '');
        });
        jQuery('.wp-color-picker-field').wpColorPicker();
        jQuery('table#wizard-listing tbody').sortable({
            axis: 'y',
            stop: function() {
                var wizard_sortable_data = jQuery(this).sortable('serialize', {key: 'string'});
                var wizard_sortable_data_arr = wizard_sortable_data.split('&');
                var i = 0;
                var pageNum = jQuery('.wpfp-pagination-link ul li.selected').attr('p');
                var numRecords = jQuery('#all_wizards_count').val();
                var str = '';
                for (i; i < wizard_sortable_data_arr.length; i++) {
                    if (str !== '') {
                        str += ',';
                    }
                    str += wizard_sortable_data_arr[i].slice(7);
                }
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'wpfp_sortable_wizard_list_based_on_id',
                        pagenum: pageNum,
                        limit: numRecords,
                        wizard_sortable_data: str
                    },
                    success: function() {
                    }
                });
            }
        });
        //jQuery('table#question_list_table tbody').sortable();
        jQuery('#detete_all_selected_question').attr('disabled', 'disabled');
        /*Table Sorter*/
        jQuery('.tablesorter').tablesorter({
            headers: {
                0: {
                    sorter: false
                },
                4: {
                    sorter: false
                }
            }
        });

        /*Accordian section for option section*/
        jQuery('#accordion').accordion({
            header: '> div > h3',
            collapsible: true,
            active: false,
            autoHeight: false,
            autoFill: true,
            autoActivate: true,
            beforeActivate: function(event,ui) {
                // The accordion believes a panel is being opened
                var currHeader;
                var currContent;
                if (ui.newHeader[0]) {
                    currHeader = ui.newHeader;
                    currContent = currHeader.next('.ui-accordion-content');
                    // The accordion believes a panel is being closed
                } else {
                    currHeader = ui.oldHeader;
                    currContent = currHeader.next('.ui-accordion-content');
                }
                // Since we've changed the default behavior, this detects the actual status
                var isPanelSelected = currHeader.attr('aria-selected') === 'true';
                // Toggle the panel's header
                currHeader.toggleClass('ui-corner-all', isPanelSelected).toggleClass('accordion-header-active ui-state-active ui-corner-top', !isPanelSelected).attr('aria-selected', ((!isPanelSelected).toString()));
                // Toggle the panel's icon
                currHeader.children('.ui-icon').toggleClass('ui-icon-triangle-1-e', isPanelSelected).toggleClass('ui-icon-triangle-1-s', !isPanelSelected);
                // Toggle the panel's content
                currContent.toggleClass('accordion-content-active', !isPanelSelected);
                if (isPanelSelected) {
                    currContent.slideUp();
                } else {
                    currContent.slideDown();
                }

                return false; // Cancels the default action
            }
        });

        jQuery(function() {
            jQuery('#accordion')
                    .accordion({
                        header: '> div > h3'
                    })
                    .sortable({
                        axis: 'y',
                        handle: 'h3',
                        stop: function() {
                            var sortable_option_data = jQuery(this).sortable('serialize', {key: 'string'});
                            sortable_option_data = sortable_option_data.substr(0, sortable_option_data.lastIndexOf('&'));
                            var option_sortable_data_arr = sortable_option_data.split('&');
                            var i = 0;
                            var str = '';
                            for (i; i < option_sortable_data_arr.length; i++) {
                                if (str !== '') {
                                    str += ',';
                                }
                                str += option_sortable_data_arr[i].slice(7);
                            }
                            var url_parameters = getUrlVars();
                            var current_wizard_id = url_parameters['wrd_id']; // jshint ignore:line
                            var current_question_id = url_parameters['que_id']; // jshint ignore:line
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: 'wpfp_sortable_option_list_based_on_id',
                                    wizard_id: current_wizard_id,
                                    question_id: current_question_id,
                                    option_sortable_data: str
                                },
                                success: function() {
                                    //alert(response);
                                }
                            });
                        }
                    }).on('stop', function() {
                jQuery(this).children().each(function(i) {
                    jQuery(this).data('index', i);
                });
            }).trigger('stop');
        });

        /*Get last url parameters*/
        function getUrlVars()
        {
            var vars = [], hash;
            var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
            for (var i = 0; i < hashes.length; i++)
            {
                hash = hashes[i].split('=');
                vars.push(hash[0]);
                vars[hash[0]] = hash[1];
            }
            return vars;
        }

        /*Display record when page is loaded in wizard section*/
        jQuery(document).ready(function() {
            var url_parameters = getUrlVars();
            var current_wizard_id = url_parameters['wrd_id']; // jshint ignore:line
            displayRecords(current_wizard_id, 5, 1);
        });

        /*Check all checkbox wizard*/
        jQuery('body').on('click', '#chk_all_wizard', function() {
            jQuery('input.chk_single_wizard:checkbox').not(this).prop('checked', this.checked);

            var numberOfChecked = jQuery('input[name="chk_single_wizard_chk"]:checked').length;
            if (numberOfChecked >= 1) {
                jQuery('#detete_all_selected_wizard').removeAttr('disabled');
            } else {
                jQuery('#detete_all_selected_wizard').attr('disabled', 'disabled');
            }
        });

        /*Check single checkbox wizard*/
        jQuery('body').on('click', '.chk_single_wizard', function() {
            var numberOfChecked = jQuery('input[name="chk_single_wizard_chk"]:checked').length;
            if (numberOfChecked >= 1) {
                jQuery('#detete_all_selected_wizard').removeAttr('disabled');
            } else {
                jQuery('#detete_all_selected_wizard').attr('disabled', 'disabled');
            }
        });

        /*Get all checkbox checked value*/
        jQuery('body').on('click', '#detete_all_selected_wizard', function() {
            var numberOfChecked = jQuery('input[name="chk_single_wizard_chk"]:checked').length;
            if (numberOfChecked >= 1) {
                var confrim = confirm('Are you sure want to delete selected wizard?');
                if (confrim === true) {
                    var selected_wizard_arr = [];
                    jQuery.each(jQuery('input[name="chk_single_wizard_chk"]:checked'), function() {
                        selected_wizard_arr.push(jQuery(this).val());
                    });
                    var selected_wizard = selected_wizard_arr;//.join(', ')
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'wpfp_delete_selected_wizard_using_checkbox',
                            selected_wizard_id: selected_wizard
                        },
                        success: function(response) {
                            if (jQuery.trim(response) === 'true') {
                                jQuery.each(selected_wizard, function(index, value) {
                                    jQuery('#wizard_row_' + value).remove();
                                });
                            } else {

                            }
                        }
                    });
                } else {
                    return false;
                }
            }
        });

        /*Delete single wizard using delete button*/
        jQuery('body').on('click', '.delete_single_selected_wizard', function() {
            var single_selected_wizard = jQuery(this).attr('id');
            var single_selected_wizard_int_id = single_selected_wizard.substr(single_selected_wizard.lastIndexOf('_') + 1);
            var confrim = confirm('Are you sure want to delete this wizard?');
            if (confrim === true) {
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'wpfp_delete_single_wizard_using_button',
                        single_selected_wizard_id: single_selected_wizard_int_id
                    },
                    success: function(response) {
                        if (jQuery.trim(response) === 'true') {
                            jQuery('#wizard_row_' + single_selected_wizard_int_id).remove();
                        } else {

                        }
                    }
                });
            } else {
                return false;
            }
        });

        /*Check all checkbox wizard*/
        jQuery('body').on('click', '#chk_all_question', function() {
            jQuery('input.chk_single_question:checkbox').not(this).prop('checked', this.checked);

            var numberOfChecked = jQuery('input[name="chk_single_question_name"]:checked').length;
            if (numberOfChecked >= 1) {
                jQuery('#detete_all_selected_question').removeAttr('disabled');
            } else {
                jQuery('#detete_all_selected_question').attr('disabled', 'disabled');
            }
        });

        /*Check single checkbox question*/
        jQuery('body').on('click', '.chk_single_question', function() {
            var numberOfChecked = jQuery('input[name="chk_single_question_name"]:checked').length;
            if (numberOfChecked >= 1) {
                jQuery('#detete_all_selected_question').removeAttr('disabled');
            } else {
                jQuery('#detete_all_selected_question').attr('disabled', 'disabled');
            }
        });

        /*Get all checkbox checked value*/
        jQuery('body').on('click', '#detete_all_selected_question', function() {
            var numberOfChecked = jQuery('input[name="chk_single_question_name"]:checked').length;
            if (numberOfChecked >= 1) {
                var confrim = confirm('Are you sure want to delete selected questions?');
                if (confrim === true) {
                    var selected_question_arr = [];
                    jQuery.each(jQuery('input[name="chk_single_question_name"]:checked'), function() {
                        selected_question_arr.push(jQuery(this).val());
                    });
                    var selected_question = selected_question_arr;//.join(', ')
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'wpfp_delete_selected_question_using_checkbox',
                            selected_question_id: selected_question
                        },
                        success: function(response) {
                            if (jQuery.trim(response) === 'true') {
                                jQuery.each(selected_question, function(index, value) {
                                    jQuery('#after_updated_question_' + value).remove();
                                });
                            } else {

                            }
                        }
                    });
                } else {
                    return false;
                }
            }
        });

        /*Delete single questions using delete button*/
        jQuery('body').on('click', '.delete_single_question_using_button', function(e) {
            e.preventDefault();
            var confrim = confirm('Are you sure want to delete this questions?');
            if (confrim === true) {
                var single_selected_question = jQuery(this).attr('id');
                var single_selected_question_int_id = single_selected_question.substr(single_selected_question.lastIndexOf('_') + 1);
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'wpfp_delete_single_question_using_button',
                        single_selected_question_id: single_selected_question_int_id
                    },
                    success: function(response) {
                        if (jQuery.trim(response) === 'true') {
                            jQuery('#after_updated_question_' + single_selected_question_int_id).remove();
                        } else {

                        }
                    }
                });
            } else {
                return false;
            }
        });

        /*Add new options*/
        jQuery('body').on('click', '#add_new_options', function() {
            var url_parameters = getUrlVars();
            var current_wizard_id = url_parameters['wrd_id']; // jshint ignore:line

            var fetchOptionLabel = JSON.parse(optionLabelDetails.option_label);
            var fetchOptionLabelDescription = JSON.parse(optionLabelDetails.option_lable_description);
            var fetchOptionLabelPlaceholder = JSON.parse(optionLabelDetails.option_lable_placeholder);
            var fetchOptionImageLabel = JSON.parse(optionLabelDetails.option_image_lable);
            var fetchOptionErrorName = JSON.parse(optionLabelDetails.option_name_error);
            var fetchOptionImageSelectFile = JSON.parse(optionLabelDetails.option_image_select_file);
            var fetchOptionImageUploadImage = JSON.parse(optionLabelDetails.option_image_upload_image);
            var fetchOptionImageDescription = JSON.parse(optionLabelDetails.option_image_description);
            var fetchOptionImageError = JSON.parse(optionLabelDetails.option_image_error);
            var fetchOptionAttributeError = JSON.parse(optionLabelDetails.option_attribute_error);
            var fetchOptionAttributeLabel = JSON.parse(optionLabelDetails.option_attribute_lable);
            var fetchOptionAttributeDescription = JSON.parse(optionLabelDetails.option_attribute_description);
            var fetchOptionAttributePlaceholder = JSON.parse(optionLabelDetails.option_attribute_placeholder);
            var fetchOptionValueLabel = JSON.parse(optionLabelDetails.option_value_lable);
            var fetchOptionValueDescription = JSON.parse(optionLabelDetails.option_value_description);
            var fetchOptionValuePlaceholder = JSON.parse(optionLabelDetails.option_value_placeholder);
            var fetchOptionValueError = JSON.parse(optionLabelDetails.option_value_error);
            var fetchTotalCountOptionId = jQuery.trim(JSON.parse(optionLabelDetails.last_option_id_option_tbl));
            var fetchOptionNextLabel = JSON.parse(optionLabelDetails.option_next_label);
            var fetchOptionNextDescription = JSON.parse(optionLabelDetails.option_next_description);
            var fetchOptionNextValue = JSON.parse(optionLabelDetails.option_next_values);
            
            if( fetchOptionNextValue === '' ){
                fetchOptionNextValue = '<option>The list of questions will appear once you save a question.</option>';
            }
            if (fetchTotalCountOptionId === '0' || fetchTotalCountOptionId === '') {
                fetchTotalCountOptionId = '1';
            }
            // console.log('fetchTotalCountOptionId'+fetchTotalCountOptionId);

            var total_count_options = jQuery('.options_rank_class').length;
            // console.log('total_count_options'+total_count_options);

            var x = +fetchTotalCountOptionId + +total_count_options; // jshint ignore:line
            if (x === '0') {
                x = '1';
            } else {
                x = +fetchTotalCountOptionId + +total_count_options; // jshint ignore:line
            }

            var option_title = 'Options';
            var append_new_row = '';
            append_new_row += '<div class="options_rank_class" id="options_rank_' + x + '">';
            append_new_row += '<input type="hidden" name="options_id[][' + x + ']" value="' + x + '">';
            append_new_row += '<h3>' + option_title;
            append_new_row += '<a href="javascript:void(0);" class="ajax_remove_field_pro delete" id="remove_option_' + x + '"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
            append_new_row += '</h3>';
            append_new_row += '<div>';
            append_new_row += '<table class="form-table table-outer product-fee-table" id="option_section">';
            append_new_row += '<tbody>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="options_name">' + fetchOptionLabel + '<span class="required-star">*</span></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<input type="text" name="options_name[][' + x + ']" class="text-class half_width" id="options_name_id_' + x + '" value="" required="1" placeholder="' + fetchOptionLabelPlaceholder + '">';
            append_new_row += '<span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionLabelDescription + '</p>';
            append_new_row += '<br/><span class="error_msg" id="error_option_name_' + x + '" style="display:none;">' + fetchOptionErrorName + '</span>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="options_image">' + fetchOptionImageLabel + ' <div class="pf-pro-label"></div></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip option_image_section">';
            append_new_row += '<div class="product_cost_left_div">';
            append_new_row += '<a class="option_single_upload_file button-secondary" disabled="disabled" uploader_title="' + fetchOptionImageSelectFile + '" uploader_button_text="Include File" data-uploadname="option_single_upload_file">' + fetchOptionImageUploadImage + '</a>';
            //append_new_row += '<a class="option_single_remove_file button-secondary" id="option_single_remove_file_id_' + x + '" data-uploadname="option_single_upload_file">' + fetchOptionImageRemoveImage + '</a>';
            append_new_row += '<span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionImageDescription + '</p>';
            append_new_row += '<br/><span class="error_msg" id="error_option_image_file_' + x + '" style="display:none;">' + fetchOptionImageError + '</span>';
            append_new_row += '</div>';
            append_new_row += '<div class="option_single_upload_file_div">';
            append_new_row += '<img class="option_single_image_src" id="option_single_upload_file_id_' + x + '" name="option_single_upload_file_name[][' + x + ']" style="display:none;" src="" width="100px" height="100px"/>';
            append_new_row += '<input type="hidden" name="hf_option_single_upload_file_src[][' + x + ']" id="hf_option_single_upload_file_src_' + x + '" value="">';
            append_new_row += '</div>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="attribute_name">' + fetchOptionAttributeLabel + '<span class="required-star">*</span></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<select id="attribute_name_' + x + '" data-placeholder="' + fetchOptionAttributePlaceholder + '" name="attribute_name[][' + x + ']" class="chosen-select-attribute-value attribute-value chosen-rtl">';
            append_new_row += '<option value=""></option>';
            append_new_row += '</select>';
            append_new_row += '<span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionAttributeDescription + '</p>';
            append_new_row += '<br/><span class="error_msg" id="error_attribute_name_' + x + '" style="display:none;">' + fetchOptionAttributeError + '</span>';
            append_new_row += '</td>';
            append_new_row += '</tr>';
            append_new_row += '<tr valign="top" class="attribute_value_tr">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="attributr_value">' + fetchOptionValueLabel + '<span class="required-star">*</span></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<select id="attribute_value_' + x + '" data-placeholder="' + fetchOptionValuePlaceholder + '" name="attribute_value[][' + x + ']" multiple="true" class="chosen-select-attribute-value category-select chosen-rtl">';

            append_new_row += '</select>';
            append_new_row += '<span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionValueDescription + '</p>';
            append_new_row += '<br/><span class="error_msg" id="error_attribute_value_' + x + '" style="display:none;">' + fetchOptionValueError + '</span>';
            append_new_row += '</td>';
            append_new_row += '</tr>';

            append_new_row += '<tr valign="top" class="attribute_next_tr">';
            append_new_row += '<th class="titledesc" scope="row">';
            append_new_row += '<label for="attributr_next">'+ fetchOptionNextLabel +'<span class="required-star"></span></label>';
            append_new_row += '</th>';
            append_new_row += '<td class="forminp mdtooltip">';
            append_new_row += '<select id="attribute_next_' + x + '" name="attribute_next[][' + x + ']" class="attribute_next">';
            append_new_row += fetchOptionNextValue;
            append_new_row += '</select>';
            append_new_row += '<span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>';
            append_new_row += '<p class="description">' + fetchOptionNextDescription + '</p>';
            append_new_row += '</td>';
            append_new_row += '</tr>';

            append_new_row += '</tbody>';
            append_new_row += '</table>';
            append_new_row += '</div>';
            append_new_row += '</div>';
            jQuery('#extra_div').before(append_new_row);//submit_options
            jQuery('#accordion').accordion('refresh');
            jQuery('.accordian_custom_class:last select').chosen();
            jQuery('body').on('keyup', '#attribute_name_' + x + '_chosen input', function() {
                jQuery('#attribute_name_' + x + '_chosen .chosen-drop ul li.no-results').html('Please enter 3 or more characters');
                var value = jQuery(this).val();
                var valueCount = value.length;
                var remainCount = 3 - valueCount;
                if (valueCount >= 3) {
                    jQuery('#attribute_name_' + x + '_chosen .chosen-drop ul li.no-results').html('<img src="' + admin_path + '/images/ajax-loader.gif">');
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            'action': 'wpfp_get_woocommerce_product_attribute_name_list_ajax',
                            'value': value,
                            'wizard_id': current_wizard_id
                        }, beforeSend: function() {

                        }, complete: function() {
                            jQuery('#attribute_value_' + x + '_chosen ul img').remove();
                        }, success: function(response) {
                            if (response.length !== 0) {
                                jQuery('#attribute_name_' + x + ' option:first').after(response);
                                jQuery('#attribute_name_' + x + ' option').each(function() {
                                    jQuery(this).siblings("[value='" + addslashes(this.value) + "']").remove(); // jshint ignore:line
                                });
                                jQuery('#attribute_name_' + x).trigger('chosen:updated');
                                jQuery('#attribute_name_' + x + ' .search-field input').val(value);
                                jQuery('#attribute_name_' + x + ' ul li.no-results').html('');
                            } else {
                                jQuery('#attribute_name_' + x + ' option').not(':selected').remove();
                            }
                        }
                    });
                } else {
                    if (remainCount > 0) {
                        jQuery('#attribute_name_' + x + '_chosen .chosen-drop ul li.no-results').html('Please enter ' + remainCount + ' or more characters');
                    }
                }
            });
            jQuery('.multiselect2').chosen();
            jQuery('body').on('change', '#attribute_name_' + x, function() {
                var attribute_db_name = jQuery('option:selected', this).attr('data-name');
                var attribute_value_db = jQuery('option:selected', this).attr('data-value1');
                var url_parameters = getUrlVars();
                var current_wizard_id = url_parameters['wrd_id']; // jshint ignore:line
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'wpfp_get_attributes_value_based_on_attribute_name',
                        current_wizard_id: current_wizard_id,
                        attribute_name: attribute_db_name,
                        attribute_value: attribute_value_db
                    }, beforeSend: function() {
                        jQuery('#attribute_value_' + x + '_chosen ul.chosen-choices li input').before('<img src="' + admin_path + '/images/ajax-loader.gif">');
                        jQuery('#attribute_value_' + x + '_chosen ul.chosen-choices li input').hide();
                    }, complete: function() {
                        jQuery('#attribute_value_' + x + '_chosen ul.chosen-choices li img').remove();
                        jQuery('#attribute_value_' + x + '_chosen ul.chosen-choices li input').show();
                    }, success: function(response) {
                        jQuery('#attribute_value_' + x).html(response);
                        jQuery('#attribute_value_' + x).trigger('chosen:updated');
                    }
                });
            });
        });

        /* Validation */
        jQuery('body').on('click', '#submitWizardQuestion', function() {
            var flag = '0';
            jQuery('.options_rank_class').each(function() {
                var options_rank_id = jQuery(this).attr('id');
                var options_rank_int_id = options_rank_id.substr(options_rank_id.lastIndexOf('_') + 1);
                jQuery('#options_rank_' + options_rank_int_id).each(function() {
                    var option_title = jQuery.trim(jQuery('#options_name_id_' + options_rank_int_id).val());
                    if (option_title === '') {
                        flag = '1';
                        jQuery('#error_option_name_' + options_rank_int_id).show();
                    } else {
                        jQuery('#error_option_name_' + options_rank_int_id).hide();
                    }
                    if (jQuery('#attribute_name_' + options_rank_int_id + '_chosen').find('a').hasClass('chosen-default')) {
                        flag = '1';
                        jQuery('#error_attribute_name_' + options_rank_int_id).show();
                    } else {
                        jQuery('#error_attribute_name_' + options_rank_int_id).hide();
                    }
                    var option_image = jQuery.trim(jQuery('#hf_option_single_upload_file_src_' + options_rank_int_id).val());
                    if (option_image !== '') {
                        var src = option_image; // 'static/images/banner/blue.jpg'
                        var tarr = src.split('/');      // ['static','images','banner','blue.jpg']
                        var file = tarr[tarr.length - 1]; // 'blue.jpg'
                        var extension = file.split('.')[1];  // 'blue'
                        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) === -1) {
                            flag = '1';
                            jQuery('#error_option_image_file_' + options_rank_int_id).show();
                        } else {
                            jQuery('#error_option_image_file_' + options_rank_int_id).hide();
                        }
                    }
                    var attribute_value = jQuery('#attribute_value_' + options_rank_int_id + '_chosen').find('ul').find('li').length;
                    if (attribute_value <= 1) {
                        flag = '1';
                        jQuery('#error_attribute_value_' + options_rank_int_id).show();
                    } else {
                        jQuery('#error_attribute_value_' + options_rank_int_id).hide();
                    }
                    if (option_image !== '') {
                        var src = option_image; // jshint ignore:line
                        var tarr = src.split('/');      // jshint ignore:line
                        var file = tarr[tarr.length - 1]; // jshint ignore:line
                        var extension = file.split('.')[1];  // jshint ignore:line
                        if (jQuery.inArray(extension, ['gif', 'png', 'jpg', 'jpeg']) === -1) {
                            jQuery('#options_rank_' + options_rank_int_id).find('h3').attr('style', 'border-color: red !important');
                        } else {
                            jQuery('#options_rank_' + options_rank_int_id).find('h3').attr('style', 'border-color: none');
                        }
                    }
                    if (option_title == '' || jQuery('#attribute_name_' + options_rank_int_id + '_chosen').find('a').hasClass('chosen-default') || attribute_value <= 1) { // jshint ignore:line
                        jQuery('#options_rank_' + options_rank_int_id).find('h3').attr('style', 'border-color: red !important');
                    } else {
                        jQuery('#options_rank_' + options_rank_int_id).find('h3').attr('style', 'border-color: none');
                    }
                });

            });
            if (flag === '0') {
                return true;
            } else {
                return false;
            }
        });



        /* description toggle */
        jQuery('body').on('click', 'span.woocommerce_wpfp_tab_descirtion', function() {
            jQuery(this).next('p.description').toggle();
        });

		call_pagination();
        function call_pagination(){	
			/* Custom Pagination */
			jQuery('#custom_pagination a').on('click', function(e) {
				e.preventDefault();
				var pageNum = this.id;
				var parts = pageNum.split('_');
				var wizard_id = parts[1];
				var numRecords = parts[3];
				pageNum = parts[5];
				jQuery.ajax({
					type: 'POST',
					url: ajaxurl,
					data: {
						action: 'wpfp_get_admin_question_list_with_pagination',
						wizard_id: wizard_id,
						pagenum: pageNum,
						limit: numRecords
					}, beforeSend: function() {
						jQuery('#using_ajax').html('<img src="' + admin_path + '/images/ajax-loader.gif">');
					}, complete: function() {
					},
					success: function(response) {
						jQuery('#using_ajax').html(response);
						jQuery('table#question_list_table tbody').sortable({
							axis: 'y',
							stop: function() {
								var question_sortable_data = jQuery(this).sortable('serialize', {key: 'string'});
								var question_sortable_data_arr = question_sortable_data.split('&');
								var i = 0;
								var str = '';
								for (i; i < question_sortable_data_arr.length; i++) {
									if (str !== '') {
										str += ',';
									}
									str += question_sortable_data_arr[i].slice(7);
								}
								jQuery.ajax({
									type: 'POST',
									url: ajaxurl,
									data: {
										action: 'wpfp_sortable_question_list_based_on_id',
										wizard_id: wizard_id,
										pagenum: pageNum,
										limit: numRecords,
										question_sortable_data: str
									},
									success: function() {
									}
								});
							}
						});
						call_pagination();
					}
				});
			});
		}
        /* Get admin question list with pagination */
        function displayRecords(wizard_id, numRecords, pageNum) {
            jQuery.ajax({
                type: 'POST',
                url: ajaxurl,
                data: {
                    action: 'wpfp_get_admin_question_list_with_pagination',
                    wizard_id: wizard_id,
                    pagenum: pageNum,
                    limit: numRecords
                }, beforeSend: function() {
                    jQuery('#using_ajax').html('<img src="' + admin_path + '/images/ajax-loader.gif">');
                }, complete: function() {
                }, success: function(response) {
                    //alert(response);
                    jQuery('#using_ajax').html(response);
                    //jQuery('table#question_list_table tbody').sortable();
                    jQuery('table#question_list_table tbody').sortable({
                        axis: 'y',
                        stop: function() {
                            var question_sortable_data = jQuery(this).sortable('serialize', {key: 'string'});
                            var question_sortable_data_arr = question_sortable_data.split('&');
                            var i = 0;
                            var str = '';
                            for (i; i < question_sortable_data_arr.length; i++) {
                                if (str !== '') {
                                    str += ',';
                                }
                                str += question_sortable_data_arr[i].slice(7);
                            }
                            jQuery.ajax({
                                type: 'POST',
                                url: ajaxurl,
                                data: {
                                    action: 'wpfp_sortable_question_list_based_on_id',
                                    wizard_id: wizard_id,
                                    pagenum: pageNum,
                                    limit: numRecords,
                                    question_sortable_data: str
                                },
                                success: function() {
                                }
                            });
                        }
                    });
					 call_pagination();
                }
            });
        }

        function addslashes(str) {
            return (str + '').replace(/[\\"']/g, '\\$&').replace(/\u0000/g, '\\0');
        }


        /*Attribute value*/
        var configattributevalue = {
            '.chosen-select-attribute-value': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        };
        for (var selectorattributevalue in configattributevalue) {
            $(selectorattributevalue).chosen(configattributevalue[selectorattributevalue]);
        }

        var option_value_id_data = option_value_id.OptionValueIDArray;
        if (option_value_id_data !== '') {
            var fetchAllAttributeValuID = JSON.parse(option_value_id.OptionValueIDArray);
            jQuery.each(fetchAllAttributeValuID, function(index, value) {
                var option_id = value.substr(value.lastIndexOf('_') + 1);
                /*Attribute Option Section*/
                var settingObj = window['allAttributeValue' + option_id];
                var selectedAttributeOptionsArray1 = settingObj.attributeOptionArray;
                var selectedttributeOptionsglobalarr1 = [];
                for (var j in selectedAttributeOptionsArray1) {
                    selectedttributeOptionsglobalarr1.push(selectedAttributeOptionsArray1[j]);
                }
                var attributeString1 = '';
                attributeString1 = selectedttributeOptionsglobalarr1.join(',');
                //alert(attributeString1);
                if (attributeString1 != '') { // jshint ignore:line
                    jQuery.each(attributeString1.split(','), function(i, e) {
                        jQuery('#attribute_value_' + option_id + " option[value='" + jQuery.trim(addslashes(e)) + "']").prop("selected", true); // jshint ignore:line
                        jQuery('#attribute_value_' + option_id).trigger('chosen:updated');
                    });
                }

                /*Attribute Name Section*/
                settingObj = window['allAttributename' + option_id];
                var selectedAttributeNameArray1 = settingObj.attributeAttributeArray;
                if (selectedAttributeNameArray1 !== '') {
                    jQuery('#attribute_name_' + option_id + " option[value='" + jQuery.trim(addslashes(selectedAttributeNameArray1)) + "']").prop("selected", true); // jshint ignore:line
                    jQuery('#attribute_name_' + option_id).trigger('chosen:updated');
                }

                /*Attribute Name Chosen Section (Using Ajax)*/

                jQuery('body').on('keyup', '#attribute_name_' + option_id + '_chosen input', function() {
                    var url_parameters = getUrlVars();
                    var current_wizard_id = url_parameters['wrd_id']; // jshint ignore:line
                    jQuery('#attribute_name_' + option_id + '_chosen .chosen-drop ul li.no-results').html('Please enter 3 or more characters');
                    var value = jQuery(this).val();
                    var valueCount = value.length;
                    var remainCount = 3 - valueCount;
                    if (valueCount >= 3) {
                        jQuery('#attribute_name_' + option_id + '_chosen .chosen-drop ul li.no-results').html('<img src="' + admin_path + '/images/ajax-loader.gif">');
                        jQuery.ajax({
                            type: 'POST',
                            url: ajaxurl,
                            data: {
                                'action': 'wpfp_get_woocommerce_product_attribute_name_list_ajax',
                                'value': value,
                                'wizard_id': current_wizard_id
                            }, beforeSend: function() {
                            }, complete: function() {
                            }, success: function(response) {
                                if (response.length !== 0) {
                                    jQuery('#attribute_name_' + option_id + ' option:first').after(response);
                                    jQuery('#attribute_name_' + option_id + ' .search-field input').val(value);
                                    jQuery('#attribute_name_' + option_id + ' option').each(function() {
                                        jQuery(this).siblings("[value='" + addslashes(this.value) + "']").remove(); // jshint ignore:line
                                    });
                                    jQuery('#attribute_name_' + option_id).trigger('chosen:updated');

                                    jQuery('#attribute_name_' + option_id + ' ul li.no-results').html('');
                                } else {
                                    jQuery('#attribute_name_' + option_id + ' option').not(':selected').remove();
                                }

                            }
                        });
                    } else {
                        if (remainCount > 0) {
                            jQuery('#attribute_name_' + option_id + '_chosen .chosen-drop ul li.no-results').html('Please enter ' + remainCount + ' or more characters');
                        }
                    }
                });

                //jQuery('.multiselect2').chosen();

                jQuery('body').on('change', '#attribute_name_' + option_id, function() {
                    var attribute_db_name = jQuery('option:selected', this).attr('data-name');
                    var attribute_value_db = jQuery('option:selected', this).attr('data-value1');
                    var chosen_id = jQuery(this).attr('id');
                    var chosen_int_id = chosen_id.substr(chosen_id.lastIndexOf('_') + 1);
                    var url_parameters = getUrlVars();
                    var current_wizard_id = url_parameters['wrd_id']; // jshint ignore:line
                    jQuery.ajax({
                        type: 'POST',
                        url: ajaxurl,
                        data: {
                            action: 'wpfp_get_attributes_value_based_on_attribute_name',
                            current_wizard_id: current_wizard_id,
                            attribute_name: attribute_db_name,
                            attribute_value: attribute_value_db
                        }, beforeSend: function() {
                            jQuery('#attribute_value_' + option_id + '_chosen ul.chosen-choices li input').before('<img src="' + admin_path + '/images/ajax-loader.gif">');
                            jQuery('#attribute_value_' + option_id + '_chosen ul.chosen-choices li input').hide();
                        }, complete: function() {
                            jQuery('#attribute_value_' + option_id + '_chosen ul.chosen-choices li img').remove();
                            jQuery('#attribute_value_' + option_id + '_chosen ul.chosen-choices li input').show();
                        }, success: function(response) {
                            jQuery('#attribute_value_' + chosen_int_id).html(response);
                            jQuery('#attribute_value_' + chosen_int_id).trigger('chosen:updated');
                        }
                    });
                });
            });
        }

        /*Categoty*/
        var configwizardcategory = {
            '.chosen-select-wizard-category': {},
            '.chosen-select-deselect': {allow_single_deselect: true},
            '.chosen-select-no-single': {disable_search_threshold: 10},
            '.chosen-select-no-results': {no_results_text: 'Oops, nothing found!'},
        };
        for (var selectorwizardcategory in configwizardcategory) {
            $(selectorwizardcategory).chosen(configwizardcategory[selectorwizardcategory]);
        }

        var woo_category_data = woo_category.WooCategoryArray;
        if (woo_category_data !== '') {
            var fetchAllCategory = JSON.parse(woo_category.WooCategoryArray);

            var selectedCategoryarr = [];
            for (var i in fetchAllCategory) {
                selectedCategoryarr.push(fetchAllCategory[i]);
            }

            var categoryString = '';
            categoryString = selectedCategoryarr.join(',');

            if (categoryString !== '') {
                jQuery.each(categoryString.split(','), function(i, e) {
                    jQuery("#wizard_category option[value='" + e + "']").prop('selected', true); // jshint ignore:line
                    jQuery('#wizard_category').trigger('chosen:updated');
                });
            }
        }
        $('#wizard_tag').chosen();
        /*Add css for chosen select*/
        jQuery('body').on('click', '.chosen-container-multi', function(e) {
            if (jQuery('.chosen-container-multi').hasClass('chosen-container-active')) {
                jQuery('.chosen-container-multi .chosen-drop').css('position', 'relative');
            }
            e.stopPropagation();
        });
        jQuery(document).click(function() {
            jQuery('.chosen-container .chosen-drop').css('position', 'absolute');
        });

        jQuery('body').on('click', '.ajax_remove_field_pro', function(e) { //user click on remove text
            var confrim = confirm('Remove this option?');
            if (confrim === true) {
                e.preventDefault();
                var remove_option_id = jQuery(this).attr('id');
                var remove_option_int_id = remove_option_id.substr(remove_option_id.lastIndexOf('_') + 1);
                jQuery('#options_rank_' + remove_option_int_id).remove();
            } else {
                return false;
            }
        });

        /*Remove option data from ajax*/
        jQuery('body').on('click', '.remove_option_row', function() {
            var confrim = confirm('Remove this option?');
            if (confrim === true) {
                var remove_option_id = jQuery(this).attr('id');
                var remove_option_int_id = remove_option_id.substr(remove_option_id.lastIndexOf('_') + 1);
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'wpfp_remove_option_data_from_option_page',
                        option_id: remove_option_int_id
                    },
                    success: function(response) {
                        if (jQuery.trim(response) === '1') {
                            jQuery('#options_rank_' + remove_option_int_id).remove();
                        } else {
                            alert('Something error');
                        }
                    }
                });
            } else {
                return false;
            }
        });

    });
    jQuery(document).ready(function() {
        jQuery('#search_wizard').val('');
        
        load_all_wizards(1); // Load page 1 as the default
        jQuery('body').on('click', '.wpfp-pagination-link ul li', function(e){
            if( jQuery(this).hasClass('inactive') ){
                e.preventDefault();
            }else{
                var page = jQuery(this).attr('p');
                load_all_wizards(page);
            }
         });
         /*Search wizard*/
        jQuery('body').on('click', '.search-wizard button', function() {
            var search = jQuery('#search_wizard').val();
            if( search.length > 3 ){
                jQuery.ajax({
                    type: 'POST',
                    url: ajaxurl,
                    data: {
                        action: 'wpfp_search_wizards',
                        search: search
                    },
                    success: function(response) {
                        var data = $.parseJSON(response);
                        jQuery('#wizard-listing tbody tr').remove();
                        jQuery('#wizard-listing tbody').html(data.wizards);
                        jQuery('.wpfp_pag_loading').hide();
                        setTimeout(function() {
                            jQuery('.tablesorter').trigger('update');
                        }, 300);
                    }
                });
            } else {
                load_all_wizards(1);
                jQuery('.wpfp_pag_loading').show();
            }
        });
        jQuery('input[name="wpfp_price_range_status"]').on( 'click', function(){
            if( jQuery(this).prop('checked') === true ){
                jQuery(this).parents('tr').next().show();
            }else{
                jQuery(this).parents('tr').next().hide();
            }
        });

        /** Dynamic Promotional Bar START */
        $(document).on('click', '.dpbpop-close', function () {
            var popupName = $(this).attr('data-popup-name');
            setCookie( 'banner_' + popupName, 'yes', 60 * 24 * 7);
            $('.' + popupName).hide();
        });

        $(document).on('click', '.dpb-popup .dpb-popup-meta a', function () {
            var promotional_id = $(this).parent().find('.dpbpop-close').attr('data-bar-id');
            var popupName = $(this).parent().find('.dpbpop-close').attr('data-popup-name');
            setCookie( 'banner_' + popupName, 'yes', 60 * 24 * 7);
            $('.' + popupName).hide();

            //Create a new Student object using the values from the textfields
            var apiData = {
                'bar_id' : promotional_id
            };

            $.ajax({
                type: 'POST',
                url: adminajax.dpb_api_url + 'wp-content/plugins/dots-dynamic-promotional-banner/bar-response.php',
                data: JSON.stringify(apiData),// now data come in this function
                dataType: 'json',
                cors: true,
                contentType:'application/json',
                
                success: function (data) {
                    console.log(data);
                },
                error: function () {
                }
             });
        });
        /** Dynamic Promotional Bar END */

        /** Upgrade Dashboard Script START */
        // Dashboard features popup script
        $(document).on('click', '.dotstore-upgrade-dashboard .premium-key-fetures .premium-feature-popup', function (event) {
            let $trigger = $('.feature-explanation-popup, .feature-explanation-popup *');
            if(!$trigger.is(event.target) && $trigger.has(event.target).length === 0){
                $('.feature-explanation-popup-main').not($(this).find('.feature-explanation-popup-main')).hide();
                $(this).parents('li').find('.feature-explanation-popup-main').show();
                $('body').addClass('feature-explanation-popup-visible');
            }
        });
        $(document).on('click', '.dotstore-upgrade-dashboard .popup-close-btn', function () {
            $(this).parents('.feature-explanation-popup-main').hide();
            $('body').removeClass('feature-explanation-popup-visible');
        });
        /** Upgrade Dashboard Script End */

        /** Script for Freemius upgrade popup */
        $(document).on('click', '#dotsstoremain .pf-pro-label, .wpfp-upgrade-pro-to-unlock', function(){
            $('body').addClass('wpfp-modal-visible');
        });
        $(document).on('click', '.upgrade-to-pro-modal-main .modal-close-btn', function(){
            $('body').removeClass('wpfp-modal-visible');
        });
        $(document).on( 'change', '.wpfp-main-table #question_type', function() {
            let selectedOption = $(this).find(':selected').val();
            if( selectedOption.includes('_in_pro') ){
                $(this).find(':selected').prop('selected', false);

                $('body').addClass('wpfp-modal-visible');
            }
        });
        $(document).on('click', '.dots-header .dots-upgrade-btn, .dotstore-upgrade-dashboard .upgrade-now', function(e){
            e.preventDefault();
            upgradeToProFreemius( '' );
        });
        $(document).on('click', '.upgrade-to-pro-modal-main .upgrade-now', function(e){
            e.preventDefault();
            $('body').removeClass('wpfp-modal-visible');
            let couponCode = $('.upgrade-to-pro-discount-code').val();
            upgradeToProFreemius( couponCode );
        });

        // Script for Beacon configuration
        var helpBeaconCookie = getCookie( 'wpfp-help-beacon-hide' );
        if ( ! helpBeaconCookie ) {
            if ( typeof Beacon === 'function' ) {
                Beacon('init', 'afe1c188-3c3b-4c5f-9dbd-87329301c920');
                Beacon('config', {
                    display: {
                        style: 'icon',
                        iconImage: 'message',
                        zIndex: '99999'
                    }
                });

                // Add plugin articles IDs to display in beacon
                Beacon('suggest', ['5e0477f204286364bc933aca', '5e0479912c7d3a7e9ae58281', '5e048f4e2c7d3a7e9ae582d7', '5e04866b2c7d3a7e9ae582ac', '5e048abf2c7d3a7e9ae582bf']);

                // Add custom close icon form beacon
                setTimeout(function() {
                    if ( $( '.hsds-beacon .BeaconFabButtonFrame' ).length > 0 ) {
                        let newElement = document.createElement('span');
                        newElement.classList.add('dashicons', 'dashicons-no-alt', 'dots-beacon-close');
                        let container = document.getElementsByClassName('BeaconFabButtonFrame');
                        container[0].appendChild( newElement );
                    }
                }, 3000);

                // Hide beacon
                $(document).on('click', '.dots-beacon-close', function(){
                    Beacon('destroy');
                    setCookie( 'wpfp-help-beacon-hide' , 'true', 24 * 60 );
                });
            }
        }

        /** Plugin Setup Wizard Script START */
        // Hide & show wizard steps based on the url params 
        var urlParams = new URLSearchParams(window.location.search);
        if (urlParams.has('require_license')) {
            $('.ds-plugin-setup-wizard-main .tab-panel').hide();
            $( '.ds-plugin-setup-wizard-main #step5' ).show();
        } else {
            $( '.ds-plugin-setup-wizard-main #step1' ).show();
        }
        
        // Plugin setup wizard steps script
        $(document).on('click', '.ds-plugin-setup-wizard-main .tab-panel .btn-primary:not(.ds-wizard-complete)', function () {
            var curruntStep = jQuery(this).closest('.tab-panel').attr('id');
            var nextStep = 'step' + ( parseInt( curruntStep.slice(4,5) ) + 1 ); // Masteringjs.io

            if( 'step5' !== curruntStep ) {
                // Youtube videos stop on next step
                $('iframe[src*="https://www.youtube.com/embed/"]').each(function(){
                   $(this).attr('src', $(this).attr('src'));
                   return false;
                });
                
                jQuery( '#' + curruntStep ).hide();
                jQuery( '#' + nextStep ).show();   
            }
        });

        // Get allow for marketing or not
        if ( $( '.ds-plugin-setup-wizard-main .ds_count_me_in' ).is( ':checked' ) ) {
            $('#fs_marketing_optin input[name="allow-marketing"][value="true"]').prop('checked', true);
        } else {
            $('#fs_marketing_optin input[name="allow-marketing"][value="false"]').prop('checked', true);
        }

        // Get allow for marketing or not on change     
        $(document).on( 'change', '.ds-plugin-setup-wizard-main .ds_count_me_in', function() {
            if ( this.checked ) {
                $('#fs_marketing_optin input[name="allow-marketing"][value="true"]').prop('checked', true);
            } else {
                $('#fs_marketing_optin input[name="allow-marketing"][value="false"]').prop('checked', true);
            }
        });

        // Complete setup wizard
        $(document).on( 'click', '.ds-plugin-setup-wizard-main .tab-panel .ds-wizard-complete', function() {
            if ( $( '.ds-plugin-setup-wizard-main .ds_count_me_in' ).is( ':checked' ) ) {
                $( '.fs-actions button'  ).trigger('click');
            } else {
                $('.fs-actions #skip_activation')[0].click();
            }
        });

        // Send setup wizard data on Ajax callback
        $(document).on( 'click', '.ds-plugin-setup-wizard-main .fs-actions button', function() {
            var wizardData = {
                'action': 'wpfp_plugin_setup_wizard_submit',
                'survey_list': $('.ds-plugin-setup-wizard-main .ds-wizard-where-hear-select').val(),
                'nonce': adminajax.setup_wizard_ajax_nonce
            };

            $.ajax({
                url: adminajax.ajaxurl,
                data: wizardData,
                success: function ( success ) {
                    console.log(success);
                }
            });
        });
        /** Plugin Setup Wizard Script End */
    });
    function load_all_wizards(page){
        var data = {
          page: page,
          action: 'wpfp_pagination_wizards'
        };
        // Send the data
        $.post(ajaxurl, data, function(response) {
         jQuery('#wizard-listing tbody tr').remove();
         jQuery('#wizard-listing tbody').html(response.wizards);
         jQuery('.wpfp_pag_loading').html(response.pagination);
         jQuery('html, body').animate({ scrollTop: 0 }, 'slow');
         setTimeout(function() {
            jQuery('.tablesorter').trigger('update');
        }, 300);
        });
    }

    /** Script for Freemius upgrade popup */
    function upgradeToProFreemius( couponCode ) {
        let handler;
        handler = FS.Checkout.configure({
            plugin_id: '3474',
            plan_id: '5541',
            public_key:'pk_9edf804dccd14eabfd00ff503acaf',
            image: 'https://www.thedotstore.com/wp-content/uploads/sites/1417/2023/10/Product-Finder-for-WooCommerce-Banner-1-New.png',
            coupon: couponCode,
        });
        handler.open({
            name: 'Product Recommendation Quiz For WooCommerce',
            subtitle: 'You’re a step closer to our Pro features',
            licenses: jQuery('input[name="licence"]:checked').val(),
            purchaseCompleted: function( response ) {
                console.log (response);
            },
            success: function (response) {
                console.log (response);
            }
        });
    }

    // Set cookies
    function setCookie(name, value, minutes) {
        var expires = '';
        if (minutes) {
            var date = new Date();
            date.setTime(date.getTime() + (minutes * 60 * 1000));
            expires = '; expires=' + date.toUTCString();
        }
        document.cookie = name + '=' + (value || '') + expires + '; path=/';
    }

    // Get cookies
    function getCookie(name) {
        let nameEQ = name + '=';
        let ca = document.cookie.split(';');
        for (let i = 0; i < ca.length; i++) {
            let c = ca[i].trim();
            if (c.indexOf(nameEQ) === 0) {
                return c.substring(nameEQ.length, c.length);
            }
        }
        return null;
    }
})(jQuery);
