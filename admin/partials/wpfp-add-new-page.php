<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global $wpdb;
$wpf_admin_object = new WPFPFW_Woo_Product_Finder_Pro_Admin($this->plugin_name, $this->version);
// phpcs:ignore
$wizard_id = filter_input( INPUT_GET, 'wrd_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$question_id = filter_input( INPUT_GET, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$retrieved_nonce = ( isset( $_REQUEST['_wpnonce'] ) && !empty( $_REQUEST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) : '' );
$wizard_id = ( empty( $wizard_id ) ? '' : sanitize_text_field( wp_unslash( $wizard_id ) ) );
$question_id = ( empty( $question_id ) ? '' : sanitize_text_field( wp_unslash( $question_id ) ) );
$add_new_wsave = __( 'Save & Continue', 'woo-product-finder' );
$edit_new_wsave = __( 'Update', 'woo-product-finder' );
$submitWizard = filter_input( INPUT_POST, 'submitWizard', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$submitWizard = ( empty( $submitWizard ) ? '' : sanitize_text_field( wp_unslash( $submitWizard ) ) );
$setting_arr = array();
$wp_http_referer = filter_input( INPUT_POST, '_wp_http_referer', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$wizard_post_id = filter_input( INPUT_POST, 'wizard_post_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$wizard_title = filter_input( INPUT_POST, 'wizard_title', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$wizard_shortcode = filter_input( INPUT_POST, 'wizard_shortcode', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$wizard_status = filter_input( INPUT_POST, 'wizard_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$wpfp_price_range_status = filter_input( INPUT_POST, 'wpfp_price_range_status', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$wpfp_set_min_price_range = filter_input( INPUT_POST, 'wpfp_set_min_price_range', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$wpfp_set_max_price_range = filter_input( INPUT_POST, 'wpfp_set_max_price_range', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$submitWizard = filter_input( INPUT_POST, 'submitWizard', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$wizard_category = filter_input(
    INPUT_POST,
    'wizard_category',
    FILTER_DEFAULT,
    FILTER_REQUIRE_ARRAY
);
$wizard_tag = filter_input(
    INPUT_POST,
    'wizard_tag',
    FILTER_DEFAULT,
    FILTER_REQUIRE_ARRAY
);
$setting_arr['_wpnonce'] = $retrieved_nonce;
$setting_arr['_wp_http_referer'] = ( isset( $wp_http_referer ) && !empty( $wp_http_referer ) ? sanitize_text_field( wp_unslash( $wp_http_referer ) ) : '' );
$setting_arr['wizard_post_id'] = ( isset( $wizard_post_id ) && !empty( $wizard_post_id ) ? sanitize_text_field( wp_unslash( $wizard_post_id ) ) : '' );
$setting_arr['wizard_title'] = ( isset( $wizard_title ) && !empty( $wizard_title ) ? sanitize_text_field( wp_unslash( $wizard_title ) ) : '' );
$setting_arr['wizard_shortcode'] = ( isset( $wizard_shortcode ) && !empty( $wizard_shortcode ) ? sanitize_text_field( wp_unslash( $wizard_shortcode ) ) : '' );
$setting_arr['wizard_status'] = ( isset( $wizard_status ) && !empty( $wizard_status ) ? sanitize_text_field( wp_unslash( $wizard_status ) ) : '' );
$setting_arr['wpfp_price_range_status'] = ( isset( $wpfp_price_range_status ) && !empty( $wpfp_price_range_status ) ? sanitize_text_field( wp_unslash( $wpfp_price_range_status ) ) : '' );
$setting_arr['wpfp_set_min_price_range'] = ( isset( $wpfp_set_min_price_range ) && !empty( $wpfp_set_min_price_range ) ? sanitize_text_field( wp_unslash( $wpfp_set_min_price_range ) ) : '' );
$setting_arr['wpfp_set_max_price_range'] = ( isset( $wpfp_set_max_price_range ) && !empty( $wpfp_set_max_price_range ) ? sanitize_text_field( wp_unslash( $wpfp_set_max_price_range ) ) : '' );
$setting_arr['submitWizard'] = ( isset( $submitWizard ) && !empty( $submitWizard ) ? sanitize_text_field( wp_unslash( $submitWizard ) ) : '' );
$setting_arr['wizard_category'] = ( isset( $wizard_category ) && !empty( $wizard_category ) ? $wizard_category : array() );
$setting_arr['wizard_tag'] = ( isset( $wizard_tag ) && !empty( $wizard_tag ) ? $wizard_tag : array() );
if ( isset( $submitWizard ) && ($submitWizard === $add_new_wsave || $submitWizard === 'Save &amp; Continue') ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wizardfrm' ) ) {
        die( 'Failed security check-' );
    } else {
        if ( method_exists( $wpf_admin_object, 'wpfp_wizard_save' ) ) {
            $wpf_admin_object->wpfp_wizard_save( $setting_arr, 'add', $setting_arr['wizard_post_id'] );
        }
    }
} elseif ( isset( $submitWizard ) && $submitWizard === $edit_new_wsave ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wizardfrm' ) ) {
        die( 'Failed security check--' );
    } else {
        if ( method_exists( $wpf_admin_object, 'wpfp_wizard_save' ) ) {
            $wpf_admin_object->wpfp_wizard_save( $setting_arr, 'add', $setting_arr['wizard_post_id'] );
        }
    }
}
$wizard_category_explode = array();
$wizard_tag_explode = array();
if ( isset( $_REQUEST['action'] ) && sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) === 'edit' ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wppfcnonce' ) ) {
        die( 'Failed security check---' );
    } else {
        $btnValue = __( 'Update', 'woo-product-finder' );
        $get_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_wizard WHERE id=%d", $wizard_id ) );
        // phpcs:ignore
        if ( !empty( $get_rows ) && isset( $get_rows ) ) {
            $wizard_title = esc_attr( $get_rows->name );
            $wizard_category = esc_attr( $get_rows->wizard_category );
            $wizard_category_explode = explode( ',', $wizard_category );
            $wizard_shortcode = '[wpfp_' . esc_attr( $wizard_id ) . ']';
            $wizard_status = esc_attr( $get_rows->status );
            $wizard_tag = esc_attr( $get_rows->wizard_tags );
            $wizard_price_range = esc_attr( $get_rows->wizard_price_range );
            $wizard_price_explode = explode( '||', $wizard_price_range );
            $wizard_range_status = esc_attr( $get_rows->range_status );
            $wizard_tag_explode = explode( ',', $wizard_tag );
        }
    }
} else {
    $btnValue = __( 'Save & Continue', 'woo-product-finder' );
    if ( method_exists( $wpf_admin_object, 'wpfp_get_current_auto_increment_id' ) ) {
        $current_auto_incr_id = $wpf_admin_object->wpfp_get_current_auto_increment_id( WPFPFW_WIZARDS_PRO_TABLE );
    } else {
        $current_auto_incr_id = 1;
    }
    $wizard_title = '';
    if ( method_exists( $wpf_admin_object, 'wpfp_create_wizard_shortcode' ) ) {
        $wizard_shortcode = $wpf_admin_object->wpfp_create_wizard_shortcode( $current_auto_incr_id );
    } else {
        $wizard_shortcode = '';
    }
    $wizard_status = '';
    $wizard_range_status = '';
}
if ( isset( $_REQUEST['action'] ) && sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) === 'delete' ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wppfcnonce' ) ) {
        die( 'Failed security check----' );
    } else {
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $delete_sql = $wpdb->delete( $questions_table_name, array(
            'id'        => esc_attr( $question_id ),
            'wizard_id' => esc_attr( $wizard_id ),
        ), array('%d', '%d') );
        // phpcs:ignore
        if ( $delete_sql === '1' ) {
            wp_redirect( home_url( '/wp-admin/admin.php?page=wpfp-edit-wizard&id=' . esc_attr( $wizard_id ) . '&action=edit&_wpnonce=' . wp_kses_post( $retrieved_nonce ) ) );
            exit;
        } else {
            echo esc_html_e( 'Error Happens.Please try again', 'woo-product-finder' );
            wp_redirect( home_url( '/wp-admin/admin.php?page=wpfp-question-list&wrd_id=' . esc_attr( $wizard_id . '' ) ) );
            exit;
        }
    }
}
if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'edit' ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wppfcnonce' ) ) {
        die( 'Failed security check-----' );
    }
}
$wizardObject = new WPFPFW_Woo_Product_Finder_Pro_Admin($this->plugin_name, $this->version);
// phpcs:ignore
$fetchWizardTag = $wizardObject->wpfp_get_woocommerce_tag();
$fetchWizardTagName = ( !empty( $fetchWizardTag ) ? $fetchWizardTag : '' );
?>
<div class="wpfp-main-table res-cl">
    <h2><?php 
esc_html_e( 'Wizard Configuration', 'woo-product-finder' );
?></h2>
    <form method="POST" name="wizardfrm" action="">
        <?php 
wp_nonce_field( 'wizardfrm' );
?>
        <input type="hidden" name="wizard_post_id" value="<?php 
echo esc_attr( $wizard_id );
?>">
        <table class="form-table table-outer product-fee-table">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_status"><?php 
esc_html_e( WPFPFW_WIZARD_STATUS, 'woo-product-finder' );
?></label></th>
                    <td class="forminp mdtooltip">
                        <label class="switch">
                            <input type="checkbox" name="wizard_status" value="on" <?php 
echo ( !empty( esc_attr( $wizard_status ) ) && esc_attr( $wizard_status ) === 'off' ? '' : 'checked' );
?>>
                            <div class="slider round"></div>
                        </label>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_title"><?php 
esc_html_e( WPFPFW_WIZARD_TITLE, 'woo-product-finder' );
?><span class="required-star">*</span></label></th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="wizard_title" class="text-class half_width" id="wizard_title" value="<?php 
echo ( !empty( esc_attr( $wizard_title ) ) ? esc_attr( $wizard_title ) : '' );
?>" required="1" placeholder="<?php 
esc_attr( 'Enter Wizard Title Here' );
?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
esc_html_e( 'Wizard title will display in front side at top of product list ( EX:HELP ME PICK MY SHOES! )', 'woo-product-finder' );
?></p>
                    </td>
                </tr>
                <?php 
?>
                        <tr valign="top" class="wizard_category_tr">
                            <th class="titledesc" scope="row">
                                <label for="wizard_category"><?php 
esc_html_e( 'Wizard Category', 'woo-product-finder' );
?><div class="pf-pro-label"></div></label></th>
                            <td class="forminp mdtooltip">
                                <select id="wizard_category" data-placeholder="<?php 
esc_attr( 'Select Wizard Category' );
?>"  multiple="true" disabled="disabled" class="chosen-select-wizard-category category-select chosen-rtl">
                                    <option value=""></option>
                                </select>
                                <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                <p class="description"><?php 
esc_html_e( 'If you select category, then product will display based on these selected category.', 'woo-product-finder' );
?></p>
                            </td>
                        </tr>
                        <?php 
?>
                <tr valign="top" class="wizard_tag_tr">
                    <th class="titledesc" scope="row">
                        <label for="wizard_tag"><?php 
esc_html_e( 'Wizard Tags', 'woo-product-finder' );
?></label></th>
                    <td class="forminp mdtooltip">
                        <select id="wizard_tag" data-placeholder="<?php 
esc_attr( 'Select Wizard Tag' );
?>" name="wizard_tag[]" multiple="true" class="chosen-select-wizard-tag tag-select chosen-rtl">
                            <option></option>
                            <?php 
if ( !empty( $fetchWizardTagName ) && $fetchWizardTagName !== '' && isset( $fetchWizardTagName ) && is_array( $fetchWizardTagName ) ) {
    foreach ( $fetchWizardTagName as $key => $values ) {
        ?>
                                    <option value="<?php 
        echo esc_attr( trim( $key ) );
        ?>"<?php 
        echo selected( in_array( trim( $key ), $wizard_tag_explode, true ), true, false );
        ?>"><?php 
        echo esc_html_e( trim( $values ), 'woo-product-finder' );
        ?></option>
                                    <?php 
    }
}
?>
                        </select>
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
esc_html_e( 'If you select tags, then product will display based on these selected tags.', 'woo-product-finder' );
?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wizard_shortcode"><?php 
esc_html_e( 'Wizard Shortcode', 'woo-product-finder' );
?></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <div class="product_cost_left_div">
                            <input type="text" name="wizard_shortcode" required="1" class="text-class" id="wizard_shortcode" value="<?php 
echo ( !empty( esc_attr( $wizard_shortcode ) ) ? esc_attr( $wizard_shortcode ) : '' );
?>" readonly>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
esc_html_e( 'Paste shortcode in that page where you want to configure recommandation wizard )', 'woo-product-finder' );
?>
                            </p>
                        </div>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="wpfp_price_range_status"><?php 
esc_html_e( 'Price Range Status', 'woo-product-finder' );
?></label></th>
                    <td class="forminp mdtooltip">
                        <label class="switch">
                            <input type="checkbox" name="wpfp_price_range_status" value="off" <?php 
echo ( !empty( esc_attr( $wizard_range_status ) ) && esc_attr( $wizard_range_status ) === 'on' ? 'checked' : '' );
?>>
                            <div class="slider round"></div>
                        </label>
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
esc_html_e( 'Enable/Disable price range option.', 'woo-product-finder' );
?></p>
                    </td>
                </tr>
                <?php 
if ( 'on' === $wizard_range_status ) {
    $showrangesetting = 'table-row';
} else {
    $showrangesetting = 'none';
}
?>
                <tr valign="top" style="display:<?php 
echo esc_attr( $showrangesetting );
?>">
                    <th class="titledesc" scope="row">
                        <label for="wpfp_set_price_range"><?php 
esc_html_e( 'Set Min/Max Price Range', 'woo-product-finder' );
?></label></th>
                    <td class="forminp mdtooltip">
                        <input type="text" class="text-class half_width wpfp_mm_price" placeholder="Minimum" name="wpfp_set_min_price_range" value="<?php 
echo ( isset( $wizard_price_explode[0] ) ? esc_attr( $wizard_price_explode[0] ) : '' );
?>">
                        <input type="text" class="text-class half_width wpfp_mm_price" placeholder="Maximum" name="wpfp_set_max_price_range" value="<?php 
echo ( isset( $wizard_price_explode[1] ) ? esc_attr( $wizard_price_explode[1] ) : '' );
?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
esc_html_e( 'Set minimum and maximum price range to filter the product.', 'woo-product-finder' );
?></p>
                    </td>
                </tr>
                
            </tbody>
        </table>
        <p class="submit"><input type="submit" name="submitWizard" class="button button-primary" value="<?php 
echo esc_attr( $btnValue );
?>"></p>
    </form>

    <?php 
if ( isset( $_REQUEST['action'] ) && $_REQUEST['action'] === 'edit' ) {
    $wizardfrm = wp_create_nonce( 'wizardfrm' );
    ?>
        <div class="product_header_title">
            <h2>
                <?php 
    esc_html_e( 'Manage Questions', 'woo-product-finder' );
    ?>
                <a class="add-new-btn dots-btn-with-brand-color"  href="<?php 
    echo esc_url( home_url( '/wp-admin/admin.php?page=wpfp-add-new-question&wrd_id=' . esc_attr( $wizard_id ) . '&_wpnonce=' . esc_attr( $wizardfrm ) ) );
    ?>"><?php 
    esc_html_e( 'Add New Question', 'woo-product-finder' );
    ?></a>
                <a id="detete_all_selected_question" class="detete-btn button-secondary"  disabled="disabled"><?php 
    esc_html_e( 'Delete ( Selected )', 'woo-product-finder' );
    ?></a>
            </h2>
        </div>
        <div id="using_ajax">

        </div>
        <?php 
}
?>
</div>
</div>
</div>
</div>
</div>
