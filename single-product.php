<?php
/**
 * The template for displaying product content in the single-product.php template
 *
 * @package BizMart Pro
 * @version 1.0.0
 */

defined('ABSPATH') || exit;

global $product;

get_header('shop'); ?>

<main id="primary" class="site-main single-product-page">
    <div class="container">
        
        <?php while (have_posts()) : the_post(); ?>
            
            <div class="product-details-wrapper">
                <div class="row">
                    
                    <!-- Product Images -->
                    <div class="col-lg-6 col-md-6">
                        <div class="product-images">
                            <?php
                            /**
                             * Hook: woocommerce_before_single_product_summary.
                             *
                             * @hooked woocommerce_show_product_sale_flash - 10
                             * @hooked woocommerce_show_product_images - 20
                             */
                            do_action('woocommerce_before_single_product_summary');
                            ?>
                        </div>
                    </div>
                    
                    <!-- Product Info -->
                    <div class="col-lg-6 col-md-6">
                        <div class="product-summary">
                            <?php
                            /**
                             * Hook: woocommerce_single_product_summary.
                             *
                             * @hooked woocommerce_template_single_title - 5
                             * @hooked woocommerce_template_single_rating - 10
                             * @hooked woocommerce_template_single_price - 10
                             * @hooked woocommerce_template_single_excerpt - 20
                             * @hooked woocommerce_template_single_add_to_cart - 30
                             * @hooked woocommerce_template_single_meta - 40
                             * @hooked woocommerce_template_single_sharing - 50
                             * @hooked WC_Structured_Data::generate_product_data() - 60
                             */
                            do_action('woocommerce_single_product_summary');
                            ?>
                            
                            <!-- Additional Product Features -->
                            <div class="product-features">
                                <div class="feature-item">
                                    <i class="fas fa-shipping-fast"></i>
                                    <div class="feature-content">
                                        <strong><?php _e('Free Shipping', 'bizmart-pro'); ?></strong>
                                        <span><?php _e('On orders over $99', 'bizmart-pro'); ?></span>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-undo"></i>
                                    <div class="feature-content">
                                        <strong><?php _e('30-Day Returns', 'bizmart-pro'); ?></strong>
                                        <span><?php _e('Easy return policy', 'bizmart-pro'); ?></span>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-shield-alt"></i>
                                    <div class="feature-content">
                                        <strong><?php _e('Warranty', 'bizmart-pro'); ?></strong>
                                        <span><?php _e('1 year warranty', 'bizmart-pro'); ?></span>
                                    </div>
                                </div>
                                <div class="feature-item">
                                    <i class="fas fa-headset"></i>
                                    <div class="feature-content">
                                        <strong><?php _e('24/7 Support', 'bizmart-pro'); ?></strong>
                                        <span><?php _e('Customer support', 'bizmart-pro'); ?></span>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Social Share -->
                            <div class="product-social-share">
                                <h4><?php _e('Share this product:', 'bizmart-pro'); ?></h4>
                                <div class="social-buttons">
                                    <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="social-btn facebook">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social-btn twitter">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="social-btn pinterest">
                                        <i class="fab fa-pinterest-p"></i>
                                    </a>
                                    <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="social-btn linkedin">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Product Details Tabs -->
            <div class="product-tabs-section">
                <div class="product-tabs">
                    <?php
                    /**
                     * Hook: woocommerce_output_product_data_tabs.
                     *
                     * @hooked woocommerce_output_product_data_tabs - 10
                     */
                    do_action('woocommerce_output_product_data_tabs');
                    ?>
                </div>
            </div>
            
            <!-- Related Products -->
            <div class="related-products-section">
                <?php
                /**
                 * Hook: woocommerce_output_related_products_args.
                 *
                 * @hooked woocommerce_output_related_products - 20
                 */
                $args = array(
                    'posts_per_page' => 4,
                    'columns'        => 4,
                );
                woocommerce_output_related_products($args);
                ?>
            </div>
            
            <!-- Recently Viewed Products -->
            <div class="recently-viewed-section">
                <?php echo do_shortcode('[bizmart_recently_viewed]'); ?>
            </div>
            
        <?php endwhile; ?>
        
    </div>
</main>

<!-- Product Quick Actions (Sticky) -->
<div class="product-sticky-actions">
    <div class="container">
        <div class="sticky-content">
            <div class="product-info-mini">
                <?php if (has_post_thumbnail()) : ?>
                    <div class="product-thumb">
                        <?php the_post_thumbnail('thumbnail'); ?>
                    </div>
                <?php endif; ?>
                <div class="product-details-mini">
                    <h4><?php the_title(); ?></h4>
                    <div class="price"><?php echo $product->get_price_html(); ?></div>
                </div>
            </div>
            <div class="sticky-actions">
                <?php if ($product->is_type('simple')) : ?>
                    <form class="cart" action="<?php echo esc_url(apply_filters('woocommerce_add_to_cart_form_action', $product->get_permalink())); ?>" method="post" enctype='multipart/form-data'>
                        <div class="quantity-wrapper">
                            <?php
                            woocommerce_quantity_input(array(
                                'min_value'   => apply_filters('woocommerce_quantity_input_min', $product->get_min_purchase_quantity(), $product),
                                'max_value'   => apply_filters('woocommerce_quantity_input_max', $product->get_max_purchase_quantity(), $product),
                                'input_value' => isset($_POST['quantity']) ? wc_stock_amount(wp_unslash($_POST['quantity'])) : $product->get_min_purchase_quantity(),
                            ));
                            ?>
                        </div>
                        <button type="submit" name="add-to-cart" value="<?php echo esc_attr($product->get_id()); ?>" class="btn btn-primary add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i>
                            <?php echo esc_html($product->single_add_to_cart_text()); ?>
                        </button>
                    </form>
                <?php endif; ?>
                <button class="btn btn-outline wishlist-btn" data-product-id="<?php echo $product->get_id(); ?>">
                    <i class="fas fa-heart"></i>
                    <?php _e('Wishlist', 'bizmart-pro'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<style>
/* Product Page Styles */
.single-product-page {
    padding: 40px 0;
}

.product-details-wrapper {
    margin-bottom: 60px;
}

.product-images {
    position: relative;
}

.product-summary {
    padding-left: 30px;
}

.product-features {
    margin: 30px 0;
    padding: 25px;
    background: #f8f9fa;
    border-radius: 8px;
}

.feature-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
    gap: 15px;
}

.feature-item:last-child {
    margin-bottom: 0;
}

.feature-item i {
    font-size: 1.2rem;
    color: #007cba;
    min-width: 20px;
}

.feature-content strong {
    display: block;
    font-weight: 600;
    color: #333;
}

.feature-content span {
    font-size: 0.9rem;
    color: #666;
}

.product-social-share {
    margin-top: 30px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.product-social-share h4 {
    margin-bottom: 15px;
    font-size: 1rem;
    color: #333;
}

.social-buttons {
    display: flex;
    gap: 10px;
}

.social-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 40px;
    height: 40px;
    border-radius: 50%;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
}

.social-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.social-btn.facebook { background: #3b5998; }
.social-btn.twitter { background: #1da1f2; }
.social-btn.pinterest { background: #bd081c; }
.social-btn.linkedin { background: #0077b5; }

.product-tabs-section {
    margin: 60px 0;
}

.related-products-section,
.recently-viewed-section {
    margin: 60px 0;
}

/* Sticky Actions */
.product-sticky-actions {
    position: fixed;
    bottom: 0;
    left: 0;
    right: 0;
    background: #fff;
    box-shadow: 0 -2px 20px rgba(0,0,0,0.1);
    z-index: 999;
    transform: translateY(100%);
    transition: transform 0.3s ease;
}

.product-sticky-actions.show {
    transform: translateY(0);
}

.sticky-content {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 15px 0;
}

.product-info-mini {
    display: flex;
    align-items: center;
    gap: 15px;
}

.product-thumb {
    width: 60px;
    height: 60px;
    overflow: hidden;
    border-radius: 8px;
}

.product-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.product-details-mini h4 {
    margin: 0 0 5px 0;
    font-size: 1.1rem;
    font-weight: 600;
}

.product-details-mini .price {
    color: #007cba;
    font-weight: 700;
}

.sticky-actions {
    display: flex;
    align-items: center;
    gap: 15px;
}

.sticky-actions .cart {
    display: flex;
    align-items: center;
    gap: 10px;
}

.quantity-wrapper {
    display: flex;
    align-items: center;
}

.quantity-wrapper input {
    width: 60px;
    text-align: center;
    border: 1px solid #ddd;
    border-radius: 4px;
    padding: 8px;
}

.add-to-cart-btn,
.wishlist-btn {
    white-space: nowrap;
    padding: 12px 20px;
}

/* Product Gallery Enhancements */
.woocommerce-product-gallery {
    position: relative;
}

.woocommerce-product-gallery__wrapper {
    position: relative;
}

.woocommerce-product-gallery__image {
    position: relative;
    overflow: hidden;
    border-radius: 8px;
    margin-bottom: 15px;
}

.woocommerce-product-gallery__image img {
    transition: transform 0.3s ease;
}

.woocommerce-product-gallery__image:hover img {
    transform: scale(1.05);
}

/* Product Thumbnails */
.flex-control-thumbs {
    display: flex;
    gap: 10px;
    margin-top: 15px;
    flex-wrap: wrap;
}

.flex-control-thumbs li {
    width: 80px;
    height: 80px;
    overflow: hidden;
    border-radius: 6px;
    border: 2px solid transparent;
    cursor: pointer;
    transition: border-color 0.3s ease;
}

.flex-control-thumbs li.flex-active {
    border-color: #007cba;
}

.flex-control-thumbs li img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Product Meta Enhancements */
.product_meta {
    margin-top: 25px;
    padding-top: 20px;
    border-top: 1px solid #eee;
}

.product_meta > span {
    display: block;
    margin-bottom: 8px;
    font-size: 0.9rem;
}

.product_meta a {
    color: #007cba;
    text-decoration: none;
}

.product_meta a:hover {
    text-decoration: underline;
}

/* Responsive Design */
@media (max-width: 768px) {
    .product-summary {
        padding-left: 0;
        margin-top: 30px;
    }
    
    .sticky-content {
        flex-direction: column;
        gap: 15px;
        padding: 15px;
    }
    
    .product-info-mini {
        width: 100%;
        justify-content: center;
    }
    
    .sticky-actions {
        width: 100%;
        justify-content: center;
    }
    
    .sticky-actions .cart {
        flex: 1;
        justify-content: center;
    }
    
    .social-buttons {
        justify-content: center;
    }
    
    .feature-item {
        text-align: center;
        flex-direction: column;
        gap: 8px;
    }
}

/* Animation Classes */
@keyframes bounce {
    0%, 20%, 60%, 100% {
        transform: translateY(0);
    }
    40% {
        transform: translateY(-10px);
    }
    80% {
        transform: translateY(-5px);
    }
}

.cart-count.bounce {
    animation: bounce 0.6s;
}

/* Loading States */
.loading {
    position: relative;
    opacity: 0.6;
    pointer-events: none;
}

.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 30px;
    height: 30px;
    margin: -15px 0 0 -15px;
    border: 3px solid #f3f3f3;
    border-top: 3px solid #007cba;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
jQuery(document).ready(function($) {
    // Show sticky actions when scrolling past product summary
    var $stickyActions = $('.product-sticky-actions');
    var $productSummary = $('.product-summary');
    
    if ($stickyActions.length && $productSummary.length) {
        $(window).on('scroll', function() {
            var summaryBottom = $productSummary.offset().top + $productSummary.outerHeight();
            var scrollTop = $(window).scrollTop() + $(window).height();
            
            if (scrollTop > summaryBottom + 100) {
                $stickyActions.addClass('show');
            } else {
                $stickyActions.removeClass('show');
            }
        });
    }
    
    // Wishlist functionality
    $('.wishlist-btn').on('click', function(e) {
        e.preventDefault();
        
        var $btn = $(this);
        var productId = $btn.data('product-id');
        
        $btn.addClass('loading');
        
        $.ajax({
            url: bizmart_ajax.ajaxurl,
            type: 'POST',
            data: {
                action: 'bizmart_add_to_wishlist',
                product_id: productId,
                nonce: bizmart_ajax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $btn.addClass('added');
                    $btn.find('i').removeClass('far').addClass('fas');
                    
                    // Show notification
                    var notification = '<div class="notification notification-success">Product added to wishlist!</div>';
                    $('body').append(notification);
                    setTimeout(function() {
                        $('.notification').addClass('show');
                    }, 100);
                    setTimeout(function() {
                        $('.notification').remove();
                    }, 3000);
                }
            },
            complete: function() {
                $btn.removeClass('loading');
            }
        });
    });
});
</script>

<?php
get_footer('shop');
?>