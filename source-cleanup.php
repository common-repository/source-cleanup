<?php
/*
Plugin Name: Source Cleanup
Plugin URI: http://www.srikanth.me
Description: This plugin removes WP version and shortlink from WP head and, moves javascript files to the footer for better performance.
Version: 0.1
Author: Srikanth AD
Author URI: http://www.srikanth.me
*/

// Remove WP version meta tag and from RSS feed
function remove_wp_ver_meta_rss() {
    return '';
}
add_filter( 'the_generator', 'remove_wp_ver_meta_rss' );

// Remove WP version parameter from any enqueued scripts
function remove_wp_ver_css_js( $src ) {
    if ( strpos( $src, 'ver=' ) )
        $src = remove_query_arg( 'ver', $src );
    return $src;
}
add_filter( 'style_loader_src', 'remove_wp_ver_css_js');
add_filter( 'script_loader_src', 'remove_wp_ver_css_js');

// Remove WP shortlink from WP head
remove_action( 'wp_head', 'wp_shortlink_wp_head');

// Move javascript to footer - for better performance and load time
remove_action('wp_head', 'wp_print_scripts');
remove_action('wp_head', 'wp_print_head_scripts', 9);
remove_action('wp_head', 'wp_enqueue_scripts', 1);
add_action('wp_footer', 'wp_print_scripts', 3);
add_action('wp_footer', 'wp_enqueue_scripts', 3);
add_action('wp_footer', 'wp_print_head_scripts', 3);