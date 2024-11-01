<?php

/**
 * Create shortcode for particular wizard
 *
 * @since    1.0.0
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
global $wpdb;
$wizard_rows = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}wpfp_wizard " );
// phpcs:ignore
if ( !empty( $wizard_rows ) && is_array( $wizard_rows ) ) {
    foreach ( $wizard_rows as $wizard_data ) {
        $wizard_id = $wizard_data->id;
        $cb = function () use($wizard_id) {
            global $wpdb;
            $wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
            $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
            $options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
            $test_obj = new WPFPFW_Woo_Product_Finder_Pro_Public($this->plugin_name, $this->version);
            $total_question = $test_obj->wpfp_count_questions_from_db_based_on_wizard_id( $wizard_id );
            $sel_qry = "";
            $sel_qry .= "SELECT ";
            $sel_qry .= " wizard.*,";
            $sel_qry .= " qustions.id AS question_id,qustions.name,qustions.option_type,qustions.sortable_id";
            $sel_qry .= " FROM " . $wizard_table_name . " wizard";
            $sel_qry .= " LEFT JOIN " . $questions_table_name . " AS qustions";
            $sel_qry .= " ON qustions.wizard_id = wizard.id";
            $sel_qry .= " WHERE wizard.id = %d";
            $sel_qry .= " AND wizard.status = 'on'";
            $sel_qry .= " ORDER BY qustions.sortable_id ASC";
            $sel_qry .= " LIMIT 0, 1";
            $sel_qry_prepare = $wpdb->prepare( $sel_qry, $wizard_id );
            // phpcs:ignore
            $sel_rows = $wpdb->get_row( $sel_qry_prepare );
            // phpcs:ignore
            $que = ( empty( $sel_rows->sortable_id ) ? 1 : $sel_rows->sortable_id );
            if ( $total_question > 0 ) {
                $wprw_progress_per = $que / $total_question * 100;
            } else {
                $wprw_progress_per = 0;
            }
            if ( !empty( $sel_rows ) ) {
                $wizard_setting = ( empty( $sel_rows->wizard_setting ) ? '' : json_decode( $sel_rows->wizard_setting, true ) );
                $reload_title = ( empty( $wizard_setting['reload_title'] ) ? 'Reload Title' : $wizard_setting['reload_title'] );
                $all_bg_color = ( empty( $wizard_setting['background_color'] ) ? '#000000' : $wizard_setting['background_color'] );
                $wizard_product_fields = ( empty( $wizard_setting['wizard_product_fields'] ) ? '' : $wizard_setting['wizard_product_fields'] );
                if ( str_contains( $wizard_product_fields, 'hide-wizard-box' ) ) {
                    $wizard_product_fields = 'yes';
                } else {
                    $wizard_product_fields = 'no';
                }
                $ajax_loader_wizard_question = esc_url( WPFP_PLUGIN_URL . '/images/ajax-loader.gif' );
                $ajax_loader_wizard = esc_url( WPFP_PLUGIN_URL . '/images/ajax-loader.gif' );
                $publicObj = new WPFPFW_Woo_Product_Finder_Pro_Public($this->plugin_name, $this->version);
                $wizard_title = $publicObj->wpfp_get_wizard_title_based_on_id( $wizard_id );
                $restart_title = ( empty( $wizard_setting['restart_title'] ) ? 'Reload Title' : $wizard_setting['restart_title'] );
                $front_html = '';
                $i = 0;
                $front_html .= '<div class="wprw_list" id="wprw_list_new_' . esc_attr( $wizard_id ) . '">';
                $front_html .= '<div class="wprw_progressbar"><div style="width:' . esc_attr( $wprw_progress_per ) . '%;background-color:' . esc_attr( $all_bg_color ) . '"></div></div>';
                $front_html .= '<input type="hidden" class="wprw_tour" value="' . $sel_rows->sortable_id . '" data-all-question="' . esc_attr( $total_question ) . '">';
                $front_html .= '<input type="hidden" class="wprw_hide_wizard_last_step" value="' . esc_attr( $wizard_product_fields ) . '">';
                $front_html .= '<div class="wprw_question_list">';
                $front_html .= '<div class="wizard_title_class" id="wizard_title_id_' . esc_attr( $wizard_id ) . '">';
                $front_html .= '<h1>' . wp_kses_post( $wizard_title ) . '</h1>';
                $front_html .= '</div>';
                $front_html .= '<div class="wprv-list-restart">';
                $front_html .= '<button class="wprv-list-hover-button wprv-list-restart-button" data-title="' . esc_attr( $reload_title ) . '">';
                $front_html .= '<i class="fa fa-refresh" aria-hidden="true"></i><span class="wprv-list-hover-label wprv-list-round wprv-list-hover-left wprv-list-icon">';
                $front_html .= esc_html__( $restart_title, 'woo-product-finder' );
                $front_html .= '</span>';
                $front_html .= '</button>';
                $front_html .= '</div>';
                $front_html .= '<div id="ajax_loader_wizard_question_div">';
                $front_html .= '<img src="' . esc_url( $ajax_loader_wizard_question ) . '" id="ajax_loader_wizard_question" class="wizard_loading_image">';
                $front_html .= '</div>';
                if ( !empty( $sel_rows ) ) {
                    $front_html .= '<ul class="wprw-questions" id="wprw_question_list_new_' . esc_attr( $wizard_id ) . '">';
                    $question_id = $sel_rows->question_id;
                    $question_name = $sel_rows->name;
                    $option_type = ( isset( $sel_rows->option_type ) ? trim( $sel_rows->option_type ) : '' );
                    $sortable_id = $sel_rows->sortable_id;
                    $text_color_wizard_title = ( empty( $wizard_setting['text_color_wizard_title'] ) ? WPFPFW_DEFAULT_WIZARD_TEXT_COLOR : $wizard_setting['text_color_wizard_title'] );
                    $background_image_for_questions = ( empty( $wizard_setting['background_image_for_questions_upload_file'] ) ? WPFPFW_DEFAULT_BACKGROUND_IMAGE : $wizard_setting['background_image_for_questions_upload_file'] );
                    $option_row_item = ( empty( $wizard_setting['option_row_item'] ) ? WPFPFW_DEFAULT_OPTION_ROW_ITEM : sanitize_text_field( wp_unslash( $wizard_setting['option_row_item'] ) ) );
                    $background_color = ( empty( $wizard_setting['background_color'] ) ? '#000000' : $wizard_setting['background_color'] );
                    $text_color = ( empty( $wizard_setting['text_color'] ) ? '#ffffff' : $wizard_setting['text_color'] );
                    $background_color_for_options = ( empty( $wizard_setting['background_color_for_options'] ) ? WPFPFW_DEFAULT_OPTION_BACKGROUND_COLOR : $wizard_setting['background_color_for_options'] );
                    $text_color_for_options = ( empty( $wizard_setting['text_color_for_options'] ) ? WPFPFW_DEFAULT_OPTION_TEXT_COLOR : $wizard_setting['text_color_for_options'] );
                    $background_np_button_color = ( empty( $wizard_setting['background_np_button_color'] ) ? '#000000' : $wizard_setting['background_np_button_color'] );
                    $text_np_button_color = ( empty( $wizard_setting['text_np_button_color'] ) ? '#ffffff' : $wizard_setting['text_np_button_color'] );
                    $customization_css = '';
                    if ( !empty( $text_color_wizard_title ) ) {
                        $customization_css .= "#wizard_title_id_" . $wizard_id . " h1 {";
                        $customization_css .= "color: " . esc_attr( $text_color_wizard_title ) . " !important;";
                        $customization_css .= "}";
                    }
                    if ( !empty( $background_image_for_questions ) ) {
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw_question_list {";
                        $customization_css .= "background-image: url( " . esc_url( $background_image_for_questions ) . " ) !important;";
                        $customization_css .= "background-size: cover;";
                        $customization_css .= "background-repeat: no-repeat;";
                        $customization_css .= "background-position: center;";
                        $customization_css .= "}";
                    }
                    if ( !empty( $background_color ) ) {
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-question-text-panel, ";
                        $customization_css .= "#sub_prd_section_id_" . $wizard_id . " .tablenav-pages.front_pagination span.pagination-links a.selected, ";
                        $customization_css .= "#sub_prd_section_id_" . $wizard_id . " .wprw-product-headline, ";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprv-list-restart-button, ";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " button.wprw-button.wprw-button-show-result.wprw-button-inactive, ";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .pfw-final-step button.wprw-button.pfw-final-restart";
                        $customization_css .= "{";
                        $customization_css .= "background-color: " . esc_attr( $background_color ) . " !important;";
                        $customization_css .= "}";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .irs--round .irs-from, #wprw_list_new_" . $wizard_id . "  .irs--round .irs-to, .irs--round .irs-single {";
                        $customization_css .= "background-color: " . esc_attr( $background_color ) . " !important;";
                        $customization_css .= "}";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .irs--round .irs-from:before, .irs--round .irs-to:before, #wprw_list_new_" . $wizard_id . " .irs--round .irs-single:before {";
                        $customization_css .= "border-top-color: " . esc_attr( $background_color ) . " !important;";
                        $customization_css .= "}";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .irs--round .irs-handle {";
                        $customization_css .= "border: 4px solid " . esc_attr( $background_color ) . " !important;";
                        $customization_css .= "}";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .irs--round .irs-bar {";
                        $customization_css .= "background-color: " . esc_attr( $background_color ) . " !important;";
                        $customization_css .= "}";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .irs--round .irs-from, .irs--round .irs-to, .irs--round .irs-single {";
                        $customization_css .= "background-color: " . esc_attr( $background_color ) . " !important;";
                        $customization_css .= "}";
                    }
                    if ( !empty( $text_color ) ) {
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-question-text-panel .wprw-question-text, ";
                        $customization_css .= "#sub_prd_section_id_" . $wizard_id . " .tablenav-pages.front_pagination span.pagination-links a.selected, ";
                        $customization_css .= "#sub_prd_section_id_" . $wizard_id . " .wprw-product-headline, ";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprv-list-restart-button, ";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " button.wprw-button.wprw-button-show-result.wprw-button-inactive, ";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .pfw-final-step button.wprw-button.pfw-final-restart, ";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-question .wprw-question-text-panel .wprw-question-text span.success_msg2";
                        $customization_css .= "{";
                        $customization_css .= "color: " . esc_attr( $text_color ) . " !important;";
                        $customization_css .= "}";
                    }
                    if ( !empty( $background_color_for_options ) ) {
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-questions .wprw-question .wprw-answers .wprw-answer .wprw-answer-content";
                        $customization_css .= "{";
                        $customization_css .= "background-color: " . esc_attr( $background_color_for_options ) . " !important;";
                        $customization_css .= "}";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-answer-content.wprw-answer-selector";
                        $customization_css .= "{";
                        $customization_css .= "border-color: " . esc_attr( $background_color_for_options ) . " !important;";
                        $customization_css .= "}";
                    }
                    if ( !empty( $text_color_for_options ) ) {
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-questions .wprw-question .wprw-answers .wprw-answer .wprw-answer-content .wprw-radio .wprw-answer-selector .wprw-label-element-span";
                        $customization_css .= "{";
                        $customization_css .= "color: " . esc_attr( $text_color_for_options ) . " !important;";
                        $customization_css .= "}";
                    }
                    if ( !empty( $background_np_button_color ) ) {
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-button-next,";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-button-previous,";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .pfw-final-step button.wprw-button.pfw-final-back";
                        $customization_css .= "{";
                        $customization_css .= "background-color: " . esc_attr( $background_np_button_color ) . " !important;";
                        $customization_css .= "}";
                    }
                    if ( !empty( $text_np_button_color ) ) {
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-button-next,";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .wprw-button-previous,";
                        $customization_css .= "#wprw_list_new_" . $wizard_id . " .pfw-final-step button.wprw-button.pfw-final-back";
                        $customization_css .= "{";
                        $customization_css .= "color: " . esc_attr( $text_np_button_color ) . " !important;";
                        $customization_css .= "}";
                    }
                    wp_enqueue_style(
                        $this->plugin_name . 'css',
                        plugin_dir_url( __FILE__ ) . 'css/woo-product-finder-pro-public.css',
                        array(),
                        $this->version,
                        'all'
                    );
                    wp_add_inline_style( $this->plugin_name . 'css', $customization_css );
                    /* Get Next Questions ID */
                    $get_next_id_qry = "";
                    $get_next_id_qry .= "SELECT *";
                    $get_next_id_qry .= " FROM " . $questions_table_name;
                    $get_next_id_qry .= " WHERE sortable_id=" . "( select min( sortable_id ) from " . $questions_table_name . " where sortable_id > %d )";
                    $get_next_id_qry .= " AND wizard_id =%d";
                    $get_next_id_qry_prepare = $wpdb->prepare( $get_next_id_qry, $sortable_id, $wizard_id );
                    // phpcs:ignore
                    $get_next_id_rows = $wpdb->get_row( $get_next_id_qry_prepare );
                    // phpcs:ignore
                    $total_question = $test_obj->wpfp_count_questions_from_db_based_on_wizard_id( $wizard_id );
                    $remaining_total_question = $total_question - 1;
                    $next_question_html = '';
                    $next_title = ( empty( $wizard_setting['next_title'] ) ? 'Next' : $wizard_setting['next_title'] );
                    if ( !empty( $get_next_id_rows ) && $get_next_id_rows !== '0' ) {
                        $get_next_question_id = $get_next_id_rows->id;
                        $next_sortable_id = $get_next_id_rows->sortable_id;
                        $next_question_html .= '<button class="wprw-button wprw-button-next wprw-button-inactive wprw_next_cont" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $get_next_question_id ) . '_cur_' . esc_attr( $get_next_question_id ) . '_sortable_' . esc_attr( $next_sortable_id ) . '" data-totque="' . esc_attr( $total_question ) . '" data-prevque="' . esc_attr( $sortable_id ) . '" data-curque="' . esc_attr( $next_sortable_id ) . '" data-remque="' . esc_attr( $remaining_total_question ) . '">';
                        $next_question_html .= esc_html__( $next_title, 'woo-product-finder' );
                        $next_question_html .= '</button>';
                    } else {
                        $next_sortable_id = '';
                    }
                    if ( !empty( $question_name ) ) {
                        $front_html .= '<li class="wprw-question wprw-mandatory-question" id="ques_' . esc_attr( $question_id ) . '">';
                        $front_html .= '<div class="wprw-mandatory-message" style="display: none;">' . esc_html__( 'Please answer the question.', 'woo-product-finder' ) . '</div>';
                        $front_html .= '<div class="wprw-question-text-panel">';
                        $front_html .= '<div class="wprw-question-text">' . wp_kses_post( $question_name ) . '</div>';
                        $front_html .= '</div>';
                        $front_html .= '<ul class="wprw-answers">';
                        $sel_qry = $wpdb->prepare( 'SELECT * FROM ' . $options_table_name . ' WHERE wizard_id = %d AND question_id = %d ORDER BY sortable_id ASC', $wizard_id, $question_id );
                        // phpcs:ignore
                        $sel_rows = $wpdb->get_results( $sel_qry );
                        // phpcs:ignore
                        $total_option_count = $wpdb->get_var( $sel_qry );
                        // phpcs:ignore
                        if ( !empty( $sel_rows ) && is_array( $sel_rows ) ) {
                            $i = 0;
                            foreach ( $sel_rows as $sel_data ) {
                                $i++;
                                $option_id = $sel_data->id;
                                $option_name = $sel_data->option_name;
                                $option_image = '';
                                if ( $option_type === 'radio' ) {
                                    $div_answer_action_class = 'radio';
                                } else {
                                    $div_answer_action_class = 'checkbox';
                                }
                                if ( $option_row_item ) {
                                    $row_extra_class = 12 / $option_row_item;
                                } else {
                                    $row_extra_class = '2';
                                }
                                $div_class = 'col-md-' . esc_attr( $row_extra_class ) . ' col-sm-6 col-xs-12';
                                $li_class = ( empty( $option_image ) ? 'li_simple_option' : 'li_img_option li_img_option_' . $total_option_count . '' );
                                if ( !empty( $option_name ) ) {
                                    $front_html .= '<li class="' . esc_attr( $div_class ) . ' wprw-answer wprw-selected-answer ' . esc_attr( $li_class ) . '" id="opt_attr_' . esc_attr( $option_id ) . '">';
                                    if ( isset( $sel_data->option_attribute_next ) && !empty( $sel_data->option_attribute_next ) ) {
                                        $sel_qry_nxt = $wpdb->prepare( 'SELECT * FROM ' . $questions_table_name . ' WHERE wizard_id = %d AND id = %d ORDER BY sortable_id ASC', $sel_data->wizard_id, $sel_data->option_attribute_next );
                                        // phpcs:ignore
                                        $sel_rows_nxt = $wpdb->get_results( $sel_qry_nxt, OBJECT );
                                        // phpcs:ignore
                                        $front_html .= '<input type="hidden" class="wprw_option_next_que" value="wd_' . $sel_data->wizard_id . '_que_' . $sel_data->option_attribute_next . '_cur_' . $sel_data->option_attribute_next . '_sortable_' . $sel_rows_nxt[0]->sortable_id . '">';
                                        $front_html .= '<input type="hidden" class="wprw_option_prev_que" value="wd_' . $sel_data->wizard_id . '_que_' . $sel_data->question_id . '_cur_' . $sel_data->question_id . '_sortable_' . $sortable_id . '">';
                                    }
                                    if ( !empty( $option_image ) ) {
                                        $front_html .= '<div class="wprw-answer-image wprw-answer-selector">';
                                        $front_html .= '<img class="wprw-desktop-image wprw-active-image" src=' . esc_url( $option_image ) . '>';
                                        $front_html .= '</div>';
                                    }
                                    $front_html .= '<div class="wprw-answer-content wprw-answer-selector">';
                                    $front_html .= '<div class="wprw-answer-action wprw-action-element wprw-' . esc_attr( $div_answer_action_class ) . '">';
                                    $front_html .= '<span class="wprw-answer-selector" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '">';
                                    if ( $option_type === 'radio' ) {
                                        $front_html .= '<input class="wprw-input" type="radio" value="' . esc_attr( $option_id ) . '" name="option_name" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '">';
                                    }
                                    $front_html .= '<span class="wprw-label-element-span wprw-answer-label">';
                                    $front_html .= '<span class="wprw-answer-label wprw-label-element">' . wp_kses_post( $option_name ) . '</span>';
                                    $front_html .= '</span>';
                                    $front_html .= '</span>';
                                    $front_html .= '</div>';
                                    $front_html .= '</div>';
                                    $front_html .= '</li>';
                                } else {
                                    $front_html .= '<li class="wprw-answer wprw-selected-answer">';
                                    $front_html .= '<div class="wprw-answer-content wprw-answer-selector">';
                                    $front_html .= '<div class="wprw-answer-action wprw-action-element wprw-checkbox">';
                                    $front_html .= '<span class="wprw-answer-selector">';
                                    $front_html .= '<span class="wprw-label-element-span wprw-answer-label">';
                                    $front_html .= '<span class="wprw-answer-label wprw-label-element">' . esc_html__( 'No Option Available', 'woo-product-finder' ) . '</span>';
                                    $front_html .= '</span>';
                                    $front_html .= '</span>';
                                    $front_html .= '</div>';
                                    $front_html .= '</div>';
                                    $front_html .= '</li>';
                                }
                            }
                        }
                        $front_html .= '</ul>';
                        $front_html .= '</li>';
                        $front_html .= '<div class="wprw-page-nav-buttons">';
                        $front_html .= $next_question_html;
                        // WPCS: XSS OK.
                        $front_html .= '</div>';
                    } else {
                        $front_html .= '<li class="wprw-question wprw-mandatory-question" id="ques_">';
                        $front_html .= '<div class="wprw-question-text-panel">';
                        $front_html .= '<div class="wprw-question-text">' . esc_html__( 'No Questions Available', 'woo-product-finder' ) . '</div>';
                        $front_html .= '</div>';
                        $front_html .= '</li>';
                    }
                }
                $front_html .= '</ul>';
                $question_result = $test_obj->wpfp_get_all_question_list( $wizard_id );
                $question_id_array = array();
                if ( !empty( $question_result ) && is_array( $question_result ) ) {
                    foreach ( $question_result as $question_result_data ) {
                        $all_question_id = $question_result_data->id;
                        $question_id_array[] = $question_result_data->id;
                        $front_html .= '<input type="hidden" name="current_selected_value_name" id="current_selected_value_id_' . esc_attr( $all_question_id ) . '" value=""/>';
                    }
                }
                $question_id_array_implode = implode( ',', $question_id_array );
                $mquery = "SELECT * FROM  " . $wizard_table_name . "  WHERE id=%d";
                $mqry_prepare = $wpdb->prepare( $mquery, $wizard_id );
                // phpcs:ignore
                $mrows = $wpdb->get_row( $mqry_prepare );
                // phpcs:ignore
                $min_max_price = $mrows->range_status;
                $front_html .= '<input type="hidden" name="all_selected_value" id="all_selected_value" value=""/>';
                $front_html .= '<input type="hidden" name="all_question_id" id="all_question_value" value="' . esc_attr( $question_id_array_implode ) . '"/>';
                $front_html .= '<input type="hidden" name="wpfp_min_price" id="wpfp_min_price" value=""/>';
                $front_html .= '<input type="hidden" name="wpfp_max_price" id="wpfp_max_price" value=""/>';
                $front_html .= '</div>';
                $front_html .= '<div class="pfw-final-step" style="display:none;">';
                $front_html .= '<div class="range-div wprw-dv">';
                if ( isset( $min_max_price ) && 'on' === $min_max_price ) {
                    $min_max_price = $mrows->wizard_price_range;
                    $mmp = explode( '||', $min_max_price );
                    if ( isset( $mmp[0] ) && !empty( $mmp[1] ) && isset( $mmp[1] ) ) {
                        $front_html .= '<input type="text" class="wpfp_price_range" name="wpfp_price_range" value="" data-type="double" data-min="' . esc_attr( $mmp[0] ) . '" data-max="' . esc_attr( $mmp[1] ) . '" data-grid="true" />';
                    }
                }
                $front_html .= '</div>';
                $front_html .= '<div class="wprw-dv"></div>';
                $front_html .= '<div class="wprw-dv btns"><button class="wprw-button pfw-final-back">Back</button><button class="wprw-button pfw-final-restart">' . esc_html__( $restart_title, 'woo-product-finder' ) . '</button></div>';
                $front_html .= '</div>';
                $front_html .= '<div class="product_list" id="product_list_id_' . esc_attr( $wizard_id ) . '">';
                $front_html .= '<div class="main_all_prd_section">';
                $front_html .= '<div class="sub_prd_section" id="sub_prd_section_id_' . esc_attr( $wizard_id ) . '">';
                $front_html .= '<div id="ajax_loader_wizard_div">';
                $front_html .= '<img src="' . esc_url( $ajax_loader_wizard ) . '" id="ajax_loader_wizard" class="wizard_loading_image">';
                $front_html .= '</div>';
                $front_html .= '<div id="perfect_product_div_' . esc_attr( $wizard_id ) . '">';
                $front_html .= '</div>';
                $front_html .= '<div id="recently_product_div_' . esc_attr( $wizard_id ) . '">';
                $front_html .= '</div>';
                $front_html .= '<div id="front_pagination_div_' . esc_attr( $wizard_id ) . '">';
                $front_html .= '</div>';
                $front_html .= '</div>';
                $front_html .= '</div>';
                $front_html .= '</div>';
                $front_html .= '</div>';
                add_filter( 'safe_style_css', function ( $styles ) {
                    $styles[] = 'display';
                    return $styles;
                } );
                $allowed_html = wp_kses_allowed_html( 'post' );
                $allowed_input_html = array(
                    'input' => array(
                        'id'                => array(),
                        'type'              => array(),
                        'name'              => array(),
                        'class'             => array(),
                        'value'             => array(),
                        'data-name'         => array(),
                        'data-type'         => array(),
                        'data-min'          => array(),
                        'data-max'          => array(),
                        'data-grid'         => array(),
                        'data-all-question' => array(),
                    ),
                    'div'   => array(
                        'style' => array(),
                        'id'    => array(),
                        'name'  => array(),
                        'class' => array(),
                    ),
                );
                $f_array = array_merge( $allowed_html, $allowed_input_html );
                return wp_kses( $front_html, $f_array );
            }
        };
        add_shortcode( "wpfp_" . $wizard_id, $cb );
    }
}