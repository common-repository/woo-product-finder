(function($) {
    'use strict';
    $(window).on('load',function() {
        if( MyAjax.show_result_last === 'yes' ){
            jQuery( '.product_list' ).hide();
        }
        jQuery('.wprw_list #ajax_loader_wizard_question_div').hide();
        jQuery('.product_list #ajax_loader_wizard_div').hide();
        jQuery('.wprw-button-previous').hide();
        jQuery('.wprw-button-previous').hide();
        jQuery('.wprw-display-results-button').hide();
        jQuery('.wprw-start-advisor-button').hide();
        jQuery('.wprw-scroll-to-results-button').hide();

        jQuery('.wprw-congatu-msg').hide();
        jQuery('.wprw-congatu-next').hide();
        jQuery('.wprw-button-show-result').hide();

        /*Click on next button*/
        jQuery('body').on('click', '.wprw-button-next', function() {
            jQuery('#ajax_loader_wizard_question_div').show();

            var main_id = jQuery(this).attr('id');
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var sortable_id = parts[7];
            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function() {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf('_') + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val !== '') {
                    all_question_value.push(jQuery('#current_selected_value_id_' + all_question_id).val());
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });

            var prevque = jQuery(this).attr('data-prevque');
            var curque = jQuery(this).attr('data-curque');
            var remque = jQuery(this).attr('data-remque');

            var all_question_id = jQuery('#all_question_value').val().split(',');
            var remove_current_questoin_id;
            if (prevque) {
                remove_current_questoin_id = jQuery.grep(all_question_id, function(value) {
                    return value !== prevque;
                });
            } else {
                remove_current_questoin_id = '0';
            }
            var new_remque = remque - '1';
            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: 'wpfp_get_next_questions_front_side',
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    all_selected_value_id: all_question_value,
                    sortable_id: sortable_id,
                    remove_current_questoin_id: remove_current_questoin_id,
                    cur_que_id_on_nxt_btn: curque,
                    remque: new_remque,
                },
                dataType: 'json',
                beforeSend: function() {
                    jQuery('#wprw_question_list_new_' + wizard_int_id).css({opacity: 0});
                    jQuery('#ajax_loader_wizard_question_div').show();
                }, complete: function() {
                    jQuery('#ajax_loader_wizard_question_div').hide();
                    jQuery('#wprw_question_list_new_' + wizard_int_id).css({opacity: 1});
                }, success: function(response) {
                    jQuery('#ajax_loader_wizard_question_div').hide();
                    jQuery('#wprw_question_list_new_' + wizard_int_id).html(response.next_html);
                    var total_selected_value = [];
                    var current_selected_value_arr = [];
                    var total_question_id = response.question_id_array;
                    jQuery.each(total_question_id, function(i, val) {
                        var current_selected_val = jQuery('#current_selected_value_id_' + val).val();
                        if (current_selected_val !== '') {
                            current_selected_value_arr.push(jQuery('#current_selected_value_id_' + val).val());
                        }
                    });
                    var current = jQuery('#wprw_list_new_'+wizard_int_id+' .wprw_tour').val();
                    var allstep = jQuery('#wprw_list_new_'+wizard_int_id+' .wprw_tour').attr('data-all-question');
                    var que_index;
                    if( current < allstep ){
                        que_index = parseInt(current) + 1;
                    }
                    var per = ( parseInt(que_index) / total_question_id.length ) * 100;
                    jQuery('#wprw_list_new_'+ wizard_int_id +' .wprw_progressbar div').css('width',per + '%');
                    jQuery('#wprw_list_new_'+ wizard_int_id +' .wprw_tour').val(que_index);
                    if (current_selected_value_arr !== '') {
                        total_selected_value.push(current_selected_value_arr);
                    }
                    jQuery('#all_selected_value_id').val(total_selected_value);
                    jQuery('#all_question_value').val(remove_current_questoin_id);
                    var total_selected_value_with_join = total_selected_value.join(',');
                    var split_val = total_selected_value_with_join.split(',');
                    jQuery.each(split_val, function(i, val) {
                        jQuery('.wprw-questions .wprw-question li.wprw-answer .wprw-answer-action #wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
                    });

                    var show_attribute = response.show_attribute_field;
                    jQuery('.prd_section').each(function() {
                        var prd_attribute_id = jQuery(this).attr('id');
                        var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf('_') + 1));
                        jQuery('#prd_' + prd_attribute_int_id).each(function() {
                            var prd_wise_att_count = jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes').find('.prd-attribute').length;
                            if (prd_wise_att_count > show_attribute) {
                                jQuery('#view_more_btn_' + prd_attribute_int_id).show();
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes .prd-attribute:lt(' + (prd_wise_att_count) + ')').show();
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes .prd-attribute:gt(' + (show_attribute - 1) + ')').hide();
                            } else {
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes').find('.prd-attribute').show();
                                jQuery('#view_more_btn_' + prd_attribute_int_id).hide();
                            }
                            jQuery('.show_less_btn').hide();
                        });
                    });

                    /*Hide and show congrate btn*/
                    var all_selected_value_on_load_time = jQuery('#all_selected_value').val();

                    if (all_selected_value_on_load_time) {
                        jQuery('.wprw-congatu-msg').show();
                        jQuery('.wprw-congatu-next').show();
                        jQuery('.wprw-button-show-result').show();
                    } else {
                        jQuery('.wprw-congatu-msg').hide();
                        jQuery('.wprw-congatu-next').hide();
                        jQuery('.wprw-button-show-result').hide();
                    }
                }
            });
        });

        /*Click on previous button*/
        jQuery('body').on('click', '.wprw-button-previous', function() {
            jQuery('#ajax_loader_wizard_question').show();
            var main_id = jQuery(this).attr('id');
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var sortable_id = parts[7];

            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function() {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf('_') + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val !== '') {
                    all_question_value.push(jQuery('#current_selected_value_id_' + all_question_id).val());
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });

            var curque = jQuery(this).attr('data-curque');
            var all_question_id = jQuery('#all_question_value').val();
            var remove_current_questoin_id;
            if (curque) {
                if (all_question_id) {
                    remove_current_questoin_id = all_question_id + ',' + curque;
                } else {
                    remove_current_questoin_id = curque;
                }
            } else {
                remove_current_questoin_id = '0';
            }
            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: 'wpfp_get_previous_questions_front_side',
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    all_selected_value_id: all_question_value,
                    sortable_id: sortable_id,
                    remove_current_questoin_id: remove_current_questoin_id,
                    cur_que_id_on_nxt_btn: curque,
                },
                dataType: 'json',
                beforeSend: function() {
                    jQuery('#wprw_question_list_new_' + wizard_int_id).css({opacity: 0});
                    jQuery('#ajax_loader_wizard_question_div').show();
                }, complete: function() {
                    jQuery('#ajax_loader_wizard_question_div').hide();
                    jQuery('#wprw_question_list_new_' + wizard_int_id).css({opacity: 1});
                }, success: function(response) {
                    jQuery('#ajax_loader_wizard_question_div').hide();
                    jQuery('#wprw_question_list_new_' + wizard_int_id).html(response.previous_html);
                    var total_selected_value = [];
                    var current_selected_value_arr = [];
                    var total_question_id = response.question_id_array;
                    jQuery.each(total_question_id, function(i, val) {
                        var current_selected_val = jQuery('#current_selected_value_id_' + val).val();
                        if (current_selected_val !== '') {
                            current_selected_value_arr.push(jQuery('#current_selected_value_id_' + val).val());
                        }
                    });
                    if (current_selected_value_arr !== '') {
                        total_selected_value.push(current_selected_value_arr);
                    }
                    var current = jQuery('#wprw_list_new_'+wizard_int_id+' .wprw_tour').val();
                    var que_index;
                    if( current > 0 ){
                        que_index = parseInt(current) - 1;
                    }
					var per = ( parseInt(que_index) / total_question_id.length ) * 100;
                    jQuery( '#wprw_list_new_'+ wizard_int_id +' .wprw_progressbar' ).show();
					jQuery('#wprw_list_new_'+ wizard_int_id +' .wprw_progressbar div').css('width',per + '%');
                    jQuery('#wprw_list_new_'+ wizard_int_id +' .wprw_tour').val(que_index);

                    jQuery('#all_selected_value_id').val(total_selected_value);
                    jQuery('#all_question_value').val(remove_current_questoin_id);
                    var total_selected_value_with_join = total_selected_value.join(',');
                    var split_val = total_selected_value_with_join.split(',');
                    jQuery.each(split_val, function(i, val) {
                        jQuery('.wprw-questions .wprw-question li.wprw-answer .wprw-answer-action #wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
                    });

                    var show_attribute = response.show_attribute_field;
                    jQuery('.prd_section').each(function() {
                        var prd_attribute_id = jQuery(this).attr('id');
                        var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf('_') + 1));
                        jQuery('#prd_' + prd_attribute_int_id).each(function() {
                            var prd_wise_att_count = jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes').find('.prd-attribute').length;
                            if (prd_wise_att_count > show_attribute) {
                                jQuery('#view_more_btn_' + prd_attribute_int_id).show();
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes .prd-attribute:lt(' + (prd_wise_att_count) + ')').show();
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes .prd-attribute:gt(' + (show_attribute - 1) + ')').hide();
                            } else {
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes').find('.prd-attribute').show();
                                jQuery('#view_more_btn_' + prd_attribute_int_id).hide();
                            }
                            jQuery('.show_less_btn').hide();
                        });
                    });

                    /*Hide and show congrate btn*/
                    var all_selected_value_on_load_time = jQuery('#all_selected_value').val();

                    if (all_selected_value_on_load_time) {
                        jQuery('.wprw-congatu-msg').show();
                        jQuery('.wprw-congatu-next').show();
                        jQuery('.wprw-button-show-result').show();
                    } else {
                        jQuery('.wprw-congatu-msg').hide();
                        jQuery('.wprw-congatu-next').hide();
                        jQuery('.wprw-button-show-result').hide();
                    }
                }
            });
        });
        /* Click on input label to bind click event */
        jQuery('body').on('click', 'span.wprw-answer-selector span.wprw-label-element-span', function() {
            jQuery(this).parent().find('.wprw-input').click();
        });
        /*Click on input button*/
        jQuery('body').on('change', 'span.wprw-answer-selector input.wprw-input', function() {
            var main_id = jQuery(this).attr('id');
            var next = jQuery(this).closest('li').find('.wprw_option_next_que').val();
            if( '' !== next && typeof next !== 'undefined' ){
                jQuery('.wprw-page-nav-buttons .wprw-button.wprw-button-next').attr('id', next);
            }
            
            var parts = main_id.split('_');
            var wizard_int_id = parts[1];
            var question_int_id = parts[3];
            var option_int_id = parts[5];

            jQuery('#ajax_loader_wizard_div').show();

            var allInputs = jQuery('input.wprw-input:input');
            var allInputs_type = jQuery.trim(allInputs.attr('type'));
            var current_selected_value = [];
            var current_selected_value_with_join;
            var total_selected_value_pass_database;

            

            if (allInputs_type === 'radio') {
                var radioValue = jQuery('input.wprw-input:radio:checked').val();
                if (radioValue) {
                    current_selected_value = radioValue;
                }
                current_selected_value_with_join = current_selected_value;
            }
            jQuery('#current_selected_value_id_' + question_int_id).val(current_selected_value);

            var all_question_value = [];
            jQuery('input[name="current_selected_value_name"]').each(function() {
                var all_selected_value_id = jQuery(this).attr('id');
                var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf('_') + 1);
                var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                if (current_selected_val !== '') {
                    all_question_value.push(current_selected_val);
                }
            });
            jQuery('#all_selected_value').val(all_question_value);
            var total_selected_value_with_join = all_question_value.join(',');
            var split_val = total_selected_value_with_join.split(',');
            jQuery.each(split_val, function(i, val) {
                jQuery('#wd_' + wizard_int_id + '_que_' + question_int_id + '_opt_' + val).prop('checked', true);
            });
            if (total_selected_value_with_join !== '') {
                total_selected_value_pass_database = '\'' + total_selected_value_with_join.split(',').join('\',\'') + '\'';
            } else {
                total_selected_value_pass_database = '';
            }
            var min = jQuery('#wpfp_min_price').val();
			var max = jQuery('#wpfp_max_price').val();
            jQuery.ajax({
                type: 'POST',
                url: MyAjax.ajaxurl,
                data: {
                    action: 'wpfp_get_ajax_woocommerce_product_list',
                    current_wizard_id: wizard_int_id,
                    current_question_id: question_int_id,
                    current_option_id: option_int_id,
                    current_selected_value: current_selected_value_with_join,
                    all_selected_value: total_selected_value_pass_database,
                    wpfp_min_price: min,
					wpfp_max_price: max
                },
                dataType: 'json',
                beforeSend: function() {
                    jQuery('#perfect_product_div_' + wizard_int_id).hide();
                    jQuery('#recently_product_div_' + wizard_int_id).hide();
                    jQuery('#front_pagination_div_' + wizard_int_id).hide();
                    jQuery('#ajax_loader_wizard_div').show();
                }, complete: function() {
                    jQuery('#ajax_loader_wizard_div').hide();
                    jQuery('#perfect_product_div_' + wizard_int_id).show();
                    jQuery('#recently_product_div_' + wizard_int_id).show();
                    jQuery('#front_pagination_div_' + wizard_int_id).show();
                }, success: function(response) {
                    if ( response.product_html ) {
						jQuery( '#perfect_product_div_' + wizard_int_id ).html( response.product_html );
					} else {
						jQuery( '#perfect_product_div_' + wizard_int_id ).html('');
					}
					if ( response.store_product_html ) {
						jQuery( '#recently_product_div_' + wizard_int_id ).html( response.store_product_html );
					} else {
						jQuery( '#recently_product_div_' + wizard_int_id ).html('');
					}
                    if( null === response.product_html && null === response.store_product_html ) {
                        jQuery( '#perfect_product_div_' + wizard_int_id ).html( response.no_records );
                    }
					if ( response.pagination_html ) {
						jQuery( '#front_pagination_div_' + wizard_int_id ).html( response.pagination_html );
					} else {
						jQuery( '#front_pagination_div_' + wizard_int_id ).html('');
					}

                    var k = 0;
                    jQuery.each(split_val, function() {
                        var j = 0;
                        jQuery('.prd_section .prd-attribute').each(function() {
                            j++;
                            var prd_attribute_class = jQuery.trim(jQuery(this).attr('class'));
                            if (prd_attribute_class === 'prd-attribute') {
                                jQuery(this).addClass('prd-neutral-attr');
                            }
                        });
                        k++;
                    });

                    jQuery('.prd_section').each(function() {
                        var prd_attribute_id = jQuery(this).attr('id');
                        var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf('_') + 1));

                        var negative_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-negative-attr').sort(sortMe);
                        var neutral_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-neutral-attr').sort(sortMe);

                        function sortMe(a, b) {
                            return a.className < b.className;
                        }

                        jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(negative_value);
                        jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(neutral_value);

                        var show_attribute = response.show_attribute_field;
                        jQuery('#prd_' + prd_attribute_int_id).each(function() {
                            var prd_wise_att_count = jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes').find('.prd-attribute').length;
                            if (prd_wise_att_count > show_attribute) {
                                jQuery('#view_more_btn_' + prd_attribute_int_id).show();
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes .prd-attribute:lt(' + (prd_wise_att_count) + ')').show();
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes .prd-attribute:gt(' + (show_attribute - 1) + ')').hide();
                            } else {
                                jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes').find('.prd-attribute').show();
                                jQuery('#view_more_btn_' + prd_attribute_int_id).hide();
                            }
                            jQuery('.show_less_btn').hide();
                        });
                    });

                    /*Hide and show congrate btn*/
                    var all_selected_value_on_load_time = jQuery('#all_selected_value').val();

                    if (all_selected_value_on_load_time) {
                        jQuery('.wprw-congatu-msg').show();
                        jQuery('.wprw-congatu-next').show();
                        jQuery('.wprw-button-show-result').show();
                    } else {
                        jQuery('.wprw-congatu-msg').hide();
                        jQuery('.wprw-congatu-next').hide();
                        jQuery('.wprw-button-show-result').hide();
                    }
                }
            });
        });

        jQuery( document ).ajaxComplete(function(event, xhr, settings) {

            /* Check once ajax call reset the pagination */
            var call_ajax_url = settings.url;
            var call_file =call_ajax_url.substring(call_ajax_url.lastIndexOf('/'));
            if('/admin-ajax.php' === call_file) {

                /*Click on pagination*/
                jQuery('.front_pagination a').on('click', function(e) {
                    e.preventDefault();
                    jQuery('html,body').animate({
                        scrollTop: jQuery('.wprw-questions').offset().top - 50},
                    'slow');
                    var pageNumID = this.id;
                    var parts = pageNumID.split('_');
                    var wizard_id = parts[1];
                    var questions_id = parts[3];
                    var option_id = parts[5];
                    var curr_selected_value = parts[7];
                    var numRecords = parts[9];
                    var pageNum = parts[11];
                    var total_selected_value_pass_database = jQuery('#all_selected_value').val();
                    var perfect_product_div_length = jQuery('#perfect_product_div .prd_section').length;
                    var all_question_value = [];
                    var wpfp_min_price = jQuery('#wpfp_min_price').val();
			        var wpfp_max_price = jQuery('#wpfp_max_price').val();
                    jQuery('input[name="current_selected_value_name"]').each(function() {
                        var all_selected_value_id = jQuery(this).attr('id');
                        var all_question_id = all_selected_value_id.substr(all_selected_value_id.lastIndexOf('_') + 1);
                        var current_selected_val = jQuery('#current_selected_value_id_' + all_question_id).val();
                        if (current_selected_val !== '') {
                            all_question_value.push(current_selected_val);
                        }
                    });
                    var total_selected_value_with_join = all_question_value.join(',');
                    var split_val = total_selected_value_with_join.split(',');
                    jQuery('#ajax_loader_wizard_div').show();
                    jQuery.ajax({
                        type: 'POST',
                        url: MyAjax.ajaxurl,
                        data: {
                            action: 'wpfp_get_ajax_woocommerce_product_list',
                            current_wizard_id: wizard_id,
                            current_question_id: questions_id,
                            current_option_id: option_id,
                            current_selected_value: curr_selected_value,
                            all_selected_value: total_selected_value_pass_database,
                            pagenum: pageNum,
                            limit: numRecords,
                            perfect_product_div_length: perfect_product_div_length,
                            wpfp_min_price: wpfp_min_price,
					        wpfp_max_price: wpfp_max_price
                        },
                        dataType: 'json',
                        beforeSend: function() {
                            jQuery('#perfect_product_div_' + wizard_id).hide();
                            jQuery('#recently_product_div_' + wizard_id).hide();
                            jQuery('#front_pagination_div_' + wizard_id).hide();
                            jQuery('#ajax_loader_wizard_div').show();
                        }, complete: function() {
                            jQuery('#ajax_loader_wizard_div').hide();
                            jQuery('#perfect_product_div_' + wizard_id).show();
                            jQuery('#recently_product_div_' + wizard_id).show();
                            jQuery('#front_pagination_div_' + wizard_id).show();
                        }, success: function(response) {
                            jQuery('#ajax_loader_wizard_div').hide();
                            jQuery('#perfect_product_div_' + wizard_id).html(response.product_html);
                            jQuery('#recently_product_div_' + wizard_id).html(response.store_product_html);
                            jQuery('#front_pagination_div_' + wizard_id).html(response.pagination_html);

                            var k = 0;
                            jQuery.each(split_val, function() {
                                var j = 0;
                                jQuery('.prd_section .prd-attribute').each(function() {
                                    j++;
                                    var prd_attribute_class = jQuery.trim(jQuery(this).attr('class'));
                                    if (prd_attribute_class === 'prd-attribute') {
                                        jQuery(this).addClass('prd-neutral-attr');
                                    }
                                });
                                k++;
                            });
                            jQuery('.prd_section').each(function() {
                                var prd_attribute_id = jQuery(this).attr('id');
                                var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf('_') + 1));

                                var negative_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-negative-attr').sort(sortMe);
                                var neutral_value = jQuery('#prd_' + prd_attribute_int_id).find('div.prd-neutral-attr').sort(sortMe);

                                function sortMe(a, b) {
                                    return a.className < b.className;
                                }

                                jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(negative_value);
                                jQuery('#prd_' + prd_attribute_int_id + ' .prd-overlay-attributes').append(neutral_value);

                                var show_attribute = response.show_attribute_field;
                                jQuery('#prd_' + prd_attribute_int_id).each(function() {
                                    var prd_wise_att_count = jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes').find('.prd-attribute').length;
                                    if (prd_wise_att_count > show_attribute) {
                                        jQuery('#view_more_btn_' + prd_attribute_int_id).show();
                                        jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes .prd-attribute:lt(' + (prd_wise_att_count) + ')').show();
                                        jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes .prd-attribute:gt(' + (show_attribute - 1) + ')').hide();
                                    } else {
                                        jQuery(this).find('.prd_detail .prd_middle_detail .main_prd_attribute .prd_attribute_list .prd-overlay-attributes').find('.prd-attribute').show();
                                        jQuery('#view_more_btn_' + prd_attribute_int_id).hide();
                                    }
                                    jQuery('.show_less_btn').hide();
                                });
                            });
                        }
                    });
                });
            }
        });
        /*Restart*/
        jQuery('body').on('click', '.wprv-list-restart-button', function() {
            var data_title = jQuery(this).attr('data-title');
            var confrim = confirm(data_title);

            if (confrim === true) {
                setTimeout(function() {
                    location.reload(true);
                }, 1000);
            } else {
                return false;
            }
        });

        /*View more button for product attribute*/
        jQuery('body').on('click', '.view_more_btn', function() {
            var prd_attribute_id = jQuery(this).attr('id');
            var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf('_') + 1));
            var scr_length = jQuery('#prd_' + prd_attribute_int_id).find('.prd_detail > .prd_middle_detail > .main_prd_attribute > .prd_attribute_list > .prd-overlay-attributes > div.prd-attribute:hidden').length;
            jQuery('#prd_' + prd_attribute_int_id).find('.prd_detail > .prd_middle_detail > .main_prd_attribute > .prd_attribute_list > .prd-overlay-attributes > div.prd-attribute:hidden').slice(0, scr_length).slideDown();
            if (jQuery('#prd_' + prd_attribute_id).find('.prd_detail > .prd_middle_detail > .main_prd_attribute > .prd_attribute_list > .prd-overlay-attributes > div.prd-attribute:hidden').length === 0) {
                jQuery('#view_more_btn_' + prd_attribute_int_id).fadeOut('slow');
            }
            jQuery('#show_less_btn_' + prd_attribute_int_id).show();
            jQuery('#view_more_btn_' + prd_attribute_int_id).hide();
        });

        /*Show less button for product attribute*/
        jQuery('body').on('click', '.show_less_btn', function() {
            var prd_attribute_id = jQuery(this).attr('id');
            var show_attribute = jQuery(this).attr('data-prddefault');
            var prd_attribute_int_id = jQuery.trim(prd_attribute_id.substr(prd_attribute_id.lastIndexOf('_') + 1));
            var scr_length = jQuery('#prd_' + prd_attribute_int_id).find('.prd_detail > .prd_middle_detail > .main_prd_attribute > .prd_attribute_list > .prd-overlay-attributes > div.prd-attribute:visible').length;
            if (scr_length > show_attribute) {
                var show_attribute_count = jQuery.trim(+show_attribute + 1);
                var hide_acc = +(scr_length - show_attribute_count) + 1;
                jQuery('#prd_' + prd_attribute_int_id).find('.prd_detail > .prd_middle_detail > .main_prd_attribute > .prd_attribute_list > .prd-overlay-attributes').find('.prd-attribute:gt(-' + (+hide_acc + 1) + ')').slideUp();
            }
            jQuery('#view_more_btn_' + prd_attribute_int_id).show();
            jQuery('#show_less_btn_' + prd_attribute_int_id).hide();
        });
        jQuery( 'body' ).on( 'click', '.wprw-button-show-result', function() {
            var hide_wizard_box = jQuery('.wprw_hide_wizard_last_step').val();
            if( 'yes' === hide_wizard_box ){
                jQuery('.wprw_question_list,.wprw_progressbar').hide();
            } else{
                jQuery('.wprw-dv.btns button').hide();
            }
			jQuery( '.product_list' ).show();
			jQuery('.wpfp_price_range').ionRangeSlider({
				skin: 'round',
                prefix: '$',
                onFinish: function (data) {
                    console.log(data.from + ' - ' + data.to);
					jQuery('#wpfp_min_price').val(data.from);
					jQuery('#wpfp_max_price').val(data.to);
					jQuery('span.wprw-answer-selector input.wprw-input').trigger('change');
                }
			});
			jQuery(this).parents('.wprw_question_list').next('.pfw-final-step').show();
			jQuery( 'html,body' ).animate( {
					scrollTop: jQuery(this).parents('.wprw_question_list').next().next().offset().top - 50
				},
			1000 );
		} );
		jQuery( 'body' ).on( 'click', 'button.wprw-button.pfw-final-back', function() {
			jQuery(this).parent().parent().hide();
            jQuery('.wprw_progressbar').show();
			jQuery('.wprw_question_list').show();
            jQuery( 'html,body' ).animate( {
                    scrollTop: jQuery( '.wprw_question_list' ).offset().top - 50
                },
            1000 );
		});
		jQuery( 'body' ).on( 'click', 'button.wprw-button.pfw-final-restart', function() {
			jQuery('.wprv-list-restart button.wprv-list-hover-button.wprv-list-restart-button').trigger('click');
		});
    });


    /**
     * All of the code for your public-facing JavaScript source
     * should reside in this file.
     *
     * Note: It has been assumed you will write jQuery code here, so the
     * $ function reference has been prepared for usage within the scope
     * of this function.
     *
     * This enables you to define handlers, for when the DOM is ready:
     *
     * $(function() {
     *
     * });
     *
     * When the window is loaded:
     *
     * $( window ).load(function() {
     *
     * });
     *
     * ...and/or other possibilities.
     *
     * Ideally, it is not considered best practise to attach more than a
     * single DOM-ready or window-load handler for a particular page.
     * Although scripts in the WordPress core, Plugins and Themes may be
     * practising this, we should strive to set a better example in our own work.
     */
})(jQuery);
