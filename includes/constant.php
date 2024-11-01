<?php

/**
 * define constant variabes
 * define admin side constant
 * @since 1.0.0
 * @author Multidots
 * @param null
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
global $wpdb;

// define constant for plugin slug
define( 'WPFPFW_WOO_PRODUCT_FINDER_PRO_PLUGIN_SLUG', 'woo-product-finder' );
define( 'WPFPFW_WOO_PRODUCT_FINDER_PRO_PLUGIN_NAME', __( 'Product Recommendation Quiz', 'woo-product-finder' ) );
define( 'WPFPFW_WOO_PRODUCT_FINDER_PLUGIN_NAME', __( 'Product Recommendation Quiz', 'woo-product-finder' ) );
define( 'WPFPFW_WOO_PRODUCT_FINDER_PRO_TEXT_DOMAIN', 'woo-product-finder' );
define( 'WPFPFW_PLUGIN_VERSION', '2.0.0' );
define( 'WPFPFW_PRO_PLUGIN', 'Pro Version' );
define( 'WPFPFW_FREE_PLUGIN', 'Free Version' );
define( 'WPFPFW_EXPETRANL_URL', esc_url( 'https://www.thedotstore.com/woocommerce-product-finder/' ) );

####### Header Section #######
define( 'WPFPFW_GENERAL_SETTING_PAGE_TITLE', 'General Setting' );
define( 'WPFPFW_PREMIUM_VERSION', 'Premium Version' );
define( 'WPFPFW_ABOUT_PLUGIN', 'About Plugin' );
define( 'WPFPFW_GETTING_STARTED', 'Getting Started' );
define( 'WPFPFW_QUICK_INFO', 'Quick info' );

####### Sidebar Section #######
define( 'WPFPFW_WOOCOMMERCE_PLUGINS', 'WooCommerce Plugins' );
define( 'WPFPFW_WORDPRESS_PLUGINS', 'Wordpress Plugins' );
define( 'WPFPFW_FREE_PLUGINS', 'Free Plugins' );
define( 'WPFPFW_FREE_THEMES', 'Free Themes' );
define( 'WPFPFW_CONTACT_SUPPORT', 'Contact Support' );

####### Wizard Page Constant #######
define( 'WPFPFW_LIST_PAGE_TITLE', 'Manage Wizards' );
define( 'WPFPFW_GLOBAL_SETTINGS_RESULT_TYPE_TITLE', 'Want to display product finder result at last?' );
define( 'WPFPFW_DELETE_LIST_NAME', 'Delete ( Selected )' );
define( 'WPFPFW_ADD_NEW_WIZARD', 'Add New Wizard' );
define( 'WPFPFW_EDIT_WIZARD', 'Edit Wizard' );
define( 'WPFPFW_BACK_TO_WIZARD_LIST', 'Back to wizard list' );
define( 'WPFPFW_BACK_TO_EDIT_WIZARD_CONFIGURATION', 'Back to wizard configuration' );

define( 'WPFPFW_WIZARD_TITLE', 'Wizard Title' );
define( 'WPFPFW_WIZARD_TITLE_PLACEHOLDER', 'Enter Wizard Title Here' );
define( 'WPFPFW_WIZARD_TITLE_DESCRIPTION', 'Wizard title will display in front side at top of product list ( EX:HELP ME PICK MY SHOES! )' );
define( 'WPFPFW_WIZARD_CATEGORY_TITLE', 'Wizard Category' );
define( 'WPFPFW_WIZARD_CATEGORY_TITLE_PLACEHOLDER', 'Select Wizard Category' );
define( 'WPFPFW_WIZARD_CATEGORY_TITLE_DESCRIPTION', 'If you select category, then product will display based on these selected category.' );
define( 'WPFPFW_WIZARD_TAG_TITLE', 'Wizard Tags' );
define( 'WPFPFW_WIZARD_TAG_TITLE_PLACEHOLDER', 'Select Wizard Tag' );
define( 'WPFPFW_WIZARD_TAG_TITLE_DESCRIPTION', 'If you select tags, then product will display based on these selected tags.' );
define( 'WPFPFW_WIZARD_SHORTCODE', 'Wizard Shortcode' );
define( 'WPFPFW_WIZARD_SHORTCODE_DESCRIPTION', 'Paste shortcode in that page where you want to configure recommandation wizard )' );
define( 'WPFPFW_WIZARD_STATUS', 'Status' );
define( 'WPFPFW_WIZARD_OTHER_RESULT', 'Show other result' );
define( 'WPFPFW_WIZARD_FIELDS', 'Product Fields' );

####### Option Page Constant #######
define( 'WPFPFW_ADD_NEW_OPTIONS', 'Add New Option' );

######## Table Name ########
define( 'WPFPFW_WP_TABLE_PREFIX', $wpdb->prefix );
define( 'WPFPFW_PRO_TABLE_PREFIX', "wpfp_" );
define( 'WPFPFW_WIZARDS_PRO_TABLE', WPFPFW_WP_TABLE_PREFIX. WPFPFW_PRO_TABLE_PREFIX . "wizard" );
define( 'WPFPFW_QUESTIONS_PRO_TABLE', WPFPFW_WP_TABLE_PREFIX. WPFPFW_PRO_TABLE_PREFIX . "questions" );
define( 'WPFPFW_OPTIONS_PRO_TABLE', WPFPFW_WP_TABLE_PREFIX. WPFPFW_PRO_TABLE_PREFIX . "questions_options" );


######## Wizard Setting ########
define( 'WPFPFW_PERFECT_MATCH_TITLE', "Top Product( s )" );
define( 'WPFPFW_PERFECT_MATCH_TITLE_PLACEHOLDER', "Top Product( s )" );
define( 'WPFPFW_PERFECT_MATCH_TITLE_DESCRIPTION', "Complete matched product title based on your requirements" );
define( 'WPFPFW_RECENT_MATCH_TITLE', "Products meeting most of your requirements" );
define( 'WPFPFW_RECENT_MATCH_TITLE_PLACEHOLDER', "Products meeting most of your requirements" );
define( 'WPFPFW_RECENT_MATCH_TITLE_DESCRIPTION', "Recently matched product title based on your requirements" );
define( 'WPFPFW_TOTAL_PAGES', "Products Per Page" );
define( 'WPFPFW_TOTAL_PAGES_PLACEHOLDER', "Products Per Page" );
define( 'WPFPFW_TOTAL_PAGES_DESCRIPTION', "How many product display per page?" );
define( 'WPFPFW_GENERAL_SETTING_SAVE', "Save" );
define( 'WPFPFW_SHOW_ATTRIBUTE_TITLE', "Display Attribute Per Product" );
define( 'WPFPFW_SHOW_ATTRIBUTE_PLACEHOLDER', "Display Attribute" );
define( 'WPFPFW_SHOW_ATTRIBUTE_DESCRIPTION', "How many attribute display per product?" );
define( 'WPFPFW_SHOW_ATTRIBUTE_DEFAULT', "3" );
define( 'WPFPFW_DEFAULT_PAGINATION_NUMBER', "5" );
define( 'WPFPFW_DEFAULT_BACKGROUND_COLOR', "#000000" );
define( 'WPFPFW_DEFAULT_TEXT_COLOR', "#ffffff" );

define( 'WPFPFW_DEFAULT_NP_BUTTON_BACKGROUND_COLOR', "#000000" );
define( 'WPFPFW_DEFAULT_NP_BUTTON_TEXT_COLOR', "#ffffff" );
define( 'WPFPFW_DEFAULT_BACKGROUND_IMAGE', esc_url( WPFP_PLUGIN_URL . "images/background_img.jpg" ) );
define( 'WPFPFW_DEFAULT_WIZARD_TEXT_COLOR', "#000000" );
define( 'WPFPFW_DEFAULT_OPTION_BACKGROUND_COLOR', "#ffffff" );
define( 'WPFPFW_DEFAULT_OPTION_TEXT_COLOR', "#000000" );
define( 'WPFPFW_DEFAULT_OPTION_ROW_ITEM', "2" );

define( 'WPFPFW_OPTIONS_ROW_ITEM', "How many options item display in a one row?" );
define( 'WPFPFW_OPTIONS_ROW_ITEM_PLACEHOLDER', "How many options item display in a one row?" );
define( 'WPFPFW_OPTIONS_ROW_ITEM_DESCRIPTION', "Display options in a one row. (EX: Two Option name display in a one row)" );
######## Error Message ########
define( 'WPFPFW_WIZARD_OPTIONS_ERROR_MESSAGE', 'Please Enter Options Title Here' );
define( 'WPFPFW_WIZARD_ATTRIBUTE_NAME_ERROR_MESSAGE', 'Please Select Attribute Name' );
define( 'WPFPFW_WIZARD_OPTIONS_IMAGE_ERROR', 'Invalid file or images( Allow only png,jpg,jpeg or gif )' );
define( 'WPFPFW_WIZARD_ATTRIBUTE_VALUE_ERROR_MESSAGE', 'Please Select Attribute Value' );

######## Wizard Setting #######
define( 'WPFPFW_BACKGROUND_IMAGE_FOR_QUESTIONS_LIST', 'Background Image For Question' );
define( 'WPFPFW_BACKGROUND_IMAGE_FOR_QUESTIONS_UPLOAD_IMAGE', 'Upload File' );
define( 'WPFPFW_BACKGROUND_IMAGE_FOR_QUESTIONS_REMOVE_IMAGE', 'Remove File' );
define( 'WPFPFW_BACKGROUND_IMAGE_FOR_QUESTIONS_SELECT_FILE', 'Select File' );
define( 'WPFPFW_BACKGROUND_IMAGE_FOR_QUESTIONS_LIST_DESCRIPTION', 'Upload Background image here which is display in front side background of all question list' );

define( 'WPFPFW_BACKGROUND_COLOR_TITLE', 'Background color' );
define( 'WPFPFW_BACKGROUND_COLOR_DESCRIPTION', 'Background color is display on specific button,Top Product Title,Products meeting most of your requirements title and pagination' );

define( 'WPFPFW_TEXT_COLOR_TITLE', 'Text color' );
define( 'WPFPFW_TEXT_COLOR_DESCRIPTION', 'Text color is display on specific button,Top Product Title,Products meeting most of your requirements title and pagination text' );

define( 'WPFPFW_TEXT_COLOR_FOR_WIZARD_TITLE', 'Text color for wizard title' );
define( 'WPFPFW_TEXT_COLOR_FOR_WIZARD_DESCRIPTION', 'Text color is display on wizard title.' );

define( 'WPFPFW_BACKGROUND_COLOR_FOR_OPTIONS', 'Background color for options' );
define( 'WPFPFW_BACKGROUND_COLOR_FOR_OPTIONS_DESCRIPTION', 'Background color is display on option title.' );

define( 'WPFPFW_TEXT_COLOR_FOR_OPTIONS', 'Text color for options' );
define( 'WPFPFW_TEXT_COLOR_FOR_OPTIONS_DESCRIPTION', 'Text color is display on option title.' );

define( 'WPFPFW_RELOAD_TITLE', 'Reload Title' );
define( 'WPFPFW_RELOAD_TITLE_PLACEHOLDER', 'Reload Title' );
define( 'WPFPFW_RELOAD_TITLE_DESCRIPTION', 'When you restart the filtering for finder using reload button then this text will display there.' );

define( 'WPFPFW_NEXT_TITLE', 'Next' );
define( 'WPFPFW_NEXT_TITLE_PLACEHOLDER', 'Next Title' );
define( 'WPFPFW_NEXT_TITLE_DESCRIPTION', 'You can add your own Next button text which display at front on pagination.' );

define( 'WPFPFW_BACK_TITLE', 'Back' );
define( 'WPFPFW_BACK_TITLE_PLACEHOLDER', 'Back Title' );
define( 'WPFPFW_BACK_TITLE_DESCRIPTION', 'You can add your own Back button text which display at front on pagination.' );

define( 'WPFPFW_SHOW_RESULT_TITLE', 'Show Result' );
define( 'WPFPFW_SHOW_RESULT_TITLE_PLACEHOLDER', 'Show Result Title' );
define( 'WPFPFW_SHOW_RESULT_TITLE_DESCRIPTION', 'You can add your own Show result button text which display at front on pagination.' );

define( 'WPFPFW_RESTART_TITLE', 'Restart' );
define( 'WPFPFW_RESTART_TITLE_PLACEHOLDER', 'Restart Title' );
define( 'WPFPFW_RESTART_TITLE_DESCRIPTION', 'You can add your own Restart button text which display at front on pagination.' );

define( 'WPFPFW_DETAIL_TITLE', 'Detail' );
define( 'WPFPFW_DETAIL_TITLE_PLACEHOLDER', 'Detail Title' );
define( 'WPFPFW_DETAIL_TITLE_DESCRIPTION', 'You can add your own Product filtered detail link label at front side.' );

define( 'WPFPFW_CONGRATULATIONS_TITLE', 'Congratulations' );
define( 'WPFPFW_CONGRATULATIONS_TITLE_PLACEHOLDER', 'Congratulations Title' );
define( 'WPFPFW_CONGRATULATIONS_TITLE_DESCRIPTION', 'You can add your own Congratulations message label at front side.' );

define( 'WPFPFW_CONGRATULATIONS_MESSAGE_TITLE', 'Message Title' );
define( 'WPFPFW_CONGRATULATIONS_MESSAGE_TITLE_PLACEHOLDER', 'WE FOUND THE PERFECT PRODUCT FOR YOU!' );
define( 'WPFPFW_CONGRATULATIONS_MESSAGE_TITLE_DESCRIPTION', 'You can add your own Congratulations message label at front side.' );

define( 'WPFPFW_TOTAL_COUNT_TITLE', 'Total Count' );
define( 'WPFPFW_TOTAL_COUNT_TITLE_PLACEHOLDER', 'item(s)' );
define( 'WPFPFW_TOTAL_COUNT_TITLE_DESCRIPTION', 'You can add your own Label for total count items after filter.' );

define( 'WPFPFW_BACKGROUND_NP_BUTTON_COLOR_TITLE', 'Background color for next and prev button' );
define( 'WPFPFW_BACKGROUND_NP_BUTTON_COLOR_DESCRIPTION', 'Background color is display on next and prev button' );

define( 'WPFPFW_TEXT_NP_BUTTON_COLOR_TITLE', 'Text color for next and prev button' );
define( 'WPFPFW_TEXT_NP_BUTTON_COLOR_DESCRIPTION', 'Text color is display on next and prev button' );




