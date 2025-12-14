<?php
function india_day_trip_theme_setup()
{
    // Add theme support
    add_theme_support('post-thumbnails');
    add_theme_support('title-tag');
    add_theme_support('custom-logo');
    add_theme_support('menus');

    // Register menus
    register_nav_menus(array(
        'primary' => __('Primary Menu', 'india-day-trip'),
    ));
}
add_action('after_setup_theme', 'india_day_trip_theme_setup');

function india_day_trip_enqueue_scripts()
{
    // Enqueue styles
    wp_enqueue_style('bootstrap', get_template_directory_uri() . '/assets/css/bootstrap.min.css', array(), '5.3.0');
    wp_enqueue_style('fontawesome', get_template_directory_uri() . '/assets/css/fontawesome.min.css', array(), '6.4.0');
    wp_enqueue_style('magnific-popup', get_template_directory_uri() . '/assets/css/magnific-popup.min.css', array(), '1.1.0');
    wp_enqueue_style('swiper', get_template_directory_uri() . '/assets/css/swiper-bundle.min.css', array(), '8.4.7');
    wp_enqueue_style('main-style', get_template_directory_uri() . '/assets/css/style.css', array(), '1.0.0');
    wp_enqueue_style('theme-style', get_stylesheet_uri(), array(), '1.0.0');

    // Enqueue scripts
    wp_enqueue_script('jquery');
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/assets/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);
    wp_enqueue_script('magnific-popup-js', get_template_directory_uri() . '/assets/js/jquery.magnific-popup.min.js', array('jquery'), '1.1.0', true);
    wp_enqueue_script('swiper-js', get_template_directory_uri() . '/assets/js/swiper-bundle.min.js', array('jquery'), '8.4.7', true);
    wp_enqueue_script('main-js', get_template_directory_uri() . '/assets/js/main.js', array('jquery'), '1.0.0', true);
}
add_action('wp_enqueue_scripts', 'india_day_trip_enqueue_scripts');

// Custom post type for tours
function create_tour_post_type()
{
    register_post_type(
        'tour',
        array(
            'labels' => array(
                'name' => __('Tours'),
                'singular_name' => __('Tour')
            ),
            'public' => true,
            'has_archive' => true,
            'supports' => array('title', 'editor', 'thumbnail', 'excerpt'),
            'menu_icon' => 'dashicons-location-alt',
        )
    );
}



add_action('init', 'create_tour_post_type');
