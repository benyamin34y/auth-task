<?php
/**
 * WooCommerce template
 *
 * @package BizMart Pro
 * @version 1.0.0
 */

get_header('shop'); ?>

<main id="primary" class="site-main woocommerce-page">
    <div class="container">
        
        <?php if (is_shop() || is_product_category() || is_product_tag()) : ?>
            
            <!-- Shop Header -->
            <div class="shop-header">
                <div class="row align-center">
                    <div class="col-md-6">
                        <div class="shop-title">
                            <?php if (is_shop()) : ?>
                                <h1><?php woocommerce_page_title(); ?></h1>
                                <p><?php _e('Browse our amazing collection of products', 'bizmart-pro'); ?></p>
                            <?php elseif (is_product_category()) : ?>
                                <?php
                                $current_cat = get_queried_object();
                                ?>
                                <h1><?php echo $current_cat->name; ?></h1>
                                <?php if ($current_cat->description) : ?>
                                    <p><?php echo $current_cat->description; ?></p>
                                <?php endif; ?>
                            <?php elseif (is_product_tag()) : ?>
                                <?php
                                $current_tag = get_queried_object();
                                ?>
                                <h1><?php printf(__('Products tagged "%s"', 'bizmart-pro'), $current_tag->name); ?></h1>
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="shop-controls">
                            <!-- View Toggle -->
                            <div class="view-toggle">
                                <button class="view-btn grid-view active" data-view="grid">
                                    <i class="fas fa-th"></i>
                                </button>
                                <button class="view-btn list-view" data-view="list">
                                    <i class="fas fa-list"></i>
                                </button>
                            </div>
                            
                            <!-- Results Count -->
                            <div class="results-count">
                                <?php woocommerce_result_count(); ?>
                            </div>
                            
                            <!-- Ordering -->
                            <div class="shop-ordering">
                                <?php woocommerce_catalog_ordering(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Shop Content -->
            <div class="shop-content">
                <div class="row">
                    
                    <!-- Sidebar -->
                    <div class="col-lg-3 col-md-4">
                        <aside class="shop-sidebar">
                            
                            <!-- Product Categories -->
                            <div class="widget widget-categories">
                                <h3 class="widget-title"><?php _e('Categories', 'bizmart-pro'); ?></h3>
                                <?php
                                wp_list_categories(array(
                                    'taxonomy'     => 'product_cat',
                                    'hide_empty'   => true,
                                    'hierarchical' => true,
                                    'title_li'     => '',
                                    'walker'       => new Bizmart_Category_Walker(),
                                ));
                                ?>
                            </div>
                            
                            <!-- Price Filter -->
                            <div class="widget widget-price-filter">
                                <h3 class="widget-title"><?php _e('Filter by Price', 'bizmart-pro'); ?></h3>
                                <div class="price-filter-wrapper">
                                    <div id="price-range"></div>
                                    <div class="price-inputs">
                                        <input type="number" id="price-min" name="price-min" value="0" min="0">
                                        <span>-</span>
                                        <input type="number" id="price-max" name="price-max" value="1000" max="1000">
                                    </div>
                                    <div class="price-display" id="price-display">$0 - $1000</div>
                                    <button class="btn btn-primary filter-price-btn"><?php _e('Filter', 'bizmart-pro'); ?></button>
                                </div>
                            </div>
                            
                            <!-- Product Attributes -->
                            <?php
                            $attributes = wc_get_attribute_taxonomies();
                            foreach ($attributes as $attribute) :
                                $attribute_name = wc_attribute_taxonomy_name($attribute->attribute_name);
                                $terms = get_terms($attribute_name, array('hide_empty' => true));
                                
                                if ($terms && !is_wp_error($terms)) :
                                ?>
                                <div class="widget widget-attribute">
                                    <h3 class="widget-title"><?php echo esc_html($attribute->attribute_label); ?></h3>
                                    <ul class="attribute-list">
                                        <?php foreach ($terms as $term) : ?>
                                            <li>
                                                <label>
                                                    <input type="checkbox" name="<?php echo esc_attr($attribute_name); ?>[]" value="<?php echo esc_attr($term->slug); ?>">
                                                    <span><?php echo esc_html($term->name); ?></span>
                                                    <small>(<?php echo $term->count; ?>)</small>
                                                </label>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                <?php
                                endif;
                            endforeach;
                            ?>
                            
                            <!-- Featured Products -->
                            <div class="widget widget-featured-products">
                                <h3 class="widget-title"><?php _e('Featured Products', 'bizmart-pro'); ?></h3>
                                <?php
                                $featured_products = wc_get_featured_product_ids();
                                if ($featured_products) :
                                    $args = array(
                                        'post_type' => 'product',
                                        'posts_per_page' => 3,
                                        'post__in' => $featured_products,
                                        'orderby' => 'rand',
                                    );
                                    $featured_query = new WP_Query($args);
                                    
                                    if ($featured_query->have_posts()) :
                                        echo '<div class="featured-products-list">';
                                        while ($featured_query->have_posts()) :
                                            $featured_query->the_post();
                                            global $product;
                                            ?>
                                            <div class="featured-product-item">
                                                <div class="product-thumb">
                                                    <a href="<?php the_permalink(); ?>">
                                                        <?php the_post_thumbnail('thumbnail'); ?>
                                                    </a>
                                                </div>
                                                <div class="product-info">
                                                    <h4><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h4>
                                                    <div class="price"><?php echo $product->get_price_html(); ?></div>
                                                </div>
                                            </div>
                                            <?php
                                        endwhile;
                                        echo '</div>';
                                        wp_reset_postdata();
                                    endif;
                                endif;
                                ?>
                            </div>
                            
                            <!-- Clear Filters -->
                            <div class="widget widget-clear-filters">
                                <button class="btn btn-outline clear-filters-btn">
                                    <i class="fas fa-times"></i>
                                    <?php _e('Clear All Filters', 'bizmart-pro'); ?>
                                </button>
                            </div>
                            
                        </aside>
                    </div>
                    
                    <!-- Products -->
                    <div class="col-lg-9 col-md-8">
                        <div class="products-wrapper">
                            
                            <!-- Active Filters -->
                            <div class="active-filters">
                                <!-- This will be populated by JavaScript -->
                            </div>
                            
                            <!-- Products -->
                            <div class="products-container">
                                <?php
                                if (woocommerce_product_loop()) {
                                    woocommerce_product_loop_start();

                                    if (wc_get_loop_prop('is_paginated')) {
                                        do_action('woocommerce_pagination_top');
                                    }

                                    while (have_posts()) {
                                        the_post();
                                        wc_get_template_part('content', 'product');
                                    }

                                    woocommerce_product_loop_end();

                                    if (wc_get_loop_prop('is_paginated')) {
                                        do_action('woocommerce_pagination');
                                    }
                                } else {
                                    do_action('woocommerce_no_products_found');
                                }
                                ?>
                            </div>
                            
                        </div>
                    </div>
                    
                </div>
            </div>
            
        <?php else : ?>
            
            <!-- Default WooCommerce Content -->
            <div class="woocommerce-content">
                <?php woocommerce_content(); ?>
            </div>
            
        <?php endif; ?>
        
    </div>
</main>

<?php
// Custom Category Walker
class Bizmart_Category_Walker extends Walker_Category {
    public function start_el(&$output, $category, $depth = 0, $args = array(), $id = 0) {
        $cat_name = apply_filters('list_cats', esc_attr($category->name), $category);
        $cat_count = $category->count;
        
        $link = '<a href="' . esc_url(get_term_link($category)) . '">';
        $link .= $cat_name;
        $link .= ' <span class="count">(' . $cat_count . ')</span>';
        $link .= '</a>';
        
        $css_classes = array('cat-item', 'cat-item-' . $category->term_id);
        
        if (isset($args['current_category']) && $args['current_category'] == $category->term_id) {
            $css_classes[] = 'current-cat';
        }
        
        $css_class = implode(' ', $css_classes);
        
        $output .= '<li class="' . $css_class . '">' . $link;
    }
}
?>

<style>
/* Shop Page Styles */
.woocommerce-page {
    padding: 40px 0;
}

.shop-header {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}

.shop-title h1 {
    margin-bottom: 10px;
    font-size: 2.5rem;
    font-weight: 700;
}

.shop-title p {
    color: #666;
    font-size: 1.1rem;
    margin: 0;
}

.shop-controls {
    display: flex;
    align-items: center;
    justify-content: flex-end;
    gap: 20px;
    flex-wrap: wrap;
}

.view-toggle {
    display: flex;
    border: 1px solid #ddd;
    border-radius: 6px;
    overflow: hidden;
}

.view-btn {
    background: #fff;
    border: none;
    padding: 10px 15px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.view-btn.active {
    background: #007cba;
    color: #fff;
}

.view-btn:hover {
    background: #f8f9fa;
}

.view-btn.active:hover {
    background: #005a87;
}

.results-count {
    font-size: 0.9rem;
    color: #666;
}

.shop-ordering select {
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    background: #fff;
}

/* Sidebar */
.shop-sidebar {
    background: #f8f9fa;
    padding: 30px 25px;
    border-radius: 8px;
    margin-bottom: 30px;
}

.shop-sidebar .widget {
    margin-bottom: 40px;
    padding-bottom: 30px;
    border-bottom: 1px solid #eee;
}

.shop-sidebar .widget:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}

.widget-title {
    margin-bottom: 20px;
    font-size: 1.2rem;
    font-weight: 600;
    color: #333;
}

/* Categories Widget */
.widget-categories ul {
    list-style: none;
    margin: 0;
    padding: 0;
}

.widget-categories li {
    margin-bottom: 8px;
}

.widget-categories a {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 8px 0;
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.widget-categories a:hover {
    color: #007cba;
}

.widget-categories .current-cat > a {
    color: #007cba;
    font-weight: 600;
}

.widget-categories .count {
    color: #999;
    font-size: 0.9rem;
}

/* Price Filter */
.price-filter-wrapper {
    padding: 15px 0;
}

#price-range {
    margin-bottom: 20px;
    height: 8px;
    background: #ddd;
    border-radius: 4px;
}

.price-inputs {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
}

.price-inputs input {
    flex: 1;
    padding: 8px 12px;
    border: 1px solid #ddd;
    border-radius: 4px;
    text-align: center;
}

.price-display {
    text-align: center;
    font-weight: 600;
    margin-bottom: 15px;
    color: #007cba;
}

.filter-price-btn {
    width: 100%;
    padding: 10px;
}

/* Attribute Filters */
.attribute-list {
    list-style: none;
    margin: 0;
    padding: 0;
}

.attribute-list li {
    margin-bottom: 10px;
}

.attribute-list label {
    display: flex;
    align-items: center;
    gap: 8px;
    cursor: pointer;
    transition: color 0.3s ease;
}

.attribute-list label:hover {
    color: #007cba;
}

.attribute-list input[type="checkbox"] {
    margin: 0;
}

.attribute-list small {
    color: #999;
    margin-left: auto;
}

/* Featured Products Widget */
.featured-products-list {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.featured-product-item {
    display: flex;
    gap: 15px;
    align-items: center;
}

.featured-product-item .product-thumb {
    width: 60px;
    height: 60px;
    overflow: hidden;
    border-radius: 6px;
    flex-shrink: 0;
}

.featured-product-item .product-thumb img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.featured-product-item .product-info h4 {
    margin: 0 0 5px 0;
    font-size: 0.9rem;
    line-height: 1.3;
}

.featured-product-item .product-info h4 a {
    color: #333;
    text-decoration: none;
    transition: color 0.3s ease;
}

.featured-product-item .product-info h4 a:hover {
    color: #007cba;
}

.featured-product-item .price {
    font-size: 0.9rem;
    font-weight: 600;
    color: #007cba;
}

/* Clear Filters */
.clear-filters-btn {
    width: 100%;
    padding: 12px;
}

/* Products Container */
.products-wrapper {
    position: relative;
}

.active-filters {
    margin-bottom: 20px;
    min-height: 20px;
}

.active-filter-tag {
    display: inline-flex;
    align-items: center;
    gap: 5px;
    background: #007cba;
    color: #fff;
    padding: 5px 10px;
    border-radius: 4px;
    font-size: 0.8rem;
    margin-right: 10px;
    margin-bottom: 10px;
}

.active-filter-tag .remove {
    cursor: pointer;
    margin-left: 5px;
}

/* Products Grid/List Toggle */
.products.list-view .product {
    display: flex;
    align-items: center;
    gap: 20px;
    margin-bottom: 20px;
    padding: 20px;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
}

.products.list-view .product .product-image {
    width: 200px;
    flex-shrink: 0;
}

.products.list-view .product .product-info {
    flex: 1;
}

/* Loading State */
.products-container.loading {
    position: relative;
    opacity: 0.6;
    pointer-events: none;
}

.products-container.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 40px;
    height: 40px;
    margin: -20px 0 0 -20px;
    border: 4px solid #f3f3f3;
    border-top: 4px solid #007cba;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

/* Responsive Design */
@media (max-width: 768px) {
    .shop-controls {
        justify-content: center;
        margin-top: 20px;
    }
    
    .shop-sidebar {
        margin-bottom: 40px;
    }
    
    .products.list-view .product {
        flex-direction: column;
        text-align: center;
    }
    
    .products.list-view .product .product-image {
        width: 100%;
    }
}
</style>

<script>
jQuery(document).ready(function($) {
    // View toggle functionality
    $('.view-btn').on('click', function() {
        var view = $(this).data('view');
        
        $('.view-btn').removeClass('active');
        $(this).addClass('active');
        
        if (view === 'list') {
            $('.products').addClass('list-view');
        } else {
            $('.products').removeClass('list-view');
        }
        
        // Save preference
        localStorage.setItem('shop_view', view);
    });
    
    // Load saved view preference
    var savedView = localStorage.getItem('shop_view');
    if (savedView === 'list') {
        $('.view-btn[data-view="list"]').trigger('click');
    }
    
    // Clear filters
    $('.clear-filters-btn').on('click', function() {
        $('input[type="checkbox"]').prop('checked', false);
        $('#price-min').val(0);
        $('#price-max').val(1000);
        $('#price-display').text('$0 - $1000');
        
        // Reset URL
        window.location.href = window.location.pathname;
    });
    
    // Filter functionality
    $('.attribute-list input[type="checkbox"]').on('change', function() {
        updateFilters();
    });
    
    $('.filter-price-btn').on('click', function() {
        updateFilters();
    });
    
    function updateFilters() {
        var filters = {};
        var activeFilters = [];
        
        // Collect attribute filters
        $('.attribute-list input[type="checkbox"]:checked').each(function() {
            var name = $(this).attr('name');
            var value = $(this).val();
            
            if (!filters[name]) {
                filters[name] = [];
            }
            filters[name].push(value);
            
            activeFilters.push({
                type: 'attribute',
                name: name,
                value: value,
                label: $(this).next('span').text()
            });
        });
        
        // Collect price filter
        var minPrice = $('#price-min').val();
        var maxPrice = $('#price-max').val();
        
        if (minPrice > 0 || maxPrice < 1000) {
            filters.price = minPrice + '-' + maxPrice;
            activeFilters.push({
                type: 'price',
                value: filters.price,
                label: '$' + minPrice + ' - $' + maxPrice
            });
        }
        
        // Show active filters
        displayActiveFilters(activeFilters);
        
        // Apply filters via AJAX
        applyFilters(filters);
    }
    
    function displayActiveFilters(filters) {
        var html = '';
        
        filters.forEach(function(filter) {
            html += '<span class="active-filter-tag">';
            html += filter.label;
            html += '<span class="remove" data-type="' + filter.type + '" data-value="' + filter.value + '">&times;</span>';
            html += '</span>';
        });
        
        $('.active-filters').html(html);
    }
    
    function applyFilters(filters) {
        $('.products-container').addClass('loading');
        
        // Build query string
        var queryString = $.param(filters);
        
        $.get(window.location.pathname + '?' + queryString, function(data) {
            var $newProducts = $(data).find('.products');
            $('.products').html($newProducts.html());
            
            // Update URL
            history.pushState(null, '', '?' + queryString);
        }).always(function() {
            $('.products-container').removeClass('loading');
        });
    }
    
    // Remove active filter
    $(document).on('click', '.active-filter-tag .remove', function() {
        var type = $(this).data('type');
        var value = $(this).data('value');
        
        if (type === 'price') {
            $('#price-min').val(0);
            $('#price-max').val(1000);
            $('#price-display').text('$0 - $1000');
        } else {
            $('input[value="' + value + '"]').prop('checked', false);
        }
        
        updateFilters();
    });
});
</script>

<?php
get_footer('shop');
?>