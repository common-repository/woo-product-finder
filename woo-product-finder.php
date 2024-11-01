<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.thedotstore.com
 * @since             1.0.0
 * @package           Woo_Product_Finder_Pro
 *
 * @wordpress-plugin
 * Plugin Name: Product Recommendation Quiz For WooCommerce
 * Plugin URI:        https://www.thedotstore.com/woocommerce-product-finder/
 * Description:       Product Recommendation Quiz For WooCommerce let customers narrow down the product list on the basis of their choices. It enables the store owners to add a questionnaire to the product page. The product recommendations are then rendered according to the answers, given by the users. You can showcase N number of products, matching the answers and query. 
 * Version:           2.0.0
 * Author:            theDotstore
 * Author URI:        https://profiles.wordpress.org/dots
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       woo-product-finder
 * Domain Path:       /languages
 * Requires Plugins:  woocommerce
 * 
 * WP tested up to:     6.6.1
 * WC tested up to:     9.1.4
 * Requires PHP:        7.2
 * Requires at least:   5.0
 */
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
if ( function_exists( 'wpfp_fs' ) ) {
    wpfp_fs()->set_basename( false, __FILE__ );
    return;
}
if ( !function_exists( 'wpfp_fs' ) ) {
    // Create a helper function for easy SDK access.
    function wpfp_fs() {
        global $wpfp_fs;
        if ( !isset( $wpfp_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $wpfp_fs = fs_dynamic_init( array(
                'id'               => '3474',
                'slug'             => 'woo-product-finder-pro',
                'type'             => 'plugin',
                'public_key'       => 'pk_283cce2c62f26271f3c6e2418df8a',
                'is_premium'       => false,
                'has_addons'       => false,
                'has_paid_plans'   => true,
                'is_org_compliant' => false,
                'trial'            => array(
                    'days'               => 14,
                    'is_require_payment' => true,
                ),
                'menu'             => array(
                    'slug'       => 'wpfp-get-started',
                    'first-path' => 'admin.php?page=wpfp-get-started',
                    'contact'    => false,
                    'support'    => false,
                ),
                'is_live'          => true,
            ) );
        }
        return $wpfp_fs;
    }

    // Init Freemius.
    wpfp_fs();
    // Signal that SDK was initiated.
    do_action( 'wpfp_fs_loaded' );
    wpfp_fs()->get_upgrade_url();
    // Not like register_uninstall_hook(), you do NOT have to use a static function.
    wpfp_fs()->add_action( 'after_uninstall', 'wpfp_fs_uninstall_cleanup' );
}
if ( !defined( 'WPFP_PLUGIN_URL' ) ) {
    define( 'WPFP_PLUGIN_URL', plugin_dir_url( __FILE__ ) );
}
if ( !defined( 'WPFP_PLUGIN_DIR_PATH' ) ) {
    define( 'WPFP_PLUGIN_DIR_PATH', plugin_dir_path( __FILE__ ) );
}
if ( !defined( 'WPFP_PLUGIN_BASENAME' ) ) {
    define( 'WPFP_PLUGIN_BASENAME', plugin_basename( __FILE__ ) );
}
if ( !defined( 'PLUGIN_NAME_VERSION' ) ) {
    define( 'PLUGIN_NAME_VERSION', '2.0.0' );
}
if ( !defined( 'WPFP_STORE_URL' ) ) {
    define( 'WPFP_STORE_URL', 'https://www.thedotstore.com/' );
}
/**
 * The core plugin include constant file for set constant.
 */
require plugin_dir_path( __FILE__ ) . 'includes/constant.php';
/**
 * Check Initialize plugin in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
function wpfp_product_finder_initialize_plugin() {
    $wc_active = in_array( 'woocommerce/woocommerce.php', get_option( 'active_plugins' ), true );
    if ( current_user_can( 'activate_plugins' ) && $wc_active !== true || $wc_active !== true ) {
        add_action( 'admin_notices', 'wpfp_product_finder_plugin_admin_notice' );
    }
}

add_action( 'plugins_loaded', 'wpfp_product_finder_initialize_plugin' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-woo-product-finder-pro-activator.php
 */
function activate_Woo_Product_Finder_Pro() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-product-finder-pro-activator.php';
    WPFPFW_Woo_Product_Finder_Pro_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-woo-product-finder-pro-deactivator.php
 */
function deactivate_Woo_Product_Finder_Pro() {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-woo-product-finder-pro-deactivator.php';
    WPFPFW_Woo_Product_Finder_Pro_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_Woo_Product_Finder_Pro' );
register_deactivation_hook( __FILE__, 'deactivate_Woo_Product_Finder_Pro' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-woo-product-finder-pro.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function wpfp_run_Woo_Product_Finder_Pro() {
    $plugin = new WPFPFW_Woo_Product_Finder_Pro();
    $plugin->run();
}

wpfp_run_Woo_Product_Finder_Pro();
add_action( 'admin_enqueue_scripts', 'wpfp_my_de_register_javascript', 100 );
function wpfp_my_de_register_javascript() {
    $getpage = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
    if ( isset( $getpage ) && !empty( $getpage ) && ($getpage === 'wpfp-list' || $getpage === 'wpfp-add-new' || $getpage === 'wpfp-get-started' || $getpage === 'wpfp-information' || $getpage === 'wpfp-edit-wizard' || $getpage === 'wpfp-add-new-question' || $getpage === 'wpfp-question-list' || $getpage === 'wpfp-edit-question' || $getpage === 'wpfp-add-new-options' || $getpage === 'wpfp-wizard-setting') ) {
        wp_dequeue_style( 'chosen-drop-down' );
        wp_dequeue_style( 'jquery-chosen' );
        wp_dequeue_style( 'jquery-chosen' );
        wp_dequeue_script( 'jquery-chosen' );
        wp_dequeue_script( 'ajax-chosen' );
        wp_dequeue_style( 'aiosp_admin_style' );
        wp_dequeue_style( 'aioseop-module-style' );
        wp_dequeue_style( 'aioseop-module-style-rtl' );
        wp_dequeue_style( 'aioseop_welcome_css' );
        wp_dequeue_style( 'carbon-fields-plugin-update-warning' );
        wp_dequeue_style( 'wp-fastest-cache' );
        wp_dequeue_style( 'wcj-admin' );
        wp_dequeue_style( 'swpsmtp_stylesheet' );
        wp_dequeue_style( 'revslider-global-styles' );
        wp_dequeue_style( 'tp-color-picker-css' );
        wp_dequeue_style( 'woo-carrier-agents-admin-css' );
        wp_dequeue_style( 'tm_epo_admin_css' );
        wp_dequeue_style( 'jquery-ui' );
        wp_dequeue_style( 'wp-bulk-delete-css' );
        wp_dequeue_style( 'seed-csp4-adminbar-notification' );
        wp_dequeue_style( 'elementor-pro-admin' );
        wp_dequeue_style( 'yith-wfbt-admin-scripts' );
        wp_dequeue_style( 'elementor-icons' );
        wp_dequeue_style( 'elementor-admin-app' );
        wp_dequeue_style( 'wp-fastest-cache-toolbar' );
        wp_dequeue_style( 'yit-theme-licence' );
        wp_dequeue_style( 'woocommerce_admin_styles' );
        wp_dequeue_style( 'jquery-chosen' );
        wp_dequeue_style( 'wc_matkahuolto' );
        wp_dequeue_style( 'yit-plugin-metaboxes' );
        wp_dequeue_style( 'jquery-ui-overcast' );
        wp_dequeue_style( 'to.css' );
        wp_dequeue_style( 'shipment_tracking_styles' );
        wp_dequeue_style( 'woocommerce_admin_menu_styles' );
        wp_dequeue_style( 'woocommerce_admin_menu_styles' );
        wp_dequeue_style( 'woocommerce_frontend_styles' );
        wp_dequeue_style( 'woocommerce-general' );
        wp_dequeue_style( 'woocommerce-layout' );
        wp_dequeue_style( 'woocommerce-smallscreen' );
        wp_dequeue_style( 'woocommerce_fancybox_styles' );
        wp_dequeue_style( 'woocommerce_chosen_styles' );
        wp_dequeue_style( 'woocommerce_prettyPhoto_css' );
    }
}

/**
 * Show admin notice in case of WooCommerce plugin is missing.
 *
 * @since    1.0.0
 */
function wpfp_product_finder_plugin_admin_notice() {
    $product_finder_plugin = esc_html__( 'Product Recommendation Quiz For WooCommerce', 'woo-product-finder' );
    $wc_plugin = esc_html__( 'WooCommerce', 'woo-product-finder' );
    ?>
    <div class="error">
        <p>
			<?php 
    echo sprintf( esc_html__( '%1$s requires %2$s to be installed & activated!', 'woo-product-finder' ), '<strong>' . esc_html( $product_finder_plugin ) . '</strong>', '<a href="' . esc_url( 'https://wordpress.org/plugins/woocommerce/' ) . '" target="_blank"><strong>' . esc_html( $wc_plugin ) . '</strong></a>' );
    ?>
        </p>
    </div>
	<?php 
}

if ( !function_exists( 'wpfp_allowed_html_tags' ) ) {
    function wpfp_allowed_html_tags(  $tags = array()  ) {
        $allowedposttags = array(
            'a'        => array(
                'href'  => array(),
                'title' => array(),
                'class' => array(),
            ),
            'ul'       => array(
                'class' => array(),
            ),
            'li'       => array(
                'class' => array(),
            ),
            'div'      => array(
                'class' => array(),
                'id'    => array(),
            ),
            'select'   => array(
                'id'       => array(),
                'name'     => array(),
                'class'    => array(),
                'multiple' => array(),
                'style'    => array(),
            ),
            'input'    => array(
                'id'    => array(),
                'value' => array(),
                'min'   => array(),
                'max'   => array(),
                'name'  => array(),
                'class' => array(),
                'type'  => array(),
            ),
            'textarea' => array(
                'id'    => array(),
                'name'  => array(),
                'class' => array(),
            ),
            'option'   => array(
                'id'       => array(),
                'selected' => array(),
                'name'     => array(),
                'value'    => array(),
            ),
            'br'       => array(),
            'em'       => array(),
            'strong'   => array(),
            'p'        => array(),
            'b'        => array(
                'style' => array(),
            ),
            'option'   => array(
                'value' => array(),
            ),
        );
        if ( !empty( $tags ) ) {
            foreach ( $tags as $key => $value ) {
                $allowedposttags[$key] = $value;
            }
        }
        return $allowedposttags;
    }

}
/**
 * Hide freemius account tab
 *
 * @since 2.0.0
 */
if ( !function_exists( 'wpfp_hide_account_tab' ) ) {
    function wpfp_hide_account_tab() {
        return true;
    }

    wpfp_fs()->add_filter( 'hide_account_tabs', 'wpfp_hide_account_tab' );
}
/**
 * Include plugin header on freemius account page
 *
 * @since 2.0.0
 */
if ( !function_exists( 'wpfp_load_plugin_header_after_account' ) ) {
    function wpfp_load_plugin_header_after_account() {
        require_once plugin_dir_path( __FILE__ ) . 'admin/partials/header/plugin-header.php';
        ?>
        </div>
        </div>
        </div>
        </div>
        <?php 
    }

    wpfp_fs()->add_action( 'after_account_details', 'wpfp_load_plugin_header_after_account' );
}
/**
 * Hide billing and payments details from freemius account page
 *
 * @since 2.0.0
 */
if ( !function_exists( 'wpfp_hide_billing_and_payments_info' ) ) {
    function wpfp_hide_billing_and_payments_info() {
        return true;
    }

    wpfp_fs()->add_action( 'hide_billing_and_payments_info', 'wpfp_hide_billing_and_payments_info' );
}
/**
 * Hide powerd by popup from freemius account page
 *
 * @since 2.0.0
 */
if ( !function_exists( 'wpfp_hide_freemius_powered_by' ) ) {
    function wpfp_hide_freemius_powered_by() {
        return true;
    }

    wpfp_fs()->add_action( 'hide_freemius_powered_by', 'wpfp_hide_freemius_powered_by' );
}
/**
 * Start plugin setup wizard before license activation screen
 *
 * @since  2.0.0
 */
if ( !function_exists( 'wpfp_load_plugin_setup_wizard_connect_before' ) ) {
    function wpfp_load_plugin_setup_wizard_connect_before() {
        require_once plugin_dir_path( __FILE__ ) . 'admin/partials/dots-plugin-setup-wizard.php';
        ?>
        <div class="tab-panel" id="step5">
            <div class="ds-wizard-wrap">
                <div class="ds-wizard-content">
                    <h2 class="cta-title"><?php 
        echo esc_html__( 'Activate Plugin', 'woo-product-finder' );
        ?></h2>
                </div>
        <?php 
    }

    wpfp_fs()->add_action( 'connect/before', 'wpfp_load_plugin_setup_wizard_connect_before' );
}
/**
 * End plugin setup wizard after license activation screen
 *
 * @since 2.0.0
 */
if ( !function_exists( 'wpfp_load_plugin_setup_wizard_connect_after' ) ) {
    function wpfp_load_plugin_setup_wizard_connect_after() {
        ?>
        </div>
        </div>
        </div>
        </div>
        <?php 
    }

    wpfp_fs()->add_action( 'connect/after', 'wpfp_load_plugin_setup_wizard_connect_after' );
}