<?php
/**
 * BizMart Pro Theme Customizer
 *
 * @package BizMart Pro
 * @version 1.0.0
 */

/**
 * Add postMessage support for site title and description for the Theme Customizer.
 */
function bizmart_customize_register($wp_customize) {
    
    // Site Identity
    $wp_customize->get_setting('blogname')->transport         = 'postMessage';
    $wp_customize->get_setting('blogdescription')->transport  = 'postMessage';
    $wp_customize->get_setting('header_textcolor')->transport = 'postMessage';
    
    if (isset($wp_customize->selective_refresh)) {
        $wp_customize->selective_refresh->add_partial('blogname', array(
            'selector'        => '.site-title a',
            'render_callback' => 'bizmart_customize_partial_blogname',
        ));
        $wp_customize->selective_refresh->add_partial('blogdescription', array(
            'selector'        => '.site-description',
            'render_callback' => 'bizmart_customize_partial_blogdescription',
        ));
    }
    
    // Header Options
    $wp_customize->add_section('bizmart_header_options', array(
        'title'    => __('Header Options', 'bizmart-pro'),
        'priority' => 30,
    ));
    
    // Header Layout
    $wp_customize->add_setting('header_layout', array(
        'default'           => 'default',
        'sanitize_callback' => 'bizmart_sanitize_select',
    ));
    
    $wp_customize->add_control('header_layout', array(
        'label'       => __('Header Layout', 'bizmart-pro'),
        'section'     => 'bizmart_header_options',
        'type'        => 'select',
        'choices'     => array(
            'default'  => __('Default', 'bizmart-pro'),
            'centered' => __('Centered', 'bizmart-pro'),
            'minimal'  => __('Minimal', 'bizmart-pro'),
        ),
    ));
    
    // Enable Sticky Header
    $wp_customize->add_setting('enable_sticky_header', array(
        'default'           => true,
        'sanitize_callback' => 'bizmart_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('enable_sticky_header', array(
        'label'   => __('Enable Sticky Header', 'bizmart-pro'),
        'section' => 'bizmart_header_options',
        'type'    => 'checkbox',
    ));
    
    // Header Phone
    $wp_customize->add_setting('header_phone', array(
        'default'           => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('header_phone', array(
        'label'   => __('Header Phone Number', 'bizmart-pro'),
        'section' => 'bizmart_header_options',
        'type'    => 'text',
    ));
    
    // Header Email
    $wp_customize->add_setting('header_email', array(
        'default'           => 'info@bizmart.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('header_email', array(
        'label'   => __('Header Email Address', 'bizmart-pro'),
        'section' => 'bizmart_header_options',
        'type'    => 'email',
    ));
    
    // Colors
    $wp_customize->add_section('bizmart_colors', array(
        'title'    => __('Theme Colors', 'bizmart-pro'),
        'priority' => 40,
    ));
    
    // Primary Color
    $wp_customize->add_setting('primary_color', array(
        'default'           => '#007cba',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'primary_color', array(
        'label'   => __('Primary Color', 'bizmart-pro'),
        'section' => 'bizmart_colors',
    )));
    
    // Secondary Color
    $wp_customize->add_setting('secondary_color', array(
        'default'           => '#6c757d',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'secondary_color', array(
        'label'   => __('Secondary Color', 'bizmart-pro'),
        'section' => 'bizmart_colors',
    )));
    
    // Accent Color
    $wp_customize->add_setting('accent_color', array(
        'default'           => '#28a745',
        'sanitize_callback' => 'sanitize_hex_color',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control(new WP_Customize_Color_Control($wp_customize, 'accent_color', array(
        'label'   => __('Accent Color', 'bizmart-pro'),
        'section' => 'bizmart_colors',
    )));
    
    // Typography
    $wp_customize->add_section('bizmart_typography', array(
        'title'    => __('Typography', 'bizmart-pro'),
        'priority' => 50,
    ));
    
    // Body Font Family
    $wp_customize->add_setting('body_font_family', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'bizmart_sanitize_select',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('body_font_family', array(
        'label'   => __('Body Font Family', 'bizmart-pro'),
        'section' => 'bizmart_typography',
        'type'    => 'select',
        'choices' => bizmart_get_google_fonts(),
    ));
    
    // Heading Font Family
    $wp_customize->add_setting('heading_font_family', array(
        'default'           => 'Inter',
        'sanitize_callback' => 'bizmart_sanitize_select',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('heading_font_family', array(
        'label'   => __('Heading Font Family', 'bizmart-pro'),
        'section' => 'bizmart_typography',
        'type'    => 'select',
        'choices' => bizmart_get_google_fonts(),
    ));
    
    // Font Size
    $wp_customize->add_setting('body_font_size', array(
        'default'           => '16',
        'sanitize_callback' => 'absint',
        'transport'         => 'postMessage',
    ));
    
    $wp_customize->add_control('body_font_size', array(
        'label'       => __('Body Font Size (px)', 'bizmart-pro'),
        'section'     => 'bizmart_typography',
        'type'        => 'number',
        'input_attrs' => array(
            'min'  => 12,
            'max'  => 24,
            'step' => 1,
        ),
    ));
    
    // Homepage Settings
    $wp_customize->add_section('bizmart_homepage', array(
        'title'    => __('Homepage Settings', 'bizmart-pro'),
        'priority' => 60,
    ));
    
    // Hero Title
    $wp_customize->add_setting('hero_title', array(
        'default'           => __('Welcome to Our Store', 'bizmart-pro'),
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('hero_title', array(
        'label'   => __('Hero Section Title', 'bizmart-pro'),
        'section' => 'bizmart_homepage',
        'type'    => 'text',
    ));
    
    // Hero Subtitle
    $wp_customize->add_setting('hero_subtitle', array(
        'default'           => __('Discover amazing products with unbeatable quality and prices. Shop now and experience the difference.', 'bizmart-pro'),
        'sanitize_callback' => 'sanitize_textarea_field',
    ));
    
    $wp_customize->add_control('hero_subtitle', array(
        'label'   => __('Hero Section Subtitle', 'bizmart-pro'),
        'section' => 'bizmart_homepage',
        'type'    => 'textarea',
    ));
    
    // Hero Background Image
    $wp_customize->add_setting('hero_background_image', array(
        'default'           => '',
        'sanitize_callback' => 'esc_url_raw',
    ));
    
    $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize, 'hero_background_image', array(
        'label'   => __('Hero Background Image', 'bizmart-pro'),
        'section' => 'bizmart_homepage',
    )));
    
    // Enable Hero Parallax
    $wp_customize->add_setting('enable_hero_parallax', array(
        'default'           => false,
        'sanitize_callback' => 'bizmart_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('enable_hero_parallax', array(
        'label'   => __('Enable Hero Parallax Effect', 'bizmart-pro'),
        'section' => 'bizmart_homepage',
        'type'    => 'checkbox',
    ));
    
    // Footer Settings
    $wp_customize->add_section('bizmart_footer', array(
        'title'    => __('Footer Settings', 'bizmart-pro'),
        'priority' => 70,
    ));
    
    // Footer Copyright
    $wp_customize->add_setting('footer_copyright', array(
        'default'           => sprintf(__('© %s %s. All rights reserved.', 'bizmart-pro'), date('Y'), get_bloginfo('name')),
        'sanitize_callback' => 'wp_kses_post',
    ));
    
    $wp_customize->add_control('footer_copyright', array(
        'label'   => __('Footer Copyright Text', 'bizmart-pro'),
        'section' => 'bizmart_footer',
        'type'    => 'textarea',
    ));
    
    // Footer Address
    $wp_customize->add_setting('footer_address', array(
        'default'           => '123 Business St, City, State 12345',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_address', array(
        'label'   => __('Footer Address', 'bizmart-pro'),
        'section' => 'bizmart_footer',
        'type'    => 'text',
    ));
    
    // Footer Phone
    $wp_customize->add_setting('footer_phone', array(
        'default'           => '+1 (555) 123-4567',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_phone', array(
        'label'   => __('Footer Phone Number', 'bizmart-pro'),
        'section' => 'bizmart_footer',
        'type'    => 'text',
    ));
    
    // Footer Email
    $wp_customize->add_setting('footer_email', array(
        'default'           => 'info@bizmart.com',
        'sanitize_callback' => 'sanitize_email',
    ));
    
    $wp_customize->add_control('footer_email', array(
        'label'   => __('Footer Email Address', 'bizmart-pro'),
        'section' => 'bizmart_footer',
        'type'    => 'email',
    ));
    
    // Footer Business Hours
    $wp_customize->add_setting('footer_hours', array(
        'default'           => 'Mon - Fri: 9:00 AM - 6:00 PM',
        'sanitize_callback' => 'sanitize_text_field',
    ));
    
    $wp_customize->add_control('footer_hours', array(
        'label'   => __('Business Hours', 'bizmart-pro'),
        'section' => 'bizmart_footer',
        'type'    => 'text',
    ));
    
    // Social Media
    $wp_customize->add_section('bizmart_social', array(
        'title'    => __('Social Media', 'bizmart-pro'),
        'priority' => 80,
    ));
    
    $social_platforms = array(
        'facebook'  => __('Facebook URL', 'bizmart-pro'),
        'twitter'   => __('Twitter URL', 'bizmart-pro'),
        'instagram' => __('Instagram URL', 'bizmart-pro'),
        'linkedin'  => __('LinkedIn URL', 'bizmart-pro'),
        'youtube'   => __('YouTube URL', 'bizmart-pro'),
        'pinterest' => __('Pinterest URL', 'bizmart-pro'),
    );
    
    foreach ($social_platforms as $platform => $label) {
        $wp_customize->add_setting('social_' . $platform, array(
            'default'           => '',
            'sanitize_callback' => 'esc_url_raw',
        ));
        
        $wp_customize->add_control('social_' . $platform, array(
            'label'   => $label,
            'section' => 'bizmart_social',
            'type'    => 'url',
        ));
    }
    
    // Performance & Features
    $wp_customize->add_section('bizmart_performance', array(
        'title'    => __('Performance & Features', 'bizmart-pro'),
        'priority' => 90,
    ));
    
    // Enable Preloader
    $wp_customize->add_setting('enable_preloader', array(
        'default'           => false,
        'sanitize_callback' => 'bizmart_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('enable_preloader', array(
        'label'   => __('Enable Preloader', 'bizmart-pro'),
        'section' => 'bizmart_performance',
        'type'    => 'checkbox',
    ));
    
    // Enable Smooth Scroll
    $wp_customize->add_setting('enable_smooth_scroll', array(
        'default'           => true,
        'sanitize_callback' => 'bizmart_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('enable_smooth_scroll', array(
        'label'   => __('Enable Smooth Scrolling', 'bizmart-pro'),
        'section' => 'bizmart_performance',
        'type'    => 'checkbox',
    ));
    
    // Enable Back to Top
    $wp_customize->add_setting('enable_back_to_top', array(
        'default'           => true,
        'sanitize_callback' => 'bizmart_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('enable_back_to_top', array(
        'label'   => __('Enable Back to Top Button', 'bizmart-pro'),
        'section' => 'bizmart_performance',
        'type'    => 'checkbox',
    ));
    
    // Enable Lazy Loading
    $wp_customize->add_setting('enable_lazy_loading', array(
        'default'           => true,
        'sanitize_callback' => 'bizmart_sanitize_checkbox',
    ));
    
    $wp_customize->add_control('enable_lazy_loading', array(
        'label'   => __('Enable Lazy Loading for Images', 'bizmart-pro'),
        'section' => 'bizmart_performance',
        'type'    => 'checkbox',
    ));
    
    // Custom CSS
    $wp_customize->add_section('bizmart_custom_css', array(
        'title'    => __('Additional CSS', 'bizmart-pro'),
        'priority' => 200,
    ));
    
    $wp_customize->add_setting('custom_css', array(
        'default'           => '',
        'sanitize_callback' => 'wp_strip_all_tags',
    ));
    
    $wp_customize->add_control('custom_css', array(
        'label'   => __('Custom CSS', 'bizmart-pro'),
        'section' => 'bizmart_custom_css',
        'type'    => 'textarea',
        'description' => __('Add your custom CSS here. This will be applied after the theme styles.', 'bizmart-pro'),
    ));
}
add_action('customize_register', 'bizmart_customize_register');

/**
 * Render the site title for the selective refresh partial.
 */
function bizmart_customize_partial_blogname() {
    bloginfo('name');
}

/**
 * Render the site tagline for the selective refresh partial.
 */
function bizmart_customize_partial_blogdescription() {
    bloginfo('description');
}

/**
 * Sanitize select options
 */
function bizmart_sanitize_select($input, $setting) {
    $input = sanitize_key($input);
    $choices = $setting->manager->get_control($setting->id)->choices;
    return (array_key_exists($input, $choices) ? $input : $setting->default);
}

/**
 * Sanitize checkbox
 */
function bizmart_sanitize_checkbox($checked) {
    return ((isset($checked) && true == $checked) ? true : false);
}

/**
 * Get Google Fonts list
 */
function bizmart_get_google_fonts() {
    return array(
        'Inter'       => 'Inter',
        'Roboto'      => 'Roboto',
        'Open Sans'   => 'Open Sans',
        'Lato'        => 'Lato',
        'Poppins'     => 'Poppins',
        'Montserrat'  => 'Montserrat',
        'Source Sans Pro' => 'Source Sans Pro',
        'Nunito'      => 'Nunito',
        'PT Sans'     => 'PT Sans',
        'Raleway'     => 'Raleway',
        'Ubuntu'      => 'Ubuntu',
        'Merriweather' => 'Merriweather',
        'Playfair Display' => 'Playfair Display',
        'Oswald'      => 'Oswald',
        'Work Sans'   => 'Work Sans',
    );
}

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bizmart_customize_preview_js() {
    wp_enqueue_script('bizmart-customizer', get_template_directory_uri() . '/assets/js/customizer.js', array('customize-preview'), BIZMART_VERSION, true);
}
add_action('customize_preview_init', 'bizmart_customize_preview_js');

/**
 * Enqueue customizer controls scripts
 */
function bizmart_customize_controls_js() {
    wp_enqueue_script('bizmart-customizer-controls', get_template_directory_uri() . '/assets/js/customizer-controls.js', array('customize-controls'), BIZMART_VERSION, true);
}
add_action('customize_controls_enqueue_scripts', 'bizmart_customize_controls_js');

/**
 * Add custom CSS from customizer
 */
function bizmart_customizer_css() {
    $primary_color = get_theme_mod('primary_color', '#007cba');
    $secondary_color = get_theme_mod('secondary_color', '#6c757d');
    $accent_color = get_theme_mod('accent_color', '#28a745');
    $body_font = get_theme_mod('body_font_family', 'Inter');
    $heading_font = get_theme_mod('heading_font_family', 'Inter');
    $font_size = get_theme_mod('body_font_size', '16');
    $custom_css = get_theme_mod('custom_css', '');
    
    $css = "
        :root {
            --primary-color: {$primary_color};
            --secondary-color: {$secondary_color};
            --accent-color: {$accent_color};
            --body-font: '{$body_font}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --heading-font: '{$heading_font}', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            --body-font-size: {$font_size}px;
        }
        
        body {
            font-family: var(--body-font);
            font-size: var(--body-font-size);
        }
        
        h1, h2, h3, h4, h5, h6 {
            font-family: var(--heading-font);
        }
        
        .btn-primary,
        .search-submit,
        .woocommerce #respond input#submit,
        .woocommerce a.button,
        .woocommerce button.button,
        .woocommerce input.button {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover,
        .search-submit:hover,
        .woocommerce #respond input#submit:hover,
        .woocommerce a.button:hover,
        .woocommerce button.button:hover,
        .woocommerce input.button:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-secondary {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-success {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        a,
        .main-navigation a:hover,
        .widget a:hover,
        .entry-meta a:hover {
            color: var(--primary-color);
        }
        
        .site-header {
            background-color: rgba(255, 255, 255, 0.95);
        }
        
        .widget-title::after,
        .section-title::after {
            background-color: var(--primary-color);
        }
        
        .woocommerce .star-rating span::before {
            color: var(--accent-color);
        }
        
        .woocommerce-message,
        .woocommerce-info {
            border-top-color: var(--primary-color);
        }
        
        {$custom_css}
    ";
    
    wp_add_inline_style('bizmart-style', $css);
}
add_action('wp_enqueue_scripts', 'bizmart_customizer_css');

/**
 * Load Google Fonts
 */
function bizmart_load_google_fonts() {
    $body_font = get_theme_mod('body_font_family', 'Inter');
    $heading_font = get_theme_mod('heading_font_family', 'Inter');
    
    $fonts = array();
    if ($body_font !== 'inherit') {
        $fonts[] = $body_font . ':300,400,500,600,700';
    }
    if ($heading_font !== 'inherit' && $heading_font !== $body_font) {
        $fonts[] = $heading_font . ':300,400,500,600,700';
    }
    
    if (!empty($fonts)) {
        $fonts_url = 'https://fonts.googleapis.com/css2?family=' . implode('&family=', $fonts) . '&display=swap';
        wp_enqueue_style('bizmart-google-fonts', $fonts_url, array(), null);
    }
}
add_action('wp_enqueue_scripts', 'bizmart_load_google_fonts');

/**
 * Add customizer styles
 */
function bizmart_customizer_styles() {
    ?>
    <style>
        .customize-control-title {
            font-weight: 600;
            margin-bottom: 5px;
        }
        
        .customize-control-description {
            font-style: italic;
            margin-top: 5px;
            color: #666;
        }
        
        .customize-section-title {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 15px;
        }
    </style>
    <?php
}
add_action('customize_controls_print_styles', 'bizmart_customizer_styles');