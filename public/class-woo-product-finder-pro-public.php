<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Finder_Pro
 * @subpackage Woo_Product_Finder_Pro/public
 */
/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Product_Finder_Pro
 * @subpackage Woo_Product_Finder_Pro/public
 * @author     Multidots <inquiry@multidots.in>
 */
// Exit if accessed directly
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class WPFPFW_Woo_Product_Finder_Pro_Public {
    /**
     * The ID of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $plugin_name The ID of this plugin.
     */
    private $plugin_name;

    /**
     * The version of this plugin.
     *
     * @since    1.0.0
     * @access   private
     * @var      string $version The current version of this plugin.
     */
    private $version;

    /**
     * Initialize the class and set its properties.
     *
     * @since    1.0.0
     *
     * @param      string $plugin_name The name of the plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the public-facing side of the site.
     *
     * @since    1.0.0
     * @access   public
     */
    public function enqueue_styles() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Product_Finder_Pro_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Product_Finder_Pro_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        wp_enqueue_style(
            $this->plugin_name,
            plugin_dir_url( __FILE__ ) . 'css/woo-product-finder-pro-public.css',
            array(),
            $this->version,
            'all'
        );
        wp_enqueue_style(
            $this->plugin_name . 'font-awesome',
            WPFP_PLUGIN_URL . 'admin/css/font-awesome.min.css',
            array(),
            $this->version,
            'all'
        );
        wp_enqueue_style(
            $this->plugin_name . 'rangeSlider',
            plugin_dir_url( __FILE__ ) . 'css/ion.rangeSlider.min.css',
            array(),
            $this->version,
            'all'
        );
    }

    /**
     * Register the JavaScript for the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts() {
        /**
         * This function is provided for demonstration purposes only.
         *
         * An instance of this class should be passed to the run() function
         * defined in Woo_Product_Finder_Pro_Loader as all of the hooks are defined
         * in that particular class.
         *
         * The Woo_Product_Finder_Pro_Loader will then create the relationship
         * between the defined hooks and the functions defined in this
         * class.
         */
        $shipping_method_format = get_option( 'md_woocommerce_shipping_method_format' );
        wp_register_script(
            'productFrontRecommendationWizardPro',
            plugin_dir_url( __FILE__ ) . 'js/woo-product-finder-pro-public.js',
            array('jquery'),
            $this->version,
            false
        );
        wp_register_script(
            'ion_rangeSlider_min',
            plugin_dir_url( __FILE__ ) . 'js/ion.rangeSlider.min.js',
            array('jquery'),
            $this->version,
            false
        );
        wp_enqueue_script( 'ion_rangeSlider_min' );
        wp_localize_script( 'productFrontRecommendationWizardPro', 'MyAjax', array(
            'ajaxurl'          => admin_url( 'admin-ajax.php' ),
            'ajax_icon'        => plugin_dir_url( __FILE__ ) . '/images/ajax-loader.gif',
            'show_result_last' => $shipping_method_format,
        ) );
        wp_enqueue_script( 'productFrontRecommendationWizardPro' );
    }

    /**
     * Get the next question when click on next button based on ajax in front side
     *
     * @since    1.0.0
     *
     * @return   html  Its return html for next questions with multiple parameter ( sequences : string, html,array with encoded questions id )
     *
     */
    public function wpfp_get_next_questions_front_side() {
        if ( !empty( $_REQUEST['current_wizard_id'] ) && isset( $_REQUEST['current_wizard_id'] ) ) {
            // phpcs:ignore
            $wizard_id = sanitize_text_field( wp_unslash( $_REQUEST['current_wizard_id'] ) );
            // phpcs:ignore
        } else {
            $wizard_id = '';
        }
        if ( !empty( $_REQUEST['current_question_id'] ) && isset( $_REQUEST['current_question_id'] ) ) {
            // phpcs:ignore
            $current_question_id = sanitize_text_field( wp_unslash( $_REQUEST['current_question_id'] ) );
            // phpcs:ignore
        } else {
            $current_question_id = '';
        }
        if ( !empty( $_REQUEST['sortable_id'] ) && isset( $_REQUEST['sortable_id'] ) ) {
            // phpcs:ignore
            $sortable_id = sanitize_text_field( wp_unslash( $_REQUEST['sortable_id'] ) );
            // phpcs:ignore
        } else {
            $sortable_id = '';
        }
        if ( !empty( $_REQUEST['remque'] ) && isset( $_REQUEST['remque'] ) ) {
            // phpcs:ignore
            $remque = sanitize_text_field( wp_unslash( $_REQUEST['remque'] ) );
            // phpcs:ignore
        } else {
            $remque = '';
        }
        $show_attribute_field = $this->wpfp_get_product_per_attribute_based_on_wizard_id( $wizard_id );
        $question_result = $this->wpfp_get_all_question_list( $wizard_id );
        $question_id_array = array();
        if ( !empty( $question_result ) ) {
            foreach ( $question_result as $question_result_data ) {
                $question_id_array[] = $question_result_data->id;
            }
        }
        $all_selected_value_id = filter_input(
            INPUT_POST,
            'all_selected_value_id',
            FILTER_DEFAULT,
            FILTER_REQUIRE_ARRAY
        );
        if ( !empty( $all_selected_value_id ) && isset( $all_selected_value_id ) ) {
            $all_selected_value_id = $all_selected_value_id;
        } else {
            $all_selected_value_id = '';
        }
        $count_remain_que = filter_input( INPUT_POST, 'count_remain_que', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $remove_current_questoin_id = filter_input(
            INPUT_POST,
            'remove_current_questoin_id',
            FILTER_DEFAULT,
            FILTER_REQUIRE_ARRAY
        );
        $cur_que_id_on_nxt_btn = filter_input( INPUT_POST, 'cur_que_id_on_nxt_btn', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $count_remain_que = ( !empty( $count_remain_que ) && isset( $count_remain_que ) ? $count_remain_que : '' );
        $remove_current_questoin_id = ( !empty( $remove_current_questoin_id ) && isset( $remove_current_questoin_id ) ? $remove_current_questoin_id : '' );
        $cur_que_id_on_nxt_btn = ( !empty( $cur_que_id_on_nxt_btn ) && isset( $cur_que_id_on_nxt_btn ) ? $cur_que_id_on_nxt_btn : '' );
        $next_question_html = $this->wpfp_get_next_button_front_side(
            $wizard_id,
            $current_question_id,
            $all_selected_value_id,
            $sortable_id,
            $count_remain_que,
            $remove_current_questoin_id,
            $cur_que_id_on_nxt_btn,
            $remque
        );
        $previous_question_html = $this->wpfp_get_previous_button_front_side(
            $wizard_id,
            $current_question_id,
            $all_selected_value_id,
            $sortable_id,
            $count_remain_que,
            $remove_current_questoin_id,
            $cur_que_id_on_nxt_btn,
            $remque
        );
        $next_html = '';
        $next_html .= $this->wpfp_ajax_get_question_option_list_based_on_next_and_previous(
            $wizard_id,
            $current_question_id,
            $all_selected_value_id,
            $sortable_id,
            $count_remain_que,
            $remove_current_questoin_id,
            $cur_que_id_on_nxt_btn,
            $remque
        );
        $next_html .= '<div class="wprw-page-nav-buttons">';
        $allowed_html = wp_kses_allowed_html( 'post' );
        $allowed_input_html = array(
            'button' => array(
                'id'               => array(),
                'type'             => array(),
                'name'             => array(),
                'class'            => array(),
                'value'            => array(),
                'data-name'        => array(),
                'data-totque'      => array(),
                'data-prevque'     => array(),
                'data-curque'      => array(),
                'data-remque'      => array(),
                'data-countremque' => array(),
                'data-remque'      => array(),
            ),
        );
        $f_array = array_merge( $allowed_html, $allowed_input_html );
        $next_html .= wp_kses( $previous_question_html, $f_array );
        $next_html .= wp_kses( $next_question_html, $f_array );
        $next_html .= '</div>';
        echo wp_json_encode( array(
            'next_html'            => $next_html,
            'question_id_array'    => $question_id_array,
            'show_attribute_field' => $show_attribute_field,
        ) );
        // phpcs:ignore
        wp_die();
    }

    /**
     * Get Product Per Attribute From Database
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id
     *
     * @return string
     *
     */
    public function wpfp_get_product_per_attribute_based_on_wizard_id( $wizard_id ) {
        global $wpdb;
        $show_attribute_field = "";
        $wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
        $sel_wizard_qry = $wpdb->prepare( 'SELECT * FROM ' . $wizard_table_name . ' WHERE id= %d ', $wizard_id );
        // phpcs:ignore
        $sel_wizard_rows = $wpdb->get_row( $sel_wizard_qry );
        // phpcs:ignore
        if ( !empty( $sel_wizard_rows ) && $sel_wizard_rows !== '' ) {
            $wizard_setting = ( empty( $sel_wizard_rows->wizard_setting ) ? '' : json_decode( $sel_wizard_rows->wizard_setting, true ) );
            $show_attribute_field = ( isset( $wizard_setting['show_attribute_field'] ) && !empty( $wizard_setting['show_attribute_field'] ) ? sanitize_text_field( wp_unslash( $wizard_setting['show_attribute_field'] ) ) : '3' );
        }
        return $show_attribute_field;
    }

    /**
     * Get all questions list
     *
     * @since    1.0.0
     *
     * @param      int $wizard_id wizard id.
     *
     * @return array Its return whole results set
     *
     */
    public function wpfp_get_all_question_list( $wizard_id ) {
        global $wpdb;
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $sel_qry = $wpdb->prepare( 'SELECT * FROM ' . $questions_table_name . ' WHERE wizard_id=%d ORDER BY id ASC', $wizard_id );
        // phpcs:ignore
        $sel_rows = $wpdb->get_results( $sel_qry );
        // phpcs:ignore
        if ( !empty( $sel_rows ) && $sel_rows !== '0' && isset( $sel_rows ) ) {
            return $sel_rows;
        }
    }

    /**
     * Get the next button in front side
     *
     * @since    1.0.0
     *
     * @return   html  Its return next button with next question id
     *
     */
    public function wpfp_get_next_button_front_side(
        $wizard_id,
        $current_question_id,
        $all_selected_value_id,
        $sortable_id,
        $count_remain_que,
        $remove_current_questoin_id,
        $cur_que_id_on_nxt_btn,
        $remque
    ) {
        /* Get Next Questions ID */
        global $wpdb;
        $wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
        $get_next_sortable_id = '';
        $sel_wizard_qry = $wpdb->prepare( 'SELECT * FROM ' . $wizard_table_name . ' WHERE id = %d', $wizard_id );
        // phpcs:ignore
        $sel_wizard_rows = $wpdb->get_row( $sel_wizard_qry );
        // phpcs:ignore
        $wizard_setting = ( empty( $sel_wizard_rows->wizard_setting ) ? '' : json_decode( $sel_wizard_rows->wizard_setting, true ) );
        $show_result_title = ( empty( $wizard_setting['show_result_title'] ) ? WPFPFW_SHOW_RESULT_TITLE : $wizard_setting['show_result_title'] );
        $next_title = ( empty( $wizard_setting['next_title'] ) ? 'Next' : $wizard_setting['next_title'] );
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $get_next_id_qry = $wpdb->prepare( 'SELECT * FROM ' . $questions_table_name . ' WHERE sortable_id > %d AND wizard_id = %d ORDER BY sortable_id ASC LIMIT 1', $sortable_id, $wizard_id );
        // phpcs:ignore
        $total_question = $this->wpfp_count_questions_from_db_based_on_wizard_id( $wizard_id );
        $question_result = $this->wpfp_get_all_question_list( $wizard_id );
        $question_id_array = array();
        if ( !empty( $question_result ) ) {
            foreach ( $question_result as $question_result_data ) {
                $question_id_array[] = $question_result_data->id;
            }
        }
        $get_next_id_rows = $wpdb->get_row( $get_next_id_qry );
        // phpcs:ignore
        $next_question_html = '';
        if ( empty( $remove_current_questoin_id ) && !empty( $current_question_id ) ) {
            $next_question_html .= '<button class="wprw-congatu-next wprw-button wprw-button-next wprw-button-inactive" id="wd_' . esc_attr( $wizard_id ) . '_que_0_cur_0_sortable_' . esc_attr( $cur_que_id_on_nxt_btn ) . '" data-totque="' . esc_attr( $total_question ) . '" data-curque="' . esc_attr( $cur_que_id_on_nxt_btn ) . '" data-prevque="' . esc_attr( $cur_que_id_on_nxt_btn ) . '" data-countremque="' . esc_attr( $get_next_sortable_id ) . '">';
            $next_question_html .= __( $next_title, 'woo-product-finder' );
            $next_question_html .= '</button>';
        } else {
            if ( empty( $remove_current_questoin_id ) && empty( $current_question_id ) ) {
                $next_question_html .= '<button class="wprw-button wprw-button-show-result wprw-button-inactive">';
                $next_question_html .= esc_html__( $show_result_title, 'woo-product-finder' );
                $next_question_html .= '</button>';
            } else {
                if ( !empty( $get_next_id_rows ) && $get_next_id_rows !== '0' ) {
                    $get_next_question_id = $get_next_id_rows->id;
                    $get_next_sortable_id = $get_next_id_rows->sortable_id;
                    $next_question_html .= '<button class="wprw-button wprw-button-next wprw-button-inactive wprw_next_cont" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $get_next_question_id ) . '_cur_' . esc_attr( $get_next_question_id ) . '_sortable_' . esc_attr( $get_next_sortable_id ) . '" data-totque="' . esc_attr( $total_question ) . '" data-prevque="' . esc_attr( $sortable_id ) . '" data-curque="' . esc_attr( $get_next_sortable_id ) . '" data-countremque="' . esc_attr( $get_next_sortable_id ) . '" data-remque="' . esc_attr( $remque ) . '" >';
                    $next_question_html .= __( $next_title, 'woo-product-finder' );
                    $next_question_html .= '</button>';
                } else {
                    $get_next_sortable_id = '';
                    $next_question_html .= '<button class="wprw-button wprw-button-show-result wprw-button-inactive">';
                    $next_question_html .= esc_html__( $show_result_title, 'woo-product-finder' );
                    $next_question_html .= '</button>';
                }
            }
        }
        $allowed_html = wp_kses_allowed_html( 'post' );
        $allowed_input_html = array(
            'button' => array(
                'id'               => array(),
                'type'             => array(),
                'name'             => array(),
                'class'            => array(),
                'value'            => array(),
                'data-name'        => array(),
                'data-totque'      => array(),
                'data-prevque'     => array(),
                'data-curque'      => array(),
                'data-remque'      => array(),
                'data-countremque' => array(),
                'data-remque'      => array(),
            ),
        );
        $f_array = array_merge( $allowed_html, $allowed_input_html );
        return wp_kses( $next_question_html, $f_array );
    }

    /**
     * Count total questions from database based on wizard id
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id
     *
     * @return string
     *
     */
    public function wpfp_count_questions_from_db_based_on_wizard_id( $wizard_id ) {
        global $wpdb;
        $total_questions = '';
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $count_que_qry = $wpdb->prepare( 'SELECT COUNT(id) AS total_que FROM ' . $questions_table_name . ' WHERE wizard_id = %d', $wizard_id );
        // phpcs:ignore
        $count_que_rows = $wpdb->get_row( $count_que_qry );
        // phpcs:ignore
        if ( !empty( $count_que_rows ) && $count_que_rows !== '' ) {
            $total_questions = $count_que_rows->total_que;
        }
        return $total_questions;
    }

    /**
     * Get the previous button in front side
     *
     * @since    1.0.0
     *
     * @return   html  Its return previous button with previous question id
     *
     */
    public function wpfp_get_previous_button_front_side(
        $wizard_id,
        $current_question_id,
        $all_selected_value_id,
        $sortable_id,
        $count_remain_que,
        $remove_current_questoin_id,
        $cur_que_id_on_nxt_btn,
        $remque
    ) {
        /* Get Previous Questions ID */
        global $wpdb;
        $wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
        $sel_wizard_qry = $wpdb->prepare( 'SELECT * FROM ' . $wizard_table_name . ' WHERE id = %d', $wizard_id );
        // phpcs:ignore
        $sel_wizard_rows = $wpdb->get_row( $sel_wizard_qry );
        // phpcs:ignore
        $wizard_setting = ( empty( $sel_wizard_rows->wizard_setting ) ? '' : json_decode( $sel_wizard_rows->wizard_setting, true ) );
        $back_title = ( empty( $wizard_setting['back_title'] ) ? 'Back' : $wizard_setting['back_title'] );
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $get_previous_id_qry = $wpdb->prepare( 'SELECT * FROM ' . $questions_table_name . ' WHERE sortable_id < %d AND wizard_id=%d ORDER BY sortable_id DESC LIMIT 1', $sortable_id, $wizard_id );
        // phpcs:ignore
        $total_question = $this->wpfp_count_questions_from_db_based_on_wizard_id( $wizard_id );
        $question_result = $this->wpfp_get_all_question_list( $wizard_id );
        $question_id_array = array();
        if ( !empty( $question_result ) ) {
            foreach ( $question_result as $question_result_data ) {
                $question_id_array[] = $question_result_data->id;
            }
        }
        $get_previous_id_rows = $wpdb->get_row( $get_previous_id_qry );
        // phpcs:ignore
        $previous_question_html = '';
        if ( empty( $remove_current_questoin_id ) ) {
            $previous_question_html .= '<button class="wprw-button wprw-button-previous wprw-button-inactive wprw-congatu-prev" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $cur_que_id_on_nxt_btn ) . '_cur_0_sortable_' . esc_attr( $cur_que_id_on_nxt_btn ) . '" data-totque="' . esc_attr( $total_question ) . '" data-prevque="' . esc_attr( $cur_que_id_on_nxt_btn ) . '" data-curque="' . esc_attr( $cur_que_id_on_nxt_btn ) . '" data-remque="' . esc_attr( $remque ) . '" >';
            $previous_question_html .= __( $back_title, 'woo-product-finder' );
            $previous_question_html .= '</button>';
        } else {
            if ( !empty( $get_previous_id_rows ) && $get_previous_id_rows !== '0' ) {
                $get_previous_question_id = $get_previous_id_rows->id;
                $get_previous_sortable_id = $get_previous_id_rows->sortable_id;
                $previous_question_html .= '<button class="wprw-button wprw-button-previous wprw-button-inactive" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $get_previous_question_id ) . '_cur_' . esc_attr( $get_previous_question_id ) . '_sortable_' . esc_attr( $get_previous_sortable_id ) . '" data-totque="' . esc_attr( $total_question ) . '" data-prevque="' . esc_attr( $sortable_id ) . '" data-curque="' . esc_attr( $get_previous_sortable_id ) . '" data-remque="' . esc_attr( $remque ) . '" >';
                $previous_question_html .= __( $back_title, 'woo-product-finder' );
                $previous_question_html .= '</button>';
            } else {
                $get_previous_sortable_id = '';
                $previous_question_html .= '';
            }
        }
        $allowed_html = wp_kses_allowed_html( 'post' );
        $allowed_input_html = array(
            'button' => array(
                'id'               => array(),
                'type'             => array(),
                'name'             => array(),
                'class'            => array(),
                'value'            => array(),
                'data-name'        => array(),
                'data-totque'      => array(),
                'data-prevque'     => array(),
                'data-curque'      => array(),
                'data-remque'      => array(),
                'data-countremque' => array(),
                'data-remque'      => array(),
            ),
        );
        $f_array = array_merge( $allowed_html, $allowed_input_html );
        return wp_kses( $previous_question_html, $f_array );
    }

    /**
     * Get option list with questions based on next and prev button in front side
     *
     * @since    1.0.0
     *
     * @return   html  Its return question list with options
     *
     */
    public function wpfp_ajax_get_question_option_list_based_on_next_and_previous(
        $wizard_id,
        $current_question_id,
        $all_selected_value_id,
        $sortable_id,
        $count_remain_que,
        $remove_current_questoin_id
    ) {
        global $wpdb;
        $sel_wizard_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id = %d", $wizard_id ) );
        // phpcs:ignore
        $wizard_setting = ( empty( $sel_wizard_rows->wizard_setting ) ? '' : json_decode( $sel_wizard_rows->wizard_setting, true ) );
        $option_row_item = ( empty( $wizard_setting['option_row_item'] ) ? WPFPFW_DEFAULT_OPTION_ROW_ITEM : sanitize_text_field( wp_unslash( $wizard_setting['option_row_item'] ) ) );
        $congratulations_title = ( empty( $wizard_setting['congratulations_title'] ) ? 'Congratulations' : sanitize_text_field( wp_unslash( $wizard_setting['congratulations_title'] ) ) );
        $congratulations_message_title = ( empty( $wizard_setting['congratulations_message_title'] ) ? WPFPFW_CONGRATULATIONS_MESSAGE_TITLE : sanitize_text_field( wp_unslash( $wizard_setting['congratulations_message_title'] ) ) );
        $sel_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions WHERE wizard_id=%d AND sortable_id=%d ORDER BY id ASC", $wizard_id, $sortable_id ) );
        // phpcs:ignore
        $ajax_html = '';
        if ( empty( $remove_current_questoin_id ) ) {
            $ajax_html .= '<li class="wprw-question wprw-congatu-msg" id="ques_result">';
            $ajax_html .= '<div class="wprw-question-text-panel">';
            $ajax_html .= '<div class="wprw-question-text">';
            $ajax_html .= '<span class="success_msg1">' . esc_html__( $congratulations_title, 'woo-product-finder' ) . '</span>';
            $ajax_html .= '<span class="success_msg2">' . esc_html__( $congratulations_message_title, 'woo-product-finder' ) . '</span>';
            $ajax_html .= '</div>';
            $ajax_html .= '</div>';
        } else {
            if ( !empty( $sel_rows ) && is_array( $sel_rows ) ) {
                foreach ( $sel_rows as $sel_data ) {
                    $question_id = $sel_data->id;
                    $question_name = $sel_data->name;
                    $option_type = trim( $sel_data->option_type );
                    $sel_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id=%d AND question_id=%d ORDER BY sortable_id ASC", $wizard_id, $question_id ) );
                    // phpcs:ignore
                    $total_option_count = $wpdb->get_var( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id=%d AND question_id=%d ORDER BY sortable_id ASC", $wizard_id, $question_id ) );
                    // phpcs:ignore
                    $ajax_html .= '<li class="wprw-question wprw-mandatory-question" id="ques_' . esc_attr( $question_id ) . '">';
                    $ajax_html .= '<div class="wprw-question-text-panel">';
                    $ajax_html .= '<div class="wprw-question-text">' . wp_kses_post( $question_name ) . '</div>';
                    $ajax_html .= '</div>';
                    $ajax_html .= '<ul class="wprw-answers">';
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
                            $ajax_html .= '<li class="' . esc_attr( $div_class ) . ' wprw-answer wprw-selected-answer ' . esc_attr( $li_class ) . '" id="opt_attr_' . esc_attr( $option_id ) . '">';
                            if ( isset( $sel_data->option_attribute_next ) && !empty( $sel_data->option_attribute_next ) ) {
                                $sel_rows_nxt = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions WHERE wizard_id = %d AND id = %d ORDER BY sortable_id ASC", $sel_data->wizard_id, $sel_data->option_attribute_next ), OBJECT );
                                // phpcs:ignore
                                $ajax_html .= '<input type="hidden" class="wprw_option_next_que" value="wd_' . $sel_data->wizard_id . '_que_' . $sel_data->option_attribute_next . '_cur_' . $sel_data->option_attribute_next . '_sortable_' . $sel_rows_nxt[0]->sortable_id . '">';
                                $ajax_html .= '<input type="hidden" class="wprw_option_prev_que" value="wd_' . $sel_data->wizard_id . '_que_' . $sel_data->question_id . '_cur_' . $sel_data->question_id . '_sortable_' . $sortable_id . '">';
                            }
                            $ajax_html .= '<div class="wprw-answer-content wprw-answer-selector">';
                            if ( !empty( $option_image ) ) {
                                $ajax_html .= '<div class="wprw-answer-image wprw-answer-selector">';
                                $ajax_html .= '<img class="wprw-desktop-image wprw-active-image" src=' . esc_url( $option_image ) . '>';
                                $ajax_html .= '</div>';
                            }
                            $ajax_html .= '<div class="wprw-answer-action wprw-action-element wprw-' . esc_attr( $div_answer_action_class ) . '">';
                            $ajax_html .= '<span class="wprw-answer-selector" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '">';
                            if ( $option_type === 'radio' ) {
                                $ajax_html .= '<input class="wprw-input" type="radio" value="' . esc_attr( $option_id ) . '" name="option_name_' . esc_attr( $question_id ) . '" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '">';
                            } elseif ( $option_type === 'checkbox' ) {
                                $ajax_html .= '<input class="wprw-input" type="checkbox" value="' . esc_attr( $option_id ) . '" name="' . $option_name . '" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '">';
                            }
                            $ajax_html .= '<span class="wprw-label-element-span wprw-answer-label">';
                            $ajax_html .= '<span class="wprw-answer-label wprw-label-element">' . wp_kses_post( $option_name ) . '</span>';
                            $ajax_html .= '</span>';
                            $ajax_html .= '</span>';
                            $ajax_html .= '</div>';
                            $ajax_html .= '</div>';
                            $ajax_html .= '</li>';
                        }
                    } else {
                        $ajax_html .= '<li class="wprw-answer wprw-selected-answer li_no_option">';
                        $ajax_html .= '<div class="wprw-answer-content wprw-answer-selector">';
                        $ajax_html .= '<div class="wprw-answer-action wprw-action-element wprw-checkbox">';
                        $ajax_html .= '<span class="wprw-answer-selector">';
                        $ajax_html .= '<span class="wprw-label-element-span wprw-answer-label">';
                        $ajax_html .= '<span class="wprw-answer-label wprw-label-element">' . esc_html__( 'No Option Available', 'woo-product-finder' ) . '</span>';
                        $ajax_html .= '</span>';
                        $ajax_html .= '</span>';
                        $ajax_html .= '</div>';
                        $ajax_html .= '</div>';
                        $ajax_html .= '</li>';
                    }
                    $ajax_html .= '</ul>';
                    $ajax_html .= '</li>';
                }
            }
        }
        $allowed_html = wp_kses_allowed_html( 'post' );
        $allowed_input_html = array(
            'input' => array(
                'id'               => array(),
                'type'             => array(),
                'name'             => array(),
                'class'            => array(),
                'value'            => array(),
                'data-name'        => array(),
                'data-totque'      => array(),
                'data-prevque'     => array(),
                'data-curque'      => array(),
                'data-remque'      => array(),
                'data-countremque' => array(),
                'data-remque'      => array(),
            ),
        );
        $f_array = array_merge( $allowed_html, $allowed_input_html );
        return wp_kses( $ajax_html, $f_array );
        // WPCS: XSS OK.
    }

    /**
     * Get the previous question when click on next button based on ajax in front side
     *
     * @since    1.0.0
     *
     * @return   html  Its return html for previous questions with multiple parameter ( sequences : string, html,array with encoded questions id )
     *
     */
    public function wpfp_get_previous_questions_front_side() {
        if ( !empty( $_REQUEST['current_wizard_id'] ) && isset( $_REQUEST['current_wizard_id'] ) ) {
            // phpcs:ignore
            $wizard_id = sanitize_text_field( wp_unslash( $_REQUEST['current_wizard_id'] ) );
            // phpcs:ignore
        } else {
            $wizard_id = '';
        }
        if ( !empty( $_REQUEST['current_question_id'] ) && isset( $_REQUEST['current_question_id'] ) ) {
            // phpcs:ignore
            $current_question_id = sanitize_text_field( wp_unslash( $_REQUEST['current_question_id'] ) );
            // phpcs:ignore
        } else {
            $current_question_id = '';
        }
        if ( !empty( $_REQUEST['sortable_id'] ) && isset( $_REQUEST['sortable_id'] ) ) {
            // phpcs:ignore
            $sortable_id = sanitize_text_field( wp_unslash( $_REQUEST['sortable_id'] ) );
            // phpcs:ignore
        } else {
            $sortable_id = '';
        }
        if ( !empty( $_REQUEST['remque'] ) && isset( $_REQUEST['remque'] ) ) {
            // phpcs:ignore
            $remque = sanitize_text_field( wp_unslash( $_REQUEST['remque'] ) );
            // phpcs:ignore
        } else {
            $remque = '';
        }
        $show_attribute_field = $this->wpfp_get_product_per_attribute_based_on_wizard_id( $wizard_id );
        $question_result = $this->wpfp_get_all_question_list( $wizard_id );
        $question_id_array = array();
        if ( !empty( $question_result ) ) {
            foreach ( $question_result as $question_result_data ) {
                $question_id_array[] = $question_result_data->id;
            }
        }
        if ( !empty( $_REQUEST['all_selected_value_id'] ) && isset( $_REQUEST['all_selected_value_id'] ) ) {
            // phpcs:ignore
            $all_selected_value_id = filter_input(
                INPUT_POST,
                'all_selected_value_id',
                FILTER_DEFAULT,
                FILTER_REQUIRE_ARRAY
            );
        } else {
            $all_selected_value_id = '';
        }
        $count_remain_que = ( !empty( $_REQUEST['count_remain_que'] ) && isset( $_REQUEST['count_remain_que'] ) ? sanitize_text_field( $_REQUEST['count_remain_que'] ) : '' );
        // phpcs:ignore
        $remove_current_questoin_id = ( !empty( $_REQUEST['remove_current_questoin_id'] ) && isset( $_REQUEST['remove_current_questoin_id'] ) ? sanitize_text_field( $_REQUEST['remove_current_questoin_id'] ) : '' );
        // phpcs:ignore
        $cur_que_id_on_nxt_btn = ( !empty( $_REQUEST['cur_que_id_on_nxt_btn'] ) && isset( $_REQUEST['cur_que_id_on_nxt_btn'] ) ? sanitize_text_field( $_REQUEST['cur_que_id_on_nxt_btn'] ) : '' );
        // phpcs:ignore
        $next_question_html = $this->wpfp_get_next_button_front_side(
            $wizard_id,
            $current_question_id,
            $all_selected_value_id,
            $sortable_id,
            $count_remain_que,
            $remove_current_questoin_id,
            $cur_que_id_on_nxt_btn,
            $remque
        );
        $previous_question_html = $this->wpfp_get_previous_button_front_side(
            $wizard_id,
            $current_question_id,
            $all_selected_value_id,
            $sortable_id,
            $count_remain_que,
            $remove_current_questoin_id,
            $cur_que_id_on_nxt_btn,
            $remque
        );
        $previous_html = '';
        $previous_html .= $this->wpfp_ajax_get_question_option_list_based_on_next_and_previous(
            $wizard_id,
            $current_question_id,
            $all_selected_value_id,
            $sortable_id,
            $count_remain_que,
            $remove_current_questoin_id,
            $cur_que_id_on_nxt_btn,
            $remque
        );
        $previous_html .= '<div class="wprw-page-nav-buttons">';
        $allowed_html = wp_kses_allowed_html( 'post' );
        $allowed_input_html = array(
            'button' => array(
                'id'               => array(),
                'type'             => array(),
                'name'             => array(),
                'class'            => array(),
                'value'            => array(),
                'data-name'        => array(),
                'data-totque'      => array(),
                'data-prevque'     => array(),
                'data-curque'      => array(),
                'data-remque'      => array(),
                'data-countremque' => array(),
                'data-remque'      => array(),
            ),
        );
        $f_array = array_merge( $allowed_html, $allowed_input_html );
        $previous_html .= wp_kses( $previous_question_html, $f_array );
        $previous_html .= wp_kses( $next_question_html, $f_array );
        $previous_html .= '</div>';
        echo wp_json_encode( array(
            'previous_html'        => $previous_html,
            'question_id_array'    => $question_id_array,
            'show_attribute_field' => $show_attribute_field,
        ) );
        // phpcs:ignore
        wp_die();
    }

    /**
     * Get Product list when select option in front side
     *
     * @since    1.0.0
     *
     * @return   html  Its return html for get product results with multiple parameter ( sequences : string, matched product html,recently matched product html,pagination
     *                 html,array with encoded attribute value for passing jquery,array with encoded attribute value )
     *
     */
    public function wpfp_get_ajax_woocommerce_product_list() {
        ob_start();
        ob_flush();
        global $product, $wpdb;
        $wizard_id = ( isset( $_REQUEST['current_wizard_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['current_wizard_id'] ) ) : '' );
        // phpcs:ignore
        $question_id = ( isset( $_REQUEST['current_question_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['current_question_id'] ) ) : '' );
        // phpcs:ignore
        $option_id = ( isset( $_REQUEST['current_option_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['current_option_id'] ) ) : '' );
        // phpcs:ignore
        $all_selected_value = ( isset( $_REQUEST['all_selected_value'] ) ? sanitize_text_field( stripslashes( $_REQUEST['all_selected_value'] ) ) : '' );
        // phpcs:ignore
        $current_selected_value = ( isset( $_REQUEST['current_selected_value'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['current_selected_value'] ) ) : $all_selected_value );
        // phpcs:ignore
        $options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        // Get wizard details by ID
        $sel_wizard_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id = %d", $wizard_id ) );
        // phpcs:ignore
        $wizard_category_id = ( empty( $sel_wizard_rows->wizard_category ) ? '' : $sel_wizard_rows->wizard_category );
        $wizard_tags_arr = ( empty( $sel_wizard_rows->wizard_tags ) ? '' : explode( ',', $sel_wizard_rows->wizard_tags ) );
        $wizard_price_range = ( empty( $sel_wizard_rows->wizard_price_range ) ? '' : $sel_wizard_rows->wizard_price_range );
        $wizard_price_exlode = explode( '||', $wizard_price_range );
        $wizard_price_min = $wizard_price_exlode[0];
        $wizard_price_max = $wizard_price_exlode[1];
        $wizard_range_status = ( empty( $sel_wizard_rows->range_status ) ? '' : $sel_wizard_rows->range_status );
        if ( isset( $wizard_range_status ) && !empty( $wizard_range_status ) ) {
            if ( isset( $_REQUEST['wpfp_min_price'] ) && '' !== $_REQUEST['wpfp_min_price'] && isset( $_REQUEST['wpfp_max_price'] ) && '' !== $_REQUEST['wpfp_max_price'] ) {
                // phpcs:ignore
                $wpfp_min_price = filter_input( INPUT_POST, 'wpfp_min_price', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                $wpfp_max_price = filter_input( INPUT_POST, 'wpfp_max_price', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                $wpfp_min_price = ( isset( $wpfp_min_price ) ? $wpfp_min_price : '' );
                $wpfp_max_price = ( isset( $wpfp_max_price ) ? $wpfp_max_price : '' );
            } else {
                $wpfp_min_price = $wizard_price_min;
                $wpfp_max_price = $wizard_price_max;
            }
        }
        $wizard_setting = ( empty( $sel_wizard_rows->wizard_setting ) ? '' : json_decode( $sel_wizard_rows->wizard_setting, true ) );
        $perfect_match_title = ( isset( $wizard_setting['perfect_match_title'] ) && !empty( $wizard_setting['perfect_match_title'] ) ? sanitize_text_field( wp_unslash( $wizard_setting['perfect_match_title'] ) ) : 'Top Product( s )' );
        $recent_match_title = ( isset( $wizard_setting['recent_match_title'] ) && !empty( $wizard_setting['recent_match_title'] ) ? sanitize_text_field( wp_unslash( $wizard_setting['recent_match_title'] ) ) : 'Products meeting most of your requirements' );
        $show_attribute_field = $this->wpfp_get_product_per_attribute_based_on_wizard_id( $wizard_id );
        $backend_limit = ( isset( $wizard_setting['backend_limit'] ) && !empty( $wizard_setting['backend_limit'] ) ? sanitize_text_field( wp_unslash( $wizard_setting['backend_limit'] ) ) : '5' );
        $wizard_product_fields = ( isset( $wizard_setting['wizard_product_fields'] ) && !empty( $wizard_setting['wizard_product_fields'] ) ? esc_attr( $wizard_setting['wizard_product_fields'] ) : '' );
        $option_product_list = ( isset( $wizard_setting['option_product_list'] ) && !empty( $wizard_setting['option_product_list'] ) ? esc_attr( $wizard_setting['option_product_list'] ) : 'list' );
        if ( !empty( $wizard_product_fields ) ) {
            $wizard_product_fields_explode = explode( ',', $wizard_product_fields );
        } else {
            $wizard_product_fields_explode = array();
        }
        $detail_title = ( isset( $wizard_setting['detail_title'] ) && !empty( $wizard_setting['detail_title'] ) ? sanitize_text_field( wp_unslash( $wizard_setting['detail_title'] ) ) : '' );
        if ( !empty( $wizard_tags_arr ) && isset( $wizard_tags_arr ) ) {
            $args = array(
                'post_status' => 'publish',
                'tax_query'   => array(
                    // phpcs:ignore
                    array(
                        'taxonomy' => 'product_tag',
                        'field'    => 'term_id',
                        'terms'    => $wizard_tags_arr,
                    ),
                ),
            );
            $query = new WP_Query($args);
            $post_ids_arr = wp_list_pluck( $query->posts, 'ID' );
            $post_ids = implode( ', ', $post_ids_arr );
        }
        $category_wise = "";
        $category_wise .= "SELECT GROUP_CONCAT(DISTINCT {$wpdb->prefix}posts.ID) AS category_wise_product";
        $category_wise .= " FROM {$wpdb->prefix}posts";
        $category_wise .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $category_wise .= " ON ({$wpdb->prefix}posts.ID = m1.post_id)";
        if ( !empty( $wizard_category_id ) ) {
            $category_wise .= " INNER JOIN {$wpdb->prefix}term_relationships";
            $category_wise .= " ON ({$wpdb->prefix}posts.ID = {$wpdb->prefix}term_relationships.object_id)";
        }
        $category_wise .= " WHERE";
        $category_wise .= " {$wpdb->prefix}posts.post_type = 'product'";
        $category_wise .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        if ( !empty( $wizard_category_id ) ) {
            $category_wise .= " AND ({$wpdb->prefix}term_relationships.term_taxonomy_id IN ({$wizard_category_id}))";
        }
        if ( !empty( $wizard_tags_arr ) && isset( $wizard_tags_arr ) ) {
            $category_wise .= " AND ({$wpdb->prefix}posts.ID IN ({$post_ids}))";
        }
        $category_wise_result = $wpdb->get_row( $category_wise );
        // phpcs:ignore
        $category_wise_product = $category_wise_result->category_wise_product;
        // Get matched products of selected criteria
        $check_its_meta_attribute_or_not_arr = $this->wpfp_checkMetaAttributeOrNot(
            $wizard_id,
            $all_selected_value,
            $category_wise_product,
            $wizard_category_id
        );
        if ( !empty( $check_its_meta_attribute_or_not_arr['final_match_product_id'] ) ) {
            $check_its_meta_attribute_or_not = implode( " ,", $check_its_meta_attribute_or_not_arr['final_match_product_id'] );
        } else {
            $check_its_meta_attribute_or_not = '';
        }
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        $sel_qry .= " WHERE wizard_id= %d ";
        if ( !empty( $all_selected_value ) || $all_selected_value !== "" ) {
            $sel_qry .= " AND id IN ( " . stripslashes( $all_selected_value ) . " )";
        }
        $sel_qry .= " ORDER BY id DESC";
        $sel_qry_prepare = $wpdb->prepare( $sel_qry, $wizard_id );
        // phpcs:ignore
        $sel_rows = $wpdb->get_results( $sel_qry_prepare );
        // phpcs:ignore
        $fetch_attribute_value_array = array();
        $fetch_attribute_value_pass_jquery = array();
        $option_attribute_arr = array();
        $fetch_option_attribute_value_arr = array();
        $fetch_attribute_value_pass_jquery_merge = array();
        if ( !empty( $sel_rows ) && is_array( $sel_rows ) ) {
            foreach ( $sel_rows as $sel_data ) {
                $option_attribute = trim( $sel_data->option_attribute );
                $option_attribute_value = str_replace( "’", "", $sel_data->option_attribute_value );
                $fetch_option_attribute_value = trim( str_replace( ", ", ",", $option_attribute_value ) );
                $option_attribute_arr[] = trim( $sel_data->option_attribute );
                $fetch_option_attribute_value_arr[] = trim( str_replace( ", ", ",", $option_attribute_value ) );
                $fetch_option_attribute_value = str_replace( ', ', ",", $option_attribute_value );
                $fetch_attribute_value_array[][trim( $option_attribute )] = trim( str_replace( "’", "", $fetch_option_attribute_value ) );
                if ( !empty( $fetch_attribute_value_pass_jquery ) ) {
                    $fetch_attribute_value_pass_jquery_merge[trim( strtolower( $option_attribute ) )] = trim( strtolower( str_replace( "’", "", $fetch_option_attribute_value ) ) );
                    if ( array_key_exists( trim( strtolower( $option_attribute ) ), $fetch_attribute_value_pass_jquery ) ) {
                        foreach ( $fetch_attribute_value_pass_jquery as $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value ) {
                            $fetch_attribute_value_pass_jquery[trim( strtolower( $option_attribute ) )] = $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value . "," . trim( strtolower( str_replace( ", ", ",", $sel_data->option_attribute_value ) ) );
                        }
                    } else {
                        $fetch_attribute_value_pass_jquery[trim( strtolower( $option_attribute ) )] = trim( strtolower( str_replace( "’", "", $fetch_option_attribute_value ) ) );
                    }
                } else {
                    $fetch_attribute_value_pass_jquery[trim( strtolower( $option_attribute ) )] = trim( strtolower( str_replace( "’", "", $fetch_option_attribute_value ) ) );
                }
            }
        }
        $all_fetch_attribute_value_array = array();
        $all_option_attribute = array();
        $all_fetch_option_attribute_value_arr = array();
        $all_fetch_match_attribute_value_array = array();
        if ( !empty( $sel_rows ) && is_array( $sel_rows ) ) {
            foreach ( $sel_rows as $all_sel_data ) {
                $all_option_single_id = trim( $all_sel_data->id );
                $all_option_single_attribute = trim( $all_sel_data->option_attribute );
                $all_option_single_attribute_value = str_replace( "’", "", $sel_data->option_attribute_value );
                $all_fetch_option_attribute_value = trim( str_replace( ", ", ",", $all_option_single_attribute_value ) );
                $all_fetch_option_attribute_value_arr[][$all_option_single_id] = trim( str_replace( ", ", ",", $all_option_single_attribute_value ) );
                $all_option_attribute[] = trim( $all_sel_data->option_attribute );
                $all_fetch_attribute_value_array[][trim( $all_option_single_attribute )] = trim( $all_fetch_option_attribute_value );
                $all_fetch_match_attribute_value_array[trim( $all_option_single_attribute )] = trim( $all_fetch_option_attribute_value );
            }
        }
        $all_fetch_oopt_att_val_n_arr = array();
        $all_check_oopt_att_val_n_arr = array();
        foreach ( $all_option_attribute as $all_opt_name_key => $all_opt_name_value ) {
            foreach ( $all_fetch_option_attribute_value_arr as $all_key => $all_value ) {
                foreach ( $all_value as $all_value_value ) {
                    if ( $all_opt_name_key === $all_key ) {
                        $all_fetch_oopt_att_val_n_arr[] = $all_opt_name_value . "||" . $all_value_value;
                        $all_check_oopt_att_val_n_arr[] = $all_opt_name_value . "||" . $all_value_value;
                    }
                }
            }
        }
        $get_all_prd_attr = $this->wpfp_get_all_attribute_value( $category_wise_product );
        $get_all_product_id = $this->wpfp_get_all_product_id( $category_wise_product );
        if ( !empty( $get_all_product_id ) ) {
            $get_all_product_id_with_comma = implode( " ,", $get_all_product_id );
        }
        $query_args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'orderby'        => 'post_date',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        );
        $check_combine_products_result = new WP_Query($query_args);
        $check_combine_qry_count = $check_combine_products_result->post_count;
        $custom_product_attributes_name = array();
        $custom_product_attributes = array();
        $custom_product_attributes_arr = array();
        $custom_product_attributes_arr_arr = array();
        $fetch_attribute_value_pass_jquery_test = $fetch_attribute_value_pass_jquery;
        $fetch_attribute_value_pass_jquery_test_result_data = array();
        $arr_fetch_record_custom_array = array();
        $arr_fetch_record_custom_array_for_class = array();
        if ( !empty( $fetch_attribute_value_pass_jquery_test ) && is_array( $fetch_attribute_value_pass_jquery_test ) ) {
            foreach ( $fetch_attribute_value_pass_jquery_test as $fetch_attribute_value_pass_jquery_test_result_key => $fetch_attribute_value_pass_jquery_test_result ) {
                $fetch_attribute_value_pass_jquery_test_resultkey = $fetch_attribute_value_pass_jquery_test_result_key;
                $fetch_attribute_value_pass_jquery_test_result = implode( ',', array_unique( explode( ',', str_replace( "'", "", $fetch_attribute_value_pass_jquery_test_result ) ) ) );
                foreach ( explode( ',', $fetch_attribute_value_pass_jquery_test_result ) as $line ) {
                    // Get all the selected attributes by user
                    $arr_fetch_record_custom_array[][$fetch_attribute_value_pass_jquery_test_resultkey] = trim( $line );
                }
                $arr_fetch_record_custom_array_for_class[][$fetch_attribute_value_pass_jquery_test_resultkey] = $fetch_attribute_value_pass_jquery_test_result;
                $fetch_attribute_value_pass_jquery_test_result_data[$fetch_attribute_value_pass_jquery_test_resultkey] = $fetch_attribute_value_pass_jquery_test_result;
            }
        }
        if ( $check_combine_qry_count > 0 ) {
            if ( $check_combine_products_result->have_posts() ) {
                $array_install_id_to_order_by_product = array();
                $array_install_id_to_order_by_not_match_product = array();
                $store_id = array();
                $arr_fetch_record_custom_array_test = $arr_fetch_record_custom_array;
                $convert_two_dimesioanl_array = new RecursiveIteratorIterator(new RecursiveArrayIterator($arr_fetch_record_custom_array_test));
                $convert_two_dimesioanl_array_into_one = iterator_to_array( $convert_two_dimesioanl_array, false );
                while ( $check_combine_products_result->have_posts() ) {
                    $check_combine_products_result->the_post();
                    $theid = get_the_ID();
                    $match_id_and_counter = 0;
                    $not_match_id_and_counter = 0;
                    if ( !empty( $get_all_prd_attr ) && isset( $get_all_prd_attr ) ) {
                        foreach ( $get_all_prd_attr as $all_key => $all_value ) {
                            if ( $all_key === $theid ) {
                                foreach ( $all_value as $key => $value ) {
                                    if ( strpos( $value, '|' ) !== false ) {
                                        $attribute_value_ex = explode( '|', trim( $value ) );
                                    } else {
                                        $attribute_value_ex = array($value);
                                    }
                                    foreach ( $attribute_value_ex as $att_value ) {
                                        if ( !empty( $att_value ) && isset( $att_value ) ) {
                                            $get_option_id = $this->wpfp_get_option_id_based_on_option_value( trim( $att_value ), trim( $key ), $wizard_id );
                                            if ( !empty( $get_option_id ) ) {
                                                if ( strpos( $get_option_id, ',' ) !== false ) {
                                                    $att_option_id = str_replace( ',', '_', $get_option_id );
                                                } else {
                                                    $att_option_id = $get_option_id;
                                                }
                                            } else {
                                                $att_option_id = '';
                                            }
                                            if ( !empty( $arr_fetch_record_custom_array ) ) {
                                                foreach ( $arr_fetch_record_custom_array as $arr_fetch_record_custom_array_result ) {
                                                    foreach ( $arr_fetch_record_custom_array_result as $arr_fetch_record_custom_array_key => $arr_fetch_record_custom_array_for_match_product_id ) {
                                                        if ( !empty( $arr_fetch_record_custom_array_key ) && strtolower( $key ) === $arr_fetch_record_custom_array_key && in_array( trim( strtolower( $att_value ) ), $arr_fetch_record_custom_array_result, true ) ) {
                                                            $match_id_and_counter++;
                                                            $array_install_id_to_order_by_product[$theid] = $match_id_and_counter;
                                                        } else {
                                                            if ( !empty( $arr_fetch_record_custom_array_key ) && strtolower( $key ) === $arr_fetch_record_custom_array_key && !in_array( trim( strtolower( $att_value ) ), $convert_two_dimesioanl_array_into_one, true ) && !in_array( $theid . "," . $att_option_id, $store_id, true ) ) {
                                                                $not_match_id_and_counter++;
                                                                $store_id[] = $theid . "," . $att_option_id;
                                                                $array_install_id_to_order_by_not_match_product[$theid] = $not_match_id_and_counter;
                                                            } else {
                                                                if ( !empty( $arr_fetch_record_custom_array_key ) && strtolower( $key ) === $arr_fetch_record_custom_array_key && !in_array( trim( strtolower( $att_value ) ), $convert_two_dimesioanl_array_into_one, true ) && !in_array( $theid . "," . $att_option_id, $store_id, true ) ) {
                                                                    $not_match_id_and_counter++;
                                                                    $store_id[] = $theid . "," . $att_option_id;
                                                                    $array_install_id_to_order_by_not_match_product[$theid] = $not_match_id_and_counter;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        $order_result_by_id = '';
        if ( !empty( $array_install_id_to_order_by_product ) || !empty( $array_install_id_to_order_by_not_match_product ) ) {
            $result_order_by_id = $array_install_id_to_order_by_product;
            arsort( $result_order_by_id );
            $array = $result_order_by_id;
            $counts = array_count_values( $array );
            $filtered = array_filter( $array, function ( $value ) use($counts) {
                return $counts[$value] > 1;
            } );
            $test = array();
            foreach ( $filtered as $filtered_key => $filtered_val ) {
                $test[$filtered_key] = $filtered_key;
            }
            $global_not_match_array = array();
            foreach ( $test as $test_val ) {
                if ( array_key_exists( $test_val, $array_install_id_to_order_by_not_match_product ) ) {
                    $global_not_match_array[$test_val] = $array_install_id_to_order_by_not_match_product[$test_val];
                }
            }
            asort( $global_not_match_array );
            arsort( $array_install_id_to_order_by_product );
            $array_common_key = array_intersect_key( $array_install_id_to_order_by_product, $array_install_id_to_order_by_not_match_product );
            $com_match_comm_key = $array_install_id_to_order_by_product + $array_common_key;
            $diff_from_match_and_not_match = array_diff_key( $array_install_id_to_order_by_not_match_product, $array_install_id_to_order_by_product );
            $all_combine = $com_match_comm_key + $diff_from_match_and_not_match;
            $all_id_result = array_diff_key( $get_all_product_id, $all_combine );
            $final_result = $all_combine + $all_id_result;
            $order_result_test = implode( ", ", array_keys( $final_result ) );
            $order_result_by_id = '';
            if ( !empty( $result_order_by_id ) ) {
                $order_result_by_id = implode( ", ", array_keys( $result_order_by_id ) );
            }
        }
        update_option( 'woocommerce_recommoded_product_record', $order_result_by_id );
        $total_count_qry = "";
        $total_count_qry .= "SELECT count( post_table.ID ) AS total_id";
        $total_count_qry .= " FROM ( SELECT {$wpdb->prefix}posts.ID";
        $total_count_qry .= " FROM {$wpdb->prefix}posts";
        $total_count_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $total_count_qry .= " ON ( {$wpdb->prefix}posts.ID = m1.post_id )";
        $total_count_qry .= " WHERE";
        $total_count_qry .= " {$wpdb->prefix}posts.post_type = 'product'";
        $total_count_qry .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        if ( isset( $wizard_range_status ) && !empty( $wizard_range_status ) ) {
            $total_count_qry .= " AND        m1.meta_key ='_price'";
            $total_count_qry .= " AND        m1.meta_value >= {$wpfp_min_price}";
            $total_count_qry .= " AND        m1.meta_value <= {$wpfp_max_price}";
        }
        if ( !empty( $wizard_category_id ) && isset( $wizard_category_id ) ) {
            $total_count_qry .= " AND {$wpdb->prefix}posts.ID IN ( " . stripslashes( $category_wise_product ) . " )";
        }
        if ( !empty( $check_its_meta_attribute_or_not ) ) {
            $total_count_qry .= " AND ( {$wpdb->prefix}posts.ID IN ( {$check_its_meta_attribute_or_not} ) )";
        } else {
            $total_count_qry .= " AND ( {$wpdb->prefix}posts.ID NOT IN ( " . $get_all_product_id_with_comma . " ) )";
        }
        $total_count_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $total_count_qry .= " union all";
        $total_count_qry .= " SELECT {$wpdb->prefix}posts.ID";
        $total_count_qry .= " FROM {$wpdb->prefix}posts";
        $total_count_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $total_count_qry .= " ON ( {$wpdb->prefix}posts.ID = m1.post_id )";
        $total_count_qry .= " WHERE";
        $total_count_qry .= " {$wpdb->prefix}posts.post_type = 'product'";
        $total_count_qry .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        if ( isset( $wizard_range_status ) && !empty( $wizard_range_status ) ) {
            $total_count_qry .= " AND        m1.meta_key ='_price'";
            $total_count_qry .= " AND        m1.meta_value >= {$wpfp_min_price}";
            $total_count_qry .= " AND        m1.meta_value <= {$wpfp_max_price}";
        }
        if ( !empty( $wizard_category_id ) && isset( $wizard_category_id ) ) {
            $total_count_qry .= " AND {$wpdb->prefix}posts.ID IN ( " . stripslashes( $category_wise_product ) . " )";
        }
        if ( !empty( $check_its_meta_attribute_or_not ) ) {
            $total_count_qry .= " AND ( {$wpdb->prefix}posts.ID NOT IN ( {$check_its_meta_attribute_or_not} ) )";
        } else {
            $total_count_qry .= " AND ( {$wpdb->prefix}posts.ID IN ( " . $get_all_product_id_with_comma . " ) )";
        }
        $total_count_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $total_count_qry .= "  )";
        $total_count_qry .= " as post_table";
        $page_result = $wpdb->get_row( $total_count_qry );
        // phpcs:ignore
        $total_records = $page_result->total_id;
        $page = ( isset( $_REQUEST['pagenum'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['pagenum'] ) ) : '1' );
        // phpcs:ignore
        $limit = ( isset( $_REQUEST['limit'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['limit'] ) ) : $backend_limit );
        // phpcs:ignore
        $last = ceil( $total_records / $limit );
        if ( $page < 1 ) {
            $page = 1;
        } elseif ( $page > $last ) {
            $page = $last;
        }
        if ( $page > 1 ) {
            $lower_limit = ($page - 1) * $limit;
        } else {
            $lower_limit = '0';
        }
        $perfect_page_qry = "";
        $perfect_page_qry .= " SELECT  pq.ID AS common_id,pq.ID AS perfect_id,0 as recently_id";
        $perfect_page_qry .= " FROM {$wpdb->prefix}posts AS pq";
        $perfect_page_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $perfect_page_qry .= " ON ( pq.ID = m1.post_id )";
        $perfect_page_qry .= " WHERE";
        $perfect_page_qry .= " pq.post_type= 'product'";
        $perfect_page_qry .= " AND pq.post_status= 'publish'";
        if ( isset( $wizard_range_status ) && !empty( $wizard_range_status ) ) {
            $perfect_page_qry .= " AND        m1.meta_key ='_price'";
            $perfect_page_qry .= " AND        m1.meta_value >= {$wpfp_min_price}";
            $perfect_page_qry .= " AND        m1.meta_value <= {$wpfp_max_price}";
        }
        if ( !empty( $wizard_category_id ) && isset( $wizard_category_id ) ) {
            $perfect_page_qry .= " AND pq.ID IN ( " . stripslashes( $category_wise_product ) . " )";
        }
        if ( !empty( $check_its_meta_attribute_or_not ) ) {
            $perfect_page_qry .= " AND ( pq.ID IN ( {$check_its_meta_attribute_or_not} ) )";
        } else {
            $perfect_page_qry .= " AND ( pq.ID NOT IN ( " . $get_all_product_id_with_comma . " ) )";
        }
        $perfect_page_qry .= " GROUP by common_id";
        $recently_page_qry = "";
        $recently_page_qry .= " SELECT rq.ID AS common_id,0 as perfect_id, rq.ID AS recently_id";
        $recently_page_qry .= " FROM {$wpdb->prefix}posts AS rq";
        $recently_page_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $recently_page_qry .= " ON ( rq.ID = m1.post_id )";
        $recently_page_qry .= " WHERE";
        $recently_page_qry .= " rq.post_type = 'product' ";
        $recently_page_qry .= " AND rq.post_status = 'publish'";
        if ( isset( $wizard_range_status ) && !empty( $wizard_range_status ) ) {
            $recently_page_qry .= " AND        m1.meta_key ='_price'";
            $recently_page_qry .= " AND        m1.meta_value >= {$wpfp_min_price}";
            $recently_page_qry .= " AND        m1.meta_value <= {$wpfp_max_price}";
        }
        if ( !empty( $wizard_category_id ) && isset( $wizard_category_id ) ) {
            $recently_page_qry .= " AND rq.ID IN ( " . stripslashes( $category_wise_product ) . " )";
        }
        if ( !empty( $check_its_meta_attribute_or_not ) ) {
            $recently_page_qry .= " AND ( rq.ID NOT IN ( {$check_its_meta_attribute_or_not} ) )";
        } else {
            $recently_page_qry .= " AND ( rq.ID IN ( " . $get_all_product_id_with_comma . " ) )";
        }
        $recently_page_qry .= " GROUP by common_id";
        $combine_qry = "";
        $combine_qry .= " ( ";
        $combine_qry .= $perfect_page_qry;
        $combine_qry .= "  )";
        $combine_qry .= " union all";
        $combine_qry .= " ( ";
        $combine_qry .= $recently_page_qry;
        $combine_qry .= "  )";
        if ( !empty( $result_order_by_id ) && !empty( $order_result_test ) ) {
            $combine_qry .= " ORDER BY FIELD( common_id ,{$order_result_test} )";
        }
        $combine_qry .= " LIMIT %d, %d";
        $combine_qry_prepare = $wpdb->prepare( $combine_qry, $lower_limit, $limit );
        // phpcs:ignore
        $combine_products_result = $wpdb->get_results( $combine_qry_prepare );
        // phpcs:ignore
        if ( !empty( $combine_products_result ) && isset( $combine_products_result ) && $combine_products_result !== 'false' ) {
            $product_html = '';
            $store_product_html = '';
            $product_title_class = 'style="display:none;';
            $recently_title_class = 'style="display:none;';
            foreach ( $combine_products_result as $prd_data ) {
                $perfect_id = $prd_data->perfect_id;
                $recently_id = $prd_data->recently_id;
                if ( !empty( $perfect_id ) && isset( $perfect_id ) && $perfect_id !== '0' ) {
                    $product_title_class = 'style="display:block"';
                } else {
                    if ( !empty( $perfect_id ) && !empty( $recently_id ) ) {
                        $product_title_class = 'style="display:block;"';
                        $recently_title_class = 'style="display:block;"';
                    } else {
                        if ( !empty( $recently_id ) && isset( $recently_id ) && $recently_id !== '0' ) {
                            $recently_title_class = 'style="display:block;"';
                        } else {
                            $recently_title_class = 'style="display:none;"';
                            $product_title_class = 'style="display:none;"';
                        }
                    }
                }
            }
            $product_html .= '<div class="wprw-product-headline" id="perfect_fit_product_id" ' . wp_kses_post( $product_title_class ) . '>' . wp_kses_post( $perfect_match_title ) . '</div>';
            $store_product_html .= '<div class="wprw-product-headline" id="recently_fit_product_id" ' . wp_kses_post( $recently_title_class ) . '>' . wp_kses_post( $recent_match_title ) . '</div>';
            $i = 0;
            foreach ( $combine_products_result as $prd_data ) {
                $i++;
                $perfect_id = $prd_data->perfect_id;
                if ( !empty( $perfect_id ) && isset( $perfect_id ) && $perfect_id !== '0' ) {
                    $product = new WC_Product($perfect_id);
                    $variation_data = $product->get_attributes();
                    if ( !empty( $variation_data ) && isset( $variation_data ) ) {
                        foreach ( $variation_data as $attribute ) {
                            $custom_product_attributes_name[] = explode( '|', $attribute['name'] );
                            $custom_product_attributes[] = explode( '|', $attribute['value'] );
                            $custom_product_attributes_arr[][$perfect_id] = $attribute['name'] . "||" . $attribute['value'];
                            $custom_product_attributes_arr_arr[$attribute['name']] = $attribute['value'];
                        }
                    }
                    $view = ( 'grid' === $option_product_list ? 'prd_section_grid' : 'prd_section_list' );
                    $product_html .= '<div class="prd_section ' . esc_attr( $view ) . '" id="prd_' . esc_attr( $perfect_id ) . '">';
                    $product_html .= '<div class="prd_detail">';
                    $product_html .= '<div class="prd_top_detail">';
                    // Check if user has selected title field in option
                    if ( in_array( 'title', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        $product_html .= '<div class="prd_title left_title">';
                        $product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $perfect_id ) ) . '">' . wp_kses_post( get_the_title( $perfect_id ) ) . '</a>';
                        $product_html .= '</div>';
                    }
                    $product_html .= '<div class="prd_compare right_compare">';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '<div class="prd_middle_detail">';
                    // Check if user has selected thumbnail field in wizard option
                    if ( in_array( 'thumbnail', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        $product_html .= '<div class="prd_image left_image">';
                        if ( has_filter( 'wpf_wizard_image_size' ) ) {
                            $img_size = apply_filters( 'wpf_wizard_image_size', $img_size );
                            $img_width = ( isset( $img_size['width'] ) && !empty( $img_size['width'] ) ? $img_size['width'] : '' );
                            $img_height = ( isset( $img_size['height'] ) && !empty( $img_size['height'] ) ? $img_size['height'] : '' );
                            if ( has_post_thumbnail( $recently_id ) ) {
                                $product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $perfect_id ) ) . '">' . wp_kses_post( get_the_post_thumbnail( $perfect_id, array($img_width, $img_height) ) ) . '</a>';
                            } else {
                                $product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $perfect_id ) ) . '"><img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="Awaiting product image" class="wp-post-image" /></a>';
                            }
                        } else {
                            if ( has_post_thumbnail( $perfect_id ) ) {
                                $product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $perfect_id ) ) . '">' . wp_kses_post( get_the_post_thumbnail( $perfect_id, array(250, 250) ) ) . '</a>';
                            } else {
                                $product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $perfect_id ) ) . '"><img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="Awaiting product image" class="wp-post-image" /></a>';
                            }
                        }
                        $product_html .= '</div>';
                    }
                    $product_html .= '<div class="middle_wrapper">';
                    $product_html .= '<div class="main_prd_attribute middle_attribute">';
                    // Check if user has selected attributes field in option
                    if ( in_array( 'attributes', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        $product_html .= '<div class="prd_attribute_list">';
                        $product_html .= '<div class="prd-overlay-attributes">';
                        if ( !empty( $get_all_prd_attr ) && isset( $get_all_prd_attr ) ) {
                            foreach ( $get_all_prd_attr as $all_key => $all_value ) {
                                if ( $all_key === (int) $perfect_id ) {
                                    foreach ( $all_value as $key => $value ) {
                                        if ( strpos( $value, '|' ) !== false ) {
                                            $attribute_value_ex = explode( '|', trim( strtolower( str_replace( ' ', '', $value ) ) ) );
                                        } else {
                                            $attribute_value_ex = array(trim( strtolower( str_replace( ' ', '', $value ) ) ));
                                        }
                                        $class = '';
                                        if ( !empty( $arr_fetch_record_custom_array_for_class ) ) {
                                            foreach ( $arr_fetch_record_custom_array_for_class as $arr_fetch_record_custom_array_result ) {
                                                foreach ( $arr_fetch_record_custom_array_result as $arr_fetch_record_custom_array_key => $arr_fetch_record_custom_array_for_match_product_id ) {
                                                    if ( strpos( $arr_fetch_record_custom_array_for_match_product_id, ',' ) !== false ) {
                                                        $arr_fetch_record_custom_array_for_match_product_id_ex = explode( ',', trim( strtolower( str_replace( ' ', '', $arr_fetch_record_custom_array_for_match_product_id ) ) ) );
                                                    } else {
                                                        $arr_fetch_record_custom_array_for_match_product_id_ex = array(trim( strtolower( str_replace( ' ', '', $arr_fetch_record_custom_array_for_match_product_id ) ) ));
                                                    }
                                                    if ( !empty( $arr_fetch_record_custom_array_key ) && strtolower( $key ) === $arr_fetch_record_custom_array_key && array_intersect( $arr_fetch_record_custom_array_for_match_product_id_ex, $attribute_value_ex ) ) {
                                                        $class = 'prd-positive-attr';
                                                    } else {
                                                        if ( !empty( $arr_fetch_record_custom_array_key ) && strtolower( $key ) === $arr_fetch_record_custom_array_key && !array_intersect( $arr_fetch_record_custom_array_for_match_product_id_ex, $attribute_value_ex ) ) {
                                                            $class = 'prd-negative-attr';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $product_html .= '<div class="prd-attribute ' . esc_attr( $class ) . '"><span id="' . esc_attr( trim( strtolower( $key ) ) ) . '" class="prd_attribute_name">' . esc_html( $key ) . ' : </span><span id="' . esc_attr( trim( strtolower( $value ) ) ) . '" class="prd_attribute_value"> ' . esc_html( $value ) . '</span></div>';
                                    }
                                }
                            }
                        }
                        $product_html .= '</div>';
                        $product_html .= '<div class="prd_view_more_attribute">';
                        $product_html .= '<a class="view_more_btn" href="javascript:void(0);" id="view_more_btn_' . esc_attr( $perfect_id ) . '" style="display:none;" data-prddefault=' . esc_attr( $show_attribute_field ) . '>' . esc_html__( 'View More', 'woo-product-finder' ) . '</a>';
                        $product_html .= '</div>';
                        $product_html .= '<div class="prd_show_less_attribute">';
                        $product_html .= '<a class="show_less_btn" href="javascript:void(0);" id="show_less_btn_' . esc_attr( $perfect_id ) . '" style="display:none;" data-prddefault=' . esc_attr( $show_attribute_field ) . '>' . esc_html__( 'Show Less', 'woo-product-finder' ) . '</a>';
                        $product_html .= '</div>';
                        $product_html .= '</div>';
                    }
                    $product_html .= '</div>';
                    if ( in_array( 'description', $wizard_product_fields_explode, true ) ) {
                        // Check if product has excerpt exist
                        if ( $product->post->post_excerpt ) {
                            $pro_description = wp_strip_all_tags( wp_trim_words( $product->post->post_excerpt, 12 ) );
                        } else {
                            $pro_description = wp_strip_all_tags( wp_trim_words( $product->post->post_content, 12 ) );
                        }
                        $product_html .= '<div class="product-description">';
                        $product_html .= $pro_description;
                        $product_html .= '</div>';
                    }
                    $product_html .= '</div>';
                    $product_html .= '<div class="prd_price right_bottom_price 111">';
                    if ( in_array( 'add-to-cart', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        if ( !has_term( 'variable', 'product_type', $perfect_id ) ) {
                            $add_to_cart_url = esc_url( home_url( '/cart/?add-to-cart=' . $perfect_id ) );
                            $button_label = 'Add to cart';
                            $pprice = $product->get_price_html();
                        } else {
                            $product__ = wc_get_product( $perfect_id );
                            $add_to_cart_url = esc_url( get_the_permalink( $perfect_id ) );
                            $button_label = 'See Options';
                            $currency = get_woocommerce_currency_symbol();
                            $sale_price = $product__->get_variation_price( 'min', true );
                            $regular_price = $product__->get_variation_price( 'max', true );
                            if ( !empty( $sale_price ) && !empty( $regular_price ) ) {
                                $pprice = $currency . $sale_price . ' - ' . $currency . $regular_price;
                            } else {
                                $pprice = $currency . $sale_price;
                            }
                        }
                        $product_html .= '<div class="product-addtocart">';
                        $product_html .= '<a class="product-addtocart-btn" href="' . $add_to_cart_url . '">' . $button_label . '</a>';
                        $product_html .= '</div>';
                    }
                    $product_html .= '<div class="product-details">';
                    $product_html .= '<div class="wprw-product-price">';
                    $product_html .= '<span class="prd_sale_price">';
                    $product_html .= wp_kses_post( $pprice );
                    $product_html .= '</span>';
                    $product_html .= '</div>';
                    $product_html .= '<a class="wprw-button wprw-detail-button wprw-product-detail-link" href="' . esc_url( get_the_permalink( $perfect_id ) ) . '" target="_blank">';
                    $product_html .= '<span class="prd_detail_name">' . esc_html__( $detail_title, 'woo-product-finder' ) . '</span>';
                    $product_html .= '</a>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                    $product_html .= '</div>';
                }
                $recently_id = trim( $prd_data->recently_id );
                if ( !empty( $recently_id ) && isset( $recently_id ) && $recently_id !== '0' ) {
                    $product = new WC_Product($recently_id);
                    $variation_data = $product->get_attributes();
                    foreach ( $variation_data as $attribute ) {
                        $custom_product_attributes_name[] = explode( '|', $attribute['name'] );
                        $custom_product_attributes[] = explode( '|', $attribute['value'] );
                        $custom_product_attributes_arr[][$recently_id] = $attribute['name'] . "||" . $attribute['value'];
                        $custom_product_attributes_arr_arr[$recently_id][$attribute['name']] = $attribute['value'];
                    }
                    $view = ( 'grid' === $option_product_list ? 'prd_section_grid' : 'prd_section_list' );
                    $store_product_html .= '<div class="prd_section ' . esc_attr( $view ) . '" id="prd_' . esc_attr( $recently_id ) . '">';
                    $store_product_html .= '<div class="prd_detail">';
                    $store_product_html .= '<div class="prd_top_detail">';
                    // Check if user has selected title field in option
                    if ( in_array( 'title', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        $store_product_html .= '<div class="prd_title left_title">';
                        $store_product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $recently_id ) ) . '">' . wp_kses_post( get_the_title( $recently_id ) ) . '</a>';
                        $store_product_html .= '</div>';
                    }
                    $store_product_html .= '<div class="prd_compare right_compare">';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '<div class="prd_middle_detail">';
                    // Check if user has selected thumbnail field in wizard option
                    if ( in_array( 'thumbnail', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        $store_product_html .= '<div class="prd_image left_image">';
                        if ( has_filter( 'wpf_wizard_image_size' ) ) {
                            $img_size = apply_filters( 'wpf_wizard_image_size', $img_size );
                            $img_width = ( isset( $img_size['width'] ) && !empty( $img_size['width'] ) ? $img_size['width'] : '' );
                            $img_height = ( isset( $img_size['height'] ) && !empty( $img_size['height'] ) ? $img_size['height'] : '' );
                            if ( has_post_thumbnail( $recently_id ) ) {
                                $store_product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $recently_id ) ) . '">' . wp_kses_post( get_the_post_thumbnail( $recently_id, array($img_width, $img_height) ) ) . '</a>';
                            } else {
                                $store_product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $recently_id ) ) . '"><img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="Awaiting product image" class="wp-post-image" /></a>';
                            }
                        } else {
                            if ( has_post_thumbnail( $recently_id ) ) {
                                $store_product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $recently_id ) ) . '">' . wp_kses_post( get_the_post_thumbnail( $recently_id, array(250, 250) ) ) . '</a>';
                            } else {
                                $store_product_html .= '<a class="woo-product-detail-link" href="' . esc_url( get_the_permalink( $recently_id ) ) . '"><img src="' . esc_url( wc_placeholder_img_src() ) . '" alt="Awaiting product image" class="wp-post-image" /></a>';
                            }
                        }
                        $store_product_html .= '</div>';
                    }
                    $store_product_html .= '<div class="middle_wrapper">';
                    $store_product_html .= '<div class="main_prd_attribute middle_attribute">';
                    // Check if user has selected attributes field in option
                    if ( in_array( 'attributes', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        $store_product_html .= '<div class="prd_attribute_list">';
                        $store_product_html .= '<div class="prd-overlay-attributes">';
                        if ( !empty( $get_all_prd_attr ) && isset( $get_all_prd_attr ) ) {
                            foreach ( $get_all_prd_attr as $all_key => $all_value ) {
                                if ( $all_key === (int) $recently_id ) {
                                    foreach ( $all_value as $key => $value ) {
                                        if ( strpos( $value, '|' ) !== false ) {
                                            $attribute_value_ex = explode( '|', trim( strtolower( str_replace( ' ', '', $value ) ) ) );
                                        } else {
                                            $attribute_value_ex = array(trim( strtolower( str_replace( ' ', '', $value ) ) ));
                                        }
                                        $class = '';
                                        if ( !empty( $arr_fetch_record_custom_array_for_class ) ) {
                                            foreach ( $arr_fetch_record_custom_array_for_class as $arr_fetch_record_custom_array_result ) {
                                                foreach ( $arr_fetch_record_custom_array_result as $arr_fetch_record_custom_array_key => $arr_fetch_record_custom_array_for_match_product_id ) {
                                                    if ( strpos( $arr_fetch_record_custom_array_for_match_product_id, ',' ) !== false ) {
                                                        $arr_fetch_record_custom_array_for_match_product_id_ex = explode( ',', trim( strtolower( str_replace( ' ', '', $arr_fetch_record_custom_array_for_match_product_id ) ) ) );
                                                    } else {
                                                        $arr_fetch_record_custom_array_for_match_product_id_ex = array(trim( strtolower( str_replace( ' ', '', $arr_fetch_record_custom_array_for_match_product_id ) ) ));
                                                    }
                                                    if ( !empty( $arr_fetch_record_custom_array_key ) && strtolower( $key ) === $arr_fetch_record_custom_array_key && array_intersect( $arr_fetch_record_custom_array_for_match_product_id_ex, $attribute_value_ex ) ) {
                                                        $class = 'prd-positive-attr';
                                                    } else {
                                                        if ( !empty( $arr_fetch_record_custom_array_key ) && strtolower( $key ) === $arr_fetch_record_custom_array_key && !array_intersect( $arr_fetch_record_custom_array_for_match_product_id_ex, $attribute_value_ex ) ) {
                                                            $class = 'prd-negative-attr';
                                                        }
                                                    }
                                                }
                                            }
                                        }
                                        $store_product_html .= '<div class="prd-attribute ' . esc_attr( $class ) . '"><span id="' . esc_attr( trim( strtolower( $key ) ) ) . '" class="prd_attribute_name">' . esc_html( $key ) . ' : </span><span id="' . esc_attr( trim( strtolower( $value ) ) ) . '" class="prd_attribute_value"> ' . esc_html( $value ) . '</span></div>';
                                    }
                                }
                            }
                        }
                        $store_product_html .= '</div>';
                        $store_product_html .= '<div class="prd-view_more_attribute">';
                        $store_product_html .= '<a class="view_more_btn" href="javascript:void(0);" id="view_more_btn_' . esc_attr( $recently_id ) . '" style="display:none;" data-prddefault=' . esc_attr( $show_attribute_field ) . '>' . esc_html__( 'View More', 'woo-product-finder' ) . '</a>';
                        $store_product_html .= '</div>';
                        $store_product_html .= '<div class="prd_show_less_attribute">';
                        $store_product_html .= '<a class="show_less_btn" href="javascript:void(0);" id="show_less_btn_' . esc_attr( $recently_id ) . '" style="display:none;" data-prddefault=' . esc_attr( $show_attribute_field ) . '>' . esc_html__( 'Show Less', 'woo-product-finder' ) . '</a>';
                        $store_product_html .= '</div>';
                        $store_product_html .= '</div>';
                    }
                    // Check if description is selected on fields option
                    if ( in_array( 'description', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        // Check if product has excerpt exist
                        if ( $product->post->post_excerpt ) {
                            $pro_description = wp_strip_all_tags( wp_trim_words( $product->post->post_excerpt, 9 ) );
                        } else {
                            $pro_description = wp_strip_all_tags( wp_trim_words( $product->post->post_content, 9 ) );
                        }
                        $store_product_html .= '<div class="product-description">';
                        $store_product_html .= $pro_description;
                        $store_product_html .= '</div>';
                    }
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '<div class="prd_price right_bottom_price 222">';
                    // Check if add to cart field is selected on fields option
                    if ( in_array( 'add-to-cart', $wizard_product_fields_explode, true ) || empty( $wizard_product_fields_explode ) ) {
                        if ( $product->is_type( 'simple' ) ) {
                            $add_to_cart_url = esc_url( home_url( '/cart/?add-to-cart=' . $recently_id ) );
                            $button_label = 'Add to cart';
                        } else {
                            $add_to_cart_url = esc_url( get_the_permalink( $recently_id ) );
                            $button_label = 'See Options';
                        }
                        $store_product_html .= '<div class="product-addtocart">';
                        $store_product_html .= '<a class="product-addtocart-btn" href="' . $add_to_cart_url . '">' . $button_label . '</a>';
                        $store_product_html .= '</div>';
                    }
                    $store_product_html .= '<div class="product-details">';
                    $store_product_html .= '<div class="wprw-product-price">';
                    $store_product_html .= '<span class="prd_sale_price">';
                    $store_product_html .= wp_kses_post( $product->get_price_html() );
                    $store_product_html .= '</span>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '<a class="wprw-button wprw-detail-button wprw-product-detail-link" href="' . esc_url( get_the_permalink( $recently_id ) ) . '" target="_blank">';
                    $store_product_html .= '<span class="prd_detail_name">' . esc_html__( $detail_title, 'woo-product-finder' ) . '</span>';
                    $store_product_html .= '</a>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                    $store_product_html .= '</div>';
                } else {
                    $store_product_html .= '';
                }
            }
        }
        $noRecord = '<p class="wpf-no-match">No Matched product found try with another value.</p>';
        $pagination_html = $this->wpfp_front_ajax_pagination(
            $wizard_id,
            $question_id,
            $option_id,
            $current_selected_value,
            $limit,
            $page,
            $last,
            $total_records
        );
        echo wp_json_encode( array(
            'product_html'         => $product_html,
            'store_product_html'   => $store_product_html,
            'pagination_html'      => $pagination_html,
            'show_attribute_field' => $show_attribute_field,
            'no_records'           => $noRecord,
        ) );
        // phpcs:ignore
        ob_end_flush();
        wp_die();
    }

    /**
     * Check attribute is custom attribute or attribute term
     *
     * @since    1.0.0
     *
     * @param      int    $wizard_id             Wizard ID.
     *
     * @param      string $attribute_value       Attribute Value.
     *
     * @param      array  $category_wise_product Category ID.
     *
     * @param      array  $wizard_category_id    Attribute ID.
     *
     * @return array Its return unique product id which is match multiple attribute value
     *
     */
    public function wpfp_checkMetaAttributeOrNot(
        $wizard_id,
        $attribute_value,
        $category_wise_product,
        $wizard_category_id
    ) {
        global $wpdb;
        $options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        $sel_qry = "";
        $sel_qry .= "SELECT *";
        $sel_qry .= " FROM " . $options_table_name;
        $sel_qry .= " WHERE wizard_id=%d";
        if ( !empty( $attribute_value ) || $attribute_value !== "" ) {
            $sel_qry .= " AND id IN ( " . stripslashes( $attribute_value ) . " )";
        }
        $sel_qry .= " ORDER BY id DESC";
        $sel_rows = $wpdb->get_results( $wpdb->prepare( $sel_qry, $wizard_id ) );
        // phpcs:ignore
        $fetch_attribute_value_array = array();
        $fetch_attribute_value_pass_jquery = array();
        $option_attribute_arr = array();
        $fetch_option_attribute_value_arr = array();
        $fetch_attribute_value_pass_jquery_merge = array();
        $prd_meta_id = array();
        if ( !empty( $sel_rows ) && is_array( $sel_rows ) ) {
            foreach ( $sel_rows as $sel_data ) {
                $option_attribute = trim( $sel_data->option_attribute );
                $fetch_option_attribute_value = trim( str_replace( ", ", ",", stripslashes( $sel_data->option_attribute_value ) ) );
                $option_attribute_arr[] = trim( $sel_data->option_attribute );
                $fetch_option_attribute_value_arr[] = trim( str_replace( ", ", ",", stripslashes( $sel_data->option_attribute_value ) ) );
                $fetch_option_attribute_value = str_replace( ', ', ",", $fetch_option_attribute_value );
                $fetch_attribute_value_array[][trim( $option_attribute )] = trim( $fetch_option_attribute_value );
                if ( !empty( $fetch_attribute_value_pass_jquery ) ) {
                    $fetch_attribute_value_pass_jquery_merge[trim( strtolower( $option_attribute ) )] = trim( stripslashes( $fetch_option_attribute_value ) );
                    if ( array_key_exists( trim( strtolower( $option_attribute ) ), $fetch_attribute_value_pass_jquery ) ) {
                        foreach ( $fetch_attribute_value_pass_jquery as $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value ) {
                            $fetch_attribute_value_pass_jquery[trim( strtolower( $option_attribute ) )] = $fetch_attribute_value_pass_multiple_jquery_checkbox_only_value . "," . trim( str_replace( ", ", ",", stripslashes( $sel_data->option_attribute_value ) ) );
                        }
                    } else {
                        $fetch_attribute_value_pass_jquery[trim( strtolower( $option_attribute ) )] = trim( stripslashes( $fetch_option_attribute_value ) );
                    }
                } else {
                    $fetch_attribute_value_pass_jquery[trim( strtolower( $option_attribute ) )] = trim( stripslashes( $fetch_option_attribute_value ) );
                }
            }
        }
        $prd_chk_meta_qry = "";
        $prd_chk_meta_qry .= "SELECT {$wpdb->prefix}posts.post_title,{$wpdb->prefix}posts.ID";
        $prd_chk_meta_qry .= " FROM {$wpdb->prefix}posts";
        $prd_chk_meta_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $prd_chk_meta_qry .= " ON ( {$wpdb->prefix}posts.ID = m1.post_id )";
        $prd_chk_meta_qry .= " WHERE";
        $prd_chk_meta_qry .= " {$wpdb->prefix}posts.post_type = 'product'";
        $prd_chk_meta_qry .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        if ( !empty( $wizard_category_id ) && isset( $wizard_category_id ) ) {
            $prd_chk_meta_qry .= " AND {$wpdb->prefix}posts.ID IN ( " . stripslashes( $category_wise_product ) . " )";
        }
        $prd_chk_meta_qry .= " AND ( m1.meta_key = '_product_attributes' )";
        if ( !empty( $fetch_attribute_value_pass_jquery ) && is_array( $fetch_attribute_value_pass_jquery ) ) {
            foreach ( $fetch_attribute_value_pass_jquery as $all_fetch_key => $all_fetch_value ) {
                $serialized_attribute_name = serialize( 'name' ) . serialize( $all_fetch_key );
                //phpcs:ignore
                $prd_chk_meta_qry .= " AND m1.meta_value LIKE '%" . addslashes( $serialized_attribute_name ) . "%'";
                if ( strpos( $all_fetch_value, ',' ) !== false ) {
                    $attribute_name_key = explode( ',', trim( $all_fetch_value ) );
                    $i = 0;
                    $count_attribute_name_key = count( $attribute_name_key );
                    foreach ( $attribute_name_key as $opt_ex_value ) {
                        if ( $i === 0 ) {
                            $prd_chk_meta_qry .= " AND ( m1.meta_value REGEXP '\\b" . trim( $opt_ex_value ) . "\\b'";
                        } else {
                            if ( $i > 0 ) {
                                $prd_chk_meta_qry .= " OR m1.meta_value REGEXP '\\b" . trim( $opt_ex_value ) . "\\b'";
                            }
                        }
                        $i++;
                        if ( $i === $count_attribute_name_key ) {
                            $prd_chk_meta_qry .= " ) ";
                        }
                    }
                } else {
                    $prd_chk_meta_qry .= " AND m1.meta_value REGEXP '\\b" . trim( addslashes( $all_fetch_value ) ) . "\\b'";
                }
            }
        }
        $prd_chk_meta_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $prd_chk_meta_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
        $prd_chk_meta_qry .= " ASC";
        $prd_meta_result = $wpdb->get_results( $prd_chk_meta_qry );
        // phpcs:ignore
        if ( !empty( $prd_meta_result ) && is_array( $prd_meta_result ) ) {
            foreach ( $prd_meta_result as $value ) {
                $prd_meta_id[$value->ID] = $value->ID;
            }
        }
        $term_meta_id = array();
        $tax_meta_query = array();
        if ( !empty( $fetch_attribute_value_pass_jquery ) && is_array( $fetch_attribute_value_pass_jquery ) ) {
            foreach ( $fetch_attribute_value_pass_jquery as $all_fetch_key => $all_fetch_value ) {
                $attribute_slug_from_db = $this->wpfp_get_wc_attribute_label_slug( $all_fetch_key );
                if ( strpos( $all_fetch_value, ',' ) !== false ) {
                    $attribute_value_exp = explode( ',', trim( $all_fetch_value ) );
                    $attribute_value_slug_from_db = $this->wpfp_get_wc_attribute_value_slug( $attribute_slug_from_db, $attribute_value_exp );
                    $tax_meta_query[] = array(
                        'taxonomy' => 'pa_' . $attribute_slug_from_db,
                        'field'    => 'slug',
                        'terms'    => $attribute_value_slug_from_db,
                    );
                } else {
                    $attribute_value_slug_from_db = $this->wpfp_get_wc_attribute_value_slug( $attribute_slug_from_db, $all_fetch_value );
                    $tax_meta_query[] = array(
                        'taxonomy' => 'pa_' . $attribute_slug_from_db,
                        'field'    => 'slug',
                        'terms'    => array($attribute_value_slug_from_db),
                    );
                }
            }
        }
        $taxonomy_qry = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'tax_query'      => $tax_meta_query,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        );
        $taxonomy_query = new WP_Query($taxonomy_qry);
        $term_meta_result = $taxonomy_query->posts;
        if ( isset( $term_meta_result ) && is_array( $term_meta_result ) ) {
            foreach ( $term_meta_result as $value ) {
                $term_meta_id[$value->ID] = $value->ID;
            }
        }
        $term_unique_id = array();
        $tax_unique_query = array();
        if ( !empty( $fetch_attribute_value_pass_jquery ) && is_array( $fetch_attribute_value_pass_jquery ) ) {
            foreach ( $fetch_attribute_value_pass_jquery as $all_fetch_key => $all_fetch_value ) {
                $attribute_slug_from_db = $this->wpfp_get_wc_attribute_label_slug( $all_fetch_key );
                if ( strpos( $all_fetch_value, ',' ) !== false ) {
                    $attribute_value_exp = explode( ',', trim( $all_fetch_value ) );
                    $attribute_value_slug_from_db = $this->wpfp_get_wc_attribute_value_slug( $attribute_slug_from_db, $attribute_value_exp );
                    $tax_unique_query[] = array(
                        'taxonomy' => 'pa_' . $attribute_slug_from_db,
                        'field'    => 'slug',
                        'terms'    => $attribute_value_slug_from_db,
                    );
                } else {
                    $attribute_value_slug_from_db = $this->wpfp_get_wc_attribute_value_slug( $attribute_slug_from_db, $all_fetch_value );
                    $tax_unique_query[] = array(
                        'taxonomy' => 'pa_' . $attribute_slug_from_db,
                        'field'    => 'slug',
                        'terms'    => array($attribute_value_slug_from_db),
                    );
                }
            }
        }
        $taxonomy_unique_query = new WP_Query(array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'tax_query'      => $tax_unique_query,
            'orderby'        => 'title',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        ));
        $taxonomy_meta_result = $taxonomy_unique_query->posts;
        if ( !empty( $taxonomy_meta_result ) && is_array( $taxonomy_meta_result ) ) {
            foreach ( $taxonomy_meta_result as $value ) {
                $term_unique_id[$value->ID] = $value->ID;
            }
        }
        $prd_unique_id = array();
        $prd_unique_meta_qry = "";
        $prd_unique_meta_qry .= "SELECT {$wpdb->prefix}posts.post_title,{$wpdb->prefix}posts.ID";
        $prd_unique_meta_qry .= " FROM {$wpdb->prefix}posts";
        $prd_unique_meta_qry .= " INNER JOIN {$wpdb->prefix}postmeta m1";
        $prd_unique_meta_qry .= " ON ( {$wpdb->prefix}posts.ID = m1.post_id )";
        $prd_unique_meta_qry .= " WHERE";
        $prd_unique_meta_qry .= " {$wpdb->prefix}posts.post_type = 'product'";
        $prd_unique_meta_qry .= " AND {$wpdb->prefix}posts.post_status = 'publish'";
        if ( !empty( $wizard_category_id ) && isset( $wizard_category_id ) ) {
            $prd_unique_meta_qry .= " AND {$wpdb->prefix}posts.ID IN ( " . stripslashes( $category_wise_product ) . " )";
        }
        $prd_unique_meta_qry .= " AND ( m1.meta_key = '_product_attributes' )";
        if ( !empty( $fetch_attribute_value_pass_jquery ) && is_array( $fetch_attribute_value_pass_jquery ) ) {
            foreach ( $fetch_attribute_value_pass_jquery as $all_fetch_key => $all_fetch_value ) {
                $serialized_attribute_name = serialize( 'name' ) . serialize( $all_fetch_key );
                //phpcs:ignore
                $prd_unique_meta_qry .= " AND m1.meta_value LIKE '%" . addslashes( $serialized_attribute_name ) . "%'";
                if ( strpos( $all_fetch_value, ',' ) !== false ) {
                    $attribute_name_key = explode( ',', trim( $all_fetch_value ) );
                    $i = 0;
                    $count_attribute_name_key = count( $attribute_name_key );
                    foreach ( $attribute_name_key as $opt_ex_value ) {
                        if ( $i === 0 ) {
                            $prd_unique_meta_qry .= " AND ( m1.meta_value REGEXP '\\b" . trim( $opt_ex_value ) . "\\b'";
                        } else {
                            if ( $i > 0 ) {
                                $prd_unique_meta_qry .= " OR m1.meta_value REGEXP '\\b" . trim( $opt_ex_value ) . "\\b' ";
                            }
                        }
                        $i++;
                        if ( $i === $count_attribute_name_key ) {
                            $prd_unique_meta_qry .= " ) ";
                        }
                    }
                } else {
                    $prd_unique_meta_qry .= " OR m1.meta_value REGEXP '\\b" . trim( $all_fetch_value ) . "\\b'";
                }
            }
        }
        $prd_unique_meta_qry .= " GROUP BY {$wpdb->prefix}posts.ID";
        $prd_unique_meta_qry .= " ORDER BY {$wpdb->prefix}posts.post_date";
        $prd_unique_meta_qry .= " ASC";
        $prd_unique_meta_result = $wpdb->get_results( $prd_unique_meta_qry );
        // phpcs:ignore
        foreach ( $prd_unique_meta_result as $value ) {
            $prd_unique_id[$value->ID] = $value->ID;
        }
        if ( !empty( $prd_unique_id ) && !empty( $prd_meta_id ) ) {
            $prd_unique_prd_meta_common_id = array_merge( $prd_meta_id, $prd_unique_id );
        }
        if ( !empty( $term_unique_id ) && !empty( $term_meta_id ) ) {
            $term_unique_term_meta_common_id = array_intersect_key( $term_unique_id, $term_meta_id );
        }
        $final_match_product_id = '';
        if ( !empty( $prd_unique_prd_meta_common_id ) && !empty( $term_unique_term_meta_common_id ) ) {
            $final_match_product_id = array_merge( $prd_unique_prd_meta_common_id, $term_unique_term_meta_common_id );
        } else {
            if ( !empty( $prd_unique_prd_meta_common_id ) ) {
                $final_match_product_id = $prd_unique_prd_meta_common_id;
            } else {
                if ( !empty( $term_unique_term_meta_common_id ) ) {
                    $final_match_product_id = $term_unique_term_meta_common_id;
                }
            }
        }
        if ( empty( $final_match_product_id ) ) {
            return array(
                'final_match_product_id' => array(),
            );
        } else {
            return array(
                'final_match_product_id' => array_unique( array_filter( $final_match_product_id ) ),
            );
        }
    }

    /**
     * Get woocommerce atrribute label slug
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id
     *
     * @return string
     *
     */
    public function wpfp_get_wc_attribute_label_slug( $attribute_label ) {
        global $wpdb;
        $attribute_name = '';
        $get_att_name_rows = $wpdb->get_row( $wpdb->prepare( "SELECT attribute_name FROM {$wpdb->prefix}woocommerce_attribute_taxonomies WHERE attribute_label = %s", $attribute_label ) );
        // phpcs:ignore
        if ( !empty( $get_att_name_rows ) && $get_att_name_rows !== '' ) {
            $attribute_name = $get_att_name_rows->attribute_name;
        }
        return $attribute_name;
    }

    /**
     * Get woocommerce atrribute value slug
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id
     *
     * @return string
     *
     */
    public function wpfp_get_wc_attribute_value_slug( $attribute_slug_from_db, $attribute_value ) {
        global $wpdb;
        $attribute_value_slug = '';
        $wp_terms = $wpdb->prefix . "terms";
        if ( !empty( $attribute_value ) && is_array( $attribute_value ) ) {
            $attribute_value_slug_arr = array();
            foreach ( $attribute_value as $value ) {
                $attribute_value_replace = str_replace( "’", "'", $value );
                $get_att_value_qry = $wpdb->prepare( 'SELECT slug FROM ' . $wp_terms . ' WHERE name = %s', stripslashes( $attribute_value_replace ) );
                // phpcs:ignore
                $get_att_value_rows = $wpdb->get_row( $get_att_value_qry );
                // phpcs:ignore
                if ( !empty( $get_att_value_rows ) && $get_att_value_rows !== '' ) {
                    $attribute_value_slug_arr[] = $get_att_value_rows->slug;
                }
            }
            return $attribute_value_slug_arr;
        } else {
            $attribute_value_replace = str_replace( "’", "'", $attribute_value );
            $get_att_value_qry = $wpdb->prepare( 'SELECT slug FROM ' . $wp_terms . ' WHERE name = %s', stripslashes( $attribute_value_replace ) );
            // phpcs:ignore
            $get_att_value_rows = $wpdb->get_row( $get_att_value_qry );
            // phpcs:ignore
            if ( !empty( $get_att_value_rows ) && $get_att_value_rows !== '' ) {
                $attribute_value_slug = $get_att_value_rows->slug;
            }
            return $attribute_value_slug;
        }
    }

    /**
     * Get Option value based on option id
     *
     * @since    1.0.0
     *
     * @param      int $option_id option id.
     *
     * @param      int $wizard_id wizard id.
     *
     * @return array
     */
    public function wpfp_get_option_value_based_on_option_id( $option_id, $wizard_id ) {
        global $wpdb;
        $option_attribute_value = array();
        $options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        if ( !empty( $wizard_id ) && isset( $wizard_id ) ) {
            $and = " AND wizard_id=%d";
        }
        $sel_qry = $wpdb->prepare( 'SELECT * FROM ' . $options_table_name . ' WHERE id IN ( ' . stripslashes( $option_id ) . ' ) ' . $and . '', $wizard_id );
        // phpcs:ignore
        $sel_rows = $wpdb->get_results( $sel_qry );
        // phpcs:ignore
        if ( !empty( $sel_rows ) && $sel_rows !== '0' && isset( $sel_rows ) ) {
            foreach ( $sel_rows as $sel_data ) {
                if ( strpos( $sel_data->option_attribute_value, ',' ) !== false ) {
                    $option_attribute_value_ex = explode( ',', trim( $sel_data->option_attribute_value ) );
                } else {
                    $option_attribute_value_ex = array($sel_data->option_attribute_value);
                }
                foreach ( $option_attribute_value_ex as $value ) {
                    $option_attribute_value[] = $value;
                }
            }
        }
        return $option_attribute_value;
    }

    /**
     * Get Option name based on option id
     *
     * @since    1.0.0
     *
     * @param      int $option_id option id.
     *
     * @param      int $wizard_id wizard id.
     *
     * @return array
     */
    public function wpfp_get_option_name_based_on_option_id( $option_id, $wizard_id ) {
        global $wpdb;
        $option_attribute = array();
        $options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        if ( !empty( $wizard_id ) && isset( $wizard_id ) ) {
            $and = " AND wizard_id=%d";
        }
        $sel_qry = $wpdb->prepare( 'SELECT * FROM ' . $options_table_name . ' WHERE id IN ( ' . stripslashes( $option_id ) . ' ) ' . $and . '', $wizard_id );
        // phpcs:ignore
        $sel_rows = $wpdb->get_results( $sel_qry );
        // phpcs:ignore
        if ( !empty( $sel_rows ) && $sel_rows !== '0' && isset( $sel_rows ) ) {
            foreach ( $sel_rows as $sel_data ) {
                $options_id = $sel_data->id;
                $option_attribute[$options_id] = $sel_data->option_attribute;
            }
        }
        return $option_attribute;
    }

    /**
     * Get all attribute value
     *
     * @since    1.0.0
     *
     * @param      array $category_wise_product Category ID.
     *
     * @return array
     *
     */
    public function wpfp_get_all_attribute_value( $category_wise_product ) {
        $query_args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'orderby'        => 'post_date',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        );
        if ( !empty( $category_wise_product ) ) {
            $query_args['post__in'] = explode( ',', stripslashes( $category_wise_product ) );
        }
        $sel_result = new WP_Query($query_args);
        $sel_result_count = $sel_result->post_count;
        $custom_product_attributes_arr_arr = array();
        $custom_product_attributes = array();
        if ( $sel_result_count > 0 ) {
            if ( $sel_result->have_posts() ) {
                while ( $sel_result->have_posts() ) {
                    $sel_result->the_post();
                    $theid = get_the_ID();
                    $product = new WC_Product($theid);
                    $variation_data = $product->get_attributes();
                    if ( !empty( $variation_data ) && isset( $variation_data ) ) {
                        foreach ( $variation_data as $attribute ) {
                            if ( $attribute['is_taxonomy'] ) {
                                $values = wc_get_product_terms( $theid, $attribute['name'], array(
                                    'fields' => 'names',
                                ) );
                                $att_val = apply_filters(
                                    'woocommerce_attribute',
                                    wptexturize( implode( ' | ', str_replace( "'", "", $values ) ) ),
                                    $attribute,
                                    str_replace( "'", "", $values )
                                );
                                $att_val_ex = trim( $att_val );
                            } else {
                                $att_val_ex = trim( str_replace( "'", "", $attribute['value'] ) );
                            }
                            $custom_product_attributes[] = explode( '|', $att_val_ex );
                            $custom_product_attributes_arr_arr[$theid][wc_attribute_label( $attribute['name'] )] = $att_val_ex;
                        }
                    }
                }
            }
        }
        return $custom_product_attributes_arr_arr;
    }

    /**
     * Get all product id
     *
     * @since    1.0.0
     *
     * @param      array $category_wise_product Category ID.
     *
     * @return int Its return custom product id
     *
     */
    public function wpfp_get_all_product_id( $category_wise_product ) {
        $query_args = array(
            'post_type'      => 'product',
            'post_status'    => 'publish',
            'orderby'        => 'post_date',
            'order'          => 'ASC',
            'posts_per_page' => -1,
        );
        if ( !empty( $category_wise_product ) ) {
            $query_args['post__in'] = explode( ',', stripslashes( $category_wise_product ) );
        }
        $sel_result = new WP_Query($query_args);
        $sel_result_count = $sel_result->post_count;
        $custom_product_id = array();
        if ( $sel_result_count > 0 ) {
            if ( $sel_result->have_posts() ) {
                while ( $sel_result->have_posts() ) {
                    $sel_result->the_post();
                    $theid = get_the_ID();
                    $custom_product_id[$theid] = trim( $theid );
                }
            }
        }
        return $custom_product_id;
        wp_reset_query();
    }

    /**
     * Get Option id based on option value
     *
     * @since    1.0.0
     *
     * @param      string $option_name      Option Name.
     *
     * @param      string $option_attribute Option Attribute.
     *
     * @param      int    $wizard_id        Wizard Id.
     *
     * @return int
     *
     */
    public function wpfp_get_option_id_based_on_option_value( $option_name, $option_attribute, $wizard_id ) {
        global $wpdb;
        $options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        $where = '';
        if ( !empty( $option_name ) && $option_name !== '' && isset( $option_name ) ) {
            $where .= " WHERE FIND_IN_SET( '" . trim( $option_name ) . "', option_attribute_value ) <> 0";
        }
        $and = '';
        if ( !empty( $option_attribute ) && $option_attribute !== '' && isset( $option_attribute ) ) {
            $and .= " AND option_attribute=%d";
        }
        if ( !empty( $wizard_id ) && $wizard_id !== '' && isset( $wizard_id ) ) {
            $and .= " AND wizard_id=%d";
        }
        $sel_qry = $wpdb->prepare( 'SELECT GROUP_CONCAT( id ) as all_id FROM ' . $options_table_name . ' ' . $where . ' ' . $and . '', $option_attribute, $wizard_id );
        // phpcs:ignore
        $get_option_result = $wpdb->get_row( $sel_qry );
        // phpcs:ignore
        if ( !empty( $get_option_result ) && $get_option_result !== '' && isset( $get_option_result ) ) {
            $get_option_id = $get_option_result->all_id;
            return $get_option_id;
        }
    }

    /**
     * Ajax pagination in front side
     *
     * @since    1.0.0
     *
     * @param      int $wizard_id              wizard id.
     *
     * @param      int $question_id            question id.
     *
     * @param      int $option_id              option id.
     *
     * @param      int $current_selected_value Selected current value from attribute selection.
     *
     * @param      int $limit                  limit for display list ( Like Display 4 products in front side ).
     *
     * @param      int $page                   Page number ( Current page number ).
     *
     * @param      int $last                   Last Page Number.
     *
     * @param      int $total_records          Total Records ( How many records in product ).
     *
     * @return     html Its return pagination html in front side
     *
     */
    public function wpfp_front_ajax_pagination(
        $wizard_id,
        $question_id,
        $option_id,
        $current_selected_value,
        $limit,
        $page,
        $last,
        $total_records
    ) {
        global $wpdb;
        $pagination_list = '';
        $sel_wizard_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id= %d ", $wizard_id ) );
        // phpcs:ignore
        if ( !empty( $sel_wizard_rows ) && $sel_wizard_rows !== '' ) {
            $wizard_setting = ( empty( $sel_wizard_rows->wizard_setting ) ? '' : json_decode( $sel_wizard_rows->wizard_setting, true ) );
            $total_count_title = ( isset( $wizard_setting['total_count_title'] ) && !empty( $wizard_setting['total_count_title'] ) ? sanitize_text_field( wp_unslash( $wizard_setting['total_count_title'] ) ) : '' );
        }
        if ( $page !== '1' && !empty( $page ) ) {
            $pagination_list .= '<div class="top_product_btn front_pagination">';
            $pagination_list .= '<a class="first-page wprw-button wprw-detail-button wprw-product-detail-link" href="javascript:void(0);" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_1">';
            $pagination_list .= '<span class="prd_detail_name">' . esc_html( 'Back To Top Product' ) . '</span>';
            $pagination_list .= '</a>';
            $pagination_list .= '</div>';
        }
        $pagination_list .= '<div class="tablenav">';
        $pagination_list .= '<div class="tablenav-pages front_pagination" id="front_pagination">';
        $pagination_list .= '<span class="displaying-num">' . esc_html( $total_records ) . ' ' . esc_html__( $total_count_title, 'woo-product-finder' ) . '</span>';
        $pagination_list .= '<span class="pagination-links">';
        $page_minus = $page - 1;
        $page_plus = $page + 1;
        if ( $page_minus > 0 ) {
            $pagination_list .= '<a class="first-page" href="javascript:void(0);" class="links" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_1">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'First page', 'woo-product-finder' ) . '</span><span aria-hidden="true" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_1" class="pagination_span">&#171;</span></a>';
            $pagination_list .= '<a class="prev-page" href="javascript:void(0);" class="links" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $page_minus ) . '">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'woo-product-finder' ) . '</span><span aria-hidden="true" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $page_minus ) . '"  class="pagination_span">&#8249;</span></a>';
        }
        for ($i = 1; $i <= $last; $i++) {
            if ( $i === (int) $page ) {
                if ( $total_records > $limit ) {
                    $pagination_list .= '<a href="javascript:void(0);" class="selected" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $i ) . '">' . esc_html( $i ) . '</a>';
                }
            } else {
                $pagination_list .= '<a href="javascript:void(0);" class="links"  id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $i ) . '">' . esc_html( $i ) . '</a>';
            }
        }
        $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'Current Page', 'woo-product-finder' ) . '</span>';
        if ( $total_records > $limit ) {
            $pagination_list .= '<span id="table-paging" class="paging-input"><span class="tablenav-paging-text">' . $page . ' of <span class="total-pages">' . $last . '</span></span></span>';
        }
        if ( $page_plus <= $last ) {
            $pagination_list .= '<a class="next-page" href="javascript:void(0);" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_' . $page_plus . '" class="links">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'Next page', 'woo-product-finder' ) . '</span><span aria-hidden="true" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $page_plus ) . '" class="pagination_span">&#8250;</span>';
            $pagination_list .= '</a>';
        }
        if ( $page !== $last ) {
            $pagination_list .= '<a class="last-page"href="javascript:void(0);" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_' . $last . '" class="links">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'Last page', 'woo-product-finder' ) . '</span><span aria-hidden="true" id="wd_' . esc_attr( $wizard_id ) . '_que_' . esc_attr( $question_id ) . '_opt_' . esc_attr( $option_id ) . '_cur_' . esc_attr( $current_selected_value ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $last ) . '" class="pagination_span">&#187;</span>';
            $pagination_list .= '</a>';
        }
        $pagination_list .= '</span>';
        $pagination_list .= '</div>';
        $pagination_list .= '</div>';
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
        return wp_kses( $pagination_list, $f_array );
    }

    /**
     * Get wizard title based on id.
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id
     *
     * @return string
     *
     */
    public function wpfp_get_wizard_title_based_on_id( $wizard_id ) {
        global $wpdb;
        $wizard_name = '';
        $sel_wizard_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id=%d", $wizard_id ) );
        // phpcs:ignore
        if ( !empty( $sel_wizard_rows ) && $sel_wizard_rows !== '' ) {
            $wizard_name = $sel_wizard_rows->name;
        }
        return $wizard_name;
    }

}
