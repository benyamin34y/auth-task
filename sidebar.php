<?php
/**
 * The sidebar containing the main widget area
 *
 * @package BizMart Pro
 * @version 1.0.0
 */

if (!is_active_sidebar('sidebar-main')) {
    return;
}
?>

<aside id="secondary" class="widget-area sidebar">
    
    <!-- Search Widget -->
    <section class="widget widget_search">
        <h3 class="widget-title"><?php _e('Search', 'bizmart-pro'); ?></h3>
        <?php get_search_form(); ?>
    </section>

    <!-- Recent Posts -->
    <section class="widget widget_recent_entries">
        <h3 class="widget-title"><?php _e('Recent Posts', 'bizmart-pro'); ?></h3>
        <ul class="recent-posts-list">
            <?php
            $recent_posts = wp_get_recent_posts(array(
                'numberposts' => 5,
                'post_status' => 'publish'
            ));

            foreach ($recent_posts as $recent) :
                ?>
                <li class="recent-post-item">
                    <div class="post-meta">
                        <span class="post-date"><?php echo get_the_date('M j, Y', $recent['ID']); ?></span>
                    </div>
                    <h4 class="post-title">
                        <a href="<?php echo get_permalink($recent['ID']); ?>">
                            <?php echo $recent['post_title']; ?>
                        </a>
                    </h4>
                </li>
                <?php
            endforeach;
            wp_reset_query();
            ?>
        </ul>
    </section>

    <!-- Categories -->
    <section class="widget widget_categories">
        <h3 class="widget-title"><?php _e('Categories', 'bizmart-pro'); ?></h3>
        <ul class="categories-list">
            <?php
            wp_list_categories(array(
                'orderby'    => 'count',
                'order'      => 'DESC',
                'show_count' => 1,
                'title_li'   => '',
                'number'     => 10,
            ));
            ?>
        </ul>
    </section>

    <!-- Tag Cloud -->
    <section class="widget widget_tag_cloud">
        <h3 class="widget-title"><?php _e('Tags', 'bizmart-pro'); ?></h3>
        <div class="tagcloud">
            <?php
            wp_tag_cloud(array(
                'smallest'                  => 0.8,
                'largest'                   => 1.25,
                'unit'                      => 'rem',
                'number'                    => 20,
            ));
            ?>
        </div>
    </section>

    <!-- Newsletter Signup -->
    <section class="widget widget_newsletter">
        <h3 class="widget-title"><?php _e('Newsletter', 'bizmart-pro'); ?></h3>
        <div class="newsletter-widget">
            <p><?php _e('Subscribe to our newsletter to get the latest updates and offers.', 'bizmart-pro'); ?></p>
            <form class="newsletter-form widget-newsletter-form">
                <div class="form-group">
                    <input type="email" placeholder="<?php _e('Your email address', 'bizmart-pro'); ?>" required>
                    <button type="submit" class="btn btn-primary">
                        <?php _e('Subscribe', 'bizmart-pro'); ?>
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- Archives -->
    <section class="widget widget_archive">
        <h3 class="widget-title"><?php _e('Archives', 'bizmart-pro'); ?></h3>
        <ul class="archives-list">
            <?php
            wp_get_archives(array(
                'type'            => 'monthly',
                'limit'           => 12,
                'format'          => 'html',
                'show_post_count' => true,
            ));
            ?>
        </ul>
    </section>

    <!-- Popular Posts -->
    <section class="widget widget_popular_posts">
        <h3 class="widget-title"><?php _e('Popular Posts', 'bizmart-pro'); ?></h3>
        <ul class="popular-posts-list">
            <?php
            $popular_posts = new WP_Query(array(
                'posts_per_page' => 5,
                'meta_key' => 'post_views_count',
                'orderby' => 'meta_value_num',
                'order' => 'DESC',
            ));

            if ($popular_posts->have_posts()) :
                while ($popular_posts->have_posts()) : $popular_posts->the_post();
                    ?>
                    <li class="popular-post-item">
                        <?php if (has_post_thumbnail()) : ?>
                            <div class="post-thumbnail">
                                <a href="<?php the_permalink(); ?>">
                                    <?php the_post_thumbnail('thumbnail'); ?>
                                </a>
                            </div>
                        <?php endif; ?>
                        <div class="post-content">
                            <div class="post-meta">
                                <span class="post-date"><?php echo get_the_date(); ?></span>
                                <span class="post-views">
                                    <?php
                                    $views = get_post_meta(get_the_ID(), 'post_views_count', true);
                                    echo ($views ? $views : '0') . ' ' . __('views', 'bizmart-pro');
                                    ?>
                                </span>
                            </div>
                            <h4 class="post-title">
                                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                            </h4>
                        </div>
                    </li>
                    <?php
                endwhile;
                wp_reset_postdata();
            else :
                echo '<li>' . __('No popular posts found.', 'bizmart-pro') . '</li>';
            endif;
            ?>
        </ul>
    </section>

    <!-- Social Media -->
    <section class="widget widget_social_media">
        <h3 class="widget-title"><?php _e('Follow Us', 'bizmart-pro'); ?></h3>
        <div class="social-media-links">
            <a href="#" class="social-link facebook" target="_blank">
                <i class="fab fa-facebook-f"></i>
                <span><?php _e('Facebook', 'bizmart-pro'); ?></span>
            </a>
            <a href="#" class="social-link twitter" target="_blank">
                <i class="fab fa-twitter"></i>
                <span><?php _e('Twitter', 'bizmart-pro'); ?></span>
            </a>
            <a href="#" class="social-link instagram" target="_blank">
                <i class="fab fa-instagram"></i>
                <span><?php _e('Instagram', 'bizmart-pro'); ?></span>
            </a>
            <a href="#" class="social-link linkedin" target="_blank">
                <i class="fab fa-linkedin-in"></i>
                <span><?php _e('LinkedIn', 'bizmart-pro'); ?></span>
            </a>
            <a href="#" class="social-link youtube" target="_blank">
                <i class="fab fa-youtube"></i>
                <span><?php _e('YouTube', 'bizmart-pro'); ?></span>
            </a>
        </div>
    </section>

    <!-- Custom Widget Area -->
    <?php dynamic_sidebar('sidebar-main'); ?>

</aside>

<style>
/* Sidebar Styles */
.sidebar {
    background: #f8f9fa;
    padding: 30px;
    border-radius: 12px;
    margin-bottom: 40px;
}

.sidebar .widget {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #e9ecef;
}

.sidebar .widget:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.widget-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 20px;
    color: #333;
    position: relative;
    padding-bottom: 10px;
}

.widget-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 40px;
    height: 3px;
    background: #007cba;
    border-radius: 2px;
}

/* Search Widget */
.widget_search .search-form {
    position: relative;
}

.widget_search .search-field {
    width: 100%;
    padding: 12px 45px 12px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.3s ease;
}

.widget_search .search-field:focus {
    border-color: #007cba;
    outline: none;
}

.widget_search .search-submit {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: #007cba;
    color: #fff;
    border: none;
    padding: 8px 12px;
    border-radius: 6px;
    cursor: pointer;
    transition: background 0.3s ease;
}

.widget_search .search-submit:hover {
    background: #005a87;
}

/* Recent Posts */
.recent-posts-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.recent-post-item {
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e9ecef;
}

.recent-post-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.recent-post-item .post-meta {
    margin-bottom: 8px;
}

.recent-post-item .post-date {
    font-size: 0.85rem;
    color: #6c757d;
}

.recent-post-item .post-title {
    margin: 0;
    font-size: 1rem;
    line-height: 1.4;
}

.recent-post-item .post-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.recent-post-item .post-title a:hover {
    color: #007cba;
}

/* Categories */
.categories-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.categories-list li {
    margin-bottom: 8px;
}

.categories-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #333;
    text-decoration: none;
    padding: 8px 0;
    transition: color 0.3s ease;
    border-bottom: 1px solid transparent;
}

.categories-list a:hover {
    color: #007cba;
    border-bottom-color: #007cba;
}

.categories-list .count {
    background: #e9ecef;
    color: #6c757d;
    padding: 2px 8px;
    border-radius: 12px;
    font-size: 0.8rem;
}

/* Tag Cloud */
.tagcloud {
    line-height: 1.8;
}

.tagcloud a {
    display: inline-block;
    background: #e9ecef;
    color: #333;
    padding: 5px 12px;
    margin: 2px 4px 2px 0;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.9rem !important;
    transition: all 0.3s ease;
}

.tagcloud a:hover {
    background: #007cba;
    color: #fff;
    transform: translateY(-2px);
}

/* Newsletter Widget */
.newsletter-widget p {
    margin-bottom: 20px;
    color: #666;
    line-height: 1.5;
}

.widget-newsletter-form .form-group {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.widget-newsletter-form input {
    padding: 12px 15px;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    font-size: 0.95rem;
    transition: border-color 0.3s ease;
}

.widget-newsletter-form input:focus {
    border-color: #007cba;
    outline: none;
}

.widget-newsletter-form button {
    padding: 12px 20px;
    border-radius: 8px;
}

/* Archives */
.archives-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.archives-list li {
    margin-bottom: 8px;
}

.archives-list a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    color: #333;
    text-decoration: none;
    padding: 8px 0;
    transition: color 0.3s ease;
}

.archives-list a:hover {
    color: #007cba;
}

/* Popular Posts */
.popular-posts-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.popular-post-item {
    display: flex;
    gap: 15px;
    margin-bottom: 20px;
    padding-bottom: 15px;
    border-bottom: 1px solid #e9ecef;
}

.popular-post-item:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.popular-post-item .post-thumbnail {
    width: 60px;
    height: 60px;
    overflow: hidden;
    border-radius: 8px;
    flex-shrink: 0;
}

.popular-post-item .post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.popular-post-item:hover .post-thumbnail img {
    transform: scale(1.1);
}

.popular-post-item .post-content {
    flex: 1;
}

.popular-post-item .post-meta {
    margin-bottom: 5px;
}

.popular-post-item .post-date,
.popular-post-item .post-views {
    font-size: 0.8rem;
    color: #6c757d;
    margin-right: 10px;
}

.popular-post-item .post-title {
    margin: 0;
    font-size: 0.95rem;
    line-height: 1.3;
}

.popular-post-item .post-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.popular-post-item .post-title a:hover {
    color: #007cba;
}

/* Social Media */
.social-media-links {
    display: flex;
    flex-direction: column;
    gap: 10px;
}

.social-link {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px 15px;
    border-radius: 8px;
    text-decoration: none;
    color: #fff;
    transition: all 0.3s ease;
}

.social-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.social-link i {
    font-size: 1.1rem;
    width: 20px;
    text-align: center;
}

.social-link.facebook { background: #3b5998; }
.social-link.twitter { background: #1da1f2; }
.social-link.instagram { background: linear-gradient(45deg, #f09433 0%,#e6683c 25%,#dc2743 50%,#cc2366 75%,#bc1888 100%); }
.social-link.linkedin { background: #0077b5; }
.social-link.youtube { background: #ff0000; }

/* Responsive Design */
@media (max-width: 768px) {
    .sidebar {
        padding: 20px;
        margin-bottom: 30px;
    }
    
    .popular-post-item {
        flex-direction: column;
        text-align: center;
    }
    
    .popular-post-item .post-thumbnail {
        width: 100%;
        height: 150px;
    }
    
    .social-media-links {
        flex-direction: row;
        flex-wrap: wrap;
    }
    
    .social-link {
        flex: 1;
        min-width: calc(50% - 5px);
        justify-content: center;
    }
}

/* Animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.widget {
    animation: fadeInUp 0.6s ease-out;
}

.widget:nth-child(2) { animation-delay: 0.1s; }
.widget:nth-child(3) { animation-delay: 0.2s; }
.widget:nth-child(4) { animation-delay: 0.3s; }
.widget:nth-child(5) { animation-delay: 0.4s; }
.widget:nth-child(6) { animation-delay: 0.5s; }
</style>