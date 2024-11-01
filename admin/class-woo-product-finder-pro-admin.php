<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Finder_Pro
 * @subpackage Woo_Product_Finder_Pro/admin
 */
/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Product_Finder_Pro
 * @subpackage Woo_Product_Finder_Pro/admin
 * @author     Multidots <inquiry@multidots.in>
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class WPFPFW_Woo_Product_Finder_Pro_Admin {
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
     * @param      string $plugin_name The name of this plugin.
     * @param      string $version     The version of this plugin.
     */
    public function __construct( $plugin_name, $version ) {
        $this->plugin_name = $plugin_name;
        $this->version = $version;
    }

    /**
     * Register the stylesheets for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_styles( $hook ) {
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
        if ( strpos( $hook, '_wpfp' ) !== false ) {
            wp_enqueue_style(
                $this->plugin_name,
                plugin_dir_url( __FILE__ ) . 'css/woo-product-finder-pro-admin.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . 'main-style',
                plugin_dir_url( __FILE__ ) . 'css/style.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . 'plugin-new-style',
                plugin_dir_url( __FILE__ ) . 'css/plugin-new-style.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . 'upgrade-dashboard',
                plugin_dir_url( __FILE__ ) . 'css/upgrade-dashboard.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . 'plugin-setup-wizard',
                plugin_dir_url( __FILE__ ) . 'css/plugin-setup-wizard.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . '-jquery-ui-css',
                plugin_dir_url( __FILE__ ) . 'css/jquery-ui.min.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . 'font-awesome',
                plugin_dir_url( __FILE__ ) . 'css/font-awesome.min.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . '-webkit-css',
                plugin_dir_url( __FILE__ ) . 'css/webkit.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style(
                $this->plugin_name . 'media-css',
                plugin_dir_url( __FILE__ ) . 'css/media.css',
                array(),
                $this->version,
                'all'
            );
            wp_enqueue_style( 'wp-color-picker' );
            wp_enqueue_style(
                $this->plugin_name . '-chosen-wizard-css',
                plugin_dir_url( __FILE__ ) . 'css/chosen.css',
                array(),
                $this->version,
                'all'
            );
        }
    }

    /**
     * Register the JavaScript for the admin area.
     *
     * @since    1.0.0
     */
    public function enqueue_scripts( $hook ) {
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
        if ( strpos( $hook, '_wpfp' ) !== false ) {
            wp_enqueue_script( 'jquery' );
            wp_enqueue_script( 'media-upload' );
            wp_enqueue_script( 'jquery-ui-core' );
            wp_enqueue_script( 'jquery-ui-sortable' );
            wp_enqueue_script( 'jquery-ui-accordion' );
            wp_enqueue_style( 'wp-jquery-ui-dialog' );
            wp_enqueue_media();
            wp_enqueue_script(
                'woo-product-finder-pro-help-scout-beacon-js',
                plugin_dir_url( __FILE__ ) . 'js/help-scout-beacon.js',
                array('jquery'),
                $this->version,
                false
            );
            wp_enqueue_script(
                'woo-product-finder_freemius_pro',
                'https://checkout.freemius.com/checkout.min.js',
                array('jquery'),
                $this->version,
                true
            );
            wp_enqueue_script(
                'woo-product-finder-admin',
                plugin_dir_url( __FILE__ ) . 'js/woo-product-finder-admin.js',
                array(
                    'jquery',
                    'jquery-ui-dialog',
                    'jquery-ui-accordion',
                    'jquery-ui-sortable',
                    'wp-color-picker'
                ),
                $this->version,
                false
            );
            wp_localize_script( 'woo-product-finder-admin', 'adminajax', array(
                'ajaxurl'                 => admin_url( 'admin-ajax.php' ),
                'ajax_icon'               => esc_url( plugin_dir_url( __FILE__ ) . '/images/ajax-loader.gif' ),
                'dpb_api_url'             => WPFP_STORE_URL,
                'setup_wizard_ajax_nonce' => wp_create_nonce( 'wizard_ajax_nonce' ),
            ) );
            wp_enqueue_script(
                $this->plugin_name . 'tablesorter',
                plugin_dir_url( __FILE__ ) . 'js/jquery.tablesorter.js',
                array('jquery'),
                $this->version,
                false
            );
            wp_enqueue_script(
                'chosen_custom_wizard_pro',
                plugin_dir_url( __FILE__ ) . 'js/chosen.jquery.js',
                array('jquery'),
                $this->version,
                false
            );
            wp_localize_script( 'chosen_custom_wizard_pro', 'woo_category', array(
                'WooCategoryArray' => '',
            ) );
            wp_localize_script( 'chosen_custom_wizard_pro', 'option_value_id', array(
                'OptionValueIDArray' => '',
            ) );
            wp_localize_script( 'chosen_custom_wizard_pro', 'wizard_path', array(
                'WizardPath' => plugin_dir_url( __FILE__ ),
            ) );
            /* Category List */
            $fetchWooCategory = $this->wpfp_get_woocommerce_category_from_database();
            $WooCategoryArray = ( !empty( $fetchWooCategory ) ? wp_json_encode( $fetchWooCategory ) : wp_json_encode( array() ) );
            if ( $WooCategoryArray && !empty( $WooCategoryArray ) && $WooCategoryArray !== '' ) {
                wp_localize_script( 'chosen_custom_wizard_pro', 'woo_category', array(
                    'WooCategoryArray' => $WooCategoryArray,
                ) );
            } else {
                wp_localize_script( 'chosen_custom_wizard_pro', 'woo_category', array(
                    'WooCategoryArray' => '',
                ) );
            }
            wp_localize_script( 'chosen_custom_wizard_pro', 'option_value_id', array(
                'OptionValueIDArray' => '',
            ) );
            wp_localize_script( 'chosen_custom_wizard_pro', 'wizard_path', array(
                'WizardPath' => plugin_dir_url( __FILE__ ),
            ) );
            /* Total Count Option ID */
            $last_option_id_option_tbl = $this->wpfp_get_next_option_id_for_question();
            /* GET Wizard Id and Question ID */
            $get_wizard_id = ( isset( $_REQUEST['wrd_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wrd_id'] ) ) : '' );
            // phpcs:ignore
            $get_question_id = ( isset( $_REQUEST['que_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['que_id'] ) ) : '' );
            // phpcs:ignore
            /* Option ID */
            $fetchOptionValueID = $this->wpfp_get_custom_options_id_from_database();
            $OptionValueIDArray = ( !empty( $fetchOptionValueID ) ? wp_json_encode( $fetchOptionValueID ) : wp_json_encode( array() ) );
            wp_localize_script( 'chosen_custom_wizard_pro', 'option_value_id', array(
                'OptionValueIDArray' => $OptionValueIDArray,
            ) );
            $questions = '';
            if ( isset( $_REQUEST["que_id"] ) && !empty( $_REQUEST["que_id"] ) && isset( $_REQUEST['wrd_id'] ) && !empty( $_REQUEST['wrd_id'] ) ) {
                // phpcs:ignore
                global $wpdb;
                $wrd_id = filter_input( INPUT_GET, 'wrd_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                $que_id = filter_input( INPUT_GET, 'que_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                $question_query_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions WHERE wizard_id=%d AND NOT id=%d ORDER BY sortable_id ASC", $wrd_id, $que_id ) );
                // phpcs:ignore
                if ( isset( $question_query_rows ) && !empty( $question_query_rows ) ) {
                    $questions .= "<option value=''>Select Next Question</option>";
                    foreach ( $question_query_rows as $values ) {
                        $questions .= "<option value='" . esc_attr( $values->id ) . "'>(#" . esc_html__( $values->id, 'woo-product-finder' ) . ") " . esc_html__( $values->name, 'woo-product-finder' ) . "</option>";
                    }
                }
            }
            /* Option Label Name Dynamically When Add New Option */
            wp_localize_script( 'chosen_custom_wizard_pro', 'optionLabelDetails', array(
                'option_label'                 => wp_json_encode( 'Options Title' ),
                'option_lable_description'     => wp_json_encode( 'If you are creating wizard based on shoes, then you want to enter option title related to attribute value ( EX: Attribute value is male, then you should keep option name : Male )' ),
                'option_lable_placeholder'     => wp_json_encode( 'Enter Options Title Here' ),
                'option_name_error'            => wp_json_encode( 'Please Enter Options Title Here' ),
                'option_image_lable'           => wp_json_encode( 'Options Image' ),
                'option_image_select_file'     => wp_json_encode( 'Select File' ),
                'option_image_upload_image'    => wp_json_encode( 'Upload File' ),
                'option_image_remove_image'    => wp_json_encode( 'Remove File' ),
                'option_image_description'     => wp_json_encode( 'Upload Options Image Here' ),
                'option_image_error'           => wp_json_encode( 'Invalid file or images( Allow only png,jpg,jpeg or gif )' ),
                'option_attribute_lable'       => wp_json_encode( 'Attribute Name' ),
                'option_attribute_description' => wp_json_encode( 'Select attribute name which is created in Product attribute section (Ex. Attribute name: Gender Attribute value: gender) type attribute value gender' ),
                'option_attribute_placeholder' => wp_json_encode( 'Please type attribute slug' ),
                'option_attribute_error'       => wp_json_encode( 'Please Select Attribute Name' ),
                'option_value_lable'           => wp_json_encode( 'Attribute Value' ),
                'option_value_description'     => wp_json_encode( 'Select attribute value which is created in Product attribute section' ),
                'option_value_placeholder'     => wp_json_encode( 'Select Attribute Value' ),
                'option_value_error'           => wp_json_encode( 'Please Select Attribute Value' ),
                'option_next_label'            => wp_json_encode( 'Next Question' ),
                'option_next_description'      => wp_json_encode( 'Set next question for this option.' ),
                'option_next_values'           => wp_json_encode( $questions ),
                'last_option_id_option_tbl'    => wp_json_encode( $last_option_id_option_tbl['next_count_option_id'] ),
            ) );
            /*get action*/
            $action = ( isset( $_REQUEST['action'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) : '' );
            // phpcs:ignore
            if ( $action === '' ) {
                /* Category List */
                wp_localize_script( 'chosen_custom_wizard_pro', 'woo_category', array(
                    'WooCategoryArray' => '',
                ) );
            }
            if ( $action === 'edit' ) {
                /* Category List */
                wp_localize_script( 'chosen_custom_wizard_pro', 'woo_category', array(
                    'WooCategoryArray' => '',
                ) );
                /* Option ID */
                $fetchOptionValueID = $this->wpfp_get_custom_options_id_from_database();
                $OptionValueIDArray = ( !empty( $fetchOptionValueID ) ? wp_json_encode( $fetchOptionValueID ) : wp_json_encode( array() ) );
                wp_localize_script( 'chosen_custom_wizard_pro', 'option_value_id', array(
                    'OptionValueIDArray' => $OptionValueIDArray,
                ) );
                /* Attribute Value */
                $attributeValueArrayFromDB = $this->wpfp_get_custom_attribute_value_from_database();
                if ( !empty( $attributeValueArrayFromDB ) && $attributeValueArrayFromDB !== '' && is_array( $attributeValueArrayFromDB ) ) {
                    foreach ( $attributeValueArrayFromDB as $key => $value ) {
                        $value1 = explode( ',', trim( $value ) );
                        $fetchWooCoomerceOption = ( !empty( $value1 ) ? $value1 : '' );
                        wp_localize_script( 'chosen_custom_wizard_pro', 'allAttributeValue' . $key, array(
                            'attribute_option_id'  => 'attribute_option_' . $key,
                            'attributeOptionArray' => $fetchWooCoomerceOption,
                        ) );
                    }
                }
                /* Attribute Name */
                $fetchOptionNameFromDB = $this->wpfp_get_custom_options_name_from_database();
                if ( !empty( $fetchOptionNameFromDB ) && $fetchOptionNameFromDB !== '' && is_array( $fetchOptionNameFromDB ) ) {
                    foreach ( $fetchOptionNameFromDB as $key => $value ) {
                        $fetchWooCoomerceAttributename = ( !empty( $value ) ? $value : '' );
                        wp_localize_script( 'chosen_custom_wizard_pro', 'allAttributename' . $key, array(
                            'attribute_name_id'       => 'attribute_name_' . $key,
                            'attributeAttributeArray' => $fetchWooCoomerceAttributename,
                        ) );
                    }
                }
            }
        }
    }

    /**
     * Get woocommerce category from wizard table.
     *
     * @since    1.0.0
     *
     * @return string
     */
    public function wpfp_get_woocommerce_category_from_database() {
        global $wpdb;
        $wizard_attribute_name = array();
        $wizard_id = ( isset( $_REQUEST['wrd_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wrd_id'] ) ) : '' );
        // phpcs:ignore
        $sel_wizard_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id = %d", $wizard_id ) );
        // phpcs:ignore
        if ( !empty( $sel_wizard_rows ) && $sel_wizard_rows !== '' && is_array( $sel_wizard_rows ) ) {
            foreach ( $sel_wizard_rows as $sel_wizard_data ) {
                $get_wizard_id = $sel_wizard_data->id;
                $wizard_attribute_name[$get_wizard_id] = $sel_wizard_data->wizard_category;
            }
        }
        return $wizard_attribute_name;
    }

    /**
     * Next option id for particular question
     *
     * @since    1.0.0
     *
     * @return array
     */
    public function wpfp_get_next_option_id_for_question() {
        $last_option_id = $this->wpfp_get_total_option_id_for_question();
        $next_count_option_id = intval( $last_option_id['last_option_id'] ) + intval( 1 );
        return array(
            "next_count_option_id" => $next_count_option_id,
        );
    }

    /**
     * Total option id for particular question
     *
     * @since    1.0.0
     *
     * @return array
     */
    public function wpfp_get_total_option_id_for_question() {
        global $wpdb;
        $last_option_id = '';
        $sel_results = $wpdb->get_row( "SELECT id AS last_option_id FROM {$wpdb->prefix}wpfp_questions_options ORDER BY id DESC LIMIT 1 " );
        // phpcs:ignore
        if ( !empty( $sel_results ) && isset( $sel_results ) ) {
            $last_option_id = $sel_results->last_option_id;
        }
        return array(
            "last_option_id" => $last_option_id,
        );
    }

    /**
     * Get custom options id from option table for admin are.
     *
     * @since    1.0.0
     *
     * @return array
     */
    public function wpfp_get_custom_options_id_from_database() {
        global $wpdb;
        $wizard_id = ( isset( $_REQUEST['wrd_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wrd_id'] ) ) : '' );
        // phpcs:ignore
        $question_id = ( isset( $_REQUEST['que_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['que_id'] ) ) : '' );
        // phpcs:ignore
        $option_id_arr = array();
        $sel_options_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id=%d AND question_id = %d", $wizard_id, $question_id ) );
        // phpcs:ignore
        if ( !empty( $sel_options_rows ) && $sel_options_rows !== '' && is_array( $sel_options_rows ) ) {
            foreach ( $sel_options_rows as $sel_options_data ) {
                $options_id = $sel_options_data->id;
                $option_id_arr[] = "attribute_option_" . $options_id;
            }
        }
        return $option_id_arr;
    }

    /**
     * Get custom attribute value from option table for admin are.
     *
     * @since    1.0.0
     *
     * @return array
     */
    public function wpfp_get_custom_attribute_value_from_database() {
        global $wpdb;
        $wizard_id = ( isset( $_REQUEST['wrd_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wrd_id'] ) ) : '' );
        // phpcs:ignore
        $question_id = ( isset( $_REQUEST['que_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['que_id'] ) ) : '' );
        // phpcs:ignore
        $option_att_arr = array();
        $sel_options_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id=%d AND question_id = %d", $wizard_id, $question_id ) );
        // phpcs:ignore
        if ( !empty( $sel_options_rows ) && $sel_options_rows !== '' && is_array( $sel_options_rows ) ) {
            foreach ( $sel_options_rows as $sel_options_data ) {
                $options_id = $sel_options_data->id;
                $option_attribute_value = $sel_options_data->option_attribute_value;
                $option_att_arr[$options_id] = $option_attribute_value;
            }
        }
        return $option_att_arr;
    }

    /**
     * Get custom options name from option table for admin are.
     *
     * @since    1.0.0
     *
     * @return string
     */
    public function wpfp_get_custom_options_name_from_database() {
        global $wpdb;
        $wizard_id = ( isset( $_REQUEST['wrd_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wrd_id'] ) ) : '' );
        // phpcs:ignore
        $question_id = ( isset( $_REQUEST['que_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['que_id'] ) ) : '' );
        // phpcs:ignore
        $options_attribute_name = array();
        $sel_options_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id=%d AND question_id = %d", $wizard_id, $question_id ) );
        // phpcs:ignore
        if ( !empty( $sel_options_rows ) && $sel_options_rows !== '' && is_array( $sel_options_rows ) ) {
            foreach ( $sel_options_rows as $sel_options_data ) {
                $options_id = $sel_options_data->id;
                $options_attribute_name[$options_id] = stripslashes( $sel_options_data->option_attribute . "==" . $sel_options_data->option_attribute_db );
            }
        }
        return $options_attribute_name;
    }

    /**
     * Register the Page for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_dot_store_menu() {
        global $GLOBALS;
        if ( empty( $GLOBALS['admin_page_hooks']['dots_store'] ) ) {
            add_menu_page(
                'Dotstore Plugins',
                __( 'Dotstore Plugins', 'woo-product-finder' ),
                'manage_option',
                'dots_store',
                array($this, 'wpfp_wizrd_list_page'),
                'dashicons-marker',
                25
            );
        }
        add_submenu_page(
            'dots_store',
            'Get Started',
            'Get Started',
            'manage_options',
            'wpfp-get-started',
            array($this, 'wpfp_get_started_page')
        );
        add_submenu_page(
            'dots_store',
            'Introduction',
            'Introduction',
            'manage_options',
            'wpfp-information',
            array($this, 'wpfp_information_page')
        );
        add_submenu_page(
            'dots_store',
            'Product Recommendation Quiz For WooCommerce',
            __( WPFPFW_WOO_PRODUCT_FINDER_PLUGIN_NAME, 'woo-product-finder' ),
            'manage_options',
            'wpfp-list',
            array($this, 'wpfp_wizrd_list_page')
        );
        add_submenu_page(
            'dots_store',
            'Get Premium',
            'Get Premium',
            'manage_options',
            'wpfp-upgrade-dashboard',
            array($this, 'wpfp_free_user_upgrade_page')
        );
        add_submenu_page(
            'dots_store',
            'Add New',
            'Add New',
            'manage_options',
            'wpfp-add-new',
            array($this, 'wpfp_add_new_wizard_page')
        );
        add_submenu_page(
            'dots_store',
            'Edit Wizard',
            'Edit Wizard',
            'manage_options',
            'wpfp-edit-wizard',
            array($this, 'wpfp_edit_wizard_page')
        );
        add_submenu_page(
            'dots_store',
            'Add New',
            'Add New',
            'manage_options',
            'wpfp-add-new-question',
            array($this, 'wpfp_add_new_question_page')
        );
        add_submenu_page(
            'dots_store',
            'Edit Question',
            'Edit Question',
            'manage_options',
            'wpfp-edit-question',
            array($this, 'wpfp_edit_question_page')
        );
        add_submenu_page(
            'dots_store',
            'Wizard Setting',
            'Wizard Setting',
            'manage_options',
            'wpfp-wizard-setting',
            array($this, 'wpfp_wizard_setting_page')
        );
    }

    /**
     * Register the Information Page for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_information_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wpfp-information-page.php';
    }

    /**
     * Register the Wizard List for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_wizrd_list_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wpfp-list-page.php';
    }

    /**
     * Register the Add New Wizard for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_add_new_wizard_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wpfp-add-new-page.php';
    }

    /**
     * Register the Edit Wizard Page for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_edit_wizard_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wpfp-add-new-page.php';
    }

    /**
     * Register the Get Started Page for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_get_started_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wpfp-get-started-page.php';
    }

    /**
     * Register the Add New Question for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_add_new_question_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wpfp-add-new-question-page.php';
    }

    /**
     * Register the Edit Question for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_edit_question_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wpfp-add-new-question-page.php';
    }

    /**
     * Register the Wizard Setting Page for the admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_wizard_setting_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/wpfp-wizard-setting.php';
    }

    /**
     * Register the Upgrade Premium Page for the admin area.
     *
     * @since 2.0.0
     */
    public function wpfp_free_user_upgrade_page() {
        require_once plugin_dir_path( __FILE__ ) . 'partials/dots-upgrade-dashboard.php';
    }

    /**
     * Welcome Screen Redirect.
     *
     * @since    1.0.0
     */
    public function wpfp_welcome_screen_do_activation_redirect() {
        // if no activation redirect
        if ( !get_transient( '_welcome_screen_activation_redirect_wpfp' ) ) {
            return;
        }
        // Delete the redirect transient
        delete_transient( '_welcome_screen_activation_redirect_wpfp' );
        // if activating from network, or bulk
        if ( is_network_admin() || isset( $_GET['activate-multi'] ) ) {
            // phpcs:ignore
            return;
        }
        // Redirect to extra cost welcome  page
        wp_safe_redirect( add_query_arg( array(
            'page' => 'wpfp-get-started',
        ), admin_url( 'admin.php' ) ) );
        exit;
    }

    /**
     * Remove Menu from toolbar which is display in admin section.
     *
     * @since    1.0.0
     */
    public function wpfp_remove_admin_submenus() {
        remove_submenu_page( 'dots_store', 'dots_store' );
        remove_submenu_page( 'dots_store', 'wpfp-information' );
        remove_submenu_page( 'dots_store', 'wpfp-upgrade-dashboard' );
        remove_submenu_page( 'dots_store', 'wpfp-add-new' );
        remove_submenu_page( 'dots_store', 'wpfp-edit-wizard' );
        remove_submenu_page( 'dots_store', 'wpfp-get-started' );
        remove_submenu_page( 'dots_store', 'wpfp-add-new-question' );
        remove_submenu_page( 'dots_store', 'wpfp-edit-question' );
        remove_submenu_page( 'dots_store', 'wpfp-wizard-setting' );
    }

    /**
     * Get all woocommerce category for admin area.
     *
     * @since    1.0.0
     *
     * @return array
     */
    public function wpfp_get_woocommerce_category() {
        $wooCategory = get_terms( array(
            'taxonomy'   => 'product_cat',
            'hide_empty' => false,
            'orderby'    => 'id',
            'order'      => 'ASC',
        ) );
        $cat_array = array();
        if ( count( $wooCategory ) > 0 && is_array( $wooCategory ) ) {
            foreach ( $wooCategory as $term ) {
                $cat_array[$term->term_id] = trim( $term->name );
            }
        }
        return $cat_array;
    }

    /**
     * Get all woocommerce tags for admin area.
     *
     * @since    1.0.0
     *
     * @return array
     */
    public function wpfp_get_woocommerce_tag() {
        $wooTags = get_terms( 'product_tag' );
        $cat_array = array();
        if ( count( $wooTags ) > 0 && is_array( $wooTags ) ) {
            foreach ( $wooTags as $term ) {
                $cat_array[$term->term_id] = trim( $term->name );
            }
        }
        return $cat_array;
    }

    /**
     * Woocommerce all product attribute value list that is custom add or attribute section in product.
     *
     * @since    1.0.0
     *
     * @param      integer $wizard_id wizard id.
     *
     * @return array
     */
    public function wpfp_get_woocommerce_product_attribute_name_list( $wizard_id, $all_product_attribute ) {
        $wizard_id = ( isset( $wizard_id ) ? $wizard_id : '' );
        $merge_prd_attr = array();
        $product_attribute_array = array();
        $custom_attribute_array = array();
        if ( !empty( $all_product_attribute ) && is_array( $all_product_attribute ) ) {
            foreach ( $all_product_attribute as $key => $prd_attr_ser ) {
                $unserialize_prd_att = unserialize( $prd_attr_ser );
                // phpcs:ignore
                if ( !empty( $unserialize_prd_att ) && is_array( $unserialize_prd_att ) ) {
                    foreach ( $unserialize_prd_att as $un_key => $un_value ) {
                        if ( strpos( $un_key, 'pa_' ) !== false ) {
                            $product_attribute_array[$key] = $un_value['name'];
                        } else {
                            $custom_attribute_array[$key] = $un_value['name'];
                        }
                    }
                }
            }
        }
        $merge_prd_attr = array_merge( $product_attribute_array, $custom_attribute_array );
        $custom_product_attributes_name_arr = array();
        if ( !empty( $merge_prd_attr ) && is_array( $merge_prd_attr ) ) {
            foreach ( $merge_prd_attr as $author ) {
                $custom_product_attributes_name_arr[wc_attribute_label( $author ) . "==" . $author] = addslashes( wc_attribute_label( $author ) );
            }
        }
        return $custom_product_attributes_name_arr;
    }

    /**
     * Get category which is selected in particular wizard id.
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id.
     *
     * @return array
     */
    public function wpfp_get_category_which_is_selected_in_wizard( $wizard_id ) {
        global $wpdb;
        $wizard_category_arr = array();
        $get_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id=%d", $wizard_id ) );
        // phpcs:ignore
        if ( !empty( $get_rows ) && isset( $get_rows ) ) {
            $wizard_id = $get_rows->id;
            $wizard_category = $get_rows->wizard_category;
            if ( !empty( $wizard_category ) && isset( $wizard_category ) ) {
                $wizard_category_arr = explode( ',', $wizard_category );
                return $wizard_category_arr;
            }
        }
    }

    /**
     * Get tags which is selected in particular wizard id.
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id.
     *
     * @return array
     */
    public function wpfp_get_tags_which_is_selected_in_wizard( $wizard_id ) {
        global $wpdb;
        $get_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id=%d", $wizard_id ) );
        // phpcs:ignore
        if ( !empty( $get_rows ) && isset( $get_rows ) ) {
            $wizard_id = $get_rows->id;
            $wizard_tags = $get_rows->wizard_tags;
            if ( !empty( $wizard_tags ) && isset( $wizard_tags ) ) {
                $wizard_tags_arr = explode( ',', $wizard_tags );
                return $wizard_tags_arr;
            }
        }
    }

    /**
     * Woocommerce all product attribute value list based on attribute name.
     *
     * @since    1.0.0
     *
     * @return array
     */
    public function wpfp_get_attributes_value_based_on_attribute_name() {
        $attribute_value = filter_input( INPUT_POST, 'attribute_value', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $attribute_value = ( isset( $attribute_value ) ? sanitize_text_field( wp_unslash( stripslashes( $attribute_value ) ) ) : '' );
        $attribute_value_ex = explode( '|', $attribute_value );
        $dropdwon_list = '';
        $dropdwon_list .= '<option value=""></option>';
        if ( !empty( $attribute_value_ex ) && isset( $attribute_value_ex ) && is_array( $attribute_value_ex ) ) {
            foreach ( $attribute_value_ex as $final_value ) {
                $dropdwon_list .= '<option value="' . esc_attr( trim( $final_value ) ) . '">' . esc_html__( trim( $final_value ), 'woo-product-finder' ) . '</option>';
            }
        }
        echo wp_kses( $dropdwon_list, wpfp_allowed_html_tags() );
        wp_die();
    }

    /**
     * Display attribute value where chages attribute name
     *
     * @since    1.0.0
     *
     * @param int    $wizard_id      Wizard id
     *
     * @param string $attribute_name Attribute name
     */
    public function wpfp_display_attributes_value_based_on_attribute_name( $wizard_id, $attribute_name ) {
        global $wpdb;
        $attribute_name = trim( $attribute_name );
        $wizard_id = ( isset( $_REQUEST['current_wizard_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['current_wizard_id'] ) ) : '' );
        // phpcs:ignore
        $serialized_attribute_name = serialize( 'name' ) . serialize( $attribute_name );
        // phpcs:ignore
        $posts_table = $wpdb->prefix . 'posts';
        $post_meta_tabel = $wpdb->prefix . 'postmeta';
        $sel_qry = "";
        $sel_qry .= "SELECT ID,m1.meta_value";
        $sel_qry .= " FROM " . $posts_table . " p1";
        $sel_qry .= " INNER JOIN " . $post_meta_tabel . " m1";
        $sel_qry .= " ON ( p1.ID = m1.post_id )";
        $sel_qry .= " WHERE post_type ='product'";
        $sel_qry .= "AND ( m1.meta_key = '_product_attributes' )";
        $sel_qry .= "AND ( m1.meta_value != 'a:0:{}' )";
        $sel_qry .= " AND m1.meta_value LIKE '%" . addslashes( $serialized_attribute_name ) . "%'";
        $sel_qry .= " AND post_status = 'publish'";
        $prd_att_value_qry = $wpdb->get_results( $sel_qry );
        // phpcs:ignore
        $custom_product_attributes_arr = array();
        if ( !empty( $prd_att_value_qry ) && is_array( $prd_att_value_qry ) ) {
            foreach ( $prd_att_value_qry as $prd_attr_ser ) {
                foreach ( $prd_attr_ser as $prd_ser ) {
                    // phpcs:ignore
                    $unserialize_prd_att = unserialize( $prd_attr_ser->meta_value );
                    // phpcs:ignore
                    foreach ( $unserialize_prd_att as $un_key => $un_value ) {
                        if ( strpos( $un_key, 'pa_' ) !== false ) {
                            $values = wc_get_product_terms( $prd_attr_ser->ID, $un_value['name'], array(
                                'fields' => 'names',
                            ) );
                            $att_val = apply_filters(
                                'woocommerce_attribute',
                                wptexturize( implode( ' | ', $values ) ),
                                ' ',
                                $values
                            );
                            $att_val_ex = trim( $att_val );
                        } else {
                            $att_val_ex = trim( $un_value['value'] );
                        }
                        $custom_product_attributes_arr[$un_key] = $att_val_ex;
                    }
                }
            }
        }
        $all_attribute_value = array();
        $all_attribute_value_implode = array();
        if ( !empty( $custom_product_attributes_arr ) && isset( $custom_product_attributes_arr ) && is_array( $custom_product_attributes_arr ) ) {
            foreach ( $custom_product_attributes_arr as $arr_items => $arr_values ) {
                if ( trim( $attribute_name ) === trim( $arr_items ) ) {
                    $all_attribute_value[] = explode( '|', $arr_values );
                }
            }
        }
        ####### Implode array value #######
        if ( !empty( $all_attribute_value ) && isset( $all_attribute_value ) && is_array( $all_attribute_value ) ) {
            foreach ( $all_attribute_value as $innerValue ) {
                $all_attribute_value_implode[] = implode( ',', $innerValue );
            }
        }
        ####### Join Array value with comma #######
        $result_attribute_value = '';
        if ( !empty( $all_attribute_value_implode ) && isset( $all_attribute_value_implode ) && is_array( $all_attribute_value_implode ) ) {
            foreach ( $all_attribute_value_implode as $sub_array ) {
                $result_attribute_value .= $sub_array . ',';
            }
        }
        $result_attribute_value = trim( $result_attribute_value, ',' );
        return $result_attribute_value;
    }

    /**
     * Delete Option data from option page in admin area.
     *
     * @since    1.0.0
     */
    public function wpfp_remove_option_data_from_option_page() {
        global $wpdb;
        $option_id = ( isset( $_REQUEST['option_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['option_id'] ) ) : '' );
        // phpcs:ignore
        $questions_options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        $delete_result = $wpdb->delete( $questions_options_table_name, array(
            'id' => $option_id,
        ), array('%d') );
        // phpcs:ignore
        echo wp_kses_post( $delete_result );
        wp_die();
    }

    /**
     * Delete checked wizard id from wizard page.
     *
     * @since    1.0.0
     */
    public function wpfp_delete_selected_wizard_using_checkbox() {
        global $wpdb;
        $swi = filter_input(
            INPUT_POST,
            'selected_wizard_id',
            FILTER_DEFAULT,
            FILTER_REQUIRE_ARRAY
        );
        $selected_wizard_id = ( isset( $swi ) ? $swi : '' );
        $wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $questions_options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        $success_delete = array();
        if ( !empty( $selected_wizard_id ) && isset( $selected_wizard_id ) && is_array( $selected_wizard_id ) ) {
            foreach ( $selected_wizard_id as $value ) {
                $delete_wizard_result = $wpdb->delete( $wizard_table_name, array(
                    'id' => $value,
                ), array('%d') );
                // phpcs:ignore
                $delete_questions_result = $wpdb->delete( $questions_table_name, array(
                    'wizard_id' => $value,
                ), array('%d') );
                // phpcs:ignore
                $delete_options_result = $wpdb->delete( $questions_options_table_name, array(
                    'wizard_id' => $value,
                ), array('%d') );
                // phpcs:ignore
                $success_delete[] = $delete_wizard_result;
            }
            if ( in_array( 1, $success_delete, true ) ) {
                echo esc_html__( 'true', 'woo-product-finder' );
                wp_die();
            }
        }
    }

    /**
     * Delete single wizard id from wizard page.
     *
     * @since    1.0.0
     */
    public function wpfp_delete_single_wizard_using_button() {
        global $wpdb;
        $single_selected_wizard_id = ( isset( $_REQUEST['single_selected_wizard_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['single_selected_wizard_id'] ) ) : '' );
        // phpcs:ignore
        $wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $questions_options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        $delete_wizard_result = $wpdb->delete( $wizard_table_name, array(
            'id' => $single_selected_wizard_id,
        ), array('%d') );
        // phpcs:ignore
        $delete_questions_result = $wpdb->delete( $questions_table_name, array(
            'wizard_id' => $single_selected_wizard_id,
        ), array('%d') );
        // phpcs:ignore
        $delete_options_result = $wpdb->delete( $questions_options_table_name, array(
            'wizard_id' => $single_selected_wizard_id,
        ), array('%d') );
        // phpcs:ignore
        if ( $delete_wizard_result === 1 ) {
            echo esc_html__( 'true', 'woo-product-finder' );
            wp_die();
        }
    }

    /**
     * Delete selected questions from questions page.
     *
     * @since    1.0.0
     */
    public function wpfp_delete_selected_question_using_checkbox() {
        global $wpdb;
        $selected_question_id = filter_input(
            INPUT_POST,
            'selected_question_id',
            FILTER_DEFAULT,
            FILTER_REQUIRE_ARRAY
        );
        $selected_question_id = ( isset( $selected_question_id ) ? $selected_question_id : '' );
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $questions_options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        $success_delete = array();
        if ( !empty( $selected_question_id ) && isset( $selected_question_id ) && is_array( $selected_question_id ) ) {
            foreach ( $selected_question_id as $value ) {
                $delete_questions_result = $wpdb->delete( $questions_table_name, array(
                    'id' => $value,
                ), array('%d') );
                // phpcs:ignore
                $delete_options_result = $wpdb->delete( $questions_options_table_name, array(
                    'question_id' => $value,
                ), array('%d') );
                // phpcs:ignore
                $success_delete[] = $delete_questions_result;
            }
            if ( in_array( "1", $success_delete, true ) ) {
                echo esc_html__( 'true', 'woo-product-finder' );
                wp_die();
            }
        }
    }

    /**
     * Delete single question using delete button.
     *
     * @since    1.0.0
     */
    public function wpfp_delete_single_question_using_button() {
        global $wpdb;
        $single_selected_question_id = ( isset( $_REQUEST['single_selected_question_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['single_selected_question_id'] ) ) : '' );
        // phpcs:ignore
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $questions_options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        $delete_questions_result = $wpdb->delete( $questions_table_name, array(
            'id' => $single_selected_question_id,
        ), array('%d') );
        // phpcs:ignore
        $delete_options_result = $wpdb->delete( $questions_options_table_name, array(
            'question_id' => $single_selected_question_id,
        ), array('%d') );
        // phpcs:ignore
        if ( $delete_questions_result === '1' ) {
            echo esc_html__( 'true', 'woo-product-finder' );
            wp_die();
        }
    }

    /**
     * Save wizard data
     *
     * @since    1.0.0
     *
     * @param WP_Post $post
     */
    public function wpfp_wizard_save( $post, $extra_param, $wizard_id ) {
        global $wpdb;
        if ( empty( $post ) ) {
            return false;
        }
        $wcpfcnonce = wp_create_nonce( 'wppfcnonce' );
        $wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
        if ( isset( $post['wizard_status'] ) && !empty( $post['wizard_status'] ) ) {
            $wizard_status = 'on';
        } else {
            $wizard_status = 'off';
        }
        if ( isset( $post['wpfp_price_range_status'] ) && !empty( $post['wpfp_price_range_status'] ) ) {
            $wpfp_price_range_status = 'on';
        } else {
            $wpfp_price_range_status = 'off';
        }
        if ( isset( $post['wpfp_set_min_price_range'] ) && !empty( $post['wpfp_set_min_price_range'] ) ) {
            $wpfp_set_min_price_range = $post['wpfp_set_min_price_range'];
        } else {
            $wpfp_set_min_price_range = '0';
        }
        if ( isset( $post['wpfp_set_max_price_range'] ) && !empty( $post['wpfp_set_max_price_range'] ) ) {
            $wpfp_set_max_price_range = $post['wpfp_set_max_price_range'];
        } else {
            $wpfp_set_max_price_range = '1000';
        }
        $wpfp_set_both_price_range = $wpfp_set_min_price_range . '||' . $wpfp_set_max_price_range;
        if ( isset( $post['wizard_category'] ) && !empty( $post['wizard_category'] ) ) {
            $wizard_category = implode( ',', $post['wizard_category'] );
        } else {
            $wizard_category = '';
        }
        if ( isset( $post['wizard_tag'] ) && !empty( $post['wizard_tag'] ) ) {
            $wizard_tag = implode( ',', $post['wizard_tag'] );
        } else {
            $wizard_tag = '';
        }
        $perfect_match_title = '';
        $recent_match_title = '';
        $show_attribute_field = '';
        $backend_limit = '';
        $option_row_item = '';
        $text_color_wizard_title = '';
        $background_image_for_questions_upload_file = '';
        $background_color = '';
        $text_color = '';
        $background_color_for_options = '';
        $text_color_for_options = '';
        $reload_title = '';
        $next_title = '';
        $back_title = '';
        $show_result_title = '';
        $restart_title = '';
        $detail_title = '';
        $congratulations_title = '';
        $congratulations_message_title = '';
        $total_count_title = '';
        $background_np_button_color = '';
        $text_np_button_color = '';
        $show_other_result = '';
        $wizard_product_fields = 'title,thumbnail,attributes,add-to-cart';
        // Default fields to show
        $wizard_setting = array(
            'perfect_match_title'                        => $perfect_match_title,
            'recent_match_title'                         => $recent_match_title,
            'show_attribute_field'                       => $show_attribute_field,
            'backend_limit'                              => $backend_limit,
            'option_row_item'                            => $option_row_item,
            'text_color_wizard_title'                    => $text_color_wizard_title,
            'background_image_for_questions_upload_file' => $background_image_for_questions_upload_file,
            'background_color'                           => $background_color,
            'text_color'                                 => $text_color,
            'background_color_for_options'               => $background_color_for_options,
            'text_color_for_options'                     => $text_color_for_options,
            'reload_title'                               => $reload_title,
            'next_title'                                 => $next_title,
            'back_title'                                 => $back_title,
            'show_result_title'                          => $show_result_title,
            'restart_title'                              => $restart_title,
            'detail_title'                               => $detail_title,
            'congratulations_title'                      => $congratulations_title,
            'congratulations_message_title'              => $congratulations_message_title,
            'total_count_title'                          => $total_count_title,
            'background_np_button_color'                 => $background_np_button_color,
            'text_np_button_color'                       => $text_np_button_color,
            'show_other_result'                          => $show_other_result,
            'wizard_product_fields'                      => $wizard_product_fields,
            'option_product_list'                        => $option_product_list,
        );
        if ( $extra_param === 'add' ) {
            if ( isset( $post['wizard_title'] ) ) {
                if ( intval( $wizard_id ) === '' || 0 === intval( $wizard_id ) ) {
                    $wtn_max_sortable_number = $this->wpfp_get_wtn_max_sortabl_insert_time( $wizard_id );
                    $wpdb->query( $wpdb->prepare(
                        "INSERT INTO " . $wizard_table_name . "(  name, wizard_category, wizard_tags, wizard_price_range, wizard_setting, shortcode, sortable_id, status, range_status, created_date, updated_date  ) VALUES (  %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s  )",
                        trim( stripslashes( sanitize_text_field( $post['wizard_title'] ) ) ),
                        $wizard_category,
                        $wizard_tag,
                        $wpfp_set_both_price_range,
                        wp_json_encode( $wizard_setting ),
                        trim( sanitize_text_field( $post['wizard_shortcode'] ) ),
                        $wtn_max_sortable_number,
                        trim( $wizard_status ),
                        trim( $wpfp_price_range_status ),
                        gmdate( "Y-m-d H:i:s" ),
                        gmdate( "Y-m-d H:i:s" )
                    ) );
                    // phpcs:ignore
                    $last_wizard_id = $wpdb->insert_id;
                } else {
                    $check_wizard_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id = %d AND shortcode = %s", intval( $wizard_id ), trim( sanitize_text_field( $post['wizard_shortcode'] ) ) ) );
                    // phpcs:ignore
                    if ( !empty( $check_options_rows ) ) {
                        // phpcs:ignore
                        $wpdb->query( $wpdb->prepare(
                            "UPDATE {$wpdb->prefix}wpfp_wizard SET name = %s, wizard_category=%s, wizard_tags=%s, wizard_price_range=%s, wizard_setting=%s, shortcode=%s, status=%s, range_status=%s, created_date=%s, updated_date=%s WHERE id = %d",
                            trim( stripslashes( sanitize_text_field( $post['wizard_title'] ) ) ),
                            $wizard_category,
                            $wizard_tag,
                            $wpfp_set_both_price_range,
                            '',
                            trim( sanitize_text_field( $post['wizard_shortcode'] ) ),
                            trim( $wizard_status ),
                            trim( $wpfp_price_range_status ),
                            gmdate( "Y-m-d H:i:s" ),
                            gmdate( "Y-m-d H:i:s" ),
                            intval( $wizard_id )
                        ) );
                        // phpcs:ignore
                        $last_wizard_id = intval( sanitize_text_field( wp_unslash( $wizard_id ) ) );
                    } else {
                        $get_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id=%d", $wizard_id ) );
                        // phpcs:ignore
                        if ( !empty( $get_rows ) && isset( $get_rows ) ) {
                            $get_wizard_id = esc_attr( $get_rows->id );
                            $wizard_shortcode = esc_attr( $get_rows->shortcode );
                        }
                        $wtn_update_sortable_number = $this->wpfp_get_wtn_last_max_sortabl_update( $wizard_id );
                        $wpdb->query( $wpdb->prepare(
                            "UPDATE {$wpdb->prefix}wpfp_wizard SET name = %s, wizard_category=%s, wizard_tags=%s, wizard_price_range=%s, shortcode=%s, sortable_id=%s, status=%s, range_status=%s, created_date=%s, updated_date=%s WHERE id = %d",
                            trim( stripslashes( sanitize_text_field( $post['wizard_title'] ) ) ),
                            $wizard_category,
                            $wizard_tag,
                            $wpfp_set_both_price_range,
                            trim( sanitize_text_field( $wizard_shortcode ) ),
                            $wtn_update_sortable_number,
                            trim( $wizard_status ),
                            trim( $wpfp_price_range_status ),
                            gmdate( "Y-m-d H:i:s" ),
                            gmdate( "Y-m-d H:i:s" ),
                            intval( $get_wizard_id )
                        ) );
                        // phpcs:ignore
                        $last_wizard_id = intval( sanitize_text_field( wp_unslash( $wizard_id ) ) );
                    }
                }
            }
        } else {
            $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpfp_wizard SET wizard_setting=%s WHERE id = %d", wp_json_encode( $wizard_setting ), intval( $wizard_id ) ) );
            // phpcs:ignore
            $last_wizard_id = intval( sanitize_text_field( wp_unslash( $wizard_id ) ) );
        }
        if ( $extra_param === 'add' ) {
            $latest_url = esc_url( home_url( '/wp-admin/admin.php?page=wpfp-edit-wizard&wrd_id=' . esc_attr( $last_wizard_id ) . '&action=edit&_wpnonce=' . esc_attr( $wcpfcnonce ) ) );
        } else {
            $latest_url = esc_url( home_url( '/wp-admin/admin.php?page=wpfp-wizard-setting&wrd_id=' . esc_attr( $last_wizard_id ) . '&action=setting&_wpnonce=' . esc_attr( $wcpfcnonce ) ) );
        }
        $newUrl = html_entity_decode( $latest_url );
        wp_safe_redirect( $newUrl );
        exit;
    }

    /**
     * Save question data
     *
     * @since    1.0.0
     *
     * @param varchar $post      check post or not.
     *
     * @param int     $wizard_id which questions are saved for wizard.
     */
    public function wpfp_wizard_question_save( $post, $wizard_id ) {
        global $wpdb;
        if ( empty( $post ) ) {
            return false;
        }
        $wppfcnonce = wp_create_nonce( 'wppfcnonce' );
        if ( isset( $post['question_type'] ) ) {
            $question_type = sanitize_text_field( wp_unslash( $post['question_type'] ) );
        }
        if ( isset( $post['question_name'] ) ) {
            if ( $post['question_id'] === '' ) {
                $max_sortable_number = $this->wpfp_get_last_max_sortabl_question_insert_time( $wizard_id );
                $wpdb->query( $wpdb->prepare(
                    "INSERT INTO {$wpdb->prefix}wpfp_questions (  name, wizard_id, option_type, sortable_id, created_date, updated_date  ) VALUES (  %s, %d, %s, %d, %s, %s  )",
                    trim( stripslashes( sanitize_text_field( wp_unslash( $post['question_name'] ) ) ) ),
                    trim( $wizard_id ),
                    trim( $question_type ),
                    trim( $max_sortable_number ),
                    gmdate( "Y-m-d H:i:s" ),
                    gmdate( "Y-m-d H:i:s" )
                ) );
                // phpcs:ignore
                $last_question_id = $wpdb->insert_id;
                $this->wpfp_wizard_options_save(
                    $post['options_id'],
                    $post['options_name'],
                    $post['hf_option_single_upload_file_src'],
                    $post['attribute_name'],
                    $post['attribute_value'],
                    $post['attribute_next'],
                    $wizard_id,
                    $last_question_id
                );
            } else {
                $wpdb->query( $wpdb->prepare(
                    "UPDATE {$wpdb->prefix}wpfp_questions SET name = %s, option_type=%s, created_date=%s, updated_date=%s WHERE id = %d AND wizard_id = %d",
                    trim( stripslashes( $post['question_name'] ) ),
                    trim( $question_type ),
                    gmdate( "Y-m-d H:i:s" ),
                    gmdate( "Y-m-d H:i:s" ),
                    $post['question_id'],
                    $wizard_id
                ) );
                // phpcs:ignore
                $this->wpfp_wizard_options_save(
                    $post['options_id'],
                    $post['options_name'],
                    $post['hf_option_single_upload_file_src'],
                    $post['attribute_name'],
                    $post['attribute_value'],
                    $post['attribute_next'],
                    $wizard_id,
                    $post['question_id']
                );
                $last_question_id = sanitize_text_field( wp_unslash( $post['question_id'] ) );
            }
        }
        $latest_url = esc_url( home_url( '/wp-admin/admin.php?page=wpfp-add-new-question&wrd_id=' . esc_attr( $wizard_id ) . '&que_id=' . esc_attr( $last_question_id ) . '&action=edit&_wpnonce=' . wp_kses_post( $wppfcnonce ) ) );
        $newUrl = html_entity_decode( $latest_url );
        wp_safe_redirect( $newUrl );
        exit;
    }

    /**
     * Get last sortable id before updated new wizard sortable record
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id.
     *
     * @return int
     */
    public function wpfp_get_last_max_sortabl_question_insert_time( $wizard_id ) {
        global $wpdb;
        $sel_results = $wpdb->get_row( $wpdb->prepare( "SELECT MAX( sortable_id ) AS max FROM {$wpdb->prefix}wpfp_questions WHERE wizard_id=%d", $wizard_id ) );
        // phpcs:ignore
        $max_question_sortable_number = $sel_results->max;
        $max_question_sortable_number++;
        return $max_question_sortable_number;
    }

    /**
     * Get last sortable id before updated new wizard sortable record
     *
     * @since    1.0.0
     *
     * @param int $wizard_id wizard id.
     *
     * @return int
     */
    public function wpfp_get_wtn_max_sortabl_insert_time() {
        global $wpdb;
        $sel_results = $wpdb->get_row( $wpdb->prepare( "SELECT MAX( sortable_id ) AS max FROM {$wpdb->prefix}wpfp_wizard WHERE 1=%d", 1 ) );
        // phpcs:ignore
        $max_sortable_number = $sel_results->max;
        $max_sortable_number++;
        return $max_sortable_number;
    }

    /**
     * After drag and drop updated new sortable wizard
     *
     * @since    1.0.0
     *
     * @param int $wizard_id   wizard id.
     *
     *
     * @return int
     */
    public function wpfp_get_wtn_last_max_sortabl_update( $wizard_id ) {
        global $wpdb;
        $sel_results = $wpdb->get_row( $wpdb->prepare( "SELECT sortable_id FROM {$wpdb->prefix}wpfp_wizard WHERE id = %d", $wizard_id ) );
        // phpcs:ignore
        $current_wizard_sortable_number = $sel_results->sortable_id;
        return $current_wizard_sortable_number;
    }

    /**
     * Save options data
     *
     * @since    1.0.0
     *
     * @param varchar $post                             check post or not.
     *
     * @param int     $options_id                       posted option id
     *
     * @param string  $options_name                     which posted option name
     *
     * @param image   $hf_option_single_upload_file_src posted option image
     *
     * @param string  $attribute_name                   posted attribute name
     *
     * @param string  $attribute_value                  posted attribute value
     *
     * @param int     $wizard_id                        which options are saved for wizard.
     *
     * @param int     $questions_id                     which options are saved for questions.
     */
    public function wpfp_wizard_options_save(
        $options_id,
        $options_name,
        $hf_option_single_upload_file_src,
        $attribute_name,
        $attribute_value,
        $attribute_next,
        $wizard_id,
        $questions_id
    ) {
        global $wpdb;
        $final_results = array();
        $main_options_id = $options_id;
        $main_options_name = $options_name;
        $main_options_image = ( isset( $hf_option_single_upload_file_src ) ? $hf_option_single_upload_file_src : array() );
        $main_attribute_name = $attribute_name;
        $main_attributr_value = $attribute_value;
        $main_attributr_next = $attribute_next;
        if ( !empty( $main_options_id ) ) {
            foreach ( $main_options_id as $main_options_id_value ) {
                foreach ( $main_options_id_value as $options_key => $options_value ) {
                    if ( !empty( $main_options_name ) ) {
                        foreach ( $main_options_name as $main_options_name_value ) {
                            foreach ( $main_options_name_value as $options_name_key => $options_name_value ) {
                                if ( !empty( $main_options_image ) ) {
                                    foreach ( $main_options_image as $options_image ) {
                                        foreach ( $options_image as $oi_key => $oi_value ) {
                                            if ( !empty( $main_attribute_name ) ) {
                                                foreach ( $main_attribute_name as $attribute_name ) {
                                                    foreach ( $attribute_name as $an_key => $an_value ) {
                                                        if ( !empty( $main_attributr_value ) ) {
                                                            $original_attributr_value = '';
                                                            foreach ( $main_attributr_value as $attributr_value ) {
                                                                foreach ( $attributr_value as $av_key => $av_value ) {
                                                                    if ( !empty( $main_attributr_next ) ) {
                                                                        foreach ( $main_attributr_next as $attributr_next ) {
                                                                            foreach ( $attributr_next as $ann_key => $ann_value ) {
                                                                                if ( $options_key === $options_name_key && $options_key === $an_key && $options_key === $av_key && $options_key === $ann_key && $options_key === $oi_key && $options_name_key === $an_key && $options_name_key === $av_key && $options_name_key === $ann_key && $options_name_key === $oi_key && $an_key === $av_key && $an_key === $ann_key && $an_key === $oi_key && $av_key === $oi_key && $ann_key === $oi_key ) {
                                                                                    $original_attributr_value .= ',' . $av_value;
                                                                                    $final_results[$options_key][$options_value] = trim( $options_name_value ) . "||" . trim( $oi_value ) . "||" . trim( $an_value ) . "||" . ltrim( $original_attributr_value . "||" . trim( $ann_value ), ',' );
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
                    }
                }
            }
        }
        $result_option = '';
        if ( isset( $final_results ) && is_array( $final_results ) ) {
            foreach ( $final_results as $value ) {
                foreach ( $value as $v_key => $v_value ) {
                    if ( $v_key === '' ) {
                        $max_option_sortable_number = $this->wpfp_get_last_max_sortabl_option_insert_time( $wizard_id, $questions_id );
                        $other_option_data = explode( '||', trim( $v_value ) );
                        $option_name = $this->wpfp_replace_slash( $other_option_data[0] );
                        $option_image = $this->wpfp_replace_slash( $other_option_data[1] );
                        $other_option_data_ex = explode( '==', $other_option_data[2] );
                        $option_attribute = $this->wpfp_replace_slash( $other_option_data_ex[0] );
                        $option_attribute_db = $this->wpfp_replace_slash( $other_option_data_ex[1] );
                        $option_attribute_value = $this->wpfp_replace_slash( $other_option_data[3] );
                        $option_attribute_next = $this->wpfp_replace_slash( $other_option_data[4] );
                        $result_option .= $wpdb->query( $wpdb->prepare(
                            "INSERT INTO {$wpdb->prefix}wpfp_questions_options (  wizard_id, question_id, option_name,option_image, option_attribute, option_attribute_db, option_attribute_value, option_attribute_next, sortable_id, created_date, updated_date  ) VALUES (  %d, %d, %s,%s ,%s, %s, %s, %s, %d, %s, %s  )",
                            trim( $wizard_id ),
                            trim( $questions_id ),
                            stripslashes( trim( $option_name ) ),
                            stripslashes( trim( $option_image ) ),
                            stripslashes( trim( $option_attribute ) ),
                            stripslashes( trim( $option_attribute_db ) ),
                            stripslashes( trim( $option_attribute_value ) ),
                            trim( $option_attribute_next ),
                            trim( $max_option_sortable_number ),
                            gmdate( "Y-m-d H:i:s" ),
                            gmdate( "Y-m-d H:i:s" )
                        ) );
                        // phpcs:ignore
                    }
                }
            }
            if ( !empty( $final_results ) && is_array( $final_results ) ) {
                foreach ( $final_results as $value ) {
                    foreach ( $value as $v_key => $v_value ) {
                        $check_options_rows = $wpdb->get_row( $wpdb->prepare(
                            "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id = %d AND question_id = %d AND id = %d",
                            $wizard_id,
                            $questions_id,
                            $v_key
                        ) );
                        // phpcs:ignore
                        if ( !empty( $check_options_rows ) ) {
                            $exist_option_id = $check_options_rows->id;
                            if ( !empty( $exist_option_id ) && $exist_option_id !== '' ) {
                                $other_option_data = explode( '||', trim( $v_value ) );
                                $option_name = $this->wpfp_replace_slash( $other_option_data[0] );
                                $option_image = $this->wpfp_replace_slash( $other_option_data[1] );
                                $other_option_data_ex = explode( '==', $other_option_data[2] );
                                $option_attribute = $this->wpfp_replace_slash( $other_option_data_ex[0] );
                                $option_attribute_db = $this->wpfp_replace_slash( $other_option_data_ex[1] );
                                $option_attribute_value = $this->wpfp_replace_slash( $other_option_data[3] );
                                $option_attribute_next = $this->wpfp_replace_slash( $other_option_data[4] );
                                $result_option .= $wpdb->query( $wpdb->prepare(
                                    "UPDATE {$wpdb->prefix}wpfp_questions_options SET option_name = %s, option_image=%s, option_attribute=%s, option_attribute_db=%s, option_attribute_value=%s, option_attribute_next=%s, created_date=%s, updated_date=%s WHERE id = %d AND wizard_id = %d AND question_id = %d",
                                    stripslashes( trim( $option_name ) ),
                                    stripslashes( trim( $option_image ) ),
                                    stripslashes( trim( $option_attribute ) ),
                                    stripslashes( trim( $option_attribute_db ) ),
                                    stripslashes( trim( $option_attribute_value ) ),
                                    stripslashes( trim( $option_attribute_next ) ),
                                    gmdate( "Y-m-d H:i:s" ),
                                    gmdate( "Y-m-d H:i:s" ),
                                    $v_key,
                                    $wizard_id,
                                    $questions_id
                                ) );
                                // phpcs:ignore
                            }
                        } else {
                            $other_option_data = explode( '||', trim( $v_value ) );
                            $option_name = $this->wpfp_replace_slash( $other_option_data[0] );
                            $option_image = $this->wpfp_replace_slash( $other_option_data[1] );
                            $other_option_data_ex = explode( '==', $other_option_data[2] );
                            $option_attribute = $this->wpfp_replace_slash( $other_option_data_ex[0] );
                            $option_attribute_db = $this->wpfp_replace_slash( $other_option_data_ex[1] );
                            $option_attribute_value = $this->wpfp_replace_slash( $other_option_data[3] );
                            $max_option_sortable_number = $this->wpfp_get_last_max_sortabl_option_insert_time( $wizard_id, $questions_id );
                            $result_option .= $wpdb->query( $wpdb->prepare(
                                "INSERT INTO {$wpdb->prefix}wpfp_questions_options (  wizard_id, question_id, option_name,option_image, option_attribute, option_attribute_db, option_attribute_value, sortable_id, created_date, updated_date  ) VALUES (  %d, %d, %s, %s,%s, %s, %s, %d, %s, %s  )",
                                trim( $wizard_id ),
                                trim( $questions_id ),
                                stripslashes( trim( $option_name ) ),
                                stripslashes( trim( $option_image ) ),
                                stripslashes( trim( $option_attribute ) ),
                                stripslashes( trim( $option_attribute_db ) ),
                                stripslashes( trim( $option_attribute_value ) ),
                                trim( $max_option_sortable_number ),
                                gmdate( "Y-m-d H:i:s" ),
                                gmdate( "Y-m-d H:i:s" )
                            ) );
                            // phpcs:ignore
                        }
                    }
                }
            }
        }
        return $result_option;
    }

    /**
     * Get last sortable question id before updated new questions sortable record
     *
     * @since    1.0.0
     *
     * @param int $wizard_id   wizard id.
     *
     * @param int $question_id question id.
     *
     * @return int
     */
    public function wpfp_get_last_max_sortabl_option_insert_time( $wizard_id, $question_id ) {
        global $wpdb;
        $options_table_name = WPFPFW_OPTIONS_PRO_TABLE;
        $sel_qry = $wpdb->prepare( 'SELECT MAX( sortable_id ) AS max FROM ' . $options_table_name . ' WHERE wizard_id = %d AND question_id = %d', $wizard_id, $question_id );
        // phpcs:ignore
        $sel_results = $wpdb->get_row( $sel_qry );
        // phpcs:ignore
        $max_option_sortable_number = $sel_results->max;
        $max_option_sortable_number++;
        return $max_option_sortable_number;
    }

    /**
     * Replace slash
     *
     * @since    1.0.0
     *
     * @param string $string .
     *
     * @return array
     */
    public function wpfp_replace_slash( $string_var ) {
        return preg_replace( '/\\\\/', '', $string_var );
    }

    /**
     * After drag and drop updated new sortable question id
     *
     * @since    1.0.0
     *
     * @param int $wizard_id   wizard id.
     *
     * @param int $question_id question id.
     *
     * @return int
     */
    public function wpfp_get_last_max_sortabl_question_insert_update( $wizard_id, $question_id ) {
        global $wpdb;
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $sel_qry = $wpdb->prepare( 'SELECT sortable_id FROM ' . $questions_table_name . ' WHERE wizard_id=%d AND id = %d', $wizard_id, $question_id );
        // phpcs:ignore
        $sel_results = $wpdb->get_row( $sel_qry );
        // phpcs:ignore
        $current_question_sortable_number = $sel_results->sortable_id;
        return $current_question_sortable_number;
    }

    /**
     * Add custom css for dotstore icon in admin area
     *
     * @since  1.0.0
     *
     */
    public function wpfp_dot_store_icon_css() {
        echo '<style>
	    .toplevel_page_dots_store .dashicons-marker::after{content:"";border:3px solid;position:absolute;top:14px;left:15px;border-radius:50%;opacity: 0.6;}
	    li.toplevel_page_dots_store:hover .dashicons-marker::after,li.toplevel_page_dots_store.current .dashicons-marker::after{opacity: 1;}
	    @media only screen and (max-width: 960px){
	    	.toplevel_page_dots_store .dashicons-marker::after{left:14px;}
	    }
	  	</style>';
    }

    /**
     * Questions list with pagination
     *
     * @since    1.0.0
     *
     * @return html Its return html
     */
    public function wpfp_get_admin_question_list_with_pagination() {
        global $wpdb;
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        if ( isset( $_REQUEST["wizard_id"] ) && !empty( $_REQUEST['wizard_id'] ) ) {
            // phpcs:ignore
            $wizard_id = sanitize_text_field( wp_unslash( $_REQUEST["wizard_id"] ) );
            // phpcs:ignore
        } else {
            $wizard_id = '';
        }
        if ( isset( $_REQUEST["pagenum"] ) && !empty( $_REQUEST['pagenum'] ) ) {
            // phpcs:ignore
            $page = intval( sanitize_text_field( wp_unslash( $_REQUEST['pagenum'] ) ) );
            // phpcs:ignore
        } else {
            $page = 1;
        }
        if ( isset( $_REQUEST["limit"] ) ) {
            // phpcs:ignore
            $limit = ( sanitize_text_field( wp_unslash( $_REQUEST["limit"] ) ) != "" && is_numeric( sanitize_text_field( wp_unslash( $_REQUEST["limit"] ) ) ) ? intval( sanitize_text_field( wp_unslash( $_REQUEST["limit"] ) ) ) : 5 );
            // phpcs:ignore
        } else {
            $limit = 1;
        }
        $sel_page_qry = $wpdb->prepare( 'SELECT COUNT( * ) AS total_id FROM ' . $questions_table_name . ' WHERE wizard_id = %d', $wizard_id );
        // phpcs:ignore
        $page_result = $wpdb->get_row( $sel_page_qry );
        // phpcs:ignore
        $total_records = $page_result->total_id;
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
        $sel_qry = $wpdb->prepare(
            'SELECT * FROM ' . $questions_table_name . ' WHERE wizard_id = %d ORDER BY sortable_id ASC LIMIT %d, %d',
            $wizard_id,
            $lower_limit,
            $limit
        );
        // phpcs:ignore
        $sel_rows = $wpdb->get_results( $sel_qry );
        // phpcs:ignore
        $pagination_question_list = '';
        $pagination_question_list .= '<table class="table-outer form-table all-table-listing" id="question_list_table">';
        $pagination_question_list .= '<thead>';
        $pagination_question_list .= '<tr class="wpfp-head">';
        $pagination_question_list .= '<th><input type="checkbox" name="check_all" class="chk_all_question_class" id="chk_all_question"/></th>';
        $pagination_question_list .= '<th>' . esc_html__( 'Name', 'woo-product-finder' ) . '</th>';
        $pagination_question_list .= '<th>' . esc_html__( 'Type', 'woo-product-finder' ) . '</th>';
        $pagination_question_list .= '<th>' . esc_html__( 'Action', 'woo-product-finder' ) . '</th>';
        $pagination_question_list .= '</tr>';
        $pagination_question_list .= '</thead>';
        $pagination_question_list .= '<tbody>';
        if ( !empty( $sel_rows ) && is_array( $sel_rows ) ) {
            $i = 1;
            foreach ( $sel_rows as $sel_data ) {
                $question_id = $sel_data->id;
                $wizard_id = $sel_data->wizard_id;
                $question_name = $sel_data->name;
                $question_type = ucfirst( $sel_data->option_type );
                $wprwnonce = wp_create_nonce( 'wppfcnonce' );
                $edit_url = esc_url( home_url( '/wp-admin/admin.php?page=wpfp-add-new-question&wrd_id=' . esc_attr( $wizard_id ) . '&que_id=' . esc_attr( $question_id ) . '&action=edit' . '&_wpnonce=' . esc_attr( $wprwnonce ) ) );
                $new_edit_url = html_entity_decode( $edit_url );
                $pagination_question_list .= '<tr id="after_updated_question_' . esc_attr( $question_id ) . '">';
                $pagination_question_list .= '<td width="10%">';
                $pagination_question_list .= '<input type="checkbox" name="chk_single_question_name" class="chk_single_question" value="' . esc_attr( $question_id ) . '">';
                $pagination_question_list .= '</td>';
                $pagination_question_list .= '<td>';
                $pagination_question_list .= '<a href="' . esc_url( $new_edit_url ) . '">' . esc_html__( $question_name, 'woo-product-finder' ) . '</a>';
                $pagination_question_list .= '</td>';
                $pagination_question_list .= '<td>' . wp_kses_post( $question_type ) . '</td>';
                $pagination_question_list .= '<td>';
                $pagination_question_list .= '<a class="fee-action-button button-secondary" href="' . esc_url( $new_edit_url ) . '" id="questions_edit_' . esc_attr( $question_id ) . '">' . esc_html__( 'Edit', 'woo-product-finder' ) . '</a>';
                $pagination_question_list .= '<a class="fee-action-button button-secondary delete_single_question_using_button" href="#" id="delete_single_selected_question_' . esc_attr( $question_id ) . '">' . esc_html__( 'Delete', 'woo-product-finder' ) . '</a>';
                $pagination_question_list .= '</td>';
                $pagination_question_list .= '</tr>';
                $i++;
            }
        } else {
            $pagination_question_list .= '<tr>';
            $pagination_question_list .= '<td colspan="4">' . esc_html__( 'No List Available', 'woo-product-finder' ) . '</td>';
            $pagination_question_list .= '</tr>';
        }
        $pagination_question_list .= '</tbody>';
        $pagination_question_list .= '</table>';
        $pagination_question_list .= $this->wpfp_admin_ajax_pagination(
            $wizard_id,
            $limit,
            $page,
            $last,
            $total_records
        );
        $allowed_html = wp_kses_allowed_html( 'post' );
        $allowed_input_html = array(
            'input' => array(
                'id'    => array(),
                'type'  => array(),
                'name'  => array(),
                'class' => array(),
                'value' => array(),
            ),
        );
        $f_array = array_merge( $allowed_html, $allowed_input_html );
        echo wp_kses( $pagination_question_list, $f_array );
        wp_die();
    }

    /**
     * Ajax Pagination
     *
     * @since    1.0.0
     *
     * @param varchar $post          check post or not.
     *
     * @param int     $wizard_id     which options are saved for wizard.
     *
     * @param int     $limit         which how many data display in list.
     *
     * @param int     $page          Current page id
     *
     * @param int     $last          Last page id
     *
     * @param int     $total_records Total data
     *
     * @return html Its return html
     */
    public function wpfp_admin_ajax_pagination(
        $wizard_id,
        $limit,
        $page,
        $last,
        $total_records
    ) {
        $pagination_list = '';
        $pagination_list .= '<div class="tablenav">';
        $pagination_list .= '<div class="tablenav-pages" id="custom_pagination">';
        $pagination_list .= '<span class="displaying-num">' . wp_kses_post( $total_records ) . ' items</span>';
        $pagination_list .= '<span class="pagination-links">';
        $page_minus = $page - 1;
        $page_plus = $page + 1;
        if ( $page_minus > 0 ) {
            $pagination_list .= '<a class="first-page" href="javascript:void( 0 );" class="links" id="wd_' . esc_attr( $wizard_id ) . '_lmt_' . esc_attr( $limit ) . '_que_1">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'First page', 'woo-product-finder' ) . '</span><span aria-hidden="true" id="wd_' . esc_attr( $wizard_id ) . '_lmt_' . esc_attr( $limit ) . '_que_1" class="pagination_span">&#171;</span></a>';
            $pagination_list .= '<a class="prev-page" href="javascript:void( 0 );" class="links" id="wd_' . esc_attr( $wizard_id ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $page_minus ) . '">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'Previous page', 'woo-product-finder' ) . '</span><span aria-hidden="true" id="wd_' . esc_attr( $wizard_id ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $page_minus ) . '" class="pagination_span">&#8249;</span></a>';
        }
        $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'Current Page', 'woo-product-finder' ) . '</span>';
        $pagination_list .= '<span id="table-paging" class="paging-input"><span class="tablenav-paging-text">' . esc_html( $page ) . esc_html__( ' of ', 'woo-product-finder' ) . '<span class="total-pages">' . esc_html( $last ) . '</span></span></span>';
        if ( $page_plus <= $last ) {
            $pagination_list .= '<a class="next-page" href="javascript:void( 0 );" id="wd_' . esc_attr( $wizard_id ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $page_plus ) . '" class="links">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'Next page', 'woo-product-finder' ) . '</span><span aria-hidden="true" id="wd_' . esc_attr( $wizard_id ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $page_plus ) . '" class="pagination_span">&#8250;</span>';
            $pagination_list .= '</a>';
        }
        if ( $page !== $last ) {
            $pagination_list .= '<a class="last-page"href="javascript:void( 0 );" id="wd_' . esc_attr( $wizard_id ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $last ) . '" class="links">';
            $pagination_list .= '<span class="screen-reader-text">' . esc_html__( 'Last page', 'woo-product-finder' ) . '</span><span aria-hidden="true" id="wd_' . esc_attr( $wizard_id ) . '_lmt_' . esc_attr( $limit ) . '_que_' . esc_attr( $last ) . '" class="pagination_span">&#187;</span>';
            $pagination_list .= '</a>';
        }
        $pagination_list .= '</span>';
        $pagination_list .= '</div>';
        $pagination_list .= '</div>';
        return wp_kses_post( $pagination_list );
    }

    /**
     * Current auto increment id for wizard table
     *
     * @since    1.0.0
     *
     * @param string $table_name Wizard table name.
     *
     * @return int
     */
    public function wpfp_get_current_auto_increment_id( $table_name ) {
        global $wpdb;
        $tb_auto_incr = $wpdb->get_results( 'SELECT id FROM ' . $table_name . ' ORDER BY id DESC LIMIT 0, 1' );
        // phpcs:ignore
        if ( isset( $tb_auto_incr[0]->id ) && !empty( $tb_auto_incr[0]->id ) ) {
            $current_auto_incr_id = (int) $tb_auto_incr[0]->id + 1;
        } else {
            $current_auto_incr_id = 1;
        }
        return $current_auto_incr_id;
    }

    /**
     * Generate auto shortcode
     *
     * @since    1.0.0
     *
     * @param int $current_auto_incr_id Current auto increment wizard id.
     *
     * @return string
     */
    public function wpfp_create_wizard_shortcode( $current_auto_incr_id ) {
        $current_shortcode = '[wpfp_' . $current_auto_incr_id . ']';
        return $current_shortcode;
    }

    /**
     * Drag and drop question list
     *
     * @since    1.0.0
     */
    public function wpfp_sortable_question_list_based_on_id() {
        global $wpdb;
        $wizard_id = ( isset( $_REQUEST['wizard_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wizard_id'] ) ) : '' );
        // phpcs:ignore
        $question_sortable_data = explode( ',', ( isset( $_REQUEST['question_sortable_data'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['question_sortable_data'] ) ) : '' ) );
        // phpcs:ignore
        $sel_results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id=%d ORDER BY id ASC", $wizard_id ) );
        // phpcs:ignore
        $i = 0;
        $j = 0;
        foreach ( $question_sortable_data as $value ) {
            foreach ( $sel_results as $sel_value ) {
                $question_id = $sel_value->id;
                if ( $value === $question_id ) {
                    $j++;
                    $wpdb->query( $wpdb->prepare(
                        "UPDATE {$wpdb->prefix}wpfp_questions_options SET sortable_id = %d WHERE id = %d AND wizard_id = %d",
                        $j,
                        $question_id,
                        $wizard_id
                    ) );
                    // phpcs:ignore
                }
            }
            $i++;
        }
        wp_die();
    }

    /**
     * Drag and drop wizard list
     *
     * @since    1.0.0
     */
    public function wpfp_sortable_wizard_list_based_on_id() {
        global $wpdb;
        $wizard_sortable_data = explode( ',', ( isset( $_REQUEST['wizard_sortable_data'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wizard_sortable_data'] ) ) : '' ) );
        $wpfp_dafault_pagination_count = 10;
        $per_page = $wpfp_dafault_pagination_count;
        $paged = filter_input( INPUT_POST, 'pagenum', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $paged = ( $paged ? $paged : 1 );
        $per_page = ( !empty( $per_page ) || $per_page > 1 ? $per_page : 10 );
        $edit_start_at = $paged * $per_page - $per_page;
        $sel_results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard ORDER BY sortable_id DESC" ) );
        // phpcs:ignore
        $objects_ids = array();
        foreach ( $sel_results as $result ) {
            $objects_ids[] = (int) $result->id;
        }
        $objects_per_page = $wpfp_dafault_pagination_count;
        $edit_start_at = $paged * $objects_per_page - $objects_per_page;
        $index = 0;
        for ($i = $edit_start_at; $i < $edit_start_at + $objects_per_page; $i++) {
            if ( !isset( $objects_ids[$i] ) ) {
                break;
            }
            $objects_ids[$i] = (int) $wizard_sortable_data[$index];
            $index++;
        }
        $objects_ids = array_reverse( $objects_ids );
        foreach ( $objects_ids as $value => $key ) {
            $wpdb->query( $wpdb->prepare( "UPDATE {$wpdb->prefix}wpfp_wizard SET sortable_id = %d WHERE id = %d", $value, $key ) );
            // phpcs:ignore
        }
        wp_die();
    }

    /**
     * Sortable Option list based on option id
     *
     * @since    1.0.0
     */
    public function wpfp_sortable_option_list_based_on_id() {
        global $wpdb;
        $wizard_id = ( isset( $_REQUEST['wizard_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['wizard_id'] ) ) : '' );
        // phpcs:ignore
        $question_id = ( isset( $_REQUEST['question_id'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['question_id'] ) ) : '' );
        // phpcs:ignore
        $option_sortable_data = explode( ',', ( isset( $_REQUEST['option_sortable_data'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['option_sortable_data'] ) ) : '' ) );
        // phpcs:ignore
        $sel_results = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id=%d AND question_id=%d ORDER BY id ASC", $wizard_id, $question_id ) );
        // phpcs:ignore
        $i = 0;
        $j = 0;
        if ( isset( $option_sortable_data ) && is_array( $option_sortable_data ) ) {
            foreach ( $option_sortable_data as $value ) {
                foreach ( $sel_results as $sel_value ) {
                    $option_id = $sel_value->id;
                    if ( $value === $option_id ) {
                        $j++;
                        $wpdb->query( $wpdb->prepare(
                            "UPDATE {$wpdb->prefix}wpfp_questions_options SET sortable_id = %d WHERE id = %d AND question_id = %d AND wizard_id = %d",
                            $j,
                            $option_id,
                            $question_id,
                            $wizard_id
                        ) );
                        // phpcs:ignore
                    }
                }
                $i++;
            }
        }
        wp_die();
    }

    /**
     * After drag and drop updated new sortable option id
     *
     * @since    1.0.0
     *
     * @param int $wizard_id   wizard id.
     *
     * @param int $question_id question id.
     *
     * @param int $option_id   option id.
     *
     * @return int
     */
    public function wpfp_get_last_max_sortabl_option_insert_update( $wizard_id, $question_id, $option_id ) {
        global $wpdb;
        $sel_results = $wpdb->get_row( $wpdb->prepare(
            "SELECT sortable_id FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id = %d AND question_id = %d AND id = %d",
            $wizard_id,
            $question_id,
            $option_id
        ) );
        // phpcs:ignore
        $current_option_sortable_number = $sel_results->sortable_id;
        return $current_option_sortable_number;
    }

    /**
     * Replace slash
     *
     * @since    1.0.0
     *
     * @param get product in which attribute available.
     *
     * @return array
     */
    public function wpfp_product_in_which_attribute_avaiabale() {
        global $wpdb;
        $posts_table = $wpdb->prefix . 'posts';
        $post_meta_tabel = $wpdb->prefix . 'postmeta';
        $sel_qry = "";
        $sel_qry .= "SELECT ID,m1.meta_value";
        $sel_qry .= " FROM " . $posts_table . " p1";
        $sel_qry .= " INNER JOIN " . $post_meta_tabel . " m1";
        $sel_qry .= " ON ( p1.ID = m1.post_id )";
        $sel_qry .= " WHERE post_type ='product'";
        $sel_qry .= "AND ( m1.meta_key = '_product_attributes' )";
        $sel_qry .= "AND ( m1.meta_value != 'a:0:{}' )";
        $sel_qry .= " AND post_status = 'publish'";
        $prd_att_qry = $wpdb->get_results( $sel_qry );
        // phpcs:ignore
        $prd_atr_array = array();
        if ( !empty( $prd_att_qry ) && isset( $prd_att_qry ) ) {
            foreach ( $prd_att_qry as $author ) {
                $post_id = $author->ID;
                $attribute = $author->meta_value;
                $prd_atr_array[$post_id] = $attribute;
            }
        }
        return $prd_atr_array;
    }

    /**
     * Replace slash
     *
     * @since    1.0.0
     *
     * @param get product attribute name based on three character.
     *
     * @return array
     */
    public function wpfp_get_woocommerce_product_attribute_name_list_ajax() {
        global $wpdb;
        $wizard_id = ( isset( $_REQUEST['wizard_id'] ) ? sanitize_text_field( wp_unslash( trim( $_REQUEST['wizard_id'] ) ) ) : '' );
        // phpcs:ignore
        $wizard_category_arr = $this->wpfp_get_category_which_is_selected_in_wizard( $wizard_id );
        if ( !empty( $wizard_category_arr ) && isset( $wizard_category_arr ) ) {
            $wizard_category_implode = implode( ',', $wizard_category_arr );
        }
        $wizard_tags_arr = $this->wpfp_get_tags_which_is_selected_in_wizard( $wizard_id );
        $value = ( isset( $_REQUEST['value'] ) ? "pa_" . sanitize_text_field( wp_unslash( trim( $_REQUEST['value'] ) ) ) : '' );
        // phpcs:ignore
        $custom_avlue = ( isset( $_REQUEST['value'] ) ? "" . sanitize_text_field( wp_unslash( trim( $_REQUEST['value'] ) ) ) : '' );
        // phpcs:ignore
        $posts_table = $wpdb->prefix . 'posts';
        $post_meta_tabel = $wpdb->prefix . 'postmeta';
        $wp_terms = $wpdb->prefix . 'terms';
        $wp_term_relationships = $wpdb->prefix . 'term_relationships';
        $wp_term_taxonomy = $wpdb->prefix . 'term_taxonomy';
        $attribute_name_html = '';
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
        $sel_qry = "";
        $sel_qry .= "SELECT ID,m1.meta_value";
        $sel_qry .= " FROM " . $posts_table . " p1";
        $sel_qry .= " INNER JOIN " . $post_meta_tabel . " m1";
        $sel_qry .= " ON ( p1.ID = m1.post_id )";
        if ( !empty( $wizard_category_arr ) && isset( $wizard_category_arr ) ) {
            $sel_qry .= " LEFT JOIN " . $wp_term_relationships . " wtr ON wtr.object_id = p1.ID";
            $sel_qry .= " LEFT JOIN " . $wp_term_taxonomy . " ttx on ttx.term_taxonomy_id = wtr.term_taxonomy_id";
            $sel_qry .= " LEFT JOIN " . $wp_terms . " wt ON wt.term_id = wtr.term_taxonomy_id";
        }
        $sel_qry .= " WHERE post_type ='product'";
        if ( !empty( $wizard_category_arr ) && isset( $wizard_category_arr ) ) {
            $sel_qry .= " AND wt.term_id IN(" . $wizard_category_implode . ")";
        }
        if ( !empty( $wizard_tags_arr ) && isset( $wizard_tags_arr ) ) {
            $sel_qry .= " AND p1.ID IN(" . $post_ids . ")";
        }
        $sel_qry .= " AND ( m1.meta_key = '_product_attributes' )";
        $sel_qry .= " AND ( m1.meta_value != 'a:0:{}' )";
        $sel_qry .= " AND ( m1.meta_value LIKE '%" . $value . "%'";
        $sel_qry .= " OR m1.meta_value LIKE '%" . $custom_avlue . "%' )";
        $sel_qry .= " AND post_status = 'publish'";
        $prd_att_qry = $wpdb->get_results( $sel_qry );
        // phpcs:ignore
        $prd_atr_array = array();
        if ( !empty( $prd_att_qry ) && is_array( $prd_att_qry ) ) {
            foreach ( $prd_att_qry as $author ) {
                $post_id = $author->ID;
                $attribute = $author->meta_value;
                $prd_atr_array[$post_id] = $attribute;
            }
            $att_name_and_value_array = array();
            $custom_att_name_and_value_array = array();
            if ( !empty( $prd_att_qry ) && is_array( $prd_att_qry ) ) {
                foreach ( $prd_att_qry as $prd_attr_ser ) {
                    $unserialize_prd_att = unserialize( $prd_attr_ser->meta_value );
                    // phpcs:ignore
                    $custom_product_attributes_arr = array();
                    if ( isset( $unserialize_prd_att ) && is_array( $unserialize_prd_att ) ) {
                        foreach ( $unserialize_prd_att as $un_key => $un_value ) {
                            if ( strpos( $un_key, 'pa_' ) !== false ) {
                                $values = wc_get_product_terms( $prd_attr_ser->ID, $un_value['name'], array(
                                    'fields' => 'names',
                                ) );
                                $att_val = apply_filters(
                                    'woocommerce_attribute',
                                    wptexturize( implode( ' | ', $values ) ),
                                    ' ',
                                    $values
                                );
                                $att_val_ex = trim( $att_val );
                                if ( !empty( $att_val_ex ) ) {
                                    $att_name_and_value_array[$un_key][] = trim( $att_val_ex );
                                }
                            } else {
                                if ( !empty( $un_value['value'] ) ) {
                                    $custom_att_name_and_value_array[$un_key][] = $un_value['name'] . "==" . trim( $un_value['value'] );
                                }
                            }
                            $custom_product_attributes_arr[$un_key] = $att_val_ex;
                        }
                    }
                }
            }
            if ( !empty( $att_name_and_value_array ) && is_array( $att_name_and_value_array ) ) {
                foreach ( $att_name_and_value_array as $n_key => $n_value ) {
                    if ( !empty( $n_value ) ) {
                        $value_ex = array();
                        $value_simple = array();
                        foreach ( $n_value as $value ) {
                            if ( !empty( $value ) || $value !== '' ) {
                                if ( strpos( $value, ' | ' ) !== false ) {
                                    $value_ex[] = explode( ' | ', trim( $value ) );
                                } else {
                                    $value_simple[] = array(trim( $value ));
                                }
                            }
                        }
                        $nwe_value_arr = array();
                        $value_ex_array = array_merge( $value_ex, $value_simple );
                        foreach ( $value_ex_array as $value_ex_array_val ) {
                            foreach ( $value_ex_array_val as $n_sub_key => $n_sub_val ) {
                                // phpcs:ignore
                                $nwe_value_arr[] = trim( $n_sub_val );
                            }
                        }
                        $unique_array_value = array_unique( $nwe_value_arr );
                        $unique_array = implode( '|', $unique_array_value );
                    }
                    $attribute_name_html .= '<option value="' . addslashes( wc_attribute_label( $n_key ) ) . '==' . trim( $n_key ) . '" data-name="' . trim( $n_key ) . '" data-value1="' . esc_attr( $unique_array ) . '">' . wc_attribute_label( $n_key ) . '</option>';
                }
            }
            if ( !empty( $custom_att_name_and_value_array ) && is_array( $custom_att_name_and_value_array ) ) {
                foreach ( $custom_att_name_and_value_array as $c_n_key => $c_n_value ) {
                    foreach ( $c_n_value as $key => $value ) {
                        // phpcs:ignore
                        $val_ex = explode( "==", $value );
                        $attribute_name_html .= '<option value="' . addslashes( $val_ex[0] ) . '==' . trim( $c_n_key ) . '" data-name="' . trim( $c_n_key ) . '" data-value1="' . esc_attr( $val_ex[1] ) . '">' . $val_ex[0] . '</option>';
                    }
                }
            }
        }
        $attribute_name_html .= esc_html__( "No List found", 'woo-product-finder' );
        $allowed_html = wp_kses_allowed_html( 'post' );
        $allowed_input_html = array(
            'option' => array(
                'id'          => array(),
                'type'        => array(),
                'name'        => array(),
                'class'       => array(),
                'value'       => array(),
                'data-name'   => array(),
                'data-value1' => array(),
            ),
        );
        $f_array = array_merge( $allowed_html, $allowed_input_html );
        echo wp_kses( $attribute_name_html, $f_array );
        wp_die();
    }

    /**
     * Replace slash
     *
     * @since    1.0.0
     *
     * @param product.
     *
     * @return array
     */
    public function this_screen() {
        $current_screen = get_current_screen();
        if ( $current_screen->id === "product" ) {
            if ( isset( $_GET['action'] ) && $_GET['action'] === 'edit' ) {
                // phpcs:ignore
                $this->wpfp_delete_transient();
            }
        }
    }

    /**
     * Replace slash
     *
     * @since    1.0.0
     *
     * @param delet transient for attribute name when attribute add in attribute page or set product.
     *
     * @return array
     */
    public function wpfp_delete_transient() {
        global $wpdb;
        $sel_rows = $wpdb->get_results( "SELECT id FROM {$wpdb->prefix}wpfp_wizard ORDER BY created_date" );
        // phpcs:ignore
        if ( !empty( $sel_rows ) && isset( $sel_rows ) && is_array( $sel_rows ) ) {
            foreach ( $sel_rows as $sel_data ) {
                $wizard_id = esc_attr( $sel_data->id );
                if ( false !== get_site_transient( 'prd_att_qry' . $wizard_id ) ) {
                    delete_site_transient( 'prd_att_qry' . $wizard_id );
                }
            }
        }
    }

    /**
     * Search wizards
     */
    public function wpfp_search_wizards() {
        global $wpdb;
        $search = filter_input( INPUT_POST, 'search', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $sel_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE name LIKE %s ORDER BY sortable_id DESC", '%' . $search . '%' ) );
        // phpcs:ignore
        if ( !empty( $sel_rows ) && isset( $sel_rows ) && is_array( $sel_rows ) ) {
            $i = 1;
            foreach ( $sel_rows as $sel_data ) {
                $wizard_id = esc_attr( $sel_data->id );
                $wizard_title = esc_attr( $sel_data->name );
                $wizard_shortcode = esc_attr( $sel_data->shortcode );
                $wizard_status = esc_attr( $sel_data->status );
                $wpfpnonce = wp_create_nonce( 'wppfcnonce' );
                $msg .= '<tr id="wizard_row_' . esc_attr( $wizard_id ) . '">
					<td width="10%">
						<input type="checkbox" class="chk_single_wizard" name="chk_single_wizard_chk" value="' . esc_attr( $wizard_id ) . '">
					</td>
					<td>
						<a href="' . esc_url( home_url( "/wp-admin/admin.php?page=wpfp-edit-wizard&wrd_id=" . esc_attr( $wizard_id ) . "&action=edit" . "&_wpnonce=" . esc_attr( $wpfpnonce ) ) ) . '">' . esc_html__( $wizard_title, "woo-product-finder" ) . '</a>
					</td>
					<td>
						<input type="text" class="copy-shortcode" value="' . esc_attr( $wizard_shortcode ) . '" readonly="">
					</td>
					<td>';
                if ( !empty( esc_attr( $wizard_status ) ) && esc_attr( $wizard_status ) === 'on' ) {
                    $msg .= '<span class="active-status">' . esc_html__( 'Enabled', 'woo-product-finder' ) . '</span>';
                } else {
                    $msg .= '<span class="inactive-status">' . esc_html__( 'Disabled', 'woo-product-finder' ) . '</span>';
                }
                $msg .= '</td>
					<td>
						<div class="wpf-action">
							<a class="fee-action-button button-secondary" href="' . esc_url( home_url( "/wp-admin/admin.php?page=wpfp-edit-wizard&wrd_id=" . esc_attr( $wizard_id ) . "&action=edit" . "&_wpnonce=" . esc_attr( $wpfpnonce ) ) ) . '"><i class="fa fa-pencil fa-fw"></i></a>
							<a class="fee-action-button button-secondary delete_single_selected_wizard" href="javascript:void(0);" id="delete_single_selected_wizard_' . esc_attr( $wizard_id ) . '" data-attr_name="' . esc_attr( $wizard_title ) . '"><i class="fa fa-trash-o fa-lg"></i></a>';
                $msg .= '<a class="fee-action-button button-secondary setting_single_selected_wizard" href="' . esc_url( home_url( "/wp-admin/admin.php?page=wpfp-wizard-setting&wrd_id=" . esc_attr( $wizard_id ) . "&action=setting" . "&_wpnonce=" . esc_attr( $wpfpnonce ) ) ) . '" id="setting_single_selected_wizard_' . esc_attr( $wizard_id ) . '" data-attr_name="' . esc_attr( $wizard_title ) . '"><i class="fa fa-cog"></i></a>';
                $msg .= '</div>
					</td>
				</tr>';
                $i++;
            }
        } else {
            $msg .= '<tr>
						<td colspan="5">' . esc_html__( 'No List Available', 'woo-product-finder' ) . '</td>
					</tr>';
        }
        $responce = array();
        $responce['wizards'] = $msg;
        echo wp_json_encode( $responce );
        exit;
    }

    public function wpfp_pagination_wizards() {
        global $wpdb;
        $msg = '';
        $page_no = filter_input( INPUT_POST, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if ( isset( $page_no ) ) {
            header( "Content-type: application/json" );
            $wpfp_dpc = 10;
            $page = sanitize_text_field( $page_no );
            $cur_page = $page;
            $page -= 1;
            if ( isset( $wpfp_dpc ) && !empty( $wpfp_dpc ) ) {
                $per_page = $wpfp_dpc;
            } else {
                $per_page = 10;
            }
            $previous_btn = true;
            $next_btn = true;
            $start = $page * $per_page;
            // Query the posts
            $sel_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard ORDER BY sortable_id DESC LIMIT %d, %d", $start, $per_page ) );
            // phpcs:ignore
            // At the same time, count the number of queried posts
            $count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM {$wpdb->prefix}wpfp_wizard WHERE 1=%d", 1 ) );
            // phpcs:ignore
            // Loop into all the posts
            $i = 1;
            if ( !empty( $sel_rows ) && isset( $sel_rows ) && is_array( $sel_rows ) ) {
                $i = 1;
                foreach ( $sel_rows as $sel_data ) {
                    $wizard_id = esc_attr( $sel_data->id );
                    $wizard_title = esc_attr( $sel_data->name );
                    $wizard_status = esc_attr( $sel_data->status );
                    $wpfpnonce = wp_create_nonce( 'wppfcnonce' );
                    $msg .= '<tr id="wizard_row_' . $wizard_id . '">
						<td width="10%">
							<input type="checkbox" class="chk_single_wizard" name="chk_single_wizard_chk" value="' . esc_attr( $wizard_id ) . '">
						</td>
						<td>
							<a href="' . esc_url( home_url( "/wp-admin/admin.php?page=wpfp-edit-wizard&wrd_id=" . esc_attr( $wizard_id ) . "&action=edit" . "&_wpnonce=" . esc_attr( $wpfpnonce ) ) ) . '">' . esc_html__( $wizard_title, "woo-product-finder" ) . '</a>
						</td>
						<td>
							<input type="text" class="copy-shortcode" value="[wpfp_' . esc_attr( $wizard_id ) . ']" readonly="">
						</td>
						<td>';
                    if ( !empty( esc_attr( $wizard_status ) ) && esc_attr( $wizard_status ) === 'on' ) {
                        $msg .= '<span class="active-status">' . esc_html__( 'Enabled', 'woo-product-finder' ) . '</span>';
                    } else {
                        $msg .= '<span class="inactive-status">' . esc_html__( 'Disabled', 'woo-product-finder' ) . '</span>';
                    }
                    $msg .= '</td>
						<td>
							<div class="wpf-action">
								<a class="fee-action-button button-secondary" href="' . esc_url( home_url( "/wp-admin/admin.php?page=wpfp-edit-wizard&wrd_id=" . esc_attr( $wizard_id ) . "&action=edit" . "&_wpnonce=" . esc_attr( $wpfpnonce ) ) ) . '"><i class="fa fa-pencil fa-fw"></i></a>
								<a class="fee-action-button button-secondary delete_single_selected_wizard" href="javascript:void(0);" id="delete_single_selected_wizard_' . esc_attr( $wizard_id ) . '" data-attr_name="' . esc_attr( $wizard_title ) . '"><i class="fa fa-trash-o fa-lg"></i></a>';
                    $msg .= '<a class="fee-action-button button-secondary setting_single_selected_wizard" href="' . esc_url( home_url( "/wp-admin/admin.php?page=wpfp-wizard-setting&wrd_id=" . esc_attr( $wizard_id ) . "&action=setting" . "&_wpnonce=" . esc_attr( $wpfpnonce ) ) ) . '" id="setting_single_selected_wizard_' . esc_attr( $wizard_id ) . '" data-attr_name="' . esc_attr( $wizard_title ) . '"><i class="fa fa-cog"></i></a>';
                    $msg .= '</div>
						</td>
					</tr>';
                    $i++;
                }
            } else {
                $msg .= '<tr>
							<td colspan="5">' . esc_html__( 'No List Available', 'woo-product-finder' ) . '</td>
						</tr>';
            }
            $no_of_paginations = ceil( $count / $per_page );
            if ( $cur_page >= 7 ) {
                $start_loop = $cur_page - 3;
                if ( $no_of_paginations > $cur_page + 3 ) {
                    $end_loop = $cur_page + 3;
                } else {
                    if ( $cur_page <= $no_of_paginations && $cur_page > $no_of_paginations - 6 ) {
                        $start_loop = $no_of_paginations - 6;
                        $end_loop = $no_of_paginations;
                    } else {
                        $end_loop = $no_of_paginations;
                    }
                }
            } else {
                $start_loop = 1;
                if ( $no_of_paginations > 7 ) {
                    $end_loop = 7;
                } else {
                    $end_loop = $no_of_paginations;
                }
            }
            $pag_container = '';
            // Pagination Buttons
            if ( $no_of_paginations > 1 ) {
                $pag_container .= "\n\t\t\t\t<div class='wpfp-pagination-link'>\n\t\t\t\t<ul>";
                if ( $previous_btn && $cur_page > 1 ) {
                    $pre = $cur_page - 1;
                    $pag_container .= "<li p='{$pre}' class='active'>Previous</li>";
                } else {
                    if ( $previous_btn ) {
                        $pag_container .= "<li class='inactive'>Previous</li>";
                    }
                }
                for ($i = $start_loop; $i <= $end_loop; $i++) {
                    if ( (int) $cur_page === $i ) {
                        $pag_container .= "<li p='{$i}' class = 'selected' >{$i}</li>";
                    } else {
                        $pag_container .= "<li p='{$i}' class='active'>{$i}</li>";
                    }
                }
                if ( $next_btn && $cur_page < $no_of_paginations ) {
                    $nex = $cur_page + 1;
                    $pag_container .= "<li p='{$nex}' class='active'>Next</li>";
                } else {
                    if ( $next_btn ) {
                        $pag_container .= "<li class='inactive'>Next</li>";
                    }
                }
                $pag_container = $pag_container . "\n\t\t\t\t</ul>\n\t\t\t\t</div>";
            }
        }
        $responce = array();
        $responce['wizards'] = $msg;
        $responce['pagination'] = $pag_container;
        echo wp_json_encode( $responce );
        exit;
    }

    /**
     * Get dynamic promotional bar of plugin
     *
     * @param   String  $plugin_slug  slug of the plugin added in the site option
     * @since    3.9.3
     * 
     * @return  null
     */
    public function wpfp_get_promotional_bar( $plugin_slug = '' ) {
        $promotional_bar_upi_url = WPFP_STORE_URL . 'wp-json/dpb-promotional-banner/v2/dpb-promotional-banner?' . wp_rand();
        $promotional_banner_request = wp_remote_get( $promotional_bar_upi_url );
        //phpcs:ignore
        if ( empty( $promotional_banner_request->errors ) ) {
            $promotional_banner_request_body = $promotional_banner_request['body'];
            $promotional_banner_request_body = json_decode( $promotional_banner_request_body, true );
            echo '<div class="dynamicbar_wrapper">';
            if ( !empty( $promotional_banner_request_body ) && is_array( $promotional_banner_request_body ) ) {
                foreach ( $promotional_banner_request_body as $promotional_banner_request_body_data ) {
                    $promotional_banner_id = $promotional_banner_request_body_data['promotional_banner_id'];
                    $promotional_banner_cookie = $promotional_banner_request_body_data['promotional_banner_cookie'];
                    $promotional_banner_image = $promotional_banner_request_body_data['promotional_banner_image'];
                    $promotional_banner_description = $promotional_banner_request_body_data['promotional_banner_description'];
                    $promotional_banner_button_group = $promotional_banner_request_body_data['promotional_banner_button_group'];
                    $dpb_schedule_campaign_type = $promotional_banner_request_body_data['dpb_schedule_campaign_type'];
                    $promotional_banner_target_audience = $promotional_banner_request_body_data['promotional_banner_target_audience'];
                    if ( !empty( $promotional_banner_target_audience ) ) {
                        $plugin_keys = array();
                        if ( is_array( $promotional_banner_target_audience ) ) {
                            foreach ( $promotional_banner_target_audience as $list ) {
                                $plugin_keys[] = $list['value'];
                            }
                        } else {
                            $plugin_keys[] = $promotional_banner_target_audience['value'];
                        }
                        $display_banner_flag = false;
                        if ( in_array( 'all_customers', $plugin_keys, true ) || in_array( $plugin_slug, $plugin_keys, true ) ) {
                            $display_banner_flag = true;
                        }
                    }
                    if ( true === $display_banner_flag ) {
                        if ( 'default' === $dpb_schedule_campaign_type ) {
                            $banner_cookie_show = filter_input( INPUT_COOKIE, 'banner_show_' . $promotional_banner_cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                            $banner_cookie_visible_once = filter_input( INPUT_COOKIE, 'banner_show_once_' . $promotional_banner_cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                            $flag = false;
                            if ( empty( $banner_cookie_show ) && empty( $banner_cookie_visible_once ) ) {
                                setcookie( 'banner_show_' . $promotional_banner_cookie, 'yes', time() + 86400 * 7 );
                                //phpcs:ignore
                                setcookie( 'banner_show_once_' . $promotional_banner_cookie, 'yes' );
                                //phpcs:ignore
                                $flag = true;
                            }
                            $banner_cookie_show = filter_input( INPUT_COOKIE, 'banner_show_' . $promotional_banner_cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                            if ( !empty( $banner_cookie_show ) || true === $flag ) {
                                $banner_cookie = filter_input( INPUT_COOKIE, 'banner_' . $promotional_banner_cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                                $banner_cookie = ( isset( $banner_cookie ) ? $banner_cookie : '' );
                                if ( empty( $banner_cookie ) && 'yes' !== $banner_cookie ) {
                                    ?>
                            	<div class="dpb-popup <?php 
                                    echo ( isset( $promotional_banner_cookie ) ? esc_html( $promotional_banner_cookie ) : 'default-banner' );
                                    ?>">
                                    <?php 
                                    if ( !empty( $promotional_banner_image ) ) {
                                        ?>
                                        <img src="<?php 
                                        echo esc_url( $promotional_banner_image );
                                        ?>"/>
                                        <?php 
                                    }
                                    ?>
                                    <div class="dpb-popup-meta">
                                        <p>
                                            <?php 
                                    echo wp_kses_post( str_replace( array('<p>', '</p>'), '', $promotional_banner_description ) );
                                    if ( !empty( $promotional_banner_button_group ) ) {
                                        foreach ( $promotional_banner_button_group as $promotional_banner_button_group_data ) {
                                            ?>
                                                    <a href="<?php 
                                            echo esc_url( $promotional_banner_button_group_data['promotional_banner_button_link'] );
                                            ?>" target="_blank"><?php 
                                            echo esc_html( $promotional_banner_button_group_data['promotional_banner_button_text'] );
                                            ?></a>
                                                    <?php 
                                        }
                                    }
                                    ?>
                                    	</p>
                                    </div>
                                    <a href="javascript:void(0);" data-bar-id="<?php 
                                    echo esc_attr( $promotional_banner_id );
                                    ?>" data-popup-name="<?php 
                                    echo ( isset( $promotional_banner_cookie ) ? esc_attr( $promotional_banner_cookie ) : 'default-banner' );
                                    ?>" class="dpbpop-close"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"><path id="Icon_material-close" data-name="Icon material-close" d="M17.5,8.507,16.493,7.5,12.5,11.493,8.507,7.5,7.5,8.507,11.493,12.5,7.5,16.493,8.507,17.5,12.5,13.507,16.493,17.5,17.5,16.493,13.507,12.5Z" transform="translate(-7.5 -7.5)" fill="#acacac"/></svg></a>
                                </div>
                                <?php 
                                }
                            }
                        } else {
                            $banner_cookie_show = filter_input( INPUT_COOKIE, 'banner_show_' . $promotional_banner_cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                            $banner_cookie_visible_once = filter_input( INPUT_COOKIE, 'banner_show_once_' . $promotional_banner_cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                            $flag = false;
                            if ( empty( $banner_cookie_show ) && empty( $banner_cookie_visible_once ) ) {
                                setcookie( 'banner_show_' . $promotional_banner_cookie, 'yes' );
                                //phpcs:ignore
                                setcookie( 'banner_show_once_' . $promotional_banner_cookie, 'yes' );
                                //phpcs:ignore
                                $flag = true;
                            }
                            $banner_cookie_show = filter_input( INPUT_COOKIE, 'banner_show_' . $promotional_banner_cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                            if ( !empty( $banner_cookie_show ) || true === $flag ) {
                                $banner_cookie = filter_input( INPUT_COOKIE, 'banner_' . $promotional_banner_cookie, FILTER_SANITIZE_FULL_SPECIAL_CHARS );
                                $banner_cookie = ( isset( $banner_cookie ) ? $banner_cookie : '' );
                                if ( empty( $banner_cookie ) && 'yes' !== $banner_cookie ) {
                                    ?>
                    			<div class="dpb-popup <?php 
                                    echo ( isset( $promotional_banner_cookie ) ? esc_html( $promotional_banner_cookie ) : 'default-banner' );
                                    ?>">
                                    <?php 
                                    if ( !empty( $promotional_banner_image ) ) {
                                        ?>
                                            <img src="<?php 
                                        echo esc_url( $promotional_banner_image );
                                        ?>"/>
                                        <?php 
                                    }
                                    ?>
                                    <div class="dpb-popup-meta">
                                        <p>
                                            <?php 
                                    echo wp_kses_post( str_replace( array('<p>', '</p>'), '', $promotional_banner_description ) );
                                    if ( !empty( $promotional_banner_button_group ) ) {
                                        foreach ( $promotional_banner_button_group as $promotional_banner_button_group_data ) {
                                            ?>
                                                    <a href="<?php 
                                            echo esc_url( $promotional_banner_button_group_data['promotional_banner_button_link'] );
                                            ?>" target="_blank"><?php 
                                            echo esc_html( $promotional_banner_button_group_data['promotional_banner_button_text'] );
                                            ?></a>
                                                    <?php 
                                        }
                                    }
                                    ?>
                                        </p>
                                    </div>
                                    <a href="javascript:void(0);" data-bar-id="<?php 
                                    echo esc_attr( $promotional_banner_id );
                                    ?>" data-popup-name="<?php 
                                    echo ( isset( $promotional_banner_cookie ) ? esc_html( $promotional_banner_cookie ) : 'default-banner' );
                                    ?>" class="dpbpop-close"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10"><path id="Icon_material-close" data-name="Icon material-close" d="M17.5,8.507,16.493,7.5,12.5,11.493,8.507,7.5,7.5,8.507,11.493,12.5,7.5,16.493,8.507,17.5,12.5,13.507,16.493,17.5,17.5,16.493,13.507,12.5Z" transform="translate(-7.5 -7.5)" fill="#acacac"/></svg></a>
                                </div>
                                <?php 
                                }
                            }
                        }
                    }
                }
            }
            echo '</div>';
        }
    }

    /**
     * Admin footer review
     *
     * @since 2.0.0
     */
    public function wpfp_admin_footer_review() {
        $url = '';
        $url = esc_url( 'https://wordpress.org/plugins/woo-product-finder/#reviews' );
        $html = sprintf( wp_kses( __( '<strong>We need your support</strong> to keep updating and improving the plugin. Please <a href="%1$s" target="_blank">help us by leaving a good review</a> :) Thanks!', 'woo-product-finder' ), array(
            'strong' => array(),
            'a'      => array(
                'href'   => array(),
                'target' => 'blank',
            ),
        ) ), esc_url( $url ) );
        echo wp_kses_post( $html );
    }

    /**
     * Get and save plugin setup wizard data
     * 
     * @since 2.0.0
     * 
     */
    public function wpfp_plugin_setup_wizard_submit() {
        check_ajax_referer( 'wizard_ajax_nonce', 'nonce' );
        $survey_list = filter_input( INPUT_GET, 'survey_list', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if ( !empty( $survey_list ) && 'Select One' !== $survey_list ) {
            update_option( 'wpfp_where_hear_about_us', $survey_list );
        }
        wp_die();
    }

    /**
     * Send setup wizard data to sendinblue
     * 
     * @since 2.0.0 
     * 
     */
    public function wpfp_send_wizard_data_after_plugin_activation() {
        $send_wizard_data = filter_input( INPUT_GET, 'send-wizard-data', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if ( isset( $send_wizard_data ) && !empty( $send_wizard_data ) ) {
            if ( !get_option( 'wpfp_data_submited_in_sendiblue' ) ) {
                $wpfp_where_hear = get_option( 'wpfp_where_hear_about_us' );
                $get_user = wpfp_fs()->get_user();
                $data_insert_array = array();
                if ( isset( $get_user ) && !empty( $get_user ) ) {
                    $data_insert_array = array(
                        'user_email'              => $get_user->email,
                        'ACQUISITION_SURVEY_LIST' => $wpfp_where_hear,
                    );
                }
                $feedback_api_url = WPFP_STORE_URL . 'wp-json/dotstore-sendinblue-data/v2/dotstore-sendinblue-data?' . wp_rand();
                $query_url = $feedback_api_url . '&' . http_build_query( $data_insert_array );
                if ( function_exists( 'vip_safe_wp_remote_get' ) ) {
                    $response = vip_safe_wp_remote_get(
                        $query_url,
                        3,
                        1,
                        20
                    );
                } else {
                    $response = wp_remote_get( $query_url );
                }
                if ( !is_wp_error( $response ) && 200 === wp_remote_retrieve_response_code( $response ) ) {
                    update_option( 'wpfp_data_submited_in_sendiblue', '1' );
                    delete_option( 'wpfp_where_hear_about_us' );
                }
            }
        }
    }

}
