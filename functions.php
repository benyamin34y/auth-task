<?php
/**
 * BizMart Pro Theme Functions
 * 
 * @package BizMart Pro
 * @version 1.0.0
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

// Theme constants
define('BIZMART_VERSION', '1.0.0');
define('BIZMART_THEME_DIR', get_template_directory());
define('BIZMART_THEME_URI', get_template_directory_uri());

/**
 * Theme Setup
 */
function bizmart_theme_setup() {
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('custom-header');
    add_theme_support('custom-background');
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));
    
    // WooCommerce support
    add_theme_support('woocommerce');
    add_theme_support('wc-product-gallery-zoom');
    add_theme_support('wc-product-gallery-lightbox');
    add_theme_support('wc-product-gallery-slider');
    
    // Elementor support
    add_theme_support('elementor');
    
    // Register navigation menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'bizmart-pro'),
        'footer' => __('Footer Menu', 'bizmart-pro'),
        'mobile' => __('Mobile Menu', 'bizmart-pro'),
    ));
    
    // Add editor styles
    add_theme_support('editor-styles');
    add_editor_style('editor-style.css');
    
    // Set content width
    $GLOBALS['content_width'] = 1200;
}
add_action('after_setup_theme', 'bizmart_theme_setup');

/**
 * Enqueue Scripts and Styles
 */
function bizmart_scripts() {
    // Main stylesheet
    wp_enqueue_style('bizmart-style', get_stylesheet_uri(), array(), BIZMART_VERSION);
    
    // Google Fonts
    wp_enqueue_style('bizmart-fonts', 'https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap', array(), null);
    
    // Font Awesome
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css', array(), '6.0.0');
    
    // Main JavaScript
    wp_enqueue_script('bizmart-script', BIZMART_THEME_URI . '/assets/js/theme.js', array('jquery'), BIZMART_VERSION, true);
    
    // Responsive navigation
    wp_enqueue_script('bizmart-navigation', BIZMART_THEME_URI . '/assets/js/navigation.js', array('jquery'), BIZMART_VERSION, true);
    
    // AJAX support
    wp_localize_script('bizmart-script', 'bizmart_ajax', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce('bizmart_nonce'),
    ));
    
    // Conditional scripts
    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }
}
add_action('wp_enqueue_scripts', 'bizmart_scripts');

/**
 * Admin Scripts and Styles
 */
function bizmart_admin_scripts() {
    wp_enqueue_style('bizmart-admin', BIZMART_THEME_URI . '/assets/css/admin.css', array(), BIZMART_VERSION);
    wp_enqueue_script('bizmart-admin-js', BIZMART_THEME_URI . '/assets/js/admin.js', array('jquery'), BIZMART_VERSION, true);
}
add_action('admin_enqueue_scripts', 'bizmart_admin_scripts');

/**
 * Register Widget Areas
 */
function bizmart_widgets_init() {
    // Main sidebar
    register_sidebar(array(
        'name'          => __('Main Sidebar', 'bizmart-pro'),
        'id'            => 'sidebar-main',
        'description'   => __('Add widgets here to appear in your sidebar.', 'bizmart-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Shop sidebar
    register_sidebar(array(
        'name'          => __('Shop Sidebar', 'bizmart-pro'),
        'id'            => 'sidebar-shop',
        'description'   => __('Add widgets here to appear in shop pages.', 'bizmart-pro'),
        'before_widget' => '<section id="%1$s" class="widget %2$s">',
        'after_widget'  => '</section>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));
    
    // Footer widgets
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Footer %d', 'bizmart-pro'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Add widgets here to appear in footer column %d.', 'bizmart-pro'), $i),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h3 class="widget-title">',
            'after_title'   => '</h3>',
        ));
    }
}
add_action('widgets_init', 'bizmart_widgets_init');

/**
 * Custom Logo Setup
 */
function bizmart_custom_logo_setup() {
    $defaults = array(
        'height'      => 50,
        'width'       => 200,
        'flex-height' => true,
        'flex-width'  => true,
        'header-text' => array('site-title', 'site-description'),
    );
    add_theme_support('custom-logo', $defaults);
}
add_action('after_setup_theme', 'bizmart_custom_logo_setup');

/**
 * Theme Customizer
 */
function bizmart_customize_register($wp_customize) {
    // Header Section
    $wp_customize->add_section('bizmart_header', array(
        'title'    => __('Header Options', 'bizmart-pro'),
        'priority' => 30,
    ));
    
    // Header layout
    $wp_customize->add_setting('header_layout', array(
        'default'           => 'default',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('header_layout', array(
        'label'   => __('Header Layout', 'bizmart-pro'),
        'section' => 'bizmart_header',
        'type'    => 'select',
        'choices' => array(
            'default' => __('Default', 'bizmart-pro'),
            'centered' => __('Centered', 'bizmart-pro'),
            'minimal' => __('Minimal', 'bizmart-pro'),
        ),
    ));
    
    // Colors Section
    $wp_customize->add_section('bizmart_colors', array(
        'title'    => __('Theme Colors', 'bizmart-pro'),
        'priority' => 40,
    ));
    
    // Primary color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#007cba',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'   => __('Primary Color', 'bizmart-pro'),
        'section' => 'bizmart_colors',
    )));
    
    // Secondary color
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#6c757d',
        'sanitize_callback' => 'sanitize_hex_color',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'   => __('Secondary Color', 'bizmart-pro'),
        'section' => 'bizmart_colors',
    )));
    
    // Typography Section
    $wp_customize->add_section('bizmart_typography', array(
        'title'    => __('Typography', 'bizmart-pro'),
        'priority' => 50,
    ));
    
    // Body font
    $wp_customize->add_setting('body_font', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('body_font', array(
        'label'   => __('Body Font', 'bizmart-pro'),
        'section' => 'bizmart_typography',
        'type'    => 'select',
        'choices' => array(
            'Inter' => 'Inter',
            'Roboto' => 'Roboto',
            'Open Sans' => 'Open Sans',
            'Lato' => 'Lato',
            'Poppins' => 'Poppins',
        ),
    ));
}
add_action('customize_register', 'bizmart_customize_register');

/**
 * WooCommerce Customizations
 */
if (class_exists('WooCommerce')) {
    // Remove default WooCommerce styles
    add_filter('woocommerce_enqueue_styles', '__return_false');
    
    // Custom WooCommerce styles
    function bizmart_woocommerce_styles() {
        wp_enqueue_style('bizmart-woocommerce', BIZMART_THEME_URI . '/assets/css/woocommerce.css', array(), BIZMART_VERSION);
    }
    add_action('wp_enqueue_scripts', 'bizmart_woocommerce_styles');
    
    // Change number of products per row
    function bizmart_loop_columns() {
        return 4;
    }
    add_filter('loop_shop_columns', 'bizmart_loop_columns');
    
    // Change number of products per page
    function bizmart_products_per_page() {
        return 12;
    }
    add_filter('loop_shop_per_page', 'bizmart_products_per_page');
    
    // Add cart icon to header
    function bizmart_cart_link() {
        ?>
        <a class="cart-toggle" href="<?php echo wc_get_cart_url(); ?>">
            <i class="fas fa-shopping-cart"></i>
            <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        </a>
        <?php
    }
    
    // Update cart count via AJAX
    function bizmart_add_to_cart_fragment($fragments) {
        ob_start();
        ?>
        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
        <?php
        $fragments['.cart-count'] = ob_get_clean();
        return $fragments;
    }
    add_filter('woocommerce_add_to_cart_fragments', 'bizmart_add_to_cart_fragment');
}

/**
 * Elementor Compatibility
 */
function bizmart_elementor_support() {
    // Add Elementor support
    add_action('elementor/theme/register_locations', function($elementor_theme_manager) {
        $elementor_theme_manager->register_location('header');
        $elementor_theme_manager->register_location('footer');
    });
}
add_action('after_setup_theme', 'bizmart_elementor_support');

/**
 * Custom Post Types
 */
function bizmart_custom_post_types() {
    // Portfolio post type
    register_post_type('portfolio', array(
        'labels' => array(
            'name' => __('Portfolio', 'bizmart-pro'),
            'singular_name' => __('Portfolio Item', 'bizmart-pro'),
        ),
        'public' => true,
        'has_archive' => true,
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
        'rewrite' => array('slug' => 'portfolio'),
    ));
    
    // Testimonials post type
    register_post_type('testimonials', array(
        'labels' => array(
            'name' => __('Testimonials', 'bizmart-pro'),
            'singular_name' => __('Testimonial', 'bizmart-pro'),
        ),
        'public' => true,
        'supports' => array('title', 'editor', 'thumbnail'),
        'rewrite' => array('slug' => 'testimonials'),
    ));
}
add_action('init', 'bizmart_custom_post_types');

/**
 * Helper Functions
 */

// Get primary color
function bizmart_get_primary_color() {
    return get_theme_mod('primary_color', '#007cba');
}

// Get secondary color
function bizmart_get_secondary_color() {
    return get_theme_mod('secondary_color', '#6c757d');
}

// Custom excerpt length
function bizmart_excerpt_length($length) {
    return 25;
}
add_filter('excerpt_length', 'bizmart_excerpt_length');

// Custom excerpt more
function bizmart_excerpt_more($more) {
    return '...';
}
add_filter('excerpt_more', 'bizmart_excerpt_more');

/**
 * Security Enhancements
 */

// Remove WordPress version
function bizmart_remove_version() {
    return '';
}
add_filter('the_generator', 'bizmart_remove_version');

// Hide login errors
function bizmart_login_errors() {
    return __('Login failed. Please try again.', 'bizmart-pro');
}
add_filter('login_errors', 'bizmart_login_errors');

/**
 * Performance Optimizations
 */

// Remove query strings from static resources
function bizmart_remove_query_strings($src) {
    $parts = explode('?ver', $src);
    return $parts[0];
}
add_filter('script_loader_src', 'bizmart_remove_query_strings', 15, 1);
add_filter('style_loader_src', 'bizmart_remove_query_strings', 15, 1);

// Defer parsing of JavaScript
function bizmart_defer_parsing_of_js($url) {
    if (is_admin()) return $url;
    if (FALSE === strpos($url, '.js')) return $url;
    if (strpos($url, 'jquery.js')) return $url;
    return str_replace(' src', ' defer src', $url);
}
add_filter('script_loader_tag', 'bizmart_defer_parsing_of_js', 10);

/**
 * Theme Activation
 */
function bizmart_theme_activation() {
    // Create default pages if they don't exist
    $pages = array(
        'shop' => 'Shop',
        'cart' => 'Cart',
        'checkout' => 'Checkout',
        'my-account' => 'My Account',
    );
    
    foreach ($pages as $slug => $title) {
        if (!get_page_by_path($slug)) {
            wp_insert_post(array(
                'post_title' => $title,
                'post_name' => $slug,
                'post_content' => '',
                'post_status' => 'publish',
                'post_type' => 'page',
            ));
        }
    }
    
    // Set WooCommerce pages
    if (class_exists('WooCommerce')) {
        $shop = get_page_by_path('shop');
        $cart = get_page_by_path('cart');
        $checkout = get_page_by_path('checkout');
        $account = get_page_by_path('my-account');
        
        if ($shop) update_option('woocommerce_shop_page_id', $shop->ID);
        if ($cart) update_option('woocommerce_cart_page_id', $cart->ID);
        if ($checkout) update_option('woocommerce_checkout_page_id', $checkout->ID);
        if ($account) update_option('woocommerce_myaccount_page_id', $account->ID);
    }
}
add_action('after_switch_theme', 'bizmart_theme_activation');

/**
 * Include additional files
 */
require_once BIZMART_THEME_DIR . '/inc/template-functions.php';
require_once BIZMART_THEME_DIR . '/inc/customizer.php';
require_once BIZMART_THEME_DIR . '/inc/woocommerce.php';

// Include admin files only in admin
if (is_admin()) {
    require_once BIZMART_THEME_DIR . '/inc/admin/theme-options.php';
}