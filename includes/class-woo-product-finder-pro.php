<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Finder_Pro
 * @subpackage Woo_Product_Finder_Pro/includes
 */
/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Product_Finder_Pro
 * @subpackage Woo_Product_Finder_Pro/includes
 * @author     Multidots <inquiry@multidots.in>
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
class WPFPFW_Woo_Product_Finder_Pro {
    /**
     * The loader that's responsible for maintaining and registering all hooks that power
     * the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      Woo_Product_Finder_Pro_Loader    $loader    Maintains and registers all hooks for the plugin.
     */
    protected $loader;

    /**
     * The unique identifier of this plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $plugin_name    The string used to uniquely identify this plugin.
     */
    protected $plugin_name;

    /**
     * The current version of the plugin.
     *
     * @since    1.0.0
     * @access   protected
     * @var      string    $version    The current version of the plugin.
     */
    protected $version;

    const wpfp_VERSION = '1.1';

    /**
     * Define the core functionality of the plugin.
     *
     * Set the plugin name and the plugin version that can be used throughout the plugin.
     * Load the dependencies, define the locale, and set the hooks for the admin area and
     * the public-facing side of the site.
     *
     * @since    1.0.0
     */
    public function __construct() {
        if ( defined( 'WPFPFW_PLUGIN_VERSION' ) ) {
            $this->version = WPFPFW_PLUGIN_VERSION;
        } else {
            $this->version = '1.1';
        }
        $this->plugin_name = 'woo-product-finder-pro';
        $this->load_dependencies();
        $this->set_locale();
        $this->define_admin_hooks();
        $this->define_public_hooks();
        $prefix = ( is_network_admin() ? 'network_admin_' : '' );
        add_filter(
            "{$prefix}plugin_action_links_" . WPFP_PLUGIN_BASENAME,
            array($this, 'plugin_action_links'),
            10,
            4
        );
        add_filter(
            'plugin_row_meta',
            array($this, 'plugin_row_meta_action_links'),
            20,
            3
        );
    }

    /**
     * Load the required dependencies for this plugin.
     *
     * Include the following files that make up the plugin:
     *
     * - Woo_Product_Finder_Pro_Loader. Orchestrates the hooks of the plugin.
     * - Woo_Product_Finder_Pro_i18n. Defines internationalization functionality.
     * - Woo_Product_Finder_Pro_Admin. Defines all hooks for the admin area.
     * - Woo_Product_Finder_Pro_Public. Defines all hooks for the public side of the site.
     *
     * Create an instance of the loader which will be used to register the hooks
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function load_dependencies() {
        /**
         * The class responsible for orchestrating the actions and filters of the
         * core plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-product-finder-pro-loader.php';
        /**
         * The class responsible for defining internationalization functionality
         * of the plugin.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-product-finder-pro-i18n.php';
        /**
         * The class responsible for defining all actions that occur in the admin area.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-product-finder-pro-admin.php';
        /**
         * The class responsible for defining all actions that occur in the public-facing
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-product-finder-pro-public.php';
        /**
         * The class responsible for defining shortcode for wizard
         * side of the site.
         */
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-product-finder-pro-public-shortcode-creator.php';
        $this->loader = new WPFPFW_Woo_Product_Finder_Pro_Loader();
    }

    /**
     * Define the locale for this plugin for internationalization.
     *
     * Uses the Woo_Product_Finder_Pro_i18n class in order to set the domain and to register the hook
     * with WordPress.
     *
     * @since    1.0.0
     * @access   private
     */
    private function set_locale() {
        $plugin_i18n = new WPFPFW_Woo_Product_Finder_Pro_i18n();
        $this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );
    }

    /**
     * Register all of the hooks related to the admin area functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_admin_hooks() {
        $plugin_admin = new WPFPFW_Woo_Product_Finder_Pro_Admin($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
        $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );
        $this->loader->add_action( 'admin_menu', $plugin_admin, 'wpfp_dot_store_menu' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'wpfp_welcome_screen_do_activation_redirect' );
        $this->loader->add_action( 'admin_head', $plugin_admin, 'wpfp_remove_admin_submenus' );
        $this->loader->add_action( 'wp_ajax_wpfp_get_attributes_value_based_on_attribute_name', $plugin_admin, 'wpfp_get_attributes_value_based_on_attribute_name' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_attributes_value_based_on_attribute_name', $plugin_admin, 'wpfp_get_attributes_value_based_on_attribute_name' );
        $this->loader->add_action( 'wp_ajax_wpfp_remove_option_data_from_option_page', $plugin_admin, 'wpfp_remove_option_data_from_option_page' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_remove_option_data_from_option_page', $plugin_admin, 'wpfp_remove_option_data_from_option_page' );
        $this->loader->add_action( 'wp_ajax_wpfp_delete_selected_wizard_using_checkbox', $plugin_admin, 'wpfp_delete_selected_wizard_using_checkbox' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_delete_selected_wizard_using_checkbox', $plugin_admin, 'wpfp_delete_selected_wizard_using_checkbox' );
        $this->loader->add_action( 'wp_ajax_wpfp_delete_single_wizard_using_button', $plugin_admin, 'wpfp_delete_single_wizard_using_button' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_delete_single_wizard_using_button', $plugin_admin, 'wpfp_delete_single_wizard_using_button' );
        $this->loader->add_action( 'wp_ajax_wpfp_delete_selected_question_using_checkbox', $plugin_admin, 'wpfp_delete_selected_question_using_checkbox' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_delete_selected_question_using_checkbox', $plugin_admin, 'wpfp_delete_selected_question_using_checkbox' );
        $this->loader->add_action( 'wp_ajax_wpfp_delete_single_question_using_button', $plugin_admin, 'wpfp_delete_single_question_using_button' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_delete_single_question_using_button', $plugin_admin, 'wpfp_delete_single_question_using_button' );
        $this->loader->add_action( 'wp_ajax_wpfp_get_admin_question_list_with_pagination', $plugin_admin, 'wpfp_get_admin_question_list_with_pagination' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_admin_question_list_with_pagination', $plugin_admin, 'wpfp_get_admin_question_list_with_pagination' );
        $this->loader->add_action( 'wp_ajax_wpfp_sortable_question_list_based_on_id', $plugin_admin, 'wpfp_sortable_question_list_based_on_id' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_sortable_question_list_based_on_id', $plugin_admin, 'wpfp_sortable_question_list_based_on_id' );
        $this->loader->add_action( 'wp_ajax_wpfp_sortable_option_list_based_on_id', $plugin_admin, 'wpfp_sortable_option_list_based_on_id' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_sortable_option_list_based_on_id', $plugin_admin, 'wpfp_sortable_option_list_based_on_id' );
        $this->loader->add_action( 'wp_ajax_wpfp_get_woocommerce_product_attribute_name_list_ajax', $plugin_admin, 'wpfp_get_woocommerce_product_attribute_name_list_ajax' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_woocommerce_product_attribute_name_list_ajax', $plugin_admin, 'wpfp_get_woocommerce_product_attribute_name_list_ajax' );
        $this->loader->add_action( 'current_screen', $plugin_admin, 'this_screen' );
        $this->loader->add_action( 'admin_head', $plugin_admin, 'wpfp_dot_store_icon_css' );
        $this->loader->add_action( 'wp_ajax_save_master_settings', $plugin_admin, 'wpfp_free_save_master_settings__premium_only' );
        $this->loader->add_action( 'wp_ajax_wpfp_pagination_wizards', $plugin_admin, 'wpfp_pagination_wizards' );
        $this->loader->add_action( 'wp_ajax_wpfp_search_wizards', $plugin_admin, 'wpfp_search_wizards' );
        $this->loader->add_action( 'wp_ajax_wpfp_sortable_wizard_list_based_on_id', $plugin_admin, 'wpfp_sortable_wizard_list_based_on_id' );
        $this->loader->add_action( 'wp_ajax_wpfp_plugin_setup_wizard_submit', $plugin_admin, 'wpfp_plugin_setup_wizard_submit' );
        $this->loader->add_action( 'admin_init', $plugin_admin, 'wpfp_send_wizard_data_after_plugin_activation' );
        $get_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        if ( !empty( $get_page ) && false !== strpos( $get_page, 'wpfp' ) ) {
            $this->loader->add_filter( 'admin_footer_text', $plugin_admin, 'wpfp_admin_footer_review' );
        }
    }

    /**
     * Register all of the hooks related to the public-facing functionality
     * of the plugin.
     *
     * @since    1.0.0
     * @access   private
     */
    private function define_public_hooks() {
        $plugin_public = new WPFPFW_Woo_Product_Finder_Pro_Public($this->get_plugin_name(), $this->get_version());
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );
        $this->loader->add_action( 'wp_ajax_wpfp_get_next_questions_front_side', $plugin_public, 'wpfp_get_next_questions_front_side' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_next_questions_front_side', $plugin_public, 'wpfp_get_next_questions_front_side' );
        $this->loader->add_action( 'wp_ajax_wpfp_get_previous_questions_front_side', $plugin_public, 'wpfp_get_previous_questions_front_side' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_previous_questions_front_side', $plugin_public, 'wpfp_get_previous_questions_front_side' );
        $this->loader->add_action( 'wp_ajax_wpfp_get_ajax_woocommerce_product_list', $plugin_public, 'wpfp_get_ajax_woocommerce_product_list' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_ajax_woocommerce_product_list', $plugin_public, 'wpfp_get_ajax_woocommerce_product_list' );
        $this->loader->add_action( 'wp_ajax_wpfp_get_final_woocommerce_product_list', $plugin_public, 'wpfp_get_final_woocommerce_product_list' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_final_woocommerce_product_list', $plugin_public, 'wpfp_get_final_woocommerce_product_list' );
        $this->loader->add_action( 'wp_ajax_wpfp_get_front_html_list_with_pagination', $plugin_public, 'wpfp_get_front_html_list_with_pagination' );
        $this->loader->add_action( 'wp_ajax_nopriv_wpfp_get_front_html_list_with_pagination', $plugin_public, 'wpfp_get_front_html_list_with_pagination' );
    }

    /**
     * Return the plugin action links.  This will only be called if the plugin
     * is active.
     *
     * @since 1.0.0
     * @param array $actions associative array of action names to anchor tags
     * @return array associative array of plugin action links
     */
    public function plugin_action_links( $actions ) {
        $custom_actions = array(
            'configure' => sprintf( '<a href="%s">%s</a>', admin_url( 'admin.php?page=wpfp-list' ), __( 'Settings', 'woo-product-finder' ) ),
            'docs'      => sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'https://docs.thedotstore.com/collection/278-product-finder' ), __( 'Docs', 'woo-product-finder' ) ),
            'support'   => sprintf( '<a href="%s" target="_blank">%s</a>', esc_url( 'www.thedotstore.com/support' ), __( 'Support', 'woo-product-finder' ) ),
        );
        // add the links to the front of the actions list
        return array_merge( $custom_actions, $actions );
    }

    /**
     * Add review stars in plugin row meta
     *
     * @since 1.0.0
     */
    public function plugin_row_meta_action_links( $plugin_meta, $plugin_file, $plugin_data ) {
        if ( isset( $plugin_data['TextDomain'] ) && $plugin_data['TextDomain'] !== 'woo-product-finder' ) {
            return $plugin_meta;
        }
        $url = '';
        $url = esc_url( 'https://wordpress.org/plugins/woo-product-finder/#reviews' );
        $plugin_meta[] = sprintf( '<a href="%s" target="_blank" style="color:#f5bb00;">%s</a>', $url, esc_html( '★★★★★' ) );
        return $plugin_meta;
    }

    /**
     * Run the loader to execute all of the hooks with WordPress.
     *
     * @since    1.0.0
     */
    public function run() {
        $this->loader->run();
    }

    /**
     * The name of the plugin used to uniquely identify it within the context of
     * WordPress and to define internationalization functionality.
     *
     * @since     1.0.0
     * @return    string    The name of the plugin.
     */
    public function get_plugin_name() {
        return $this->plugin_name;
    }

    /**
     * The reference to the class that orchestrates the hooks with the plugin.
     *
     * @since     1.0.0
     * @return    Woo_Product_Finder_Pro_Loader    Orchestrates the hooks of the plugin.
     */
    public function get_loader() {
        return $this->loader;
    }

    /**
     * Retrieve the version number of the plugin.
     *
     * @since     1.0.0
     * @return    string    The version number of the plugin.
     */
    public function get_version() {
        return $this->version;
    }

}
