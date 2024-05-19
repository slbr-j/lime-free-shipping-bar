<?php
/*
Plugin Name: Lime Free Shipping Bar
Description: Displays a top bar with a progress bar for free shipping in WooCommerce. Glory to Ukraine!
Version: 1.2
Author: @slbr-j | Lime:Studio
Text Domain: lime-free-shipping-bar
Domain Path: /languages
Requires at least: 5.0
Requires PHP: 7.4
*/

// Connecting the required files
include_once plugin_dir_path(__FILE__) . 'includes/ajax-functions.php';
include_once plugin_dir_path(__FILE__) . 'includes/helpers.php'; 
include_once plugin_dir_path(__FILE__) . 'includes/admin-page.php';

// Connecting styles and scripts
function fshb_enqueue_assets() {
    wp_enqueue_style('fshb-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
    wp_enqueue_script('fshb-script', plugin_dir_url(__FILE__) . 'assets/js/fshb-script.js', array('jquery'), null, true);
    wp_localize_script('fshb-script', 'fshb_params', array(
        'ajax_url' => admin_url('admin-ajax.php'),
        'nonce'    => wp_create_nonce('fshb_nonce'),
        'lang'     => function_exists('pll_current_language') ? pll_current_language() : 'en'
    ));
}
add_action('wp_enqueue_scripts', 'fshb_enqueue_assets');

// Connecting colour picker scripts and styles
function fshb_enqueue_color_picker($hook_suffix) {
    // Checking if we are on the correct plugin settings page
    if ('toplevel_page_fshb-settings' !== $hook_suffix) {
        return;
    }
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('fshb-color-picker', plugin_dir_url(__FILE__) . 'assets/js/color-picker.js', array('wp-color-picker'), false, true);
}
add_action('admin_enqueue_scripts', 'fshb_enqueue_color_picker');

// Uploading a text domain for translation
function fshb_load_textdomain() {
    load_plugin_textdomain('lime-free-shipping-bar', false, dirname(plugin_basename(__FILE__)) . '/languages');
}
add_action('plugins_loaded', 'fshb_load_textdomain');

// Register settings for multilingualism
function fshb_register_strings() {
    if (function_exists('pll_register_string')) {
        pll_register_string('Free Shipping Message', get_option('fshb_free_shipping_message'), 'lime-free-shipping-bar');
        pll_register_string('Insufficient Amount Message', get_option('fshb_insufficient_amount_message'), 'lime-free-shipping-bar');
    }
}
add_action('admin_init', 'fshb_register_strings');

// Add a link to the settings page in the plugin list
function fshb_settings_link($links) {
    $settings_link = '<a href="admin.php?page=fshb-settings">' . __('Settings', 'lime-free-shipping-bar') . '</a>';
    array_unshift($links, $settings_link);
    return $links;
}
add_filter('plugin_action_links_' . plugin_basename(__FILE__), 'fshb_settings_link');

// Adding a top bar
function fshb_display_bar() {
    if (is_cart() || is_checkout()) return;
    include plugin_dir_path(__FILE__) . 'templates/free-shipping-bar.php';
}
add_action('wp_footer', 'fshb_display_bar');

// Clearing the WP Rocket cache
function fshb_clear_cache() {
    if (function_exists('rocket_clean_domain')) {
        rocket_clean_domain();
    }
}
add_action('update_option_fshb_threshold', 'fshb_clear_cache');
add_action('update_option_fshb_currency', 'fshb_clear_cache');
add_action('update_option_fshb_free_shipping_message', 'fshb_clear_cache');
add_action('update_option_fshb_insufficient_amount_message', 'fshb_clear_cache');
add_action('update_option_fshb_bar_background_color', 'fshb_clear_cache');
add_action('update_option_fshb_text_color', 'fshb_clear_cache');
add_action('update_option_fshb_amount_color', 'fshb_clear_cache');
add_action('update_option_fshb_progress_bar_color', 'fshb_clear_cache');
add_action('update_option_fshb_progress_bar_background_color', 'fshb_clear_cache');
?>