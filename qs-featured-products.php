<?php
/*
Plugin Name: Quiero Spain featured products slider
Plugin URI: https://novadevs.com/
Description: Plugin para mmostrar los productos destacados del comercio sobre un slider en la home
Version: 1.0.0-rc
Author: Bruno Lorente
Author URI: https://github.com/brunolorente
License: GPLv2 or later
Text Domain: novadevs
*/

if (!defined('QS_FP')) {
    define('QS_FP', plugin_dir_path(__FILE__));
}

// Including admin page file
require_once(QS_FP . '/activation.php');
// require_once( QS_FP . '/uninstall.php' );
require_once(QS_FP . 'includes/shortcode.php');


/**
 * Check if WooCommerce is activated
 */
if (! function_exists('is_woocommerce_activated')) {
    function is_woocommerce_activated()
    {
        if (class_exists('woocommerce')) {
            return true;
        } else {
            return false;
        }
    }
}


if (! function_exists('qs_fp_styles')) {
    function qs_fp_styles()
    {
        wp_register_style('bootstrap-css', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css');
        wp_enqueue_style('bootstrap-css');
        wp_enqueue_style('qs_fp_css', plugin_dir_url(__FILE__) . 'css/main.css');
    }
}
add_action('wp_enqueue_scripts', 'qs_fp_styles');


if (! function_exists('qs_fp_scripts')) {
    function qs_fp_scripts()
    {
        // Bootstrap 4 JS
        wp_deregister_script('bootstrap-js');
        wp_register_script('bootstrap-js', 'https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js', array('jquery'), null, true);
        wp_enqueue_script('bootstrap-js');

        // Own scripts
        wp_deregister_script('qs_fp_scripts');
        wp_enqueue_script('qs_fp_scripts', plugin_dir_url(__FILE__) . 'scripts/main.js', array('jquery'), null, true);
    }
}
add_action('wp_enqueue_scripts', 'qs_fp_scripts');


// Get featured products of WooCommerce
if (! function_exists('get_qs_fp_products')) {
    function get_qs_fp_products()
    {
        $featured_products = array();
        // The tax query
        $tax_query[] = array(
            'taxonomy' => 'product_visibility',
            'field'    => 'name',
            'terms'    => 'featured',
            'operator' => 'IN', // or 'NOT IN' to exclude feature products
        );

        // The query
        $query = new WP_Query(array(
            'post_type'           => 'product',
            'post_status'         => 'publish',
            'ignore_sticky_posts' => 1,
            'posts_per_page'      => $products,
            'orderby'             => $orderby,
            'order'               => $order == 'asc' ? 'asc' : 'desc',
            'tax_query'           => $tax_query // <===
        ));

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();
                $product = wc_get_product($query->post->ID);
                array_push($featured_products, $product);
            }
            
            wp_reset_query();
        }

        return $featured_products;
    }


    function random_color_part()
    {
        return str_pad(dechex(mt_rand(0, 255)), 2, '0', STR_PAD_LEFT);
    }
    
    function random_color()
    {
        return random_color_part() . random_color_part() . random_color_part();
    }
}
