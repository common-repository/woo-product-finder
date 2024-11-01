<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global $wpdb;
$wizard_post_id = ( empty( $_REQUEST['wrd_id'] ) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['wrd_id'] ) ) );
$retrieved_nonce = ( empty( $_REQUEST['_wpnonce'] ) ? '' : sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) );
if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'delete' ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wppfcnonce' ) ) {
        die( 'Failed security check' );
    }
    $wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
    $delete_sql = $wpdb->delete( $wizard_table_name, array(
        'id' => esc_attr( $wizard_post_id ),
    ), array('%d') );
    // phpcs:ignore
    if ( $delete_sql === '1' ) {
        wp_redirect( esc_url( home_url( '/wp-admin/admin.php?page=wpfp-list' ) ) );
        exit;
    } else {
        esc_html_e( 'Error Happens.Please try again', 'woo-product-finder' );
        wp_redirect( esc_url( home_url( '/wp-admin/admin.php?page=wpfp-list' ) ) );
        exit;
    }
}
$wizard_table_name = WPFPFW_WIZARDS_PRO_TABLE;
$count = $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(id) FROM {$wpdb->prefix}wpfp_wizard WHERE 1=%d", 1 ) );
// phpcs:ignore
wp_nonce_field( 'delete' );
?>
<div class="wpfp-main-table res-cl">
    <div class="product_header_title">
        <h2>
            <?php 
esc_html_e( 'Manage Wizards', 'woo-product-finder' );
?>
            <a class="add-new-btn dots-btn-with-brand-color"  href="<?php 
echo esc_url( home_url( '/wp-admin/admin.php?page=wpfp-add-new' ) );
?>"><?php 
esc_html_e( 'Add New Wizard', 'woo-product-finder' );
?></a>
            <a id="detete_all_selected_wizard" class="detete_all_select_wizard_list button-secondary" href="javascript:void(0);" disabled="disabled"><?php 
esc_html_e( 'Delete ( Selected )', 'woo-product-finder' );
?></a>
            <div class="search-wizard"><input type="text" name="searchWizard" placeholder="Search Wizards" id="search_wizard"><button class="button-secondary"><?php 
esc_html_e( 'Search', 'woo-product-finder' );
?></button></div>
        </h2>
    </div>
    <input type="hidden" id="all_wizards_count" value="<?php 
echo esc_attr( $count );
?>">
    <table id="wizard-listing" class="table-outer form-table all-table-listing tablesorter">
        <thead>
            <tr class="wpfp-head">
                <th><input type="checkbox" name="check_all" class="chk_all_wizard_class" id="chk_all_wizard"></th>
                <th><?php 
esc_html_e( 'Name', 'woo-product-finder' );
?></th>
                <th><?php 
esc_html_e( 'Shortcode', 'woo-product-finder' );
?></th>
                <th><?php 
esc_html_e( 'Status', 'woo-product-finder' );
?></th>
                <th><?php 
esc_html_e( 'Action', 'woo-product-finder' );
?></th>
            </tr>
        </thead>
        <tbody></tbody>
    </table>
    <div class = "wpfp_pag_loading"></div>
    <?php 
?>
                <div class="wpfpro-mastersettings wpfp-upgrade-pro-to-unlock">
                    <div class="mastersettings-title">
                        <h2><?php 
esc_html_e( 'Master Settings', 'woo-product-finder' );
?><div class="pf-pro-label"></div></h2>
                    </div>
                    <table class="table-mastersettings table-outer" cellpadding="0" cellspacing="0">
                        <tbody>
                        <tr valign="top">
                            <td class="table-whattodo"><?php 
esc_html_e( 'Want to display product finder result at last?', 'woo-product-finder' );
?></td>
                            <td>
                                <select name="result_display_mode" id="result_display_mode" disabled="disabled">
                                    <option value="no"><?php 
esc_html_e( 'No', 'woo-product-finder' );
?></option>
                                </select>
                            </td>
                        </tr>
                        <tr valign="top">
                            <td class="table-whattodo"><?php 
esc_html_e( 'Default pagination count', 'woo-product-finder' );
?></td>
                            <td>
                                <input type="text" placeholder="Records per page" class="wpfp-text" disabled="disabled" value="10">
                            </td>
                        </tr>
                        <tr>
                            <td colspan="2">
                                <span class="button-primary" id="save_master_settings" name="save_master_settings" disabled="disabled"><?php 
esc_html_e( 'Save Master Settings', 'woo-product-finder' );
?></span>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            <?php 
?>
</div>
</div>
</div>
</div>
</div>
