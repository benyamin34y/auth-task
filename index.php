<?php
/**
 * The main template file
 *
 * @package BizMart Pro
 * @version 1.0.0
 */

get_header(); ?>

<main id="primary" class="site-main">
    
    <?php if (is_home() && !is_paged()) : ?>
        
        <!-- Hero Section -->
        <section class="hero-section">
            <div class="container">
                <div class="hero-content">
                    <h1><?php echo get_theme_mod('hero_title', __('Welcome to Our Store', 'bizmart-pro')); ?></h1>
                    <p><?php echo get_theme_mod('hero_subtitle', __('Discover amazing products with unbeatable quality and prices. Shop now and experience the difference.', 'bizmart-pro')); ?></p>
                    <div class="hero-buttons">
                        <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-primary">
                            <?php _e('Shop Now', 'bizmart-pro'); ?>
                        </a>
                        <a href="#featured-products" class="btn btn-outline">
                            <?php _e('Learn More', 'bizmart-pro'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Featured Categories -->
        <section class="featured-categories section-padding">
            <div class="container">
                <div class="section-header text-center mb-3">
                    <h2><?php _e('Shop by Category', 'bizmart-pro'); ?></h2>
                    <p><?php _e('Browse our carefully curated collection of premium products', 'bizmart-pro'); ?></p>
                </div>
                
                <div class="categories-grid">
                    <?php
                    if (class_exists('WooCommerce')) {
                        $categories = get_terms(array(
                            'taxonomy' => 'product_cat',
                            'hide_empty' => true,
                            'number' => 6,
                            'parent' => 0,
                        ));
                        
                        if ($categories && !is_wp_error($categories)) {
                            foreach ($categories as $category) {
                                $thumbnail_id = get_term_meta($category->term_id, 'thumbnail_id', true);
                                $image = wp_get_attachment_url($thumbnail_id);
                                ?>
                                <div class="category-card">
                                    <a href="<?php echo get_term_link($category); ?>">
                                        <div class="category-image">
                                            <?php if ($image) : ?>
                                                <img src="<?php echo esc_url($image); ?>" alt="<?php echo esc_attr($category->name); ?>">
                                            <?php else : ?>
                                                <div class="category-placeholder">
                                                    <i class="fas fa-image"></i>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="category-info">
                                            <h3><?php echo esc_html($category->name); ?></h3>
                                            <span class="product-count"><?php echo $category->count; ?> <?php _e('Products', 'bizmart-pro'); ?></span>
                                        </div>
                                    </a>
                                </div>
                                <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Featured Products -->
        <section id="featured-products" class="featured-products section-padding bg-light">
            <div class="container">
                <div class="section-header text-center mb-3">
                    <h2><?php _e('Featured Products', 'bizmart-pro'); ?></h2>
                    <p><?php _e('Check out our best-selling and most popular items', 'bizmart-pro'); ?></p>
                </div>
                
                <div class="product-grid">
                    <?php
                    if (class_exists('WooCommerce')) {
                        $featured_products = wc_get_featured_product_ids();
                        $args = array(
                            'post_type' => 'product',
                            'posts_per_page' => 8,
                            'post__in' => $featured_products,
                            'orderby' => 'menu_order',
                            'order' => 'ASC',
                        );
                        
                        $products = new WP_Query($args);
                        
                        if ($products->have_posts()) {
                            while ($products->have_posts()) {
                                $products->the_post();
                                global $product;
                                ?>
                                <div class="product-card">
                                    <div class="product-image">
                                        <a href="<?php the_permalink(); ?>">
                                            <?php
                                            if (has_post_thumbnail()) {
                                                the_post_thumbnail('medium');
                                            } else {
                                                echo '<div class="product-placeholder"><i class="fas fa-image"></i></div>';
                                            }
                                            ?>
                                        </a>
                                        <div class="product-actions">
                                            <?php echo do_shortcode('[add_to_cart id="' . get_the_ID() . '" style="" show_price="false" text="Add to Cart"]'); ?>
                                        </div>
                                    </div>
                                    <div class="product-info">
                                        <h3 class="product-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h3>
                                        <div class="product-price">
                                            <?php echo $product->get_price_html(); ?>
                                        </div>
                                        <div class="product-rating">
                                            <?php echo wc_get_rating_html($product->get_average_rating()); ?>
                                        </div>
                                    </div>
                                </div>
                                <?php
                            }
                            wp_reset_postdata();
                        }
                    }
                    ?>
                </div>
                
                <div class="text-center mt-2">
                    <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-primary">
                        <?php _e('View All Products', 'bizmart-pro'); ?>
                    </a>
                </div>
            </div>
        </section>

        <!-- Special Offers -->
        <section class="special-offers section-padding">
            <div class="container">
                <div class="offers-grid">
                    <div class="offer-card offer-primary">
                        <div class="offer-content">
                            <h3><?php _e('Summer Sale', 'bizmart-pro'); ?></h3>
                            <p><?php _e('Up to 50% off on selected items', 'bizmart-pro'); ?></p>
                            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-primary">
                                <?php _e('Shop Sale', 'bizmart-pro'); ?>
                            </a>
                        </div>
                    </div>
                    <div class="offer-card offer-secondary">
                        <div class="offer-content">
                            <h3><?php _e('Free Shipping', 'bizmart-pro'); ?></h3>
                            <p><?php _e('On orders over $99', 'bizmart-pro'); ?></p>
                            <a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>" class="btn btn-outline">
                                <?php _e('Learn More', 'bizmart-pro'); ?>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Testimonials -->
        <section class="testimonials section-padding bg-light">
            <div class="container">
                <div class="section-header text-center mb-3">
                    <h2><?php _e('What Our Customers Say', 'bizmart-pro'); ?></h2>
                    <p><?php _e('Read reviews from our satisfied customers', 'bizmart-pro'); ?></p>
                </div>
                
                <div class="testimonials-grid">
                    <?php
                    $testimonials = new WP_Query(array(
                        'post_type' => 'testimonials',
                        'posts_per_page' => 3,
                        'post_status' => 'publish',
                    ));
                    
                    if ($testimonials->have_posts()) {
                        while ($testimonials->have_posts()) {
                            $testimonials->the_post();
                            ?>
                            <div class="testimonial-card">
                                <div class="testimonial-content">
                                    <div class="testimonial-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p><?php the_content(); ?></p>
                                </div>
                                <div class="testimonial-author">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="author-avatar">
                                            <?php the_post_thumbnail('thumbnail'); ?>
                                        </div>
                                    <?php endif; ?>
                                    <div class="author-info">
                                        <h4><?php the_title(); ?></h4>
                                        <span><?php echo get_post_meta(get_the_ID(), 'company', true); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                        wp_reset_postdata();
                    } else {
                        // Default testimonials if none exist
                        $default_testimonials = array(
                            array(
                                'content' => 'Amazing quality products and excellent customer service. Highly recommended!',
                                'author' => 'Sarah Johnson',
                                'company' => 'Business Owner'
                            ),
                            array(
                                'content' => 'Fast shipping and great prices. Will definitely shop here again.',
                                'author' => 'Mike Chen',
                                'company' => 'Marketing Manager'
                            ),
                            array(
                                'content' => 'Professional service and top-notch products. Five stars!',
                                'author' => 'Emily Davis',
                                'company' => 'Designer'
                            ),
                        );
                        
                        foreach ($default_testimonials as $testimonial) {
                            ?>
                            <div class="testimonial-card">
                                <div class="testimonial-content">
                                    <div class="testimonial-rating">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                    <p><?php echo esc_html($testimonial['content']); ?></p>
                                </div>
                                <div class="testimonial-author">
                                    <div class="author-info">
                                        <h4><?php echo esc_html($testimonial['author']); ?></h4>
                                        <span><?php echo esc_html($testimonial['company']); ?></span>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
        </section>

        <!-- Newsletter -->
        <section class="newsletter section-padding">
            <div class="container">
                <div class="newsletter-content text-center">
                    <h2><?php _e('Stay Updated', 'bizmart-pro'); ?></h2>
                    <p><?php _e('Subscribe to our newsletter and get the latest updates and offers', 'bizmart-pro'); ?></p>
                    <form class="newsletter-form">
                        <div class="form-group">
                            <input type="email" placeholder="<?php _e('Enter your email address', 'bizmart-pro'); ?>" required>
                            <button type="submit" class="btn btn-primary">
                                <?php _e('Subscribe', 'bizmart-pro'); ?>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </section>

    <?php else : ?>
        
        <!-- Blog Posts -->
        <div class="container section-padding">
            <div class="row">
                <div class="col-lg-8">
                    <div class="posts-grid">
                        <?php
                        if (have_posts()) {
                            while (have_posts()) {
                                the_post();
                                ?>
                                <article class="post-card">
                                    <?php if (has_post_thumbnail()) : ?>
                                        <div class="post-thumbnail">
                                            <a href="<?php the_permalink(); ?>">
                                                <?php the_post_thumbnail('medium_large'); ?>
                                            </a>
                                        </div>
                                    <?php endif; ?>
                                    
                                    <div class="post-content">
                                        <div class="post-meta">
                                            <span class="post-date"><?php echo get_the_date(); ?></span>
                                            <span class="post-category">
                                                <?php the_category(', '); ?>
                                            </span>
                                        </div>
                                        
                                        <h2 class="post-title">
                                            <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                        </h2>
                                        
                                        <div class="post-excerpt">
                                            <?php the_excerpt(); ?>
                                        </div>
                                        
                                        <a href="<?php the_permalink(); ?>" class="read-more">
                                            <?php _e('Read More', 'bizmart-pro'); ?>
                                        </a>
                                    </div>
                                </article>
                                <?php
                            }
                            
                            // Pagination
                            the_posts_pagination(array(
                                'prev_text' => __('Previous', 'bizmart-pro'),
                                'next_text' => __('Next', 'bizmart-pro'),
                            ));
                            
                        } else {
                            ?>
                            <div class="no-posts">
                                <h2><?php _e('Nothing Found', 'bizmart-pro'); ?></h2>
                                <p><?php _e('It seems we can\'t find what you\'re looking for. Perhaps searching can help.', 'bizmart-pro'); ?></p>
                                <?php get_search_form(); ?>
                            </div>
                            <?php
                        }
                        ?>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <?php get_sidebar(); ?>
                </div>
            </div>
        </div>
        
    <?php endif; ?>

</main>

<?php
get_footer();
?>