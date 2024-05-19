<?php

// Create a settings page in the admin panel
function fshb_create_admin_page() {
    add_menu_page(
        __('Free Shipping Bar Settings', 'lime-free-shipping-bar'),
        __('Free Shipping Bar', 'lime-free-shipping-bar'),
        'manage_options',
        'fshb-settings',
        'fshb_settings_page_html',
        'dashicons-admin-generic',
        20
    );
}
add_action('admin_menu', 'fshb_create_admin_page');

// HTML code for the settings page
function fshb_settings_page_html() {
    if (!current_user_can('manage_options')) {
        return;
    }

    // Getting all active languages
    $languages = function_exists('pll_languages_list') ? pll_languages_list(array('fields' => 'slug')) : array('en');

    // Saving settings for each language
    if (isset($_POST['fshb_settings'])) {
        update_option('fshb_threshold', sanitize_text_field($_POST['fshb_threshold']));
        update_option('fshb_bar_background_color', sanitize_hex_color($_POST['fshb_bar_background_color']));
        update_option('fshb_text_color', sanitize_hex_color($_POST['fshb_text_color']));
        update_option('fshb_amount_color', sanitize_hex_color($_POST['fshb_amount_color']));
        update_option('fshb_progress_bar_color', sanitize_hex_color($_POST['fshb_progress_bar_color']));
        update_option('fshb_progress_bar_background_color', sanitize_hex_color($_POST['fshb_progress_bar_background_color']));
        
        foreach ($languages as $lang) {
            update_option("fshb_currency_{$lang}", sanitize_text_field($_POST["fshb_currency_{$lang}"]));
            update_option("fshb_free_shipping_for_orders_over_{$lang}", sanitize_textarea_field($_POST["fshb_free_shipping_for_orders_over_{$lang}"]));
            update_option("fshb_free_shipping_message_{$lang}", sanitize_textarea_field($_POST["fshb_free_shipping_message_{$lang}"]));
            update_option("fshb_insufficient_amount_message_{$lang}", sanitize_textarea_field($_POST["fshb_insufficient_amount_message_{$lang}"]));
        }

        // Clearing the WP Rocket cache
        if (function_exists('rocket_clean_domain')) {
            rocket_clean_domain();
        }

        echo '<div class="updated"><p>' . __('Settings saved', 'lime-free-shipping-bar') . '</p></div>';
    }

    if (isset($_POST['fshb_reset_settings'])) {
        delete_option('fshb_threshold');
        delete_option('fshb_bar_background_color');
        delete_option('fshb_text_color');
        delete_option('fshb_amount_color');
        delete_option('fshb_progress_bar_color');
        delete_option('fshb_progress_bar_background_color');
        
        foreach ($languages as $lang) {
            delete_option("fshb_currency_{$lang}");
            delete_option("fshb_free_shipping_for_orders_over_{$lang}");
            delete_option("fshb_free_shipping_message_{$lang}");
            delete_option("fshb_insufficient_amount_message_{$lang}");
        }

        // Clearing the WP Rocket cache
        if (function_exists('rocket_clean_domain')) {
            rocket_clean_domain();
        }

        echo '<div class="updated"><p>' . __('Settings reset to defaults', 'lime-free-shipping-bar') . '</p></div>';
    }

    $threshold = get_option('fshb_threshold', '500');
    $bar_background_color = get_option('fshb_bar_background_color', '#f2f2f2');
    $text_color = get_option('fshb_text_color', '#4caf50');
    $amount_color = get_option('fshb_amount_color', '#ff0000');
    $progress_bar_color = get_option('fshb_progress_bar_color', '#4caf50');
    $progress_bar_background_color = get_option('fshb_progress_bar_background_color', '#ddd');
    
    ?>

    <div class="wrap">
        <h1><?php _e('Free Shipping Bar Settings', 'lime-free-shipping-bar'); ?></h1>
        <form method="POST" action="">
            <table class="form-table">
                <tr valign="top">
                    <th scope="row"><?php _e('Free Shipping Threshold', 'lime-free-shipping-bar'); ?></th>
                    <td><input type="number" name="fshb_threshold" value="<?php echo esc_attr($threshold); ?>" /></td>
                </tr>
                <?php foreach ($languages as $lang): ?>
                    <tr valign="top">
                        <th scope="row"><?php echo sprintf(__('Free Shipping Currency (%s)', 'lime-free-shipping-bar'), $lang); ?></th>
                        <td><input type="text" name="fshb_currency_<?php echo $lang; ?>" value="<?php echo esc_attr(get_option("fshb_currency_{$lang}", __('UAH', 'lime-free-shipping-bar'))); ?>" /></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo sprintf(__('Free Shipping for Orders Over Message (%s)', 'lime-free-shipping-bar'), $lang); ?></th>
                        <td><textarea name="fshb_free_shipping_for_orders_over_<?php echo $lang; ?>" rows="2" cols="50"><?php echo esc_textarea(get_option("fshb_free_shipping_for_orders_over_{$lang}", __('Free shipping for orders over {amount}', 'lime-free-shipping-bar'))); ?></textarea></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo sprintf(__('Free Shipping Message (%s)', 'lime-free-shipping-bar'), $lang); ?></th>
                        <td><textarea name="fshb_free_shipping_message_<?php echo $lang; ?>" rows="4" cols="50"><?php echo esc_textarea(get_option("fshb_free_shipping_message_{$lang}", __('Congratulations, you get free shipping!', 'lime-free-shipping-bar'))); ?></textarea></td>
                    </tr>
                    <tr valign="top">
                        <th scope="row"><?php echo sprintf(__('Insufficient Amount Message (%s)', 'lime-free-shipping-bar'), $lang); ?></th>
                        <td>
                            <textarea name="fshb_insufficient_amount_message_<?php echo $lang; ?>" rows="4" cols="50" placeholder="<?php _e('Use {amount} to indicate the remaining amount.', 'lime-free-shipping-bar'); ?>"><?php echo esc_textarea(get_option("fshb_insufficient_amount_message_{$lang}", __('{amount} to get free shipping', 'lime-free-shipping-bar'))); ?></textarea>
                            <p class="description"><?php _e('Use {amount} to indicate the remaining amount.', 'lime-free-shipping-bar'); ?></p>
                        </td>
                    </tr>
                <?php endforeach; ?>
                <tr valign="top">
                    <th scope="row"><?php _e('Bar Background Color', 'lime-free-shipping-bar'); ?></th>
                    <td><input type="text" name="fshb_bar_background_color" value="<?php echo esc_attr($bar_background_color); ?>" class="fshb-color-field" data-default-color="#f2f2f2" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Text Color', 'lime-free-shipping-bar'); ?></th>
                    <td><input type="text" name="fshb_text_color" value="<?php echo esc_attr($text_color); ?>" class="fshb-color-field" data-default-color="#4caf50" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Amount Color', 'lime-free-shipping-bar'); ?></th>
                    <td><input type="text" name="fshb_amount_color" value="<?php echo esc_attr($amount_color); ?>" class="fshb-color-field" data-default-color="#ff0000" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Progress Bar Color', 'lime-free-shipping-bar'); ?></th>
                    <td><input type="text" name="fshb_progress_bar_color" value="<?php echo esc_attr($progress_bar_color); ?>" class="fshb-color-field" data-default-color="#4caf50" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row"><?php _e('Progress Bar Background Color', 'lime-free-shipping-bar'); ?></th>
                    <td><input type="text" name="fshb_progress_bar_background_color" value="<?php echo esc_attr($progress_bar_background_color); ?>" class="fshb-color-field" data-default-color="#ddd" /></td>
                </tr>
            </table>
            <input type="hidden" name="fshb_settings" value="1">
            <?php submit_button(__('Save Settings', 'lime-free-shipping-bar')); ?>
        </form>
        <form method="POST" action="" style="margin-top: 20px;">
            <input type="hidden" name="fshb_reset_settings" value="1">
            <?php submit_button(__('Reset Settings to Default', 'lime-free-shipping-bar'), 'delete'); ?>
        </form>
    </div>
    <?php
}
