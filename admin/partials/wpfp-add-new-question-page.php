<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
global $wpdb;
$queation_setting_arr = array();
$wrd_id = filter_input( INPUT_GET, 'wrd_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$que_id = filter_input( INPUT_GET, 'que_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$opt_id = filter_input( INPUT_GET, 'opt_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$retrieved_nonce = ( isset( $_REQUEST['_wpnonce'] ) && !empty( $_REQUEST['_wpnonce'] ) ? sanitize_text_field( wp_unslash( $_REQUEST['_wpnonce'] ) ) : '' );
$wizard_id = ( empty( $wrd_id ) ? '' : sanitize_text_field( wp_unslash( $wrd_id ) ) );
$question_id = ( empty( $que_id ) ? '' : sanitize_text_field( wp_unslash( $que_id ) ) );
$options_id = ( empty( $opt_id ) ? '' : sanitize_text_field( wp_unslash( $opt_id ) ) );
$add_new_qsave = __( 'Save', 'woo-product-finder' );
$edit_new_qsave = __( 'Update', 'woo-product-finder' );
$submitWizardQuestion = filter_input( INPUT_POST, 'submitWizardQuestion', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$_wp_http_referer = filter_input( INPUT_POST, '_wp_http_referer', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$question_id = ( isset( $question_id ) && !empty( $question_id ) ? $question_id : filter_input( INPUT_POST, 'question_id', FILTER_SANITIZE_FULL_SPECIAL_CHARS ) );
$question_name = filter_input( INPUT_POST, 'question_name', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$question_type = filter_input( INPUT_POST, 'question_type', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$submitWizardQuestion = filter_input( INPUT_POST, 'submitWizardQuestion', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$options_id = filter_input(
    INPUT_POST,
    'options_id',
    FILTER_DEFAULT,
    FILTER_REQUIRE_ARRAY
);
$options_name = filter_input(
    INPUT_POST,
    'options_name',
    FILTER_DEFAULT,
    FILTER_REQUIRE_ARRAY
);
$hf_option_single_upload_file_src = filter_input(
    INPUT_POST,
    'hf_option_single_upload_file_src',
    FILTER_DEFAULT,
    FILTER_REQUIRE_ARRAY
);
$attribute_name = filter_input(
    INPUT_POST,
    'attribute_name',
    FILTER_DEFAULT,
    FILTER_REQUIRE_ARRAY
);
$attribute_value = filter_input(
    INPUT_POST,
    'attribute_value',
    FILTER_DEFAULT,
    FILTER_REQUIRE_ARRAY
);
$attribute_next = filter_input(
    INPUT_POST,
    'attribute_next',
    FILTER_DEFAULT,
    FILTER_REQUIRE_ARRAY
);
$queation_setting_arr['_wpnonce'] = $retrieved_nonce;
$queation_setting_arr['_wp_http_referer'] = ( empty( $_wp_http_referer ) ? '' : sanitize_text_field( wp_unslash( $_wp_http_referer ) ) );
$queation_setting_arr['question_id'] = ( empty( $question_id ) ? '' : sanitize_text_field( wp_unslash( $question_id ) ) );
$queation_setting_arr['question_name'] = ( empty( $question_name ) ? '' : sanitize_text_field( wp_unslash( $question_name ) ) );
$queation_setting_arr['question_type'] = ( empty( $question_type ) ? '' : sanitize_text_field( wp_unslash( $question_type ) ) );
$queation_setting_arr['submitWizardQuestion'] = ( empty( $submitWizardQuestion ) ? '' : sanitize_text_field( wp_unslash( $submitWizardQuestion ) ) );
$queation_setting_arr['submitWizardQuestion'] = ( empty( $submitWizardQuestion ) ? '' : sanitize_text_field( wp_unslash( $submitWizardQuestion ) ) );
$queation_setting_arr['options_id'] = ( isset( $options_id ) && !empty( $options_id ) ? $options_id : array() );
$queation_setting_arr['options_name'] = ( isset( $options_name ) && !empty( $options_name ) ? $options_name : array() );
$queation_setting_arr['hf_option_single_upload_file_src'] = ( isset( $hf_option_single_upload_file_src ) && !empty( $hf_option_single_upload_file_src ) ? $hf_option_single_upload_file_src : array() );
$queation_setting_arr['attribute_name'] = ( isset( $attribute_name ) && !empty( $attribute_name ) ? $attribute_name : array() );
$queation_setting_arr['attribute_value'] = ( isset( $attribute_value ) && !empty( $attribute_value ) ? $attribute_value : array() );
$queation_setting_arr['attribute_next'] = ( isset( $attribute_next ) && !empty( $attribute_next ) ? $attribute_next : array() );
if ( isset( $submitWizardQuestion ) && $submitWizardQuestion === $add_new_qsave ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wizardquestionfrm' ) ) {
        die( 'Failed security check' );
    } else {
        if ( method_exists( $this, 'wpfp_wizard_question_save' ) ) {
            // phpcs:ignore
            $this->wpfp_wizard_question_save( $queation_setting_arr, $wizard_id );
            // phpcs:ignore
        }
    }
} else {
    if ( isset( $submitWizardQuestion ) && $submitWizardQuestion === $edit_new_qsave ) {
        if ( !wp_verify_nonce( $retrieved_nonce, 'wizardquestionfrm' ) ) {
            die( 'Failed security check' );
        } else {
            if ( method_exists( $this, 'wpfp_wizard_question_save' ) ) {
                // phpcs:ignore
                $this->wpfp_wizard_question_save( $queation_setting_arr, $wizard_id );
                // phpcs:ignore
            }
        }
    }
}
if ( isset( $_REQUEST['action'] ) && sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) === 'edit' ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wppfcnonce' ) ) {
        die( 'Failed security check' );
    } else {
        $btnValue = __( 'Update', 'woo-product-finder' );
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $get_rows = $wpdb->get_row( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions WHERE id=%d AND wizard_id = %d", $question_id, $wizard_id ) );
        // phpcs:ignore
        if ( !empty( $get_rows ) && isset( $get_rows ) ) {
            $question_name = esc_attr( $get_rows->name );
            $question_type = esc_attr( $get_rows->option_type );
        }
    }
} else {
    $btnValue = __( 'Save', 'woo-product-finder' );
    $question_name = '';
    $question_type = '';
}
if ( isset( $_REQUEST['action'] ) && sanitize_text_field( wp_unslash( $_REQUEST['action'] ) ) === 'delete' ) {
    if ( !wp_verify_nonce( $retrieved_nonce, 'wppfcnonce' ) ) {
        die( 'Failed security check' );
    } else {
        $questions_table_name = WPFPFW_QUESTIONS_PRO_TABLE;
        $delete_sql = $wpdb->delete( $questions_table_name, array(
            'id'        => esc_attr( $question_id ),
            'wizard_id' => esc_attr( $wizard_id ),
        ), array('%d', '%d') );
        // phpcs:ignore
        if ( $delete_sql === '1' ) {
            wp_redirect( esc_url( home_url( '/wp-admin/admin.php?page=wpfp-edit-wizard&id=' . esc_attr( $wizard_id ) . '&action=edit&_wpnonce=' . esc_attr( $retrieved_nonce ) ) ) );
            exit;
        } else {
            echo 'Error Happens.Please try again';
            wp_redirect( esc_url( home_url( '/wp-admin/admin.php?page=wpfp-question-list&wrd_id=' . esc_attr( $wizard_id ) . '' ) ) );
            exit;
        }
    }
}
################# Options save ######################
$submitOptions = filter_input( INPUT_POST, 'submitOptions', FILTER_SANITIZE_FULL_SPECIAL_CHARS );
$submitOptions = ( empty( $submitOptions ) ? '' : sanitize_text_field( wp_unslash( $submitOptions ) ) );
$sel_options_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions_options WHERE wizard_id=%d AND question_id=%d ORDER BY sortable_id ASC", $wizard_id, $question_id ) );
// phpcs:ignore
?>
<div class="wpfp-main-table wpfp-question-table res-cl">
    <h2>
        <?php 
esc_html_e( 'Question Configuration', 'woo-product-finder' );
?>
        <a class="add-new-btn back-button button-secondary"  id="back_button" href="<?php 
echo esc_url( home_url( '/wp-admin/admin.php?page=wpfp-list' ) );
?>"><?php 
esc_html_e( 'Back to wizard list', 'woo-product-finder' );
?></a>
        <a class="add-new-btn back-button button-secondary"  id="back_button" href="<?php 
echo esc_url( home_url( '/wp-admin/admin.php?page=wpfp-edit-wizard&wrd_id=' . esc_attr( $wizard_id ) . '&action=edit&_wpnonce=' . esc_attr( wp_create_nonce( 'wppfcnonce' ) ) ) );
?>"><?php 
esc_html_e( 'Back to wizard configuration', 'woo-product-finder' );
?></a>
    </h2>
    <form method="POST" name="wizardquestionfrm" action="" id="wizardquestionfrm">
        <?php 
wp_nonce_field( 'wizardquestionfrm' );
?>
        <input type="hidden" name="question_id" value="<?php 
echo esc_attr( $question_id );
?>">
        <table class="form-table table-outer question-table all-table-listing">
            <tbody>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="question_name"><?php 
esc_html_e( 'Question Title', 'woo-product-finder' );
?><span class="required-star">*</span></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <input type="text" name="question_name" class="text-class half_width" id="question_name" value="<?php 
echo ( !empty( esc_attr( $question_name ) ) ? esc_attr( $question_name ) : '' );
?>" required="1" placeholder="<?php 
esc_attr( 'Enter Question Title Here' );
?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
esc_html_e( 'Question Description Here ( EX: I prefer my shoes to be )', 'woo-product-finder' );
?></p>
                    </td>
                </tr>
                <tr valign="top">
                    <th class="titledesc" scope="row">
                        <label for="question_type"><?php 
esc_html_e( 'Question Type', 'woo-product-finder' );
?></label>
                    </th>
                    <td class="forminp mdtooltip">
                        <select name="question_type" id="question_type">
                            <option value="radio" <?php 
echo ( !empty( esc_attr( $question_type ) ) && esc_attr( $question_type ) === 'radio' ? 'selected="selected"' : '' );
?>><?php 
esc_html_e( 'Radio', 'woo-product-finder' );
?></option>
                            <?php 
?>
                                        <option value="checkbox_in_pro"><?php 
esc_html_e( 'Checkbox 🔒', 'woo-product-finder' );
?></option>
                                    <?php 
?>
                        </select>
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description">
                            <?php 
esc_html_e( 'Select questions type radio or checkbox', 'woo-product-finder' );
?>
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>

        <div class="option_header_title" id="option_header_title">
            <h2>
                <?php 
esc_html_e( 'Manage Options', 'woo-product-finder' );
?>
                <a class="add-new-btn dots-btn-with-brand-color"  id="add_new_options" href="javascript:void( 0 );"><?php 
esc_html_e( WPFPFW_ADD_NEW_OPTIONS, 'woo-product-finder' );
?></a>
            </h2>
        </div>

        <div id="accordion" class="accordian_custom_class">
            <?php 
if ( !empty( $sel_options_rows ) && $sel_options_rows !== '' && isset( $sel_options_rows ) && is_array( $sel_options_rows ) ) {
    foreach ( $sel_options_rows as $sel_options_data ) {
        $options_id = sanitize_text_field( $sel_options_data->id );
        $wizard_id = sanitize_text_field( $sel_options_data->wizard_id );
        $question_id = sanitize_text_field( $sel_options_data->question_id );
        $option_name = ( empty( $sel_options_data->option_name ) ? '' : sanitize_text_field( wp_unslash( $sel_options_data->option_name ) ) );
        $option_image = ( empty( $sel_options_data->option_image ) ? '' : sanitize_text_field( wp_unslash( $sel_options_data->option_image ) ) );
        $option_attribute = sanitize_text_field( $sel_options_data->option_attribute );
        $option_attribute_db = sanitize_text_field( $sel_options_data->option_attribute_db );
        $option_attribute_value = $sel_options_data->option_attribute_value;
        $option_attribute_next = $sel_options_data->option_attribute_next;
        $question_query_rows = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$wpdb->prefix}wpfp_questions WHERE wizard_id=%d AND NOT id = %d  ORDER BY sortable_id ASC", $wizard_id, $question_id ) );
        // phpcs:ignore
        if ( !empty( $option_image ) && $option_image !== '' && isset( $option_image ) ) {
            $image_display_none = 'block';
        } else {
            $image_display_none = 'none';
        }
        ?>
                    <div class="options_rank_class" id="options_rank_<?php 
        echo esc_attr( $options_id );
        ?>">
                        <input type="hidden" name="options_id[][<?php 
        echo esc_attr( $options_id );
        ?>]" value="<?php 
        echo esc_attr( $options_id );
        ?>">
                        <h3>
                            <?php 
        esc_html_e( $option_name, 'woo-product-finder' );
        ?>
                            <a href="javascript:void( 0 );" class="remove_option_row delete" id="remove_option_<?php 
        echo esc_attr( $options_id );
        ?>"><i class="fa fa-trash-o" aria-hidden="true"></i></a>
                        </h3>
                        <div>
                            <table class="form-table table-outer option-table all-table-listing" id="option_section">
                                <tbody>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="options_name"><?php 
        esc_html_e( 'Options Title', 'woo-product-finder' );
        ?><span class="required-star">*</span></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <input type="text" name="options_name[][<?php 
        echo esc_attr( $options_id );
        ?>]" class="text-class half_width" id="options_name_id_<?php 
        echo esc_attr( $options_id );
        ?>" value="<?php 
        echo esc_attr( $option_name );
        ?>" required="1" placeholder="<?php 
        esc_attr( 'Enter Options Title Here' );
        ?>">
                                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php 
        esc_html_e( 'If you are creating wizard based on shoes, then you want to enter option title related to attribute value ( EX: Attribute value is male, then you should keep option name : Male )', 'woo-product-finder' );
        ?></p>
                                            <br/><span class="error_msg" id="error_option_name_<?php 
        echo esc_attr( $options_id );
        ?>" style="display:none;"><?php 
        esc_html_e( 'Please Enter Options Title Here', 'woo-product-finder' );
        ?></span>
                                        </td>
                                    </tr>
                                    <?php 
        ?>
                                            <tr valign="top">
                                                <th class="titledesc" scope="row">
                                                    <label for="options_image"><?php 
        esc_html_e( 'Options Image', 'woo-product-finder' );
        ?><div class="pf-pro-label"></div></label>
                                                </th>
                                                <td class="forminp mdtooltip option_image_section">
                                                    <div class="product_cost_left_div">
                                                        <a class="option_single_upload_file button-secondary" disabled="disabled" uploader_button_text="Include File" ><?php 
        esc_html_e( 'Upload File', 'woo-product-finder' );
        ?></a>
                                                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                                        <p class="description"><?php 
        esc_html_e( 'Upload Options Image Here', 'woo-product-finder' );
        ?></p>
                                                    </div>
                                                    <div class="option_single_upload_file_div">
                                                        <img class="option_single_image_src" id="option_single_upload_file_id_<?php 
        echo esc_attr( $options_id );
        ?>" name="option_single_upload_file_name[][<?php 
        echo esc_attr( $options_id );
        ?>]" style="display:<?php 
        echo esc_attr( $image_display_none );
        ?>;" src="<?php 
        echo esc_url( $option_image );
        ?>" width="100px" height="100px"/>
                                                        <input type="hidden" name="hf_option_single_upload_file_src[][<?php 
        echo esc_attr( $options_id );
        ?>]" id="hf_option_single_upload_file_src_<?php 
        echo esc_attr( $options_id );
        ?>" value="<?php 
        echo esc_url( $option_image );
        ?>">
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php 
        ?>
                                    <tr valign="top">
                                        <th class="titledesc" scope="row">
                                            <label for="attribute_name"><?php 
        esc_html_e( 'Attribute Name', 'woo-product-finder' );
        ?><span class="required-star">*</span></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <select id="attribute_name_<?php 
        echo esc_attr( $options_id );
        ?>" data-placeholder="<?php 
        esc_attr( 'Please type attribute slug' );
        ?>" name="attribute_name[][<?php 
        echo esc_attr( $options_id );
        ?>]" class="chosen-select-attribute-value attribute-value chosen-rtl">
                                                <option value=""></option>
                                                <option value="<?php 
        echo esc_attr( trim( $option_attribute ) );
        ?>==<?php 
        echo esc_attr( trim( $option_attribute_db ) );
        ?>" data-name=<?php 
        echo esc_attr( trim( $option_attribute_db ) );
        ?> data-value1=<?php 
        echo esc_attr( trim( $option_attribute_value ) );
        ?>><?php 
        echo esc_html_e( $this->wpfp_replace_slash( stripslashes( $option_attribute ) ), 'woo-product-finder' );
        // phpcs:ignore
        ?></option>
                                                <?php 
        ?>
                                            </select>
                                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php 
        esc_html_e( 'Select attribute name which is created in Product attribute section (Ex. Attribute name: Gender Attribute value: gender) type attribute value gender', 'woo-product-finder' );
        ?></p>
                                            <br/><span class="error_msg" id="error_attribute_name_<?php 
        echo esc_attr( $options_id );
        ?>" style="display:none;"><?php 
        esc_html_e( 'Please Select Attribute Name', 'woo-product-finder' );
        ?></span>
                                        </td>
                                    </tr>
                                    <tr valign="top" class="attribute_value_tr">
                                        <th class="titledesc" scope="row">
                                            <label for="attributr_value"><?php 
        esc_html_e( 'Attribute Value', 'woo-product-finder' );
        ?><span class="required-star">*</span></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <select id="attribute_value_<?php 
        echo esc_attr( $options_id );
        ?>" data-placeholder="<?php 
        echo esc_attr( 'Select Attribute Value' );
        ?>" name="attribute_value[][<?php 
        echo esc_attr( $options_id );
        ?>]" multiple="true" class="chosen-select-attribute-value category-select chosen-rtl attribute_value multiselect2" required multiple="multiple">
                                                <option value=""></option>
                                                <?php 
        if ( strpos( $option_attribute_value, ',' ) !== false ) {
            $option_attribute_value_ex = explode( ',', sanitize_text_field( $option_attribute_value ) );
        } else {
            $option_attribute_value_ex = array(sanitize_text_field( $option_attribute_value ));
        }
        foreach ( $option_attribute_value_ex as $key => $values ) {
            // phpcs:ignore
            ?>
                                                        <option value="<?php 
            echo esc_attr( trim( $values ) );
            ?>"><?php 
            echo esc_html_e( trim( $values ), 'woo-product-finder' );
            ?></option>
                                                        <?php 
        }
        ?>
                                            </select>
                                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php 
        esc_html_e( 'Select attribute value which is created in Product attribute section', 'woo-product-finder' );
        ?></p>
                                            <br/><span class="error_msg" id="error_attribute_value_<?php 
        echo esc_attr( $options_id );
        ?>" style="display:none;"><?php 
        esc_html_e( 'Please Select Attribute Value', 'woo-product-finder' );
        ?></span>
                                        </td>
                                    </tr>
                                    <tr valign="top" class="attribute_next_tr">
                                        <th class="titledesc" scope="row">
                                            <label for="attributr_next"><?php 
        esc_html_e( 'Next question', 'woo-product-finder' );
        ?><span class="required-star"></span></label>
                                        </th>
                                        <td class="forminp mdtooltip">
                                            <select id="attribute_next_<?php 
        echo esc_attr( $options_id );
        ?>" name="attribute_next[][<?php 
        echo esc_attr( $options_id );
        ?>]" class="attribute_next">
                                                <option value=""><?php 
        echo esc_html_e( 'Select Next Question', 'woo-product-finder' );
        ?></option>
                                                <?php 
        if ( isset( $question_query_rows ) && !empty( $question_query_rows ) ) {
            foreach ( $question_query_rows as $values ) {
                $selected = ( $option_attribute_next === $values->id ? 'selected' : '' );
                ?>
                                                            <option <?php 
                echo esc_attr( $selected );
                ?> value="<?php 
                echo esc_attr( $values->id );
                ?>">(#<?php 
                echo esc_html_e( $values->id, 'woo-product-finder' );
                ?>) <?php 
                echo esc_html_e( $values->name, 'woo-product-finder' );
                ?></option>
                                                        <?php 
            }
        }
        ?>
                                            </select>
                                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                            <p class="description"><?php 
        esc_html_e( 'Set next question for this option.', 'woo-product-finder' );
        ?></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <?php 
    }
}
?>
            <div id="extra_div">
            </div>
        </div>
        <p class="submit"><input type="submit" name="submitWizardQuestion" id="submitWizardQuestion" class="button button-primary" value="<?php 
echo esc_attr( $btnValue );
?>"></p>
    </form>
</div>
</div>
</div>
</div>
</div>
