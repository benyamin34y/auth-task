<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="https://gmpg.org/xfn/11">

    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<div id="page" class="site">
    <a class="skip-link screen-reader-text" href="#primary"><?php _e('Skip to content', 'bizmart-pro'); ?></a>

    <!-- Header Top Bar -->
    <div class="header-top">
        <div class="container">
            <div class="header-top-content d-flex justify-between align-center">
                <div class="header-top-left">
                    <span class="top-info">
                        <i class="fas fa-phone"></i>
                        <?php echo get_theme_mod('header_phone', '+1 (555) 123-4567'); ?>
                    </span>
                    <span class="top-info">
                        <i class="fas fa-envelope"></i>
                        <?php echo get_theme_mod('header_email', 'info@bizmart.com'); ?>
                    </span>
                </div>
                <div class="header-top-right">
                    <div class="top-links">
                        <?php if (class_exists('WooCommerce')) : ?>
                            <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">
                                <i class="fas fa-user"></i>
                                <?php _e('My Account', 'bizmart-pro'); ?>
                            </a>
                            <a href="<?php echo wc_get_cart_url(); ?>">
                                <i class="fas fa-heart"></i>
                                <?php _e('Wishlist', 'bizmart-pro'); ?>
                            </a>
                        <?php endif; ?>
                        <div class="language-switcher">
                            <i class="fas fa-globe"></i>
                            <span><?php _e('EN', 'bizmart-pro'); ?></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Header -->
    <header id="masthead" class="site-header">
        <div class="header-main">
            <div class="container">
                <div class="header-flex">
                    <!-- Logo -->
                    <div class="site-branding">
                        <?php
                        if (has_custom_logo()) {
                            the_custom_logo();
                        } else {
                            ?>
                            <h1 class="site-title">
                                <a href="<?php echo esc_url(home_url('/')); ?>" rel="home">
                                    <?php bloginfo('name'); ?>
                                </a>
                            </h1>
                            <?php
                            $description = get_bloginfo('description', 'display');
                            if ($description || is_customize_preview()) {
                                ?>
                                <p class="site-description"><?php echo $description; ?></p>
                                <?php
                            }
                        }
                        ?>
                    </div>

                    <!-- Main Navigation -->
                    <nav id="site-navigation" class="main-navigation">
                        <?php
                        wp_nav_menu(array(
                            'theme_location' => 'primary',
                            'menu_id'        => 'primary-menu',
                            'container'      => false,
                            'fallback_cb'    => 'bizmart_fallback_menu',
                        ));
                        ?>
                    </nav>

                    <!-- Header Actions -->
                    <div class="header-actions">
                        <!-- Search Toggle -->
                        <button class="search-toggle" aria-label="<?php _e('Search', 'bizmart-pro'); ?>">
                            <i class="fas fa-search"></i>
                        </button>

                        <?php if (class_exists('WooCommerce')) : ?>
                            <!-- Cart -->
                            <div class="cart-dropdown">
                                <?php bizmart_cart_link(); ?>
                                <div class="cart-dropdown-content">
                                    <div class="widget_shopping_cart_content">
                                        <?php woocommerce_mini_cart(); ?>
                                    </div>
                                </div>
                            </div>

                            <!-- Account -->
                            <a class="account-toggle" href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>">
                                <i class="fas fa-user"></i>
                            </a>
                        <?php endif; ?>

                        <!-- Mobile Menu Toggle -->
                        <button class="mobile-menu-toggle" aria-label="<?php _e('Menu', 'bizmart-pro'); ?>">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search Form -->
        <div class="search-form-wrapper">
            <div class="container">
                <form role="search" method="get" class="search-form" action="<?php echo esc_url(home_url('/')); ?>">
                    <div class="search-input-wrapper">
                        <input type="search" 
                               class="search-field" 
                               placeholder="<?php _e('Search products...', 'bizmart-pro'); ?>" 
                               value="<?php echo get_search_query(); ?>" 
                               name="s" />
                        <?php if (class_exists('WooCommerce')) : ?>
                            <input type="hidden" name="post_type" value="product" />
                        <?php endif; ?>
                        <button type="submit" class="search-submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <button class="search-close" type="button">
                        <i class="fas fa-times"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div class="mobile-menu">
            <div class="mobile-menu-header">
                <div class="mobile-logo">
                    <?php
                    if (has_custom_logo()) {
                        the_custom_logo();
                    } else {
                        ?>
                        <h2><a href="<?php echo esc_url(home_url('/')); ?>"><?php bloginfo('name'); ?></a></h2>
                        <?php
                    }
                    ?>
                </div>
                <button class="mobile-menu-close">
                    <i class="fas fa-times"></i>
                </button>
            </div>
            <nav class="mobile-navigation">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'mobile',
                    'fallback_cb'    => 'bizmart_fallback_menu',
                    'container'      => false,
                ));
                ?>
            </nav>
            <div class="mobile-menu-footer">
                <?php if (class_exists('WooCommerce')) : ?>
                    <a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>" class="mobile-account">
                        <i class="fas fa-user"></i>
                        <?php _e('My Account', 'bizmart-pro'); ?>
                    </a>
                    <a href="<?php echo wc_get_cart_url(); ?>" class="mobile-cart">
                        <i class="fas fa-shopping-cart"></i>
                        <?php _e('Cart', 'bizmart-pro'); ?>
                        <span class="cart-count"><?php echo WC()->cart->get_cart_contents_count(); ?></span>
                    </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Mobile Menu Overlay -->
        <div class="mobile-menu-overlay"></div>
    </header>

    <!-- Breadcrumbs -->
    <?php if (!is_front_page() && !is_home()) : ?>
        <div class="breadcrumbs-wrapper">
            <div class="container">
                <?php
                if (function_exists('woocommerce_breadcrumb')) {
                    woocommerce_breadcrumb();
                } else {
                    bizmart_breadcrumbs();
                }
                ?>
            </div>
        </div>
    <?php endif; ?>

<?php
// Fallback menu function
function bizmart_fallback_menu() {
    $pages = get_pages();
    if ($pages) {
        echo '<ul id="primary-menu" class="menu">';
        echo '<li><a href="' . esc_url(home_url('/')) . '">' . __('Home', 'bizmart-pro') . '</a></li>';
        
        if (class_exists('WooCommerce')) {
            echo '<li><a href="' . get_permalink(wc_get_page_id('shop')) . '">' . __('Shop', 'bizmart-pro') . '</a></li>';
        }
        
        foreach ($pages as $page) {
            if ($page->post_parent == 0) {
                echo '<li><a href="' . get_permalink($page->ID) . '">' . $page->post_title . '</a></li>';
            }
        }
        echo '</ul>';
    }
}

// Breadcrumbs function
function bizmart_breadcrumbs() {
    if (!is_front_page()) {
        echo '<nav class="breadcrumbs">';
        echo '<a href="' . esc_url(home_url('/')) . '">' . __('Home', 'bizmart-pro') . '</a>';
        
        if (is_category() || is_single()) {
            echo ' / ';
            the_category(' / ');
            if (is_single()) {
                echo ' / ';
                the_title();
            }
        } elseif (is_page()) {
            echo ' / ';
            the_title();
        }
        echo '</nav>';
    }
}
?>