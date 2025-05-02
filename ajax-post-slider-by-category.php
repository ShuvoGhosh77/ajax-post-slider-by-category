<?php 

// Shortcode load all post by category function
function cps_blog_post_shortcode() {
    ob_start();

    // Get all post categories except Uncategorized
    $categories = get_terms(array(
        'taxonomy' => 'category',
        'hide_empty' => false,
        'exclude' => array(get_cat_ID('Uncategorized'))
    ));

    if (!empty($categories) && !is_wp_error($categories)) {
        $first_category = $categories[0]; // First category
        ?>

        <div id="ecom-blog-container">
            <!-- Categories -->
            <div class="ecom-blog-categories-container">
                <div id="ecom-blog-categories">
                    <ul>
                        <?php 
                        $first = true;
                        foreach ($categories as $category): ?>
                            <li>
                                <a href="#" class="category-btn <?php echo $first ? 'active' : ''; ?>" 
                                   data-id="<?php echo esc_attr($category->term_id); ?>">
                                    <?php echo esc_html($category->name); ?>
                                </a>
                            </li>
                        <?php 
                        $first = false;
                        endforeach; ?>
                    </ul>
					 <div  class="ecom-blog-seee-all-btn">
                        <a href="/blog">SEE ALL</a>
                        
                    </div>
                  
                </div>
            </div>

            <!-- Posts will load here -->
            <div id="ecom-blog-posts"></div>
        </div>

        <!-- Pass first category ID to JS -->
        <script>
            var defaultCategory = "<?php echo esc_js($first_category->term_id); ?>";
        </script>

        <?php
    } else {
        echo '<p>No categories found.</p>';
    }

    return ob_get_clean();
}
add_shortcode('cps_blog_posts', 'cps_blog_post_shortcode');

// AJAX handler
function load_blog_posts_ajax() {
    $category = isset($_POST['category']) ? sanitize_text_field($_POST['category']) : '';

    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => -1,
    );

    if (!empty($category)) {
        $args['cat'] = intval($category);
    }

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        echo '<div class="ecom-blog-slider slick-slider" >'; 

        while ($query->have_posts()) {
            $query->the_post();
            ?>

            <div class="ecom-blog-slider-item">
                <?php if (has_post_thumbnail()): ?>
                    <div class="ecom-blog-thumbnail">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('full'); ?>
                        </a>
                    </div>
                <?php endif; ?>
                <div class="titel-catagory-container">
                    <div class="ecom-blog-categories">
                       <div class="ecom-blog-categories-name">
                            <?php
                            $categories = get_the_category();
                            if (!empty($categories)) {
                               
                                foreach ($categories as $category) {
                                    echo '<div class="category-item">' . esc_html($category->name) . '</div>';
                                }
                               
                            }
                            ?>
                       </div>
                       <a href="<?php the_permalink(); ?>"> <img src="https://ecomgiantz.com/wp-content/uploads/2025/04/Icon-wrap.png" alt="icon"> </a>

                    </div>
                    <h3 class="ecom-blog-post-titel"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
                    <div class="ecom-blog-meta">
                        <div class="ecom-blog-date">
                           <?php echo get_the_date('F j'); ?>
                        </div>
                        <div class="ecom-blog-author">
                            <?php echo get_the_author(); ?>
                        </div>
                    </div>
                </div>
           
            
                
            </div>

            <?php
        }

        echo '</div>'; 
    } else {
        echo '<p class="no-case-study">No posts found in this category.</p>';
    }

    wp_reset_postdata();
    die();
}
add_action('wp_ajax_load_blog_posts', 'load_blog_posts_ajax');
add_action('wp_ajax_nopriv_load_blog_posts', 'load_blog_posts_ajax');