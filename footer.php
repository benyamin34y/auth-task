    <!-- Site Footer -->
    <footer id="colophon" class="site-footer">
        <div class="footer-main">
            <div class="container">
                <div class="footer-widgets">
                    <!-- Footer Widget 1 -->
                    <div class="footer-widget-area">
                        <?php if (is_active_sidebar('footer-1')) : ?>
                            <?php dynamic_sidebar('footer-1'); ?>
                        <?php else : ?>
                            <div class="widget">
                                <h3 class="widget-title"><?php _e('About Us', 'bizmart-pro'); ?></h3>
                                <p><?php _e('We are a leading e-commerce platform providing high-quality products and exceptional customer service. Your satisfaction is our priority.', 'bizmart-pro'); ?></p>
                                <div class="footer-social">
                                    <a href="#" aria-label="<?php _e('Facebook', 'bizmart-pro'); ?>">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a href="#" aria-label="<?php _e('Twitter', 'bizmart-pro'); ?>">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a href="#" aria-label="<?php _e('Instagram', 'bizmart-pro'); ?>">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                    <a href="#" aria-label="<?php _e('LinkedIn', 'bizmart-pro'); ?>">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Widget 2 -->
                    <div class="footer-widget-area">
                        <?php if (is_active_sidebar('footer-2')) : ?>
                            <?php dynamic_sidebar('footer-2'); ?>
                        <?php else : ?>
                            <div class="widget">
                                <h3 class="widget-title"><?php _e('Quick Links', 'bizmart-pro'); ?></h3>
                                <ul>
                                    <li><a href="<?php echo esc_url(home_url('/')); ?>"><?php _e('Home', 'bizmart-pro'); ?></a></li>
                                    <?php if (class_exists('WooCommerce')) : ?>
                                        <li><a href="<?php echo get_permalink(wc_get_page_id('shop')); ?>"><?php _e('Shop', 'bizmart-pro'); ?></a></li>
                                        <li><a href="<?php echo get_permalink(wc_get_page_id('cart')); ?>"><?php _e('Cart', 'bizmart-pro'); ?></a></li>
                                        <li><a href="<?php echo get_permalink(wc_get_page_id('checkout')); ?>"><?php _e('Checkout', 'bizmart-pro'); ?></a></li>
                                        <li><a href="<?php echo get_permalink(wc_get_page_id('myaccount')); ?>"><?php _e('My Account', 'bizmart-pro'); ?></a></li>
                                    <?php endif; ?>
                                    <li><a href="<?php echo get_permalink(get_option('page_for_posts')); ?>"><?php _e('Blog', 'bizmart-pro'); ?></a></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Widget 3 -->
                    <div class="footer-widget-area">
                        <?php if (is_active_sidebar('footer-3')) : ?>
                            <?php dynamic_sidebar('footer-3'); ?>
                        <?php else : ?>
                            <div class="widget">
                                <h3 class="widget-title"><?php _e('Customer Service', 'bizmart-pro'); ?></h3>
                                <ul>
                                    <li><a href="#"><?php _e('Contact Us', 'bizmart-pro'); ?></a></li>
                                    <li><a href="#"><?php _e('FAQ', 'bizmart-pro'); ?></a></li>
                                    <li><a href="#"><?php _e('Shipping Info', 'bizmart-pro'); ?></a></li>
                                    <li><a href="#"><?php _e('Returns', 'bizmart-pro'); ?></a></li>
                                    <li><a href="#"><?php _e('Size Guide', 'bizmart-pro'); ?></a></li>
                                    <li><a href="#"><?php _e('Track Your Order', 'bizmart-pro'); ?></a></li>
                                </ul>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Footer Widget 4 -->
                    <div class="footer-widget-area">
                        <?php if (is_active_sidebar('footer-4')) : ?>
                            <?php dynamic_sidebar('footer-4'); ?>
                        <?php else : ?>
                            <div class="widget">
                                <h3 class="widget-title"><?php _e('Contact Info', 'bizmart-pro'); ?></h3>
                                <div class="contact-info">
                                    <div class="contact-item">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <div class="contact-details">
                                            <strong><?php _e('Address', 'bizmart-pro'); ?></strong>
                                            <p><?php echo get_theme_mod('footer_address', '123 Business St, City, State 12345'); ?></p>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-phone"></i>
                                        <div class="contact-details">
                                            <strong><?php _e('Phone', 'bizmart-pro'); ?></strong>
                                            <p><?php echo get_theme_mod('footer_phone', '+1 (555) 123-4567'); ?></p>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-envelope"></i>
                                        <div class="contact-details">
                                            <strong><?php _e('Email', 'bizmart-pro'); ?></strong>
                                            <p><?php echo get_theme_mod('footer_email', 'info@bizmart.com'); ?></p>
                                        </div>
                                    </div>
                                    <div class="contact-item">
                                        <i class="fas fa-clock"></i>
                                        <div class="contact-details">
                                            <strong><?php _e('Business Hours', 'bizmart-pro'); ?></strong>
                                            <p><?php echo get_theme_mod('footer_hours', 'Mon - Fri: 9:00 AM - 6:00 PM'); ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <div class="container">
                <div class="footer-bottom-content d-flex justify-between align-center">
                    <div class="footer-copyright">
                        <p>&copy; <?php echo date('Y'); ?> 
                            <a href="<?php echo esc_url(home_url('/')); ?>">
                                <?php bloginfo('name'); ?>
                            </a>. 
                            <?php _e('All rights reserved.', 'bizmart-pro'); ?>
                        </p>
                    </div>
                    
                    <div class="footer-links">
                        <?php if (has_nav_menu('footer')) : ?>
                            <?php
                            wp_nav_menu(array(
                                'theme_location' => 'footer',
                                'container'      => false,
                                'menu_class'     => 'footer-menu',
                                'depth'          => 1,
                            ));
                            ?>
                        <?php else : ?>
                            <ul class="footer-menu">
                                <li><a href="#"><?php _e('Privacy Policy', 'bizmart-pro'); ?></a></li>
                                <li><a href="#"><?php _e('Terms of Service', 'bizmart-pro'); ?></a></li>
                                <li><a href="#"><?php _e('Cookie Policy', 'bizmart-pro'); ?></a></li>
                            </ul>
                        <?php endif; ?>
                    </div>
                    
                    <div class="payment-methods">
                        <span class="payment-text"><?php _e('We Accept:', 'bizmart-pro'); ?></span>
                        <div class="payment-icons">
                            <i class="fab fa-cc-visa" title="Visa"></i>
                            <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                            <i class="fab fa-cc-paypal" title="PayPal"></i>
                            <i class="fab fa-cc-apple-pay" title="Apple Pay"></i>
                            <i class="fab fa-google-pay" title="Google Pay"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back to Top Button -->
        <button id="back-to-top" class="back-to-top" aria-label="<?php _e('Back to top', 'bizmart-pro'); ?>">
            <i class="fas fa-chevron-up"></i>
        </button>
    </footer>

</div><!-- #page -->

<?php wp_footer(); ?>

<!-- Additional CSS for Footer Components -->
<style>
/* Category Cards */
.categories-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 20px;
    margin: 40px 0;
}

.category-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    text-align: center;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}

.category-image {
    height: 150px;
    overflow: hidden;
    position: relative;
}

.category-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.category-card:hover .category-image img {
    transform: scale(1.1);
}

.category-placeholder {
    width: 100%;
    height: 100%;
    background: #f8f9fa;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #dee2e6;
}

.category-info {
    padding: 20px;
}

.category-info h3 {
    margin-bottom: 8px;
    font-size: 1.1rem;
    color: #333;
}

.product-count {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Special Offers */
.offers-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin: 40px 0;
}

.offer-card {
    padding: 40px;
    border-radius: 12px;
    text-align: center;
    color: #fff;
    position: relative;
    overflow: hidden;
}

.offer-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.offer-secondary {
    background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
}

.offer-content h3 {
    font-size: 2rem;
    margin-bottom: 1rem;
}

.offer-content p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

/* Testimonials */
.testimonials-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 30px;
    margin: 40px 0;
}

.testimonial-card {
    background: #fff;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.testimonial-card:hover {
    transform: translateY(-5px);
}

.testimonial-rating {
    margin-bottom: 15px;
}

.testimonial-rating i {
    color: #ffc107;
    margin-right: 2px;
}

.testimonial-content p {
    font-style: italic;
    margin-bottom: 20px;
    line-height: 1.6;
}

.testimonial-author {
    display: flex;
    align-items: center;
    gap: 15px;
}

.author-avatar {
    width: 50px;
    height: 50px;
    border-radius: 50%;
    overflow: hidden;
}

.author-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.author-info h4 {
    margin-bottom: 5px;
    font-size: 1rem;
}

.author-info span {
    color: #6c757d;
    font-size: 0.9rem;
}

/* Newsletter */
.newsletter {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: #fff;
}

.newsletter-content h2 {
    font-size: 2.5rem;
    margin-bottom: 1rem;
}

.newsletter-content p {
    font-size: 1.1rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.newsletter-form .form-group {
    display: flex;
    max-width: 500px;
    margin: 0 auto;
    gap: 10px;
}

.newsletter-form input {
    flex: 1;
    padding: 15px 20px;
    border: none;
    border-radius: 6px;
    font-size: 1rem;
}

.newsletter-form button {
    padding: 15px 30px;
    white-space: nowrap;
}

/* Footer Styles */
.footer-social {
    margin-top: 20px;
}

.footer-social a {
    display: inline-block;
    width: 40px;
    height: 40px;
    background: #34495e;
    color: #fff;
    text-align: center;
    line-height: 40px;
    border-radius: 50%;
    margin-right: 10px;
    transition: all 0.3s ease;
}

.footer-social a:hover {
    background: #007cba;
    transform: translateY(-2px);
}

.contact-info .contact-item {
    display: flex;
    align-items: flex-start;
    margin-bottom: 20px;
    gap: 15px;
}

.contact-item i {
    font-size: 1.2rem;
    color: #007cba;
    margin-top: 5px;
    min-width: 20px;
}

.contact-details strong {
    display: block;
    margin-bottom: 5px;
    color: #fff;
}

.contact-details p {
    margin: 0;
    color: #bdc3c7;
    line-height: 1.4;
}

.footer-bottom-content {
    flex-wrap: wrap;
    gap: 20px;
}

.footer-menu {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 20px;
}

.footer-menu a {
    color: #95a5a6;
    text-decoration: none;
    transition: color 0.3s ease;
}

.footer-menu a:hover {
    color: #fff;
}

.payment-methods {
    display: flex;
    align-items: center;
    gap: 15px;
}

.payment-text {
    color: #95a5a6;
    font-size: 0.9rem;
}

.payment-icons {
    display: flex;
    gap: 8px;
}

.payment-icons i {
    font-size: 1.5rem;
    color: #95a5a6;
    transition: color 0.3s ease;
}

.payment-icons i:hover {
    color: #fff;
}

.back-to-top {
    position: fixed;
    bottom: 30px;
    right: 30px;
    width: 50px;
    height: 50px;
    background: #007cba;
    color: #fff;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    opacity: 0;
    visibility: hidden;
    transition: all 0.3s ease;
    z-index: 1000;
}

.back-to-top.show {
    opacity: 1;
    visibility: visible;
}

.back-to-top:hover {
    background: #005a87;
    transform: translateY(-2px);
}

/* Blog Posts */
.posts-grid {
    display: grid;
    gap: 30px;
}

.post-card {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
}

.post-card:hover {
    transform: translateY(-3px);
}

.post-thumbnail {
    height: 250px;
    overflow: hidden;
}

.post-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.post-card:hover .post-thumbnail img {
    transform: scale(1.05);
}

.post-content {
    padding: 25px;
}

.post-meta {
    margin-bottom: 15px;
}

.post-meta span {
    color: #6c757d;
    font-size: 0.9rem;
    margin-right: 15px;
}

.post-title {
    margin-bottom: 15px;
}

.post-title a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.post-title a:hover {
    color: #007cba;
}

.post-excerpt {
    margin-bottom: 20px;
    color: #666;
    line-height: 1.6;
}

.read-more {
    color: #007cba;
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.read-more:hover {
    color: #005a87;
}

/* Responsive Design */
@media (max-width: 768px) {
    .footer-bottom-content {
        flex-direction: column;
        text-align: center;
    }
    
    .footer-menu {
        justify-content: center;
    }
    
    .payment-methods {
        justify-content: center;
    }
    
    .newsletter-form .form-group {
        flex-direction: column;
    }
    
    .offers-grid {
        grid-template-columns: 1fr;
    }
    
    .offer-card {
        padding: 30px 20px;
    }
    
    .offer-content h3 {
        font-size: 1.5rem;
    }
}
</style>

<script>
// Back to top functionality
jQuery(document).ready(function($) {
    var backToTop = $('#back-to-top');
    
    $(window).scroll(function() {
        if ($(this).scrollTop() > 300) {
            backToTop.addClass('show');
        } else {
            backToTop.removeClass('show');
        }
    });
    
    backToTop.click(function() {
        $('html, body').animate({scrollTop: 0}, 500);
        return false;
    });
});
</script>

</body>
</html>