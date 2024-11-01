<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
$plugin_slug = '';
$plugin_name = WPFPFW_WOO_PRODUCT_FINDER_PLUGIN_NAME;
$plugin_slug = 'basic_product_finder';
$version_label = __( 'Free', 'woo-product-finder' );
$plugin_version = 'v' . PLUGIN_NAME_VERSION;
global $wpfp_fs;
$WPFPFW_admin_object = new WPFPFW_Woo_Product_Finder_Pro_Admin('', '');
$get_page = filter_input( INPUT_GET, 'page', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$get_action = filter_input( INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$fee_list = ( isset( $get_page ) && (sanitize_text_field( wp_unslash( $get_page ) ) === 'wpfp-list' || sanitize_text_field( wp_unslash( $get_page ) ) === 'wpfp-wizard-setting') ? 'active' : '' );
$fee_add = ( isset( $get_page ) && (sanitize_text_field( wp_unslash( $get_page ) ) === 'wpfp-add-new' || sanitize_text_field( wp_unslash( $get_page ) ) === 'wpfp-edit-wizard') ? 'active' : '' );
$fee_getting_started = ( !empty( $get_page ) && sanitize_text_field( wp_unslash( $get_page ) ) === 'wpfp-get-started' ? 'active' : '' );
$upgrade_pro_dashboard = ( !empty( $get_page ) && sanitize_text_field( wp_unslash( $get_page ) ) === 'wpfp-upgrade-dashboard' ? 'active' : '' );
$wpfp_account_page = ( !empty( $get_page ) && sanitize_text_field( wp_unslash( $get_page ) ) === 'wpfp-get-started-account' ? 'active' : '' );
if ( !empty( $get_action ) && !empty( $get_page ) ) {
    if ( $get_action === 'edit' && sanitize_text_field( wp_unslash( $get_page ) ) === 'wpfp-edit-wizard' ) {
        $wi = filter_input( INPUT_GET, 'wrd_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $wn = filter_input( INPUT_GET, '_wpnonce', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
        $wsid = ( isset( $wi ) ? $wi : '' );
        $wpnonce = ( isset( $wn ) ? $wn : '' );
        $wizard_id = sanitize_text_field( wp_unslash( $wsid ) );
        $wpfpnonce = sanitize_text_field( wp_unslash( $wpnonce ) );
        $wizard_header_title = 'Edit Wizard';
        $wizard_header_url = esc_url( home_url( '/wp-admin/admin.php?page=wpfp-edit-wizard&wrd_id=' . esc_attr( $wizard_id ) . '&action=edit' . '&_wpnonce=' . esc_attr( $wpfpnonce ) ) );
    } else {
        $wizard_header_title = 'Add New Wizard';
        $wizard_header_url = esc_url( home_url( '/wp-admin/admin.php?page=wpfp-add-new' ) );
    }
} else {
    $wizard_header_title = 'Add New Wizard';
    $wizard_header_url = esc_url( home_url( '/wp-admin/admin.php?page=wpfp-add-new' ) );
}
?>
<div id="dotsstoremain">
    <div class="all-pad">
        <?php 
$WPFPFW_admin_object->wpfp_get_promotional_bar( $plugin_slug );
?>
        <header class="dots-header">
            <div class="dots-plugin-details">
                <div class="dots-header-left">
                    <div class="dots-logo-main">
                        <img src="<?php 
echo esc_url( WPFP_PLUGIN_URL . 'admin/images/plugin-icon.png' );
?>">
                    </div>
                    <div class="plugin-name">
                        <div class="title"><?php 
esc_html_e( $plugin_name, 'woo-product-finder' );
?></div>
                    </div>
                    <span class="version-label <?php 
echo esc_attr( $plugin_slug );
?>"><?php 
esc_html_e( $version_label, 'woo-product-finder' );
?></span>
                    <span class="version-number"><?php 
echo esc_html_e( $plugin_version, 'woo-product-finder' );
?></span>
                </div>
                <div class="dots-header-right">
                    <div class="button-dots">
                        <a target="_blank" href="<?php 
echo esc_url( 'http://www.thedotstore.com/support/' );
?>"><?php 
esc_html_e( 'Support', 'woo-product-finder' );
?></a>
                    </div>
                    <div class="button-dots">
                        <a target="_blank" href="<?php 
echo esc_url( 'https://www.thedotstore.com/feature-requests/' );
?>"><?php 
esc_html_e( 'Suggest', 'woo-product-finder' );
?></a>
                    </div>
                    <?php 
$plugin_help_url = 'https://docs.thedotstore.com/collection/278-product-finder';
if ( strpos( current_filter(), 'fs_connect' ) !== false ) {
    $plugin_help_url = 'https://docs.thedotstore.com/article/62-how-to-installing-and-activating-an-thedotstore-plugin';
}
?>
                    <div class="button-dots <?php 
echo ( wpfp_fs()->is__premium_only() && wpfp_fs()->can_use_premium_code() ? '' : 'last-link-button' );
?>">
                        <a target="_blank" href="<?php 
echo esc_url( $plugin_help_url );
?>"><?php 
esc_html_e( 'Help', 'woo-product-finder' );
?></a>
                    </div>
                    <div class="button-dots">
                        <?php 
?>
                            <a class="dots-upgrade-btn" target="_blank" href="javascript:void(0);"><?php 
esc_html_e( 'Upgrade Now', 'woo-product-finder' );
?></a>
                            <?php 
?>
                    </div>
                </div>
            </div>
            <div class="dots-bottom-menu-main">
                <div class="dots-menu-main">
                    <nav>
                        <ul>
                            <li>
                                <a class="dotstore_plugin <?php 
echo esc_attr( $fee_list );
?>"  href="<?php 
echo esc_url( home_url( '/wp-admin/admin.php?page=wpfp-list' ) );
?>"><?php 
esc_html_e( 'Manage Wizards', 'woo-product-finder' );
?></a>
                            </li>
                            <li>
                                <a class="dotstore_plugin <?php 
echo esc_attr( $fee_add );
?>"  href="<?php 
echo esc_url( $wizard_header_url );
?>"> <?php 
esc_html_e( $wizard_header_title, 'woo-product-finder' );
?></a>
                            </li>
                            <?php 
if ( wpfp_fs()->is__premium_only() && wpfp_fs()->can_use_premium_code() ) {
    ?>
                                <li>
                                    <a class="dotstore_plugin <?php 
    echo esc_attr( $wpfp_account_page );
    ?>" href="<?php 
    echo esc_url( $wpfp_fs->get_account_url() );
    ?>"><?php 
    esc_html_e( 'License', 'woo-product-finder' );
    ?></a>
                                </li>
                                <?php 
} else {
    ?>
                                <li>
                                    <a class="dotstore_plugin dots_get_premium <?php 
    echo esc_attr( $upgrade_pro_dashboard );
    ?>" href="<?php 
    echo esc_url( add_query_arg( array(
        'page' => 'wpfp-upgrade-dashboard',
    ), admin_url( 'admin.php' ) ) );
    ?>"><?php 
    esc_html_e( 'Get Premium', 'woo-product-finder' );
    ?></a>
                                </li>
                                <?php 
}
?>
                        </ul>
                    </nav>
                </div>
                <div class="dots-getting-started">
                    <a href="<?php 
echo esc_url( add_query_arg( array(
    'page' => 'wpfp-get-started',
), admin_url( 'admin.php' ) ) );
?>" class="<?php 
echo esc_attr( $fee_getting_started );
?>"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" aria-hidden="true" focusable="false"><path d="M12 4.75a7.25 7.25 0 100 14.5 7.25 7.25 0 000-14.5zM3.25 12a8.75 8.75 0 1117.5 0 8.75 8.75 0 01-17.5 0zM12 8.75a1.5 1.5 0 01.167 2.99c-.465.052-.917.44-.917 1.01V14h1.5v-.845A3 3 0 109 10.25h1.5a1.5 1.5 0 011.5-1.5zM11.25 15v1.5h1.5V15h-1.5z" fill="#a0a0a0"></path></svg></a>
                </div>
            </div>
        </header>
        <!-- Upgrade to pro popup -->
        <?php 
if ( !(wpfp_fs()->is__premium_only() && wpfp_fs()->can_use_premium_code()) ) {
    require_once WPFP_PLUGIN_DIR_PATH . 'admin/partials/dots-upgrade-popup.php';
}
?>
        <div class="dots-settings-inner-main">
            <div class="dots-settings-left-side">
