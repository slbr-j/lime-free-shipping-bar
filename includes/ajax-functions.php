<?php

function fshb_update_free_shipping_bar() {
    // Nonce verification to protect against CSRF attacks
    check_ajax_referer('fshb_nonce', 'nonce');

    // Getting the language from an AJAX request
    $lang = isset($_POST['lang']) ? sanitize_text_field($_POST['lang']) : 'en';

    // Get the HTML content of the bar for the specified languagev
    $html = fshb_get_free_shipping_bar_content($lang);

    // Returning a JSON response with HTML content
    wp_send_json_success([
        'html' => $html
    ]);
}

add_action('wp_ajax_fshb_update_free_shipping_bar', 'fshb_update_free_shipping_bar');
add_action('wp_ajax_nopriv_fshb_update_free_shipping_bar', 'fshb_update_free_shipping_bar');
?>
