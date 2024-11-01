<?php
/**
 * Handles free plugin user dashboard
 * 
 * @package DSFPS_Free_Product_Sample_Pro
 * @since   1.2.0
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

// Get plugin header
require_once( plugin_dir_path( __FILE__ ) . 'header/plugin-header.php' );

// Get product details from Freemius via API
$annual_plugin_price = '';
$monthly_plugin_price = '';
$plugin_details = array(
    'product_id' => 45416,
);

$api_url = add_query_arg(wp_rand(), '', WPFP_STORE_URL . 'wp-json/dotstore-product-fs-data/v2/dotstore-product-fs-data');
$final_api_url = add_query_arg($plugin_details, $api_url);

if ( function_exists( 'vip_safe_wp_remote_get' ) ) {
    $api_response = vip_safe_wp_remote_get( $final_api_url, 3, 1, 20 );
} else {
    $api_response = wp_remote_get( $final_api_url ); // phpcs:ignore
}

if ( ( !is_wp_error($api_response)) && (200 === wp_remote_retrieve_response_code( $api_response ) ) ) {
	$api_response_body = wp_remote_retrieve_body($api_response);
	$plugin_pricing = json_decode( $api_response_body, true );

	if ( isset( $plugin_pricing ) && ! empty( $plugin_pricing ) ) {
		$first_element = reset( $plugin_pricing );
        if ( ! empty( $first_element['price_data'] ) ) {
            $first_price = reset( $first_element['price_data'] )['annual_price'];
        } else {
            $first_price = "0";
        }

        if( "0" !== $first_price ){
        	$annual_plugin_price = $first_price;
        	$monthly_plugin_price = round( intval( $first_price  ) / 12 );
        }
	}
}

// Set plugin key features content
$plugin_key_features = array(
    array(
        'title' => esc_html__( 'Create Dynamic Questionnaires', 'woo-product-finder' ),
        'description' => esc_html__( 'Customize questions to gather user preferences and improve product recommendations.', 'woo-product-finder' ),
        'popup_image' => esc_url( WPFP_PLUGIN_URL . 'admin/images/pro-features-img/feature-box-one-img.png' ),
        'popup_content' => array(
        	esc_html__( 'Design and deploy tailored questionnaires with various input options. Gather user preferences to refine product recommendations and enhance shopping experiences.', 'woo-product-finder' ),
        ),
        'popup_examples' => array(
            esc_html__( 'Add unlimited questions and options.', 'woo-product-finder' ),
            esc_html__( 'Create any type of product quiz, such as personalized skincare quizzes or customized furniture selection.', 'woo-product-finder' ),
        )
    ),
    array(
        'title' => esc_html__( 'Wizards Based on Specific Categories', 'woo-product-finder' ),
        'description' => esc_html__( 'Create wizards tailored to specific brands or categories for targeted product searches.', 'woo-product-finder' ),
        'popup_image' => esc_url( WPFP_PLUGIN_URL . 'admin/images/pro-features-img/feature-box-two-img.png' ),
        'popup_content' => array(
        	esc_html__( 'Create tailored wizards to filter products by specific brands or categories. Enhance user experience with targeted recommendations and relevant product suggestions.', 'woo-product-finder' ),
        ),
        'popup_examples' => array(
            esc_html__( 'Design wizards to filter products by selected categories or tags.', 'woo-product-finder' ),
            esc_html__( ' Provide users with relevant product suggestions based on their preferences.', 'woo-product-finder' ),
        )
    ),
    array(
        'title' => esc_html__( 'Next Question Based on Selected Option', 'woo-product-finder' ),
        'description' => esc_html__( 'Ensure a seamless user experience by adapting subsequent questions based on previous answers.', 'woo-product-finder' ),
        'popup_image' => esc_url( WPFP_PLUGIN_URL . 'admin/images/pro-features-img/feature-box-three-img.png' ),
        'popup_content' => array(
        	esc_html__( 'The next question adapts based on the user\'s previous answers. This keeps the filtering process relevant and helps users find products that match their choices.', 'woo-product-finder' ),
        ),
        'popup_examples' => array(
            esc_html__( 'Questions adjust based on prior answers.', 'woo-product-finder' ),
            esc_html__( 'Create your flow of user answers. ', 'woo-product-finder' ),
            esc_html__( 'Keep the questionnaire focused and engaging. ', 'woo-product-finder' ),
        )
    ),
    array(
        'title' => esc_html__( 'Popular Product Wizard Settings', 'woo-product-finder' ),
        'description' => esc_html__( 'Easily customize the wizard’s look with options for background color, images, and text styling.', 'woo-product-finder' ),
        'popup_image' => esc_url( WPFP_PLUGIN_URL . 'admin/images/pro-features-img/feature-box-four-img.png' ),
        'popup_content' => array(
        	esc_html__( 'Customize the wizard\'s appearance with background colors, images, and text styles.', 'woo-product-finder' ),
        ),
        'popup_examples' => array(
            esc_html__( 'Customize the wizard’s background to match your site’s theme.', 'woo-product-finder' ),
            esc_html__( 'Control visibility and style for titles, thumbnails, attributes, and descriptions.', 'woo-product-finder' ),
        )
    ),
    array(
        'title' => esc_html__( 'Personalized Pricing Advice and Filters', 'woo-product-finder' ),
        'description' => esc_html__( 'Easily set up and manage price ranges in your product wizard to filter results according to user-selected prices.', 'woo-product-finder' ),
        'popup_image' => esc_url( WPFP_PLUGIN_URL . 'admin/images/pro-features-img/feature-box-five-img.png' ),
        'popup_content' => array(
        	esc_html__( 'Adjust the minimum and maximum price fields to refine product recommendations based on budget preferences.', 'woo-product-finder' ),
        ),
        'popup_examples' => array(
            esc_html__( 'Activate the price range feature in the wizard settings to display the price range filter.', 'woo-product-finder' ),
            esc_html__( 'Set minimum and maximum price values for filtering.', 'woo-product-finder' ),
        )
    ),
);
?>
	<div class="fps-section-left">
		<div class="dotstore-upgrade-dashboard">
			<div class="premium-benefits-section">
				<h2><?php esc_html_e( 'Upgrade to Unlock Premium Features', 'woo-product-finder' ); ?></h2>
				<p><?php esc_html_e( 'Upgrade to premium to access advanced features, enhance customer satisfaction, and personalized product listings!', 'woo-product-finder' ); ?></p>
			</div>
			<div class="premium-plugin-details">
				<div class="premium-key-fetures">
					<h3><?php esc_html_e( 'Discover Our Top Key Features', 'woo-product-finder' ) ?></h3>
					<ul>
						<?php 
						if ( isset( $plugin_key_features ) && ! empty( $plugin_key_features ) ) {
							foreach( $plugin_key_features as $key_feature ) {
								?>
								<li>
									<h4><?php echo esc_html( $key_feature['title'] ); ?><span class="premium-feature-popup"></span></h4>
									<p><?php echo esc_html( $key_feature['description'] ); ?></p>
									<div class="feature-explanation-popup-main">
										<div class="feature-explanation-popup-outer">
											<div class="feature-explanation-popup-inner">
												<div class="feature-explanation-popup">
													<span class="dashicons dashicons-no-alt popup-close-btn" title="<?php esc_attr_e('Close', 'woo-product-finder'); ?>"></span>
													<div class="popup-body-content">
														<div class="feature-content">
															<h4><?php echo esc_html( $key_feature['title'] ); ?></h4>
															<?php 
															if ( isset( $key_feature['popup_content'] ) && ! empty( $key_feature['popup_content'] ) ) {
																foreach( $key_feature['popup_content'] as $feature_content ) {
																	?>
																	<p><?php echo esc_html( $feature_content ); ?></p>
																	<?php
																}
															}
															?>
															<ul>
																<?php 
																if ( isset( $key_feature['popup_examples'] ) && ! empty( $key_feature['popup_examples'] ) ) {
																	foreach( $key_feature['popup_examples'] as $feature_example ) {
																		?>
																		<li><?php echo esc_html( $feature_example ); ?></li>
																		<?php
																	}
																}
																?>
															</ul>
														</div>
														<div class="feature-image">
															<img src="<?php echo esc_url( $key_feature['popup_image'] ); ?>" alt="<?php echo esc_attr( $key_feature['title'] ); ?>">
														</div>
													</div>
												</div>		
											</div>
										</div>
									</div>
								</li>
								<?php
							}
						}
						?>
					</ul>
				</div>
				<div class="premium-plugin-buy">
					<div class="premium-buy-price-box">
						<div class="price-box-top">
							<div class="pricing-icon">
								<img src="<?php echo esc_url( WPFP_PLUGIN_URL . 'admin/images/premium-upgrade-img/pricing-1.svg' ); ?>" alt="<?php esc_attr_e( 'Personal Plan', 'woo-product-finder' ); ?>">
							</div>
							<h4><?php esc_html_e( 'Personal', 'woo-product-finder' ) ?></h4>
						</div>
						<div class="price-box-middle">
							<?php
							if ( ! empty( $annual_plugin_price ) ) {
								?>
								<div class="monthly-price-wrap"><?php echo esc_html( '$' . $monthly_plugin_price ) ?><span class="seprater">/</span><span><?php esc_html_e( 'month', 'woo-product-finder' ) ?></span></div>
								<div class="yearly-price-wrap"><?php echo sprintf( esc_html__( 'Pay $%s today. Renews in 12 months.', 'woo-product-finder' ), esc_html( $annual_plugin_price ) ); ?></div>
								<?php
							}
							?>
							<span class="for-site"><?php esc_html_e( '1 site', 'woo-product-finder' ) ?></span>
							<p class="price-desc"><?php esc_html_e( 'Great for website owners with a single WooCommerce Store', 'woo-product-finder' ) ?></p>
						</div>
						<div class="price-box-bottom">
							<a href="javascript:void(0);" class="upgrade-now"><?php esc_html_e( 'Get The Premium Version', 'woo-product-finder' ) ?></a>
							<p class="trusted-by"><?php esc_html_e( 'Trusted by 100,000+ store owners and WP experts!', 'woo-product-finder' ) ?></p>
						</div>
					</div>
					<div class="premium-satisfaction-guarantee premium-satisfaction-guarantee-2">
						<div class="money-back-img">
							<img src="<?php echo esc_url(WPFP_PLUGIN_URL . 'admin/images/premium-upgrade-img/14-Days-Money-Back-Guarantee.png'); ?>" alt="<?php esc_attr_e('14-Day money-back guarantee', 'woo-product-finder'); ?>">
						</div>
						<div class="money-back-content">
							<h2><?php esc_html_e( '14-Day Satisfaction Guarantee', 'woo-product-finder' ) ?></h2>
							<p><?php esc_html_e( 'You are fully protected by our 100% Satisfaction Guarantee. If over the next 14 days you are unhappy with our plugin or have an issue that we are unable to resolve, we\'ll happily consider offering a 100% refund of your money.', 'woo-product-finder' ); ?></p>
						</div>
					</div>
					<div class="plugin-customer-review">
						<h3><?php esc_html_e( 'Best product quiz plugin', 'woo-product-finder' ) ?></h3>
						<p>
							<?php echo wp_kses( __( 'This is the <strong>best product quiz plugin</strong> by far. We have been looking for a product quiz plugin for WooCommerce to use for a long time and <strong>this one is just what we need</strong>!', 'woo-product-finder' ), array(
					                'strong' => array(),
					            ) ); 
				            ?>
			            </p>
						<div class="review-customer">
							<div class="customer-img">
								<img src="<?php echo esc_url(WPFP_PLUGIN_URL . 'admin/images/premium-upgrade-img/customer-profile-img.jpeg'); ?>" alt="<?php esc_attr_e('Customer Profile Image', 'woo-product-finder'); ?>">
							</div>
							<div class="customer-name">
								<span><?php esc_html_e( 'Carl Ellison', 'woo-product-finder' ) ?></span>
								<div class="customer-rating-bottom">
									<div class="customer-ratings">
										<span class="dashicons dashicons-star-filled"></span>
										<span class="dashicons dashicons-star-filled"></span>
										<span class="dashicons dashicons-star-filled"></span>
										<span class="dashicons dashicons-star-filled"></span>
										<span class="dashicons dashicons-star-filled"></span>
									</div>
									<div class="verified-customer">
										<span class="dashicons dashicons-yes-alt"></span>
										<?php esc_html_e( 'Verified Customer', 'woo-product-finder' ) ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="upgrade-to-pro-faqs">
				<h2><?php esc_html_e( 'FAQs', 'woo-product-finder' ); ?></h2>
				<div class="upgrade-faqs-main">
					<div class="upgrade-faqs-list">
						<div class="upgrade-faqs-header">
							<h3><?php esc_html_e( 'Do you offer support for the plugin? What’s it like?', 'woo-product-finder' ); ?></h3>
						</div>
						<div class="upgrade-faqs-body">
							<p>
							<?php 
								echo sprintf(
								    esc_html__('Yes! You can read our %s or submit a %s. We are very responsive and strive to do our best to help you.', 'woo-product-finder'),
								    '<a href="' . esc_url('https://docs.thedotstore.com/collection/278-product-finder') . '" target="_blank">' . esc_html__('knowledge base', 'woo-product-finder') . '</a>',
								    '<a href="' . esc_url('https://www.thedotstore.com/support-ticket/') . '" target="_blank">' . esc_html__('support ticket', 'woo-product-finder') . '</a>',
								);

							?>
							</p>
						</div>
					</div>
					<div class="upgrade-faqs-list">
						<div class="upgrade-faqs-header">
							<h3><?php esc_html_e( 'What payment methods do you accept?', 'woo-product-finder' ); ?></h3>
						</div>
						<div class="upgrade-faqs-body">
							<p><?php esc_html_e( 'You can pay with your credit card using Stripe checkout. Or your PayPal account.', 'woo-product-finder' ) ?></p>
						</div>
					</div>
					<div class="upgrade-faqs-list">
						<div class="upgrade-faqs-header">
							<h3><?php esc_html_e( 'What’s your refund policy?', 'woo-product-finder' ); ?></h3>
						</div>
						<div class="upgrade-faqs-body">
							<p><?php esc_html_e( 'We have a 14-day money-back guarantee.', 'woo-product-finder' ) ?></p>
						</div>
					</div>
					<div class="upgrade-faqs-list">
						<div class="upgrade-faqs-header">
							<h3><?php esc_html_e( 'I have more questions…', 'woo-product-finder' ); ?></h3>
						</div>
						<div class="upgrade-faqs-body">
							<p>
							<?php 
								echo sprintf(
								    esc_html__('No problem, we’re happy to help! Please reach out at %s.', 'woo-product-finder'),
								    '<a href="' . esc_url('mailto:hello@thedotstore.com') . '" target="_blank">' . esc_html('hello@thedotstore.com') . '</a>',
								);

							?>
							</p>
						</div>
					</div>
				</div>
			</div>
			<div class="upgrade-to-premium-btn">
				<a href="javascript:void(0);" target="_blank" class="upgrade-now"><?php esc_html_e( 'Get The Premium Version', 'woo-product-finder' ) ?><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="crown" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512" class="svg-inline--fa fa-crown fa-w-20 fa-3x" width="22" height="20"><path fill="#000" d="M528 448H112c-8.8 0-16 7.2-16 16v32c0 8.8 7.2 16 16 16h416c8.8 0 16-7.2 16-16v-32c0-8.8-7.2-16-16-16zm64-320c-26.5 0-48 21.5-48 48 0 7.1 1.6 13.7 4.4 19.8L476 239.2c-15.4 9.2-35.3 4-44.2-11.6L350.3 85C361 76.2 368 63 368 48c0-26.5-21.5-48-48-48s-48 21.5-48 48c0 15 7 28.2 17.7 37l-81.5 142.6c-8.9 15.6-28.9 20.8-44.2 11.6l-72.3-43.4c2.7-6 4.4-12.7 4.4-19.8 0-26.5-21.5-48-48-48S0 149.5 0 176s21.5 48 48 48c2.6 0 5.2-.4 7.7-.8L128 416h384l72.3-192.8c2.5.4 5.1.8 7.7.8 26.5 0 48-21.5 48-48s-21.5-48-48-48z" class=""></path></svg></a>
			</div>
		</div>
	</div>
	</div>
</div>
</div>
<?php 
