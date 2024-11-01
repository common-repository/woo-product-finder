<?php

if ( !defined( 'ABSPATH' ) ) {
    exit;
}
require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
// Free plugin wizard settings content
function wpfp_free_wizard_settings_content() {
    ?>
    <div class="wpfp-main-table res-cl wpfp-upgrade-pro-to-unlock">
        <h2><?php 
    esc_html_e( 'Wizard Settings', 'woo-product-finder' );
    ?><div class="pf-pro-label"></div></h2>
        <form method="POST" name="wizardsettingfrm_pro" action="">
            <table class="form-table table-outer product-fee-table ">
                <tbody>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label for="perfect_match_title"><?php 
    esc_html_e( WPFPFW_PERFECT_MATCH_TITLE, 'woo-product-finder' );
    ?></label></th>
                        <td class="forminp mdtooltip">
                            <input type="text" name="perfect_match_title" class="text-class half_width" id="perfect_match_title" value="" placeholder="<?php 
    echo esc_attr( 'Top Product( s )' );
    ?>">
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description"><?php 
    esc_html_e( 'Complete matched product title based on your requirements', 'woo-product-finder' );
    ?></p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label for="recent_match_title"><?php 
    esc_html_e( WPFPFW_RECENT_MATCH_TITLE, 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="text" name="recent_match_title" class="text-class half_width" id="recent_match_title" value="" placeholder="<?php 
    echo esc_attr( 'Products meeting most of your requirements' );
    ?>">
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Recently matched product title based on your requirements', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label for="show_attribute_field"><?php 
    esc_html_e( 'Display Attribute Per Product', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="number" name="show_attribute_field" class="text-class" step="1" id="show_attribute_field" value="" placeholder="<?php 
    echo esc_attr( 'Display Attribute' );
    ?>" min="1">
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'How many attribute display per product?', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label for="backend_limit"><?php 
    esc_html_e( 'Products Per Page', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="number" name="backend_limit" class="text-class" id="backend_limit" value="" placeholder="<?php 
    echo esc_attr( 'Products Per Page' );
    ?>" min="1">
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'How many product display per page?', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label for="option_row_item_id"><?php 
    esc_html_e( 'How many options item display in a one row?', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <select name="option_row_item" id="option_row_item_id">
                                <option value="1"><?php 
    esc_html_e( '1', 'woo-product-finder' );
    ?></option>
                            </select>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Display options in a one row. (EX: Two Option name display in a one row)', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top" class="text_color">
                        <th class="titledesc" scope="row">
                            <label for="text_color_wizard_title_id"><?php 
    esc_html_e( 'Text color for wizard title', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="text" value="" class="wp-color-picker-field" data-default-color="#ffffff" name="text_color_wizard_title" id="text_color_wizard_title_id"/>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Text color is display on wizard title.', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label for="background_image_for_questions"><?php 
    esc_html_e( 'Background Image For Question', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip option_image_section">
                            <div class="product_cost_left_div">
                                <a class="option_single_upload_file button-secondary" id="background_image_for_questions_upload_file_tag_id_" uploader_title="<?php 
    echo esc_attr( 'Select File' );
    ?>" uploader_button_text="Include File" data-uploadname="background_image_for_questions_upload_file"><?php 
    esc_html_e( 'Upload File', 'woo-product-finder' );
    ?></a>
                                <a class="option_single_remove_file button-secondary" id="background_image_for_questions_upload_file_id_" data-uploadname="background_image_for_questions_upload_file"><?php 
    esc_html_e( 'Remove File', 'woo-product-finder' );
    ?></a>
                                <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                                <p class="description"><?php 
    esc_html_e( 'Upload Background image here which is display in front side background of all question list', 'woo-product-finder' );
    ?></p>
                            </div>
                        </td>
                    </tr>
                    <tr valign="top" class="background_color">
                        <th class="titledesc" scope="row">
                            <label for="background_color_id"><?php 
    esc_html_e( 'Background color', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="text" value="" class="wp-color-picker-field" data-default-color="#434344" name="background_color" id="background_color_id"/>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Background color is display on specific button,Top Product Title,Products meeting most of your requirements title and pagination', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top" class="text_color">
                        <th class="titledesc" scope="row">
                            <label for="text_color_id"><?php 
    esc_html_e( 'Text color', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="text" value="" class="wp-color-picker-field" data-default-color="#ffffff" name="text_color" id="text_color_id"/>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Text color is display on specific button,Top Product Title,Products meeting most of your requirements title and pagination text', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top" class="background_np_button_color">
                        <th class="titledesc" scope="row">
                            <label for="background_np_button_color_id"><?php 
    esc_html_e( 'Background color for next and prev button', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="text" value="" class="wp-color-picker-field" data-default-color="#434344" name="background_np_button_color" id="background_np_button_color_id"/>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Background color is display on next and prev button', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top" class="text_np_button_color">
                        <th class="titledesc" scope="row">
                            <label for="text_np_button_color_id"><?php 
    esc_html_e( 'Text color for next and prev button', 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="text" value="" class="wp-color-picker-field" data-default-color="#ffffff" name="text_np_button_color" id="text_np_button_olor_id"/>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Text color is display on next and prev button', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top" class="background_color">
                        <th class="titledesc" scope="row">
                            <label for="background_color_for_options_id"><?php 
    esc_html_e( WPFPFW_BACKGROUND_COLOR_FOR_OPTIONS, 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="text" value="" class="wp-color-picker-field" data-default-color="#ffffff" name="background_color_for_options" id="background_color_for_options_id"/>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Background color is display on option title.', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top" class="text_color">
                        <th class="titledesc" scope="row">
                            <label for="text_color_for_options_id"><?php 
    esc_html_e( WPFPFW_TEXT_COLOR_FOR_OPTIONS, 'woo-product-finder' );
    ?></label>
                        </th>
                        <td class="forminp mdtooltip">
                            <input type="text" value="" class="wp-color-picker-field" data-default-color="#000000" name="text_color_for_options" id="text_color_for_options_id"/>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description">
                                <?php 
    esc_html_e( 'Text color is display on option title.', 'woo-product-finder' );
    ?>
                            </p>
                        </td>
                    </tr>
                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="reload_title"><?php 
    esc_html_e( 'Reload Title', 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="reload_title" class="text-class half_width" id="reload_title" value="" placeholder="<?php 
    esc_attr( WPFPFW_RELOAD_TITLE_PLACEHOLDER );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( WPFPFW_RELOAD_TITLE_DESCRIPTION, 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>
                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="next_title"><?php 
    esc_html_e( 'Next', 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="next_title" class="text-class half_width" id="next_title" value="" placeholder="<?php 
    esc_attr( 'Next Title' );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'You can add your own Next button text which display at front on pagination.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>

                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="back_title"><?php 
    esc_html_e( WPFPFW_BACK_TITLE, 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="back_title" class="text-class half_width" id="back_title" value="" placeholder="<?php 
    esc_attr( 'Back Title' );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'You can add your own Back button text which display at front on pagination.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>
                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="show_result_title"><?php 
    esc_html_e( WPFPFW_SHOW_RESULT_TITLE, 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="show_result_title" class="text-class half_width" id="show_result_title" value="" placeholder="<?php 
    esc_attr( 'Show Result Title' );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'You can add your own Show result button text which display at front on pagination.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>
                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="restart_title"><?php 
    esc_html_e( WPFPFW_RESTART_TITLE, 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="restart_title" class="text-class half_width" id="restart_title" value="" placeholder="<?php 
    esc_attr( 'Restart Title' );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'You can add your own Restart button text which display at front on pagination.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>
                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="detail_title"><?php 
    esc_html_e( 'Detail', 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="detail_title" class="text-class half_width" id="detail_title" value="" placeholder="<?php 
    esc_attr( 'Detail Title' );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'You can add your own Product filtered detail link label at front side.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>

                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="congratulations_title"><?php 
    esc_html_e( 'Congratulations', 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="congratulations_title" class="text-class half_width" id="congratulations_title" value="" placeholder="<?php 
    esc_attr( 'Congratulations Title' );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'You can add your own Congratulations message label at front side.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>
                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="congratulations_message_title"><?php 
    esc_html_e( WPFPFW_CONGRATULATIONS_MESSAGE_TITLE, 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="congratulations_message_title" class="text-class half_width" id="congratulations_message_title" value="" placeholder="<?php 
    esc_attr( 'WE FOUND THE PERFECT PRODUCT FOR YOU!' );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'You can add your own Congratulations message label at front side.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>
                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="total_count_title"><?php 
    esc_html_e( WPFPFW_TOTAL_COUNT_TITLE, 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <input type="text" name="total_count_title" class="text-class half_width" id="total_count_title" value="" placeholder="<?php 
    esc_attr( 'item(s)' );
    ?>">
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'You can add your own Label for total count items after filter.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>
                    <tr valign="top">
                      <th class="titledesc" scope="row">
                        <label for="total_count_title"><?php 
    esc_html_e( 'Product List View', 'woo-product-finder' );
    ?></label></th>
                      <td class="forminp mdtooltip">
                        <select name="option_product_list" class="half_width" id="option_product_list">
                            <option value="list"><?php 
    esc_html_e( 'List', 'woo-product-finder' );
    ?></option>
                        </select>
                        <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                        <p class="description"><?php 
    esc_html_e( 'Set your own listing type of results.', 'woo-product-finder' );
    ?></p>
                      </td>
                    </tr>
                    <tr valign="top">
                        <th class="titledesc" scope="row">
                            <label for="wizard_status"><?php 
    esc_html_e( 'Product Fields', 'woo-product-finder' );
    ?></label>
                            (<small class="form-text text-muted"><?php 
    esc_html_e( 'Title field is required', 'woo-product-finder' );
    ?></small>)
                        </th>
                        <td class="forminp mdtooltip">
                            <div class="wizard-product-fields">
                                <div class="switch-wrapper">
                                    <label class="switch" style="pointer-events:none;">
                                        <input type="checkbox" name="wizard_product_fields[]" value="title" checked>
                                        <div class="slider round"></div>
                                    </label>
                                    <?php 
    esc_html_e( 'Product Title', 'woo-product-finder' );
    ?>
                                </div>
                                <div class="switch-wrapper">
                                    <label class="switch">
                                        <input type="checkbox" name="wizard_product_fields[]" value="thumbnail" checked>
                                        <div class="slider round"></div>
                                    </label>
                                    <?php 
    esc_html_e( 'Product Thumbnail', 'woo-product-finder' );
    ?>
                                </div>
                                <div class="switch-wrapper">
                                    <label class="switch">
                                        <input type="checkbox" name="wizard_product_fields[]" value="attributes" checked>
                                        <div class="slider round"></div>
                                    </label>
                                    <?php 
    esc_html_e( 'Product Attributes', 'woo-product-finder' );
    ?>
                                </div>
                                <div class="switch-wrapper">
                                    <label class="switch">
                                        <input type="checkbox" name="wizard_product_fields[]" value="description" checked>
                                        <div class="slider round"></div>
                                    </label>
                                    <?php 
    esc_html_e( 'Product Short Description', 'woo-product-finder' );
    ?>
                                </div>
                                <div class="switch-wrapper">
                                    <label class="switch">
                                        <input type="checkbox" name="wizard_product_fields[]" value="add-to-cart">
                                        <div class="slider round"></div>
                                    </label>
                                    <?php 
    esc_html_e( 'Add to Cart Button', 'woo-product-finder' );
    ?>
                                </div>
                                <div class="switch-wrapper">
                                    <label class="switch">
                                        <input type="checkbox" name="wizard_product_fields[]" value="hide-wizard-box">
                                        <div class="slider round"></div>
                                    </label>
                                    <?php 
    esc_html_e( 'Hide Wizard Box Last Step', 'woo-product-finder' );
    ?>
                                </div>
                            </div>
                            <span class="woocommerce_wpfp_tab_descirtion"><i class="fa fa-question-circle " aria-hidden="true"></i></span>
                            <p class="description"><?php 
    esc_html_e( 'Select fields to showcase on product finder wizards', 'woo-product-finder' );
    ?></p>
                        </td>
                    </tr>
                </tbody>
            </table>
            <p class="submit" style="opacity:0.7;"><input type="button" name="submitWizardSetting" class="button button-primary" value="<?php 
    echo esc_attr( 'Save' );
    ?>"></p>
        </form>
    </div>
    <?php 
}

wpfp_free_wizard_settings_content();
?>
</div>
</div>
</div>
</div>
