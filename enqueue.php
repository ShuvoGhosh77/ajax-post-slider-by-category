<?php 

function enqueue_child_theme_assets()
{
    wp_enqueue_script("jquery");

    wp_enqueue_script(
        "slick-slider-js",
        "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js",
        ["jquery"],
        null, 
        true
    );

    wp_enqueue_style(
        "slick-slider-css",
        "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css",
        [],
        null
    );

    $custom_js_path = get_stylesheet_directory() . "/custom.js";wp_enqueue_script("child-custom-js",get_stylesheet_directory_uri() . "/custom.js",
        ["jquery", "slick-slider-js", "swiper-slider"],
        filemtime($custom_js_path),
        true
    );
	 // Localize script for AJAX
    wp_localize_script('child-custom-js', 'ajax_object', array(
        'ajax_url' => admin_url('admin-ajax.php')
    ));
}
add_action("wp_enqueue_scripts", "enqueue_child_theme_assets");