<?php
// Prevent direct script access
if ( !defined( 'ABSPATH' ) )
	die ( 'No direct script access allowed' );

/**
* 3clicks Child Theme Setup
* 
* Always use child theme if you want to make some custom modifications. 
* This way theme updates will be a lot easier.
*/
function g1_childtheme_setup() {
}

add_action( 'after_setup_theme', 'g1_childtheme_setup' );

/** Tooltip **/
add_action('wp_enqueue_scripts', 'your_function_name');
function your_function_name() {
    // Enqueue the style
    wp_enqueue_style('tooltip-script',  get_stylesheet_directory_uri() . '/css/tooltipster.css');
    // Enqueue the script
    wp_enqueue_script('tooltip-script',  get_stylesheet_directory_uri() . '/js/jquery.tooltipster.min.js');
}
/** Validation **/
add_action('wp_enqueue_scripts', 'validation');
function validation() {
    // Enqueue the style
    wp_enqueue_style('validation-script',  get_stylesheet_directory_uri() . '/css/validationEngine.jquery.css');
    // Enqueue the script
    wp_enqueue_script('validation-script',  get_stylesheet_directory_uri() . '/js/jquery.validationEngine-de.js');
    wp_enqueue_script('validation_locale',  get_stylesheet_directory_uri() . '/js/jquery.validationEngine.js');
}
/** Brands Slider **/
add_action('wp_enqueue_scripts', 'brands');
function brands() {
    // Enqueue the style
    wp_enqueue_style('brands-script',  get_stylesheet_directory_uri() . '/css/brandsbox.css');
    // Enqueue the script
    wp_enqueue_script('brands-script',  get_stylesheet_directory_uri() . '/js/brandsbox.min.js');
}
/** Preis-Slider **/
function add_jquery_ui() {
    wp_enqueue_script( 'jquery-ui-slider' );
// Enqueue the style
    wp_enqueue_style('slider-script',  get_stylesheet_directory_uri() . '/css/slider.css');
}
add_action( 'wp_enqueue_scripts', 'add_jquery_ui' );
    
    
    
