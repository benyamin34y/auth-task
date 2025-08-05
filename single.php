<?php
/**
 * The template for displaying all single posts
 *
 * @package BizMart Pro
 * @version 1.0.0
 */

get_header(); ?>

<main id="primary" class="site-main single-post-page">
    <div class="container">
        <div class="row">
            
            <!-- Main Content -->
            <div class="col-lg-8 col-md-8">
                <div class="post-content-wrapper">
                    
                    <?php while (have_posts()) : the_post(); ?>
                        
                        <article id="post-<?php the_ID(); ?>" <?php post_class('single-post'); ?>>
                            
                            <!-- Post Header -->
                            <header class="post-header">
                                
                                <!-- Category -->
                                <div class="post-categories">
                                    <?php
                                    $categories = get_the_category();
                                    if ($categories) {
                                        foreach ($categories as $category) {
                                            echo '<a href="' . get_category_link($category->term_id) . '" class="category-link">' . $category->name . '</a>';
                                        }
                                    }
                                    ?>
                                </div>
                                
                                <!-- Title -->
                                <h1 class="post-title"><?php the_title(); ?></h1>
                                
                                <!-- Meta -->
                                <div class="post-meta">
                                    <div class="meta-item author">
                                        <?php echo get_avatar(get_the_author_meta('ID'), 40); ?>
                                        <span class="author-name">
                                            <?php _e('By', 'bizmart-pro'); ?> 
                                            <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                                <?php the_author(); ?>
                                            </a>
                                        </span>
                                    </div>
                                    <div class="meta-item date">
                                        <i class="fas fa-calendar-alt"></i>
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </div>
                                    <div class="meta-item reading-time">
                                        <i class="fas fa-clock"></i>
                                        <span><?php echo bizmart_reading_time(); ?> <?php _e('min read', 'bizmart-pro'); ?></span>
                                    </div>
                                    <div class="meta-item views">
                                        <i class="fas fa-eye"></i>
                                        <span><?php echo bizmart_get_post_views(); ?> <?php _e('views', 'bizmart-pro'); ?></span>
                                    </div>
                                </div>
                                
                            </header>
                            
                            <!-- Featured Image -->
                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-featured-image">
                                    <?php the_post_thumbnail('large', array('class' => 'img-responsive')); ?>
                                    <?php
                                    $caption = get_the_post_thumbnail_caption();
                                    if ($caption) {
                                        echo '<div class="image-caption">' . $caption . '</div>';
                                    }
                                    ?>
                                </div>
                            <?php endif; ?>
                            
                            <!-- Post Content -->
                            <div class="post-entry">
                                <?php
                                the_content();
                                
                                wp_link_pages(array(
                                    'before' => '<div class="page-links">' . __('Pages:', 'bizmart-pro'),
                                    'after'  => '</div>',
                                ));
                                ?>
                            </div>
                            
                            <!-- Post Footer -->
                            <footer class="post-footer">
                                
                                <!-- Tags -->
                                <?php
                                $tags = get_the_tags();
                                if ($tags) :
                                ?>
                                    <div class="post-tags">
                                        <h4><?php _e('Tags:', 'bizmart-pro'); ?></h4>
                                        <div class="tags-list">
                                            <?php
                                            foreach ($tags as $tag) {
                                                echo '<a href="' . get_tag_link($tag->term_id) . '" class="tag-link">' . $tag->name . '</a>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                
                                <!-- Social Share -->
                                <div class="post-share">
                                    <h4><?php _e('Share this post:', 'bizmart-pro'); ?></h4>
                                    <div class="share-buttons">
                                        <a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn facebook">
                                            <i class="fab fa-facebook-f"></i>
                                            <span><?php _e('Facebook', 'bizmart-pro'); ?></span>
                                        </a>
                                        <a href="https://twitter.com/intent/tweet?url=<?php echo urlencode(get_permalink()); ?>&text=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn twitter">
                                            <i class="fab fa-twitter"></i>
                                            <span><?php _e('Twitter', 'bizmart-pro'); ?></span>
                                        </a>
                                        <a href="https://pinterest.com/pin/create/button/?url=<?php echo urlencode(get_permalink()); ?>&description=<?php echo urlencode(get_the_title()); ?>" target="_blank" class="share-btn pinterest">
                                            <i class="fab fa-pinterest-p"></i>
                                            <span><?php _e('Pinterest', 'bizmart-pro'); ?></span>
                                        </a>
                                        <a href="https://www.linkedin.com/sharing/share-offsite/?url=<?php echo urlencode(get_permalink()); ?>" target="_blank" class="share-btn linkedin">
                                            <i class="fab fa-linkedin-in"></i>
                                            <span><?php _e('LinkedIn', 'bizmart-pro'); ?></span>
                                        </a>
                                    </div>
                                </div>
                                
                            </footer>
                            
                        </article>
                        
                        <!-- Author Bio -->
                        <div class="author-bio">
                            <div class="author-avatar">
                                <?php echo get_avatar(get_the_author_meta('ID'), 80); ?>
                            </div>
                            <div class="author-info">
                                <h3 class="author-name">
                                    <a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>">
                                        <?php the_author(); ?>
                                    </a>
                                </h3>
                                <p class="author-description">
                                    <?php echo get_the_author_meta('description') ?: __('This author has not provided a bio yet.', 'bizmart-pro'); ?>
                                </p>
                                <div class="author-social">
                                    <?php
                                    $social_links = array(
                                        'facebook' => get_the_author_meta('facebook'),
                                        'twitter' => get_the_author_meta('twitter'),
                                        'linkedin' => get_the_author_meta('linkedin'),
                                        'instagram' => get_the_author_meta('instagram'),
                                    );
                                    
                                    foreach ($social_links as $platform => $url) {
                                        if ($url) {
                                            echo '<a href="' . esc_url($url) . '" target="_blank" class="social-link ' . $platform . '">';
                                            echo '<i class="fab fa-' . $platform . '"></i>';
                                            echo '</a>';
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Related Posts -->
                        <div class="related-posts">
                            <h3><?php _e('Related Posts', 'bizmart-pro'); ?></h3>
                            <div class="related-posts-grid">
                                <?php
                                $related = get_posts(array(
                                    'category__in'   => wp_get_post_categories($post->ID),
                                    'numberposts'    => 3,
                                    'post__not_in'   => array($post->ID),
                                ));
                                
                                if ($related) {
                                    foreach ($related as $post) {
                                        setup_postdata($post);
                                        ?>
                                        <article class="related-post">
                                            <?php if (has_post_thumbnail()) : ?>
                                                <div class="post-thumbnail">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('medium'); ?>
                                                    </a>
                                                </div>
                                            <?php endif; ?>
                                            <div class="post-content">
                                                <div class="post-meta">
                                                    <span class="post-date"><?php echo get_the_date(); ?></span>
                                                </div>
                                                <h4 class="post-title">
                                                    <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
                                                </h4>
                                                <p class="post-excerpt"><?php echo wp_trim_words(get_the_excerpt(), 15); ?></p>
                                            </div>
                                        </article>
                                        <?php
                                    }
                                    wp_reset_postdata();
                                } else {
                                    echo '<p>' . __('No related posts found.', 'bizmart-pro') . '</p>';
                                }
                                ?>
                            </div>
                        </div>
                        
                        <!-- Post Navigation -->
                        <div class="post-navigation">
                            <div class="nav-links">
                                <?php
                                $prev_post = get_previous_post();
                                $next_post = get_next_post();
                                ?>
                                
                                <?php if ($prev_post) : ?>
                                    <div class="nav-previous">
                                        <a href="<?php echo get_permalink($prev_post->ID); ?>" class="nav-link">
                                            <div class="nav-direction">
                                                <i class="fas fa-arrow-left"></i>
                                                <span><?php _e('Previous Post', 'bizmart-pro'); ?></span>
                                            </div>
                                            <div class="nav-title"><?php echo get_the_title($prev_post->ID); ?></div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($next_post) : ?>
                                    <div class="nav-next">
                                        <a href="<?php echo get_permalink($next_post->ID); ?>" class="nav-link">
                                            <div class="nav-direction">
                                                <span><?php _e('Next Post', 'bizmart-pro'); ?></span>
                                                <i class="fas fa-arrow-right"></i>
                                            </div>
                                            <div class="nav-title"><?php echo get_the_title($next_post->ID); ?></div>
                                        </a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Comments -->
                        <?php
                        if (comments_open() || get_comments_number()) {
                            comments_template();
                        }
                        ?>
                        
                    <?php endwhile; ?>
                    
                </div>
            </div>
            
            <!-- Sidebar -->
            <div class="col-lg-4 col-md-4">
                <?php get_sidebar(); ?>
            </div>
            
        </div>
    </div>
</main>

<?php
// Helper functions
function bizmart_reading_time() {
    $content = get_post_field('post_content', get_the_ID());
    $word_count = str_word_count(strip_tags($content));
    $reading_time = ceil($word_count / 200); // Average reading speed: 200 words per minute
    return $reading_time;
}

function bizmart_get_post_views() {
    $views = get_post_meta(get_the_ID(), 'post_views_count', true);
    return $views ? $views : '0';
}

function bizmart_set_post_views() {
    $key = 'post_views_count';
    $post_id = get_the_ID();
    $count = (int) get_post_meta($post_id, $key, true);
    $count++;
    update_post_meta($post_id, $key, $count);
}

// Track post views
if (is_single()) {
    bizmart_set_post_views();
}
?>

<style>
/* Single Post Styles */
.single-post-page {
    padding: 40px 0;
}

.post-content-wrapper {
    margin-bottom: 40px;
}

.single-post {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

/* Post Header */
.post-header {
    padding: 30px 30px 0;
}

.post-categories {
    margin-bottom: 15px;
}

.category-link {
    display: inline-block;
    background: #007cba;
    color: #fff;
    padding: 5px 12px;
    border-radius: 4px;
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 500;
    margin-right: 8px;
    transition: background 0.3s ease;
}

.category-link:hover {
    background: #005a87;
    color: #fff;
}

.post-title {
    font-size: 2.5rem;
    font-weight: 700;
    line-height: 1.2;
    margin-bottom: 20px;
    color: #333;
}

.post-meta {
    display: flex;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 30px;
    padding-bottom: 20px;
    border-bottom: 1px solid #eee;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #666;
}

.meta-item.author {
    gap: 12px;
}

.meta-item.author img {
    border-radius: 50%;
}

.meta-item.author a {
    color: #007cba;
    text-decoration: none;
    font-weight: 500;
}

.meta-item.author a:hover {
    text-decoration: underline;
}

.meta-item i {
    color: #007cba;
}

/* Featured Image */
.post-featured-image {
    margin-bottom: 30px;
}

.post-featured-image img {
    width: 100%;
    height: auto;
    border-radius: 0;
}

.image-caption {
    background: #f8f9fa;
    padding: 15px 30px;
    font-size: 0.9rem;
    color: #666;
    font-style: italic;
    text-align: center;
}

/* Post Content */
.post-entry {
    padding: 0 30px 30px;
    font-size: 1.1rem;
    line-height: 1.8;
    color: #333;
}

.post-entry h1, .post-entry h2, .post-entry h3, 
.post-entry h4, .post-entry h5, .post-entry h6 {
    margin: 2rem 0 1rem;
    color: #333;
}

.post-entry p {
    margin-bottom: 1.5rem;
}

.post-entry blockquote {
    background: #f8f9fa;
    border-left: 4px solid #007cba;
    padding: 20px 30px;
    margin: 2rem 0;
    font-style: italic;
    font-size: 1.2rem;
}

.post-entry img {
    max-width: 100%;
    height: auto;
    border-radius: 8px;
    margin: 1.5rem 0;
}

.page-links {
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid #eee;
}

.page-links a {
    display: inline-block;
    padding: 8px 16px;
    margin: 0 5px;
    background: #007cba;
    color: #fff;
    text-decoration: none;
    border-radius: 4px;
    transition: background 0.3s ease;
}

.page-links a:hover {
    background: #005a87;
}

/* Post Footer */
.post-footer {
    padding: 30px;
    background: #f8f9fa;
    border-top: 1px solid #eee;
}

.post-tags {
    margin-bottom: 30px;
}

.post-tags h4 {
    margin-bottom: 15px;
    font-size: 1.1rem;
    color: #333;
}

.tags-list {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.tag-link {
    display: inline-block;
    background: #e9ecef;
    color: #333;
    padding: 6px 12px;
    border-radius: 20px;
    text-decoration: none;
    font-size: 0.85rem;
    transition: all 0.3s ease;
}

.tag-link:hover {
    background: #007cba;
    color: #fff;
    transform: translateY(-2px);
}

.post-share h4 {
    margin-bottom: 15px;
    font-size: 1.1rem;
    color: #333;
}

.share-buttons {
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}

.share-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 15px;
    border-radius: 6px;
    text-decoration: none;
    color: #fff;
    font-size: 0.9rem;
    transition: all 0.3s ease;
}

.share-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
}

.share-btn.facebook { background: #3b5998; }
.share-btn.twitter { background: #1da1f2; }
.share-btn.pinterest { background: #bd081c; }
.share-btn.linkedin { background: #0077b5; }

/* Author Bio */
.author-bio {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    margin-bottom: 40px;
    display: flex;
    gap: 20px;
    align-items: flex-start;
}

.author-avatar img {
    border-radius: 50%;
    border: 3px solid #e9ecef;
}

.author-info {
    flex: 1;
}

.author-name {
    margin-bottom: 10px;
    font-size: 1.3rem;
}

.author-name a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.author-name a:hover {
    color: #007cba;
}

.author-description {
    margin-bottom: 15px;
    color: #666;
    line-height: 1.6;
}

.author-social {
    display: flex;
    gap: 10px;
}

.author-social .social-link {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 35px;
    height: 35px;
    border-radius: 50%;
    color: #fff;
    text-decoration: none;
    transition: all 0.3s ease;
}

.author-social .social-link:hover {
    transform: translateY(-2px);
}

.author-social .social-link.facebook { background: #3b5998; }
.author-social .social-link.twitter { background: #1da1f2; }
.author-social .social-link.linkedin { background: #0077b5; }
.author-social .social-link.instagram { background: #e4405f; }

/* Related Posts */
.related-posts {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    margin-bottom: 40px;
}

.related-posts h3 {
    margin-bottom: 25px;
    font-size: 1.5rem;
    color: #333;
}

.related-posts-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 25px;
}

.related-post {
    border-radius: 8px;
    overflow: hidden;
    transition: transform 0.3s ease;
}

.related-post:hover {
    transform: translateY(-5px);
}

.related-post .post-thumbnail {
    height: 200px;
    overflow: hidden;
}

.related-post .post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.related-post:hover .post-thumbnail img {
    transform: scale(1.05);
}

.related-post .post-content {
    padding: 20px;
    background: #f8f9fa;
}

.related-post .post-meta {
    margin-bottom: 10px;
    border: none;
    padding: 0;
}

.related-post .post-date {
    font-size: 0.85rem;
    color: #666;
}

.related-post .post-title {
    margin-bottom: 10px;
    font-size: 1.1rem;
    line-height: 1.3;
}

.related-post .post-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.related-post .post-title a:hover {
    color: #007cba;
}

.related-post .post-excerpt {
    color: #666;
    font-size: 0.95rem;
    margin: 0;
}

/* Post Navigation */
.post-navigation {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    margin-bottom: 40px;
    overflow: hidden;
}

.nav-links {
    display: grid;
    grid-template-columns: 1fr 1fr;
}

.nav-previous,
.nav-next {
    display: flex;
}

.nav-link {
    display: flex;
    flex-direction: column;
    padding: 25px;
    color: #333;
    text-decoration: none;
    transition: background 0.3s ease;
    flex: 1;
}

.nav-link:hover {
    background: #f8f9fa;
    color: #333;
}

.nav-direction {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 0.9rem;
    color: #666;
    margin-bottom: 8px;
}

.nav-next .nav-direction {
    justify-content: flex-end;
}

.nav-title {
    font-weight: 600;
    line-height: 1.3;
}

.nav-next .nav-title {
    text-align: right;
}

/* Responsive Design */
@media (max-width: 768px) {
    .post-title {
        font-size: 2rem;
    }
    
    .post-meta {
        flex-direction: column;
        align-items: flex-start;
        gap: 10px;
    }
    
    .post-header,
    .post-entry,
    .post-footer {
        padding: 20px;
    }
    
    .image-caption {
        padding: 15px 20px;
    }
    
    .author-bio {
        flex-direction: column;
        text-align: center;
    }
    
    .related-posts-grid {
        grid-template-columns: 1fr;
    }
    
    .nav-links {
        grid-template-columns: 1fr;
    }
    
    .nav-next .nav-direction,
    .nav-next .nav-title {
        text-align: left;
        justify-content: flex-start;
    }
    
    .share-buttons {
        justify-content: center;
    }
}
</style>

<?php get_footer(); ?>