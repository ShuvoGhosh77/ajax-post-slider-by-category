# AJAX Category Post slick Slider for WordPress

A custom WordPress code that allows users to load posts by category using AJAX and display them in a Slick Slider. When a user clicks on a category button, related posts are fetched without a page reload and shown in a carousel slider.

## 🎯 Features

- Fetch posts dynamically via AJAX
- Filter posts by category with clickable buttons or links
- Slick Slider integration for smooth carousel display
- Lightweight and responsive
- Easy to use with shortcode
- Works with any theme

## 📦 Installation

1. Download or clone this repository into your WordPress function.php and js file

## 🔧 Shortcode Usage
[ajax_category_post_slider]

## 🔧 Slick Enqueue
1. Add function.php
function enqueue_child_theme_assets(){
    wp_enqueue_script("jquery");
    wp_enqueue_script("slick-slider-js", "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.js", ["jquery"], null, true);
    wp_enqueue_style("slick-slider-css", "https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.9.0/slick.min.css", [], null);
    $custom_js_path = get_stylesheet_directory() . "/custom.js";
    wp_enqueue_script(
        "child-custom-js",
        get_stylesheet_directory_uri() . "/custom.js",
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
