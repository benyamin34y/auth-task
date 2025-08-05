<?php
/**
 * WooCommerce Compatibility File
 *
 * @package BizMart Pro
 * @version 1.0.0
 */

/**
 * WooCommerce setup function.
 */
function bizmart_woocommerce_setup() {
    add_theme_support('woocommerce', array(
        'thumbnail_image_width' => 300,
        'single_image_width'    => 600,
        'product_grid'          => array(
            'default_rows'    => 3,
            'min_rows'        => 1,
            'default_columns' => 4,
            'min_columns'     => 1,
            'max_columns'     => 6,
        ),
    ));
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
}
add_action('after_setup_theme', 'bizmart_woocommerce_setup');

/**
 * WooCommerce specific scripts & stylesheets.
 */
function bizmart_woocommerce_scripts() {
    wp_enqueue_style('bizmart-woocommerce-style', get_template_directory_uri() . '/assets/css/woocommerce.css', array(), BIZMART_VERSION);
    
    $font_path   = WC()->plugin_url() . '/assets/fonts/';
    $inline_font = '@font-face {
            font-family: "star";
            src: url("' . $font_path . 'star.eot");
            src: url("' . $font_path . 'star.eot?#iefix") format("embedded-opentype"),
                url("' . $font_path . 'star.woff") format("woff"),
                url("' . $font_path . 'star.ttf") format("truetype"),
                url("' . $font_path . 'star.svg#star") format("svg");
            font-weight: normal;
            font-style: normal;
        }';
    
    wp_add_inline_style('bizmart-woocommerce-style', $inline_font);
}
add_action('wp_enqueue_scripts', 'bizmart_woocommerce_scripts');

/**
 * Disable the default WooCommerce stylesheet.
 */
add_filter('woocommerce_enqueue_styles', '__return_empty_array');

/**
 * Add 'woocommerce-active' class to the body tag.
 */
function bizmart_woocommerce_active_body_class($classes) {
    $classes[] = 'woocommerce-active';
    return $classes;
}
add_filter('body_class', 'bizmart_woocommerce_active_body_class');

/**
 * Products per page.
 */
function bizmart_woocommerce_products_per_page() {
    return get_theme_mod('woocommerce_products_per_page', 12);
}
add_filter('loop_shop_per_page', 'bizmart_woocommerce_products_per_page');

/**
 * Product gallery thumnbail columns.
 */
function bizmart_woocommerce_thumbnail_columns() {
    return 4;
}
add_filter('woocommerce_product_thumbnails_columns', 'bizmart_woocommerce_thumbnail_columns');

/**
 * Default loop columns on product archives.
 */
function bizmart_woocommerce_loop_columns() {
    return get_theme_mod('woocommerce_loop_columns', 3);
}
add_filter('loop_shop_columns', 'bizmart_woocommerce_loop_columns');

/**
 * Related Products Args.
 */
function bizmart_woocommerce_related_products_args($args) {
    $defaults = array(
        'posts_per_page' => 4,
        'columns'        => 4,
    );

    $args = wp_parse_args($defaults, $args);

    return $args;
}
add_filter('woocommerce_output_related_products_args', 'bizmart_woocommerce_related_products_args');

/**
 * Remove default WooCommerce wrapper.
 */
remove_action('woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10);
remove_action('woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10);

if (!function_exists('bizmart_woocommerce_wrapper_before')) {
    /**
     * Before Content.
     */
    function bizmart_woocommerce_wrapper_before() {
        echo '<main id="primary" class="site-main woocommerce-page">';
    }
}
add_action('woocommerce_before_main_content', 'bizmart_woocommerce_wrapper_before');

if (!function_exists('bizmart_woocommerce_wrapper_after')) {
    /**
     * After Content.
     */
    function bizmart_woocommerce_wrapper_after() {
        echo '</main>';
    }
}
add_action('woocommerce_after_main_content', 'bizmart_woocommerce_wrapper_after');

/**
 * Remove default WooCommerce sidebar.
 */
remove_action('woocommerce_sidebar', 'woocommerce_get_sidebar', 10);

/**
 * Add custom WooCommerce sidebar.
 */
function bizmart_woocommerce_sidebar() {
    if (is_active_sidebar('sidebar-shop')) {
        dynamic_sidebar('sidebar-shop');
    }
}
add_action('woocommerce_sidebar', 'bizmart_woocommerce_sidebar');

/**
 * Customize WooCommerce breadcrumbs.
 */
function bizmart_woocommerce_breadcrumbs() {
    return array(
        'delimiter'   => ' <i class="fas fa-chevron-right"></i> ',
        'wrap_before' => '<nav class="woocommerce-breadcrumb breadcrumbs" aria-label="' . esc_attr__('breadcrumbs', 'bizmart-pro') . '">',
        'wrap_after'  => '</nav>',
        'before'      => '',
        'after'       => '',
        'home'        => _x('Home', 'breadcrumb', 'bizmart-pro'),
    );
}
add_filter('woocommerce_breadcrumb_defaults', 'bizmart_woocommerce_breadcrumbs');

/**
 * Change number of related products output.
 */
function bizmart_related_products_limit() {
    global $product;
    
    $args['posts_per_page'] = 6;
    $args['columns'] = 3;
    
    return $args;
}
add_filter('woocommerce_output_related_products_args', 'bizmart_related_products_limit');

/**
 * Add custom fields to product edit page.
 */
function bizmart_add_custom_product_fields() {
    global $woocommerce, $post;
    
    echo '<div class="product_custom_field">';
    
    // Custom Text Field
    woocommerce_wp_text_input(
        array(
            'id'          => '_custom_product_text_field',
            'placeholder' => 'Custom text field placeholder',
            'label'       => __('Custom Text Field', 'bizmart-pro'),
            'desc_tip'    => 'true'
        )
    );
    
    // Custom Number Field
    woocommerce_wp_text_input(
        array(
            'id'                => '_custom_product_number_field',
            'placeholder'       => 'Custom number field placeholder',
            'label'             => __('Custom Number Field', 'bizmart-pro'),
            'type'              => 'number',
            'custom_attributes' => array(
                'step' => 'any',
                'min'  => '0'
            )
        )
    );
    
    echo '</div>';
}
add_action('woocommerce_product_options_general_product_data', 'bizmart_add_custom_product_fields');

/**
 * Save custom fields.
 */
function bizmart_save_custom_product_fields($post_id) {
    $custom_text_field = $_POST['_custom_product_text_field'];
    if (!empty($custom_text_field)) {
        update_post_meta($post_id, '_custom_product_text_field', esc_attr($custom_text_field));
    }
    
    $custom_number_field = $_POST['_custom_product_number_field'];
    if (!empty($custom_number_field)) {
        update_post_meta($post_id, '_custom_product_number_field', esc_attr($custom_number_field));
    }
}
add_action('woocommerce_process_product_meta', 'bizmart_save_custom_product_fields');

/**
 * Display custom fields on single product page.
 */
function bizmart_display_custom_product_fields() {
    global $post;
    
    $custom_text = get_post_meta($post->ID, '_custom_product_text_field', true);
    $custom_number = get_post_meta($post->ID, '_custom_product_number_field', true);
    
    if (!empty($custom_text)) {
        echo '<div class="custom-field-text"><strong>' . __('Custom Text:', 'bizmart-pro') . '</strong> ' . $custom_text . '</div>';
    }
    
    if (!empty($custom_number)) {
        echo '<div class="custom-field-number"><strong>' . __('Custom Number:', 'bizmart-pro') . '</strong> ' . $custom_number . '</div>';
    }
}
add_action('woocommerce_single_product_summary', 'bizmart_display_custom_product_fields', 25);

/**
 * Customize add to cart button text.
 */
function bizmart_custom_add_to_cart_text() {
    global $product;
    
    switch ($product->get_type()) {
        case 'external':
            return __('Buy Now', 'bizmart-pro');
        case 'grouped':
            return __('View Products', 'bizmart-pro');
        case 'simple':
            return __('Add to Cart', 'bizmart-pro');
        case 'variable':
            return __('Select Options', 'bizmart-pro');
        default:
            return __('Read More', 'bizmart-pro');
    }
}
add_filter('woocommerce_product_add_to_cart_text', 'bizmart_custom_add_to_cart_text');
add_filter('woocommerce_product_single_add_to_cart_text', 'bizmart_custom_add_to_cart_text');

/**
 * Change number of product columns in shop.
 */
function bizmart_shop_columns($columns) {
    if (wp_is_mobile()) {
        return 2;
    }
    return 4;
}
add_filter('loop_shop_columns', 'bizmart_shop_columns', 999);

/**
 * Add custom sale badge.
 */
function bizmart_custom_sale_badge() {
    global $product;
    
    if ($product->is_on_sale()) {
        if ($product->get_type() == 'variable') {
            $percentages = array();
            $prices = $product->get_variation_prices();
            
            foreach ($prices['price'] as $key => $price) {
                if ($prices['regular_price'][$key] !== $price) {
                    $percentages[] = round((($prices['regular_price'][$key] - $price) / $prices['regular_price'][$key]) * 100);
                }
            }
            $percentage = max($percentages);
        } else {
            $percentage = round((($product->get_regular_price() - $product->get_sale_price()) / $product->get_regular_price()) * 100);
        }
        
        echo '<span class="onsale sale-badge">-' . $percentage . '%</span>';
    }
}
remove_action('woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash', 10);
remove_action('woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash', 10);
add_action('woocommerce_before_single_product_summary', 'bizmart_custom_sale_badge', 10);
add_action('woocommerce_before_shop_loop_item_title', 'bizmart_custom_sale_badge', 10);

/**
 * Add product quick view.
 */
function bizmart_add_quick_view_button() {
    global $product;
    echo '<a href="#" class="quick-view-btn" data-product-id="' . $product->get_id() . '" title="' . __('Quick View', 'bizmart-pro') . '">';
    echo '<i class="fas fa-eye"></i>';
    echo '</a>';
}
add_action('woocommerce_after_shop_loop_item', 'bizmart_add_quick_view_button', 15);

/**
 * Add wishlist button.
 */
function bizmart_add_wishlist_button() {
    global $product;
    echo '<a href="#" class="wishlist-btn" data-product-id="' . $product->get_id() . '" title="' . __('Add to Wishlist', 'bizmart-pro') . '">';
    echo '<i class="far fa-heart"></i>';
    echo '</a>';
}
add_action('woocommerce_after_shop_loop_item', 'bizmart_add_wishlist_button', 20);

/**
 * Add compare button.
 */
function bizmart_add_compare_button() {
    global $product;
    echo '<a href="#" class="compare-btn" data-product-id="' . $product->get_id() . '" title="' . __('Compare', 'bizmart-pro') . '">';
    echo '<i class="fas fa-exchange-alt"></i>';
    echo '</a>';
}
add_action('woocommerce_after_shop_loop_item', 'bizmart_add_compare_button', 25);

/**
 * Add product actions wrapper.
 */
function bizmart_product_actions_wrapper_start() {
    echo '<div class="product-actions">';
}
add_action('woocommerce_after_shop_loop_item', 'bizmart_product_actions_wrapper_start', 5);

function bizmart_product_actions_wrapper_end() {
    echo '</div>';
}
add_action('woocommerce_after_shop_loop_item', 'bizmart_product_actions_wrapper_end', 30);

/**
 * Customize WooCommerce checkout fields.
 */
function bizmart_override_checkout_fields($fields) {
    // Billing fields
    $fields['billing']['billing_first_name']['placeholder'] = __('First Name', 'bizmart-pro');
    $fields['billing']['billing_last_name']['placeholder'] = __('Last Name', 'bizmart-pro');
    $fields['billing']['billing_company']['placeholder'] = __('Company Name (Optional)', 'bizmart-pro');
    $fields['billing']['billing_email']['placeholder'] = __('Email Address', 'bizmart-pro');
    $fields['billing']['billing_phone']['placeholder'] = __('Phone Number', 'bizmart-pro');
    $fields['billing']['billing_address_1']['placeholder'] = __('Address Line 1', 'bizmart-pro');
    $fields['billing']['billing_address_2']['placeholder'] = __('Address Line 2 (Optional)', 'bizmart-pro');
    $fields['billing']['billing_city']['placeholder'] = __('City', 'bizmart-pro');
    $fields['billing']['billing_postcode']['placeholder'] = __('Postal Code', 'bizmart-pro');
    
    // Shipping fields
    $fields['shipping']['shipping_first_name']['placeholder'] = __('First Name', 'bizmart-pro');
    $fields['shipping']['shipping_last_name']['placeholder'] = __('Last Name', 'bizmart-pro');
    $fields['shipping']['shipping_company']['placeholder'] = __('Company Name (Optional)', 'bizmart-pro');
    $fields['shipping']['shipping_address_1']['placeholder'] = __('Address Line 1', 'bizmart-pro');
    $fields['shipping']['shipping_address_2']['placeholder'] = __('Address Line 2 (Optional)', 'bizmart-pro');
    $fields['shipping']['shipping_city']['placeholder'] = __('City', 'bizmart-pro');
    $fields['shipping']['shipping_postcode']['placeholder'] = __('Postal Code', 'bizmart-pro');
    
    return $fields;
}
add_filter('woocommerce_checkout_fields', 'bizmart_override_checkout_fields');

/**
 * Add custom tab to single product page.
 */
function bizmart_add_product_custom_tab($tabs) {
    $tabs['custom_tab'] = array(
        'title'    => __('Custom Tab', 'bizmart-pro'),
        'priority' => 50,
        'callback' => 'bizmart_product_custom_tab_content'
    );
    return $tabs;
}
add_filter('woocommerce_product_tabs', 'bizmart_add_product_custom_tab');

function bizmart_product_custom_tab_content() {
    echo '<h2>' . __('Custom Tab Content', 'bizmart-pro') . '</h2>';
    echo '<p>' . __('Here you can add any custom content for this product.', 'bizmart-pro') . '</p>';
}

/**
 * Remove WooCommerce tabs.
 */
function bizmart_remove_product_tabs($tabs) {
    unset($tabs['additional_information']); // Remove additional information tab
    return $tabs;
}
// add_filter('woocommerce_product_tabs', 'bizmart_remove_product_tabs', 98);

/**
 * Add stock status to shop loop.
 */
function bizmart_stock_status_on_shop() {
    global $product;
    
    if (!$product->is_in_stock()) {
        echo '<span class="stock-status out-of-stock">' . __('Out of Stock', 'bizmart-pro') . '</span>';
    } elseif ($product->is_on_backorder()) {
        echo '<span class="stock-status on-backorder">' . __('On Backorder', 'bizmart-pro') . '</span>';
    } elseif ($product->get_stock_quantity() <= get_option('woocommerce_notify_low_stock_amount')) {
        echo '<span class="stock-status low-stock">' . __('Low Stock', 'bizmart-pro') . '</span>';
    } else {
        echo '<span class="stock-status in-stock">' . __('In Stock', 'bizmart-pro') . '</span>';
    }
}
add_action('woocommerce_after_shop_loop_item_title', 'bizmart_stock_status_on_shop', 15);

/**
 * Change single product page layout.
 */
function bizmart_single_product_layout() {
    if (is_product()) {
        remove_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 10);
        add_action('woocommerce_single_product_summary', 'woocommerce_template_single_price', 25);
    }
}
add_action('wp', 'bizmart_single_product_layout');

/**
 * Add estimated delivery date.
 */
function bizmart_estimated_delivery_date() {
    $delivery_days = get_theme_mod('estimated_delivery_days', 7);
    $delivery_date = date('F j, Y', strtotime('+' . $delivery_days . ' days'));
    
    echo '<div class="estimated-delivery">';
    echo '<i class="fas fa-truck"></i>';
    echo '<span>' . sprintf(__('Estimated delivery: %s', 'bizmart-pro'), $delivery_date) . '</span>';
    echo '</div>';
}
add_action('woocommerce_single_product_summary', 'bizmart_estimated_delivery_date', 35);

/**
 * Add product features icons.
 */
function bizmart_product_features() {
    echo '<div class="product-features">';
    echo '<div class="feature-item">';
    echo '<i class="fas fa-shipping-fast"></i>';
    echo '<span>' . __('Free Shipping', 'bizmart-pro') . '</span>';
    echo '</div>';
    echo '<div class="feature-item">';
    echo '<i class="fas fa-undo"></i>';
    echo '<span>' . __('Easy Returns', 'bizmart-pro') . '</span>';
    echo '</div>';
    echo '<div class="feature-item">';
    echo '<i class="fas fa-shield-alt"></i>';
    echo '<span>' . __('Warranty', 'bizmart-pro') . '</span>';
    echo '</div>';
    echo '</div>';
}
add_action('woocommerce_single_product_summary', 'bizmart_product_features', 45);

/**
 * AJAX handlers for custom functionality.
 */

// Quick view AJAX
function bizmart_quick_view_ajax() {
    if (!wp_verify_nonce($_POST['nonce'], 'bizmart_nonce')) {
        wp_die(__('Security check failed', 'bizmart-pro'));
    }
    
    $product_id = intval($_POST['product_id']);
    
    if ($product_id) {
        global $post, $product, $woocommerce;
        
        $post = get_post($product_id);
        $product = wc_get_product($product_id);
        
        if ($product) {
            wc_get_template('content-single-product-quick-view.php');
        }
    }
    
    wp_die();
}
add_action('wp_ajax_bizmart_quick_view', 'bizmart_quick_view_ajax');
add_action('wp_ajax_nopriv_bizmart_quick_view', 'bizmart_quick_view_ajax');

// Wishlist AJAX
function bizmart_wishlist_ajax() {
    if (!wp_verify_nonce($_POST['nonce'], 'bizmart_nonce')) {
        wp_die(__('Security check failed', 'bizmart-pro'));
    }
    
    $product_id = intval($_POST['product_id']);
    
    if ($product_id) {
        $wishlist = get_user_meta(get_current_user_id(), 'bizmart_wishlist', true);
        if (!is_array($wishlist)) {
            $wishlist = array();
        }
        
        if (!in_array($product_id, $wishlist)) {
            $wishlist[] = $product_id;
            update_user_meta(get_current_user_id(), 'bizmart_wishlist', $wishlist);
            wp_send_json_success(__('Product added to wishlist', 'bizmart-pro'));
        } else {
            wp_send_json_error(__('Product already in wishlist', 'bizmart-pro'));
        }
    }
    
    wp_die();
}
add_action('wp_ajax_bizmart_add_to_wishlist', 'bizmart_wishlist_ajax');
add_action('wp_ajax_nopriv_bizmart_add_to_wishlist', 'bizmart_wishlist_ajax');

/**
 * Remove WooCommerce generator tag.
 */
remove_action('wp_head', 'wc_generator_tag');