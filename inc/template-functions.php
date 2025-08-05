<?php
/**
 * Functions which enhance the theme by hooking into WordPress
 *
 * @package BizMart Pro
 * @version 1.0.0
 */

/**
 * Add a pingback url auto-discovery header for single posts, pages, or attachments.
 */
function bizmart_pingback_header() {
    if (is_singular() && pings_open()) {
        printf('<link rel="pingback" href="%s">', esc_url(get_bloginfo('pingback_url')));
    }
}
add_action('wp_head', 'bizmart_pingback_header');

/**
 * Add CSS class to body based on page template
 */
function bizmart_body_classes($classes) {
    // Add class for Elementor pages
    if (class_exists('Elementor\Plugin') && \Elementor\Plugin::$instance->documents->get(get_the_ID())->is_built_with_elementor()) {
        $classes[] = 'elementor-page';
    }
    
    // Add class for WooCommerce pages
    if (class_exists('WooCommerce')) {
        if (is_woocommerce() || is_cart() || is_checkout() || is_account_page()) {
            $classes[] = 'woocommerce-active';
        }
    }
    
    // Add class for mobile devices
    if (wp_is_mobile()) {
        $classes[] = 'mobile-device';
    }
    
    // Add class for logged-in users
    if (is_user_logged_in()) {
        $classes[] = 'logged-in-user';
    }
    
    return $classes;
}
add_filter('body_class', 'bizmart_body_classes');

/**
 * Add custom post classes
 */
function bizmart_post_classes($classes) {
    // Add class for posts with featured images
    if (has_post_thumbnail()) {
        $classes[] = 'has-featured-image';
    }
    
    // Add class for posts with comments
    if (comments_open() || get_comments_number()) {
        $classes[] = 'has-comments';
    }
    
    return $classes;
}
add_filter('post_class', 'bizmart_post_classes');

/**
 * Custom search form
 */
function bizmart_search_form($form) {
    $form = '<form role="search" method="get" class="search-form" action="' . home_url('/') . '">
        <div class="search-input-wrapper">
            <input type="search" class="search-field" placeholder="' . esc_attr__('Search...', 'bizmart-pro') . '" value="' . get_search_query() . '" name="s" />
            <button type="submit" class="search-submit">
                <i class="fas fa-search"></i>
                <span class="screen-reader-text">' . _x('Search', 'submit button', 'bizmart-pro') . '</span>
            </button>
        </div>
    </form>';
    
    return $form;
}
add_filter('get_search_form', 'bizmart_search_form');

/**
 * Add schema markup to posts
 */
function bizmart_add_schema_markup() {
    if (is_single() && !is_page()) {
        echo '<script type="application/ld+json">';
        echo json_encode(array(
            '@context' => 'https://schema.org',
            '@type' => 'Article',
            'headline' => get_the_title(),
            'description' => get_the_excerpt(),
            'author' => array(
                '@type' => 'Person',
                'name' => get_the_author()
            ),
            'publisher' => array(
                '@type' => 'Organization',
                'name' => get_bloginfo('name'),
                'logo' => array(
                    '@type' => 'ImageObject',
                    'url' => get_site_icon_url()
                )
            ),
            'datePublished' => get_the_date('c'),
            'dateModified' => get_the_modified_date('c'),
            'image' => has_post_thumbnail() ? get_the_post_thumbnail_url() : get_site_icon_url(),
            'url' => get_permalink()
        ));
        echo '</script>';
    }
}
add_action('wp_head', 'bizmart_add_schema_markup');

/**
 * Add custom image sizes
 */
function bizmart_add_image_sizes() {
    add_image_size('bizmart-hero', 1920, 800, true);
    add_image_size('bizmart-large', 800, 600, true);
    add_image_size('bizmart-medium', 600, 400, true);
    add_image_size('bizmart-small', 400, 300, true);
    add_image_size('bizmart-thumb', 300, 300, true);
    add_image_size('bizmart-gallery', 500, 500, true);
}
add_action('after_setup_theme', 'bizmart_add_image_sizes');

/**
 * Add custom image size names
 */
function bizmart_custom_image_sizes($sizes) {
    return array_merge($sizes, array(
        'bizmart-hero' => __('Hero Image', 'bizmart-pro'),
        'bizmart-large' => __('Large Image', 'bizmart-pro'),
        'bizmart-medium' => __('Medium Image', 'bizmart-pro'),
        'bizmart-small' => __('Small Image', 'bizmart-pro'),
        'bizmart-thumb' => __('Thumbnail', 'bizmart-pro'),
        'bizmart-gallery' => __('Gallery Image', 'bizmart-pro'),
    ));
}
add_filter('image_size_names_choose', 'bizmart_custom_image_sizes');

/**
 * Custom post excerpt
 */
function bizmart_custom_excerpt($excerpt) {
    if (empty($excerpt)) {
        $excerpt = get_the_content();
        $excerpt = strip_shortcodes($excerpt);
        $excerpt = wp_strip_all_tags($excerpt);
        $excerpt = wp_trim_words($excerpt, 25, '...');
    }
    return $excerpt;
}
add_filter('get_the_excerpt', 'bizmart_custom_excerpt');

/**
 * Add Read More link to excerpts
 */
function bizmart_excerpt_more($more) {
    if (!is_admin()) {
        global $post;
        $more = '... <a href="' . get_permalink($post->ID) . '" class="read-more">' . __('Read More', 'bizmart-pro') . '</a>';
    }
    return $more;
}
add_filter('excerpt_more', 'bizmart_excerpt_more');

/**
 * Modify comment form
 */
function bizmart_comment_form_fields($fields) {
    $commenter = wp_get_current_commenter();
    
    $fields['author'] = '<div class="form-group"><input id="author" name="author" type="text" value="' . esc_attr($commenter['comment_author']) . '" placeholder="' . __('Your Name *', 'bizmart-pro') . '" required="required" /></div>';
    
    $fields['email'] = '<div class="form-group"><input id="email" name="email" type="email" value="' . esc_attr($commenter['comment_author_email']) . '" placeholder="' . __('Your Email *', 'bizmart-pro') . '" required="required" /></div>';
    
    $fields['url'] = '<div class="form-group"><input id="url" name="url" type="url" value="' . esc_attr($commenter['comment_author_url']) . '" placeholder="' . __('Your Website', 'bizmart-pro') . '" /></div>';
    
    return $fields;
}
add_filter('comment_form_default_fields', 'bizmart_comment_form_fields');

/**
 * Modify comment form textarea
 */
function bizmart_comment_form_defaults($defaults) {
    $defaults['comment_field'] = '<div class="form-group"><textarea id="comment" name="comment" placeholder="' . __('Your Comment *', 'bizmart-pro') . '" required="required"></textarea></div>';
    $defaults['submit_button'] = '<button type="submit" class="btn btn-primary">' . __('Post Comment', 'bizmart-pro') . '</button>';
    $defaults['class_submit'] = 'btn btn-primary';
    $defaults['title_reply'] = __('Leave a Comment', 'bizmart-pro');
    $defaults['title_reply_to'] = __('Reply to %s', 'bizmart-pro');
    $defaults['cancel_reply_link'] = __('Cancel Reply', 'bizmart-pro');
    
    return $defaults;
}
add_filter('comment_form_defaults', 'bizmart_comment_form_defaults');

/**
 * Custom password form for protected posts
 */
function bizmart_password_form($output) {
    global $post;
    $label = 'pwbox-' . (empty($post->ID) ? rand() : $post->ID);
    
    $output = '<form action="' . esc_url(site_url('wp-login.php?action=postpass', 'login_post')) . '" class="post-password-form" method="post">
        <div class="password-form-content">
            <h3>' . __('This content is password protected', 'bizmart-pro') . '</h3>
            <p>' . __('Please enter the password to view this content:', 'bizmart-pro') . '</p>
            <div class="form-group">
                <input name="post_password" id="' . $label . '" type="password" size="20" placeholder="' . __('Enter password', 'bizmart-pro') . '" />
                <button type="submit" class="btn btn-primary">' . __('Submit', 'bizmart-pro') . '</button>
            </div>
        </div>
    </form>';
    
    return $output;
}
add_filter('the_password_form', 'bizmart_password_form');

/**
 * Add custom meta tags
 */
function bizmart_custom_meta_tags() {
    echo '<meta name="theme-color" content="#007cba">' . "\n";
    echo '<meta name="msapplication-TileColor" content="#007cba">' . "\n";
    
    if (is_singular()) {
        global $post;
        if (has_post_thumbnail($post->ID)) {
            $image = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'large');
            echo '<meta property="og:image" content="' . $image[0] . '">' . "\n";
        }
        echo '<meta property="og:title" content="' . get_the_title() . '">' . "\n";
        echo '<meta property="og:description" content="' . get_the_excerpt() . '">' . "\n";
        echo '<meta property="og:url" content="' . get_permalink() . '">' . "\n";
        echo '<meta property="og:type" content="article">' . "\n";
    }
}
add_action('wp_head', 'bizmart_custom_meta_tags');

/**
 * Add preloader
 */
function bizmart_add_preloader() {
    if (get_theme_mod('enable_preloader', false)) {
        echo '<div class="preloader">
            <div class="preloader-content">
                <div class="spinner"></div>
                <div class="loading-text">' . __('Loading...', 'bizmart-pro') . '</div>
            </div>
        </div>';
    }
}
add_action('wp_body_open', 'bizmart_add_preloader');

/**
 * Custom pagination
 */
function bizmart_pagination($args = array()) {
    global $wp_query;
    
    $defaults = array(
        'base' => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
        'format' => '?paged=%#%',
        'current' => max(1, get_query_var('paged')),
        'total' => $wp_query->max_num_pages,
        'prev_text' => '<i class="fas fa-chevron-left"></i>',
        'next_text' => '<i class="fas fa-chevron-right"></i>',
        'type' => 'array',
        'show_all' => false,
        'end_size' => 1,
        'mid_size' => 2,
    );
    
    $args = wp_parse_args($args, $defaults);
    $links = paginate_links($args);
    
    if ($links) {
        echo '<nav class="pagination-wrapper" aria-label="' . __('Posts navigation', 'bizmart-pro') . '">';
        echo '<ul class="pagination">';
        foreach ($links as $link) {
            if (strpos($link, 'current') !== false) {
                echo '<li class="page-item active">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
            } else {
                echo '<li class="page-item">' . str_replace('page-numbers', 'page-link', $link) . '</li>';
            }
        }
        echo '</ul>';
        echo '</nav>';
    }
}

/**
 * Add social sharing buttons
 */
function bizmart_social_share($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $permalink = get_permalink($post_id);
    $title = get_the_title($post_id);
    $image = has_post_thumbnail($post_id) ? get_the_post_thumbnail_url($post_id, 'large') : '';
    
    $social_links = array(
        'facebook' => 'https://www.facebook.com/sharer/sharer.php?u=' . urlencode($permalink),
        'twitter' => 'https://twitter.com/intent/tweet?url=' . urlencode($permalink) . '&text=' . urlencode($title),
        'linkedin' => 'https://www.linkedin.com/sharing/share-offsite/?url=' . urlencode($permalink),
        'pinterest' => 'https://pinterest.com/pin/create/button/?url=' . urlencode($permalink) . '&media=' . urlencode($image) . '&description=' . urlencode($title),
        'whatsapp' => 'https://wa.me/?text=' . urlencode($title . ' ' . $permalink),
    );
    
    echo '<div class="social-share">';
    echo '<h4>' . __('Share this:', 'bizmart-pro') . '</h4>';
    echo '<div class="share-buttons">';
    
    foreach ($social_links as $platform => $url) {
        $icon = $platform === 'whatsapp' ? 'fab fa-whatsapp' : 'fab fa-' . $platform . ($platform === 'facebook' ? '-f' : '');
        echo '<a href="' . esc_url($url) . '" target="_blank" class="share-btn ' . esc_attr($platform) . '" title="' . sprintf(__('Share on %s', 'bizmart-pro'), ucfirst($platform)) . '">';
        echo '<i class="' . esc_attr($icon) . '"></i>';
        echo '</a>';
    }
    
    echo '</div>';
    echo '</div>';
}

/**
 * Add breadcrumbs
 */
function bizmart_breadcrumbs() {
    if (is_front_page()) {
        return;
    }
    
    $separator = '<span class="separator">/</span>';
    $home_title = __('Home', 'bizmart-pro');
    
    echo '<nav class="breadcrumbs" aria-label="' . __('Breadcrumb navigation', 'bizmart-pro') . '">';
    echo '<ol class="breadcrumb-list">';
    echo '<li class="breadcrumb-item"><a href="' . esc_url(home_url('/')) . '">' . $home_title . '</a></li>';
    
    if (is_category()) {
        $category = get_category(get_query_var('cat'));
        if ($category->parent != 0) {
            $category_parents = get_category_parents($category->parent, true, $separator);
            echo '<li class="breadcrumb-item">' . $category_parents . '</li>';
        }
        echo '<li class="breadcrumb-item active">' . single_cat_title('', false) . '</li>';
        
    } elseif (is_page()) {
        if ($post->post_parent) {
            $ancestors = get_post_ancestors($post->ID);
            $ancestors = array_reverse($ancestors);
            foreach ($ancestors as $ancestor) {
                echo '<li class="breadcrumb-item"><a href="' . get_permalink($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
            }
        }
        echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        
    } elseif (is_single()) {
        $categories = get_the_category();
        if ($categories) {
            $category = $categories[0];
            if ($category->parent != 0) {
                $category_parents = get_category_parents($category->parent, true, $separator);
                echo '<li class="breadcrumb-item">' . $category_parents . '</li>';
            }
            echo '<li class="breadcrumb-item"><a href="' . get_category_link($category->term_id) . '">' . $category->name . '</a></li>';
        }
        echo '<li class="breadcrumb-item active">' . get_the_title() . '</li>';
        
    } elseif (is_tag()) {
        echo '<li class="breadcrumb-item active">' . single_tag_title('', false) . '</li>';
        
    } elseif (is_search()) {
        echo '<li class="breadcrumb-item active">' . sprintf(__('Search results for "%s"', 'bizmart-pro'), get_search_query()) . '</li>';
        
    } elseif (is_404()) {
        echo '<li class="breadcrumb-item active">' . __('404 Error', 'bizmart-pro') . '</li>';
    }
    
    echo '</ol>';
    echo '</nav>';
}

/**
 * Get related posts
 */
function bizmart_get_related_posts($post_id = null, $number_posts = 3) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $categories = wp_get_post_categories($post_id);
    
    if (empty($categories)) {
        return array();
    }
    
    $args = array(
        'category__in' => $categories,
        'post__not_in' => array($post_id),
        'posts_per_page' => $number_posts,
        'ignore_sticky_posts' => 1,
        'orderby' => 'rand',
    );
    
    return get_posts($args);
}

/**
 * Add post views functionality
 */
function bizmart_set_post_views($post_id) {
    $key = 'post_views_count';
    $count = get_post_meta($post_id, $key, true);
    if ($count == '') {
        $count = 0;
        delete_post_meta($post_id, $key);
        add_post_meta($post_id, $key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $key, $count);
    }
}

function bizmart_get_post_views($post_id) {
    $key = 'post_views_count';
    $count = get_post_meta($post_id, $key, true);
    if ($count == '') {
        delete_post_meta($post_id, $key);
        add_post_meta($post_id, $key, '0');
        return '0';
    }
    return $count;
}

/**
 * Track post views for single posts
 */
function bizmart_track_post_views($post_id) {
    if (!is_single()) return;
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    bizmart_set_post_views($post_id);
}
add_action('wp_head', 'bizmart_track_post_views');

/**
 * Add estimated reading time
 */
function bizmart_reading_time($post_id = null) {
    if (!$post_id) {
        $post_id = get_the_ID();
    }
    
    $content = get_post_field('post_content', $post_id);
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    
    return $reading_time;
}

/**
 * Add custom CSS to admin
 */
function bizmart_admin_styles() {
    echo '<style>
        .post-php .postbox-container .meta-box-sortables .postbox,
        .page-php .postbox-container .meta-box-sortables .postbox {
            border-left: 4px solid #007cba;
        }
        
        .bizmart-admin-notice {
            border-left: 4px solid #007cba;
            padding: 12px;
            background: #fff;
            box-shadow: 0 1px 1px rgba(0,0,0,.04);
        }
        
        .bizmart-admin-notice h3 {
            margin: 0 0 0.5em 0;
            color: #007cba;
        }
    </style>';
}
add_action('admin_head', 'bizmart_admin_styles');

/**
 * Add theme update notice
 */
function bizmart_admin_notice() {
    $screen = get_current_screen();
    if ($screen->id === 'themes') {
        echo '<div class="notice bizmart-admin-notice">
            <h3>' . __('BizMart Pro Theme', 'bizmart-pro') . '</h3>
            <p>' . __('Thank you for using BizMart Pro! This theme is designed to work perfectly with Elementor and WooCommerce.', 'bizmart-pro') . '</p>
        </div>';
    }
}
add_action('admin_notices', 'bizmart_admin_notice');