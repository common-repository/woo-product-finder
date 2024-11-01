<?php
if ( !defined( 'ABSPATH' ) ) {
    exit;
}

require_once plugin_dir_path( __FILE__ ) . 'header/plugin-header.php';
?>
<div class="wpfp-main-table res-cl">
    <div class="dots-getting-started-main">
        <div class="getting-started-content">
            <span><?php esc_html_e( 'How to Get Started', 'woo-product-finder' ); ?></span>
            <h3><?php esc_html_e( 'Welcome to Product Recommendation Quiz Plugin', 'woo-product-finder' ); ?></h3>
            <p><?php esc_html_e( 'Thank you for choosing our top-rated WooCommerce Product Recommendation Quiz plugin. Our user-friendly interface makes it easy to set up different product recommendation quizzes to help your customers find the perfect products.', 'woo-product-finder' ); ?></p>
            <p>
                <?php 
                echo sprintf(
                    esc_html__('To help you get started, watch the quick tour video on the right. For more help, explore our help documents or visit our %s for detailed video tutorials.', 'woo-product-finder'),
                    '<a href="' . esc_url('https://www.youtube.com/@Dotstore16') . '" target="_blank">' . esc_html__('YouTube channel', 'woo-product-finder') . '</a>',
                );
                ?>
            </p>
            <div class="getting-started-actions">
                <a href="<?php echo esc_url(add_query_arg(array('page' => 'wpfp-list'), admin_url('admin.php'))); ?>" class="quick-start"><?php esc_html_e( 'Manage Product Quizzes', 'woo-product-finder' ); ?><span class="dashicons dashicons-arrow-right-alt"></span></a>
                <a href="https://docs.thedotstore.com/article/959-beginners-guide-for-product-finder" target="_blank" class="setup-guide"><span class="dashicons dashicons-book-alt"></span><?php esc_html_e( 'Read the Setup Guide', 'woo-product-finder' ); ?></a>
            </div>
        </div>
        <div class="getting-started-video">
            <iframe width="960" height="600" src="<?php echo esc_url('https://www.youtube.com/embed/o7XmORgxwvE'); ?>" title="<?php esc_attr_e( 'Plugin Tour', 'woo-product-finder' ); ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>
</div>
</div>
</div>
</div>
</div>
<?php
