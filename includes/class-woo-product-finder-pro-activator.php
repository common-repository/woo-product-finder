<?php

/**
 * Fired during plugin activation
 *
 * @link       http://www.multidots.com
 * @since      1.0.0
 *
 * @package    Woo_Product_Finder_Pro
 * @subpackage Woo_Product_Finder_Pro/includes
 */
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Woo_Product_Finder_Pro
 * @subpackage Woo_Product_Finder_Pro/includes
 * @author     Multidots <inquiry@multidots.in>
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

class WPFPFW_Woo_Product_Finder_Pro_Activator {

    /**
     * Short Description. ( use period )
     *
     * Long Description.
     *
     * @since    1.0.0
     */
    public static function activate() {

        if ( !in_array('woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ), true ) && !is_plugin_active_for_network( 'woocommerce/woocommerce.php' ) ) {
            wp_die( "<strong> " . esc_html__( WPFPFW_WOO_PRODUCT_FINDER_PRO_PLUGIN_NAME, 'woo-product-finder') . "</strong> Plugin requires <strong>WooCommerce</strong> <a href='" . esc_url(get_admin_url( null, 'plugins.php' )) . "'>" . esc_html__( 'Plugins page', 'woo-product-finder' ) . "</a>." );
        } else {
            global $wpdb;
            require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );    

            /* Plugin's table prefix */
            $wpfp_prefix = $wpdb->prefix . WPFPFW_PRO_TABLE_PREFIX;

            /* Table name */
            $wp_wizard_table = $wpfp_prefix . "wizard";
            $wp_questions_table = $wpfp_prefix . "questions";
            $wp_questions_options_table = $wpfp_prefix . "questions_options";

            /* Setup table */
            // phpcs:disable
            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_wizard_table)) === $wp_wizard_table ) { 
                $sql = "ALTER TABLE " . $wp_wizard_table .
                        " ADD wizard_tags text NOT NULL AFTER wizard_category";
                $wpdb->query($sql); 
            }
            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_wizard_table)) === $wp_wizard_table ) { 
                $sql = "ALTER TABLE " . $wp_wizard_table .
                        " ADD wizard_price_range text NOT NULL AFTER wizard_tags";
                $wpdb->query($sql); 
            }
            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_wizard_table)) === $wp_wizard_table ) { 
                $sql = "ALTER TABLE " . $wp_wizard_table .
                        " ADD wizard_setting text NOT NULL AFTER wizard_price_range";
                $wpdb->query($sql); 
            }
            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_wizard_table)) === $wp_wizard_table ) { 
                $sql = "ALTER TABLE " . $wp_wizard_table .
                        " ADD sortable_id int(10) NOT NULL AFTER shortcode";
                $wpdb->query($sql); 
            }
            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_wizard_table)) === $wp_wizard_table ) { 
                $sql = "ALTER TABLE " . $wp_wizard_table .
                        " ADD range_status varchar( 255 ) NOT NULL AFTER status";
                $wpdb->query($sql); 
            }
            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_questions_options_table) ) === $wp_questions_options_table ) { 
                $sql = "ALTER TABLE " . $wp_questions_options_table .
                        " ADD option_attribute_db text NOT NULL AFTER option_attribute";
                $wpdb->query($sql); 
            }
            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_questions_options_table) ) === $wp_questions_options_table ) { 
                $sql = "ALTER TABLE " . $wp_questions_options_table . " ADD option_attribute_next text NOT NULL AFTER option_attribute_value";
                $wpdb->query($sql); 
            }
            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_wizard_table)) !== $wp_wizard_table ) { 
                
                $sql = "CREATE TABLE " . $wp_wizard_table . " ( 
              id int( 11 ) NOT NULL AUTO_INCREMENT,
              name text NOT NULL,
              wizard_category varchar( 255 ) NOT NULL,
              wizard_tags varchar( 255 ) NOT NULL,
              wizard_price_range text NOT NULL,
              wizard_setting text NOT NULL,
              shortcode text NOT NULL,
              sortable_id int(10) NOT NULL,
              status varchar( 255 ) NOT NULL,
              range_status varchar( 255 ) NOT NULL,
              created_date varchar( 255 ) NOT NULL,
              updated_date varchar( 255 ) NOT NULL,
              PRIMARY KEY  ( id )
               );";
            }

            dbDelta( $sql );

            if ( $wpdb->get_var($wpdb->prepare("SHOW TABLES LIKE %s", $wp_questions_table) ) !== $wp_questions_table ) { 
                $sql = "CREATE TABLE " . $wp_questions_table . " ( 
            id int( 11 ) NOT NULL AUTO_INCREMENT,
            wizard_id int( 11 ) NOT NULL,
            name text NOT NULL,
            option_type varchar( 255 ) NOT NULL,
            sortable_id int( 11 ) NOT NULL,
            created_date varchar( 255 ) NOT NULL,
            updated_date varchar( 255 ) NOT NULL,
            PRIMARY KEY  ( id )
             );"; 
            }
            dbDelta( $sql );

            if ( $wpdb->get_var( $wpdb->prepare("SHOW TABLES LIKE %s",$wp_questions_options_table) ) !== $wp_questions_options_table ) {
                $sql = "CREATE TABLE " . $wp_questions_options_table . " ( 
                            id int( 11 ) NOT NULL AUTO_INCREMENT,
                            wizard_id int( 11 ) NOT NULL,
                            question_id int( 11 ) NOT NULL,
                            option_name text NOT NULL,
                            option_image varchar( 255 ) NOT NULL,
                            option_attribute varchar( 255 ) NOT NULL,
                            option_attribute_db text NOT NULL ,
                            option_attribute_value text NOT NULL,
                            option_attribute_next text NOT NULL,
                            sortable_id int( 11 ) NOT NULL,
                            created_date varchar( 255 ) NOT NULL,
                            updated_date varchar( 255 ) NOT NULL,
                            PRIMARY KEY  ( id )
                        );";
            }
            dbDelta( $sql );
            // phpcs:enable
            set_transient( '_welcome_screen_activation_redirect_wpfp', true, 30 );
            add_option( 'wpfp_version', PLUGIN_NAME_VERSION );
        }
    }

}